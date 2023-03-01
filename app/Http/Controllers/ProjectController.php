<?php

namespace App\Http\Controllers;

use File;
use Carbon\Carbon;
use App\Models\Search;
use App\Models\Company;
use App\Models\Project;
use App\Models\Submission;
use App\Models\Institution;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ProjectSection;
use App\Models\EnrolledProject;
use App\Models\SectionSubsection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\InstitutionController;

class ProjectController extends Controller
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
                        ->get();
        }elseif(Auth::guard('mentor')->check()){
            $projects = Project::where('institution_id', Auth::guard('mentor')->user()->institution_id)->orWhere('institution_id', null)->where('status', 'publish')->get();
        }
        else{
            $projects = Project::where('status', 'publish')->get();
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
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->where('project_id', $id)->get();
        $project_sections = ProjectSection::where('project_id', $id)->get();
        return view('projects.show', compact(['project','project_sections','enrolled_projects']));
    }

    public function dashboardIndex()
    {
        // $projects = Project::with(['student', 'company'])->where('status','publish')->get();
        if(Auth::guard('web')->check()){
            $projects = Project::with(['student', 'company'])->get();
            return view('dashboard.projects.index', compact('projects'));
        }elseif(Auth::guard('mentor')->check()){
            $projects = Project::where('institution_id', Auth::guard('mentor')->user()->institution_id)->orWhere('institution_id', null)->with(['student', 'company'])->where('status', 'publish')->get();
            return view('dashboard.projects.index', compact('projects'));
        }elseif(Auth::guard('customer')->check()){
            $projects = Project::where('company_id', Auth::guard('customer')->user()->company_id)->with(['student', 'company'])->get();
            return view('dashboard.projects.index', compact('projects'));
        }
    }

    public function draftIndex()
    {
        $projects = Project::with(['student', 'company'])->where('status','draft')->get();
        return view('dashboard.projects.index', compact('projects'));
    }

    public function dashboardIndexCreate()
    {
        $partners = Company::get();
        $institutions = Institution::get();
        return view('dashboard.projects.create', compact('partners','institutions'));
    }

    public function dashboardIndexStore(Request $request)
    {
        // dd($request->all());
        // dd(Auth::guard('mentor')->user()->institution_id);

        $validated = $request->validate([
            'name' => ['required'],
            'project_domain' => ['required'],
            'period' => ['required'],
            'problem' => ['required'],
            'projectType' => ['required'],
        ],
        [
            'name.required' => 'Project name is required',
            'domain.required' => 'Project domain is required',
            'period.required' => 'Project period is required',
            'problem.required' => 'Project problem is required',
            'projectType.required' => 'Project type is required',
        ]);

        $project = new Project;
        $project->name = $validated['name'];
        $project->project_domain = $validated['project_domain'];
        $project->period = $validated['period'];
        $project->problem = $validated['problem'];
        $project->type = 'monthly';
        if(Auth::guard('web')->check() || Auth::guard('customer')->check()){
            $project->status = 'draft';
            $project->proposed_by = null;
        }elseif(Auth::guard('mentor')->check()){
            $project->status = 'draft';
            $project->proposed_by = Auth::guard('mentor')->user()->id;
        }
        if(Auth::guard('customer')->check()){
            $project->company_id = Auth::guard('customer')->user()->company_id;
        }else{
            $project->company_id = $request->partner;
        }
        if ($validated['projectType'] == 'private') {
            if(Auth::guard('web')->check() || Auth::guard('customer')->check()){
                $project->institution_id = $request->institution_id;
            }elseif(Auth::guard('mentor')->check()){
                $project->institution_id = Auth::guard('mentor')->user()->institution_id;
            }
        }
        $project->dataset = $request->dataset;
        $project->overview = $request->overview;
        $project->save();
        $message = "Successfully created a project";
        if($request->input('addInjectionCard')){
            return redirect('/dashboard/projects/'.$project->id.'/injection')->with('successTailwind', $message);
        }else{
            return redirect('/dashboard/projects')->with('successTailwind', $message);
        }
    }

    public function dashboardIndexEdit(Project $project)
    {
        // if(Auth::guard('web')->check()){
        $partners = Company::get();
        // $institutions = (new InstitutionController)->GetInstituionData();
        $cards = ProjectSection::where('project_id', $project->id)->get();

        $institutions = Institution::get();
        return view('dashboard.projects.edit', compact(['project','partners','cards','institutions']));
        // }
        // return view('dashboard.projects.edit', compact('project'));
    }

    public function dashboardIndexUpdate(Request $request, Project $project)
    {
        // dd($request->all());

        $validated = $request->validate([
            'name' => ['required'],
            'project_domain' => ['required'],
            'period' => ['required'],
            'problem' => ['required'],
            'projectType' => ['required'],
        ],
        [
            'name.required' => 'Project name is required',
            'domain.required' => 'Project domain is required',
            'period.required' => 'Project period is required',
            'problem.required' => 'Project problem is required',
            'projectType.required' => 'Project type is required',
        ]);
        $project = Project::findOrFail($project->id);
        // if(Auth::guard('web')->check()){
        $project->name = $validated['name'];
        $project->project_domain = $validated['project_domain'];
        $project->period = $validated['period'];
        if(Auth::guard('customer')->check()){
            $project->company_id = Auth::guard('customer')->user()->company_id;
        }else{
            $project->company_id = $request->partner;
        }
        $project->problem = $validated['problem'];
        $project->dataset = $request->dataset;
        $project->overview = $request->overview;

        if ($validated['projectType'] == 'private') {
            if(Auth::guard('web')->check() || Auth::guard('customer')->check()){
                if($request->institution_id == null){
                    $project->institution_id = $request->existing_institute;
                }else{
                    $project->institution_id = $request->institution_id;
                }
            }elseif(Auth::guard('mentor')->check()){
                $project->institution_id = Auth::guard('mentor')->user()->institution_id;
            }
        }elseif($validated['projectType'] == 'public'){
            $project->institution_id = null;
        }
        $project->type = 'monthly';
        $project->save();
        return redirect('dashboard/projects')->with('successTailwind','Project has been edited');

        // }elseif(Auth::guard('customer')->check()){
        //     $project->name = $validated['name'];
        //     $project->project_domain = $validated['project_domain'];
        //     $project->problem = $validated['problem'];
        //     if($request->hasFile('resources')){
        //         $resource = Storage::disk('public')->put('projects/resources', $request->file('resources'));
        //         $project->resources = $resource;
        //     }
        //     $project->valid_time = $validated['valid_time'];
        //     if($project->status == 'publish'){
        //         $project->save();
        //         return redirect('dashboard/projects')->with('success','Project has been edited');
        //     }elseif($project->status == 'draft'){
        //         $project->save();
        //         return redirect('dashboard/projects/draft')->with('success','Project has been edited');
        //     };
        // }
    }

    public function dashboardIndexShow(Project $project)
    {
        $cards = ProjectSection::where('project_id', $project->id)->get();

        return view('dashboard.projects.show', compact('project','cards'));
    }

    public function dashboardpublishDraft(Company $partner, Project $project)
    {        
        $project = Project::find($project->id);
        if($project->status == 'publish'){
            $notificationDraft = (new NotificationController)->project_notification_draft($project->id);
            $project->status = 'draft';
            $message = "Successfully drafted project";
        }else{
            $notification = (new NotificationController)->project_notification($project->id);
            $project->status = 'publish';
            $message = "Successfully publish project";
        }
        $project->save();
       return redirect('/dashboard/projects')->with('successTailwind', $message);

    }


    public function dashboardIndexDestroy($id)
    {
        $notificationDraft = (new NotificationController)->project_notification_draft($id);
        $project = Project::find($id);
        $project->delete();
        return redirect('dashboard/projects');
    }

    public function applyProject(Project $project)
    {
        $now_time = Carbon::now();
        $intern_end = Carbon::parse(Auth::guard('student')->user()->end_date);
        $remaining_intern_days = $now_time->diffInDays($intern_end,false);
        // dd($remaining_time_time);
        // dd($now_time->addMonth($project->period)->toDateString());

        $project_time = $now_time->addMonth($project->period);
        $project_totaldays = Carbon::now()->diffInDays($project_time);
        // dd($remaining_intern_days-$project_totaldays);

        // dd(Auth::guard('student')->user()->end_date);
        $enrolled_project = new EnrolledProject;
        $already_enrolled =  EnrolledProject::where('student_id',Auth::guard('student')->user()->id)
                                            ->where('is_submited', 0)->latest()->first();
        // $already_completed = EnrolledProject::where('student_id',Auth::guard('student')->user()->id)
        //                                     ->where('is_submited', 1)->first();
        // dd($already_enrolled);
        if(Auth::guard('student')->check()){
            if($remaining_intern_days-$project_totaldays >0)
                if($already_enrolled == null ){
                    $enrolled_project->student_id = Auth::guard('student')->user()->id;
                    $enrolled_project->project_id = $project->id;
                    $enrolled_project->is_submited = 0;
                    $enrolled_project->save();
                    return redirect('/profile/'.Auth::guard('student')->user()->id .'/allProjects')->with('success', 'Selected project has been applied');
                }else{
                    return redirect('/profile/'.Auth::guard('student')->user()->id.'/allProjectsAvailable/'.$project->id.'/detail')->with('error', 'Kindly complete your ongoing project');
                }
            else{
                return redirect('/profile/'.Auth::guard('student')->user()->id.'/allProjectsAvailable/'.$project->id.'/detail')->with('error', 'Your available intern time is not sufficient');
            }
        }else{
            return redirect('auth.otplogin');
        }
    }

    // SECTION
    public function dashboardIndexSection(Project $project)
    {
        return view('dashboard.projects.injection.index', compact(['project']));
    }

    public function dashboardIndexStoreSection(Request $request, Project $project)
    {
        // dd($request->all());
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
        $section_count = ProjectSection::where('project_id', $project->id);
        $section->project_id = $project->id;
        $section->title = $validated['title'];
        $section->file_type = $validated['inputfiletype'];
        $section->duration = $validated['duration'];
        $section->section = $section_count->count()+1;
        $section->description = $validated['description'];
        $section->save();
        $message = "Successfully created an injection card";
        if($request->input('addInjectionCard')){
            // return redirect()->back();
            return redirect('/dashboard/projects/'.$project->id.'/edit')->with('successTailwind', $message);
        }else{
            return redirect('/dashboard/projects/'.$project->id.'/injection/'.$section->id.'/attachment')->with('successTailwind', $message);
        }
    }

    public function dashboardIndexEditSection(Project $project, ProjectSection $injection)
    {
        $attachments = SectionSubsection::where('project_section_id', $injection->id)->get();
        $attachment_id = SectionSubsection::where('project_section_id', $injection->id)->first();
        return view('dashboard.projects.injection.edit', compact(['project','injection', 'attachment_id','attachments']));
    }

    public function dashboardIndexShowSection(Project $project, ProjectSection $injection)
    {
        $attachments = SectionSubsection::where('project_section_id', $injection->id)->get();
        return view('dashboard.projects.injection.show', compact(['project','injection','attachments']));
    }

    public function dashboardIndexUpdateSection(Request $request,Project $project, ProjectSection $injection)
    {
        // dd($request->all());
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
        $section->save();
        $message = "Successfully updated an injection card";
        return redirect('/dashboard/projects/'.$project->id.'/edit')->with('successTailwind', $message);
    }

    public function dashboardIndexDestroySection(Project $project, ProjectSection $injection)
    {
        $injection=ProjectSection::find($injection->id);
        $injection->delete();
        $message = "Successfully deleted an injection card";
        return redirect('/dashboard/projects/'.$project->id.'/edit')->with('successTailwind', $message);
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
    public function dashboardIndexSubsection(Project $project, ProjectSection $injection)
    {
        $attachment = SectionSubsection::where('project_section_id', $injection->id)->first();
        return view('dashboard.projects.injection.attachment.index', compact('project', 'injection', 'attachment'));
    }

    public function dashboardCreateSubsection ($project_id, $section_id)
    {
        $project = Project::find($project_id);
        $section = ProjectSection::find($section_id);

        return view('dashboard.projects.section.subsection.create', compact(['project', 'section']));
    }

    public function dashboardStoreSubsection(Request $request, Project $project, ProjectSection $injection)
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
          $message = "Successfully added the attachment";
          return redirect('/dashboard/projects/'.$project->id.'/injection/'.$injection->id.'/edit')->with('successTailwind', $message);
    }

    public function dashboardEditSubsection(Project $project, ProjectSection $injection, SectionSubsection $attachment)
    {
        return view('dashboard.projects.injection.attachment.edit', compact('project', 'injection', 'attachment'));
    }

    public function dashboardUpdateSubsection(Request $request, Project $project, ProjectSection $injection, SectionSubsection $attachment)
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
        return redirect('/dashboard/projects/'.$project->id.'/injection/'.$injection->id.'/edit');
    }

    public function dashboardDestroySubsection(Project $project, ProjectSection $injection, SectionSubsection $attachment, $key)
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
        $validated = $request->validate([
            'name' => ['required'],
            'project_domain' => ['required'],
            'period' => ['required'],
            'problem' => ['required'],
            'projectType' => ['required'],
            'dataset' => ['required'],
        ],
        [
            'name.required' => 'Project name is required',
            'domain.required' => 'Project domain is required',
            'period.required' => 'Project period is required',
            'problem.required' => 'Project problem is required',
            'projectType.required' => 'Project type is required',
            'dataset.required' => 'Project dataset is required',
        ]);
        $project = new Project;
        $project->name = $validated['name'];
        $project->project_domain = $validated['project_domain'];
        $project->period = $validated['period'];
        $project->problem = $validated['problem'];
        $project->type = 'monthly';
        $project->status = 'draft';
        $project->company_id = $partner->id;
        if ($validated['projectType'] == 'private') {
            $project->institution_id = $request->institution_id;
        }
        $project->dataset = $request->dataset;
        $project->overview = $request->overview;
        $project->save();
        $message = "Successfully created a project";

        if($request->input('addInjectionCard')){
            return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/injection')->with('successTailwind', $message );
            // return view('dashboard.partner.partnerProjectsInjection', compact('partner', 'project'));
        }else{
            return redirect('/dashboard/partners/'.$partner->id.'/projects')->with('successTailwind', $message );
        }
    }

    public function partnerProjectsUpdate(Request $request, Company $partner, Project $project)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => ['required'],
            'project_domain' => ['required'],
            'period' => ['required'],
            'problem' => ['required'],
            'projectType' => ['required'],
            'dataset' => ['required'],
        ],
        [
            'name.required' => 'Project name is required',
            'project_domain.required' => 'Project domain is required',
            'period.required' => 'Project period is required',
            'problem.required' => 'Project problem is required',
            'projectType.required' => 'Project type is required',
            'dataset.required' => 'Project dataset is required',
        ]);

        $project = Project::find($project->id);
        $project->name = $validated['name'];
        $project->project_domain = $validated['project_domain'];
        $project->period = $validated['period'];
        $project->problem = $validated['problem'];
        if ($validated['projectType'] == 'public') {
            $project->institution_id = null;
        }elseif($validated['projectType'] == 'private'){
            if($request->institution_id == null){
                $project->institution_id = $request->existing_institute;
            }else{
                $project->institution_id = $request->institution_id;
            }
        }
        $project->overview = $request->overview;
        $project->dataset = $validated['dataset'];
        $project->save();
        $message = "Successfully updated a project";
        return redirect('/dashboard/partners/'.$partner->id.'/projects')->with('successTailwind', $message );
    }

    public function partnerProjectsEdit(Company $partner, Project $project)
    {
        $project = Project::find($project->id);
        $cards = ProjectSection::where('project_id', $project->id)->get();
        $institutions = Institution::get();
        return view('dashboard.projects.edit', compact('partner', 'project', 'cards', 'institutions'));
    }

    public function publishDraft(Company $partner, Project $project)
    {
        $project = Project::find($project->id);
        if($project->status == 'publish'){
            $notificationDraft = (new NotificationController)->project_notification_draft($project->id);
            $project->status = 'draft';
            $message = "Successfully drafted project";
        }else{
            $notification = (new NotificationController)->project_notification($project->id);
            $project->status = 'publish';
            $message = "Successfully publish project";
        }
        $project->save();
        return redirect('/dashboard/partners/'.$partner->id.'/projects')->with('successTailwind', $message);

    }

    public function destroy(Company $partner, Project $project)
    {
        $notificationDraft = (new NotificationController)->project_notification_draft($project->id);
        $project = Project::find($project->id);
        $project->delete();
        $message = "Successfully delete a project";
        return redirect('/dashboard/partners/'.$partner->id.'/projects')->with('successTailwind', $message);
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
        $section_count = ProjectSection::where('project_id', $project->id);
        $section->project_id = $project->id;
        $section->title = $validated['title'];
        $section->file_type = $validated['inputfiletype'];
        $section->duration = $validated['duration'];
        $section->section = $section_count->count()+1;

        $section->description = $validated['description'];
        $section->save();
        $message = "Successfully created an injection card";
        if($request->input('addInjectionCard')){
            // return redirect()->back();
            return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/edit')->with('successTailwind', $message);

            // return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/injection');
            // return view('dashboard.partner.partnerProjectsInjection', compact('partner', 'project'));
        }else{
            // /partners/{partner}/projects/{project}/injection/{injection}/attachment
            return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/injection/'.$section->id.'/attachment')->with('successTailwind', $message);
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
        $message = "Successfully updated an injection card";
        return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/edit')->with('successTailwind', $message );
    }

    public function partnerProjectsInjectionDelete(Company $partner, Project $project, ProjectSection $injection)
    {
        $injection=ProjectSection::find($injection->id);
        $injection->delete();
        $message = "Successfully deleted an injection card";
        return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/edit')->with('successTailwind', $message );
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
        $message = "Successfully added the attachment";
        return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/injection/'.$injection->id.'/edit')->with('successTailwind', $message );
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
        $message = "Successfully added the attachment";
        return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/injection/'.$injection->id.'/edit')->with('successTailwind', $message);
    }

    public function partnerProjectsInjectionAttachmentDelete(Company $partner, Project $project, ProjectSection $injection, SectionSubsection $attachment, $key)
    {
        $attachment = SectionSubsection::find($attachment->id);
        if($key==1){
            $message = "Cannot delete the first attachment";
            return back()->with('error', $message);
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
        $message = "Successfully delete an attachment";
        return back()->with('successTailwind', $message);
    }

    // projects from admin dashboard sidebar menu
    public function allProjects()
    {
        dd('te');
        $projects = Project::get();
        return view('dashboard.projects.index', compact('projects'));
    }

}
