<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Rules\NotNumbersOnly;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_services');

        if ($request->ajax())
        {
            $data = getModelData( model: new Service() );

            return response()->json($data);
        }

        return view('dashboard.services.index');
    }

    public function create()
    {
        $this->authorize('create_services');

        return view('dashboard.services.create');
    }


    public function edit(Service $service)
    {
        $this->authorize('update_services');

        return view('dashboard.services.edit',compact('service'));
    }


    public function show(Service $service)
    {
        $this->authorize('show_services');

        return view('dashboard.services.show',compact('service'));
    }

    public function store(Request $request)
    {
        $this->authorize('create_services');

        $data = $request->validate([
            'name_ar'           => 'required | string |  max:255 | unique:services',
            'name_en'           => 'required | string |  max:255 | unique:services',
            'title_ar'          => 'nullable | string |  max:255',
            'title_en'          => 'nullable | string |  max:255',
            'description_ar'    => 'required | string',
            'description_en'    => 'required | string',
            'image'             => 'required | mimes:webp|max:2048' ,
            'price'             => 'required | integer | not_in:0',
            'discount_price'    => 'nullable | integer | not_in:0',
            'features' => ['sometimes', 'array'],
            'features.*.type' => ['required', 'exists:features,id'],
            'features.*.id' => ['required', 'exists:features,id'],
            'features.*.description_ar' => ['required', 'string', new NotNumbersOnly()],
            'features.*.description_en' => ['required', 'string', new NotNumbersOnly()],
        ]);

        $features = $request->features ?? [];
       
        if ($request->file('image'))
            $data['image'] = uploadImage( $request->file('image') , "Services");
        unset($data['features']);
        $service=Service::create($data);
        $service->features()->attach($this->prepareFeatures($features));


    }

    public function update(Request $request , Service $service)
    {
        $this->authorize('update_services');

        $data = $request->validate([
            'name_ar'           => 'required | string |  max:255 | unique:services,id,' . $service->id,
            'name_en'           => 'required | string |  max:255 | unique:services,id,' . $service->id,
            'title_ar'          => 'nullable | string |  max:255',
            'title_en'          => 'nullable | string |  max:255',
            'description_ar'    => 'required | string',
            'description_en'    => 'required | string',
            'image'             => 'nullable | mimes:webp|max:2048' ,
            'price'             => 'required | integer | not_in:0',
            'discount_price'    => 'nullable | integer | not_in:0',
            'features' => ['sometimes', 'array'],
            'features.*.type' => ['required', 'exists:features,id'],
            'features.*.id' => ['required', 'exists:features,id'],
            'features.*.description_ar' => ['required', 'string', new NotNumbersOnly()],
            'features.*.description_en' => ['required', 'string', new NotNumbersOnly()],
        ]);

        $features = $request->features ?? [];
        if ($request->file('image'))
        {
            deleteImage( $service['image'] , "Services");
            $data['image'] = uploadImage( $request->file('image') , "Services");
        }
        unset($data['features']);
        $service->update($data);
        $service->features()->sync($this->prepareFeatures($features));
    }


    public function destroy(Request $request, Service $service)
    {
        $this->authorize('delete_services');

        if($request->ajax())
        {
            $service->delete();
        }
    }
    private function prepareFeatures($features)
    {
        return collect($features)->map(function ($feature) {
            return [
                'feature_id' => $feature['id'] ?? null,
                'description_ar' => $feature['description_ar'] ?? null,
                'description_en' => $feature['description_en'] ?? null,
            ];
        })->toArray();
    }
}
