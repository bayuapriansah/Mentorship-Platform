<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Notification;
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

    // inputed project_id into notification so it will count as notification
    public function project_notification($project)
    {
        return Notification::create([
            'project_id' => $project->id,
        ]);
    }

    public function count_total_all_notification_available(){
        $notif = Notification::get();

        return $notif;
    }

    public function all_notif_new_task(){
        return $this->count_total_all_notification_available();
    }
}
