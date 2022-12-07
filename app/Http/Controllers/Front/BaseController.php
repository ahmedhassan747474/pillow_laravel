<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use View;

class BaseController extends Controller
{
    protected $model;

    function __construct()
    {
        config(['auth.defaults.guard' => 'web' ]);
        View::share('data', 'Shared WebSite Data');
    }
}
