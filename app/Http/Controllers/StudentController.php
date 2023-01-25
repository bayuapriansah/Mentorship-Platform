<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Student;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\ProjectSection;
use App\Models\EnrolledProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $students = Student::get();
        return view('dashboard.students.index', compact('students'));
    }

    public function register($email)
    {
        $checkStudent = Student::where('email', $email)->first();
        if(!$checkStudent){
            return redirect()->route('index');
        }elseif($checkStudent){
            // @dd($checkStudent);
            return view('student.index', compact(['checkStudent']));
        }
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
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $email)
    {
        // dd($request->all());
        // dd($email);
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'state' => 'required',
            'country' => 'required',
            'institution' => 'required',
            'g-recaptcha-response' => function ($attribute, $value, $fail) {
                $secretkey = config('services.recaptcha.secret');
                $response = $value;
                $userIP = $_SERVER['REMOTE_ADDR'];
                $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$response&remoteip=$userIP";
                $response = \file_get_contents($url);
                $response = json_decode($response);
                // dd($response);
                if(!$response->success){
                    Session::flash('g-recaptcha-response', 'Google reCAPTCHA validation failed, please try again.');
                    Session::flash('alert-class', 'alert-danger');
                    $fail($attribute.'Google reCAPTCHA validation failed, please try again.');
                } 
            },
        ]);
        $student = Student::where('email',$email)->first();
        // dd($student);
        $student->first_name = $valiresult['state'];
        $student->country = $validated['country'];
        $student->institution = $validated['institution'];
        $student->is_confirm = 1;
        $student->save();
        $message = "Profile Updated";
        return redirect()->route('student.register',[$email])->with('success', $message);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
    
    // STUDENT PROFILE
    public function allProjects($id)
    {
        // dd(Auth::guard('student')->user()->id);
        if($id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $student = Student::where('id', $id)->first();
        // dd($student->created_at);
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        return view('student.index', compact('enrolled_projects', 'student','dataDate'));
    }
    
    public function ongoingProjects($id)
    {
        // dd(Auth::guard('student')->user()->id);
        if($id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->where('is_submited', 0)->get();
        $student = Student::where('id', $id)->first();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);

        
        return view('student.index', compact('enrolled_projects', 'student','dataDate'));
    }
    
    public function completedProjects($id)
    {
        // dd(Auth::guard('student')->user()->id);
        if($id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->where('is_submited', 1)->get();
        $student = Student::where('id', $id)->first();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);

        
        return view('student.index', compact('enrolled_projects', 'student', 'dataDate'));
    }

    public function enrolledDetails($student_id, $project_id)
    {
        // to handle new task if the previous task complete then the next task is show
        $submissions = Submission::where([['section_id', $project_section->id], ['student_id', Auth::guard('student')->user()->id], ['is_complete', 1]])->get();
        // end of code
        // dd($submissions);
        $student = Student::where('id', $student_id)->first();
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $project = Project::find($project_id);
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        $project_sections = ProjectSection::orderBy('id','DESC')->where('project_id', $project_id)->get();
        return view('student.project.show', compact('student','project', 'enrolled_projects' ,'project_sections', 'dataDate','submission'));
    }

    public function enrolledDetail($student_id, $project_id)
    {
        $student = Student::where('id', $student_id)->first();
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $project = Project::find($project_id);
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        $project_sections = ProjectSection::where('project_id', $project_id)->get();
        $submissions = Submission::where([['student_id', Auth::guard('student')->user()->id], ['is_complete', 1]])->get();

        return view('student.project.show', compact('student','project', 'enrolled_projects' ,'project_sections', 'dataDate','submissions'));
    }

    public function taskDetail($student_id, $project_id, $task_id)
    {
        $student = Student::where('id', $student_id)->first();
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project_id)->get();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        $task = ProjectSection::find($task_id);
        $comments = Comment::where('student_id', $student_id)->where('project_id', $project_id)->where('project_section_id', $task_id)->get();
        $submission = Submission::where('student_id',$student_id)->where('section_id', $task_id)->first();
        return view('student.project.task.index', compact('student','enrolled_projects', 'dataDate', 'task','comments', 'submission'));
    }

    public function taskSubmit(Request $request, $student_id, $project_id, $task_id)
    {
        $task = ProjectSection::find($task_id);
        // dd($task->file_type);
        if($request->hasFile('file')==true){
            $validated = $request->validate([
                'file' => ['required'],
            ]);
        }
        $submission = new Submission;
        $submission->section_id = $task_id;
        $submission->student_id = $student_id;
        $submission->is_complete = 1;
        if($request->hasFile('file')){
            $uploadedFileType = substr($request->file('file')->getClientOriginalName(), strpos($request->file('file')->getClientOriginalName(),'.')+1);
            // dd($uploadedFileType);
            if($uploadedFileType == $task->file_type && $request->file('file')->getSize() <=5000000){
                $file = Storage::disk('public')->put('projects/submission/project/'.$project_id.'/task/'.$task_id, $validated['file']);
                $submission->file = $file;
            }else{
                return redirect('/profile/'.$student_id.'/enrolled/'.$project_id.'/task/'.$task_id)->with('error', 'File extension or file size is wrong boiii');
            }
        }
        $submission->save();
        return redirect('/profile/'.$student_id.'/enrolled/'.$project_id.'/task/'.$task_id);
    }

    public function allProjectsAvailable($student_id)
    {
        $student = Student::where('id', $student_id)->first();
        $projects = Project::whereNotIn('id', function($query){
            $query->select('project_id')->from('enrolled_projects');
            $query->where('student_id',Auth::guard('student')->user()->id);
        })->where('institution_id', $student->institution_id)->where('status', 'publish')->get();
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);

        return view('student.project.available.index', compact('student','projects','enrolled_projects','dataDate'));
    }

    public function availableProjectDetail($student_id, $project_id)
    {
        if($student_id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $student = Student::where('id', $student_id)->first();
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $project = Project::find($project_id);
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);

        return view('student.project.available.show', compact('student','project','enrolled_projects', 'dataDate'));
    }
}
