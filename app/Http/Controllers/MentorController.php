<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mentor;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Project;
use App\Models\Student;
use App\Models\Customer;
use App\Models\Institution;
use App\Models\MentorProject;
use App\Models\ProjectSection;
use App\Models\EnrolledProject;
use App\Models\SectionSubsection;
use App\Models\Submission;
use App\Models\ReadNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use Exception;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Institution $institution)
    {
        $mentors = Mentor::where('institution_id', $institution->id)->get();
        return view('dashboard.mentors.index', compact('mentors', 'institution'));
    }

    public function registered()
    {
        $mentors = Mentor::where('is_confirm', 0)->get();
        return view('dashboard.mentors.registered', compact('mentors'));
    }

    public function invite(Institution $institution)
    {
        return view('dashboard.mentors.invite', compact('institution'));
    }

    public function sendInvite(Request $request,$institution_id)
    {
        $message = "Successfully Send Invitation to Supervisor";
        foreach (array_filter($request->email) as $email) {
            $checkStudent = Student::where('email', $email)->first();
            $checkUser = User::where('email', $email)->first();
            $checkMentor = Mentor::where('email', $email)->first();
            $checkCustomer = Customer::where('email', $email)->first();
            if (!$checkStudent && !$checkUser && !$checkMentor && !$checkCustomer) {
                $encEmail = (new SimintEncryption)->encData($email);
                $link = route('supervisor.register', [$encEmail]);
                $mentors = $this->addMentor($email,$institution_id);
                $institution_detail = Institution::where('id',$institution_id)->first();
                $nameInstitution = $institution_detail->name;
                $InstitutionLogo = $institution_detail->logo;
                $sendmail = $this->EmailMentorInvitation($mentors->email,$link,$nameInstitution,$InstitutionLogo);
                // dd($sendmail);
                $message .= "\n$email";
            } else {
                toastr()->error('Email is already registered');

                return redirect()->back();
            }
        }

        toastr()->success($message);

        return redirect()->route('dashboard.institutionSupervisors', ['institution'=>$institution_id]);
    }

    public function EmailMentorInvitation($mailto, $urlInvitation, $nameInstitution, $logo)
    {
        $data = [
            'subject' => 'Invitation to join as a Supervisor',
            'body' => $mailto,
            'body2' => $urlInvitation,
            'body3' => $nameInstitution,
            'body4' => $logo,
            'body5' => 'Supervisor',
            'type' => 'cusmemb',
        ];
        try {
            Mail::to($mailto)->send(new MailNotify($data));
            return response()->json(['message' => 'Mentor Invitation Email sent successfully']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function addMentor($email,$institution_id){
        return Mentor::create([
            'email' => $email,
            'institution_id' => $institution_id,
            'is_confirm' => 0
        ]);
    }

    // dont need it but dont stash the function
    public function addMentorToProject($mentor,$request){
        $mentorProject = new MentorProject;
        $mentorProject->mentor_id = $mentor->id;
        $mentorProject->project_id = $request->project_id;
        $mentorProject->save();
    }

    public function editSupervisor(Institution $institution, Mentor $supervisor)
    {
        // dd($supervisor->id);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *$this->
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // edit mentor dari dashboard
    public function edit(Institution $institution, Mentor $supervisor)
    {
        return view('dashboard.mentors.edit', compact('institution', 'supervisor'));
    }
    // update mentor dari dashboard
    public function updateMentorDashboard(Request $request, Institution $institution, Mentor $supervisor)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'country' => 'required',
            'state' => 'required',
        ]);

        $supervisor = Mentor::find($supervisor->id);
        $supervisor->email = $validated['email'];
        $supervisor->first_name = $validated['first_name'];
        $supervisor->last_name = $validated['last_name'];
        $supervisor->country = $validated['country'];
        $supervisor->state = $validated['state'];
        $supervisor->save();
        $message = "Successfully updated mentor data";

        toastr()->success($message);

        return redirect('/dashboard/institutions/'.$institution->id.'/supervisors');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $email)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'institution' => 'required',
            'country' => 'required',
            'state' => 'required',
            'password' => 'required|confirmed|min:8|',
            'g-recaptcha-response' => 'required|recaptcha',
            'tnc' => 'required',
        ]);

        $validated = $validator->validated();
        $emails = (new SimintEncryption)->decData($email);
        if($validated){
            $mentor = Mentor::where('email',$emails)->first();
            $mentor->email = $validated['email'];
            $mentor->first_name = $validated['first_name'];
            $mentor->last_name = $validated['last_name'];
            $mentor->sex = $validated['sex'];
            if($request->institution){
              $mentor->institution_id = $validated['institution'];
              $mentor->country = $validated['country'];
              $mentor->state = $validated['state'];
            }
            $mentor->is_confirm = 1;
            $menpwd = $validated['password'];
            $menpwdhash = Hash::make($menpwd) ;
            $mentor->password = $menpwdhash;
            if (!Hash::check($menpwd, $menpwdhash)) {
                return redirect()->back();
            }
            $mentor->save();
            // $sendmail = (new MailController)->EmailMentorRegister($mentor->email);
            if($request->institution){
            $message = "Successfully Register as Mentor, Now you can login to your account";
            }else{
              $message = "Successfully Register as Staff Member, Now you can login to your account";
            }

            toastr()->success($message);

            return redirect()->route('login');
        }else{
            return redirect()->back();
        }
    }

    public function suspendSupervisorDashboard(Institution $institution, Mentor $supervisor)
    {
        $supervisor = Mentor::find($supervisor->id);
        if($supervisor->is_confirm == 1){
            $supervisor->is_confirm = 0;
            $message = "Successfully Pending Account";

            $mentors = Mentor::inRandomOrder()
                        ->where('institution_id',$institution->id)->where('id', '!=', $supervisor->id)->get()->pluck('id')->toArray();
            $students = Student::where('mentor_id', $supervisor->id)->get();
            foreach ($students as $student) {
                DB::table('students')
                ->where('id', $student->id)
                ->update(['mentor_id' => $mentors[array_rand($mentors,1)]]);
            }

        }else{
            $supervisor->is_confirm = 1;
            $message = "Successfully Activate Account";
        }
        $supervisor->save();

        toastr()->success($message);

        return redirect('/dashboard/institutions/'.$institution->id.'/supervisors');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Institution $institution, Mentor $supervisor)
    {
        $supervisor = Mentor::find($supervisor->id);

        $mentors = Mentor::inRandomOrder()
                        ->where('institution_id',$institution->id)
                        ->where('is_confirm',1)
                        ->where('id', '!=', $supervisor->id)->get()->pluck('id')->toArray();

        $students = Student::where('mentor_id', $supervisor->id)->get();
        foreach ($students as $student) {
            DB::table('students')
            ->where('id', $student->id)
            ->update(['mentor_id' => $mentors[array_rand($mentors,1)]]);
        }
        $supervisor->delete();


        $message = "Successfully Delete Account";

        toastr()->success($message);

        return redirect('/dashboard/institutions/'.$institution->id.'/supervisors');
    }

    // Register mentor
    public function register($email)
    {
        $emails = (new SimintEncryption)->decData($email);
        $checkMentor = Mentor::where('email', $emails)->where('is_confirm',0)->first();
        if(!$checkMentor){
            return redirect()->route('index');
        }elseif($checkMentor){
            $GetInstituionData = (new InstitutionController)->GetInstituionData();
            return view('mentor.index', compact(['checkMentor','GetInstituionData','email']));
        }
    }

    // Assigned mentor project

    public function indexAssigned()
    {
        $mentor = Mentor::find(Auth::guard('mentor')->user()->id);
        // dd($mentor);
        return view('dashboard.mentors.assigned.index', compact('mentor'));
    }

    public function sectionProjectAssign($project_id)
    {
        $project = Project::find($project_id);
        $project_sections =  ProjectSection::where('project_id', $project_id)->get();
        return view('dashboard.mentors.assigned.section.index', compact(['project', 'project_sections']));
    }

    public function subsectionProjectAssign($project_id, $section_id)
    {
        $project = Project::find($project_id);
        $project_section = ProjectSection::find($section_id);
        $project_subsections =  SectionSubsection::where('project_section_id', $section_id)->get();
        // dd($project_subsections->submission);
        return view('dashboard.mentors.assigned.section.subsection.index', compact(['project' ,'project_section', 'project_subsections']));
    }

    public function showAllStudentsChats($project_id, $section_id)
    {
        $enrolled_students = EnrolledProject::where('project_id', $project_id)->get();
        // dd($enrolled_students);
        return view('dashboard.mentors.assigned.section.chat.index', compact(['project_id','section_id','enrolled_students']));
    }

    public function singleStudentChat($project_id, $section_id, $student_id)
    {
        $comments = Comment::where('project_id', $project_id)->where('project_section_id', $section_id)->get();
        return view('dashboard.mentors.assigned.section.chat.show', compact(['project_id','section_id','student_id','comments']));
    }

}
