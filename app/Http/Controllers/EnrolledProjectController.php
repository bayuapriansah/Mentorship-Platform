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
        $decId = decData($project_id);
        $project = Project::find($decId);

        if (!$project) {
            abort(404, 'Project not found');
        }

        return view('dashboard.enrolled.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EnrolledProject  $enrolledProject
     * @return \Illuminate\Http\Response
     */
    public function edit($enrolled_projects_id, $student_id, $project_id)
    {
        // dd($enrolled_projects_id.', '.$student_id.', '.$project_id);
        $enrolled_projects = EnrolledProject::where('id', $enrolled_projects_id)->firstOrFail();
        $project = Project::findOrFail($project_id);
        $appliedDateStart = \Carbon\Carbon::parse(
            $project
                ->enrolled_project
                ->where('student_id', $student_id)
                ->where('project_id', $project->id)
                ->first()
                ->created_at
        )->startOfDay();
        $appliedDateEnd = \Carbon\Carbon::parse(
            $project
                ->enrolled_project
                ->where('student_id', $student_id)
                ->where('project_id', $project->id)
                ->first()
                ->created_at
        )->addMonths($project->period)->startOfDay();
        $taskDate = (new SimintEncryption())->daycompare(
            $appliedDateStart,
            $appliedDateEnd
        );

        if($enrolled_projects->is_submited != 1){
            $enrolled_projects->is_submited = 1;
            $enrolled_projects->flag_checkpoint=$taskDate;
            $enrolled_projects->save();
        }
        session()->flash('success', 'The project was successfully updated!');

        return redirect()->route('dashboard.enrollment.show', $project_id);
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
