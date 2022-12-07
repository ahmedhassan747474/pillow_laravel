<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Property;
use App\PropertyImage;
use App\PropertyAttribute;
use App\Country;
use App\City;
use App\Attribute;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use App\Transformers\Admin\PropertyTransformer;

class FurnishedApartmentController extends BaseController
{
    function __construct(PropertyTransformer $property_transformer)
    {
        $this->property_transformer = $property_transformer;

        $this->middleware(function ($request, $next) {
            checkPermission('is_furnished');
            return $next($request);
        });
    }

    public function index(Request $request, $type)
    {
        checkGate('can_show');
// dd(sssssssss);
        $search = $request->search??'';
        $apartments = Property::orderBy('id', 'desc');
        if($request->search){
            $apartments->where('name_en','like','%'.$request->search.'%')
                        ->orWhere('name_ar','like','%'.$request->search.'%')
                        ->orWhere('price','like','%'.$request->search.'%')
                        ->orWhere('payment_method','like','%'.$request->search.'%')
                        ->orWhere('description_ar','like','%'.$request->search.'%')
                        ->orWhere('description_en','like','%'.$request->search.'%')
                        ->orWhereHas('city',function($q) use($request){
                            $q->where('name_ar','like','%'.$request->search.'%');
                            $q->orWhere('name_en','like','%'.$request->search.'%');
                        })->orWhereHas('country',function($q) use($request){
                            $q->where('name_ar','like','%'.$request->search.'%');
                            $q->orWhere('name_en','like','%'.$request->search.'%');
                        });
        }
        if($type == -1 ){
//  dd('sssssssss');

            $apartments = $apartments->paginate(20);
            $data=$apartments;
            $apartments = $this->property_transformer->transformCollection($apartments->getCollection());
            // $data = $apartments->paginate(20);
        }else if($type == -2 ){
            $apartments = $apartments->where('is_popular','1')->paginate(20);
            $data=$apartments;

            $apartments = $this->property_transformer->transformCollection($apartments->getCollection());
            // $data = $apartments->where('is_popular','1')->orderBy('id', 'desc')->paginate(20);
        }else{
            $apartments = $apartments->whereType($type)->paginate(20);
            $data=$apartments;

            $apartments = $this->property_transformer->transformCollection($apartments->getCollection());

            // $data = $apartments->whereType($type)->paginate(20);
        }
// return [$apartments];
// dd($apartments);

        return view('admin.apartment.index', compact('apartments', 'data','type','search'));
    }

    public function create()
    {
        checkGate('can_create');

        $country = Country::whereStatus('1');
        if (App::isLocale('ar')) {
            $country->select('id', 'name_ar as name', 'flag', 'code', 'latitude', 'longitude');
        } else {
            $country->select('id', 'name_en as name', 'flag', 'code', 'latitude', 'longitude');
        }
        $countries = $country->get();

        $attribute = Attribute::whereStatus('1');
        if (App::isLocale('ar')) {
            $attribute->select('id', 'name_ar as name');
        } else {
            $attribute->select('id', 'name_en as name');
        }
        $attributes = $attribute->get();

        return view('admin.apartment.create', compact('countries', 'attributes'));
    }

