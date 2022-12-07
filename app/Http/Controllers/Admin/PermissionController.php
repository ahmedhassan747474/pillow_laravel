<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Permission;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            checkPermission('is_admin');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $permissions = Permission::paginate(20);

        return view('admin.permission.index', compact('permissions'));
    }

    public function create()
    {
        checkGate('can_create');

        return view('admin.permission.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $permission = Permission::create([
            'name' 					=> $request->name,
            'is_admin' 				=> $request->is_all == 'on' ? 1 : ($request->is_admin == 'on' ? 1 : 0),
            'is_user'			    => $request->is_all == 'on' ? 1 : ($request->is_user == 'on' ? 1 : 0),
            'is_ride'			    => $request->is_all == 'on' ? 1 : ($request->is_ride == 'on' ? 1 : 0),
            'is_gallary'			    => $request->is_all == 'on' ? 1 : ($request->is_gallary == 'on' ? 1 : 0),
            'is_offer'			    => $request->is_all == 'on' ? 1 : ($request->is_offer == 'on' ? 1 : 0),
            'is_information'			    => $request->is_all == 'on' ? 1 : ($request->is_information == 'on' ? 1 : 0),
            // 'is_hotel'			    => $request->is_all == 'on' ? 1 : ($request->is_hotel == 'on' ? 1 : 0),
            'is_furnished'			=> $request->is_all == 'on' ? 1 : ($request->is_furnished == 'on' ? 1 : 0),
            // 'is_shared'				=> $request->is_all == 'on' ? 1 : ($request->is_shared == 'on' ? 1 : 0),
            // 'is_restaurant'			=> $request->is_all == 'on' ? 1 : ($request->is_restaurant == 'on' ? 1 : 0),
            // 'is_wedding'			=> $request->is_all == 'on' ? 1 : ($request->is_wedding == 'on' ? 1 : 0),
            // 'is_travel'			    => $request->is_all == 'on' ? 1 : ($request->is_travel == 'on' ? 1 : 0),
            // 'is_business'		    => $request->is_all == 'on' ? 1 : ($request->is_business == 'on' ? 1 : 0),
            // 'is_car'			    => $request->is_all == 'on' ? 1 : ($request->is_car == 'on' ? 1 : 0),
            // 'is_residential'		=> $request->is_all == 'on' ? 1 : ($request->is_residential == 'on' ? 1 : 0),
            'is_attributes'		    => $request->is_all == 'on' ? 1 : ($request->is_attributes == 'on' ? 1 : 0),
            // 'is_book_list'			=> $request->is_all == 'on' ? 1 : ($request->is_book_list == 'on' ? 1 : 0),
            // 'is_through'		    => $request->is_all == 'on' ? 1 : ($request->is_through == 'on' ? 1 : 0),
            // 'is_include'			=> $request->is_all == 'on' ? 1 : ($request->is_include == 'on' ? 1 : 0),
            // 'is_residential_type'	=> $request->is_all == 'on' ? 1 : ($request->is_residential_type == 'on' ? 1 : 0),
            'is_country'		    => $request->is_all == 'on' ? 1 : ($request->is_country == 'on' ? 1 : 0),
            'is_city'			    => $request->is_all == 'on' ? 1 : ($request->is_city == 'on' ? 1 : 0),
            // 'is_reason'		        => $request->is_all == 'on' ? 1 : ($request->is_reason == 'on' ? 1 : 0),
            // 'is_coupon'			    => $request->is_all == 'on' ? 1 : ($request->is_coupon == 'on' ? 1 : 0),
            'is_property'	        => $request->is_all == 'on' ? 1 : ($request->is_property == 'on' ? 1 : 0),
            // 'is_reservation'		=> $request->is_all == 'on' ? 1 : ($request->is_reservation == 'on' ? 1 : 0),
        ]);

        return redirect()->route('permissions');
    }

    public function show($id)
    {
        checkGate('can_show');

        $permission = Permission::find($id);

        return view('admin.permission.show', compact('permission'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $permission = Permission::find($id);

        return view('admin.permission.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $permission->update([
            'name' 					=> $request->name,
            'is_admin' 				=> $request->is_admin == 'on' ? 1 : 0,
            'is_user'			    => $request->is_user == 'on' ? 1 : 0,
            'is_ride'			    => $request->is_ride == 'on' ? 1 : 0,
            'is_information'			    => $request->is_information == 'on' ? 1 : 0,
            'is_offer'			    => $request->is_offer == 'on' ? 1 : 0,
            'is_gallary'			    => $request->is_gallary == 'on' ? 1 : 0,
            // 'is_hotel'			    => $request->is_hotel == 'on' ? 1 : 0,
            'is_furnished'			=> $request->is_furnished == 'on' ? 1 : 0,
            // 'is_shared'				=> $request->is_shared == 'on' ? 1 : 0,
            // 'is_restaurant'			=> $request->is_restaurant == 'on' ? 1 : 0,
            // 'is_wedding'			=> $request->is_wedding == 'on' ? 1 : 0,
            // 'is_travel'			    => $request->is_travel == 'on' ? 1 : 0,
            // 'is_business'		    => $request->is_business == 'on' ? 1 : 0,
            // 'is_car'			    => $request->is_car == 'on' ? 1 : 0,
            // 'is_residential'		=> $request->is_residential == 'on' ? 1 : 0,
            'is_attributes'		    => $request->is_attributes == 'on' ? 1 : 0,
            // 'is_book_list'			=> $request->is_book_list == 'on' ? 1 : 0,
            // 'is_through'		    => $request->is_through == 'on' ? 1 : 0,
            // 'is_include'			=> $request->is_include == 'on' ? 1 : 0,
            // 'is_residential_type'	=> $request->is_residential_type == 'on' ? 1 : 0,
            'is_country'		    => $request->is_country == 'on' ? 1 : 0,
            'is_city'			    => $request->is_city == 'on' ? 1 : 0,
            // 'is_reason'		        => $request->is_reason == 'on' ? 1 : 0,
            // 'is_coupon'			    => $request->is_coupon == 'on' ? 1 : 0,
            'is_property'	        => $request->is_property == 'on' ? 1 : 0,
            // 'is_reservation'		=> $request->is_reservation == 'on' ? 1 : 0,
        ]);

        return redirect()->route('permissions');
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $permission = Permission::find($id);

        $permission->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }
}
