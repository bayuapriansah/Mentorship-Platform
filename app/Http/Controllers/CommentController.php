<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Student;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\ProjectSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function store(Request $request, $student_id, $project_id, $task_id)
    {
        // dd($task_id);
        $validated = $request->validate([
            'message' => 'required',
        ]);
        $comment = new Comment;
        $comment->student_id = $student_id;
        $comment->project_id = $project_id;
        $comment->project_section_id = $task_id;
        $comment->message = $validated['message'];
        if($request->hasFile('file')){
            $file = Storage::disk('public')->put('comments/'.$student_id.'/project/'.$project_id.'/task/'.$task_id, $request->file);
            $comment->file = $file;
        }
        $comment->save();
        return redirect('/profile/'.$student_id.'/enrolled/'.$project_id.'/task/'.$task_id);
    }

    

    public function index()
    {
        $messages = Comment::get();
        $injections = ProjectSection::whereHas('comment')->get();
        return view('dashboard.messages.index', compact('messages','injections'));
    }

    public function create()
    {
        $projects = Project::get();
        $projectSections = ProjectSection::get();
        $students = Student::get();
        return view('dashboard.messages.create', compact('projects', 'projectSections', 'students'));
    }

    public function taskMessage(ProjectSection $injection)
    {
        $participants = Student::whereHas('comment')->get();
        $customer_participants = Customer::where('company_id',$injection->project->company_id)->get();
        $comments = Comment::where('project_section_id',$injection->id)->where('read_message', 0)->get();
        return view('dashboard.messages.taskMessage', compact('participants', 'injection','customer_participants', 'comments'));
    }

    public function single(ProjectSection $injection, Student $participant)
    {
        $comments = Comment::where('project_section_id', $injection->id)->where('student_id', $participant->id)->get();
        $customer_participants = Customer::where('company_id',$injection->project->company_id)->get();
        return view('dashboard.messages.singleMessage', compact('injection', 'participant', 'comments', 'customer_participants'));
    }

    public function adminReply(ProjectSection $injection, Student $participant)
    {
        $customer_participants = Customer::where('company_id',$injection->project->company_id)->get();
        return view('dashboard.messages.replyMessage', compact('injection', 'participant', 'customer_participants'));
    }

    public function adminSendMessage (Request $request,ProjectSection $injection, Student $participant)
    {
        // dd($request->all());
        $validated = $request->validate([
            'message' => 'required',
        ]);
        $comment = new Comment;
        if(Auth::guard('web')->check()){
            $comment->user_id = Auth::guard('web')->user()->id;
            $comment->student_id = $participant->id;
        }elseif(Auth::guard('mentor')->check()){
            $comment->mentor_id = Auth::guard('mentor')->user()->id;
            $comment->student_id = $participant->id;
        }
        $comment->project_id = $injection->project->id;
        $comment->project_section_id = $injection->id;
        $comment->message = $validated['message'];
        if($request->hasFile('file')){
            $file = Storage::disk('public')->put('message/project/'.$injection->project->id.'/task/'.$injection->id, $request->file);
            $comment->file = $file;
        }
        $comment->save();
        return redirect('/dashboard/messages/'.$injection->id.'/single/'.$participant->id);
    }

    public function adminSendMessageGlobal(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'project' => 'required',
            'injection' => 'required',
            'student' => 'required',
            'message' => 'required',
        ]);
        $comment = new Comment;
        if(Auth::guard('web')->check()){
            $comment->user_id = Auth::guard('web')->user()->id;
            $comment->student_id = $validated['student'];
        }elseif(Auth::guard('mentor')->check()){
            $comment->mentor_id = Auth::guard('mentor')->user()->id;
            $comment->student_id = $validated['student'];
        }
        $comment->project_id = $validated['project'];
        $comment->project_section_id = $validated['injection'];
        $comment->message = $validated['message'];
        if($request->hasFile('file')){
            $file = Storage::disk('public')->put('message/project/'.$validated['project'].'/task/'.$validated['injection'], $request->file);
            $comment->file = $file;
        }
        $comment->save();
        return redirect('/dashboard/messages/'.$validated['injection'].'/single/'.$validated['student']);
    }
}
