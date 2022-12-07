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
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use App\Transformers\Admin\PropertyTransformer;

class TravelAgencyController extends Controller
{
    function __construct(PropertyTransformer $property_transformer) 
    {
        $this->property_transformer = $property_transformer;

        $this->middleware(function ($request, $next) {
            checkPermission('is_travel');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $travels = Property::whereType('6')->orderBy('id', 'desc')->paginate(20);

        $travels = $this->property_transformer->transformCollection($travels->getCollection());

        $data = Property::whereType('6')->orderBy('id', 'desc')->paginate(20);

        return view('admin.travel.index', compact('travels', 'data'));
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

        $through = Through::whereStatus('1')->where('type', '1');
        if (App::isLocale('ar')) {
            $through->select('id', 'name_ar as name');
        } else {
            $through->select('id', 'name_en as name');
        }
        $throughs = $through->get();
        
        return view('admin.travel.create', compact('countries', 'books', 'throughs'));
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
            'traveler_date'		=> 'required|date_format:Y-m-d',
            'traveler_number'	=> 'required',
            'through'      		=> 'required|exists:throughs,id',
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
                        
        $travel = Property::create([
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
            'traveler_date'     => $request->traveler_date,
            'traveler_number'   => $request->traveler_number,
            'through_id'      	=> $request->through,
            'latitude'         	=> $request->latitude,
            'longitude'         => $request->longitude,
            'price'      		=> $request->price,
            'discount'			=> $request->discount,
            'discount_type'		=> $request->discount_type,
            'per'				=> $request->per,
            'type'				=> '6',
            'status'			=> '1'
        ]);

        if($request->has('images')){
            foreach ($request->images as $image)
            {
                $hotelImage = PropertyImage::create([
                    'name'          => $image,
                    'property_id'   => $travel->id
                ]);
            }
        }

        $success = trans('common.created Successfully');
        return redirect()->route('show_travel', $travel->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $travel = Property::find($id);

        $travel = $this->property_transformer->transform($travel);

        return view('admin.travel.show', compact('travel'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $travel = Property::find($id);

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

        $through = BookList::whereStatus('1');
        if (App::isLocale('ar')) {
            $through->select('id', 'name_ar as name');
        } else {
            $through->select('id', 'name_en as name');
        }
        $throughs = $through->get();
        
        return view('admin.travel.edit', compact('travel', 'countries', 'cities', 'books', 'throughs'));
    }

    public function update(Request $request, $id)
    {
        $travel = Property::find($id);

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
            'traveler_date'		=> 'required|date_format:Y-m-d',
            'traveler_number'	=> 'required',
            'through'      		=> 'required|exists:throughs,id',
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

        $travel->update([
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
            'traveler_date'     => $request->traveler_date,
            'traveler_number'   => $request->traveler_number,
            'through_id'      	=> $request->through,
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
                    'property_id'   => $travel->id
                ]);
            }
        }
        
        $success = trans('common.Updated Successfully');

        return redirect()->route('show_travel', $travel->id)->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $travel = Property::findOrFail($id);

        $travel->delete();

        // return redirect()->route('users');
        return response()->json(['success' => 'Deleted Successfully']);
    }
}
