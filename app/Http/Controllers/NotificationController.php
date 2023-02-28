<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Notification;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\StudentController;

class NotificationController extends Controller
{
    public function index(Student $student){

        $newMessage = (new StudentController)->newCommentForSidebarMenu($student->id);
        $newActivityNotifs = (new StudentController)->newNotificationActivity($student->id);
        $notifActivityCount = (new StudentController)->newNotificationActivityCount($student->id);
        $notifNewTasks = $this->all_notif_new_task();
        $dataMessages = $this->data_comment_from_admin($student->id);
        return view('student.notifications.index', compact('student', 'newMessage', 'newActivityNotifs','notifActivityCount','notifNewTasks','dataMessages'));
    }

    // inputed project_id into notification so it will count as notification
    public function project_notification($project)
    {
        return Notification::create([
            'project_id' => $project->id,
        ]);
    }

    public function count_total_all_notification_available(){
        $notifs = Notification::get();
        
        foreach($notifs as $notif){
            $dataNotif = $notif->project->where('status','publish')->count();
        }

        return $dataNotif;
    }

    public function count_total_all_notification_availables(){
        $notifs = Notification::get();

        return $notifs;
    }

    public function all_notif_new_task(){
        return $this->count_total_all_notification_availables();
    }

    public function data_comment_from_admin($id){
        $newMessage = Comment::where('student_id', $id)
        ->where('read_message', 0)
        ->whereIn('user_id', [!null])
        ->orWhereIn('mentor_id', [!null])
        ->orWhereIn('customer_id', [!null])
        ->get();

        return $newMessage;
    }
}