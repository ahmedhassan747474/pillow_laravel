<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Admin\UpdateAdminProfileRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Router;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Admin;

class AdminController extends BaseController
{
    function __construct(Admin $model)
    {
        $this->model = $model;
        config(['auth.defaults.guard' => 'admin']);
    }

    public function login()
    {
        return view('admin.admins.login');
    }

    public function checkLogin(AdminLoginRequest $request)
    {
        $remember_me = ($request->remember_me) ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => '1'], $remember_me)) 
        {
            $user = Auth::user();
            return redirect()->route('admin-home');
        }
        else
         {
            return Redirect::back()->withErrors(['msg' => trans('common.invalid_credentials') ])->withInput();
        }
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.admins.profile', compact('user'));
    }

    public function updateProfile(UpdateAdminProfileRequest $request)
    {
        $user = Auth::user();
        $user = $this->model::find(auth()->user()->id);
        
        if($request->filled('password'))
        {
            $request['password'] = bcrypt($request->password);
        }
        else
        {
            $request['password'] = $user->password;
        }
        
        $user->fill($request->all());
        $user->save();
        
        return view('admin.admins.success', array('msg' => trans('common.success_update')));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin-login');
    }
}
