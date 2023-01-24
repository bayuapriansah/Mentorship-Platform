<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $student_id, $project_id, $task_id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'message' => 'required',
        ]);
        $comment = new Comment;
        $comment->student_id = $student_id;
        $comment->project_id = $project_id;
        $comment->project_section_id = $task_id;
        $comment->message = $validated['message'];
        if($request->hasFile('file')){
            $file = Storage::disk('public')->put('comments/.'.$student_id.'/project/'.$project_id.'/task/'.$task_id, $request->file);
            $comment->file = $file;
        }
        $comment->save();
        return redirect('/profile/'.$student_id.'/enrolled/'.$project_id.'/task/'.$task_id);
    }
}
