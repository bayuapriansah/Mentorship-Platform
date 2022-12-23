<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        return view('projects.index', compact('projects'));
    }

    public function show($id)
    {
        $project = Project::find($id);
        return view('projects.show', compact('project'));
    }

    public function dashboardIndex()
    {
        $projects = Project::with(['student', 'company'])->get();
        return view('dashboard.projects.index', compact('projects'));
    }

    public function dashboardIndexCreate()
    {
        dd('test');
    }
}
