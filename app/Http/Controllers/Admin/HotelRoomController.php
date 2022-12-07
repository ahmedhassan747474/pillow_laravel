<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Property;
use App\PropertyImage;
use App\PropertyAttribute;
use App\Country;
use App\City;
use App\Attribute;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use App\Transformers\Admin\PropertyTransformer;

class HotelRoomController extends BaseController
{
    function __construct(PropertyTransformer $property_transformer) 
    {
        $this->property_transformer = $property_transformer;

        $this->middleware(function ($request, $next) {
            checkPermission('is_hotel');
            return $next($request);
        });
    }

    public function index($id)
    {
        checkGate('can_show');

        $rooms = Property::whereType('10')->whereParentId($id)->orderBy('id', 'desc')->paginate(20);

        $rooms = $this->property_transformer->transformCollection($rooms->getCollection());

        $data = Property::whereType('10')->whereParentId($id)->orderBy('id', 'desc')->paginate(20);

        return view('admin.hotel_room.index', compact('rooms', 'data', 'id'));
    }

    public function create($id)
    {
        checkGate('can_create');

        $attribute = Attribute::whereStatus('1');
        if (App::isLocale('ar')) {
            $attribute->select('id', 'name_ar as name');
        } else {
            $attribute->select('id', 'name_en as name');
        }
        $attributes = $attribute->get();
        
        return view('admin.hotel_room.create', compact('attributes', 'id'));
    }

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            'refund_ar'         => 'required|string',
            'refund_en'         => 'required|string',
            'payment_receipt_ar'=> 'required|string',
            'payment_receipt_en'=> 'required|string',
            'include_ar'        => 'required|string',
            'include_en'        => 'required|string',
            'images'         	=> 'required|array',
            'attributes'        => 'required|array',
            'num_of_adult'      => 'required',
            'num_of_child'      => 'required',
            'num_of_bed'        => 'required',
            'price'      		=> 'required',
            'discount'			=> 'nullable',
            'discount_type'		=> 'nullable|in:percent,price',
            'size'				=> 'required',
            'per'				=> 'required'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }
                        
        $room = Property::create([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'refund_ar'         => $request->refund_ar,
            'refund_en'         => $request->refund_en,
            'payment_receipt_ar'=> $request->payment_receipt_ar,
            'payment_receipt_en'=> $request->payment_receipt_en,
            'include_ar'        => $request->include_ar,
            'include_en'        => $request->include_en,
            'num_of_adult'      => $request->num_of_adult,
            'num_of_child'      => $request->num_of_child,
            'num_of_bed'        => $request->num_of_bed,
            'price'      		=> $request->price,
            'discount'			=> $request->discount,
            'discount_type'		=> $request->discount_type,
            'size'				=> $request->size,
            'per'				=> $request->per,
            'type'				=> '10',
            'status'			=> '1',
            'parent_id'         => $id
        ]);

        if($request->has('images')){
            foreach ($request->images as $image)
            {
                $roomImage = PropertyImage::create([
                    'name'          => $image,
                    'property_id'   => $room->id
                ]);
            }
        }

        if($request['attributes']){
            foreach ($request['attributes'] as $key => $value)
            {
                $roomAttribute = PropertyAttribute::create([
                    'attribute_id'      => $key,
                    'property_id'       => $room->id
                ]);
            }
        }

        $success = trans('common.created Successfully');
        return redirect()->route('hotel_room', $id)->with('success', $success);
    }

    public function show($id)
    {
        checkGate('can_show');

        $room = Property::find($id);

        $room = $this->property_transformer->transform($room);

        $attribute = Attribute::whereStatus('1');
        if (App::isLocale('ar')) {
            $attribute->select('id', 'name_ar as name');
        } else {
            $attribute->select('id', 'name_en as name');
        }
        $attributes = $attribute->get();

        return view('admin.hotel_room.show', compact('room', 'attributes'));
    }

    public function edit($id)
    {
        checkGate('can_edit');

        $room = Property::find($id);

        $attribute = Attribute::whereStatus('1');
        if (App::isLocale('ar')) {
            $attribute->select('id', 'name_ar as name');
        } else {
            $attribute->select('id', 'name_en as name');
        }
        $attributes = $attribute->get();
        
        return view('admin.hotel_room.edit', compact('room', 'attributes'));
    }

    public function update(Request $request, $id)
    {
        $room = Property::find($id);

        $validator = Validator::make($request->all(), [
            'name_en'       	=> 'required|string',
            'name_ar'       	=> 'required|string',
            'refund_ar'         => 'required|string',
            'refund_en'         => 'required|string',
            'payment_receipt_ar'=> 'required|string',
            'payment_receipt_en'=> 'required|string',
            'include_ar'        => 'required|string',
            'include_en'        => 'required|string',
            'images'         	=> 'required|array',
            'attributes'        => 'required|array',
            'num_of_adult'      => 'required',
            'num_of_child'      => 'required',
            'num_of_bed'        => 'required',
            'price'             => 'required',
            'discount'          => 'nullable',
            'discount_type'     => 'nullable|in:percent,price',
            'size'              => 'required',
            'per'               => 'required'
        ]);

        if($validator->fails()) 
        {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput($request->all())->with('error', $error);
        }

        $room->update([
            'name_en'       	=> $request->name_en,
            'name_ar'       	=> $request->name_ar,
            'refund_ar'         => $request->refund_ar,
            'refund_en'         => $request->refund_en,
            'payment_receipt_ar'=> $request->payment_receipt_ar,
            'payment_receipt_en'=> $request->payment_receipt_en,
            'include_ar'        => $request->include_ar,
            'include_en'        => $request->include_en,
            'num_of_adult'      => $request->num_of_adult,
            'num_of_child'      => $request->num_of_child,
            'num_of_bed'        => $request->num_of_bed,
            'price'             => $request->price,
            'discount'          => $request->discount,
            'discount_type'     => $request->discount_type,
            'size'              => $request->size,
            'per'               => $request->per,
        ]);

        if($request->has('images')){
            $deleteAllImages = PropertyImage::wherePropertyId($id)->delete();
            foreach ($request->images as $image)
            {
                $roomImage = PropertyImage::create([
                    'name'          => $image,
                    'property_id'   => $room->id
                ]);
            }
        }

        if($request['attributes']){
            $deleteAllAttributes = PropertyAttribute::wherePropertyId($id)->delete();
            foreach ($request['attributes'] as $key => $value)
            {
                $roomAttribute = PropertyAttribute::create([
                    'attribute_id'      => $key,
                    'property_id'       => $room->id
                ]);
            }
        }
        
        $success = trans('common.Updated Successfully');

        return redirect()->route('hotel_room', $room->parent_id)->with('success', $success);
    }

    public function destroy($id)
    {
        checkGate('can_delete');

        $room = Property::findOrFail($id);

        $room->delete();

        return response()->json(['success' => 'Deleted Successfully']);
    }
}
