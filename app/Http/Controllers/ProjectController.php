<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $projects = Project::with(['student', 'company'])->where('status','publish')->get();
        return view('dashboard.projects.index', compact('projects'));
    }

    public function draftIndex()
    {
        $projects = Project::with(['student', 'company'])->where('status','draft')->get();
        return view('dashboard.projects.index', compact('projects'));
    }

    public function dashboardIndexCreate()
    {
        return view('dashboard.projects.create');
    }
    
    public function dashboardIndexStore(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'domain' => ['required'],
            'problem' => ['required'],
            'resources' => ['required'],
            'valid_time' => ['required']
        ]);
        $project = new Project;
        if ($request->has('publish')){
            $project->name = $validated['name'];
            $project->project_domain = $validated['domain'];
            $project->problem = $validated['problem'];
            $project->company_id = Auth::guard('company')->user()->id;
            $project->resources = Storage::disk('public')->put('projects/resources', $request->file('resources'));
            $project->valid_time = $validated['valid_time'];
            $project->status = 'publish';
            $project->is_enrolled = 0;
            $project->save();
        }elseif($request->has('draft')){
            $project->name = $validated['name'];
            $project->project_domain = $validated['domain'];
            $project->problem = $validated['problem'];
            $project->company_id = Auth::guard('company')->user()->id;
            $project->resources = Storage::disk('public')->put('projects/resources', $request->file('resources'));
            $project->valid_time = $validated['valid_time'];
            $project->status = 'draft';
            $project->is_enrolled = 0;
            $project->save();
        };
        return redirect('/dashboard/projects');
    }

    public function dashboardIndexEdit(Project $project)
    {
        return view('dashboard.projects.edit', compact('project'));
    }

    public function dashboardIndexUpdate(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => ['required'],
            'project_domain' => ['required'],
            'problem' => ['required'],
            'valid_time' => ['required']
        ]);

        $project = Project::findOrFail($request->id);
        if($project->status == 'publish'){
            $project->name = $validated['name'];
            $project->project_domain = $validated['project_domain'];
            $project->problem = $validated['problem'];
            if($request->hasFile('resources')){
                $resource = Storage::disk('public')->put('projects/resources', $request->file('resources'));
                $project->resources = $resource;
            }
            $project->valid_time = $validated['valid_time'];
            $project->save();
            return redirect('dashboard/projects')->with('success','Project has been edited');
        }elseif($project->status == 'draft'){
            $project->name = $validated['name'];
            $project->project_domain = $validated['project_domain'];
            $project->problem = $validated['problem'];
            if($request->hasFile('resources')){
                $resource = Storage::disk('public')->put('projects/resources', $request->file('resources'));
                $project->resources = $resource;
            }
            $project->valid_time = $validated['valid_time'];
            $project->save();
            return redirect('dashboard/projects/draft')->with('success','Project has been edited');
        };
        
    }

    public function publish($id)
    {
        $project = Project::findOrFail($id);
        $project->status = 'publish';
        $project->save();
        return redirect('dashboard/projects')->with('success','Project has been published');
    }


    public function dashboardIndexDestroy($id)
    {
        $project = Project::find($id);
        $project->delete();
        return redirect('dashboard/projects');
    }
}
