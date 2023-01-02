<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function subsectionProjectGradeAssign($submission_id, Request $request)
    {
        $validated = $request->validate([
            'grade' => 'required'
        ]);
        
        $grade = new Grade;
        $grade->mentor_id = Auth::guard('mentor')->user()->id;
        $grade->submission_id = $submission_id;
        $grade->score = $validated['grade'];
        $grade->save();
        return back()->with('success', 'Submission graded');

    }
}
