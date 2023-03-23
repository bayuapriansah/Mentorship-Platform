<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
      if(Auth::guard('student')->check()){
          $projects = Project::whereNotIn('id', function($query){
                          $query->select('project_id')->from('enrolled_projects');
                          $query->where('student_id',Auth::guard('student')->user()->id);
                      })->where('institution_id', Auth::guard('student')->user()->institution_id)
                      ->where('status', 'publish')
                      ->orWhere('institution_id', null)->whereNotIn('id', function($query){
                          $query->select('project_id')->from('enrolled_projects');
                          $query->where('student_id',Auth::guard('student')->user()->id);
                      })
                      ->where('status', 'publish')
                      ->take(3)->get();
          
      }else{
          $projects = Project::where('status', 'publish')->take(3)->get();
      }
      return view('index', compact('projects'));
    }

    

  public function forStudents()
  {
    if(Auth::guard('student')->check()){
      $projects = Project::whereNotIn('id', function($query){
                      $query->select('project_id')->from('enrolled_projects');
                      $query->where('student_id',Auth::guard('student')->user()->id);
                  })->where('institution_id', Auth::guard('student')->user()->institution_id)
                  ->where('status', 'publish')
                  ->orWhere('institution_id', null)->whereNotIn('id', function($query){
                      $query->select('project_id')->from('enrolled_projects');
                      $query->where('student_id',Auth::guard('student')->user()->id);
                  })
                  ->where('status', 'publish')
                  ->take(3)->get();
    }else{
        $projects = Project::where('status', 'publish')->take(3)->get();
    }
    return view('forStudents', compact('projects'));
  }
}
