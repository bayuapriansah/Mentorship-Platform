<?php

namespace App\Http\Controllers;

use File;
use Carbon\Carbon;
use App\Models\Search;
use App\Models\Company;
use App\Models\Project;
use App\Models\Submission;
use App\Models\ReadNotification;
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
use Exception;

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
            // dd($projects);
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
        if(Auth::guard('student')->check()){
          if(\Carbon\Carbon::now() > Auth::guard('student')->user()->end_date){
            abort(403);
          }
        }

        if(Auth::guard('student')->check()){
        $enrolled_projects = EnrolledProject::where('student_id', Auth::guard('student')->user()->id)->where('project_id', $id)->get();
        }
        $project_sections = ProjectSection::where('project_id', $id)->get();
        if(Auth::guard('student')->check()){
            return view('projects.show', compact(['project','project_sections','enrolled_projects']));
        }else{
            return view('projects.show', compact(['project','project_sections']));
        }
    }

    public function dashboardIndex()
    {
        // if(Auth::guard('web')->check()){
        //     $projects = Project::with(['student', 'company'])->get();
        // }elseif(Auth::guard('mentor')->check()){
        //     if(Auth::guard('mentor')->user()->institution_id != 0){
        //         $projects = Project::where('institution_id', Auth::guard('mentor')->user()->institution_id)->orWhere('institution_id', null)->with(['student', 'company'])->where('status', 'publish')->orWhere('status')->get();
        //     }else{
        //         $projects = Project::where('status', 'publish')->orWhere('status', 'private_project')
        //         ->whereHas('enrolled_project', function($q){
        //             $q->whereHas('student', function($q){
        //                 $q->where('staff_id', Auth::guard('mentor')->user()->id );
        //             });
        //         })->orWhere('proposed_by', Auth::guard('mentor')->user()->id)->get();
        //     }
        // }elseif(Auth::guard('customer')->check()){
        //     $projects = Project::where('company_id', Auth::guard('customer')->user()->company_id)->with(['student', 'company'])->get();
        // }

        return view('dashboard.projects.index');
    }

    public function draftIndex()
    {
        // $projects = Project::with(['student', 'company'])->where('status','draft')->get();
        return view('dashboard.projects.index');
    }

    public function dashboardIndexCreate()
    {
        $backUrl = route('dashboard.projects.index');
        $formAction = route('dashboard.projects.store');
        $partner = Company::orderBy('id')->first();
        $institutions = Institution::get();

        return view('dashboard.projects.create', compact(
            'backUrl',
            'formAction',
            'partner',
            'institutions',
        ));
    }

    public function dashboardIndexStore(Request $request)
    {
        // dd($request->all());
        // dd(Auth::guard('mentor')->user()->institution_id);
        $validated = $request->validate([
            'name' => ['required'],
            'project_domain' => ['required'],
            'type' => ['required'],
            'period' => ['required'],
            'problem' => ['required'],
            'projectType' => ['required'],
        ],
        [
            'name.required' => 'Project name is required',
            'domain.required' => 'Project domain is required',
            'type.required' => 'Project type is required',
            'period.required' => 'Project period is required',
            'problem.required' => 'Project problem is required',
            'projectType.required' => 'Project type is required',
        ]);

        $project = new Project;
        $project->name = $validated['name'];
        $project->project_domain = $validated['project_domain'];
        $project->type = $validated['type'];
        $project->period = $validated['period'];
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
              if(Auth::guard('mentor')->user()->institution_id != 0){
                $project->institution_id = Auth::guard('mentor')->user()->institution_id;
              }
              else{
                $project->institution_id = $request->institution_id;
              }
            }
        }elseif($validated['projectType'] == 'private_project'){
          $project->status = 'private_project';
        }
        $project->problem = $validated['problem'];
        // $project->dataset = $request->dataset;
        $project->dataset = $request->input('dataset', []); // Default to empty array if not set
        $project->overview = $request->overview;
        $project->save();
        $message = "Successfully created a project";

        toastr()->success($message);

        if($request->input('addInjectionCard')){
            return redirect('/dashboard/projects/'.$project->id.'/injection');
        }else{
            return redirect('/dashboard/projects');
        }
    }

    public function dashboardIndexEdit(Project $project)
    {
        $backUrl = route('dashboard.projects.index');
        $formAction = route('dashboard.projects.update', ['project' => $project->id]);
        $cards = ProjectSection::where('project_id', $project->id)->get();
        $institutions = Institution::get();

        return view('dashboard.projects.edit', compact(
            'project',
            'backUrl',
            'formAction',
            'cards',
            'institutions'
        ));
    }

    public function dashboardIndexUpdate(Request $request, Project $project)
    {
        // dd($request->all());

        $validated = $request->validate([
            'name' => ['required'],
            'project_domain' => ['required'],
            'type' => ['required'],
            'period' => ['required'],
            'problem' => ['required'],
            'projectType' => ['required'],
        ],
        [
            'name.required' => 'Project name is required',
            'domain.required' => 'Project domain is required',
            'type.required' => 'Project type is required',
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
                if(Auth::guard('mentor')->user()->institution_id != 0){
                  $project->institution_id = Auth::guard('mentor')->user()->institution_id;
                }
                else{
                  $project->institution_id = $request->institution_id;
                }
            }
        }elseif($validated['projectType'] == 'public'){
            $project->institution_id = null;
        }
        $project->type = $validated['type'];
        $project->save();

        toastr()->success('Project has been edited');

        return redirect('dashboard/projects');

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
        // dd($project);
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

        toastr()->success($message);

        return redirect('/dashboard/projects');
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
        // $total_month_complete = EnrolledProject::select('')->where('student_id',Auth::guard('student')->user()->id)
        //                                         ->where('is_submit',1)->;
        $total_month_complete = Project::select('period')->whereHas('enrolled_project', function($q){
                                            $q->where('student_id',Auth::guard('student')->user()->id);
                                            $q->where('is_submited',1);
                                          })->count();
        // $already_completed = EnrolledProject::where('student_id',Auth::guard('student')->user()->id)
        //                                     ->where('is_submited', 1)->first();
        if(Auth::guard('student')->check()){
          if($total_month_complete<=4){
            if($remaining_intern_days-$project_totaldays >=0){
              if($already_enrolled == null ){
                $enrolled_project->student_id = Auth::guard('student')->user()->id;
                $enrolled_project->project_id = $project->id;
                $enrolled_project->is_submited = 0;
                $enrolled_project->save();

                toastr('success', 'Selected project has been applied');

                return redirect('/profile/'.Auth::guard('student')->user()->id .'/allProjects');
              } else {
                  toastr()->error('Kindly complete your ongoing project');

                  return redirect('/profile/'.Auth::guard('student')->user()->id.'/allProjectsAvailable/'.$project->id.'/detail');
              }
            } else {
                toastr()->error('Your available intern time is not sufficient');

                return redirect('/profile/'.Auth::guard('student')->user()->id.'/allProjectsAvailable/'.$project->id.'/detail');
            }
          } else {
            toastr()->error('Your completed projects already 3 months long, please prepare for final submission');

            return redirect('/profile/'.Auth::guard('student')->user()->id.'/allProjectsAvailable/'.$project->id.'/detail');
          }
        }else{
            return redirect('auth.otplogin');
        }
    }

    // SECTION
    public function dashboardIndexSection(Project $project)
    {
        $backUrl = route('dashboard.projects.edit', ['project' => $project->id]);
        $formAction = route('dashboard.projects.storeSection', ['project' => $project->id]);

        return view('dashboard.projects.injection.index', compact(
            'project',
            'backUrl',
            'formAction',
        ));
    }

    public function dashboardIndexStoreSection(Request $request, Project $project)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'title' => ['required'],
                'duration' => ['required'],
                'description' => ['required'],
                'dataset' => ['nullable']
            ],
            [
                'title.required' => 'Title is required',
                'duration.required' => 'Duration is required',
                'description.required' => 'Description is required',
            ]);

            $completed_enrolled = EnrolledProject::where('project_id', $project->id)->get();

            foreach ($completed_enrolled as $item) {
                DB::table('enrolled_projects')
                ->where('project_id', $project->id)
                ->update([
                    'is_submited' => 0,
                    'flag_checkpoint' => null
                ]);
            }

            $section  = new ProjectSection;
            $section_count = ProjectSection::where('project_id', $project->id);
            $section->project_id = $project->id;
            $section->title = $validated['title'];
            // $section->file_type = '.zip';
            $section->duration = $validated['duration'];
            $section->section = $section_count->count()+1;
            $section->description = $validated['description'];
            $section->dataset = $validated['dataset'];
            $section->save();

            if ($request->hasFile('files')) {
                $files = $request->file('files');

                if (count($files) > 0) {
                    $attachment  = new SectionSubsection;
                    $attachment->project_section_id = $section->id;

                    foreach ($files as $index => $file) {
                        $file_name = date('YmdHis') . '-' . $file->getClientOriginalName();
                        $file->storeAs('public/projects/'.$project->id.'/attachment', $file_name);

                        if ($index === 0) {
                            $attachment->file1 = 'projects/'.$project->id.'/attachment/'.$file_name;
                        } elseif ($index === 1) {
                            $attachment->file2 = 'projects/'.$project->id.'/attachment/'.$file_name;
                        } elseif ($index === 2) {
                            $attachment->file3 = 'projects/'.$project->id.'/attachment/'.$file_name;
                        }
                    }

                    $attachment->save();
                }
            }

            DB::commit();
            toastr()->success('Successfully created an injection card');

            if($request->input('addInjectionCard')) {
                return redirect('/dashboard/projects/'.$project->id.'/edit');
            } else {
                return redirect('/dashboard/projects/'.$project->id.'/injection/'.$section->id.'/attachment');
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function dashboardIndexEditSection(Project $project, ProjectSection $injection)
    {
        $backUrl = route('dashboard.projects.edit', ['project' => $project->id]);
        $formAction = route('dashboard.projects.UpdateSection', ['project' => $project->id, 'injection' => $injection->id]);
        $attachments = SectionSubsection::where('project_section_id', $injection->id)->get();
        $attachment_id = SectionSubsection::where('project_section_id', $injection->id)->first();

        $countAttachment = 0;

        foreach ($attachments as $attachment) {
            if ($attachment->file1!= null) {
                $countAttachment++;
            }

            if ($attachment->file2!= null) {
                $countAttachment++;
            }

            if ($attachment->file3!= null) {
                $countAttachment++;
            }
        }

        return view('dashboard.projects.injection.edit', compact(
            'backUrl',
            'formAction',
            'project',
            'injection',
            'attachments',
            'attachment_id',
            'countAttachment',
        ));
    }

    public function dashboardIndexShowSection(Project $project, ProjectSection $injection)
    {
        $attachments = SectionSubsection::where('project_section_id', $injection->id)->get();
        return view('dashboard.projects.injection.show', compact(['project','injection','attachments']));
    }

    public function dashboardIndexUpdateSection(Request $request,Project $project, ProjectSection $injection)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'title' => ['required'],
                'duration' => ['required'],
                'description' => ['required'],
                'dataset' => ['nullable']
            ],
            [
                'title.required' => 'Title is required',
                'duration.required' => 'Duration is required',
                'description.required' => 'Description is required',
            ]);

            $section = ProjectSection::findOrFail($injection->id);
            $section->title = $validated['title'];
            // $section->file_type = '.zip';
            $section->duration = $validated['duration'];
            $section->description = $validated['description'];
            $section->dataset = $validated['dataset'];
            $section->save();

            if ($request->hasFile('files')) {
                $files = $request->file('files');

                if (count($files) > 0) {
                    $attachment  = new SectionSubsection;
                    $attachment->project_section_id = $section->id;

                    foreach ($files as $index => $file) {
                        $file_name = date('YmdHis') . '-' . $file->getClientOriginalName();
                        $file->storeAs('public/projects/'.$project->id.'/attachment', $file_name);

                        if ($index === 0) {
                            $attachment->file1 = 'projects/'.$project->id.'/attachment/'.$file_name;
                        } elseif ($index === 1) {
                            $attachment->file2 = 'projects/'.$project->id.'/attachment/'.$file_name;
                        } elseif ($index === 2) {
                            $attachment->file3 = 'projects/'.$project->id.'/attachment/'.$file_name;
                        }
                    }

                    $attachment->save();
                }
            }

            DB::commit();
            toastr()->success('Successfully updated an injection card');

            return redirect('/dashboard/projects/'.$project->id.'/edit');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function dashboardIndexDestroySection(Project $project, ProjectSection $injection)
    {
        $injection=ProjectSection::find($injection->id);
        $injection->delete();
        $message = "Successfully deleted an injection card";

        toastr()->success($message);

        return redirect('/dashboard/projects/'.$project->id.'/edit');
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

          toastr()->success($message);

          return redirect('/dashboard/projects/'.$project->id.'/injection/'.$injection->id.'/edit');
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

        toastr()->success('Project has been submited');

        return redirect('/projects/'.$student_id.'/applied/'.$project_id.'/detail');
    }

    public function partnerProjects(Company $partner)
    {
        // $projects = Project::where('company_id', $partner->id)->get();
        return view('dashboard.projects.index', compact('partner'));
    }

    public function partnerProjectsCreate(Company $partner)
    {
        $backUrl = route('dashboard.partner.partnerProjects', ['partner' => $partner->id]);
        $formAction = route('dashboard.partner.partnerProjectsStore', ['partner' => $partner->id]);
        $institutions = Institution::get();

        return view('dashboard.projects.create', compact(
            'backUrl',
            'formAction',
            'partner',
            'institutions',
        ));
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

        toastr()->success('Successfully created a project');

        if ($request->input('addInjectionCard')) {
            return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/injection');
        } else {
            return redirect('/dashboard/partners/'.$partner->id.'/projects');
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

        toastr()->success($message);

        return redirect('/dashboard/partners/'.$partner->id.'/projects');
    }

    public function partnerProjectsEdit(Company $partner, Project $project)
    {
        $backUrl = route('dashboard.partner.partnerProjects', ['partner' => $partner->id]);
        $formAction = route('dashboard.partner.partnerProjectsUpdate', ['partner' => $partner->id]);
        $cards = ProjectSection::where('project_id', $project->id)->get();
        $institutions = Institution::get();

        return view('dashboard.projects.edit', compact(
            'backUrl',
            'formAction',
            'project',
            'cards',
            'institutions'
        ));
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

        toastr()->success($message);

        return redirect('/dashboard/partners/'.$partner->id.'/projects');
    }

    public function destroy(Company $partner, Project $project)
    {
        $notificationDraft = (new NotificationController)->project_notification_draft($project->id);
        $project = Project::find($project->id);
        $project->delete();
        $message = "Successfully delete a project";

        toastr()->success($message);

        return redirect('/dashboard/partners/'.$partner->id.'/projects');
    }

    public function partnerProjectsInjection(Company $partner, Project $project)
    {
        $backUrl = route('dashboard.partner.partnerProjectsEdit', ['partner' => $partner->id, 'project' => $project->id]);
        $formAction = route('dashboard.partner.partnerProjectsInjectionStore', ['partner' => $partner->id, 'project' => $project->id]);

        return view('dashboard.projects.injection.index', compact(
            'partner',
            'project',
            'backUrl',
            'formAction',
        ));
    }

    public function partnerProjectsInjectionStore(Request $request, Company $partner, Project $project)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'title' => ['required'],
                // 'inputfiletype' => ['required'],
                'duration' => ['required'],
                'description' => ['required'],
            ],
            [
                'title.required' => 'Title is required',
                // 'inputfiletype.required' => 'File Type is required',
                'duration.required' => 'Duration is required',
                'description.required' => 'Description is required',
            ]);

            $completed_enrolled = EnrolledProject::where('project_id', $project->id)->get();
            foreach ($completed_enrolled as $item) {
                DB::table('enrolled_projects')
                ->where('project_id', $project->id)
                ->update([
                    'is_submited' => 0,
                    'flag_checkpoint' => null
                ]);
            }

            $section  = new ProjectSection;
            $section_count = ProjectSection::where('project_id', $project->id);
            $section->project_id = $project->id;
            $section->title = $validated['title'];
            // $section->file_type = '.zip';
            $section->duration = $validated['duration'];
            $section->section = $section_count->count()+1;
            $section->description = $validated['description'];
            $section->save();

            if ($request->hasFile('files')) {
                $files = $request->file('files');

                if (count($files) > 0) {
                    $attachment  = new SectionSubsection;
                    $attachment->project_section_id = $section->id;

                    foreach ($files as $index => $file) {
                        $file_name = date('YmdHis') . '-' . $file->getClientOriginalName();
                        $file->storeAs('public/projects/'.$project->id.'/attachment', $file_name);

                        if ($index === 0) {
                            $attachment->file1 = 'projects/'.$project->id.'/attachment/'.$file_name;
                        } elseif ($index === 1) {
                            $attachment->file2 = 'projects/'.$project->id.'/attachment/'.$file_name;
                        } elseif ($index === 2) {
                            $attachment->file3 = 'projects/'.$project->id.'/attachment/'.$file_name;
                        }
                    }

                    $attachment->save();
                }
            }

            toastr()->success('Successfully created an injection card');

            if ($request->input('addInjectionCard')) {
                // return redirect()->back();
                return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/edit');

                // return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/injection');
                // return view('dashboard.partner.partnerProjectsInjection', compact('partner', 'project'));
            } else {
                // /partners/{partner}/projects/{project}/injection/{injection}/attachment
                return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/injection/'.$section->id.'/attachment');
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function partnerProjectsInjectionEdit(Company $partner, Project $project, ProjectSection $injection)
    {
        $backUrl = route('dashboard.partner.partnerProjectsEdit', ['partner' => $partner->id, 'project' => $project->id]);
        $formAction = route('dashboard.partner.partnerProjectsInjectionUpdate', ['partner' => $partner->id, 'project' => $project->id, 'injection' => $injection->id]);
        $attachments = SectionSubsection::where('project_section_id', $injection->id)->get();
        $attachment_id = SectionSubsection::where('project_section_id', $injection->id)->first();

        $countAttachment = 0;

        foreach ($attachments as $attachment) {
            if ($attachment->file1!= null) {
                $countAttachment++;
            }

            if ($attachment->file2!= null) {
                $countAttachment++;
            }

            if ($attachment->file3!= null) {
                $countAttachment++;
            }
        }

        return view('dashboard.projects.injection.edit', compact(
            'backUrl',
            'formAction',
            'partner',
            'project',
            'injection',
            'attachments',
            'attachment_id',
            'countAttachment',
        ));
    }

    public function partnerProjectsInjectionUpdate(Request $request, Company $partner, Project $project, ProjectSection $injection)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'title' => ['required'],
                'duration' => ['required'],
                'description' => ['required'],
            ],
            [
                'title.required' => 'Title is required',
                'duration.required' => 'Duration is required',
                'description.required' => 'Description is required',
            ]);

            $section = ProjectSection::findOrFail($injection->id);
            $section->title = $validated['title'];
            // $section->file_type = '.zip';
            $section->duration = $validated['duration'];
            $section->description = $validated['description'];
            $section->save();

            if ($request->hasFile('files')) {
                $files = $request->file('files');

                if (count($files) > 0) {
                    $attachment  = new SectionSubsection;
                    $attachment->project_section_id = $section->id;

                    foreach ($files as $index => $file) {
                        $file_name = date('YmdHis') . '-' . $file->getClientOriginalName();
                        $file->storeAs('public/projects/'.$project->id.'/attachment', $file_name);

                        if ($index === 0) {
                            $attachment->file1 = 'projects/'.$project->id.'/attachment/'.$file_name;
                        } elseif ($index === 1) {
                            $attachment->file2 = 'projects/'.$project->id.'/attachment/'.$file_name;
                        } elseif ($index === 2) {
                            $attachment->file3 = 'projects/'.$project->id.'/attachment/'.$file_name;
                        }
                    }

                    $attachment->save();
                }
            }

            DB::commit();
            toastr()->success('Successfully updated an injection card');

            return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/edit');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function partnerProjectsInjectionDelete(Company $partner, Project $project, ProjectSection $injection)
    {
        $injection=ProjectSection::find($injection->id);
        $injection->delete();
        $message = "Successfully deleted an injection card";

        toastr()->success($message);

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
        $message = "Successfully added the attachment";

        toastr()->success($message);

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
        $message = "Successfully added the attachment";

        toastr()->success($message);

        return redirect('/dashboard/partners/'.$partner->id.'/projects/'.$project->id.'/injection/'.$injection->id.'/edit');
    }

    public function partnerProjectsInjectionAttachmentDelete(Company $partner, Project $project, ProjectSection $injection, SectionSubsection $attachment, $key)
    {
        $attachment = SectionSubsection::find($attachment->id);
        if($key==1){
            $message = "Cannot delete the first attachment";

            toastr()->error($message);

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
        $message = "Successfully delete an attachment";

        toastr()->success($message);

        return back();
    }

    // projects from admin dashboard sidebar menu
    public function allProjects()
    {
        $projects = Project::get();
        return view('dashboard.projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $acceptedExtensions = ['png', 'jpg', 'jpeg', 'gif'];
        $imageFolder = 'public/uploads/';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();

            // Validate file extension
            if (in_array(strtolower($extension), $acceptedExtensions)) {
                // Generate unique file name
                $filename = uniqid() . '.' . $extension;

                // Store the file
                $path = $file->storeAs($imageFolder, $filename);

                // Generate full URL
                $fullUrl = url(Storage::url($path));

                // Return the full URL of the stored file
                return response()->json(['location' => $fullUrl]);
            }
        }

        // Respond with an error if validation fails
        return response()->json(['error' => 'Invalid file'], 422);
    }
}
