<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Student;
use App\Models\Submission;
use App\Models\NotifyStudent;
use Illuminate\Http\Request;
use App\Models\ProjectSection;
use App\Models\ReadNotification;
use App\Models\EnrolledProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        // if(Auth::guard('mentor')->check()){
        //   if (Auth::guard('mentor')->user()->institution_id != 0){
        //     if($project->id == 5){
        //         return back();
        //     }
        //     $submissionsSupervised = Submission::with('grade')
        //                             ->where('project_id', $project->id)
        //                             ->whereHas('student', function($q){
        //                                 $q->where('mentor_id', Auth::guard('mentor')->user()->id);
        //                             })->get();
        //     $submissions = Submission::with('grade')
        //                             ->where('project_id', $project->id)
        //                             ->whereHas('student', function($q){
        //                                 $q->where('institution_id', Auth::guard('mentor')->user()->institution_id);
        //                             })->get();
        //     return view('dashboard.submissions.index', compact('project', 'submissionsSupervised', 'submissions'));
        //   }else{
        //     $submissions = Submission::with('grade')
        //                             ->where('project_id', $project->id)
        //                             ->whereHas('student', function($q){
        //                                 $q->where('staff_id', Auth::guard('mentor')->user()->id);
        //                             })->get();
        //     return view('dashboard.submissions.index', compact('project', 'submissions'));
        //   }

        // }
        // else{
        //     $submissions = Submission::with('grade')->where('project_id', $project->id)->get();
        // }
        // return view('dashboard.submissions.index', compact('project', 'submissions'));

        return view('dashboard.submissions.index', compact('project'));
    }

    public function singleSubmission(Project $project, Submission $submission)
    {
        return view('dashboard.submissions.show', compact('project', 'submission'));
    }

    public function adminGrade(Request $request, Project $project, Submission $submission)
    {
        if (Auth::guard('mentor')->check()) {
            if($submission->student->mentor_id != Auth::guard('mentor')->user()->id && $submission->student->staff_id != Auth::guard('mentor')->user()->id){
                toastr()->error('You cannot evaluate a student whom you did not supervise');

                return back();
            }
        }
        if($request->message){
            $comment = new Comment;
            $comment->student_id = $submission->student_id;
            $comment->project_id = $project->id;
            $comment->project_section_id = $submission->projectSection->id;
            $comment->read_message = 0;
            if(Auth::guard('web')->check()){
                $comment->user_id = Auth::guard('web')->user()->id;
            }elseif(Auth::guard('mentor')->check()){
              if(Auth::guard('mentor')->user()->institution_id != 0){
                $comment->mentor_id = Auth::guard('mentor')->user()->id;
              }else{
                $comment->staff_id = Auth::guard('mentor')->user()->id;
              }
            }
            $comment->message = $request->message;
            $comment->save();
        }

        $grade = new Grade;
        if(Auth::guard('web')->check()){
            $grade->user_id = Auth::guard('web')->user()->id;
            $grader = Auth::guard('web')->user()->name;
        }elseif(Auth::guard('mentor')->check()){
            if(Auth::guard('mentor')->check()){
                $grade->mentor_id = Auth::guard('mentor')->user()->id;
                $grader = Auth::guard('mentor')->user()->name;
            }
        }
        $grade->submission_id = $submission->id;
        if($request->input('pass')){
            $grade->status = 1;
        }elseif($request->input('revision')=='revision'){
            $grade->status = 0;
        }
        $grade->save();

        $project_sections = ProjectSection::where('project_id', $project->id)->get();
        $enrolled_project_completed_or_no = EnrolledProject::where([['student_id', $submission->student->id], ['project_id', $project->id]])->first()->is_submited;
        // dd($enrolled_project_completed_or_no);

        $submissionData = Submission::whereHas('grade', function($q){
            $q->where('status',1);
        })->where('project_id', $project->id)->where('student_id', $submission->student->id)->get();
        // dd($submissionData);
        // $submissions = Grade::where('submission_id',$submission)->get();
        // dd($project_sections->count());
        $student = Student::where('id', $submission->student->id)->first();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        if(($submissionData->count() == $project_sections->count()) && $enrolled_project_completed_or_no == 0){
            $success_project = EnrolledProject::where([['student_id', $submission->student->id], ['project_id', $project->id]])->first();
            $success_project->is_submited = 1;
            $success_project->flag_checkpoint = $dataDate;
            $success_project->save();
        }
        // return redirect('/submissions/project/'.$project->id.'/view/'.$submission->id.'/grade/'.$grade->id);

        $notifyStudent = NotifyStudent::firstOrCreate(
            ['id_students' => $submission->student_id],
            ['notify_data' => ['notification' => []]] // Default as an array
        );

        $notifications = $notifyStudent->notify_data; // This is automatically an array because of the $casts attribute

        // Get the last notification's idNotify and increment by 1
        $lastNotify = end($notifications['notification']);
        $nextIdNotify = $lastNotify ? $lastNotify['idNotify'] + 1 : 1;

        $newNotification = [
            "type" => "newGrading",
            "isRead" => 0,
            "message" => $request->message, // Or use $request->message, depending on your requirements
            "idNotify" => $nextIdNotify,
            "idProject" => $project->id,
            "idSection" => $submission->projectSection->id,
            "created_at" => Carbon::now()->toDateTimeString(),
            "graderName" => $grader, // Adjust as needed
            "titleSection" => $submission->projectSection->title, // Or another relevant field
            "statusGrading" => $request->input('pass') ? "pass" : "revision" // Adjust based on your logic
        ];

        // Append the new notification
        $notifications['notification'][] = $newNotification;

        // Laravel will automatically convert this array to JSON when saving
        $notifyStudent->notify_data = $notifications;
        $notifyStudent->save();

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

    public function changeGrade(Request $request, Project $project, Submission $submission)
    {
        $changeGrade = Grade::where('submission_id', $submission->id)->firstOrFail();
        if($request->messageFeedback){
            $comment = new Comment;
            $comment->student_id = $submission->student_id;
            $comment->project_id = $project->id;
            $comment->project_section_id = $submission->projectSection->id;
            $comment->read_message = 0;
            if(Auth::guard('web')->check()){
                $comment->user_id = Auth::guard('web')->user()->id;
            }elseif(Auth::guard('mentor')->check()){
              if(Auth::guard('mentor')->user()->institution_id != 0){
                $comment->mentor_id = Auth::guard('mentor')->user()->id;
              }else{
                $comment->staff_id = Auth::guard('mentor')->user()->id;
              }
            }
            $comment->message = $request->messageFeedback;
            $comment->save();
        }
        if(!$changeGrade){
            toastr()->error('You cant do that');

            return redirect()->back();
        }else{
            $changeGrade->status = $changeGrade->status == 0 ? 1 : 0 ;
            $changeGrade->save();
        }

        $project_sections = ProjectSection::where('project_id', $project->id)->get();
        $enrolled_project_completed_or_no = EnrolledProject::where([['student_id', $submission->student->id], ['project_id', $project->id]])->first()->is_submited;
        $submissionData = Submission::whereHas('grade', function($q){
            $q->where('status',1);
        })->where('project_id', $project->id)->where('student_id', $submission->student->id)->get();
        $checkChangedGrade = Grade::where('submission_id', $submission->id)->firstOrFail();

        if($changeGrade->status == 0){
            // dd($enrolled_project_completed_or_no . " Change to Revise");
            // if(($submissionData->count() != $project_sections->count()) && 1 == 1){
            if(($submissionData->count() != $project_sections->count()) && $enrolled_project_completed_or_no == 1){
                // dd("Change to Revise & Submission Data : " . $submissionData->count(). ' Project Section : ' .$project_sections->count() . ' Enrolled Project sudah selesai atau belum : ' . $enrolled_project_completed_or_no);
                $success_project = EnrolledProject::where([['student_id', $submission->student->id], ['project_id', $project->id]])->first();
                $success_project->is_submited = 0;
                $success_project->flag_checkpoint = null;
                $success_project->save();
            }
        }elseif($changeGrade->status == 1){
            // dd($enrolled_project_completed_or_no . " Change to Pass");
            // if(($submissionData->count() == $project_sections->count()) && 0 == 0){
            if(($submissionData->count() == $project_sections->count()) && $enrolled_project_completed_or_no == 0){
                // dd("Change to Pass & Submission Data : " . $submissionData->count(). ' Project Section : ' .$project_sections->count() . ' Enrolled Project sudah selesai atau belum : ' . $enrolled_project_completed_or_no);
                $student = Student::where('id', $submission->student->id)->first();
                $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
                $success_project = EnrolledProject::where([['student_id', $submission->student->id], ['project_id', $project->id]])->first();
                $success_project->is_submited = 1;
                $success_project->flag_checkpoint = $dataDate;
                $success_project->save();
            }
        }

        toastr()->success('Success Update Grades');

        return redirect()->back();
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
