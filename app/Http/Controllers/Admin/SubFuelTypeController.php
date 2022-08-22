<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Admin;


use App\FuelType;
use App\SubFuelType;

use App\Http\Controllers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;

use Symfony\Component\HttpFoundation\Response;

class SubFuelTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('subfueltype_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = SubFuelType::with('fuel:id,name')->get();
        // return $data;
        return view('admin.subfueltype.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_if(Gate::denies('subfueltype_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fueltype = FuelType::all();

        return view('admin.subfueltype.create', compact('fueltype'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'name' => 'bail|required|unique:sub_fuel_type|max:255',
            'fuel_type' => 'bail|required',
        ]);
        $reqData = $request->all();
        $reqData['status'] = $request->has('status') ? 1 : 0;
        SubFuelType::create($reqData);
        return redirect()->route('subfueltype.index')->withStatus(__('SubFuelType is added successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubFuelType  $subFuelType
     * @return \Illuminate\Http\Response
     */
    public function show(SubFuelType $subFuelType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubFuelType  $subFuelType
     * @return \Illuminate\Http\Response
     */
    public function edit(SubFuelType $subfueltype)
    {
        //
        abort_if(Gate::denies('subfueltype_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fueltype = FuelType::all();


        return view('admin.subfueltype.edit', compact('subfueltype', 'fueltype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubFuelType  $subFuelType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubFuelType $subfueltype)
    {
        //
        $request->validate([
            'name' => 'bail|required|max:255',
            'icon' => 'bail|sometimes|required|image',
        ]);
        $reqData = $request->all();
    
        $reqData['status'] = $request->has('status') ? 1 : 0;
        $subfueltype->update($reqData);

        return redirect()->route('subfueltype.index')->withStatus(__('SubFuelType is updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubFuelType  $subFuelType
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubFuelType $subFuelType)
    {
        //
        abort_if(Gate::denies('subfueltype_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // dd($subFuelType);
        if($subFuelType->delete()){

            return back()->withStatus(__('SubFuelType is deleted successfully.'));
        } else {
            return back()->withStatus(__('SubFuelType is not deleted successfully.'));
        }

    }
}
