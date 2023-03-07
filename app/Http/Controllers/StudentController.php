<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Grade;
use App\Models\Mentor;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Student;
use App\Models\Customer;
use App\Models\Submission;
use App\Models\Institution;
use Illuminate\Http\Request;
use App\Models\ProjectSection;
use App\Models\EnrolledProject;
use App\Models\ReadNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\InstitutionController;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::guard('web')->check()){
            $students = Student::get();
            $enrolled_projects = EnrolledProject::get();
        }elseif(Auth::guard('mentor')->check()){
            $students = Student::where('institution_id', Auth::guard('mentor')->user()->institution_id)->get();
            $enrolled_projects = EnrolledProject::get();
        }elseif(Auth::guard('customer')->check()){
            $students = EnrolledProject::whereHas('student')->get();
            $enrolled_projects = EnrolledProject::get();
        }

        // $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);

        return view('dashboard.students.index', compact('students', 'enrolled_projects'));
    }

    public function register($email)
    {
        $email = (new SimintEncryption)->decData($email);
        $regState = 0;
        $checkStudent = Student::where('email', $email)->where('is_confirm',0)->first();
        // dd($checkStudent->institution_id->institution_world_data_view);
        if(!$checkStudent){
            return redirect()->route('index');
        }elseif($checkStudent){
            $GetInstituionData = (new InstitutionController)->GetInstituionData();
            $regState = 1;
            return view('auth.register', compact(['checkStudent','GetInstituionData','regState']));
        }
    }

    public function inviteFromInstitution(Institution $institution)
    {   
        if(Route::is('dashboard.students.invite')){
            $allInstitutions = Institution::where('status',1)->get();
            return view('dashboard.students.institution.invite', compact('allInstitutions', 'institution'));
        }else{
            return view('dashboard.students.institution.invite', compact('institution'));
        }
    }

    public function sendInvite(Request $request)
    {
        // dd('tes');
        $message = "Successfully Send Invitation to Student";
        foreach (array_filter($request->email) as $email) {
            $checkStudent = Student::where('email', $email)->first();
            $checkUser = User::where('email', $email)->first(); 
            $checkMentor = Mentor::where('email', $email)->first(); 
            $checkCustomer = Customer::where('email', $email)->first(); 
            if (!$checkStudent && !$checkUser && !$checkMentor && !$checkCustomer) {
                $encEmail = (new SimintEncryption)->encData($email);
                $link = route('student.register', [$encEmail]);
                $student = $this->addStudent($email, $request->institution_id);
                $sendmail = (new MailController)->EmailStudentInvitation($student->email, $link);
                $message .= "\n$email";
            }else{
                return redirect()->back()->with('error', 'Email is already registered');
            }
        }

        return redirect()->route('dashboard.students.index')->with('successTailwind', $message);
    }

    public function sendInviteFromInstitution(Request $request, $institution_id)
    {
        $message = "Successfully Send Invitation to Student";
        foreach (array_filter($request->email) as $email) {
            $checkStudent = Student::where('email', $email)->first();
            $checkUser = User::where('email', $email)->first(); 
            $checkMentor = Mentor::where('email', $email)->first(); 
            $checkCustomer = Customer::where('email', $email)->first(); 
            if (!$checkStudent && !$checkUser && !$checkMentor && !$checkCustomer) {
                $encEmail = (new SimintEncryption)->encData($email);
                $link = route('student.register', [$encEmail]);
                $student = $this->addStudentToInstitution($email, $institution_id);
                $sendmail = (new MailController)->EmailStudentInvitation($student->email, $link);
                $message .= "\n$email";
            }else{
                return redirect()->back()->with('error', 'Email is already registered');
            }
        }

        return redirect()->route('dashboard.students.institutionStudents', ['institution' => $institution_id])->with('successTailwind', $message);
    }

    public function addStudentToInstitution($email,$institution_id)
    {
        return Student::create([
            'email' => $email,
            'institution_id' => $institution_id,
        ]);
    }

    public function addStudent($email, $institution_id)
    {
        if(Auth::guard('web')->check() || Auth::guard('customer')->check()){
            $student = Student::create([
                'email' => $email,
                'institution_id' => $institution_id,
            ]);
        }elseif(Auth::guard('mentor')->check()){
            $student = Student::create([
                'email' => $email,
                'institution_id' => Auth::guard('mentor')->user()->institution_id,
            ]);
        }
        return $student;
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

    public function manage(Institution $institution,Student $student)
    {
        $mentors = Mentor::where('institution_id', $student->institution_id)->get();
        return view('dashboard.students.edit', compact('student', 'mentors', 'institution'));
    }
    // manage students in sidebar menu
    public function manageStudent(Student $student)
    {
        $institutions = Institution::get();
        return view('dashboard.students.edit', compact('student', 'institutions'));
    }

    public function manageStudentpatch(Request $request, Student $student)
    {
        $student = Student::find($student->id);
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->date_of_birth = $request->date_of_birth;
        $student->end_date = $request->end_date;
        $student->sex = $request->sex;
        $student->institution_id = $request->institution;
        $student->country = $request->country;
        $student->state = $request->state;
        $student->email = $request->email;
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
                    $profile_picture = Storage::disk('public')->put('students/'.$student->id.'/profile_picture', $request->file('profile_picture'));
                    $student->profile_picture = $profile_picture;
                }else{
                    return redirect('/dashboard/students/'.$student->id.'/manage')->with('error', 'file extension is not png, jpg or jpeg');
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
                $profile_picture = Storage::disk('public')->put('students/'.$student->id.'/profile_picture', $request->file('profile_picture'));
                $student->profile_picture = $profile_picture;
            }else{
                return redirect('/dashboard/students/'.$student->id.'/manage')->with('error', 'file extension is not png, jpg or jpeg');
            }
        }
        $student->save();
        return redirect('/dashboard/students/')->with('successTailwind','Profile updated successfully');

    }

    public function managepatch($institution_id, $student_id, Request $request)
    {
        $student = Student::find($student_id);
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->date_of_birth = $request->date_of_birth;
        $student->end_date = $request->end_date;
        $student->sex = $request->sex;
        $student->country = $request->country;
        $student->state = $request->state;
        $student->mentor_id = $request->mentor_id;
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
                    $profile_picture = Storage::disk('public')->put('students/'.$student_id.'/profile_picture', $request->file('profile_picture'));
                    $student->profile_picture = $profile_picture;
                }else{
                    return redirect('/dashboard/institutions/'.$institution_id.'/students/'.$student_id.'/manage')->with('error', 'file extension is not png, jpg or jpeg');
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
                $profile_picture = Storage::disk('public')->put('students/'.$student_id.'/profile_picture', $request->file('profile_picture'));
                // dd($profile_picture);
                $student->profile_picture = $profile_picture;
            }else{
                return redirect('/dashboard/institutions/'.$institution_id.'/students/'.$student_id.'/manage')->with('error', 'file extension is not png, jpg or jpeg');
            }
        }
        $student->save();
        return redirect('/dashboard/institutions/'.$institution_id.'/students/')->with('successTailwind','Successfully edited student data');

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
        // $newMessage = Comment::where('student_id',$student->id)->where('read_message',0)->where('mentor_id',!NULL)->get();
        $newMessage = $this->newCommentForSidebarMenu($student->id);
        
        $newActivityNotifs = $this->newNotificationActivity($student->id);
        $notifActivityCount = $this->newNotificationActivityCount($student->id);
        $notifNewTasks = (new NotificationController)->all_notif_new_task();
        $dataMessages = (new NotificationController)->data_comment_from_admin($student->id);
        return view('student.edit', compact('student','newMessage','newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages'));
    }

    public function suspendAccountInstitution($institution_id,$student_id)
    {
        $students = Student::find($student_id);
        if($students->is_confirm==1){
            $students->is_confirm =2;
            $message = "Successfully Suspend Account";
        }elseif($students->is_confirm=2){
            $students->is_confirm =1;
            $message = "Successfully Activate Account";
        }
        $students->save();
        // return redirect('/dashboard/institutions/'.$institution_id.'/students')->with('success', $message);
        return back()->with('successTailwind', $message);
    }

    public function suspendAccount(request $request,$student_id)
    {
        $mentor = Mentor::inRandomOrder()->where('institution_id',$request->institution)->where('is_confirm',1)->first();
        $student = Student::find($student_id);
        if($student->is_confirm == 1){
            $student->is_confirm = 2;
            $message = "Successfully Deactive Account";
        }else{
            $student->is_confirm = 1;
            if($student->mentor_id == NULL){
                $student->mentor_id = $mentor->id;
            }
            if($student->end_date == NULL){
                $student->end_date = \Carbon\Carbon::now()->addMonth(4)->toDateString();
            }
            $message = "Successfully Activate Account";
        }
        $student->save();
        // return redirect('/dashboard/institutions/'.$institution_id.'/students')->with('success', $message);
        return back()->with('successTailwind', $message);
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
        // jangan lupa di validasi ya di bagian sini
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
     *
     *
     */
    public function completedRegister($email, Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'date_of_birth' => ['required'],
            'sex' => ['required'],
            'institution' => ['required'],
            'country' => ['required'],
            'state' => ['required'],
            'study_program' => ['required'],
            'year_of_study' => ['required'],
            'email' => ['required'],
            'g-recaptcha-response' => 'required|recaptcha',
            'tnc' => ['required']
        ]);

        if($validator->fails()){
            Session::flash('g-recaptcha-response', 'Google reCAPTCHA validation failed, please try again.');
            return redirect()->route('student.register',[$email])->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // to get randomly id mentors
        $mentor = Mentor::inRandomOrder()->where('institution_id',$validated['institution'])->where('is_confirm',1)->first();
        $regStudent = Student::where('email',$validated['email'])->first();
        $regStudent->first_name = $validated['first_name'];
        $regStudent->last_name = $validated['last_name'];
        $regStudent->email = $validated['email'];
        $regStudent->sex = $validated['sex'];
        $regStudent->state = $validated['state'];
        $regStudent->country = $validated['country'];
        $regStudent->date_of_birth = $validated['date_of_birth'];
        $regStudent->institution_id = $validated['institution'];
        $regStudent->study_program = $validated['study_program'];
        $regStudent->year_of_study = $validated['year_of_study'];
        // just for note, is confirm and the end_date we dont need to set in here because when we enter the route verified the is confirm and the end_date  will be handled by the route
        // $regStudent->is_confirm = 1;
        // $regStudent->end_date = \Carbon\Carbon::now()->addMonth(4)->toDateString();
        $regStudent->mentor_id = $mentor->id;
        $regStudent->save();
        $emailEnc = (new SimintEncryption)->encData($validated['email']);
        return redirect()->route('verified',[$emailEnc]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student = Student::find($student->id);
        $student->delete();
        return back()->with('error', 'Student Deleted');
    }

    // STUDENT PROFILE

    public function newNotificationActivityCount($id)
    {
        $notifActivityCounts = Submission::select('submissions.id as submission_id', 'students.id as student_id')
        ->join('grades', 'submissions.id', '=', 'grades.submission_id')
        ->join('students', 'submissions.student_id', '=', 'students.id')->where('student_id', $id)->where('readornot', 0)
        ->get();
        $notif = (new NotificationController)->count_total_all_notification_available();
        $notifActivityCount = $notifActivityCounts->count() + $notif;
        return $notifActivityCount;
    }

    public function newNotificationActivity($id)
    {
        $notifActivity = Submission::where('student_id',$id)->get();
        return $notifActivity;
    }

    public function newCommentForSidebarMenu($id)
    {
        $newMessage = Comment::where('student_id', $id)
        ->where('read_message', 0)
        ->whereHas('project')
        ->whereIn('user_id', [!null])
        ->orWhereIn('mentor_id', [!null])
        ->orWhereIn('customer_id', [!null])
        ->count();

        return $newMessage;
    }

    public function allProjects($id)
    {
        $newMessage = $this->newCommentForSidebarMenu($id);
        $newActivityNotifs = $this->newNotificationActivity($id);
        $notifActivityCount = $this->newNotificationActivityCount($id);
        $notifNewTasks = (new NotificationController)->all_notif_new_task();
        $dataMessages = (new NotificationController)->data_comment_from_admin($id);
        // dd($notifNewTask);
        // dd(Auth::guard('student')->user()->id);
        if($id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $student = Student::where('id', $id)->first();
        // dd($student->created_at);
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        return view('student.index', compact('enrolled_projects', 'student','dataDate','newMessage', 'newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages'));
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

        $newMessage = $this->newCommentForSidebarMenu($id);
        $newActivityNotifs = $this->newNotificationActivity($id);
        $notifActivityCount = $this->newNotificationActivityCount($id);
        $notifNewTasks = (new NotificationController)->all_notif_new_task();
        $dataMessages = (new NotificationController)->data_comment_from_admin($id);
        return view('student.index', compact('enrolled_projects', 'student','dataDate','newMessage', 'newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages'));
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

        $newMessage = $this->newCommentForSidebarMenu($id);
        $newActivityNotifs = $this->newNotificationActivity($id);
        $notifActivityCount = $this->newNotificationActivityCount($id);
        $notifNewTasks = (new NotificationController)->all_notif_new_task();
        $dataMessages = (new NotificationController)->data_comment_from_admin($id);
        return view('student.index', compact('enrolled_projects', 'student', 'dataDate', 'newMessage', 'newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages'));
    }

    public function enrolledDetails($student_id, $project_id)
    {
        // to handle new task if the previous task complete then the next task is show
        $submissions = Submission::where([['section_id', $project_section->id], ['student_id', Auth::guard('student')->user()->id], ['is_complete', 1]])->get();
        // end of code
        // dd($submissions);
        $submission_data = Submission::where([['section_id', $project_section->id], ['student_id', Auth::guard('student')->user()->id]])->get();
        $student = Student::where('id', $student_id)->first();
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $project = Project::find($project_id);
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        // $project_sections = ProjectSection::orderBy('id','DESC')->where('project_id', $project_id)->get();
        $project_sections = ProjectSection::orderBy('id','DESC')->where('project_id', $project_id)->get();
        // dd($project_sections);
        return view('student.project.show', compact('student','project', 'enrolled_projects' ,'project_sections', 'dataDate','submissions', 'submission_data'));
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
        // dd($project->enrolled_project->where('student_id', $student_id));
        if($project == null || $project->enrolled_project->where('student_id', $student_id)->count() == 0){
            abort(404);
        }
        
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

        // Total Task in Section
        $total_task = $project_sections->count();

        // Total task cleared
        $task_clear = $submissions->count();

        // Progress Bar for Task
        $taskProgress = (100 / $total_task) * $task_clear;
        // $newMessage = Comment::where('student_id',$student_id)->where('read_message',0)->where('mentor_id',!NULL)->get();
        $newMessage = $this->newCommentForSidebarMenu($student_id);
        $newActivityNotifs = $this->newNotificationActivity($student_id);
        $notifActivityCount = $this->newNotificationActivityCount($student_id);
        $notifNewTasks = (new NotificationController)->all_notif_new_task();
        $dataMessages = (new NotificationController)->data_comment_from_admin($student_id);
        // dd($newMessage->count());
        $submission_data = Submission::where([['project_id', $project_id], ['student_id', Auth::guard('student')->user()->id]])->get();
        
        return view('student.project.show', compact('student','project', 'enrolled_projects' ,'project_sections', 'dataDate','submissions','projectsections','taskProgress','total_task','task_clear','taskDate','newMessage','newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages','submission_data'));
    }

    public function readActivityTask($student_id, $project_id, $notification_id){
        $ReadNotification = new ReadNotification;
        $ReadNotification->student_id = $student_id;
        $ReadNotification->notifications_id = $notification_id;
        $ReadNotification->is_read = 1;
        $ReadNotification->save();
        return $this->availableProjectDetail($student_id, $project_id);
    }

    public function readActivity($student_id, $project_id, $task_id, $submission_id){
        $notif_grade_from_task = Grade::where('submission_id',$submission_id)->first();
        $notif_grade_from_task->readornot = 1;
        $notif_grade_from_task->save();
        return redirect()->route('student.taskDetail',[$student_id,$project_id,$task_id]);
    }

    public function readComment($student_id, $project_id, $task_id, $commecnt_id){
        $read_comment_from_admin = Comment::where('id', $commecnt_id)->where('read_message', 0)->first();
        $read_comment_from_admin->read_message = 1;
        $read_comment_from_admin->save();
        return redirect()->route('student.taskDetail',[$student_id,$project_id,$task_id]);
    }

    public function taskDetail($student_id, $project_id, $task_id)
    {
        if($student_id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $student = Student::where('id', $student_id)->first();
        $admins = User::get();
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        $task = ProjectSection::find($task_id);
        $comments = Comment::where('project_id', $project_id)->where('project_section_id', $task_id)->where('student_id', Auth::guard('student')->user()->id)->get();
        // $submission = Submission::get();
        $submissionData = Submission::where('student_id',$student_id)->where('section_id', $task->id)->where('is_complete',1)->first();
        $submissionId = Submission::where('student_id',$student_id)->where('section_id', $task->id)->where('is_complete',0)->first();
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
        $newMessage = $this->newCommentForSidebarMenu($student_id);
        $newActivityNotifs = $this->newNotificationActivity($student_id);
        $notifActivityCount = $this->newNotificationActivityCount($student_id);
        $notifNewTasks = (new NotificationController)->all_notif_new_task();
        $dataMessages = (new NotificationController)->data_comment_from_admin($student_id);
        return view('student.project.task.index', compact('student','enrolled_projects', 'dataDate', 'task','comments', 'submissionData','submissionId','submissions','taskProgress','total_task','task_clear','taskDate','project','newMessage','newActivityNotifs','admins','notifActivityCount','notifNewTasks','dataMessages'));
    }

    public function taskSubmit(Request $request, $student_id, $project_id, $task_id, $submission_id)
    {
        if ($request->dataset) {
            $dataset_array = json_decode($request->dataset, true);
            $dataset_values = array_column($dataset_array, 'value');
            $dataset_result = implode(';', $dataset_values);
        }
        
        // dd($request->all());

        // dd(implode(';',$request->dataset));
        // For Submission
        $project = Project::find($project_id);
        $appliedDateStart  = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->startOfDay();
        $appliedDateEnd  = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->addMonths($project->period)->startOfDay();
        $taskDate = (new SimintEncryption)->daycompare($appliedDateStart,$appliedDateEnd);
        //
        $student = Student::where('id', $student_id)->first();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        $project_sections = ProjectSection::where('project_id', $project_id)->get();
        $enrolled_project_completed_or_no = EnrolledProject::where([['student_id', Auth::guard('student')->user()->id], ['project_id', $project_id]])->first()->is_submited;
        // dd($enrolled_project_completed_or_no);
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
        $submission = Submission::find($submission_id);
        $submission->section_id = $task_id;
        $submission->student_id = $student_id;
        $submission->project_id = $project_id;
        $submission->flag_checkpoint = $taskDate;
        if($request->dataset){
            $submission->dataset = $dataset_result;
        }else{
            $submission->dataset = null;
        }
        $submission->is_complete = 1;
        if($request->hasFile('file')){
            $uploadedFileType = $request->file('file')->extension();
            if($uploadedFileType == $task->file_type && $request->file('file')->getSize() <=5000000){
                $file = Storage::disk('public')->put('projects/submission/project/'.$project_id.'/task/'.$task_id, $validated['file']);
                $submission->file = $file;
            }else{
                return redirect('/profile/'.$student_id.'/enrolled/'.$project_id.'/task/'.$task_id)->with('error', 'File extension or file size is wrong');
            }
            $submission->save();
        }else{
            return redirect('/profile/'.$student_id.'/enrolled/'.$project_id.'/task/'.$task_id)->with('error', 'Please Upload File First');
        }
        $submission_date_override = Submission::where('project_id', $project_id)->where('student_id',Auth::guard('student')->user()->id)->where('is_complete', 0)->first();
        if($submission_date_override != NULL){
            $submission_date_override->release_date = Carbon::now()->format('Y-m-d');
            $submission_date_override->save();
        }
        return redirect('/profile/'.$student_id.'/enrolled/'.$project_id.'/task/'.$task_id);
    }

    public function taskResubmit(Request $request, $student_id, $project_id, $task_id, $submission_id )
    {
        // dd($request->all());
        // dd($submission_id);
        // dataset tag implode
        if ($request->dataset) {
            $dataset_array = json_decode($request->dataset, true);
            $dataset_values = array_column($dataset_array, 'value');
            $dataset_result = implode(';', $dataset_values);
        }

        // checkpoint
        $project = Project::find($project_id);
        $appliedDateStart  = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->startOfDay();
        $appliedDateEnd  = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->addMonths($project->period)->startOfDay();
        $taskDate = (new SimintEncryption)->daycompare($appliedDateStart,$appliedDateEnd);

        $student = Student::where('id', $student_id)->first();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        $project_sections = ProjectSection::where('project_id', $project_id)->get();
        $enrolled_project_completed_or_no = EnrolledProject::where([['student_id', Auth::guard('student')->user()->id], ['project_id', $project_id]])->first()->is_submited;
        // dd($enrolled_project_completed_or_no);
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

        $submission = Submission::find($submission_id);
        $submission->flag_checkpoint = $taskDate;
        if($request->dataset){
            $submission->dataset = $dataset_result;
        }else{
            $submission->dataset = null;
        }
        // dd($dataset_result);
        if($request->hasFile('file')){

            if(Storage::path($submission->file)) {
                Storage::disk('public')->delete($submission->file);
            }

            $uploadedFileType = substr($request->file('file')->getClientOriginalName(), strpos($request->file('file')->getClientOriginalName(),'.')+1);
            if($uploadedFileType == $task->file_type && $request->file('file')->getSize() <=5000000){
                $file = Storage::disk('public')->put('projects/submission/project/'.$project_id.'/task/'.$task_id, $validated['file']);
                $submission->file = $file;
            }else{
                return redirect('/profile/'.$student_id.'/enrolled/'.$project_id.'/task/'.$task_id)->with('error', 'File extension or file size is wrong');
            }
            $submission->save();
        }else{
            return redirect('/profile/'.$student_id.'/enrolled/'.$project_id.'/task/'.$task_id)->with('error', 'Please Upload File First');
        }

        // $submissions = Submission::where([['student_id', Auth::guard('student')->user()->id] ,['project_id',$project_id], ['is_complete', 1]])->get();
        // if(($submissions->count() == $project_sections->count()) && $enrolled_project_completed_or_no == 0){
        //     $success_project = EnrolledProject::where([['student_id', Auth::guard('student')->user()->id], ['project_id', $project_id]])->first();
        //     $success_project->is_submited = 1;
        //     $success_project->flag_checkpoint = $dataDate;
        //     $success_project->save();
        // }
        $grade = Grade::where('submission_id', $submission_id)->first();
        $grade->delete();
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
                            })->where('institution_id', $student->institution_id)
                            ->where('status', 'publish')
                            ->orWhere('institution_id', null)->whereNotIn('id', function($query){
                                $query->select('project_id')->from('enrolled_projects');
                                $query->where('student_id',Auth::guard('student')->user()->id);
                            })
                            ->where('status', 'publish')
                            ->get();

        // $projects = Project::whereNotIn('id', function($query){
        //     $query->select('project_id')->from('enrolled_projects');
        //     $query->where('student_id',Auth::guard('student')->user()->id);
        // })->where('institution_id', $student->institution_id)->where('status', 'publish')->orWhere('institution_id', null)->where('status', 'publish')->get();

        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        // $newMessage = Comment::where('student_id',$student_id)->where('read_message',0)->where('mentor_id',!NULL)->get();
        $newMessage = $this->newCommentForSidebarMenu($student_id);
        $newActivityNotifs = $this->newNotificationActivity($student_id);
        $notifActivityCount = $this->newNotificationActivityCount($student_id);
        $notifNewTasks = (new NotificationController)->all_notif_new_task();
        $dataMessages = (new NotificationController)->data_comment_from_admin($student_id);
        // dd($newMessage);
        return view('student.project.available.index', compact('student','projects','enrolled_projects','dataDate','newMessage','newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages'));
    }

    public function availableProjectDetail($student_id, $project_id)
    {
        if($student_id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $student = Student::where('id', $student_id)->first();
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project_id)->get();
        $project = Project::where('status', 'publish')->find($project_id);
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        // $newMessage = Comment::where('student_id',$student_id)->where('read_message',0)->where('mentor_id',!NULL)->get();
        $newMessage = $this->newCommentForSidebarMenu($student_id);
        $newActivityNotifs = $this->newNotificationActivity($student_id);
        $notifActivityCount = $this->newNotificationActivityCount($student_id);
        $notifNewTasks = (new NotificationController)->all_notif_new_task();
        $dataMessages = (new NotificationController)->data_comment_from_admin($student_id);
        if($project){
            return view('student.project.available.show', compact('student','project','enrolled_projects', 'dataDate','newMessage','newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages'));
        }else{
            abort(404);
        }
    }
}
