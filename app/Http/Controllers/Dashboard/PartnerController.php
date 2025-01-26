<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PartnerRequest;
use App\Models\Partner;
class PartnerController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('view_partners');

        if ($request->ajax())
        {

            $data = getModelData(model: new Partner());

            return response()->json($data);
        }

        return view('dashboard.partner.index');
    }

    public function create()
    {

        $this->authorize('create_partners');

        return view('dashboard.partner.create');
    }


    public function store(Request $request)
    {
        $this->authorize('create_partners');

        $data = $request->validate([
            'image' => 'required|image', // Add your image validation rules here
        ]);

        $data['image'] = uploadImage($request->file('image'), "Partners");

        Partner::create([
            'image' => $data['image'], // Assuming 'image' is the field name
        ]);

        return redirect()->back();
    }
    public function edit(Partner $partner)
    {
        $this->authorize('update_partners');
        return view('dashboard.partner.edit', compact('partner'));
    }

    public function show($id)
    {
        $this->authorize('show_partners');

        $partner = Partner::findOrFail($id);
        return view('dashboard.partner.show', compact('partner'));


    }

    public function destroy($id)
    {
        $this->authorize('delete_partners');
        $partner = Partner::findOrFail($id);
        deleteImage($partner->image,'Partners');
        $partner->delete();
        return view('dashboard.partner.index');


    }

    public function update(Request $request, Partner $partner)
    {
        $this->authorize('update_partners');

        $data = $request->validate([
            'image' => 'required|image', // Add your image validation rules here
        ]);

        $data['image'] = uploadImage($request->file('image'), "Partners");

        $partner->update([
            'image' => $data['image'] ? $data['image'] : $partner->image,
        ]);
        $partner->save();
        return redirect()->back();

    }



}

