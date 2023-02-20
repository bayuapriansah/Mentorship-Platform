<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Project;
use App\Models\Student;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\ProjectSection;
use App\Models\EnrolledProject;

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

    public function indexCompany()
    {
      return view('dashboard.index');
    }

    public function indexMentor()
    {
      $students   = Student::where('institution_id', Auth::guard('mentor')->user()->institution_id)->get()->count();
      $assign_students   = Student::where('mentor_id', Auth::guard('mentor')->user()->id)->get()->count();
      $mentors    = Mentor::where('institution_id', Auth::guard('mentor')->user()->institution_id)->get()->count();
      // dd($mentors);
      $student_submissions = Submission::get()->count();
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
}
