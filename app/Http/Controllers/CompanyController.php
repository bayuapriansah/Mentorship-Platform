<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use App\Models\Submission;
use App\Models\ReadNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Support\Facades\Log;

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
        return view('dashboard.partners.index', compact('companies'));
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
    public function store(StoreCompanyRequest $request)
    {
        $validated = $request->validated();
    
        $company = new Company;
        $company->name = $validated['name'];
        $company->address = $validated['address'];
        $company->email = $validated['email'];
    
        if ($request->hasFile('logo')) {
            $logo = $this->uploadLogo($request->file('logo'));
            $company->logo = $logo;
        }
    
        $company->save();
        return redirect('dashboard/institutions_partners/')->with('successTailwind', 'Partner has been added');
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
    public function edit($id)
    {
        $company= Company::find($id);
        return view('dashboard.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateCompanyRequest $request)
    {
        $validated = $request->validated();
    
        $company = Company::find($id);
        $company->name = $validated['name'];
        $company->address = $validated['address'];
        $company->email = $validated['email'];
    
        if ($request->hasFile('logo')) {
            if (Storage::path($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }
    
            $logo = $this->uploadLogo($request->file('logo'));
            $company->logo = $logo;
        }
    
        $company->save();
        return redirect('dashboard/institutions_partners')->with('successTailwind', 'Partner has been edited');
    }
    
    // Upload Logo Function
    private function uploadLogo($logo)
    {
        return Storage::disk('public')->put('companies', $logo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect('dashboard/institutions')->with('successTailwind', 'Partner has been deleted');
    }
}
