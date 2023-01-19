<?php

namespace App\Http\Controllers;

use File;
use App\Models\Search;
use App\Models\Company;
use App\Models\Project;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\ProjectSection;
use App\Models\EnrolledProject;
use App\Models\SectionSubsection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {   
        if(Auth::guard('student')->check()){
            $projects = Project::whereNotIn('id', function($query){
                $query->select('project_id')->from('enrolled_projects');
                $query->where('student_id',Auth::guard('student')->user()->id);
            })->get();
        }else{
            $projects = Project::get();
        }
        
        return view('projects.index', compact('projects'));
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $search = new Search;
        if($keyword != null){
            if(Auth::guard('student')->check()){
                $search->comments = $keyword;
                $search->searcher = Auth::guard('student')->user()->email;
            }else{
                $search->comments = $keyword;
            }
            $search->save();
        }
        $projects = Project::where('name', 'like', "%" . $keyword . "%")->get();
        // return view('projects.index', compact('projects'));
    }

    public function show($id)
    {
        $project = Project::find($id);
        $project_sections = ProjectSection::where('project_id', $id)->get();
        return view('projects.show', compact(['project','project_sections']));
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
        // dd($request);
        $validated = $request->validate([
            'name' => ['required'],
            'domain' => ['required'],
            'problem' => ['required'],
            'type' => ['required'],
            'period' => ['required', 'lte:3'],
            'company_id'  => Auth::guard('web')->check() ? ['required'] : '' ,
            
        ]);
        $project = new Project;
        if(Auth::guard('web')->check()){
            $project->name = $validated['name'];
            $project->project_domain = $validated['domain'];
            $project->problem = $validated['problem'];
            $project->company_id = $request->company_id;
            $project->type = $validated['type'];
            $project->period = $validated['period'];
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
            $project->type = $validated['type'];
            $project->period = $validated['period'];
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
            'type' => ['required'],
            'period' => ['required'],
            'company_id'  => Auth::guard('web')->check() ? ['required'] : '' ,

        ]);

        $project = Project::findOrFail($request->id);
        if(Auth::guard('web')->check()){
            $project->name = $validated['name'];
            $project->project_domain = $validated['project_domain'];
            $project->problem = $validated['problem'];
            $project->company_id = $request->company_id;
            $project->type = $validated['type'];
            $project->period = $validated['period'];
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
        $already_completed = EnrolledProject::where('student_id',Auth::guard('student')->user()->id)
                                            ->where('is_submited', 1)->first();
        // dd($already_completed);
        if(Auth::guard('student')->check()){
            if($already_enrolled == null ){
                if($already_completed){
                    $enrolled_project->student_id = Auth::guard('student')->user()->id;
                    $enrolled_project->project_id = $id;
                    $enrolled_project->is_submited = 0;
                    $enrolled_project->save();
                    return redirect('/profile/'.Auth::guard('student')->user()->id .'/allProjects')->with('success', 'Selected project has been applied');
                }else{
                    return redirect('/profile/'.Auth::guard('student')->user()->id.'/allProjectsAvailable/'.$id.'/detail');
                }
            }
        }else{
            return redirect('auth.otplogin');
        }                                          
        
        
    }

    // SECTION
    public function dashboardIndexSection($project_id)
    {
        // $project = Project::findOrFail($request->id);

        $project = Project::find($project_id);
        $project_sections =  ProjectSection::where('project_id', $project_id)->get();
        return view('dashboard.projects.section.index', compact(['project', 'project_sections']));
    }

    public function dashboardIndexStoreSection($project_id, Request $request)
    {
        $validated = $request->validate([
            'description' => ['required'],
        ]);
        $project_section = new ProjectSection;
        $latest_item = ProjectSection::where('project_id', $project_id)->orderByDesc('section')->first();
        if($latest_item==null){
            $project_section->section    = 1;
        }else{
            $project_section->section    = $latest_item->section+1;
        }
        $project_section->project_id = $project_id;
        $project_section->description = $validated['description'];
        $project_section->save();

        return redirect('dashboard/projects/'.$project_id.'/section')->with('success','Project section has been created');
    }

    public function dashboardIndexEditSection($project_id, $section_id)
    {
        $project_section = ProjectSection::find($section_id);
        return view('dashboard.projects.section.edit', compact(['project_id','section_id','project_section']));
    }

    public function dashboardIndexUpdateSection($project_id, $section_id, Request $request)
    {
        $project_section = ProjectSection::find($section_id);
        $project_section->description = $request->desc;
        $project_section->save();
        return redirect('/dashboard/projects/'.$project_id.'/section');
    }

    public function dashboardIndexDestroySection($project_id, $section_id)
    {
        $project_section = ProjectSection::find($section_id);
        $select_bigger_section   = ProjectSection::where('project_id', $project_id)->where('section', '>', $project_section->section)
                                    ->get();
        foreach($select_bigger_section as $item){
            $item->section = $item->section-1;
            $item->save();
        }
        $project_section->delete();
        return redirect('/dashboard/projects/'.$project_id.'/section');
    }

    public function dashboardIndexSectionUp(Request $request,$project_id ,$section_id)
    {

        $project_section = ProjectSection::find($section_id);
        $project_section->section = $project_section->section-1;
        $select_smaller_section   = ProjectSection::where('project_id', $project_id)
                                    ->where('section', '=', $project_section->section)
                                    ->orderByDesc('section')
                                    ->first();
        if($select_smaller_section != null){
            $section = ProjectSection::find($select_smaller_section->id);
            $section->section = $select_smaller_section->section+1;
            $section->save();
        }else{
            return back();
        }
        
        $project_section->save();
        return back();
    }

    public function dashboardIndexSectionDown(Request $request,$project_id ,$section_id)
    {
        $project_section = ProjectSection::find($section_id);
        $project_section->section = $project_section->section+1;
        $select_smaller_section   = ProjectSection::where('project_id', $project_id)
                                    ->where('section', '=', $project_section->section)
                                    ->orderByDesc('section')
                                    ->first();
        if($select_smaller_section != null){
            $section = ProjectSection::find($select_smaller_section->id);
            $section->section = $select_smaller_section->section-1;
            $section->save();
        }else{
            return back();
        }
        
        $project_section->save();
        return back();
    }

    // SUBSECTION
    public function dashboardIndexSubsection($project_id, $section_id)
    {
        $project = Project::find($project_id);
        $project_section = ProjectSection::find($section_id);
        $project_subsections =  SectionSubsection::where('project_section_id', $section_id)->get();
        return view('dashboard.projects.section.subsection.index', compact(['project' ,'project_section', 'project_subsections']));
    }

    public function dashboardCreateSubsection ($project_id, $section_id)
    {
        $project = Project::find($project_id);
        $section = ProjectSection::find($section_id);

        return view('dashboard.projects.section.subsection.create', compact(['project', 'section']));
    }

    public function dashboardStoreSubsection($project_id, $section_id, Request $request)
    {   
        
        if($request->category == 'video'){
            $validated = $request->validate([
                'video_link' => 'required',
                'category' => 'required',
                'title' => 'required',
                'file1' => 'required',
                'description' => 'required'
            ]);
        }elseif($request->category == 'task'){
            $validated = $request->validate([
                'inputfiletype'=>'required',
                'category' => 'required',
                'title' => 'required',
                'file1' => 'required',
                'description' => 'required'
            ]);
        }

        $validated = $request->validate([
            'category' => 'required',
            'title' => 'required',
            'file1' => 'required',
            'description' => 'required'
        ]);
        $sectionSubsection = new SectionSubsection;
        $sectionSubsection->project_section_id = $section_id;
        $sectionSubsection->title = $validated['title'];
        $sectionSubsection->category = $validated['category'];
        $sectionSubsection->description = $validated['description'];
        if($request->hasFile('file1')){
            $file1 = Storage::disk('public')->put('projects/section/'.$section_id.'/subsection', $validated['file1']);
            $sectionSubsection->file1 = $file1;
        }
        if($request->hasFile('file2')){
            $file2 = Storage::disk('public')->put('projects/section/'.$section_id.'/subsection', $request->file('file2'));
            $sectionSubsection->file2 = $file2;
        }
        if($request->hasFile('file3')){
            $file3 = Storage::disk('public')->put('projects/section/'.$section_id.'/subsection', $request->file('file3'));
            $sectionSubsection->file3 = $file3;
        }
        $sectionSubsection->video_link = $request->video_link;
        if($request->inputfiletype != null){
            $sectionSubsection->file_type = $request->inputfiletype;
        }
        $sectionSubsection->is_submit = 0 ;
        $sectionSubsection->save();
        return redirect('/dashboard/projects/'.$project_id.'/section/'.$section_id.'/subsection');

    }

    public function dashboardEditSubsection($project_id, $section_id, $subsection_id)
    {
        $section_subsection = SectionSubsection::find($subsection_id);
        return view('dashboard.projects.section.subsection.edit', compact(['project_id','section_id','section_subsection']));
    }

    public function dashboardUpdateSubsection($project_id, $section_id, $subsection_id, Request $request)
    {
        if($request->category == 'video'){
            $validated = $request->validate([
                'video_link' => 'required',
                'category' => 'required',
                'title' => 'required',
                'description' => 'required'
            ]);
        }
        if($request->category == 'task'){
            $validated = $request->validate([
                'inputfiletype'=>'required',
                'category' => 'required',
                'title' => 'required',
                'description' => 'required'
            ]);
        }

        $validated = $request->validate([
            'category' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);
        $section_subsection = SectionSubsection::findOrFail($subsection_id);

        $section_subsection->category = $validated['category'];
        $section_subsection->title = $validated['title'];
        $section_subsection->description = $validated['description'];
        if($request->hasFile('file1')){
        
            if(Storage::path($section_subsection->file1)) {
                Storage::disk('public')->delete($section_subsection->file1);
            }
        
            // save the new image
            $file1 = Storage::disk('public')->put('projects/section/'.$section_id.'/subsection', $request->file1);
            $section_subsection->file1 = $file1;
        }
        if($request->hasFile('file2')){

            // user intends to replace the current image for the category.  
            // delete existing (if set)
            if($section_subsection->file2 != null){
                if(Storage::path($section_subsection->file2)) {
                    Storage::disk('public')->delete($section_subsection->file2);
                }
            }
            // save the new image
            $file2 = Storage::disk('public')->put('projects/section/'.$section_id.'/subsection', $request->file2);
            $section_subsection->file2 = $file2;
        }
        if($request->hasFile('file3')){

            // user intends to replace the current image for the category.  
            // delete existing (if set)
        
            if($section_subsection->file3 != null){
                if(Storage::path($section_subsection->file3)) {
                    Storage::disk('public')->delete($section_subsection->file3);
                }
            }
        
            // save the new image
            $file3 = Storage::disk('public')->put('projects/section/'.$section_id.'/subsection', $request->file3);
            $section_subsection->file3 = $file3;
        }
        $section_subsection->video_link = $request->video_link;
        if($request->inputfiletype != null){
            $section_subsection->file_type = $request->inputfiletype;
        }
        $section_subsection->save();
        return redirect('/dashboard/projects/'.$project_id.'/section/'.$section_id.'/subsection');
    }

    public function dashboardDestroySubsection($project_id, $section_id, $subsection_id)
    {
        $section_subsection = SectionSubsection::find($subsection_id);
        if($section_subsection->file1 != null){
            if(Storage::path($section_subsection->file1)) {
                Storage::disk('public')->delete($section_subsection->file1);
            }
        }
        if($section_subsection->file2 != null){
            if(Storage::path($section_subsection->file2)) {
                Storage::disk('public')->delete($section_subsection->file2);
            }
        }
        if($section_subsection->file3 != null){
            if(Storage::path($section_subsection->file3)) {
                Storage::disk('public')->delete($section_subsection->file3);
            }
        }
        $section_subsection->delete();
        return redirect('/dashboard/projects/'.$project_id.'/section/'.$section_id.'/subsection');
    }

    // Student subsection
    public function showSubsection($project_id, $subsection_id)
    {
        $section_subsection = SectionSubsection::find($subsection_id);
        return view('projects.subsection.index', compact(['section_subsection']));
        // return view('projects.show', compact(['project','project_sections']));
    }

    // Student applied
    public function applied($id)
    {
        $applied_project = EnrolledProject::where('student_id', $id)->get();
        return view('projects.applied.index', compact('applied_project'));
    }

    // public function appliedDetail($student_id, $project_id)
    // {
    //     $project = Project::find($project_id);
    //     $project_sections = ProjectSection::where('project_id', $project_id)->get();
    //     return view('projects.applied.show', compact('student_id','project', 'project_sections'));
    // }

    public function appliedSubmission($student_id, $project_id, $section_id, $subsection_id)
    {
        // $check_submission = Submission::where('')
        $section_subsection = SectionSubsection::where('project_section_id', $project_id)->find($subsection_id);

        // dd($section_subsection);
        if ($section_subsection == null) {
            abort(403);
        }
        return view('projects.subsection.index', compact(['student_id','project_id','section_subsection']));
    }

    public function appliedSubmit($student_id, $project_id, $subsection_id,Request $request)
    {
        if($request->hasFile('submission')==true){
            $validated = $request->validate([
                'submission' => ['required'],
            ]);
        }
        
        $subsection = SectionSubsection::find($subsection_id);
        // EnrolledProject::where('student_id',$student_id)
        //                 ->where('project_id',$project_id)
        //                 ->update(['is_submited'=>1]);
        $submission = new Submission;
        $submission->section_subsection_id = $subsection_id;
        $submission->student_id = $student_id;
        $submission->is_complete = 1;
        if($request->hasFile('submission')){
            $file = Storage::disk('public')->put('projects/submission/project/'.$project_id.'/section/'.$subsection->project_section_id.'/subsection/'.$subsection_id, $validated['submission']);
            $submission->file = $file;
        }
        $submission->file = 'null';
        $submission->save();
        return redirect('/projects/'.$student_id.'/applied/'.$project_id.'/detail')->with('success','Project has been submited');
    }

}   
