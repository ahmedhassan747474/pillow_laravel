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

class WeddingHallController extends BaseController
{
    function __construct(PropertyTransformer $property_transformer) 
    {
        $this->property_transformer = $property_transformer;

        $this->middleware(function ($request, $next) {
            checkPermission('is_wedding');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $weddings = Property::whereType('5')->orderBy('id', 'desc')->paginate(20);

        $weddings = $this->property_transformer->transformCollection($weddings->getCollection());

        $data = Property::whereType('5')->orderBy('id', 'desc')->paginate(20);

        return view('admin.wedding.index', compact('weddings', 'data'));
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
        
        return view('admin.wedding.create', compact('countries'));
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
            'is_hot_deal'		=> 'nullable',
            'is_cheapest'		=> 'nullable',
            'is_popular'		=> 'nullable',
            'book_in'        	=> 'required|date_format:Y-m-d',
            'start_time'		=> 'required',
            'end_time'			=> 'required',
            'guest_number'      => 'required',
            'hall_size'      	=> 'required',
            'latitude'         	=> 'required',
            'longitude'         => 'required',
            'price'      		=> 'required',
            'discount'			=> 'nullable',
            'discount_type'		=> 'nullable|in:percent,price',
            'per'				=> 'required'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }
                        
        $wedding = Property::create([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'description_en'    => $request->description_en,
            'description_ar'    => $request->description_ar,
            'country_id'       	=> $request->country,
            'city_id'       	=> $request->city,
            'is_hot_deal'       => $request->is_hot_deal == 'on' ? '1' : '0',
            'is_cheapest'       => $request->is_cheapest == 'on' ? '1' : '0',
            'is_popular'        => $request->is_popular == 'on' ? '1' : '0',
            'book_in'        	=> $request->book_in,
            'start_time'       	=> $request->start_time,
            'end_time'       	=> $request->end_time,
            'guest_number'      => $request->guest_number,
            'hall_size'      	=> $request->hall_size,
            'latitude'         	=> $request->latitude,
            'longitude'         => $request->longitude,
            'price'      		=> $request->price,
            'discount'			=> $request->discount,
            'discount_type'		=> $request->discount_type,
            'per'				=> $request->per,
            'type'				=> '5',
            'status'			=> '1'
        ]);

        if($request->has('images')){
            foreach ($request->images as $image)
            {
                $hotelImage = PropertyImage::create([
                    'name'          => $image,
                    'property_id'   => $wedding->id
                ]);
            }
        }

        $success = trans('common.created Successfully');
        return redirect()->route('show_wedding', $wedding->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $wedding = Property::find($id);

        $wedding = $this->property_transformer->transform($wedding);

        return view('admin.wedding.show', compact('wedding'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $wedding = Property::find($id);

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
        
        return view('admin.wedding.edit', compact('wedding', 'countries', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $wedding = Property::find($id);

        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            'description_en'    => 'required|string',
            'description_ar'    => 'required|string',
            'country'       	=> 'required|exists:countries,id',
            'city'       		=> 'required|exists:cities,id',
            'images'         	=> 'required|array',
            'is_hot_deal'		=> 'nullable',
            'is_cheapest'		=> 'nullable',
            'is_popular'		=> 'nullable',
            'book_in'        	=> 'required|date_format:Y-m-d',
            'start_time'		=> 'required',
            'end_time'			=> 'required',
            'guest_number'      => 'required',
            'hall_size'      	=> 'required',
            'latitude'         	=> 'required',
            'longitude'         => 'required',
            'price'      		=> 'required',
            'discount'			=> 'nullable',
            'discount_type'		=> 'nullable|in:percent,price',
            'per'				=> 'required'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $wedding->update([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'description_en'    => $request->description_en,
            'description_ar'    => $request->description_ar,
            'country_id'       	=> $request->country,
            'city_id'       	=> $request->city,
            'is_hot_deal'       => $request->is_hot_deal == 'on' ? '1' : '0',
            'is_cheapest'       => $request->is_cheapest == 'on' ? '1' : '0',
            'is_popular'        => $request->is_popular == 'on' ? '1' : '0',
            'book_in'        	=> $request->book_in,
            'start_time'       	=> $request->start_time,
            'end_time'       	=> $request->end_time,
            'guest_number'      => $request->guest_number,
            'hall_size'      	=> $request->hall_size,
            'latitude'         	=> $request->latitude,
            'longitude'         => $request->longitude,
            'price'      		=> $request->price,
            'discount'			=> $request->discount,
            'discount_type'		=> $request->discount_type,
            'per'				=> $request->per,
        ]);

        if($request->has('images')){
            $deleteAllImages = PropertyImage::wherePropertyId($id)->delete();
            foreach ($request->images as $image)
            {
                $hotelImage = PropertyImage::create([
                    'name'          => $image,
                    'property_id'   => $wedding->id
                ]);
            }
        }
        
        $success = trans('common.Updated Successfully');

        return redirect()->route('show_wedding', $wedding->id)->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $wedding = Property::findOrFail($id);

        $wedding->delete();

        // return redirect()->route('users');
        return response()->json(['success' => 'Deleted Successfully']);
    }
}
