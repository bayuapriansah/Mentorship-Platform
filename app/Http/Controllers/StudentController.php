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
    public function __construct()
    {
        $this->middleware('auth');
    }
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
        if($student->id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $student = Student::find($student->id);
        $newMessage = Comment::where('student_id',$student->id)->where('read_message',0)->where('mentor_id',!NULL)->get();

        return view('student.edit', compact('student','newMessage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        // dd($request->all());
        $student = Student::find($id);
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->date_of_birth = $request->date_of_birth;
        $student->sex = $request->sex;
        $student->country = $request->country;
        $student->state = $request->state;
        if($request->study_program =='other'){
            $student->study_program = $request->study_program_form;
        }else{
            $student->study_program = $request->study_program;
        }
        $student->year_of_study = $request->year_of_study;
        if($request->hasFile('profile_picture')){
            if($student->profile_picture == null){
                if( $request->file('profile_picture')->extension() =='png' && $request->file('profile_picture')->getSize() <=5000000 || 
                $request->file('profile_picture')->extension() =='jpg' && $request->file('profile_picture')->getSize() <=5000000 ||
                $request->file('profile_picture')->extension() =='jpeg' && $request->file('profile_picture')->getSize() <=5000000
                ){
                    $profile_picture = Storage::disk('public')->put('students/'.$id.'/profile_picture', $request->file('profile_picture'));
                    $student->profile_picture = $profile_picture;
                }else{
                    return redirect('/profile/'.$id.'/edit')->with('error', 'file extension is not png, jpg or jpeg');
                }
            }
            
            // save the new image
             if( $request->file('profile_picture')->extension() =='png' && $request->file('profile_picture')->getSize() <=5000000 || 
                $request->file('profile_picture')->extension() =='jpg' && $request->file('profile_picture')->getSize() <=5000000 ||
                $request->file('profile_picture')->extension() =='jpeg' && $request->file('profile_picture')->getSize() <=5000000
                ){
                if(Storage::path($student->profile_picture)) {
                    Storage::disk('public')->delete($student->profile_picture);
                }
                $profile_picture = Storage::disk('public')->put('students/'.$id.'/profile_picture', $request->file('profile_picture'));
                $student->profile_picture = $profile_picture;
            }else{
                return redirect('/profile/'.$id.'/edit')->with('error', 'file extension is not png, jpg or jpeg');
            }
        }
        $student->save();
        return redirect('/profile/'.$id.'/edit')->with('successTailwind','Profile updated successfully');

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
        // dd($id);
        $newMessage = Comment::where('student_id',$id)->where('read_message',0)->where('mentor_id',!NULL)->get();
        // dd($newMessage);
        // dd(Auth::guard('student')->user()->id);
        if($id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $student = Student::where('id', $id)->first();
        // dd($student->created_at);
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        return view('student.index', compact('enrolled_projects', 'student','dataDate','newMessage'));
    }
    
    public function ongoingProjects($id)
    {
        // dd(Auth::guard('student')->user()->id);
        if($id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $student = Student::where('id', $id)->first();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);

        $newMessage = Comment::where('student_id',$id)->where('read_message',0)->where('mentor_id',!NULL)->get();
        return view('student.index', compact('enrolled_projects', 'student','dataDate','newMessage'));
    }
    
    public function completedProjects($id)
    {
        // dd(Auth::guard('student')->user()->id);
        if($id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $student = Student::where('id', $id)->first();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);

        $newMessage = Comment::where('student_id',$id)->where('read_message',0)->where('mentor_id',!NULL)->get();
        return view('student.index', compact('enrolled_projects', 'student', 'dataDate', 'newMessage'));
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
        if($student_id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $student = Student::where('id', $student_id)->first();
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $project = Project::find($project_id);
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        $project_sections = ProjectSection::where('project_id', $project_id)->get();
        // dd($project_sections);
        $appliedDateStart  = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->startOfDay();
        $appliedDateEnd  = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->addMonths($project->period)->startOfDay();
        $taskDate = (new SimintEncryption)->daycompare($appliedDateStart,$appliedDateEnd);
        
        // To Check if there's data in submission inputed from Project_section
        // $submissions = Submission::where([['student_id', Auth::guard('student')->user()->id], ['is_complete', 1]])->get();
        $submissions = Submission::where([['student_id', Auth::guard('student')->user()->id] ,['project_id',$project_id], ['is_complete', 1]])->get();

        // To Check if The Project_Section not in the Submission Table then Show the data but limit data to only One
        $projectsections = ProjectSection::where('project_id', $project_id)->whereDoesntHave('submissions', function($query) use ($student_id){$query->where('student_id', $student_id);})->take(1)->get();
// dd($projectsections);
        // Change is_submited in enrolled_project
        // dd($submissions);

        if($submissions->count() == $project_sections->count()){
            $success_project = EnrolledProject::where([['student_id', Auth::guard('student')->user()->id], ['project_id', $project_id]])->first();
            $success_project->is_submited = 1;
            $success_project->flag_checkpoint = $dataDate;
            $success_project->save();
        }
        
        // Total Task in Section
        $total_task = $project_sections->count();

        // Total task cleared
        $task_clear = $submissions->count();

        // Progress Bar for Task
        $taskProgress = (100 / $total_task) * $task_clear;
        $newMessage = Comment::where('student_id',$student_id)->where('read_message',0)->where('mentor_id',!NULL)->get();
        // dd($newMessage->count());
        return view('student.project.show', compact('student','project', 'enrolled_projects' ,'project_sections', 'dataDate','submissions','projectsections','taskProgress','total_task','task_clear','taskDate','newMessage'));
    }

    public function taskDetail($student_id, $project_id, $task_id)
    {
        if($student_id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $student = Student::where('id', $student_id)->first();
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        $task = ProjectSection::find($task_id);
        $comments = Comment::where('project_id', $project_id)->where('project_section_id', $task_id)->get();
        $submission = Submission::where('student_id',$student_id)->where('section_id', $task_id)->first();
        $project = Project::find($project_id);
        $appliedDateStart  = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->startOfDay();
        $appliedDateEnd  = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->addMonths($project->period)->startOfDay();
        $taskDate = (new SimintEncryption)->daycompare($appliedDateStart,$appliedDateEnd);

        // The prerequisite for count task progress
        $project_sections = ProjectSection::where('project_id', $project_id)->get();
        $submissions = Submission::where([['student_id', Auth::guard('student')->user()->id] ,['project_id',$project_id], ['is_complete', 1]])->get();
        
        // Total Task in Section
        $total_task = $project_sections->count();
        // Total task cleared
        $task_clear = $submissions->count();
        // Progress Bar for Task
        $taskProgress = (100 / $total_task) * $task_clear;
        // dd($taskProgress);
        $newMessage = Comment::where('student_id',$student_id)->where('read_message',0)->where('mentor_id',!NULL)->get();
        return view('student.project.task.index', compact('student','enrolled_projects', 'dataDate', 'task','comments', 'submission','taskProgress','total_task','task_clear','taskDate','project','newMessage'));
    }

    public function taskSubmit(Request $request, $student_id, $project_id, $task_id)
    {
        if($student_id != Auth::guard('student')->user()->id ){
            abort(403);
        }
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
        $submission->project_id = $project_id;
        $submission->is_complete = 1;
        if($request->hasFile('file')){
            $uploadedFileType = substr($request->file('file')->getClientOriginalName(), strpos($request->file('file')->getClientOriginalName(),'.')+1);
            // dd($uploadedFileType);
            if($uploadedFileType == $task->file_type && $request->file('file')->getSize() <=5000000){
                $file = Storage::disk('public')->put('projects/submission/project/'.$project_id.'/task/'.$task_id, $validated['file']);
                $submission->file = $file;
            }else{
                return redirect('/profile/'.$student_id.'/enrolled/'.$project_id.'/task/'.$task_id)->with('error', 'File extension or file size is wrong');
            }
        }
        $submission->save();
        return redirect('/profile/'.$student_id.'/enrolled/'.$project_id.'/task/'.$task_id);
    }

    public function allProjectsAvailable($student_id)
    {
        if($student_id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $student = Student::where('id', $student_id)->first();
        $projects = Project::whereNotIn('id', function($query){
            $query->select('project_id')->from('enrolled_projects');
            $query->where('student_id',Auth::guard('student')->user()->id);
        })->where('institution_id', $student->institution_id)->where('status', 'publish')->get();
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        $newMessage = Comment::where('student_id',$student_id)->where('read_message',0)->where('mentor_id',!NULL)->get();
        // dd($newMessage);
        return view('student.project.available.index', compact('student','projects','enrolled_projects','dataDate','newMessage'));
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
        $newMessage = Comment::where('student_id',$student_id)->where('read_message',0)->where('mentor_id',!NULL)->get();
        return view('student.project.available.show', compact('student','project','enrolled_projects', 'dataDate','newMessage'));
    }
}
