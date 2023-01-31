<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Student;
use App\Models\Mentor;
use App\Models\EnrolledProject;
use App\Models\Company;

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
      return view('dashboard.index');
    }
}
