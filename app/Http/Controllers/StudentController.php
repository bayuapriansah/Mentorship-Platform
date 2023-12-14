<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Grade;
use App\Models\Mentor;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Student;
use App\Models\Feedback;
use App\Mail\MailNotify;
use App\Models\Customer;
use App\Models\Submission;
use App\Models\Institution;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ProjectSection;
use App\Models\EnrolledProject;
use App\Models\ReadNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\InstitutionController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use PhpParser\Node\Stmt\Break_;
use setasign\Fpdi\Fpdi;

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
// 1st code refactor
    // public function index()
    // {
    //     if(Auth::guard('web')->check()){
    //         $students = Student::get();
    //         $enrolled_projects = EnrolledProject::get();
    //     }elseif(Auth::guard('mentor')->check()){
    //         if(Auth::guard('mentor')->user()->institution_id != 0){
    //           $students = Student::where('institution_id', Auth::guard('mentor')->user()->institution_id)->get();
    //         }else{
    //           $students = Student::where('staff_id', Auth::guard('mentor')->user()->id)->get();
    //         }
    //         $enrolled_projects = EnrolledProject::get();
    //     }elseif(Auth::guard('customer')->check()){
    //         $students = Student::whereHas('enrolled_projects', function($q){
    //           $q->whereHas('project', function($q){
    //             $q->where('company_id', Auth::guard('customer')->user()->company_id);
    //           });
    //         })->get();
    //         $enrolled_projects = EnrolledProject::get();
    //     }

    //     return view('dashboard.students.index', compact('students', 'enrolled_projects'));
    // }
    public function index()
    {
        // Using a ternary operator to keep it more readable and less repetitive.
        $guard = Auth::guard('web')->check() ? 'web' :
                 (Auth::guard('mentor')->check() ? 'mentor' :
                 (Auth::guard('customer')->check() ? 'customer' : null));

        switch ($guard) {
            case 'web':
                $students = Student::get();
                break;
            case 'mentor':
                $mentor = Auth::guard('mentor')->user();
                $students = ($mentor->institution_id != 0)
                    ? Student::where('institution_id', $mentor->institution_id)->get()
                    : Student::where('staff_id', $mentor->id)->get();
                break;
            case 'customer':
                $companyId = Auth::guard('customer')->user()->company_id;
                $students = Student::whereHas('enrolled_projects', function ($q) use ($companyId) {
                    $q->whereHas('project', function ($q) use ($companyId) {
                        $q->where('company_id', $companyId);
                    });
                })->get();
                break;
            default:
                // Handle case when no guard is active (optional, but good for completeness)
                abort(403, 'Unauthorized action.');
                break;
        }

        $enrolled_projects = EnrolledProject::get();

        return view('dashboard.students.index', compact('students', 'enrolled_projects'));
    }
    // End of refactor first code

    // 2nd code refactor
    // public function testimonial(){
    //     if(!Auth::guard('web')->check() || optional(Auth::guard('mentor')->user())->institution_id != 0){
    //         return redirect()->back();
    //     }
    //     $students = Student::has('feedback')->get();

    //     return view('dashboard.students.testimonial.index', compact('students'));
    // }
    public function testimonial()
    {
        $isWebGuardActive = Auth::guard('web')->check();
        $mentorInstitutionId = optional(Auth::guard('mentor')->user())->institution_id;

        if (!$isWebGuardActive || $mentorInstitutionId != 0) {
            return redirect()->back();
        }

        $students = Student::has('feedback')->get();

        return view('dashboard.students.testimonial.index', compact('students'));
    }
    // end of 2nd code refactor
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
            $countries = DB::table('countries')->orderBy('name')->get();
            return view('auth.register', compact(['countries', 'checkStudent','GetInstituionData','regState']));
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
          if(Auth::guard('mentor')->user()->institution_id != 0){
            $student = Student::create([
                'email' => $email,
                'institution_id' => Auth::guard('mentor')->user()->institution_id,
            ]);
          }else{
            $student = Student::create([
              'email' => $email,
              'institution_id' => $institution_id,
            ]);
          }
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
        $supervisors = Mentor::where('institution_id', '!=', 0)->where('is_confirm', 1)->get();
        $staffs = Mentor::where('institution_id', 0)->where('is_confirm', 1)->get();
        return view('dashboard.students.edit', compact('student','supervisors','staffs','institutions'));
    }

    public function manageStudentpatch(Request $request, Student $student)
    {
        $student = Student::findOrFail($student->id);
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->date_of_birth = $request->date_of_birth;
        $student->end_date = $request->end_date;
        $student->mentor_id = $request->supervisor;
        $student->staff_id = $request->staff;
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
        $student = Student::findOrFail($student_id);
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
        $student = Student::findOrFail($student->id);
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
        $students = Student::findOrFail($student_id);
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
        $student = Student::findOrFail($student_id);
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
        $student = Student::findOrFail($id);
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
            'sex' => ['required', 'in:male,female'],
            'team_name' => ['required'],
            'country' => ['required'],
            // 'state' => ['required'],
            'institution_name' => ['required'],
            'study_program' => ['required'],
            'year_of_study' => ['required'],
            'mentorship_type' => ['required', 'in:skills_track,entrepreneur_track'],
            'email' => ['required'],
            'password' => ['required'],
            'g-recaptcha-response' => 'required|recaptcha',
        ],[
          'first_name.required' => 'First name is required',
          'last_name.required' => 'Last name is required',
          'date_of_birth.required' => 'Date of birth is required',
          'sex.required' => 'Sex is required',
          'sex.in' => 'Sex must be Male or Female',
          'team_name.required' => 'Team name is required',
          'country.required' => 'Country is required',
        //   'state.required' => 'State is required',
          'institution_name.required' => 'Institution is required',
          'study_program.required' => 'Study program is required',
          'year_of_study.required' => 'Year of study program is required',
          'mentorship_type.required' => 'Mentorship type is required',
          'mentorship_type.in' => 'Mentorship type must be Skills Track or Entrepreneur Track',
          'email.required' => 'Email is required',
          'password.required' => 'Password is required',
          'g-recaptcha-response.required' => 'Captcha is required',
        ]);

        if($validator->fails()){
            Session::flash('g-recaptcha-response', 'Google reCAPTCHA validation failed, please try again.');
            return redirect()->route('student.register',[$email])->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // to get randomly id mentors
        $mentor = Mentor::inRandomOrder()->where('institution_id', '!=', 0)->where('is_confirm', 1)->first();

        if($mentor == null){
            return back()->with('errorTailwind', "Your institute supervisor haven't registered yet");
        }

        $staff = Mentor::inRandomOrder()->where('institution_id',0)->where('is_confirm',1)->first();

        // just for note, is confirm and the end_date we dont need to set in here because when we enter the route verified the is confirm and the end_date  will be handled by the route
        // $regStudent->is_confirm = 1;
        // $regStudent->end_date = \Carbon\Carbon::now()->addMonth(4)->toDateString();

        $regStudent = Student::where('email',$validated['email'])->first();
        $regStudent->first_name = $validated['first_name'];
        $regStudent->last_name = $validated['last_name'];
        $regStudent->date_of_birth = $validated['date_of_birth'];
        $regStudent->sex = $validated['sex'];
        $regStudent->team_name = $validated['team_name'];
        $regStudent->country = $validated['country'];
        // $regStudent->state = $validated['state'];
        $regStudent->institution_name = $validated['institution_name'];
        $regStudent->study_program = $validated['study_program'];
        $regStudent->year_of_study = $validated['year_of_study'];
        $regStudent->mentorship_type = $validated['mentorship_type'];
        $regStudent->email = $validated['email'];
        $regStudent->password = Hash::make($validated['password']);
        $regStudent->mentor_id = $mentor->id;
        $regStudent->staff_id = $staff->id;
        $regStudent->save();
        $emailEnc = (new SimintEncryption)->encData($validated['email']);
        $link = route('verified', [$emailEnc]);
        $sendmail = (new MailController)->emailregister($validated['email'],$link);

        // return redirect()->route('verified',[$emailEnc]);
        return redirect()->route('verify',[$emailEnc]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student = Student::findOrFail($student->id);
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
        $readTheNotifications = ReadNotification::where('student_id', $id)
        ->where('is_read', 1)
        ->whereNull('comments_id')
        ->whereNull('submission_id')
        ->whereNull('type')
        ->whereNull('mentor_id')
        ->whereNull('user_id')
        ->whereHas('notificationStudent', function ($query) {
            $query->where('status', 'publish');
        })
        ->get()->count();
        $notifActivityCount = ($notifActivityCounts->count() + $notif) - $readTheNotifications;
        return $notifActivityCount;
    }

    public function newNotificationActivity($id)
    {
        $notifActivity = Submission::where('student_id',$id)->get();
        return $notifActivity;
    }

    public function newCommentForSidebarMenu($id)
    {
        $newMessage = Comment::where('student_id', $id)->where('read_message', 0)->where(function ($query) {
            $query->orWhereNotNull('user_id')
                ->orWhereNotNull('mentor_id')
                ->orWhereNotNull('customer_id')
                ->orWhereNotNull('staff_id');
            })->get()->count();

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
        $completed_months = Project::whereHas('enrolled_project', function($q){
          $q->where('student_id', Auth::guard('student')->user()->id);
          $q->where('is_submited',1);
        })->get();
        $student = Student::where('id', $id)->first();
        // dd($student->created_at);
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        return view('student.index', compact('enrolled_projects','completed_months', 'student','dataDate','newMessage', 'newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages'));
    }

    public function ongoingProjects($id)
    {
        // dd(Auth::guard('student')->user()->id);
        if($id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $completed_months = Project::whereHas('enrolled_project', function($q){
          $q->where('student_id', Auth::guard('student')->user()->id);
          $q->where('is_submited',1);
        })->get();
        $student = Student::where('id', $id)->first();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);

        $newMessage = $this->newCommentForSidebarMenu($id);
        $newActivityNotifs = $this->newNotificationActivity($id);
        $notifActivityCount = $this->newNotificationActivityCount($id);
        $notifNewTasks = (new NotificationController)->all_notif_new_task();
        $dataMessages = (new NotificationController)->data_comment_from_admin($id);
        return view('student.index', compact('enrolled_projects','completed_months', 'student','dataDate','newMessage', 'newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages'));
    }

    public function completedProjects($id)
    {
        // dd(Auth::guard('student')->user()->id);
        if($id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $completed_months = Project::whereHas('enrolled_project', function($q){
          $q->where('student_id', Auth::guard('student')->user()->id);
          $q->where('is_submited',1);
        })->get();
        $student = Student::where('id', $id)->first();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);

        $newMessage = $this->newCommentForSidebarMenu($id);
        $newActivityNotifs = $this->newNotificationActivity($id);
        $notifActivityCount = $this->newNotificationActivityCount($id);
        $notifNewTasks = (new NotificationController)->all_notif_new_task();
        $dataMessages = (new NotificationController)->data_comment_from_admin($id);
        return view('student.index', compact('enrolled_projects','completed_months', 'student', 'dataDate', 'newMessage', 'newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages'));
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
        $completed_months = Project::whereHas('enrolled_project', function($q){
          $q->where('student_id', Auth::guard('student')->user()->id);
          $q->where('is_submited',1);
        })->get();
        $project = Project::findOrFail($project_id);
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        // $project_sections = ProjectSection::orderBy('id','DESC')->where('project_id', $project_id)->get();
        $project_sections = ProjectSection::orderBy('id','DESC')->where('project_id', $project_id)->get();
        // dd($project_sections);
        return view('student.project.show', compact('student','project', 'enrolled_projects' ,'completed_months','project_sections', 'dataDate','submissions', 'submission_data'));
    }

    public function enrolledDetail($student_id, $project_id)
    {
        if($student_id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $student = Student::where('id', $student_id)->first();
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $completed_months = Project::whereHas('enrolled_project', function($q){
          $q->where('student_id', Auth::guard('student')->user()->id);
          $q->where('is_submited',1);
        })->get();
        $project = Project::findOrFail($project_id);
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

        return view('student.project.show', compact('student','project', 'enrolled_projects','completed_months' ,'project_sections', 'dataDate','submissions','projectsections','taskProgress','total_task','task_clear','taskDate','newMessage','newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages','submission_data'));
    }

    public function readActivityTask($student_id, $project_id, $notification_id){
        $checkReadNotification = ReadNotification::where('notifications_id',$notification_id)->where('student_id',$student_id)->first();
        $checkIdNotification = Notification::where('id',$notification_id)->where('project_id',$project_id)->where('status','publish')->first();
        $checkEnrolled = EnrolledProject::where('student_id',$student_id)->where('project_id',$project_id)->first();
        if($checkIdNotification != null){
            if(!$checkReadNotification){
                $ReadNotification = new ReadNotification;
                $ReadNotification->student_id = $student_id;
                $ReadNotification->notifications_id = $notification_id;
                $ReadNotification->is_read = 1;
                $ReadNotification->save();
            }
        }else{
            return redirect()->back();
        }

        if($checkEnrolled != null){
            return $this->availableProjectDetail($student_id, $project_id);
        }else{
            return $this->enrolledDetail($student_id, $project_id);
        }
    }

    public function readActivity($student_id, $project_id, $task_id, $submission_id){
        $notif_grade_from_task = Grade::where('submission_id',$submission_id)->first();
        $notif_grade_from_task->readornot = 1;
        $notif_grade_from_task->save();
        return redirect()->route('student.taskDetail',[$student_id,$project_id,$task_id]);
    }

    public function readComment($student_id, $project_id, $task_id, $commecnt_id){
        $read_comment_from_admin = Comment::where('id', $commecnt_id)->where('read_message', 0)->firstOrFail();
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
        $task = ProjectSection::findOrFail($task_id);
        $comments = Comment::where('project_id', $project_id)->where('project_section_id', $task_id)->where('student_id', Auth::guard('student')->user()->id)->get();
        // $submission = Submission::get();
        $submissionData = Submission::where('student_id',$student_id)->where('section_id', $task->id)->where('is_complete',1)->first();
        $submissionId = Submission::where('student_id',$student_id)->where('section_id', $task->id)->where('is_complete',0)->first();
        $project = Project::findOrFail($project_id);
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
        $completed_months = Project::whereHas('enrolled_project', function($q){
          $q->where('student_id', Auth::guard('student')->user()->id);
          $q->where('is_submited',1);
        })->get();
        return view('student.project.task.index', compact('student','completed_months','enrolled_projects', 'dataDate', 'task','comments', 'submissionData','submissionId','submissions','taskProgress','total_task','task_clear','taskDate','project','newMessage','newActivityNotifs','admins','notifActivityCount','notifNewTasks','dataMessages'));
    }

    public function taskSubmit( Request $request, $student_id, $project_id, $task_id, $submission_id )
    {
        if ($student_id != Auth::guard('student')->user()->id) {
            abort(403);
        }

        $validated = Validator::make($request->all(), [
            'glablink' => 'required',
        ]);

        if ($validated->fails()) {
            $error_message = $request->hasFile('file')
                ? 'You cannot upload a file size larger than 5MB'
                : 'No file was uploaded';

            return redirect()
                ->route('student.taskDetail', [$student_id, $project_id, $task_id])
                ->with('errorTailwind', $error_message)
                ->withErrors($validated);
        }

        if ($request->dataset) {
          $dataset_array = json_decode($request->dataset, true);
          $dataset_values = array_column($dataset_array, 'value');
          $dataset_result = implode(';', $dataset_values);
        }

        $project = Project::findOrFail($project_id);
        $appliedDateStart = \Carbon\Carbon::parse(
            $project
                ->enrolled_project
                ->where('student_id', Auth::guard('student')->user()->id)
                ->where('project_id', $project->id)
                ->first()
                ->created_at
        )->startOfDay();
        $appliedDateEnd = \Carbon\Carbon::parse(
            $project
                ->enrolled_project
                ->where('student_id', Auth::guard('student')->user()->id)
                ->where('project_id', $project->id)
                ->first()
                ->created_at
        )->addMonths($project->period)->startOfDay();
        $taskDate = (new SimintEncryption())->daycompare(
            $appliedDateStart,
            $appliedDateEnd
        );

        $student = Student::where('id', $student_id)->first();
        $task = ProjectSection::findOrFail($task_id);
        $tiempoAdicional = ProjectSection::where('project_id', $project_id)
            ->where('id', $task_id)
            ->firstOrFail();

        $glablink = $request->input('glablink');

        $submission = Submission::findOrFail($submission_id);
        $submission->section_id = $task_id;
        $submission->student_id = $student_id;
        $submission->project_id = $project_id;
        $submission->is_complete = 1;
        $submission->flag_checkpoint = $taskDate;
        $submission->file = $glablink;
        $submission->dataset = $request->dataset ? $dataset_result : null;
        $submission->save();

        $submission_date_override = Submission::where('project_id', $project_id)
            ->where('student_id', Auth::guard('student')->user()->id)
            ->where('is_complete', 0)
            ->first();

        if ($submission_date_override != null) {
            $submission_date_override->release_date = Carbon::now()->format('Y-m-d');
            $submission_date_override->dueDate = Carbon::now()->addDays($tiempoAdicional->duration)->format('Y-m-d');
            $submission_date_override->save();
        }

        return redirect('/profile/' . $student_id . '/enrolled/' . $project_id . '/task/' . $task_id);
    }

    public function taskResubmit(Request $request, $student_id, $project_id, $task_id, $submission_id )
    {
        if ($request->dataset) {
            $dataset_array = json_decode($request->dataset, true);
            $dataset_values = array_column($dataset_array, 'value');
            $dataset_result = implode(';', $dataset_values);
        }

        // checkpoint
        $project = Project::findOrFail($project_id);
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
        $task = ProjectSection::findOrFail($task_id);

        $validated = Validator::make($request->all(), [
            'glablink' => 'required',
        ]);

        $submission = Submission::findOrFail($submission_id);
        $submission->flag_checkpoint = $taskDate;
        if($request->dataset){
            $submission->dataset = $dataset_result;
        }else{
            $submission->dataset = null;
        }
        $glablink = $request->input('glablink');
        $submission->file = $glablink;
        $submission->save();

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
        // if(\Carbon\Carbon::now() > $student->end_date){
        //   abort(403);
        // }
        $projects = Project::whereNotIn('id', function($query){
                                $query->select('project_id')->from('enrolled_projects');
                                $query->where('student_id',Auth::guard('student')->user()->id);
                            })->where('institution_id', $student->institution_id)
                            ->where('status', ['publish', 'private_project'])
                            ->orWhere('institution_id', null)->whereNotIn('id', function($query){
                                $query->select('project_id')->from('enrolled_projects');
                                $query->where('student_id',Auth::guard('student')->user()->id);
                            })
                            ->where('status', ['publish', 'private_project'])
                            ->get();

        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
        $completed_months = Project::whereHas('enrolled_project', function($q){
          $q->where('student_id', Auth::guard('student')->user()->id);
          $q->where('is_submited',1);
        })->get();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);

        $newMessage = $this->newCommentForSidebarMenu($student_id);
        $newActivityNotifs = $this->newNotificationActivity($student_id);
        $notifActivityCount = $this->newNotificationActivityCount($student_id);
        $notifNewTasks = (new NotificationController)->all_notif_new_task();
        $dataMessages = (new NotificationController)->data_comment_from_admin($student_id);
        return view('student.project.available.index', compact('student','completed_months','projects','enrolled_projects','dataDate','newMessage','newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages'));
    }

    public function availableProjectDetail($student_id, $project_id)
    {
        if($student_id != Auth::guard('student')->user()->id ){
            abort(403);
        }

        $student = Student::where('id', $student_id)->first();
        if(\Carbon\Carbon::now() > $student->end_date){
          abort(403);
        }
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project_id)->get();
        $completed_months = Project::whereHas('enrolled_project', function($q){
          $q->where('student_id', Auth::guard('student')->user()->id);
          $q->where('is_submited',1);
        })->get();
        $project = Project::where('status', 'publish')->findOrFail($project_id);
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        // $newMessage = Comment::where('student_id',$student_id)->where('read_message',0)->where('mentor_id',!NULL)->get();
        $newMessage = $this->newCommentForSidebarMenu($student_id);
        $newActivityNotifs = $this->newNotificationActivity($student_id);
        $notifActivityCount = $this->newNotificationActivityCount($student_id);
        $notifNewTasks = (new NotificationController)->all_notif_new_task();
        $dataMessages = (new NotificationController)->data_comment_from_admin($student_id);
        if($project){
            return view('student.project.available.show', compact('student','project','enrolled_projects','completed_months' ,'dataDate','newMessage','newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages'));
        }else{
            abort(404);
        }
    }

    public function certificate(Student $student,$institution_id)
    {
        if(Auth::guard('student')->user()->institution_id != $institution_id){
            abort(404);
        }

        if (!Auth::guard('student')->check()) {
            abort(404);
        }

        if($student->id != Auth::guard('student')->user()->id ){
            abort(404);
        }

        $studentSerialNumber = $student->serial_number;

        if($studentSerialNumber == null){
            $highestSerialNumber = Student::where('institution_id', $institution_id)
                                    ->max('serial_number') ?? 0;

            $studentSerialNumber = $highestSerialNumber + 1;
            $student->serial_number = $studentSerialNumber;
            $student->save();
        }

        $institution_template = Institution::where('id',$institution_id)->firstOrFail();
        $student_name = Student::where('id',$student->id)->firstOrFail();
        $name = $student_name->first_name.' '.$student_name->last_name;

                // Get the latest updated_at value.
        $latestUpdatedAt = $student->enrolled_projects->max('updated_at');

        // Convert it to a Carbon instance.
        $latestUpdatedDate = Carbon::parse($latestUpdatedAt);

        // Format to get only the date part.
        $onlyDate = $latestUpdatedDate->toDateString();  // Outputs "2023-08-24"

        $datess = $onlyDate; // Assuming this is "2023-8-28"
        $dateserial = $onlyDate; // Assuming this is "2023-8-28"
        $serialNumber = $studentSerialNumber;

        // Use str_pad to ensure it's 3 characters long, padding with zeros from the left.
        $serialNombre = str_pad($serialNumber, 3, '0', STR_PAD_LEFT);

        // Parse the date using Carbon
        $date = Carbon::parse($datess);

        // Format the date
        $formattedDate = $date->format('F j, Y.'); // Outputs "August 8, 2023"

        // Parse the date using Carbon
        $date = Carbon::parse($dateserial);

        // Format the date to YYMMDD
        $formattedDateSerial = $date->format('ymd'); // Outputs "230828"
        $templateFile = Storage::path('public/'.$institution_template->template_cert);

        // Buat instance FPDI
        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->setSourceFile($templateFile);
        $pdf->useTemplate($pdf->importPage(1), null, null, null, null, true);

        // Tambahkan custom font
        $pdf->AddFont('InteloneDisplay', '', 'IntelOneDisplayRegular.php');
        $pdf->AddFont('InteloneDisplayLight', '', 'intelone-display-light.php');
        $pdf->SetFont('InteloneDisplayLight', '', 37);

        // Tambahkan nama ke sertifikat
        $pdf->SetTextColor(0, 8, 100);
        if (strlen($name) <= 28) {
            $pdf->SetXY(50.3, 64);
            $pdf->Cell(100, 10, $name, 0, 1, 'L');
        } else {
            $pdf->SetXY(50.3, 60);
            $pdf->MultiCell(150, 10, $name, 0, 'L');
        }

            $pdf->SetFont('InteloneDisplayLight', '', 20);
            $pdf->SetXY(148.5, 91.5);
            $pdf->MultiCell(150, 10, $formattedDate, 0, 'L');

            $pdf->SetFont('InteloneDisplayLight', '', 15);
            $pdf->SetXY(293, 200);
            $pdf->MultiCell(50, -30, "AI4FW".$formattedDateSerial.$serialNombre, 0, 'L');
            // $pdf->SetXY(152.5, 83);
            // $pdf->MultiCell(150, 10, "AI internship under", 0, 'L');

        // Simpan sertifikat sebagai file PDF
        $certificateFilename = "{$name}_SIP.pdf";
        // 1. Save the generated PDF to a temporary file.
        $temporaryPath = storage_path('app/public/temp/' . $certificateFilename);
        $pdf->Output($temporaryPath, 'F'); // 'F' means save to a file.

        // // 2. Use that file path to serve the PDF for download.
        return response()->download($temporaryPath, $certificateFilename)->deleteFileAfterSend(true);
    }
    //   if($student->id != Auth::guard('student')->user()->id ){
    //     abort(403);
    //   }
    //   return view('student.certificate.index', compact('student'));

    public function feedbackStudent(Request $request, Student $student)
    {
        // 1. Cek apakah ada student
        $student_name = Student::where('id', $student->id)->first();
        if (!$student_name) {
            return redirect()->back();
        }

        // 2. Cek field feedback_done
        if ($student_name->feedback_done == 1) {
            return redirect()->back();
        }

        // 3. Validasi data request
        $validated = $request->validate([
            'feedback' => 'required|min:25',
        ], [
            'feedback.required' => 'Feedback cannot be empty',
            'feedback.min' => 'Your feedback is too short',
        ]);



        // 4 & 5. Insert ke table feedback
        $feedback = new Feedback();
        $feedback->feedback = $request->input('feedback');
        $feedback->student_id = $student->id;
        $feedback->save();

        // 6. Update field feedback_done pada table student
        $student_name->feedback_done = 1;
        $student_name->save();

        return redirect()->back()->with('success', 'Thank you for your feedback');
    }

    public function support(Student $student)
    {
      if($student->id != Auth::guard('student')->user()->id ){
        abort(403);
      }
      // $newMessage = Comment::where('student_id',$student->id)->where('read_message',0)->where('mentor_id',!NULL)->get();
      $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->get();
      $completed_months = Project::whereHas('enrolled_project', function($q){
        $q->where('student_id', Auth::guard('student')->user()->id);
        $q->where('is_submited',1);
      })->get();
      $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);

      $newMessage = $this->newCommentForSidebarMenu($student->id);
      $newActivityNotifs = $this->newNotificationActivity($student->id);
      $notifActivityCount = $this->newNotificationActivityCount($student->id);
      $notifNewTasks = (new NotificationController)->all_notif_new_task();
      $dataMessages = (new NotificationController)->data_comment_from_admin($student->id);
      return view('student.support', compact('student','newMessage','newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages','enrolled_projects','completed_months','dataDate'));
    }

    public function sendSupport(Request $request,Student $student)
    {
      $validated = $request->validate([
        'first_name' => ['required'],
        'last_name' => ['required'],
        'email' => ['required'],
        'query' => ['required'],
        'message' => ['required'],
      ],[
        'first_name.required' => 'First name is required',
        'last_name.required' => 'Last name is required',
        'email.required' => 'Email is required',
        'query.required' => 'Type of query is required',
        'message.required' => 'Message is required',
      ]);
      $recipients = ['sip@sustainablelivinglab.org', 'aswathy@sustainablelivinglab.org','kevin@sustainablelivinglab.org','anip@sustainablelivinglab.org'];
      $this->SupportMail($recipients, $validated);
      return back()->with('successTailwind', 'Your message has been successfully sent to our team.');
    }

    public function SupportMail($mailto,$validated) //Email, urlInvitation
    {
      $data = [
        'subject' => 'Simulated Internship Support-Mail',
        'body' => $mailto,
        'first_name' => $validated['first_name'],
        'last_name' => $validated['last_name'],
        'email' => $validated['email'],
        'query' => $validated['query'],
        'message'=> $validated['message'],
        'type' => 'support',
      ];

    try
      {
        Mail::to($mailto)->send(new MailNotify($data));
        return response()->json(['Your message has been successfully sent to our team.']);
      } catch (\Exception $th) {
        return response()->json(['Sorry Something went wrong']);
      }
  }
}
