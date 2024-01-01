<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    public function index()
    {
        $user = Auth::guard('student');

        // Generating a unique cache key based on the user status and ID
        $cacheKey = $user->check() ? 'projects_student_' . $user->user()->id : 'projects_general';

        $projects = Cache::remember($cacheKey, now()->addWeek(), function () use ($user) {
            if ($user->check()) {
                return Project::whereNotIn('id', function ($query) use ($user) {
                            $query->select('project_id')->from('enrolled_projects');
                            $query->where('student_id', $user->user()->id);
                        })->where('institution_id', $user->user()->institution_id)
                          ->where('status', 'publish')
                          ->orWhere('institution_id', null)->whereNotIn('id', function ($query) use ($user) {
                            $query->select('project_id')->from('enrolled_projects');
                            $query->where('student_id', $user->user()->id);
                          })
                          ->where('status', 'publish')
                          ->take(3)->get();
            } else {
                return Project::where('status', 'publish')->take(3)->get();
                // return Project::where('status', 'publish')->get();
            }
        });

        return view('index', compact('projects'));
    }

    public function newindex()
    {
        $authStudent = Auth::guard('student')->user();
        $studentId = optional($authStudent)->id;
        $institutionId = optional($authStudent)->institution_id;

        $projects = Cache::remember('projects.index', 60*60, function () use ($studentId, $institutionId) {
            return Project::query()
                ->where('status', 'publish')
                ->where(function($query) use ($studentId, $institutionId) {
                    $query->where('institution_id', $institutionId)
                        ->orWhere('institution_id', null);
                })
                ->whereNotIn('id', function($query) use ($studentId) {
                    $query->select('project_id')
                        ->from('enrolled_projects')
                        ->where('student_id', $studentId);
                })
                ->get();
        });

        return view('newindex', compact('projects'));
    }

}
