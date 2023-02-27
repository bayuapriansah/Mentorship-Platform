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
            $projects = Project::where('institution_id', Auth::guard('student')->user()->institution_id)
                        ->where('status', 'publish')
                        ->orWhere('institution_id', null)
                        ->where('status', 'publish')
                        ->whereNotIn('id', function($query){
                            $query->select('project_id')->from('enrolled_projects');
                            $query->where('student_id',Auth::guard('student')->user()->id);
                        })->take(3)->get();
        }else{
            $projects = Project::take(3)->get();
        }
        return view('index', compact('projects'));
    }
}