    public function store(Request $request)
    {
        // dd($request->type);
        // $validator = Validator::make($request->all(), [
        //     'name_ar'       	=> 'required|string',
        //     // 'description_en'    => 'required|string',
        //     'description_ar'    => 'required|string',
        //     'country'       	=> 'required|exists:countries,id',
        //     'city'       		=> 'required|exists:cities,id',
        //     'images'         	=> 'required|array',
        //     'attributes'        => 'required|array',
        //     'due_date'        => 'required|date_format:Y-m-d|after:today',
        //     // 'due_date'        	=> 'required|date_format:Y-m-d|after:start_date',
        //     'num_of_rooms'      => 'required',
        //     'num_of_baths'      => 'required',
        //     'latitude'         	=> 'required',
        //     'longitude'         => 'required',
        //     'price'      		=> 'required',
        //     'discount'			=> 'nullable',
        //     'discount_type'		=> 'nullable|in:percent,price',
        //     'size'				=> 'required',
        //     'payment_methods'				=> 'required'
        // ]);

        // if($validator->fails())
        // {
        //     $error = $validator->errors()->first();
        //     return redirect()->back()->withInput($request->all())->with('error', $error);
        // }

        $apartment = Property::create([
            'name_en'       	=> $request->name_ar,
            'name_ar'       	=> $request->name_ar,
            'description_en'    => $request->description_ar,
            'description_ar'    => $request->description_ar,
            'country_id'       	=> $request->country,
            'city_id'       	=> $request->city,
            'is_furnished'       => $request->is_furshied == 'on' ? '1' : '0',
            'is_popular'       => $request->is_popular == 'on' ? '1' : '0',

            'due_date'        	=> $request->due_date,
            'num_of_rooms'      => $request->num_of_rooms,
            'num_of_baths'      => $request->num_of_baths,
            'latitude'         	=> $request->latitude,
            'longitude'         => $request->longitude,
            'price'      		=> $request->price,
            'discount'			=> $request->discount,
            'discount_type'		=> $request->discount_type,
            'size'				=> $request->size,
            'payment_method'	=> $request->payment_methods,
            'factory_type'				=> $request->factory_type,
            'land_type'				=> $request->land_type,
            'type'				=> $request->type??'1',
            'status'			=> '1'
        ]);

        // if($request->has('images')){
        // 	foreach ($request->images as $image) {
        // 		$extension      = $image->getClientOriginalExtension();
	       //      $imageRename    = time(). uniqid() . '.'.$extension;

	       //      $path           = public_path("images\properties");

	       //      if(!File::exists($path)) File::makeDirectory($path, 775, true);

	       //      $img = Image::make($image)->resize(400, 400, function ($constraint) {
	       //          $constraint->aspectRatio();
	       //          $constraint->upsize();
	       //      })->save(public_path('images/properties/').$imageRename);

	       //      $hotelImage = PropertyImage::create([
	       //      	'name' 			=> $imageRename,
	       //      	'property_id'	=> $hotel->id
	       //      ]);
        // 	}
        // }

        if($request->has('images')){
            foreach ($request->images as $image)
            {
                $hotelImage = PropertyImage::create([
                    'name'          => $image,
                    'property_id'   => $apartment->id
                ]);
            }
        }

        if($request['attributes']){
            foreach ($request['attributes'] as $key => $value)
            {
                $hotelAttribute = PropertyAttribute::create([
                    'attribute_id'      => $key,
                    'property_id'       => $apartment->id
                ]);
            }
        }

        $success = trans('common.created Successfully');
        return redirect()->route('show_apartment', $apartment->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $apartment = Property::find($id);

        $apartment = $this->property_transformer->transform($apartment);
        // dd($apartment);
        $attribute = Attribute::whereStatus('1');
        if (App::isLocale('ar')) {
            $attribute->select('id', 'name_ar as name');
        } else {
            $attribute->select('id', 'name_en as name');
        }
        $attributes = $attribute->get();

        return view('admin.apartment.show', compact('apartment', 'attributes'));
    }

    public function edit($id)
    {
       // dd('rtrtrt');
        checkGate('can_edit');


        $apartment = Property::find($id);

        $country = Country::whereStatus('1');
        if (App::isLocale('ar')) {
            $country->select('id', 'name_ar as name', 'flag', 'code', 'latitude', 'longitude');
        } else {
            $country->select('id', 'name_en as name', 'flag', 'code', 'latitude', 'longitude');
        }
        $countries = $country->get();

        $city = City::whereStatus('1');
        if (App::isLocale('ar')) {
            $city->select('id', 'name_ar as name');
        } else {
            $city->select('id', 'name_en as name');
        }
        $cities = $city->get();

        $attribute = Attribute::whereStatus('1');
        if (App::isLocale('ar')) {
            $attribute->select('id', 'name_ar as name');
        } else {
            $attribute->select('id', 'name_en as name');
        }
        $attributes = $attribute->get();

        // dd($apartment->propertyImage[0]->only_name, $apartment->propertyImage[0]->name);

        return view('admin.apartment.edit', compact('apartment', 'countries', 'cities', 'attributes'));
    }

    public function update(Request $request, $id)
    {
        $apartment = Property::find($id);

        // $validator = Validator::make($request->all(), [
        //     'name_ar'       	=> 'required|string',
        //     // 'description_en'    => 'required|string',
        //     'description_ar'    => 'required|string',
        //     'country'       	=> 'required|exists:countries,id',
        //     'city'       		=> 'required|exists:cities,id',
        //     'images'         	=> 'required|array',
        //     'attributes'        => 'required|array',
        //     'due_date'        => 'required|date_format:Y-m-d|after:today',
        //     // 'due_date'        	=> 'required|date_format:Y-m-d|after:start_date',
        //     'num_of_rooms'      => 'required',
        //     'num_of_baths'      => 'required',
        //     'latitude'         	=> 'required',
        //     'longitude'         => 'required',
        //     'price'      		=> 'required',
        //     'discount'			=> 'nullable',
        //     'discount_type'		=> 'nullable|in:percent,price',
        //     'size'				=> 'required',
        //     'payment_methods'				=> 'required'
        // ]);

        // if($validator->fails())
        // {
        //     $error = $validator->errors()->first();
        //     return redirect()->back()->withInput($request->all())->with('error', $error);
        // }

        $apartment->update([
            'name_en'       	=> $request->name_ar,
            'name_ar'       	=> $request->name_ar,
            'description_en'    => $request->description_ar,
            'description_ar'    => $request->description_ar,
            'country_id'       	=> $request->country,
            'city_id'       	=> $request->city,
            'is_furnished'       => $request->is_furshied == 'on' ? '1' : '0',
            'is_popular'       => $request->is_popular == 'on' ? '1' : '0',

            'due_date'        	=> $request->due_date,
            'num_of_rooms'      => $request->num_of_rooms,
            'num_of_baths'      => $request->num_of_baths,
            'latitude'         	=> $request->latitude,
            'longitude'         => $request->longitude,
            'price'      		=> $request->price,
            'discount'			=> $request->discount,
            'discount_type'		=> $request->discount_type,
            'size'				=> $request->size,
            'payment_method'	=> $request->payment_methods,
            'factory_type'				=> $request->factory_type??$apartment->factory_type,
            'land_type'				=> $request->land_type??$apartment->land_type,
            'type'				=> $request->type??$apartment->type,
            'status'			=> '1'
        ]);

        if($request->has('images')){
            $deleteAllImages = PropertyImage::wherePropertyId($id)->delete();
            foreach ($request->images as $image)
            {
                $hotelImage = PropertyImage::create([
                    'name'          => $image,
                    'property_id'   => $apartment->id
                ]);
            }
        }

        if($request['attributes']){
            $deleteAllAttributes = PropertyAttribute::wherePropertyId($id)->delete();
            foreach ($request['attributes'] as $key => $value)
            {
                $hotelAttribute = PropertyAttribute::create([
                    'attribute_id'      => $key,
                    'property_id'       => $apartment->id
                ]);
            }
        }

        $success = trans('common.Updated Successfully');

        return redirect()->route('show_apartment', $apartment->id)->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $apartment = Property::findOrFail($id);

        $apartment->delete();

        // return redirect()->route('users');
        return response()->json(['success' => 'Deleted Successfully']);
    }
}
