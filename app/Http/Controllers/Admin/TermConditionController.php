<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TermCondition;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class TermConditionController extends BaseController
{
    // function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         checkPermission('is_termconditions');
    //         return $next($request);
    //     });
    // }

    public function index()
    {
        checkGate('can_show');

        $term = TermCondition::whereStatus('1')->orderBy('id', 'desc');

        $terms = $term->paginate(20);

        return view('admin.terms.index', compact('terms'));
    }

    public function create()
    {
        checkGate('can_create');

        return view('admin.terms.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       	=> 'required|string',
            'type'       	=> 'required|string',
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $term = TermCondition::create([
            'name'       	=> $request->name,
            'type'       	=> $request->type,
        ]);

        // if($request->has('image')){
    	// 	$image 			= $request->image;
    	// 	$extension      = $image->getClientOriginalExtension();
        //     $imageRename    = time(). uniqid() . '.'.$extension;

        //     $path           = public_path("images\terms");

        //     if(!File::exists($path)) File::makeDirectory($path, 775, true);

        //     $img = Image::make($image)->resize(400, 400, function ($constraint) {
        //         $constraint->aspectRatio();
        //         $constraint->upsize();
        //     })->save(public_path('images/terms/').$imageRename);

        //     $term->update([
        //           'image'				=> $imageRename,
        //     ]);
        // }



        $success = trans('common.created Successfully');
        return redirect()->route('show_term', $term->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $data = TermCondition::whereId($id);

        $term = $data->first();

        return view('admin.terms.show', compact('term'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $term = TermCondition::find($id);

        return view('admin.terms.edit', compact('term'));
    }

    public function update(Request $request, $id)
    {
        $term = TermCondition::find($id);

        $validator = Validator::make($request->all(), [
            'name'       	=> 'required|string',
            'type'         	=> 'nullable'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        // if($request->has('image')){
        //     $curentPhoto    = $term->image;
        //     $image          = $request->image;
        //     $extension      = $image->getClientOriginalExtension();
        //     $imageRename    = time(). uniqid() . '.'.$extension;

        //     $path           = public_path("images\terms");

        //     if(!File::exists($path)) File::makeDirectory($path, 775, true);

        //     $img = Image::make($image)->resize(null, 700, function ($constraint) {
        //         $constraint->aspectRatio();
        //         $constraint->upsize();
        //     })->save(public_path('images/terms/').$imageRename);

        //     $upload_image   = TermCondition::where('id', $term->id)->update(['image' => $imageRename]);

        //     $userPhoto      = public_path('images/terms/').$curentPhoto;
        // }

        $term->update([
            'name'       	=> $request->name,
            'type'       	=> $request->type,
        ]);

        $success = trans('common.Updated Successfully');

        return redirect()->route('termconditions')->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');
        $term = TermCondition::find($id);
        $term->delete();
        return response()->json(['success' => 'Deleted Successfully']);
    }

    public function blockterm(Request $request)
    {
        $id = $request->id;
        $message = $request->status == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $property = TermCondition::find($id);
        $property->status = $request->status;
        $property->save();
        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
