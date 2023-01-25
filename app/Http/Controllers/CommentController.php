<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function store(Request $request, $sender_id, $project_id, $task_id, $student_id)
    {
        $validated = $request->validate([
            'message' => 'required',
        ]);
        $comment = new Comment;
        if(Auth::guard('student')->check()){
            $comment->student_id = $sender_id;
        }else{
            $comment->mentor_id = $sender_id;
            $comment->student_id = $student_id;

        }
        $comment->project_id = $project_id;
        $comment->project_section_id = $task_id;
        $comment->message = $validated['message'];
        if(Auth::guard('student')->check()){
            if($request->hasFile('file')){
                $file = Storage::disk('public')->put('comments/'.$sender_id.'/project/'.$project_id.'/task/'.$task_id, $request->file);
                $comment->file = $file;
            }
        }
        else{
            if($request->hasFile('file')){
                $file = Storage::disk('public')->put('comments/mentor/'.$sender_id.'/project/'.$project_id.'/task/'.$task_id, $request->file);
                $comment->file = $file;
            }
        }
        $comment->save();
        if(Auth::guard('student')->check()){
            return redirect('/profile/'.$sender_id.'/enrolled/'.$project_id.'/task/'.$task_id);
        }
        else{
            return back();
        }
        // return redirect('/profile/'.$sender_id.'/enrolled/'.$project_id.'/task/'.$task_id);

        
    }
}
