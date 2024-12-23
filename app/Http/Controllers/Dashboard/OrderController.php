<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\OrderNotification;
use App\Models\Organizationactive;
use App\Models\OrganizationType;
use App\Models\SettingOrderStatus;
use App\Traits\NotificationTrait;
use Auth;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    use NotificationTrait;

    public function index(Request $request)
    {
         $this->authorize('view_orders');

        if ($request->ajax())
        {

            $user = Employee::find(Auth::user()->id);

            if ($user->roles->contains('id', 1))
            {
                $data = getModelData(model: new Order(), andsFilters: [['verified', '=', 1],['status_id', '!=', 7]], relations: ['employee' => ['id', 'name']]);
            } else
            {
                // User does not have role 1, return orders where employee_id is the user's ID
                $data = getModelData(model: new Order(), andsFilters: [['employee_id', '=', $user->id], ['verified', '=', 1],['status_id', '!=', 7]], relations: ['employee' => ['id', 'name']]);

            }
            return response()->json($data);
        }

        return view('dashboard.orders.index');
    }
    
     public function orders_not_approval(Request $request)
    {
         $this->authorize('view_orders');

        if ($request->ajax())
        {

            $user = Employee::find(Auth::user()->id);

            if ($user->roles->contains('id', 1))
            {
                $data = getModelData(model: new Order(), andsFilters: [['verified', '=', 1],['status_id', '=', 7]], relations: ['employee' => ['id', 'name']]);
            } else
            {
                // User does not have role 1, return orders where employee_id is the user's ID
                $data = getModelData(model: new Order(), andsFilters: [['employee_id', '=', $user->id], ['verified', '=', 1],['status_id', '=', 7]], relations: ['employee' => ['id', 'name']]);

            }
            return response()->json($data);
        }

        return view('dashboard.orders.orders_not_approval');
    }


    public function show(Order $order)
    {
        $precentage_approve = !$order['orderDetailsCar']['having_loan'] ? 45 : 65;
        $commitment         = $order['orderDetailsCar']['commitments'];
        $salary             = $order['orderDetailsCar']['salary'];
        if ($commitment > $salary)
        {
            $approve_amount = 0;
        } else
        {
            $approve_amount = ($salary - $commitment) * ($precentage_approve / 100);
        }

        $employees = Employee::select('id', 'name')->whereHas('roles.abilities', function ($query) {
            $query->where('name', 'received_order_received');
        })->get();

        $employee = Employee::find($order->employee_id) ?? null;

        $this->authorize('show_orders');

        $order->load('car', 'orderDetailsCar');
        $organization_activity = optional($order->orderDetailsCar)->organization_activity
            ? Organizationactive::find($order->orderDetailsCar->organization_activity)
            : null;
        $organization_type     = optional($order->orderDetailsCar)->organization_type
            ? OrganizationType::find($order->orderDetailsCar->organization_type)
            : null;
        if (!$order->opened_at)
        {

            try
            {

                $order->update([
                    "opened_at" => Carbon::now()->toDateTimeString(),
                    "opened_by" => auth()->id()
                ]);

            } catch (\Throwable $th)
            {
                return $th;
            }
        }

        return view('dashboard.orders.show', compact('order', 'organization_activity', 'organization_type', 'employees', 'employee', 'precentage_approve', 'approve_amount'));
    }



    public function destroy(Request $request, Order $order)
    {
        $this->authorize('delete_orders');

        if ($request->ajax())
        {
            $order->delete();
        }
    }

    public function changeStatus(Order $order, Request $request)
    {
        $notify = [
            'oldstatue' => $order->status_id,
        ];
        $request->validate(['status' => 'required']);
        // Get the combined value from the form submission
        $combinedValue = $request->input('status');

        // Split the combined value using the underscore (_) as a separator
        $parts = explode('_', $combinedValue);

        // Now $parts[0] contains the id and $parts[1] contains the name_en
        $id      = $parts[0];
        $name_en = $parts[1];
        DB::beginTransaction();
        
       if($order->orderDetailsCar->payment_type=="finance" && $id==2){
        $phone=$order->phone;
        $message = "ﻋزﯾزﻧﺎ اﻟﻌﻣﯾل ﺗم اﺳﺗﻼم طﻠب ﺗﻣوﯾﻠك رﻗم {$order->id} وﺳﯾﺗم اﻟﺗواﺻل ﻣﻌك ﺑﺄﺳرع وﻗت";
        $this->send_message($phone,$message);
       }
       
        if($order->orderDetailsCar->payment_type=="finance" && $id==3){
        $phone=$order->phone;
        $message = "ﻋزﯾزﻧﺎ اﻟﻌﻣﯾل ﯾﺳﻌدﻧﺎ اﺑﻼﻏك ﺑﺎﻟﻣواﻓﻘﺔ ﻋﻠﻰ طﻠب اﻟﺗﻣوﯾل اﻟﺧﺎص ﺑك رﻗم {$order->id} وﺳﯾﺗم اﻟﺗواﺻل ﻣﻌك ﺑﺄﺳرع وﻗت";
        $this->send_message($phone,$message);
       }
       
        if($order->orderDetailsCar->payment_type=="finance" && $id==4){
        $phone=$order->phone;
        $message = "ﻋزﯾزﻧﺎ اﻟﻌﻣﯾل ﻧﺎﺳف اﺑﻼﻏك اﻧﮫ ﺗم رﻓض طﻠب التﻣوﯾل اﻟﺧﺎص ﺑك رﻗم {$order->id} وﺳﯾﺗم اﻟﺗواﺻل ﻣﻌك ﺑﺄﺳرع وﻗت";
        $this->send_message($phone,$message);
       }
       
         if($order->orderDetailsCar->payment_type=="finance" && $id==7){
        $phone=$order->phone;
        $message = "ﻋزﯾزﻧﺎ اﻟﻌﻣﯾل ﯾﺳﻌدﻧﺎ اﺑﻼﻏك اﻧﮫ ﺗم ﺗﻌﻣﯾد طﻠب التﻣوﯾل اﻟﺧﺎص ﺑك رقم {$order->id} وﺳﯾﺗم اﻟﺗواﺻل ﻣﻌك ﺑﺄﺳرع وﻗت";
        $this->send_message($phone,$message);
       }
       
try
        {

            OrderHistory::create([
                // 'status' => $request['status'],
                'status' => $name_en,
                'comment' => $request['comment'],
                'employee_id' => auth()->id(),
                'order_id' => $order['id'],
            ]);


            $order->update(['status_id' => $id]);
            $notify += [
                'vendor_id' => null,
                'order_id' => $order->id,
                'is_read' => false,
                'phone' => $order->phone,
                'newstatue' => $id,
                'type' => 'orderstatue',
            ];

            OrderNotification::create($notify);

            DB::commit();

        } catch (\Exception $exception)
        {
            DB::rollBack();
        }
    }

    public function assignToEmployee(Order $order, Request $request)
    {

        $employee = Employee::find($request->employee_id);
        // Now you can access the abilities
        try
        {

            OrderHistory::create([
                // 'status' => $request['status'],
                'status' => $order->statue->name_en,
                'comment' => $request['comment'],
                'employee_id' => auth()->id(),
                'assign_to' => $employee->id,
                'order_id' => $order['id'],
            ]);

            $order->update(['employee_id' => $request->employee_id]);

            DB::commit();

        } catch (\Exception $exception)
        {
            DB::rollBack();
        }
        $this->newAssignOrderNotification($order);

    }
    
        
     function send_message($phone,$message)
        { 
        $apiUrl = "https://api.oursms.com/api-a/msgs";
        $token = "e4vHwxheBK6uujxk7G9I";
        $src = 'CODE CAR';
        $dests = "$phone";
        $appName = settings()->getSettings("website_name_" . getLocale()) ?? "SariCars";

        $body = <<<msg
        مرحبا بك في $appName ...
$message
msg;
                
        $response = \Illuminate\Support\Facades\Http::asForm()->post($apiUrl, [
            'token' => $token,
            'src' => $src,
            'dests' => $dests,
            'body' => $body,
        ]);

        

        if ($response->successful()) {
            // Request successful
            // echo "SMS sent successfully.";
        } else {
            // Request failed
            echo "Failed to send SMS. Error: " . $response->body();
        
        }
        }
}
