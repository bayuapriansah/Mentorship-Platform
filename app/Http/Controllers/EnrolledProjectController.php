<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\EnrolledProject;
use App\Models\Submission;
use App\Models\ReadNotification;
use Illuminate\Support\Facades\Auth;

class EnrolledProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EnrolledProject  $enrolledProject
     * @return \Illuminate\Http\Response
     */
    public function show($project_id)
    {

        if(Auth::guard('web')->check()){
            $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('user_id',Auth::guard('web')->user()->id)->get()->count();
            $submissionNotifications = Submission::where('is_complete', 1)
                ->whereNotIn('id', function($query) {
                    $query->select('submission_id')
                          ->from('read_notifications')
                          ->where('type', 'submissions')
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
        $project = Project::find($project_id);
        $enrolled_projects = EnrolledProject::where('project_id', $project_id)->get();
        if (Auth::guard('mentor')->check()) {
          if (Auth::guard('mentor')->user()->institution_id != 0){
            $enrolled_projects = EnrolledProject::where('project_id', $project_id)
                                                ->whereHas('student', function($q){
                                                    $q->where('institution_id', Auth::guard('mentor')->user()->institution_id);
                                                })->get();
            $enrolled_projects_supervised = EnrolledProject::where('project_id', $project_id)
                                                ->whereHas('student', function($q){
                                                    $q->where('mentor_id', Auth::guard('mentor')->user()->id);
                                                })->get();
            return view('dashboard.enrolled.show', compact('enrolled_projects','project', 'enrolled_projects_supervised','totalNotificationAdmin','submissionNotifications'));

          }else{
            $enrolled_projects = EnrolledProject::where('project_id', $project_id)
                                                ->whereHas('student', function($q){
                                                    $q->where('staff_id', Auth::guard('mentor')->user()->id);
                                                })->get();
            return view('dashboard.enrolled.show', compact('enrolled_projects','project','totalNotificationAdmin','submissionNotifications'));
          }


        }

        return view('dashboard.enrolled.show', compact('enrolled_projects','project','totalNotificationAdmin','submissionNotifications'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EnrolledProject  $enrolledProject
     * @return \Illuminate\Http\Response
     */
    public function edit(EnrolledProject $enrolledProject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EnrolledProject  $enrolledProject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EnrolledProject $enrolledProject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EnrolledProject  $enrolledProject
     * @return \Illuminate\Http\Response
     */
    public function destroy(EnrolledProject $enrolledProject)
    {
        //
    }
}
