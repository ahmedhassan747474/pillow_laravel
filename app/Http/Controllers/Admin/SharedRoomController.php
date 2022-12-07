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

class SharedRoomController extends BaseController
{
    function __construct(PropertyTransformer $property_transformer) 
    {
        $this->property_transformer = $property_transformer;

        $this->middleware(function ($request, $next) {
            checkPermission('is_shared');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $rooms = Property::whereType('3')->orderBy('id', 'desc')->paginate(20);

        $rooms = $this->property_transformer->transformCollection($rooms->getCollection());

        $data = Property::whereType('3')->orderBy('id', 'desc')->paginate(20);

        return view('admin.room.index', compact('rooms', 'data'));
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
        
        return view('admin.room.create', compact('countries', 'attributes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            'description_en'    => 'required|string',
            'description_ar'    => 'required|string',
            'country'       	=> 'required|exists:countries,id',
            'city'       		=> 'required|exists:cities,id',
            'images'         	=> 'required|array',
            'is_hot_deal'		=> 'required',
            'is_cheapest'		=> 'required',
            'is_popular'		=> 'required',
            'attributes'        => 'required|array',
            'start_date'        => 'required|date_format:Y-m-d|after:today',
            'end_date'        	=> 'required|date_format:Y-m-d|after:start_date',
            'num_of_adult'      => 'required',
            'num_of_child'      => 'required',
            'latitude'         	=> 'required',
            'longitude'         => 'required',
            'price'      		=> 'required',
            'discount'			=> 'nullable',
            'discount_type'		=> 'nullable|in:percent,price',
            'size'				=> 'required',
            'per'				=> 'required'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }
                        
        $room = Property::create([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'description_en'    => $request->description_en,
            'description_ar'    => $request->description_ar,
            'country_id'       	=> $request->country,
            'city_id'       	=> $request->city,
            'is_hot_deal'       => $request->is_hot_deal == 'on' ? '1' : '0',
            'is_cheapest'       => $request->is_cheapest == 'on' ? '1' : '0',
            'is_popular'        => $request->is_popular == 'on' ? '1' : '0',
            'start_date'        => $request->start_date,
            'end_date'        	=> $request->end_date,
            'num_of_adult'      => $request->num_of_adult,
            'num_of_child'      => $request->num_of_child,
            'latitude'         	=> $request->latitude,
            'longitude'         => $request->longitude,
            'price'      		=> $request->price,
            'discount'			=> $request->discount,
            'discount_type'		=> $request->discount_type,
            'size'				=> $request->size,
            'per'				=> $request->per,
            'type'				=> '3',
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
                    'property_id'   => $room->id
                ]);
            }
        }

        if($request['attributes']){
            foreach ($request['attributes'] as $key => $value)
            {
                $hotelAttribute = PropertyAttribute::create([
                    'attribute_id'      => $key,
                    'property_id'       => $room->id
                ]);
            }
        }

        $success = trans('common.created Successfully');
        return redirect()->route('show_room', $room->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $room = Property::find($id);

        $room = $this->property_transformer->transform($room);
        // dd($room);
        $attribute = Attribute::whereStatus('1');
        if (App::isLocale('ar')) {
            $attribute->select('id', 'name_ar as name');
        } else {
            $attribute->select('id', 'name_en as name');
        }
        $attributes = $attribute->get();

        return view('admin.room.show', compact('room', 'attributes'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $room = Property::find($id);

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

        // dd($room->propertyImage[0]->only_name, $room->propertyImage[0]->name);
        
        return view('admin.room.edit', compact('room', 'countries', 'cities', 'attributes'));
    }

    public function update(Request $request, $id)
    {
        $room = Property::find($id);

        $validator = Validator::make($request->all(), [
            'name_en'           => 'required|string',
            'name_ar'           => 'required|string',
            'description_en'    => 'required|string',
            'description_ar'    => 'required|string',
            'country'           => 'required|exists:countries,id',
            'city'              => 'required|exists:cities,id',
            'images'            => 'required|array',
            'is_hot_deal'       => 'nullable',
            'is_cheapest'       => 'nullable',
            'is_popular'        => 'nullable',
            'attributes'        => 'required|array',
            'start_date'        => 'required|date_format:Y-m-d',
            'end_date'          => 'required|date_format:Y-m-d|after:start_date',
            'num_of_adult'      => 'required',
            'num_of_child'      => 'required',
            'latitude'          => 'required',
            'longitude'         => 'required',
            'price'             => 'required',
            'discount'          => 'nullable',
            'discount_type'     => 'nullable|in:percent,price',
            'size'              => 'required',
            'per'               => 'required'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $room->update([
            'name_en'           => $request->name_en,
            'name_ar'           => $request->name_ar,
            'description_en'    => $request->description_en,
            'description_ar'    => $request->description_ar,
            'country_id'        => $request->country,
            'city_id'           => $request->city,
            'is_hot_deal'       => $request->is_hot_deal == 'on' ? '1' : '0',
            'is_cheapest'       => $request->is_cheapest == 'on' ? '1' : '0',
            'is_popular'        => $request->is_popular == 'on' ? '1' : '0',
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
            'num_of_adult'      => $request->num_of_adult,
            'num_of_child'      => $request->num_of_child,
            'latitude'          => $request->latitude,
            'longitude'         => $request->longitude,
            'price'             => $request->price,
            'discount'          => $request->discount,
            'discount_type'     => $request->discount_type,
            'size'              => $request->size,
            'per'               => $request->per,
        ]);

        if($request->has('images')){
            $deleteAllImages = PropertyImage::wherePropertyId($id)->delete();
            foreach ($request->images as $image)
            {
                $hotelImage = PropertyImage::create([
                    'name'          => $image,
                    'property_id'   => $room->id
                ]);
            }
        }

        if($request['attributes']){
            $deleteAllAttributes = PropertyAttribute::wherePropertyId($id)->delete();
            foreach ($request['attributes'] as $key => $value)
            {
                $hotelAttribute = PropertyAttribute::create([
                    'attribute_id'      => $key,
                    'property_id'       => $room->id
                ]);
            }
        }
        
        $success = trans('common.Updated Successfully');

        return redirect()->route('show_room', $room->id)->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $room = Property::findOrFail($id);

        $room->delete();

        // return redirect()->route('users');
        return response()->json(['success' => 'Deleted Successfully']);
    }
}
