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
use App\ResidentialType;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use App\Transformers\Admin\PropertyTransformer;

class ResidentialController extends Controller
{
    function __construct(PropertyTransformer $property_transformer) 
    {
        $this->property_transformer = $property_transformer;

        $this->middleware(function ($request, $next) {
            checkPermission('is_residential');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $residentials = Property::whereType('9')->orderBy('id', 'desc')->paginate(20);

        $residentials = $this->property_transformer->transformCollection($residentials->getCollection());

        $data = Property::whereType('9')->orderBy('id', 'desc')->paginate(20);

        return view('admin.residential.index', compact('residentials', 'data'));
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

        $through = Through::whereStatus('1')->where('type', '2');
        if (App::isLocale('ar')) {
            $through->select('id', 'name_ar as name');
        } else {
            $through->select('id', 'name_en as name');
        }
        $throughs = $through->get();

        $type = ResidentialType::whereStatus('1');
        if (App::isLocale('ar')) {
            $type->select('id', 'name_ar as name');
        } else {
            $type->select('id', 'name_en as name');
        }
        $types = $type->get();
        
        return view('admin.residential.create', compact('countries', 'throughs', 'types'));
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
            'through'      		=> 'required|exists:throughs,id',
            'residential_type'	=> 'required|exists:residential_type,id',
            'phone'				=> 'required',
            // 'phone_code'		=> 'required',
            'latitude'         	=> 'required',
            'longitude'         => 'required',
            'price'      		=> 'required',
            'discount'			=> 'nullable',
            'discount_type'		=> 'nullable|in:percent,price',
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $getCodeCountry = Country::where('id', $request->country)->first();
                        
        $residential = Property::create([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'description_en'    => $request->description_en,
            'description_ar'    => $request->description_ar,
            'country_id'       	=> $request->country,
            'city_id'       	=> $request->city,
            'is_hot_deal'       => $request->is_hot_deal == 'on' ? '1' : '0',
            'is_cheapest'       => $request->is_cheapest == 'on' ? '1' : '0',
            'is_popular'        => $request->is_popular == 'on' ? '1' : '0',
            'through_id'      	=> $request->through,
            'residential_type_id'=> $request->residential_type,
            'phone_number'		=> $request->phone,
            'phone_code'      	=> $getCodeCountry->code,
            'latitude'         	=> $request->latitude,
            'longitude'         => $request->longitude,
            'price'      		=> $request->price,
            'discount'			=> $request->discount,
            'discount_type'		=> $request->discount_type,
            'type'				=> '9',
            'status'			=> '1'
        ]);

        if($request->has('images')){
            foreach ($request->images as $image)
            {
                $hotelImage = PropertyImage::create([
                    'name'          => $image,
                    'property_id'   => $residential->id
                ]);
            }
        }

        $success = trans('common.created Successfully');
        return redirect()->route('show_residential', $residential->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $residential = Property::find($id);

        $residential = $this->property_transformer->transform($residential);

        return view('admin.residential.show', compact('residential'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $residential = Property::find($id);

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

        $through = Through::whereStatus('1')->where('type', '2');
        if (App::isLocale('ar')) {
            $through->select('id', 'name_ar as name');
        } else {
            $through->select('id', 'name_en as name');
        }
        $throughs = $through->get();

        $type = ResidentialType::whereStatus('1');
        if (App::isLocale('ar')) {
            $type->select('id', 'name_ar as name');
        } else {
            $type->select('id', 'name_en as name');
        }
        $types = $type->get();
        
        return view('admin.residential.edit', compact('residential', 'countries', 'cities', 'throughs', 'types'));
    }

    public function update(Request $request, $id)
    {
        $residential = Property::find($id);

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
            'through'      		=> 'required|exists:throughs,id',
            'residential_type'	=> 'required|exists:residential_type,id',
            'phone'				=> 'required',
            'latitude'         	=> 'required',
            'longitude'         => 'required',
            'price'      		=> 'required',
            'discount'			=> 'nullable',
            'discount_type'		=> 'nullable|in:percent,price',
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $getCodeCountry = Country::where('id', $request->country)->first();

        $residential->update([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'description_en'    => $request->description_en,
            'description_ar'    => $request->description_ar,
            'country_id'       	=> $request->country,
            'city_id'       	=> $request->city,
            'is_hot_deal'       => $request->is_hot_deal == 'on' ? '1' : '0',
            'is_cheapest'       => $request->is_cheapest == 'on' ? '1' : '0',
            'is_popular'        => $request->is_popular == 'on' ? '1' : '0',
            'through_id'      	=> $request->through,
            'residential_type_id'=> $request->residential_type,
            'phone_number'		=> $request->phone,
            'phone_code'      	=> $getCodeCountry->code,
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
                    'property_id'   => $residential->id
                ]);
            }
        }
        
        $success = trans('common.Updated Successfully');

        return redirect()->route('show_residential', $residential->id)->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $residential = Property::findOrFail($id);

        $residential->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }
}
