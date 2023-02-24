<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    // project task submission list
    public function show(Project $project)
    {
        $submissions = Submission::with('grade')->where('project_id', $project->id)->get();
        return view('dashboard.submissions.index', compact('project', 'submissions'));
    }

    public function singleSubmission(Project $project, Submission $submission)
    {
        return view('dashboard.submissions.show', compact('project', 'submission'));
    }

    public function adminGrade(Request $request, Project $project, Submission $submission)
    {
        if($request->message){
            $comment = new Comment;
            $comment->student_id = $submission->student_id;
            $comment->project_id = $project->id;
            $comment->project_section_id = $submission->projectSection->id;
            $comment->read_message = 0;
            $comment->user_id = Auth::guard('web')->user()->id;
            $comment->message = $request->message;
            $comment->save();
        }
        $grade = new Grade;
        $grade->user_id = Auth::guard('web')->user()->id;
        $grade->submission_id = $submission->id;
        if($request->input('pass')){
            $grade->status = 1;
        }elseif($request->input('revision')=='revision'){
            $grade->status = 0;
        }
        $grade->save();

        // $submissions = Submission::whereHas('grade', function($q){
        //     $q->where('status',1);
        // })->where('student_id', $student_id)->get();
        // dd($submissions);
        // $submissions = Grade::where('submission_id',$submission)get();
        // dd($project_sections->count());
        // if(($submissions->count() == $project_sections->count()) && $enrolled_project_completed_or_no == 0){
        //     $success_project = EnrolledProject::where([['student_id', Auth::guard('student')->user()->id], ['project_id', $project_id]])->first();
        //     $success_project->is_submited = 1;
        //     $success_project->flag_checkpoint = $dataDate;
        //     $success_project->save();
        // }
        // return redirect('/submissions/project/'.$project->id.'/view/'.$submission->id.'/grade/'.$grade->id);
        return back();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project,Submission $submission, Grade $grade)
    {
        return view('dashboard.submissions.edit', compact('project','submission', 'grade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\form actionSubmission  $submission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Submission $submission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Submission $submission)
    {
        //
    }
}
