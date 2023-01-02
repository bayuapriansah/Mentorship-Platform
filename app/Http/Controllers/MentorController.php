<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Mentor;
use App\Models\Company;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\MentorProject;
use MagicLink\Actions\ResponseAction;
use MagicLink\MagicLink;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mentors = Mentor::where('is_confirm', 1)->get();
        return view('dashboard.mentors.index', compact('mentors'));
    }

    public function registered()
    {
        // $mentors = Mentor::where('is_confirm', 0)->get();
        $companies = Company::get();
        return view('dashboard.mentors.registered', compact('companies'));
    }

    public function invite($company_id)
    {
        $projects = Project::where('company_id', $company_id)->get();
        $company = Company::find($company_id);
        // $mentorProjects = MentorProject::join('mentors', 'mentor.company_id', '=', 'mentor_projects.mentor_id');
        $mentor = Mentor::where('company_id', $company_id)->get();
        // $mentorProjects = MentorProject::with('mentor')->get();
        // $mentorProjects->mentor;
        return view('dashboard.mentors.invite', compact('projects','company','mentor'));
    }
// fungsi nya bisa untuk menambahkan mentor ke banyak project dan ke banyak perusahaan
    public function sendInvite(Request $request,$company_id)
    {   
        // dd($company_id);
        $checkMentor = Mentor::where('email', $request->email)->first();   
        if($checkMentor){
            $checkMentorProject = MentorProject::where('mentor_id', $checkMentor->id)->where('project_id', $request->project_id)->first();
        }
        if(!$checkMentor){
            $mentors = $this->addMentor($request,$company_id);
            $this->addMentorToProject($mentors,$request);
            $sendmail = (new MailController)->EmailMentorInvitation($mentors->email,null);
            $message = "Successfully Send Invitation to Mentor";
            return redirect()->route('dashboard.mentors.registered')->with('success', $message);
        }elseif($checkMentorProject){
            $message = "Mentor Already Exist in this Project";
            return redirect()->route('dashboard.mentors.invite', [$company_id])->with('error', $message);
        }elseif($checkMentor->company_id != $company_id){
            $message = "Mentor can't be assigned to different project in different company";
            return redirect()->route('dashboard.mentors.invite', [$company_id])->with('error', $message);
        }elseif($checkMentor && $checkMentor->is_confirm == 1 && $checkMentor->company_id == $company_id){
            $projects = Project::where('id', $request->project_id)->first();
            $mentors = $this->addMentorToProject($checkMentor,$request);
            $sendmail = (new MailController)->EmailMentor($checkMentor->email,$projects->name);
            $message = "Successfully Send Invitation to Mentor";
            return redirect()->route('dashboard.mentors.invite', [$company_id])->with('success', $message);
        }
    }

    public function addMentor($request,$company_id){
        $mentor = new Mentor;
        $mentor->email = $request->email;
        $mentor->company_id = $company_id;
        $mentor->is_confirm = 0;
        $mentor->save();

        return $mentor;
    }

    public function addMentorToProject($mentor,$request){
        $mentorProject = new MentorProject;
        $mentorProject->mentor_id = $mentor->id;
        $mentorProject->project_id = $request->project_id;
        $mentorProject->save();
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'state' => 'required',
            'country' => 'required',
            'gender' => 'required',
            'position' => 'required',
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

        $mentor = Mentor::find($id);
        $mentor->first_name = $validated['first_name'];
        $mentor->last_name = $validated['last_name'];
        $mentor->state = $validated['state'];
        $mentor->country = $validated['country'];
        $mentor->gender = $validated['gender'];
        $mentor->position = $validated['position'];
        $mentor->is_confirm = 1;
        $mentor->save();
        $sendmail = (new MailController)->EmailMentorRegister($mentor->email);
        $message = "Successfully Register as Mentor, Now you can login to your account";
        return redirect()->route('otp.login')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Register mentor
    public function register($mentor_id)
    {
        $checkMentor = Mentor::where('id', $mentor_id)->where('is_confirm',0)->first();      
        if(!$checkMentor){
            return redirect()->route('index');
        }elseif($checkMentor){
            $checkCompany = Company::where('id', $checkMentor->company_id)->first();
            return view('mentor.index', compact(['checkMentor','checkCompany']));
        }
    }
}
