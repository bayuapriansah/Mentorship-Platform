<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::get();
        return view('dashboard.companies.index', compact('companies'));
    }

    public function registered()
    {
        $companies = Company::where('is_confirm', 0)->get();
        return view('dashboard.companies.registered', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'email' => 'required',
        ]);

        $company = new Company;
        $company->name = $validated['name'];
        $company->address = $validated['address'];
        $company->email = $validated['email'];
        $company->password = Hash::make('password');
        $company->is_confirm = 1;
        $company->save();
        return redirect('dashboard/companies/')->with('success','Company has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('dashboard.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'email' => 'required',
        ]);
        
        $company = Company::find($id);
        $company->name = $validated['name'];
        $company->address = $validated['address'];
        $company->email = $validated['email'];
        $company->save();
        return redirect('dashboard/companies')->with('success','Company has been edited');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $company->delete();
        return redirect('dashboard/companies');

    }
}
