<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Chat;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class ChatController extends BaseController
{
    public function index()
    {
        // abort_if(Gate::denies('can_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $chats = Chat::where(function($query){
            	$query->where('sender', 0);
            	$query->orWhere('receiver', 0);
            })
        	// ->where(function($query) use (){
         //    	$query->where('sender', $request->from);
         //    	$query->orWhere('receiver', $request->from);
         //    })
        	->where('for_whom', 'admin')
        	// ->orderBy('id', 'desc')
        	->get();
        dd($chats);
        return view('admin.chat.index', compact('chats'));
    }
}
