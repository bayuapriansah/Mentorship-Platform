<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Student;
use App\Models\Mentor;
use App\Models\EnrolledProject;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

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
      $students   = Student::get()->count();
      $mentors    = Mentor::get()->count();
      $eProjects  = EnrolledProject::get()->count();
      $companies  = Company::get()->count();
      return view('dashboard.index', compact('students','mentors','eProjects','companies'));
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
}
