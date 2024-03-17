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
use App\Models\NotifyMentor;
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
        return view('dashboard.students.index');
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
        $isAdmin = Auth::guard('web')->check();
        $isStaff = Auth::guard('mentor')->check() && Auth::guard('mentor')->user()->institution_id === 0;

        if ($isAdmin || $isStaff) {
            $students = Student::has('feedback')->get();
            return view('dashboard.students.testimonial.index', compact('students'));
        } else {
            abort(403);
        }
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
        $data = [
            'institution' => $institution,
            'template' => [
                'url' => url('/download/bulk_upload_template.csv'),
                'name' => 'Bulk Upload Template',
            ],
        ];

        if(Route::is('dashboard.students.invite')){
            $data['prevPage'] = url('/dashboard/students');
            $data['formAction'] = route('dashboard.students.sendInviteStudent');
        } else{
            $data['prevPage'] = url('/dashboard/institutions/'.$institution->id.'/students');
            $data['formAction'] = route('dashboard.students.sendInviteFromInstitution', ['institution'=>$institution->id]);
        }

        return view('dashboard.students.institution.invite', $data);
    }

    public function sendInvite(Request $request)
    {
        if ($request->has('emails')) {
            $emails = explode(',', $request->input('emails'));
        } else {
            $emails = $request->input('emails_check');
        }

        $emails = array_filter($emails, function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        });

        if (count($emails) == 0) {
            toastr()->error('Please enter valid emails', '', ['timeOut' => 10000]);
            return redirect()->back()->withInput();
        }

        // TODO: Will be removed
        $institution = Institution::orderBy('id')->first();
        $countInvited = 0;

        foreach ($emails as $email) {
            $checkStudent = Student::where('email', $email)->first();
            $checkUser = User::where('email', $email)->first();
            $checkMentor = Mentor::where('email', $email)->first();
            $checkCustomer = Customer::where('email', $email)->first();

            if (!$checkStudent && !$checkUser && !$checkMentor && !$checkCustomer) {
                $countInvited++;
                $encEmail = (new SimintEncryption)->encData($email);
                $link = route('student.register', [$encEmail]);
                $student = $this->addStudent($email, $institution->id);
                $sendmail = (new MailController)->EmailStudentInvitation($student->email, $link);
            }
        }


        toastr()->success($countInvited.' Participant(s) invited successfully');

        return redirect()->route('dashboard.students.index');
    }

    public function sendInviteFromInstitution(Request $request, $institution_id)
    {
        if ($request->has('emails')) {
            $emails = explode(',', $request->input('emails'));
        } else {
            $emails = $request->input('emails_check');
        }

        $emails = array_filter($emails, function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        });

        if (count($emails) == 0) {
            toastr()->error('Please enter valid emails', '', ['timeOut' => 10000]);
            return redirect()->back()->withInput();
        }

        $countInvited = 0;

        foreach ($emails as $email) {
            $checkStudent = Student::where('email', $email)->first();
            $checkUser = User::where('email', $email)->first();
            $checkMentor = Mentor::where('email', $email)->first();
            $checkCustomer = Customer::where('email', $email)->first();

            if (!$checkStudent && !$checkUser && !$checkMentor && !$checkCustomer) {
                $countInvited++;
                $encEmail = (new SimintEncryption)->encData($email);
                $link = route('student.register', [$encEmail]);
                $student = $this->addStudentToInstitution($email, $institution_id);
                $sendmail = (new MailController)->EmailStudentInvitation($student->email, $link);
            }
        }

        toastr()->success($countInvited.' Participant(s) invited successfully');

        return redirect()->route('dashboard.students.institutionStudents', ['institution' => $institution_id]);
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

    public function manage(Institution $institution, Student $student)
    {
        $data = [
            'backUrl' => url('/dashboard/institutions/'. $institution->id .'/students'),
            'formAction' => url('/dashboard/institutions/'. $institution->id .'/students/'. $student->id .'/managepatch'),
            'countries' => DB::table('countries')->orderBy('name')->get(),
            'student' => $student,
            'institution' => $institution,
            'year_of_studies' => ['1st', '2nd', '3rd', '4th', '5+'],
            'study_programs' => ['Artificial Intelligence and Machine Learning', 'Computer Science', 'Computing Systems', 'Software Engineering'],
            // 'mentors' => Mentor::where('institution_id', $student->institution_id)->get(),
        ];

        return view('dashboard.students.edit', $data);
    }

    public function manageStudent(Student $student)
    {
        $data = [
            'backUrl' => url('/dashboard/students'),
            'formAction' => url('/dashboard/students/'. $student->id .'/managepatch'),
            'countries' => DB::table('countries')->orderBy('name')->get(),
            'student' => $student,
            'institutions' => Institution::all(),
            'year_of_studies' => ['1st', '2nd', '3rd', '4th', '5+'],
            'study_programs' => ['Artificial Intelligence and Machine Learning', 'Computer Science', 'Computing Systems', 'Software Engineering'],
            // 'supervisors' => Mentor::where('institution_id', '!=', 0)->where('is_confirm', 1)->get(),
            // 'staffs' => Mentor::where('institution_id', 0)->where('is_confirm', 1)->get(),
        ];

        return view('dashboard.students.edit', $data);
    }

    public function manageStudentpatch(Request $request, Student $student)
    {
        if ($request->input('update_type') === 'end_date') {
            $student->end_date = $request->input('end_date');
            $student->save();
            toastr()->success('End date updated successfully');

            return redirect()->back();
        }

        if ($request->input('update_type') === 'password') {
            $student->password = Hash::make($request->input('password'));
            $student->save();
            toastr()->success('Password updated successfully');

            return redirect()->back();
        }

        if ($request->input('update_type') === 'mentorship_type') {
            $student->mentorship_type = $request->input('mentorship_type');
            $student->save();
            toastr()->success('Mentorship type updated successfully');

            return redirect()->back();
        }

        $student->first_name = $request->input('first_name');
        $student->last_name = $request->input('last_name');
        $student->date_of_birth = $request->input('date_of_birth');
        $student->sex = $request->input('sex');
        $student->country = $request->input('country');
        $student->institution_id = $request->input('institution');
        $student->email = $request->input('email');
        $student->year_of_study = $request->input('year_of_study');
        $student->study_program = $request->input('study_program');

        if ($request->hasFile('profile_picture')) {
            if($student->profile_picture == null){
                if( $request->file('profile_picture')->extension() =='png' && $request->file('profile_picture')->getSize() <=5000000 ||
                $request->file('profile_picture')->extension() =='jpg' && $request->file('profile_picture')->getSize() <=5000000 ||
                $request->file('profile_picture')->extension() =='jpeg' && $request->file('profile_picture')->getSize() <=5000000
                ){
                    $profile_picture = Storage::disk('public')->put('students/'.$student->id.'/profile_picture', $request->file('profile_picture'));
                    $student->profile_picture = $profile_picture;
                } else {
                    toastr()->error('File extension is not png, jpg or jpeg');
                    return redirect()->back();
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
                toastr()->error('File extension is not png, jpg or jpeg');
                return redirect()->back();
            }
        }

        $student->save();
        toastr()->success('Profile updated successfully');

        return redirect()->back();
    }

    public function managepatch($institution_id, $student_id, Request $request)
    {
        $student = Student::findOrFail($student_id);

        if ($request->input('update_type') === 'end_date') {
            $student->end_date = $request->input('end_date');
            $student->save();
            toastr()->success('End date updated successfully');

            return redirect()->back();
        }

        if ($request->input('update_type') === 'password') {
            $student->password = Hash::make($request->input('password'));
            $student->save();
            toastr()->success('Password updated successfully');

            return redirect()->back();
        }

        if ($request->input('update_type') === 'mentorship_type') {
            $student->mentorship_type = $request->input('mentorship_type');
            $student->save();
            toastr()->success('Mentorship type updated successfully');

            return redirect()->back();
        }

        $student->first_name = $request->input('first_name');
        $student->last_name = $request->input('last_name');
        $student->date_of_birth = $request->input('date_of_birth');
        $student->sex = $request->input('sex');
        $student->country = $request->input('country');
        $student->institution_id = $institution_id;
        $student->email = $request->input('email');
        $student->year_of_study = $request->input('year_of_study');
        $student->study_program = $request->input('study_program');

        if ($request->hasFile('profile_picture')) {
            if($student->profile_picture == null){
                if( $request->file('profile_picture')->extension() =='png' && $request->file('profile_picture')->getSize() <=5000000 ||
                $request->file('profile_picture')->extension() =='jpg' && $request->file('profile_picture')->getSize() <=5000000 ||
                $request->file('profile_picture')->extension() =='jpeg' && $request->file('profile_picture')->getSize() <=5000000
                ){
                    $profile_picture = Storage::disk('public')->put('students/'.$student->id.'/profile_picture', $request->file('profile_picture'));
                    $student->profile_picture = $profile_picture;
                } else {
                    toastr()->error('File extension is not png, jpg or jpeg');
                    return redirect()->back();
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
                toastr()->error('File extension is not png, jpg or jpeg');
                return redirect()->back();
            }
        }

        $student->save();
        toastr()->success('Profile updated successfully');

        return redirect()->back();
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
        $countries = DB::table('countries')->orderBy('name')->get();
        $end_date_switch = Carbon::parse($student->join_date)->addDays(20);
        // dd($end_date_switch);
        // $newMessage = Comment::where('student_id',$student->id)->where('read_message',0)->where('mentor_id',!NULL)->get();
        $newMessage = $this->newCommentForSidebarMenu($student->id);

        $newActivityNotifs = $this->newNotificationActivity($student->id);
        $notifActivityCount = $this->newNotificationActivityCount($student->id);
        $notifNewTasks = (new NotificationController)->all_notif_new_task();
        $dataMessages = (new NotificationController)->data_comment_from_admin($student->id);
        return view('student.edit', compact('student','newMessage','newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages','end_date_switch','countries'));
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

        toastr()->success($message);

        return back();
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

        toastr()->success($message);

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function updateSwitch($id, Request $request)
    {
        $student = Student::findOrFail($id);
        $student_track = Student::findOrFail($id);
        if($request->switch == "Change My Track"){
            if($student_track->mentorship_type == 'skills_track'){
                $student->mentorship_type = 'entrepreneur_track';
            }else{
                $student->mentorship_type = 'skills_track';
            }
            $student->switch_skill = 1;
            $student->save();
            toastr()->success('Mentorship Type switch successfully '.$request->switch);
        }else{
            toastr()->error('There is something Wrong when change Mentorship Type switch');
        }

        return redirect('/profile/'.$id.'/edit');
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
        // $student->state = $request->state;
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
                } else {
                    toastr()->error('file extension is not png, jpg or jpeg');

                    return redirect('/profile/'.$id.'/edit');
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
                toastr()->error('file extension is not png, jpg or jpeg');

                return redirect('/profile/'.$id.'/edit');
            }
        }
        $student->save();

        toastr()->success('Profile updated successfully');

        return redirect('/profile/'.$id.'/edit');
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
            toastr()->error('Your institute supervisor haven\'t registered yet');

            return back();
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

        toastr()->success('Student Deleted');

        return back();
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
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)
                                            ->where('mentorshipType', 'skill')
                                            ->get();

        $enrolled_projects_entrepreneur = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)
                                                        ->where('mentorshipType', 'entrepreneur')
                                                        ->get();

        $teamName = Auth::guard('student')->user()->team_name;
        // Check if a project with the same team_name already exists
        $existingProject = Project::where('team_name', $teamName)->first();
        $completed_months = Project::whereHas('enrolled_project', function($q){
          $q->where('student_id', Auth::guard('student')->user()->id);
          $q->where('is_submited',1);
        })->get();
        $student = Student::where('id', $id)->first();
        // dd($student->created_at);
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        return view('student.index', compact('enrolled_projects','enrolled_projects_entrepreneur','completed_months', 'student','dataDate','newMessage', 'newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages', 'existingProject'));
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

        if($project && $project->enrolled_project) {
            $enrolledTeam = $project->enrolled_project->where('team_name', Auth::guard('student')->user()->team_name)->first();
            if($enrolledTeam && $enrolledTeam->team_name != Auth::guard('student')->user()->team_name){
                if($project == null || $project->enrolled_project->where('student_id', $student_id)->count() == 0){
                    abort(404);
                }
            }
        }


        $appliedDateStart  = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->startOfDay();
        $appliedDateEnd  = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->addMonths($project->period)->startOfDay();
        $taskDate = (new SimintEncryption)->daycompare($appliedDateStart,$appliedDateEnd);

        // To Check if there's data in submission inputed from Project_section
        // $submissions = Submission::where([['student_id', Auth::guard('student')->user()->id], ['is_complete', 1]])->get();
        $submissions = Submission::where([['student_id', Auth::guard('student')->user()->id] ,['project_id',$project_id], ['is_complete', 1]])->get();
        if(Auth::guard('student')->user()->mentorship_type == "entrepreneur_track"){
            $projectsections = ProjectSection::where('project_id', $project_id)->get();
        }else{
            // To Check if The Project_Section not in the Submission Table then Show the data but limit data to only One
            $projectsections = ProjectSection::where('project_id', $project_id)->whereDoesntHave('submissions', function($query) use ($student_id){$query->where('student_id', $student_id);})->take(1)->get();
        }
        // dd($projectsections);
        // Change is_submited in enrolled_project

        // Total Task in Section
        $total_task = $project_sections->count();

        // Total task cleared
        $task_clear = $submissions->count();

        // Progress Bar for Task
        if ($total_task == 0) {
            // Handle the case where there are no tasks, perhaps set $taskProgress to 0 or another appropriate value
            $taskProgress = 0;
        } else {
            $taskProgress = (100 / $total_task) * $task_clear;
        }
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
        // dd($checkReadNotification);
        if($checkIdNotification != null){
            if(!$checkReadNotification){
                $ReadNotification = new ReadNotification;
                $ReadNotification->student_id = $student_id;
                $ReadNotification->notifications_id = $notification_id;
                $ReadNotification->is_read = 1;
                $ReadNotification->save();
            }else{
                return redirect()->back();
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

        $project = Project::findOrFail($project_id);
        $appliedDateStart  = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->startOfDay();
        $appliedDateEnd  = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->addMonths($project->period)->startOfDay();
        $taskDate = (new SimintEncryption)->daycompare($appliedDateStart,$appliedDateEnd);

        // The prerequisite for count task progress
        $project_sections = ProjectSection::where('project_id', $project_id)->get();
        if(Auth::guard('student')->user()->mentorship_type == "skills_track"){
            $submissionData = Submission::where('student_id',$student_id)->where('section_id', $task->id)->where('is_complete',1)->first();
            $submissionId = Submission::where('student_id',$student_id)->where('section_id', $task->id)->where('is_complete',0)->first();
            $submissions = Submission::where([['student_id', Auth::guard('student')->user()->id] ,['project_id',$project_id], ['is_complete', 1]])->get();
            // Total task cleared
            $task_clear = $submissions->count();

            // Total Task in Section
            $total_task = $project_sections->count();
            // Progress Bar for Task
            if ($total_task > 0) {
                $taskProgress = (100 / $total_task) * $task_clear;
            } else {
                // Handle the case where there are no tasks. You could set progress to 0 or another appropriate value.
                $taskProgress = 0; // or any other value that makes sense in your context
            }

            if($submissionData == null){
                $taskSubmitForm = route('student.taskSubmit',[$student->id,$task->project->id,$task->id,$submissionId->id]);
                $taskReSubmitForm = "";
            }else{
                $taskSubmitForm = "";
                $taskReSubmitForm = route('student.taskResubmit',[$student->id,$task->project->id,$task->id,$submissionData->id]);
            }
        }else{
            $taskSubmitFormProjectPlanner = route('student.projectPlanner.taskSubmit',[$student->id,$task->project->id,$task->id]);
            $submissionData = Submission::where('mentorshipType', 'entrepreneur')->where('project_id',$project_id)->where('section_id', $task->id)->first();
        }
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
        if(Auth::guard('student')->user()->mentorship_type == "skills_track"){
            return view('student.project.task.index', compact('taskSubmitForm', 'taskReSubmitForm', 'student','completed_months','enrolled_projects', 'dataDate', 'task','comments', 'submissionData','submissionId','submissions','taskProgress','total_task','task_clear','taskDate','project','newMessage','newActivityNotifs','admins','notifActivityCount','notifNewTasks','dataMessages'));
        }else{
            return view('student.project.task.index', compact('taskSubmitFormProjectPlanner','submissionData','student','completed_months','enrolled_projects', 'dataDate', 'task','comments','taskDate','project','newMessage','newActivityNotifs','admins','notifActivityCount','notifNewTasks','dataMessages'));
        }
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

            toastr()->error($error_message);

            return redirect()
                ->route('student.taskDetail', [$student_id, $project_id, $task_id])
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

        $mentorIds = [
            Auth::guard('student')->user()->mentor_id,
            Auth::guard('student')->user()->staff_id,
        ];

        foreach ($mentorIds as $mentorId) {
            // Check if the mentorId is valid before proceeding
            if ($mentorId) {
                $notifyMentor = NotifyMentor::firstOrCreate(
                    ['id_mentors' => $mentorId],
                    ['notify_mentors_data' => ['notification' => []]] // Default as an array
                );

                $notifications = $notifyMentor->notify_mentors_data; // This is automatically an array because of the $casts attribute

                // Get the last notification's idNotify and increment by 1
                $lastNotify = end($notifications['notification']);
                $nextIdNotify = $lastNotify ? $lastNotify['idNotify'] + 1 : 1;

                $newNotification = [
                    "type" => "newSubmission",
                    "isRead" => 0,
                    "idNotify" => $nextIdNotify,
                    "idStudent" => $student_id,
                    "studentName" => Auth::guard('student')->user()->first_name . " " . Auth::guard('student')->user()->last_name,
                    "idProject" => $project_id,
                    "projectName" => $project->name,
                    "idTask" => $task_id,
                    "taskTitle" => $task->title,
                    "idSubmission" => $submission_id, // Adjust as needed
                    "created_at" => Carbon::now()->toDateTimeString(),
                    "statusSubmission" => "new" // Adjust based on your logic
                ];

                // Append the new notification
                $notifications['notification'][] = $newNotification;

                // Save the updated notifications data back to the model
                $notifyMentor->notify_mentors_data = $notifications;
                $notifyMentor->save();
            }
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

        $mentorIds = [
            Auth::guard('student')->user()->mentor_id,
            Auth::guard('student')->user()->staff_id,
        ];

        foreach ($mentorIds as $mentorId) {
            // Check if the mentorId is valid before proceeding
            if ($mentorId) {
                $notifyMentor = NotifyMentor::firstOrCreate(
                    ['id_mentors' => $mentorId],
                    ['notify_mentors_data' => ['notification' => []]] // Default as an array
                );

                $notifications = $notifyMentor->notify_mentors_data; // This is automatically an array because of the $casts attribute

                // Get the last notification's idNotify and increment by 1
                $lastNotify = end($notifications['notification']);
                $nextIdNotify = $lastNotify ? $lastNotify['idNotify'] + 1 : 1;

                $newNotification = [
                    "type" => "newSubmission",
                    "isRead" => 0,
                    "idNotify" => $nextIdNotify,
                    "idStudent" => $student_id,
                    "studentName" => Auth::guard('student')->user()->first_name . " " . Auth::guard('student')->user()->last_name,
                    "idProject" => $project_id,
                    "projectName" => $project->name,
                    "idTask" => $task_id,
                    "taskTitle" => $task->title,
                    "idSubmission" => $submission_id, // Adjust as needed
                    "created_at" => Carbon::now()->toDateTimeString(),
                    "statusSubmission" => "revision" // Adjust based on your logic
                ];

                // Append the new notification
                $notifications['notification'][] = $newNotification;

                // Save the updated notifications data back to the model
                $notifyMentor->notify_mentors_data = $notifications;
                $notifyMentor->save();
            }
        }
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
        // come back here, remove only if it fix
//         $enrolledProject = EnrolledProject::where('student_id', $student_id)->first();
//         $checkEnrolled = ($enrolledProject && $enrolledProject->project_id == $project_id) || $enrolledProject === null;

//         dd($checkEnrolled);

// return redirect()->route('student.allProjects', [$student_id]);

        $student = Student::where('id', $student_id)->first();
        if(\Carbon\Carbon::now() > $student->end_date){
          abort(403);
        }
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project_id)->get();
        $completed_months = Project::whereHas('enrolled_project', function($q){
          $q->where('student_id', Auth::guard('student')->user()->id);
          $q->where('is_submited',1);
        })->get();

        if(Auth::guard('student')->user()->mentorship_type == 'entrepreneur_track'){
            $project = Project::where('status', 'private')->findOrFail($project_id);
        }else{
            $project = Project::where('status', 'publish')->findOrFail($project_id);
        }


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

        toastr('success', 'Thank you for your feedback');

        return redirect()->back();
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

      toastr()->success('Your message has been successfully sent to our team.');

      return back();
    }

    public function SupportMail($mailto,$validated) //Email, urlInvitation
    {
        $data = [
            'subject' => 'Mentorship Program Support-Mail',
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

    public function chat(Student $student)
    {
        $allowed = !isSkillsTrack();

        if (!$allowed) {
            return redirect()->route('student.allProjects', ['student' => $student]);
        }

        $newMessage = $this->newCommentForSidebarMenu($student->id);
        $newActivityNotifs = $this->newNotificationActivity($student->id);
        $notifActivityCount = $this->newNotificationActivityCount($student->id);
        $notifNewTasks = (new NotificationController)->all_notif_new_task();
        $dataMessages = (new NotificationController)->data_comment_from_admin($student->id);

        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)
                                            ->where('mentorshipType', 'skill')
                                            ->get();

        $enrolled_projects_entrepreneur = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)
                                                        ->where('mentorshipType', 'entrepreneur')
                                                        ->get();

        $teamName = Auth::guard('student')->user()->team_name;
        // Check if a project with the same team_name already exists
        $existingProject = Project::where('team_name', $teamName)->first();
        $completed_months = Project::whereHas('enrolled_project', function($q){
          $q->where('student_id', Auth::guard('student')->user()->id);
          $q->where('is_submited',1);
        })->get();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);

        return view('student.chat', compact('enrolled_projects','enrolled_projects_entrepreneur','completed_months', 'student','dataDate','newMessage', 'newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages', 'existingProject'));
    }
}
