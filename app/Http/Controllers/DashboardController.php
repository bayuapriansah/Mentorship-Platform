<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Project;
use App\Models\Student;
use App\Models\Customer;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\ProjectSection;

use App\Models\EnrolledProject;
use Illuminate\Validation\Rule;
use App\Models\SectionSubsection;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
      $students   = Student::get()->count();
      $mentors    = Mentor::get()->count();
      $eProjects  = EnrolledProject::get()->count();
      $companies  = Company::get()->count();
      return view('dashboard.index', compact('students','mentors','eProjects','companies'));
    }

    public function indexCustomer()
    {
      $internshipsTotal  = EnrolledProject::whereHas('project', function($q){
        $q->where('company_id', Auth::guard('customer')->user()->company_id);
      })->get()->count();

      $internshipsOngoing = EnrolledProject::where('is_submited', 0)->whereHas('project', function($q){
        $q->where('company_id', Auth::guard('customer')->user()->company_id);
      })->get()->count();
      
      $customerTotal = Customer::where('company_id', Auth::guard('customer')->user()->company_id)->get()->count();

      $student_submissions = Submission::whereHas('project', function($q){
        $q->where('company_id', Auth::guard('customer')->user()->company_id);
      })->count();

      return view('dashboard.index', compact('internshipsTotal', 'internshipsOngoing', 'customerTotal', 'student_submissions'));
    }

    public function indexMentor()
    {
      $students   = Student::where('institution_id', Auth::guard('mentor')->user()->institution_id)->get()->count();
      $assign_students   = Student::where('mentor_id', Auth::guard('mentor')->user()->id)->get()->count();
      $mentors    = Mentor::where('institution_id', Auth::guard('mentor')->user()->institution_id)->get()->count();
      // dd($mentors);
      $student_submissions = Submission::whereHas('student', function($q){
        $q->where('mentor_id', Auth::guard('mentor')->user()->id);
      })->count();
      return view('dashboard.index', compact('students','assign_students','mentors','student_submissions'));
    }

    public function allAssignedProjectsBEST()
    {
      $projects = Project::all();
      $enrolledProjects = EnrolledProject::select('project_id')->groupBy('project_id')->get();
      $totalStudents = EnrolledProject::selectRaw('count(DISTINCT student_id) as total, project_id')->groupBy('project_id')->get();

      return view('dashboard.admin.assignedProjects', compact('projects', 'enrolledProjects', 'totalStudents'));
    }

    public function allAssignedProjects()
    {
      $projects = Project::all();
      $enrolledProjects = EnrolledProject::all();
      return view('dashboard.admin.assignedProjects', compact('projects', 'enrolledProjects'));
    }

    public function sectionProjectAssign($project_id)
    {
        $project = Project::find($project_id);
        $project_sections =  ProjectSection::where('project_id', $project_id)->get();
        return view('dashboard.admin.assigned.section.index', compact(['project', 'project_sections']));
    }

    public function subsectionProjectAssign($project_id, $section_id)
    {
        $project = Project::find($project_id);
        $project_section = ProjectSection::find($section_id);
        $project_subsections =  SectionSubsection::where('project_section_id', $section_id)->get();
        // dd($project_subsections->submission);
        return view('dashboard.admin.assigned.section.subsection.index', compact(['project' ,'project_section', 'project_subsections']));
    }

    public function showAllStudentsChats($project_id, $section_id)
    {
        $enrolled_students = EnrolledProject::where('project_id', $project_id)->get();
        // dd($enrolled_students);
        return view('dashboard.admin.assigned.section.chat.index', compact(['project_id','section_id','enrolled_students']));
    }

    public function singleStudentChat($project_id, $section_id, $student_id)
    {
        $comments = Comment::where('project_id', $project_id)->where('project_section_id', $section_id)->get();
        return view('dashboard.admin.assigned.section.chat.show', compact(['project_id','section_id','student_id','comments']));
    }

    public function showAllStudentsSubmission($project_id, $section_id)
    {
        $enrolled_students = EnrolledProject::where('project_id', $project_id)->get();
        return view('dashboard.admin.assigned.section.submission.index', compact(['project_id','section_id','enrolled_students']));
    }

    public function singleStudentSubmission($project_id, $section_id, $student_id)
    {
        $submission = Submission::where('project_id', $project_id)->where('section_id', $section_id)->where('student_id', $student_id)->first();
        return view('dashboard.admin.assigned.section.submission.show', compact(['project_id','section_id','student_id','submission']));
    }

    // Profile

    public function profile($id){
      if (Auth::guard('web')->check()) {
          # code...
      }elseif(Auth::guard('mentor')->check()){
        $user = Mentor::find($id);
      }elseif(Auth::guard('customer')->check()){
        $user = Customer::find($id);

      }
      return view('dashboard.admin.profile.edit', compact('user'));
    }

    public function updateProfile(Request $request, $id){
      // dd($request->all()); 
      if (Auth::guard('web')->check()) {
        # code...
      }elseif(Auth::guard('mentor')->check()){
        $validated = $request->validate([
          'first_name' => ['required'],
          'last_name' => ['required'],
          'email' => ['required'],
          'institution' => ['required'],
          'state' => ['required'],
          'country' => ['required'],
          'sex' => ['required'],
          'position' => ['required'],
          'password' => ['nullable', 'min:5', 'confirmed', Rule::requiredIf(function () use ($request) {
            return !empty($request->input('password'));
          })],
          'password_confirmation' => ['nullable', Rule::requiredIf(function () use ($request) {
              return !empty($request->input('password'));
          })]
        ],
        [
          'first_name.required' => 'First name is required',
          'last_name.required' => 'Last name is required',
          'email.required' => 'Email is required',
          'institution.required' => 'Institution is required',
          'state.required' => 'State is required',
          'country.required' => 'Country is required',
          'sex.required' => 'Sex is required',
          'position.required' => 'Position is required',
          'password.confirmed' => 'Password confirmation must be the same',
          'password_confirmation.required'=> 'Please enter your confirmation password',
        ]);
        // dd($request->all());
        $mentor = Mentor::find($id);
        $mentor->first_name = $validated['first_name'];
        $mentor->last_name = $validated['last_name'];
        $mentor->sex = $validated['sex'];
        $mentor->position = $validated['position'];
        if(!empty($validated['password'])){
        $mentor->password = \Hash::make($validated['password']);
        }
        $mentor->save();
        return back()->with('successTailwind', 'Profile Edited');
      }elseif(Auth::guard('customer')->check()){
        $validated = $request->validate([
          'first_name' => ['required'],
          'last_name' => ['required'],
          'email' => ['required'],
          'company' => ['required'],
          'sex' => ['required'],
          'position' => ['required'],
          'password' => ['nullable', 'min:5', 'confirmed', Rule::requiredIf(function () use ($request) {
            return !empty($request->input('password'));
          })],
          'password_confirmation' => ['nullable', Rule::requiredIf(function () use ($request) {
              return !empty($request->input('password'));
          })]
        ],
        [
          'first_name.required' => 'First name is required',
          'last_name.required' => 'Last name is required',
          'email.required' => 'Email is required',
          'company.required' => 'Institution is required',
          'sex.required' => 'Sex is required',
          'position.required' => 'Position is required',
          'password.confirmed' => 'Password confirmation must be the same',
          'password_confirmation.required'=> 'Please enter your confirmation password',
        ]);

        $customer = Customer::find($id);
        $customer->first_name = $validated['first_name'];
        $customer->last_name = $validated['last_name'];
        $customer->sex = $validated['sex'];
        $customer->position = $validated['position'];
        if(!empty($validated['password'])){
        $customer->password = \Hash::make($validated['password']);
        }
        $customer->save();
        return back()->with('successTailwind', 'Profile Edited');
      } 
      return back();
    }
}
