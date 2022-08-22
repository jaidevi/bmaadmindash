<?php

namespace App\Http\Controllers\Admin;


use App\FuelType;
use App\Http\Controllers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubFuelType;
use Gate;

use Symfony\Component\HttpFoundation\Response;


class FuelTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        //   $coder   = new CoderController;
        //     if (method_exists($coder, 'realityCheck')) {
        //         $coder->realityCheck();
        //     }

        //  && method_exists('foo')

        abort_if(Gate::denies('fuelType_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fueltype = FuelType::all();

        return view('admin.fueltype.index', compact('fueltype'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_if(Gate::denies('fuelType_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        return view('admin.fueltype.create');
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
            'name' => 'bail|required|unique:fuel_type|max:255',
            'icon' => 'bail|required|image',
        ]);
        $reqData = $request->all();
        if ($request->icon && $request->icon != "undefined") {
            $reqData['icon'] = (new AppHelper)->saveImage($request);
        }
        $reqData['is_trending'] = $request->has('is_trending') ? 1 : 0;
        $reqData['status'] = $request->has('status') ? 1 : 0;
        FuelType::create($reqData);
        return redirect()->route('fueltype.index')->withStatus(__('FuelType is added successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FuelType  $fuelType
     * @return \Illuminate\Http\Response
     */
    public function show(FuelType $fuelType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FuelType  $fuelType
     * @return \Illuminate\Http\Response
     */
    public function edit(FuelType $fueltype)
    {
        //
        abort_if(Gate::denies('fuelType_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        return view('admin.fueltype.edit', compact('fueltype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FuelType  $fuelType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FuelType $fueltype)
    {
        //
        $request->validate([
            'name' => 'bail|required|max:255',
            'icon' => 'bail|sometimes|required|image',
        ]);
        $reqData = $request->all();
        if ($request->icon && $request->icon != "undefined") {
            $reqData['icon'] = (new AppHelper)->saveImage($request);
        }
        $reqData['is_trending'] = $request->has('is_trending') ? 1 : 0;
        $reqData['status'] = $request->has('status') ? 1 : 0;
        $fueltype->update($reqData);

        return redirect()->route('fueltype.index')->withStatus(__('FuelType is updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FuelType  $fuelType
     * @return \Illuminate\Http\Response
     */
    public function destroy(FuelType $fuelType)
    {
        //
        abort_if(Gate::denies('fuelType_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fuelType->delete();

        return back()->withStatus(__('FuelType is deleted successfully.'));
    }

    public function apiIndex()
    {
        $fueltype = FuelType::where('status', 1)->orderBy('name', 'asc')->get();

        return response()->json(['msg' => null, 'data' => $fueltype, 'success' => true], 200);
    }
    public function subFuelType($id)
    {
        $fueltype= SubFuelType::where([['fuel_type', $id], ['status', 1]])->get();
        // $fueltype = FuelType::where('status', 1)->orderBy('name', 'asc')->get();

        return response()->json(['msg' => null, 'data' => $fueltype, 'success' => true], 200);
    }
}
