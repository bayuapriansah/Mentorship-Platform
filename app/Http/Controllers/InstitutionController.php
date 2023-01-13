<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;
use App\Models\institution_world_data_view;;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $institutionss = Institution::get();
        $institutions = institution_world_data_view::get();
        return view('dashboard.institutions.index', compact('institutions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = (new TheWorldController)->TheWorld();
        return view('dashboard.institutions.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => ['required'],
            'countries' => ['required'],
            'state' => ['required'],
            
        ]);

        $institutions = new Institution;
        $institutions->name = $validated['name'];
        $institutions->country = $validated['countries'];
        $institutions->state = $validated['state'];
        $institutions->save();
        return redirect()->route('dashboard.institutions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $institutions = Institution::where('id',$id)->first();
        $institutions_view = institution_world_data_view::where('id',$id)->first();
        $countries = (new TheWorldController)->TheWorld();
        return view('dashboard.institutions.edit', compact('institutions','institutions_view','id','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required',
            'countries' => 'required',
            'state' => 'required',
        ]);
        $institutions = Institution::where('id',$id)->first();
        // dd($institutions);
        $institutions->name = $validated['name'];
        $institutions->country = $validated['countries'];
        $institutions->state = $validated['state'];
        $institutions->save();
        $message = "Successfully Edited Institution Data";
        return redirect()->route('dashboard.institutions.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
