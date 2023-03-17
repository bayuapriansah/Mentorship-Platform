<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\EnrolledProject;
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
            return view('dashboard.enrolled.show', compact('enrolled_projects','project', 'enrolled_projects_supervised'));

          }else{
            $enrolled_projects = EnrolledProject::where('project_id', $project_id)
                                                ->whereHas('student', function($q){
                                                    $q->where('staff_id', Auth::guard('mentor')->user()->id);
                                                })->get();
            return view('dashboard.enrolled.show', compact('enrolled_projects','project'));
          }
          
                                              
        }
        
        return view('dashboard.enrolled.show', compact('enrolled_projects','project'));
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
