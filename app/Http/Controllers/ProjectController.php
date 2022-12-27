<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\EnrolledProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::whereNotIn('id', function($query){
            $query->select('project_id')->from('enrolled_projects');
            $query->where('student_id',Auth::guard('student')->user()->id);
        })->get();
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
        if(Auth::guard('web')->check()){
            $companies = Company::get();
            return view('dashboard.projects.create', compact('companies'));
        }
        return view('dashboard.projects.create');
    }
    
    public function dashboardIndexStore(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'domain' => ['required'],
            'problem' => ['required'],
            'resources' => ['required'],
            'valid_time' => ['required'],
            'company_id'  => Auth::guard('web')->check() ? ['required'] : '' ,
            
        ]);
        $project = new Project;
        if(Auth::guard('web')->check()){
            $project->name = $validated['name'];
            $project->project_domain = $validated['domain'];
            $project->problem = $validated['problem'];
            $project->company_id = $request->company_id;
            $project->resources = Storage::disk('public')->put('projects/resources', $request->file('resources'));
            $project->valid_time = $validated['valid_time'];
            if ($request->has('publish')){
                $project->status = 'publish';
                $project->save();
                return redirect('/dashboard/projects');
            }elseif($request->has('draft')){
                $project->status = 'draft';
                $project->save();
                return redirect('/dashboard/projects/draft');
            };

        }elseif(Auth::guard('company')->check()){
            $project->name = $validated['name'];
            $project->project_domain = $validated['domain'];
            $project->problem = $validated['problem'];
            $project->company_id = Auth::guard('company')->user()->id;
            $project->resources = Storage::disk('public')->put('projects/resources', $request->file('resources'));
            $project->valid_time = $validated['valid_time'];
            if ($request->has('publish')){
                $project->status = 'publish';
                $project->save();
                return redirect('/dashboard/projects');

            }elseif($request->has('draft')){
                $project->status = 'draft';
                $project->save();
                return redirect('/dashboard/projects/draft');
            };
        }
    }

    public function dashboardIndexEdit(Project $project)
    {
        if(Auth::guard('web')->check()){
            $companies = Company::get();
            return view('dashboard.projects.edit', compact(['project','companies']));
        }
        return view('dashboard.projects.edit', compact('project'));
    }

    public function dashboardIndexUpdate(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => ['required'],
            'project_domain' => ['required'],
            'problem' => ['required'],
            'valid_time' => ['required','numeric','min:3', 'max:7'],
            'company_id'  => Auth::guard('web')->check() ? ['required'] : '' ,

        ]);

        $project = Project::findOrFail($request->id);
        if(Auth::guard('web')->check()){
            $project->name = $validated['name'];
            $project->project_domain = $validated['project_domain'];
            $project->problem = $validated['problem'];
            $project->company_id = $request->company_id;
            if($request->hasFile('resources')){
                $resource = Storage::disk('public')->put('projects/resources', $request->file('resources'));
                $project->resources = $resource;
            }
            $project->valid_time = $validated['valid_time'];
            if($project->status == 'publish'){
                $project->save();
                return redirect('dashboard/projects')->with('success','Project has been edited');
            }elseif($project->status == 'draft'){
                $project->save();
                return redirect('dashboard/projects/draft')->with('success','Project has been edited');
            };
        }elseif(Auth::guard('company')->check()){
            $project->name = $validated['name'];
            $project->project_domain = $validated['project_domain'];
            $project->problem = $validated['problem'];
            if($request->hasFile('resources')){
                $resource = Storage::disk('public')->put('projects/resources', $request->file('resources'));
                $project->resources = $resource;
            }
            $project->valid_time = $validated['valid_time'];
            if($project->status == 'publish'){
                $project->save();
                return redirect('dashboard/projects')->with('success','Project has been edited');
            }elseif($project->status == 'draft'){
                $project->save();
                return redirect('dashboard/projects/draft')->with('success','Project has been edited');
            };
        }
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

    public function applyProject($id)
    {
        $enrolled_project = new EnrolledProject;
        $already_enrolled =  EnrolledProject::where('student_id',Auth::guard('student')->user()->id)
                                            ->where('project_id',$id)->first();
        if($already_enrolled == null ){
            $enrolled_project->student_id = Auth::guard('student')->user()->id;
            $enrolled_project->project_id = $id;
            $enrolled_project->is_submited = 0;
            $enrolled_project->save();
            return redirect('projects')->with('success', 'Selected project has been applied');
        }
        
    }

    public function applied($id)
    {
        $applied_project = EnrolledProject::where('student_id', $id)->get();
        return view('projects.applied', compact('applied_project'));
    }

    public function submission($student_id, $enrolled_project_id)
    {
        $enrolled_project = EnrolledProject::find($enrolled_project_id);
        return view('projects.submission', compact('enrolled_project'));
    }

    public function submit(Request $request,$student_id, $enrolled_project_id)
    {
        $validated = $request->validate([
            'submission' => ['required'],
        ]);
        $enrolled_project = EnrolledProject::where('student_id',$student_id)
                                            ->where('project_id',$enrolled_project_id)
                                            ->update(['is_submited'=>1]);
        $submission = new Submission;
        $submission->enrolled_project_id = $enrolled_project_id;
        $submission->student_id = $student_id;
        if($request->hasFile('submission')){
            $file = Storage::disk('public')->put('projects/submission', $validated['submission']);
            $submission->file = $file;
        }
        $submission->save();
        return back()->with('success','Project has been submited');
    }
}
