<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Offer;
use App\Country;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class OfferController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            checkPermission('is_ride');
            return $next($request);
        });
    }

    public function index()
    {
        checkGate('can_show');

        $offers = Offer::paginate(20);

        return view('admin.offer.index', compact('offers'));
    }

    public function create()
    {
        checkGate('can_create');

        $results = Country::whereStatus('1');
        if (App::isLocale('ar')) {
            $results->select('id', 'name_ar as name', 'flag', 'code', 'latitude', 'longitude');
        } else {
            $results->select('id', 'name_en as name', 'flag', 'code', 'latitude', 'longitude');
        }
        $countries = $results->get();

        return view('admin.offer.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request['phone_number'] = convert($request->phone_number);

        $validator = Validator::make($request->all(), [
            'name'          => 'required|string',
            'surename'      => 'nullable|string',
            'phone'         => 'required|unique:offers,phone_number',
            'country'       => 'required',
            'image'         => 'nullable|image',
            'email'         => 'required|email|unique:offers,email',
            'password'      => 'required|confirmed'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        if($request->has('image')){
            $image          = $request->image;
            $extension      = $image->getClientOriginalExtension();
            $imageRename    = time(). uniqid() . '.'.$extension;

            $path           = public_path('images\offers');

            if(!File::exists($path)) File::makeDirectory($path, 775, true);

            $img = Image::make($image)->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path('images/offers/').$imageRename);
        } else {
            $imageRename = 'offer_default.png';
        }

        $request['password'] = bcrypt($request->password);

        $offer = Offer::create([
            'name'                  =>  $request->name,
            'image'                 =>  $imageRename,
            'phone_code'            =>  $request->country,
            'phone_number'          =>  $request->phone,
            'email'                 =>  $request->email,
            'password'              =>  $request->password,
            'offer_type'             =>  '2',
            'status'                =>  '1'
        ]);

        $offerSource = Offer::create([
            'name'                  =>  $request->name,
            'image'                 =>  $imageRename,
            'phone_code'            =>  $request->country,
            'phone_number'          =>  $request->phone,
            'offer_id'               =>  $offer->id
        ]);

        $success = trans('common.created Successfully');
        return redirect()->route('show_offer', $offer->id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $offer = Offer::find($id);

        return view('admin.offer.show', compact('offer'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $offer = Offer::find($id);

        $results = Country::whereStatus('1');
        if (App::isLocale('ar')) {
            $results->select('id', 'name_ar as name', 'flag', 'code', 'latitude', 'longitude');
        } else {
            $results->select('id', 'name_en as name', 'flag', 'code', 'latitude', 'longitude');
        }
        $countries = $results->get();

        return view('admin.offer.edit', compact('offer', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $offer = Offer::find($id);

        $request['phone_number'] = convert($request->phone_number);

        $validator = Validator::make($request->all(), [
            'name'          => 'required|string',
            'surename'      => 'nullable|string',
            'phone'         => 'required|unique:offers,phone_number,'. $id,
            'country'       => 'required',
            'image'         => 'nullable|image',
            'email'         => 'required|email|unique:offers,email,'. $id,
            'password'      => 'nullable|confirmed'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        if($request->has('image')){
            $curentPhoto    = $offer->image;
            $image          = $request->image;
            $extension      = $image->getClientOriginalExtension();
            $imageRename    = time(). uniqid() . '.'.$extension;

            $path           = public_path('images\offers');

            if(!File::exists($path)) File::makeDirectory($path, 775, true);

            $img = Image::make($image)->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path('images/offers/').$imageRename);

            $upload_image   = Offer::where('id', $offer->id)->update(['image' => $imageRename]);

            $upload_image_source   = Offer::where('offer_id', $offer->id)->update(['image' => $imageRename]);

            $offerPhoto      = public_path('images/offers/').$curentPhoto;

            if(file_exists($offerPhoto) && $curentPhoto != 'offer_default.png'){
                @unlink($offerPhoto);
            }
        }

        if($request->filled('password'))
        {
            $password = bcrypt($request->password);
            $updatePassword   = Offer::where('id', $offer->id)->update(['password' => $password]);
        }

        $offer->update([
            'name'                  =>  $request->name,
            'surename'              =>  $request->surename,
            'phone_code'            =>  $request->country,
            'phone_number'          =>  $request->phone,
            'email'                 =>  $request->email,
        ]);

        $update_offer_source = Offer::where('offer_id', $offer->id)->update([
        	'name'                  =>  $request->name,
        	'phone_code'            =>  $request->country,
            'phone_number'          =>  $request->phone
        ]);

        $success = trans('common.Updated Successfully');

        return redirect()->route('show_offer', $offer->id)->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $offer = Offer::findOrFail($id);

        $offer->delete();

        // return redirect()->route('offers');
        return response()->json(['success' => 'Deleted Successfully']);
    }

    public function blockOffer(Request $request)
    {
        $id = $request->offer_id;
        //$message = $request->type == 'block' ? 'تم الغاء التفعيل المستخدم بنجاح' : 'تم تفعيل المستخدم بنجاح';
        $message = $request->status == '0' ? trans('common.Offer is Blocked Successfully') : trans('common.Offer is Activated Successfully');
        $offer = Offer::find($id);
        $offer->status = $request->status;
        $offer->save();

        $arr = array('status' => '1', 'data' => [], 'message' => $message);
        return response()->json($arr);
    }
}
