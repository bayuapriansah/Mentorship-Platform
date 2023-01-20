<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Project;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\ProjectSection;
use App\Models\EnrolledProject;
use Illuminate\Support\Facades\Auth;

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

    public function enrolledDetail($student_id, $project_id)
    {
        // dd($project_id);
        $student = Student::where('id', $student_id)->first();
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $project = Project::find($project_id);
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        $project_sections = ProjectSection::where('project_id', $project_id)->get();
        return view('student.project.show', compact('student','project', 'enrolled_projects' ,'project_sections', 'dataDate'));
    }

    public function taskDetail($student_id, $project_id, $task_id)
    {
        // dd($project_id);
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->where('project_id',$project_id)->get();
        $check_enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->where('project_id',$project_id)->first();
        if ($check_enrolled_projects) {
            // dd($enrolled_projects);
            $student = Student::where('id', $student_id)->first();
            $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
            $task = ProjectSection::find($task_id);
            return view('student.project.task.index', compact('student','enrolled_projects', 'dataDate', 'task'));
        }
        return redirect()->route('student.allProjects',[$student_id]);
    }

    public function allProjectsAvailable($student_id)
    {
        $student = Student::where('id', $student_id)->first();
        $projects = Project::whereNotIn('id', function($query){
            $query->select('project_id')->from('enrolled_projects');
            $query->where('student_id',Auth::guard('student')->user()->id);
        })->where('institution_id', $student->institution)->where('status', 'publish')->get();
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
