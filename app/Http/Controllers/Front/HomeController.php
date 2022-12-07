<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        return view('front.home.main');
    }

    public function about()
    {
        return view('front.home.about');
    }


}
