<?php

namespace App\Http\Controllers\Student;

use App\Models\Project;
use App\Models\Student;
use App\Models\Institution;
use Illuminate\Http\Request;
use App\Models\ProjectSection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CreateProjectController extends Controller
{
    public function index()
    {
        $teamName = Auth::guard('student')->user()->team_name;

        // Check if a project with the same team_name already exists
        $existingProject = Project::where('team_name', $teamName)->first();

        if ($existingProject) {
            // Redirect to the edit route with the existing project's ID
            return redirect()->route('participant.projects.edit', ['project' => $existingProject->id]);
        }

        $project = new Project;
        $project->name = $teamName;
        $project->project_domain = " ";
        $project->problem = "<p><span style='color: #999;' data-mce-style='color: #999;'> -Problem Statement, Project Objective, or Use Case Description<br>-Model Type<br>-Current Performance Metrics<br>-Summary of Future Goals/Expectations<br></span></p>";
        $project->type = "weekly";
        $project->period = 10;
        $project->status = 'draft';
        $project->team_name = $teamName;
        $project->company_id = 1;
        $project->dataset = [];
        $project->overview = "Write a 2 - 3 sentence description of your project.";
        $project->save();
        $message = "Successfully created a project";

        toastr()->success($message);
        // Redirect to the edit route with the new project's ID
        return redirect()->route('participant.projects.edit', ['project' => $project->id]);

    }

    public function indexView()
    {
        return view('student.project.create', $this->generateFakeLayoutData());
    }

    // for project
    public function editproject(Project $project)
    {
        $teamName = Auth::guard('student')->user()->team_name;

        // Check if a project with the same team_name already exists
        $existingProject = Project::where('team_name', $teamName)->first();

        if ($existingProject->id != $project->id) {
            // Redirect to the edit route with the existing project's ID
            return redirect()->back();
        }

        $formAction = route('participant.projects.update', ['project' => $project->id]);
        $cards = ProjectSection::where('project_id', $project->id)->get();
        $institutions = Institution::get();
        return view('student.project.edit', compact(
            'project',
            'formAction',
            'cards',
            'institutions'
        ), $this->generateFakeLayoutData());
    }

    // For Injection
    public function addProjectTask(Project $project)
    {
        $backUrl = route('participant.projects.update', ['project' => $project->id]);
        // $formAction = route('dashboard.projects.storeSection', ['project' => $project->id]);

        return view('student.project.add-task', compact(
            'project',
            'backUrl',
            // 'formAction',
        ), $this->generateFakeLayoutData());
    }

    public function addTask()
    {
        return view('student.project.add-task', $this->generateFakeLayoutData());
    }

    public function editTask()
    {
        return view('student.project.edit-task', $this->generateFakeLayoutData());
    }

    private function generateFakeLayoutData()
    {
        return [
            'student' => auth()->user(),
            'newActivityNotifs' => new \Illuminate\Database\Eloquent\Collection(),
            'newNotifTask' => new \Illuminate\Database\Eloquent\Collection(),
            'notifNewTasks' => new \Illuminate\Database\Eloquent\Collection(),
            'notifActivityCount' => 0,
            'newMessage' => 0,
            'completed_months' => new \Illuminate\Database\Eloquent\Collection(),
            'enrolled_projects' => new \Illuminate\Database\Eloquent\Collection(),
            'dataDate' => (new \App\Http\Controllers\SimintEncryption)->daycompare(auth()->user()->created_at,auth()->user()->end_date),
        ];
    }

    public function projectUpdate(Request $request, Project $project)
    {
        $teamName = Auth::guard('student')->user()->team_name;

        // dd($request->all());

        $validated = $request->validate([
            'name' => ['required'],
            'project_domain' => ['required', 'in:nlp,statistical,computer_vision'],
            // 'type' => ['required'],
            // 'period' => ['required'],
            // 'projectType' => ['required'],
            'problem' => ['required'],
            // 'overview' => ['optional'],
            'dataset' => ['required'],
        ],
        [
            'name.required' => 'Project name is required',
            'project_domain.required' => 'Project domain is required',
            'project_domain.in' => 'The selected project domain is invalid',
            // 'type.required' => 'Project type is required',
            // 'period.required' => 'Project period is required',
            // 'projectType.required' => 'Project type is required',
            'problem.required' => 'Project problem is required',
            'dataset.required' => 'Dataset is required',
        ]);

        $project_update = Project::findOrFail($project->id);
        // dd($project_update);
        // if(Auth::guard('web')->check()){
        $project_update->name = $validated['name'];
        $project_update->project_domain = $validated['project_domain'];
        $project_update->problem = $validated['problem'];
        $project_update->overview = $request->overview;
        $project_update->dataset = $request->dataset;

        $project_update->save();

        toastr()->success('Project has been updated');

        return redirect()->route('student.allProjects', ['student' => Auth::guard('student')->user()->id]);
    }
}
