<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BookList;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class BookListController extends BaseController
{
    function __construct() 
    {
        $this->middleware(function ($request, $next) {
            checkPermission('is_book_list');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $book = BookList::whereStatus('1')->orderBy('id', 'desc');
        if (App::isLocale('ar')) {
            $book->select('id', 'name_ar as name', 'type', 'status');
        } else {
            $book->select('id', 'name_en as name', 'type', 'status');
        }
        $books = $book->paginate(20);

        return view('admin.book.index', compact('books'));
    }

    public function create()
    {
        checkGate('can_create');
        
        return view('admin.book.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            'type'    			=> 'required|in:1,2',
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }
                        
        $book = BookList::create([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'type'    			=> $request->type,
          	'status'			=> '1'
        ]);
        
        $success = trans('common.created Successfully');
        return redirect()->route('show_book', $book->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $data = BookList::whereId($id);
        if (App::isLocale('ar')) {
            $data->select('id', 'name_ar as name', 'type');
        } else {
            $data->select('id', 'name_en as name', 'type');
        }
        $book = $data->first();

        return view('admin.book.show', compact('book'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $book = BookList::find($id);
        
        return view('admin.book.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $book = BookList::find($id);

        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            'type'    			=> 'required|in:1,2'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $book->update([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'type'    			=> $request->type,
        ]);
        
        $success = trans('common.Updated Successfully');

        return redirect()->route('books')->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $book = BookList::find($id);

        $book->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }
    
    public function blockBook(Request $request)
    {
        $id = $request->id;
        //$message = $request->type == 'block' ? 'تم الغاء التفعيل المستخدم بنجاح' : 'تم تفعيل المستخدم بنجاح';
        $message = $request->status == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $book = BookList::find($id);
        $book->status = $request->status;
        $book->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
