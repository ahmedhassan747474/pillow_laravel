<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;
use App\City;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class CityController extends Controller
{
    function __construct() 
    {
        $this->middleware(function ($request, $next) {
            checkPermission('is_city');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $city = City::whereStatus('1')->orderBy('id', 'desc');
        if (App::isLocale('ar')) {
            $city->select('id', 'name_ar as name', 'country_id', 'status');
        } else {
            $city->select('id', 'name_en as name', 'country_id', 'status');
        }
        $cities = $city->paginate(20);

        return view('admin.city.index', compact('cities'));
    }

    public function create()
    {
        checkGate('can_create');

        $country = Country::whereStatus('1');
        if (App::isLocale('ar')) {
            $country->select('id', 'name_ar as name', 'flag', 'code');
        } else {
            $country->select('id', 'name_en as name', 'flag', 'code');
        }
        $countries = $country->get();
        
        return view('admin.city.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            'country'         	=> 'required|exists:countries,id'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }
                        
        $city = City::create([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
          	'country_id'       	=> $request->country,
          	'status'			=> '1'
        ]);
        
        $success = trans('common.created Successfully');
        return redirect()->route('show_city', $city->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $data = City::whereId($id);
        if (App::isLocale('ar')) {
            $data->select('id', 'name_ar as name', 'country_id', 'status');
        } else {
            $data->select('id', 'name_en as name', 'country_id', 'status');
        }
        $city = $data->first();

        return view('admin.city.show', compact('city'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $city = City::find($id);

        $country = Country::whereStatus('1');
        if (App::isLocale('ar')) {
            $country->select('id', 'name_ar as name', 'flag', 'code');
        } else {
            $country->select('id', 'name_en as name', 'flag', 'code');
        }
        $countries = $country->get();
        
        return view('admin.city.edit', compact('city', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $city = City::find($id);

        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            'country'         	=> 'required|exists:countries,id'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $city->update([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
          	'country_id'       	=> $request->country,
        ]);
        
        $success = trans('common.Updated Successfully');

        return redirect()->route('cities')->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $city = City::find($id);

        $city->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }
    
    public function blockCity(Request $request)
    {
        $id = $request->id;
        $message = $request->status == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $city = City::find($id);
        $city->status = $request->status;
        $city->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
