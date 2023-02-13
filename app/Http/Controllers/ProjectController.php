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
use App\Http\Controllers\InstitutionController;
use App\Models\Institution;

class ProjectController extends Controller
{
    public function index()
    {
        if(Auth::guard('student')->check()){
            $projects = Project::whereNotIn('id', function($query){
                $query->select('project_id')->from('enrolled_projects');
                $query->where('student_id',Auth::guard('student')->user()->id);
            })->where('institution_id', Auth::guard('student')->user()->institution_id)->where('status', 'publish')->get();
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
            $GetInstituionData = (new InstitutionController)->GetInstituionData();
            return view('dashboard.projects.create', compact('companies','GetInstituionData'));
        }
        return view('dashboard.projects.create');
    }

    public function dashboardIndexStore(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => ['required'],
            'domain' => ['required'],
            'problem' => ['required'],
            'type' => ['required'],
            'period' => ['required', 'lte:3'],
            'company_id'  => Auth::guard('web')->check() ? ['required'] : '' ,
            'institution_id' => ['required'],
        ]);
        $project = new Project;
        if(Auth::guard('web')->check()){
            $project->name = $validated['name'];
            $project->project_domain = $validated['domain'];
            $project->problem = $validated['problem'];
            $project->company_id = $request->company_id;
            $project->institution_id = $validated['institution_id'];
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
            // $institution = Institution::get();
            $GetInstituionData = (new InstitutionController)->GetInstituionData();
            return view('dashboard.projects.edit', compact(['project','companies','GetInstituionData']));
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
            'institution_id' => ['required'],

        ]);

        $project = Project::findOrFail($request->id);
        if(Auth::guard('web')->check()){
            $project->name = $validated['name'];
            $project->project_domain = $validated['project_domain'];
            $project->problem = $validated['problem'];
            $project->company_id = $request->company_id;
            $project->institution_id = $validated['institution_id'];
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
                                            ->where('is_submited', 0)->latest()->first();
        // $already_completed = EnrolledProject::where('student_id',Auth::guard('student')->user()->id)
        //                                     ->where('is_submited', 1)->first();
        // dd($already_enrolled);
        if(Auth::guard('student')->check()){
            if($already_enrolled == null ){
                $enrolled_project->student_id = Auth::guard('student')->user()->id;
                $enrolled_project->project_id = $id;
                $enrolled_project->is_submited = 0;
                $enrolled_project->save();
                return redirect('/profile/'.Auth::guard('student')->user()->id .'/allProjects')->with('success', 'Selected project has been applied');
            }else{
                return redirect('/profile/'.Auth::guard('student')->user()->id.'/allProjectsAvailable/'.$id.'/detail')->with('error', 'Kindly complete your ongoing project');
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
        // dd($request->all());
        $validated = $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'inputfiletype' => ['required'],
            'duration' => ['required']
        ]);
        $project_section = new ProjectSection;
        $latest_item = ProjectSection::where('project_id', $project_id)->orderByDesc('section')->first();
        if($latest_item==null){
            $project_section->section    = 1;
        }else{
            $project_section->section    = $latest_item->section+1;
        }
        $project_section->project_id = $project_id;
        $project_section->title = $validated['title'];
        $project_section->description = $validated['description'];
        $project_section->file_type = $validated['inputfiletype'];
        $project_section->duration = $validated['duration'];
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
        $project_section->title = $request->title;
        $project_section->description = $request->desc;
        $project_section->file_type = $request->inputfiletype;
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
                // 'inputfiletype'=>'required',
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

    // activate again for debug
    public function appliedDetail($student_id, $project_id)
    {
        $project = Project::find($project_id);
        $project_sections = ProjectSection::where('project_id', $project_id)->get();
        return view('projects.applied.show', compact('student_id','project', 'project_sections'));
    }

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

    public function partnerProjects(Company $partner)
    {
        $projects = Project::where('company_id', $partner->id)->get();
        return view('dashboard.projects.index', compact('partner', 'projects'));
    }

    public function partnerProjectsCreate(Company $partner)
    {
        $institutions = Institution::get();
        return view('dashboard.projects.create', compact('partner', 'institutions'));
    }

    public function partnerProjectsStore(Request $request,Company $partner)
    {
        // dd($request->input('addInjectionCard'));
            // dd($request->all());

        // if ($request->input('Add Injection Card')){
        // }
        $validated = $request->validate([
            'name' => ['required'],
            'domain' => ['required'],
            'period' => ['required'],
            'problem' => ['required'],
            'projectType' => ['required']
            // 'type' => ['required'],
            // 'company_id'  => Auth::guard('web')->check() ? ['required'] : '' ,
            // 'institution_id' => ['required'],
        ],
        [
            'name.required' => 'Project name is required',
            'domain.required' => 'Project domain is required',
            'period.required' => 'Project period is required',
            'problem.required' => 'Project problem is required',
            'projectType.required' => 'Project type is required'
        ]);
        $project = new Project;
        $project->name = $validated['name'];
        $project->project_domain = $validated['domain'];
        $project->period = $validated['period'];
        $project->problem = $validated['problem'];
        $project->type = 'monthly';
        $project->status = 'draft';
        $project->company_id = $partner->id;
        if ($validated['projectType'] == 'private') {
            $project->institution_id = $request->institution_id;
        }
        $project->overview = $request->overview;
        $project->save();

        if($request->input('addInjectionCard')){
            return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/injection');
            // return view('dashboard.partner.partnerProjectsInjection', compact('partner', 'project'));
        }else{
            return redirect('/dashboard/partners/'.$partner->id.'/projects');
        }
    }
    public function partnerProjectsEdit(Company $partner, Project $project)
    {
        $project = Project::find($project->id);
        $cards = ProjectSection::where('project_id', $project->id)->get();
        return view('dashboard.projects.edit', compact('partner', 'project', 'cards'));
    }

    public function partnerProjectsInjection(Company $partner, Project $project)
    {
        return view('dashboard.projects.injection.index', compact('partner', 'project'));
    }

    public function partnerProjectsInjectionStore(Request $request, Company $partner, Project $project)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'inputfiletype' => ['required'],
            'duration' => ['required'],
            'description' => ['required'],
        ],
        [
            'title.required' => 'Title is required',
            'inputfiletype.required' => 'File Type is required',
            'duration.required' => 'Duration is required',
            'description.required' => 'Description is required',
        ]);

        $section  = new ProjectSection;
        $section->project_id = $project->id;
        $section->title = $validated['title'];
        $section->file_type = $validated['inputfiletype'];
        $section->duration = $validated['duration'];
        $section->section = 0;
        $section->description = $validated['description'];
        $section->save();

        if($request->input('addInjectionCard')){
            // return redirect()->back();
            return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/edit');

            // return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/injection');
            // return view('dashboard.partner.partnerProjectsInjection', compact('partner', 'project'));
        }else{
            // /partners/{partner}/projects/{project}/injection/{injection}/attachment
            return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/injection/'.$section->id.'/attachment');
        }
    }

    public function partnerProjectsInjectionEdit(Company $partner, Project $project, ProjectSection $injection)
    {
        $injection = ProjectSection::find($injection->id);
        $attachments = SectionSubsection::where('project_section_id', $injection->id)->get();
        $attachment_id = SectionSubsection::where('project_section_id', $injection->id)->first();
        return view('dashboard.projects.injection.edit', compact('partner', 'project', 'injection', 'attachments', 'attachment_id'));
    }

    public function partnerProjectsInjectionUpdate(Request $request, Company $partner, Project $project, ProjectSection $injection)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'inputfiletype' => ['required'],
            'duration' => ['required'],
            'description' => ['required'],
        ],
        [
            'title.required' => 'Title is required',
            'inputfiletype.required' => 'File Type is required',
            'duration.required' => 'Duration is required',
            'description.required' => 'Description is required',
        ]);

        $section = ProjectSection::findOrFail($injection->id);
        $section->title = $validated['title'];
        $section->file_type = $validated['inputfiletype'];
        $section->duration = $validated['duration'];
        $section->description = $validated['description'];
        if($request->hasFile('file')){
            if(Storage::path($section->file1)) {
                Storage::disk('public')->delete($section->file1);
            }
            // save the new image
            $file = Storage::disk('public')->put('projects/'.$project->id.'/attachment', $request->file);
            $section->file1 = $file;
        }
        $section->save();
        return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/edit');
    }

    public function partnerProjectsInjectionDelete(Company $partner, Project $project, ProjectSection $injection)
    {
        $injection=ProjectSection::find($injection->id);
        $injection->delete();
        return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/edit');
    }

    public function partnerProjectsInjectionAttachment(Company $partner, Project $project, ProjectSection $injection)
    {
        $attachment = SectionSubsection::where('project_section_id', $injection->id)->first();
        return view('dashboard.projects.injection.attachment.index', compact('partner', 'project', 'injection', 'attachment'));
    }

    public function partnerProjectsInjectionAttachmentStore(Request $request, Company $partner, Project $project, ProjectSection $injection)
    {
        $validated = $request->validate([
            'file_input1' => ['required'],
        ],
        [
            'file_input1.required' => 'Attachment 1 is required',
        ]);
        // dd($injection->id);
        $attachment  = new SectionSubsection;
        $attachment->project_section_id = $injection->id;
        if($request->hasFile('file_input1')){
            $file1 = Storage::disk('public')->put('projects/'.$project->id.'/attachment', $validated['file_input1']);
            $attachment->file1 = $file1;
        }
        if($request->hasFile('file_input2')){
            $file2 = Storage::disk('public')->put('projects/'.$project->id.'/attachment', $request->file('file_input2'));
            $attachment->file2 = $file2;
        }
        if($request->hasFile('file_input3')){
            $file3 = Storage::disk('public')->put('projects/'.$project->id.'/attachment', $request->file('file_input3'));
            $attachment->file3 = $file3;
        }
        $attachment->save();
        return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/injection/'.$injection->id.'/edit');
    }

    public function partnerProjectsInjectionAttachmentEdit(Company $partner, Project $project, ProjectSection $injection, SectionSubsection $attachment)
    {
        return view('dashboard.projects.injection.attachment.edit', compact('partner', 'project', 'injection', 'attachment'));
    }

    public function partnerProjectsInjectionAttachmentUpdate(Request $request, Company $partner, Project $project, ProjectSection $injection, SectionSubsection $attachment)
    {

        $attachment = SectionSubsection::find($attachment->id);

        if($request->hasFile('file_input1')){

            if(Storage::path($attachment->file1)) {
                Storage::disk('public')->delete($attachment->file1);
            }

            // save the new image
            $file1 = Storage::disk('public')->put('projects/'.$project->id.'/attachment', $request->file_input1);
            $attachment->file1 = $file1;
        }
        if($request->hasFile('file_input2')){

            // user intends to replace the current image for the category.
            // delete existing (if set)
            if($attachment->file2 != null){
                if(Storage::path($attachment->file2)) {
                    Storage::disk('public')->delete($attachment->file2);
                }
            }
            // save the new image
            $file2 = Storage::disk('public')->put('projects/'.$project->id.'/attachment', $request->file_input2);
            $attachment->file2 = $file2;
        }
        if($request->hasFile('file_input3')){

            // user intends to replace the current image for the category.
            // delete existing (if set)

            if($attachment->file3 != null){
                if(Storage::path($attachment->file3)) {
                    Storage::disk('public')->delete($attachment->file3);
                }
            }

            // save the new image
            $file3 = Storage::disk('public')->put('projects/'.$project->id.'/attachment', $request->file_input3);
            $attachment->file3 = $file3;
        }
        $attachment->save();
        return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/injection/'.$injection->id.'/edit');
    }

    public function partnerProjectsInjectionAttachmentDelete(Company $partner, Project $project, ProjectSection $injection, SectionSubsection $attachment, $key)
    {
        $attachment = SectionSubsection::find($attachment->id);
        if($key==1){
            return back();
        }elseif($key==2){
            if(Storage::path($attachment->file2)) {
                Storage::disk('public')->delete($attachment->file2);
            }
            $attachment->file2 = null;
        }elseif($key==3){
            if(Storage::path($attachment->file3)) {
                Storage::disk('public')->delete($attachment->file3);
            }
            $attachment->file3 == null;
        }
        $attachment->save();
        return back();
    }

}
