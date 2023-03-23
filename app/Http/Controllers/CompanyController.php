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

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::guard('web')->check()){

            $submissionNotifications = Submission::where('is_complete', 1)->whereNotIn('id', function($query) {$query->select('submission_id')->from('read_notifications')->where('type', 'submissions')->where('is_read', 1)->where('user_id', Auth::guard('web')->user()->id);})->get();
            } elseif(Auth::guard('mentor')->check()){
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('type','submissions')->where('mentor_id',Auth::guard('mentor')->user()->id)->get()->count();
                $submissionNotifications = Submission::where('is_complete', 1)
                    ->whereNotIn('id', function($query) {
                        $query->select('submission_id')
                              ->from('read_notifications')
                              ->where('type', 'submissions')
                              ->where('is_read', 1)
                              ->where('mentor_id', Auth::guard('mentor')->user()->id);
                    })
                    ->when(Auth::guard('mentor')->check(), function ($query) {
                      $query->whereIn('student_id', function($query) {
                          $query->select('id')
                              ->from('students')
                              ->where('mentor_id', Auth::guard('mentor')->user()->id);
                      });
                  })
                    ->get();
            } elseif(Auth::guard('customer')->check()){
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('type','submissions')->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
                $submissionNotifications = Submission::whereHas('project', function($q){
                  $q->where('company_id', Auth::guard('customer')->user()->company_id);
                  })
                  ->where('is_complete', 1)
                  ->whereNotIn('id', function($query) {
                      $query->select('submission_id')
                            ->from('read_notifications')
                            ->where('is_read', 1)
                            ->where('customer_id', Auth::guard('customer')->user()->id);
                  })
                  ->get();
            }
        $totalNotificationAdmin = $submissionNotifications->count();
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

        if(Auth::guard('web')->check()){

            $submissionNotifications = Submission::where('is_complete', 1)->whereNotIn('id', function($query) {$query->select('submission_id')->from('read_notifications')->where('type', 'submissions')->where('is_read', 1)->where('user_id', Auth::guard('web')->user()->id);})->get();
            } elseif(Auth::guard('mentor')->check()){
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('type','submissions')->where('mentor_id',Auth::guard('mentor')->user()->id)->get()->count();
                $submissionNotifications = Submission::where('is_complete', 1)
                    ->whereNotIn('id', function($query) {
                        $query->select('submission_id')
                              ->from('read_notifications')
                              ->where('type', 'submissions')
                              ->where('is_read', 1)
                              ->where('mentor_id', Auth::guard('mentor')->user()->id);
                    })
                    ->when(Auth::guard('mentor')->check(), function ($query) {
                      $query->whereIn('student_id', function($query) {
                          $query->select('id')
                              ->from('students')
                              ->where('mentor_id', Auth::guard('mentor')->user()->id);
                      });
                  })
                    ->get();
            } elseif(Auth::guard('customer')->check()){
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('type','submissions')->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
                $submissionNotifications = Submission::whereHas('project', function($q){
                  $q->where('company_id', Auth::guard('customer')->user()->company_id);
                  })
                  ->where('is_complete', 1)
                  ->whereNotIn('id', function($query) {
                      $query->select('submission_id')
                            ->from('read_notifications')
                            ->where('is_read', 1)
                            ->where('customer_id', Auth::guard('customer')->user()->id);
                  })
                  ->get();
            }
        $totalNotificationAdmin = $submissionNotifications->count();
        return view('dashboard.companies.create',compact('totalNotificationAdmin','submissionNotifications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->file('logo')->extension());
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'logo' => 'required'
        ]);

        $company = new Company;
        $company->name = $validated['name'];
        $company->address = $validated['address'];
        $company->email = $validated['email'];
        if($request->hasFile('logo')){
            // 5000000
            if( $request->file('logo')->extension() =='png' && $request->file('logo')->getSize() <=5000000 ||
                $request->file('logo')->extension() =='jpg' && $request->file('logo')->getSize() <=5000000 ||
                $request->file('logo')->extension() =='jpeg' && $request->file('logo')->getSize() <=5000000
                ){
                $logo = Storage::disk('public')->put('companies', $validated['logo']);
                $company->logo = $logo;
            }else{
                return back()->with('error', 'file extension is not png, jpg or jpeg');
            }

        }
        $company->save();
        return redirect('dashboard/institutions_partners/')->with('successTailwind','Partner has been added');
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

        if(Auth::guard('web')->check()){

            $submissionNotifications = Submission::where('is_complete', 1)->whereNotIn('id', function($query) {$query->select('submission_id')->from('read_notifications')->where('type', 'submissions')->where('is_read', 1)->where('user_id', Auth::guard('web')->user()->id);})->get();
            } elseif(Auth::guard('mentor')->check()){
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('type','submissions')->where('mentor_id',Auth::guard('mentor')->user()->id)->get()->count();
                $submissionNotifications = Submission::where('is_complete', 1)
                    ->whereNotIn('id', function($query) {
                        $query->select('submission_id')
                              ->from('read_notifications')
                              ->where('type', 'submissions')
                              ->where('is_read', 1)
                              ->where('mentor_id', Auth::guard('mentor')->user()->id);
                    })
                    ->when(Auth::guard('mentor')->check(), function ($query) {
                      $query->whereIn('student_id', function($query) {
                          $query->select('id')
                              ->from('students')
                              ->where('mentor_id', Auth::guard('mentor')->user()->id);
                      });
                  })
                    ->get();
            } elseif(Auth::guard('customer')->check()){
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('type','submissions')->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
                $submissionNotifications = Submission::whereHas('project', function($q){
                  $q->where('company_id', Auth::guard('customer')->user()->company_id);
                  })
                  ->where('is_complete', 1)
                  ->whereNotIn('id', function($query) {
                      $query->select('submission_id')
                            ->from('read_notifications')
                            ->where('is_read', 1)
                            ->where('customer_id', Auth::guard('customer')->user()->id);
                  })
                  ->get();
            }
        $totalNotificationAdmin = $submissionNotifications->count();
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
        if($request->hasFile('logo')){

            if(Storage::path($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }

            // save the new image
             if( $request->file('logo')->extension() =='png' && $request->file('logo')->getSize() <=5000000 ||
                $request->file('logo')->extension() =='jpg' && $request->file('logo')->getSize() <=5000000 ||
                $request->file('logo')->extension() =='jpeg' && $request->file('logo')->getSize() <=5000000
                ){
                $logo = Storage::disk('public')->put('companies', $request->logo);
                $company->logo = $logo;
            }else{
                return redirect('dashboard/institutions_partners/')->with('error', 'file extension is not png, jpg or jpeg');
            }
        }
        $company->save();
        return redirect('dashboard/institutions_partners')->with('successTailwind','Partner has been edited');

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
        return redirect('dashboard/institutions')->with('successTailwind','Partner has been deleted');
    }
}
