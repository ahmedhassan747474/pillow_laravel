<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CitiesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('can_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cities = City::all();

        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {
        abort_if(Gate::denies('can_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::all();

        return view('admin.cities.create', compact('countries'));
    }

    public function store(StoreCityRequest $request)
    {
        $city = City::create($request->all());

        return redirect()->route('admin.cities.index');
    }

    public function edit(City $city)
    {
        abort_if(Gate::denies('can_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $city->load('country');

        return view('admin.cities.edit', compact('countries', 'city'));
    }

    public function update(UpdateCityRequest $request, City $city)
    {
        $city->update($request->all());

        return redirect()->route('admin.cities.index');
    }

    public function show(City $city)
    {
        abort_if(Gate::denies('can_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $city->load('country');

        return view('admin.cities.show', compact('city'));
    }

    public function destroy(City $city)
    {
        abort_if(Gate::denies('can_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $city->delete();

        return back();
    }


}
