<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\myGallary;
use Illuminate\Support\Facades\Validator;
Use Image;;
use Illuminate\Support\Facades\File;

class GallaryController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         checkPermission('is_gallary');
    //         return $next($request);
    //     });
    // }

    public function index()
    {
        checkGate('can_show');

        $gallary = myGallary::orderBy('id', 'desc');

        $gallaries = $gallary->paginate(20);

        return view('admin.gallary.index', compact('gallaries'));
    }

    public function create()
    {
        checkGate('can_create');

        return view('admin.gallary.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         	=> 'required',
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        if($request->has('name')){
            foreach ($request->name as $image) {
                $extension      = $image->getClientOriginalExtension();
                $imageRename    = time(). uniqid() . '.'.$extension;

                $path           = public_path("images\gallary");

                if(!File::exists($path)) File::makeDirectory($path, 775, true);

                $img = Image::make($image)->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(public_path('images/gallary/').$imageRename);

                $gallary = myGallary::create([
                    'name' 			=> 'images/gallary/'.$imageRename,
                ]);
            }
        }

        $success = trans('common.created Successfully');
        $gallaries = $gallary->paginate(20);

        return view('admin.gallary.index', compact('gallaries'));
    }

    public function show($id)
    {
        checkGate('can_show');

        $data = myGallary::whereId($id);
        $gallary = $data->first();

        return view('admin.gallary.show', compact('gallary'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $gallary = myGallary::find($id);

        return view('admin.gallary.edit', compact('gallary'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $gallary = myGallary::find($id);

        $gallary->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }

    public function blockgallary(Request $request)
    {
        $id = $request->id;
        $message = $request->status == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $gallary = myGallary::find($id);
        $gallary->status = $request->status;
        $gallary->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }

    public function backgroundgallary(Request $request)
    {
        $id = $request->id;
        $message = $request->background == '0' ? trans('common.Blocked Successfully') : trans('common.Activated Successfully');
        $gallary = myGallary::find($id);
        $gallary->background = $request->background;
        $gallary->save();

        $arr = array('background' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
