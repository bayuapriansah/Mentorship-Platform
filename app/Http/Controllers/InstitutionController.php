<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Student;
use App\Models\Institution;
use App\Models\Submission;
use App\Models\ReadNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\EnrolledProject;
use Illuminate\Support\Facades\Storage;
use App\Models\institution_world_data_view;;

class InstitutionController extends Controller
{
    public function GetInstituionData()
    {
        $GetInstitutionData = institution_world_data_view::get();
        return $GetInstitutionData;
    }

    public function GetInstituionById($id)
    {
        $GetInstitution = institution_world_data_view::where('id',$id)->first();
        return $GetInstitution;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function institutions_partners()
    {
        $institutions = institution_world_data_view::get();
        $companies = Company::get();
        
        if(Auth::guard('web')->check()){
            $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('user_id',Auth::guard('web')->user()->id)->get()->count();
            $submissionNotifications = Submission::where('is_complete', 1)
                ->whereNotIn('id', function($query) {
                    $query->select('submission_id')
                          ->from('read_notifications')
                          ->where('is_read', 1)
                          ->where('user_id', Auth::guard('web')->user()->id);
                })
                ->get();
            } elseif(Auth::guard('mentor')->check()){
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('mentor_id',Auth::guard('mentor')->user()->id)->get()->count();
                $submissionNotifications = Submission::where('is_complete', 1)
                    ->whereNotIn('id', function($query) {
                        $query->select('submission_id')
                              ->from('read_notifications')
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
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
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
        $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;
        return view('dashboard.institutions.index', compact('institutions', 'companies','totalNotificationAdmin','submissionNotifications'));
    }
    public function index()
    {
        // $institutions = Institution::get();
        $institutions = institution_world_data_view::get();
        $companies = Company::get();
        return view('dashboard.institutions.index', compact('institutions', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        if(Auth::guard('web')->check()){
            $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('user_id',Auth::guard('web')->user()->id)->get()->count();
            $submissionNotifications = Submission::where('is_complete', 1)
                ->whereNotIn('id', function($query) {
                    $query->select('submission_id')
                          ->from('read_notifications')
                          ->where('is_read', 1)
                          ->where('user_id', Auth::guard('web')->user()->id);
                })
                ->get();
            } elseif(Auth::guard('mentor')->check()){
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('mentor_id',Auth::guard('mentor')->user()->id)->get()->count();
                $submissionNotifications = Submission::where('is_complete', 1)
                    ->whereNotIn('id', function($query) {
                        $query->select('submission_id')
                              ->from('read_notifications')
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
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
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
        $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;
        $countries = (new TheWorldController)->TheWorld();
        return view('dashboard.institutions.create', compact('countries','totalNotificationAdmin','submissionNotifications'));
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
            'name' => ['required'],
            'countries' => ['required'],
            'state' => ['required'],
            'logo' => ['required'],
            'email'=>['required']
        ]);

        $institutions = new Institution;
        $institutions->name = $validated['name'];
        $institutions->email = $validated['email'];
        $institutions->country = $validated['countries'];
        $institutions->state = $validated['state'];
        if($request->hasFile('logo')){
            // 5000000
            if( $request->file('logo')->extension() =='png' && $request->file('logo')->getSize() <=5000000 ||
                $request->file('logo')->extension() =='jpg' && $request->file('logo')->getSize() <=5000000 ||
                $request->file('logo')->extension() =='jpeg' && $request->file('logo')->getSize() <=5000000
                ){
                $logo = Storage::disk('public')->put('institutions', $validated['logo']);
                $institutions->logo = $logo;
            }else{
                return redirect('dashboard/institutions_partners/')->with('error', 'file extension is not png, jpg or jpeg');
            }

        }
        $institutions->save();
        $message = "Successfully Created Institution Data";
        return redirect()->route('dashboard.institutions_partners')->with('successTailwind', $message);
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
        
        if(Auth::guard('web')->check()){
            $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('user_id',Auth::guard('web')->user()->id)->get()->count();
            $submissionNotifications = Submission::where('is_complete', 1)
                ->whereNotIn('id', function($query) {
                    $query->select('submission_id')
                          ->from('read_notifications')
                          ->where('is_read', 1)
                          ->where('user_id', Auth::guard('web')->user()->id);
                })
                ->get();
            } elseif(Auth::guard('mentor')->check()){
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('mentor_id',Auth::guard('mentor')->user()->id)->get()->count();
                $submissionNotifications = Submission::where('is_complete', 1)
                    ->whereNotIn('id', function($query) {
                        $query->select('submission_id')
                              ->from('read_notifications')
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
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
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
        $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;
        $institutions = Institution::where('id',$id)->first();
        $institutions_view = institution_world_data_view::where('id',$id)->first();
        $countries = (new TheWorldController)->TheWorld();
        return view('dashboard.institutions.edit', compact('institutions','institutions_view','id','countries','totalNotificationAdmin','submissionNotifications'));
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
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'countries' => 'required',
            'state' => 'required',
        ]);
        $institutions = Institution::where('id',$id)->first();
        $institutions->name = $validated['name'];
        $institutions->country = $validated['countries'];
        $institutions->state = $validated['state'];
        $institutions->email = $validated['email'];
        if($request->hasFile('logo')){

            if(Storage::path($institutions->logo)) {
                Storage::disk('public')->delete($institutions->logo);
            }

            // save the new image
             if( $request->file('logo')->extension() =='png' && $request->file('logo')->getSize() <=5000000 ||
                $request->file('logo')->extension() =='jpg' && $request->file('logo')->getSize() <=5000000 ||
                $request->file('logo')->extension() =='jpeg' && $request->file('logo')->getSize() <=5000000
                ){
                $logo = Storage::disk('public')->put('institutions', $request->logo);
                $institutions->logo = $logo;
            }else{
                return redirect('dashboard/institutions_partners/')->with('error', 'file extension is not png, jpg or jpeg');
            }
        }
        $institutions->save();
        $message = "Successfully Edited Institution Data";
        return redirect()->route('dashboard.institutions_partners')->with('successTailwind', $message);
    }

    public function institutionStudents(Institution $institution)
    {
        
        if(Auth::guard('web')->check()){
            $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('user_id',Auth::guard('web')->user()->id)->get()->count();
            $submissionNotifications = Submission::where('is_complete', 1)
                ->whereNotIn('id', function($query) {
                    $query->select('submission_id')
                          ->from('read_notifications')
                          ->where('is_read', 1)
                          ->where('user_id', Auth::guard('web')->user()->id);
                })
                ->get();
            } elseif(Auth::guard('mentor')->check()){
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('mentor_id',Auth::guard('mentor')->user()->id)->get()->count();
                $submissionNotifications = Submission::where('is_complete', 1)
                    ->whereNotIn('id', function($query) {
                        $query->select('submission_id')
                              ->from('read_notifications')
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
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
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
        $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;
        $students = Student::where('institution_id', $institution->id)->get();
        $enrolled_projects = EnrolledProject::get();
        return view('dashboard.institutions.students.index', compact('students', 'institution', 'enrolled_projects','totalNotificationAdmin','submissionNotifications'));
    }


    public function suspendInstitution($id)
    {
        $institution = Institution::find($id);
        // $students = Student::where('institution_id',$id)->get();
        // dd($students->is_confirm);
        if($institution->status==1){
            $institution->status = 0;
            $message = "Successfully Deactive Institution";
            Student::where('institution_id',$id)->where('is_confirm',1)->update(['is_confirm' => 2]);
        }else{
            $institution->status = 1;
            $message = "Successfully Activate Institution";
            Student::where('institution_id',$id)->where('is_confirm',2)->update(['is_confirm' => 1]);

        }
        $institution->save();
        return redirect()->route('dashboard.institutions_partners')->with('successTailwind', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institution = Institution::find($id);
        $institution->delete();
        $message = "Successfully Delete Institution";

        return redirect('dashboard/institutions')->with('errorTailwind', $message);
    }
}
