<?php

namespace App\Http\Controllers\Dashboard;

use Auth;
use Storage;
use App\Models\Car;
use App\Models\Tag;
use App\Models\City;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Feature;
use App\Models\Vendor;
use App\Models\CarImage;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\Possibility;
use Illuminate\Http\Request;
use App\Rules\NotNumbersOnly;
use App\Rules\ValidateMaxImages;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;

use App\Models\CarColorImage;

use Exception;

use function PHPUnit\Framework\isEmpty;
use Illuminate\Database\Eloquent\Model;
use function App\Http\Controllers\store;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_cars');

        if ($request->ajax())
        {

            $cars = getModelData(model: new Car(), relations: ['brand' => ['id', 'name_' . getLocale()]]);

            return response()->json($cars);
        }
        return view('dashboard.cars.index');
    }

    public function create()
    {
        $this->authorize('create_cars');
        $models        = CarModel::select('id', 'name_' . getLocale())->get();
        $brands        = Brand::select('id', 'name_' . getLocale())->get();
        $cities        = City::select('id', 'name_' . getLocale())->get();
        $categories    = Category::select('id', 'name_' . getLocale())->get();
        $colors        = Color::select('id', 'image', 'name_' . getLocale(), 'hex_code')->get();
        $tags          = Tag::select('id', 'name_' . getLocale())->get();
        // $possibilities = Possibility::select('id', 'title_' . getLocale())->get();
        $features      = Feature::select('id', 'title_' . getLocale())->get();
        return view('dashboard.cars.create', compact('features', 'brands', 'colors', 'cities', 'tags', 'models', 'categories'));

    }

    public function edit(Car $car)
    {

        $this->authorize('update_cars');

        $models        = CarModel::select('id', 'name_' . getLocale())->where('brand_id', $car->brand_id)->get();
        $brands        = Brand::select('id', 'name_' . getLocale())->get();
        $cities        = City::select('id', 'name_' . getLocale())->get();
        $categories    = Category::select('id', 'name_' . getLocale())->where('car_model_id', $car->model_id)->get();
        $colors        = Color::select('id', 'image', 'name_' . getLocale(), 'hex_code')->get();
        $relatedImages = $car->images;
        $tags          = Tag::select('id', 'name_' . getLocale())->get();
        $carvideoId    = $car->video_url;
        $this->getYoutubeVideoUrl($carvideoId);
        $fullYoutubeUrl = ($carvideoId) ? $this->getYoutubeVideoUrl($carvideoId) : null;
        $car->load('colors');

        $colorsWithUniqueImages = $car->colors->groupBy('id')->map(function ($colors) {
            return [
                'color_id' => $colors->first()->id,
                'color_name' => $colors->first()->name,
                'hex_code' => $colors->first()->hex_code,
                'images' => $colors->unique('pivot.image')->pluck('pivot.image')->toArray(),
            ];
        })->values()->toArray();
        $selectedtagsIds    = $car->tags->pluck('id')->toArray();
        return view('dashboard.cars.edit', compact( 'colors','brands', 'car', 'models', 'cities', 'categories', 'relatedImages', 'tags', 'selectedtagsIds', 'fullYoutubeUrl', 'colorsWithUniqueImages'));
    }

  

    public function validateStep(Request $request, Car $car = null)
    {
        
        $discountPrice = $request['discount_price'] ?? 0;
        $price = $request['price'] ?? 0;
        
        // Check if we're updating an existing car and if it has existing images
        
        $existingColorImages = $car ? $car->colors->pluck('pivot.image')->count() : 0;
        // Conditionally require images only if there are no existing ones
    
        $existingCarImage= $car ? $car->images()->count():0;
        
    
    
        $colorImagesRequired = $existingColorImages === 0;
        $carImageRequired=$existingCarImage===0;
        
    
        // Define validation rules with conditional requirement for images
        
        $rules = [
            'brand_id' => ['required'],
            'model_id' => ['required'],
            'description_ar' => ['required', 'string', new NotNumbersOnly()],
            'description_en' => ['required', 'string', new NotNumbersOnly()],
            'category_id' => ['nullable'],
            'name_ar' => ['required', 'string', 'max:255', new NotNumbersOnly()],
            'name_en' => ['required', 'string', 'max:255', new NotNumbersOnly()],
            'year' => ['required'],
            'fuel_type' => ['required'],
            'publish' => ['required'],
            'gear_shifter' => ['required'],
            'video_url' => ['nullable', 'string', 'url'],
            'price' => 'required|numeric|lte:2147483647|not_in:0|gt:' . $discountPrice,
            'discount_price' => 'required_with:have_discount|nullable|numeric|not_in:0|lt:' . $price,
            'supplier' => ['required', 'in:gulf,saudi'],
            'is_new' => ['required'],
            'show_in_home_page' => ['required', 'in:0,1'],
            'kilometers' => ['required_if:is_new,0', 'numeric', 'nullable', 'min:0'],
            'colors' => [$colorImagesRequired ? 'required' : 'nullable', 'array', 'min:1'],
            'colors.*.id' => [$colorImagesRequired ? 'required' : 'nullable', 'integer', 'exists:colors,id'],
            'colors.*.images' => [$colorImagesRequired ? 'required' : 'nullable', 'array', 'min:1'],
            'colors.*.images.*' => ['file', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'city_id' => ['required'],
            'fuel_tank_capacity' => 'required|string|max:255',
            'car_body' => 'required|string',
            'tags.*' => 'nullable',
            'features' => ['sometimes', 'array'],
            'features.*.type' => ['required', 'exists:features,id'],
            'features.*.id' => ['required', 'exists:features,id'],
            'features.*.description_ar' => ['required', 'string', new NotNumbersOnly()],
            'features.*.description_en' => ['required', 'string', new NotNumbersOnly()],
            'car_Image' => [$carImageRequired?'required':'nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
        
        ];

        // Perform validation
        $request->validate($rules);
    
        
        // Handle store or update based on whether a Car model is provided
        if ($car) {
        
            if (!$request['is_duplicate']) {
                $request['is_duplicate'] = 0;
            
                return $this->update($request, $car); // Call update function
            } else {
                
                return $this->store($request); // Call store function with modified data
            
            }
        } else {
            // Call store function for a new car
            return $this->store($request);

        }
    }


    public function store(Request $request)
    {
       
        $this->authorize('create_cars');
      
       
        $features = $request->features ?? [];
        $filteredFeatures= collect($features)->map(function($feature) {
            return [
                'feature_id' => $feature['id'] ?? null, 
                'description_ar' => $feature['description_ar'] ?? null,
                'description_en' => $feature['description_en'] ?? null,
            ];
            
        })->toArray();

        $data                  = $request->except('car_Image', 'deleted_images', 'car_id', 'tags', 'colors', 'features');
        $data['have_discount'] = $request['have_discount'] === "on";
        
        $car = Car::create($data);
        if ($request->hasFile('car_Image')) {
            $image = uploadImage($request->file('car_Image'),"Cars");
                CarImage::create([
                    'car_id' => $car->id,
                    'image' => $image,
                ]);
                $car->main_image = $image??null;
                $car->save();
        }
        
         // Handle color-specific images
         // Handle color-specific images
        
        if ($request->has('colors')) {
            foreach ($request->input('colors') as $index => $color) {
                $colorId = $color['id'];
                if ($request->hasFile("colors.$index.images")) {
                    $colorImages = $this->uploadCarImages($request->file("colors.$index.images"));
                    foreach ($colorImages as $image) {
                        $car->colors()->attach($colorId, ['image' => $image]);
                    }
                }
            }
        }
        
        $data['video_url'] = $this->getYoutubeVideoId($request['video_url']);
        $this->storeBrandCarsTypeCount($data['is_new'], $data['brand_id']);
        $car->tags()->attach($request['tags'] ?? []);
        $car->features()->attach($filteredFeatures?? []);
        if ($request->is_duplicate )
        {
           
            $oldCar = Car::find($request->car_id);
            if ($oldCar) {
                $colorsWithUniqueImages = $oldCar->colors->groupBy('id')->map(function ($colors) {
                    return [
                        'color_id' => $colors->first()->id,
                        'color_name' => $colors->first()->name,
                        'hex_code' => $colors->first()->hex_code,
                        'images' => $colors->unique('pivot.image')->pluck('pivot.image')->toArray(),
                    ];
                })->values()->toArray();
    
                $this->duplicateColorsWithImages($colorsWithUniqueImages, $car->id);
                $this->handleDuplicateImage($request->car_id, $car);
            }
           
        }
    
    }

    /**
     * Handle duplication of the single image.
     */
    private function handleDuplicateImage($oldCarId, $newCar)
    {
        $oldCar = Car::find($oldCarId);
       
        if ($oldCar && $oldCar->images->isNotEmpty()) {
            $oldImage = $oldCar->images->first()->image;

            // Generate a new name for the duplicate image
            $extension = \File::extension($oldImage);
            $originalName = pathinfo($oldImage, PATHINFO_FILENAME);
            $newImageName = "webstdy_" . time() . "_{$originalName}_copy.{$extension}";

            // Copy the old image to a new file in the same directory
            $oldImagePath = storage_path("app/public/Images/Cars/{$oldImage}");
            $newImagePath = storage_path("app/public/Images/Cars/{$newImageName}");
            \File::copy($oldImagePath, $newImagePath);

            CarImage::create([
                'car_id' => $newCar->id,
                'image' => $newImageName,
            ]);

            // Update main image for the new car
            $newCar->main_image = $newImageName;
            $newCar->save();
            // $newCar->update(['main_image'=>$newImageName]);
        }
    }

    private function duplicateColorsWithImages($colorsWithUniqueImages, $newCarId)
    {
        foreach ($colorsWithUniqueImages as $colorData) {
            $colorId = $colorData['color_id'];
            $colorImages = $colorData['images'];

            foreach ($colorImages as $image) {
                // Create a new image name for duplication
                $extension = \File::extension($image);
                $originalName = pathinfo($image, PATHINFO_FILENAME);
                $newImageName = "{$newCarId}_" . time() . "_{$originalName}_copy.{$extension}";

                // Copy the old image to a new file
                $oldImagePath = storage_path("app/public/Images/Cars/{$image}");
                $newImagePath = storage_path("app/public/Images/Cars/{$newImageName}");
                \File::copy($oldImagePath, $newImagePath);

                // Attach the color with the new image to the new car
                CarColorImage::create([
                    'car_id' => $newCarId,
                    'color_id' => $colorId,
                    'image' => $newImageName,
                ]);
            }
        }
    }

  
    public function update(Request $request, Car $car)
{
    $this->authorize('update_cars');

    $data = $request->except('car_Images', 'deleted_images', 'features', 'car_id', 'tags', 'colors');
    $data['have_discount'] = $request['have_discount'] === "on";
    $data['is_duplicate'] = $request->input('is_duplicate', 0);
   
    // Process deleted images
    $deletedImages = json_decode($request->input('deleted_images', "[]"));
    if (!empty($deletedImages)) {
        foreach ($deletedImages as $imageName) {
            $carImage = CarImage::where('car_id', $car->id)->where('image', $imageName)->first();
            if ($carImage) {
                Storage::delete("Cars/{$imageName}");
                $carImage->delete();
            }

            CarColorImage::where('car_id', $car->id)
                ->where('image', $imageName)
                ->delete();
        }
    }
    // Handle color-specific images without syncing null values
    if ($request->has('colors')) {
        foreach ($request->input('colors') as $index => $colorData) {
            $colorId = $colorData['id'];


            if ($request->hasFile("colors.$index.images")) {
                $colorImages = $this->uploadCarImages($request->file("colors.$index.images"));

                foreach ($colorImages as $image) {
                    if ($image !== null) {
                        CarColorImage::updateOrCreate(
                            ['car_id' => $car->id, 'color_id' => $colorId, 'image' => $image],
                            ['updated_at' => now()]
                        );
                    }
                }
            }
        }
    }
   
    // Update main car data and relationships
    $car->update($data);
    $car->tags()->sync($request['tags'] ?? []);
    $car->features()->sync($this->prepareFeatures($request->features ?? []));

    // Set main image if there are images left
    $car->main_image = $car->images()->first()?->image;
    $car->save();

    // Update brand statistics
    $this->updateBrandCarsTypeCount(
        action: 'update',
        oldCarType: $car->is_new,
        currentBrandId: $car->brand_id,
        newCarType: $data['is_new']
    );
}

// Helper function to prepare features array for sync
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

    public function show(Car $car)
    {
      
        $car->load('color');
        $models             = CarModel::select('id', 'name_' . getLocale())->get();
        $brands             = Brand::select('id', 'name_' . getLocale())->get();
        $cities             = City::select('id', 'name_' . getLocale())->get();
        $categories         = Category::select('id', 'name_' . getLocale())->get();
        $tags               = Tag::select('id', 'name_' . getLocale())->get();
        $selectedtagsIds    = $car->tags->pluck('id')->toArray();
        $selectedcolorssIds = $car->color->pluck('id')->toArray();

        // $features            = Feature::select('id', 'title')->get();
        $selectedFeaturesIds = $car->features->pluck('id')->toArray();

        $colors = Color::select('id', 'image', 'name_' . getLocale(), 'hex_code')->get();

        $relatedImages = $car->images;
    
        return view('dashboard.cars.show', compact( 'brands', 'colors', 'car', 'models', 'cities', 'categories', 'relatedImages', 'tags', 'selectedtagsIds', 'selectedcolorssIds'));
    }
    // private  function cleanColorsArray($colors , $oldCarColorImages)
    // {
    //     return array_filter( $colors , fn ($color) => ( $color['inner_images'] ?? false ) || ( $color['outer_images'] ?? false ) || array_key_exists( $color['id'] ,$oldCarColorImages ));
    // }


    public function images(Car $car)
    {
        $carImages = $car->images->toArray();
        $images    = scandir(public_path('/storage/Images/Cars'));

        foreach ($carImages as $imageName)
        {
            $imageName = $imageName['image'];
            if (in_array($imageName, $images))
            {
                $image['image'] = $imageName;
                $filePath       = public_path("/storage/Images/Cars/$imageName");
                $image['size']  = filesize($filePath);
                $image['path']  = asset("/storage/Images/Cars/$imageName");
                $data[]         = $image;
            }
        }

        return response()->json($data);
    }
    private function setCarName(&$data)
    {
        $brand           = Brand::find($data['brand_id'], ['id', 'name_ar', 'name_en']);
        $model           = CarModel::find($data['model_id'], ['id', 'name_ar', 'name_en']);
        $data['name_ar'] = $brand->name_ar . ' ' . $model->name_ar . ' ' . $data['year'];
        $data['name_en'] = $brand->name_en . ' ' . $model->name_en . ' ' . $data['year'];
    }
    public function getModels($brandId)
    {
        $models = CarModel::where('brand_id', $brandId)->get();
        return response()->json($models);
    }

    public function getCategories($modelId)
    {
        $categories = Category::where('car_model_id', $modelId)->get();

        return response()->json($categories);
    }

    private function uploadCarImages($images)
    {
        
            $imagesNames = [];

            foreach ($images as $index => $image)
            {
                
                $imagesNames[$index] = uploadImage($image, "Cars");
            }
          
            return $imagesNames;
        
    }

    private function getPriceFieldValue($data): string
    {
        if (array_key_exists('discount_price', $data))
            $value = "<h6 class='price-before'> <span>" . $data['price'] . "</span> <span class='currency-value' ></span> </h6>
        <h6 class='price-now'> <span class='price-word' ></span>" . $data['discount_price'] . "<span class='currency-value' ></span> </h6>";
        else
            $value = "<h6 class='price-before'></h6>
        <h6 class='price-now'> <span class='price-word' > </span>" . $data['price'] . "<span class='currency-value' ></span> </h6>";

        return $value;

    }

    public function destroy(Request $request, Car $car)
    {
        $this->authorize('delete_cars');

        if ($request->ajax())
        {
            $car->delete();
            $this->updateBrandCarsTypeCount('deletion', $car->is_new, $car->brand_id);
        }

    }

    public function storeBrandCarsTypeCount($carType, $brandId)
    {
        $brand = Brand::find($brandId);

        if ($brand->car_available_types != 'both')
        {
            if ($carType == 1)
            {
                if ($brand->car_available_types != 'used')
                    $brand->update(['car_available_types' => 'new']);
                else
                    $brand->update(['car_available_types' => 'both']);
            } else
            {
                if ($brand->car_available_types != 'new')
                    $brand->update(['car_available_types' => 'used']);
                else
                    $brand->update(['car_available_types' => 'both']);
            }
        }

    }

    private function updateBrandCarsTypeCount($action, $oldCarType, $currentBrandId, $newBrandId = null, $newCarType = null)
    {
        $currentBrand              = Brand::find($currentBrandId);
        $currentBrandNewCarsCount  = $currentBrand->newCars->count();
        $currentBrandUsedCarsCount = $currentBrand->oldCars->count();

        if (!$newBrandId) // deletion and update carType only
        {
            if ($action == 'deletion')
            {
                if ($oldCarType == 1) // car is new
                {
                    if ($currentBrandNewCarsCount == 0) // delete last new car case
                    {
                        if ($currentBrand->car_available_types == 'both')
                            $currentBrand->update(['car_available_types' => 'used']);
                        else
                            $currentBrand->update(['car_available_types' => null]);
                    }
                } else // car is used
                {
                    if ($currentBrandUsedCarsCount == 0) // delete last used car case
                    {
                        if ($currentBrand->car_available_types == 'both')
                            $currentBrand->update(['car_available_types' => 'new']);
                        else
                            $currentBrand->update(['car_available_types' => null]);
                    }
                }
            } else
            {
                if ($oldCarType == 1 && $newCarType == 0) // change from new to used
                {
                    if ($currentBrandUsedCarsCount == 1)
                    {
                        if ($currentBrandNewCarsCount > 0)
                        {
                            if ($currentBrand->car_available_types == 'new')
                                $currentBrand->update(['car_available_types' => 'both']);
                        } else
                            $currentBrand->update(['car_available_types' => 'used']);
                    }
                } else if ($oldCarType == 0 && $newCarType == 1) // change from used to new
                {
                    if ($currentBrandNewCarsCount == 1)
                    {
                        if ($currentBrandUsedCarsCount > 0)
                        {
                            if ($currentBrand->car_available_types == 'used')
                                $currentBrand->update(['car_available_types' => 'both']);
                        } else
                            $currentBrand->update(['car_available_types' => 'new']);
                    }
                }
            }
        } else // update brand or brand and type
        {
            $newBrand              = Brand::find($newBrandId);
            $newBrandNewCarsCount  = $newBrand->newCars->count();
            $newBrandUsedCarsCount = $newBrand->oldCars->count();

            if ($oldCarType == 1 && $newCarType == 0) // change from new to used
            {
                // dd("new to used", $currentBrandNewCarsCount, $newBrandUsedCarsCount);
                if ($currentBrandNewCarsCount == 0)
                {
                    switch ($currentBrand->car_available_types)
                    {
                        case 'both':
                            $currentBrand->update(['car_available_types' => 'used']);
                            break;
                        case 'new':
                            $currentBrand->update(['car_available_types' => null]);
                            break;
                    }
                }

                if ($newBrandUsedCarsCount == 1)
                {
                    switch ($newBrand->car_available_types)
                    {
                        case 'new':
                            $newBrand->update(['car_available_types' => 'both']);
                            break;
                        case null:
                            $newBrand->update(['car_available_types' => 'used']);
                            break;
                    }
                }

            } else if ($oldCarType == 1 && $newCarType == 1) // change from new to new
            {
                // dd("new to new", $currentBrandNewCarsCount, $newBrandNewCarsCount);
                echo ("new to new " . $currentBrandNewCarsCount . $newBrandNewCarsCount);
                if ($currentBrandNewCarsCount == 0)
                {
                    switch ($currentBrand->car_available_types)
                    {
                        case 'both':
                            $currentBrand->update(['car_available_types' => 'used']);
                            break;
                        case 'new':
                            $currentBrand->update(['car_available_types' => null]);
                            break;
                    }
                }

                if ($newBrandNewCarsCount == 1)
                {
                    switch ($newBrand->car_available_types)
                    {
                        case 'used':
                            $newBrand->update(['car_available_types' => 'both']);
                            break;
                        case null:
                            $newBrand->update(['car_available_types' => 'new']);
                            break;
                    }
                }
            } else if ($oldCarType == 0 && $newCarType == 0) // change from used to used
            {
                // dd("used to used", $currentBrandUsedCarsCount, $newBrandUsedCarsCount);
                if ($currentBrandUsedCarsCount == 0)
                {
                    switch ($currentBrand->car_available_types)
                    {
                        case 'both':
                            $currentBrand->update(['car_available_types' => 'new']);
                            break;
                        case 'used':
                            $currentBrand->update(['car_available_types' => null]);
                            break;
                    }
                }

                if ($newBrandUsedCarsCount == 1)
                {
                    switch ($newBrand->car_available_types)
                    {
                        case 'new':
                            $newBrand->update(['car_available_types' => 'both']);
                            break;
                        case null:
                            $newBrand->update(['car_available_types' => 'used']);
                            break;
                    }
                }
            } else if ($oldCarType == 0 && $newCarType == 1) // change from used to new
            {
                // dd("used to new", $currentBrandUsedCarsCount, $newBrandNewCarsCount);
                if ($currentBrandUsedCarsCount == 0)
                {
                    switch ($currentBrand->car_available_types)
                    {
                        case 'both':
                            $currentBrand->update(['car_available_types' => 'new']);
                            break;
                        case 'used':
                            $currentBrand->update(['car_available_types' => null]);
                            break;
                    }
                }

                if ($newBrandNewCarsCount == 1)
                {
                    switch ($newBrand->car_available_types)
                    {
                        case 'used':
                            $newBrand->update(['car_available_types' => 'both']);
                            break;
                        case null:
                            $newBrand->update(['car_available_types' => 'new']);
                            break;
                    }
                }
            }
        }
    }

    function getYoutubeVideoId($url)
    {
        // Use a regular expression to extract the video ID from the YouTube URL
        $pattern = '/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';

        // Check if the URL matches the pattern
        if (preg_match($pattern, $url, $matches))
        {
            // Return the extracted video ID
            return $matches[1];
        }

        // Return null if no match is found
        return null;
    }
    protected function getYoutubeVideoUrl($videoId)
    {
        // Use a regular expression to extract the video ID from the YouTube URL
        $pattern = '/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        // Check if the URL matches the pattern

        // Return the full YouTube URL
        return 'https://www.youtube.com/watch?v=' . $videoId;


        // Return null if no match is found

    }

  

public function updateCarImages(Request $request, $carId)
{
    // Decode the arrays from the request
    $deletedImages = json_decode($request->input('deleted_images', "[]"));
    $updatedColorsImages = json_decode($request->input('updated_colors_images', "[]"), true);

    
    // Process deleted images
    if (!empty($deletedImages)) {
        foreach ($deletedImages as $imageName) {
            // Delete from storage
            
            if (Storage::exists("Cars/{$imageName->image}")) {
                Storage::delete("Cars/{$imageName->image}");
            }

            // Delete from database
            CarColorImage::where('car_id', $carId)
                         ->where('image', $imageName->image)
                         ->delete();
        }
    }

    // Process updated color images
    foreach ($updatedColorsImages as $colorId => $colorData) {
        $images = $colorData['images'] ?? [];
        
        // Sync images in the database for each color
        foreach ($images as $image) {
            CarColorImage::updateOrCreate(
                ['car_id' => $carId, 'color_id' => $colorId, 'image' => $image],
                ['updated_at' => now()]
            );
        }
    }

    return response()->json(['status' => 'success', 'message' => 'Images updated successfully']);
}

}
