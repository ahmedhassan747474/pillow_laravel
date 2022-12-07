<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use App\Http\Requests\Front\UserLoginRequest;
use App\Http\Requests\Front\ChangePasswordRequest;
use App\Http\Requests\Front\UserRegisterationRequest;
use App\Http\Requests\Front\UpdateUserProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use DB;
use Hash;

class UserController extends BaseController
{
    function __construct(User $model)
    {
        $this->model = $model;
        config(['auth.defaults.guard' => 'web']);
    }

    public function index()
    {
        return view('front.home.main');
    }

    public function login()
    {
        return view('front.users.login');
    }

    public function registeration()
    {
        return view('front.users.registeration');
    }

    public function submitRegisteration(UserRegisterationRequest $request)
    {
        $request['password'] = bcrypt($request->password);
        $this->model::create($request->all());
        return view('front.users.success', array('msg' => trans('common.success_registeration')));
    }

    public function checkLogin(UserLoginRequest $request)
    {
        $remember_me = ($request->remember_me) ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) 
        {
            $user = Auth::user();
            
            if($user->status == 0)
            {
                Auth::logout();
                Session::flush();
                return redirect()->back()->withErrors([ 'msg'=> 'Sorry your account is rejected' ])->withInput();
            }
            return redirect()->intended('/');
        }
        else
        {
            return redirect()->back()->withErrors([ 'msg'=> trans('common.invalid_credentials') ])->withInput();
        }
    }

    public function profile()
    {
        $user = Auth::user();
        return view('front.users.profile', compact('user'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function resetPassword($token)
    {
        $email = request()->get('email');
        $existing_email = DB::table('password_resets')->where('email', $email)->first();

        if($existing_email)
        {
            $created_at  = new Carbon($existing_email->created_at);
            $current    = Carbon::now();

            $diff_hours = $created_at->diff($current)->format('%H');

            if($diff_hours < 1)
            {
                if(Hash::check($token, $existing_email->token))
                {
                    return view('front.users.reset_password', compact('email'));
                }
                else
                {
                    abort(401);
                }
            }
            else
            {
                DB::table('password_resets')->where('email', $email)->delete();
                abort(401);
            }
        }
        else
        {
            abort(401);
        }
    }

    public function updateProfile(UpdateUserProfileRequest $request)
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
        
        return view('front.users.success', array('msg' => trans('common.success_update')));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $existing_email = DB::table('password_resets')->where('email', $request->email)->first();
        if($existing_email)
        {
            $user = $this->model::where('email', $request->email)->first();
            $user->password = bcrypt($request->password);
            $user->save();
            DB::table('password_resets')->where('email', $request->email)->delete();
            return view('front.users.success', array('msg' => trans('common.success_update')));
        }
        else
        {
            abort(401);
        }
    }
}
