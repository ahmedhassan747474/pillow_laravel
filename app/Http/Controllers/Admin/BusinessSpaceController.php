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
use App\BookList;
use App\Through;
use App\IncludeList;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use App\Transformers\Admin\PropertyTransformer;

class BusinessSpaceController extends BaseController
{
    function __construct(PropertyTransformer $property_transformer) 
    {
        $this->property_transformer = $property_transformer;

        $this->middleware(function ($request, $next) {
            checkPermission('is_business');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $businesses = Property::whereType('7')->orderBy('id', 'desc')->paginate(20);

        $businesses = $this->property_transformer->transformCollection($businesses->getCollection());

        $data = Property::whereType('7')->orderBy('id', 'desc')->paginate(20);

        return view('admin.business.index', compact('businesses', 'data'));
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

        $book = BookList::whereStatus('1');
        if (App::isLocale('ar')) {
            $book->select('id', 'name_ar as name');
        } else {
            $book->select('id', 'name_en as name');
        }
        $books = $book->get();

        $include = IncludeList::whereStatus('1');
        if (App::isLocale('ar')) {
            $include->select('id', 'name_ar as name');
        } else {
            $include->select('id', 'name_en as name');
        }
        $includes = $include->get();
        
        return view('admin.business.create', compact('countries', 'books', 'includes'));
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
            'book_list'      	=> 'required|exists:book_list,id',
            'business_date'		=> 'required|date_format:Y-m-d',
            'num_of_employees'	=> 'required',
            'include'      		=> 'required|exists:includes,id',
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
                        
        $business = Property::create([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'description_en'    => $request->description_en,
            'description_ar'    => $request->description_ar,
            'country_id'       	=> $request->country,
            'city_id'       	=> $request->city,
            'is_hot_deal'       => $request->is_hot_deal == 'on' ? '1' : '0',
            'is_cheapest'       => $request->is_cheapest == 'on' ? '1' : '0',
            'is_popular'        => $request->is_popular == 'on' ? '1' : '0',
            'book_list_id'      => $request->book_list,
            'business_date'     => $request->business_date,
            'num_of_employees'  => $request->num_of_employees,
            'include_id'      	=> $request->include,
            'latitude'         	=> $request->latitude,
            'longitude'         => $request->longitude,
            'price'      		=> $request->price,
            'discount'			=> $request->discount,
            'discount_type'		=> $request->discount_type,
            'per'				=> $request->per,
            'type'				=> '7',
            'status'			=> '1'
        ]);

        if($request->has('images')){
            foreach ($request->images as $image)
            {
                $hotelImage = PropertyImage::create([
                    'name'          => $image,
                    'property_id'   => $business->id
                ]);
            }
        }

        $success = trans('common.created Successfully');
        return redirect()->route('show_business', $business->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $business = Property::find($id);

        $business = $this->property_transformer->transform($business);

        return view('admin.business.show', compact('business'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $business = Property::find($id);

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

        $book = BookList::whereStatus('1');
        if (App::isLocale('ar')) {
            $book->select('id', 'name_ar as name');
        } else {
            $book->select('id', 'name_en as name');
        }
        $books = $book->get();

        $include = IncludeList::whereStatus('1');
        if (App::isLocale('ar')) {
            $include->select('id', 'name_ar as name');
        } else {
            $include->select('id', 'name_en as name');
        }
        $includes = $include->get();
        
        return view('admin.business.edit', compact('business', 'countries', 'cities', 'books', 'includes'));
    }

    public function update(Request $request, $id)
    {
        $business = Property::find($id);

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
            'book_list'      	=> 'required|exists:book_list,id',
            'business_date'		=> 'required|date_format:Y-m-d',
            'num_of_employees'	=> 'required',
            'include'      		=> 'required|exists:includes,id',
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

        $business->update([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'description_en'    => $request->description_en,
            'description_ar'    => $request->description_ar,
            'country_id'       	=> $request->country,
            'city_id'       	=> $request->city,
            'is_hot_deal'       => $request->is_hot_deal == 'on' ? '1' : '0',
            'is_cheapest'       => $request->is_cheapest == 'on' ? '1' : '0',
            'is_popular'        => $request->is_popular == 'on' ? '1' : '0',
            'book_list_id'      => $request->book_list,
            'business_date'     => $request->business_date,
            'num_of_employees'  => $request->num_of_employees,
            'include_id'      	=> $request->include,
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
                    'property_id'   => $business->id
                ]);
            }
        }
        
        $success = trans('common.Updated Successfully');

        return redirect()->route('show_business', $business->id)->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $business = Property::findOrFail($id);

        $business->delete();

        // return redirect()->route('users');
        return response()->json(['success' => 'Deleted Successfully']);
    }
}
