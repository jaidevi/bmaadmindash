<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LoadingText;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoadingTextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('loadingText_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = LoadingText::get();
        // return $data;
        return view('admin.loadingText.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_if(Gate::denies('loadingText_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        return view('admin.loadingText.create');
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
            'text' => 'bail|required|max:50',  
        ]);
 
     
        LoadingText::create($request->all());
        return redirect()->route('loadingtext.index')->withStatus(__('LoadingText is added successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LoadingText  $loadingText
     * @return \Illuminate\Http\Response
     */
    public function show(LoadingText $loadingText)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LoadingText  $loadingText
     * @return \Illuminate\Http\Response
     */
    public function edit(LoadingText $loadingtext)
    {
        //
        abort_if(Gate::denies('loadingText_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');



        return view('admin.loadingText.edit', compact('loadingtext'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LoadingText  $loadingText
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoadingText $loadingtext)
    {
        //
        $request->validate([
            'text' => 'bail|required|max:50',
        ]);
    
        $loadingtext->update($request->all());

        return redirect()->route('loadingtext.index')->withStatus(__('LoadingText is updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LoadingText  $loadingText
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoadingText $loadingtext)
    {
        //
        abort_if(Gate::denies('loadingText_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loadingtext->delete();

        return back()->withStatus(__('LoadingText is deleted successfully.'));
    }
    public function apiIndex()
    {
        $data = LoadingText::get(['text']);
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);

    }
}
