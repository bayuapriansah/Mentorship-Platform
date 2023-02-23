<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\StudentController;

class NotificationController extends Controller
{
    public function index(Student $student){

        $newMessage = (new StudentController)->newCommentForSidebarMenu($student->id);
        $newActivityNotifs = (new StudentController)->newNotificationActivity($student->id);
        $notifActivityCount = (new StudentController)->newNotificationActivityCount($student->id);

        return view('student.notifications.index', compact('student', 'newMessage', 'newActivityNotifs','notifActivityCount'));
    } 
}
