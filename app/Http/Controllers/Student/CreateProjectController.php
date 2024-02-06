<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateProjectController extends Controller
{
    public function index()
    {
        return view('student.project.create', $this->generateFakeLayoutData());
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
}
