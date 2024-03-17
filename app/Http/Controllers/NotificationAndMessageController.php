<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotifyStudent;
use App\Models\NotifyMentor;

class NotificationAndMessageController extends Controller
{
    public function markAsRead($idNotify)
    {
        $studentId = auth('student')->user()->id;
        $notifyStudent = NotifyStudent::where('id_students', $studentId)->first();

        if ($notifyStudent && is_array($notifyStudent->notify_data)) {
            $notifications = $notifyStudent->notify_data;

            $updated = false;
            foreach ($notifications['notification'] as $key => &$notification) {
                if (isset($notification['idNotify']) && $notification['idNotify'] == $idNotify && $notification['isRead'] == 0) {
                    if($notification['type'] == "newGrading"){
                        $idTask = $notification['idSection'];
                    }
                    $idProject = $notification['idProject'];
                    $notification['isRead'] = 1;
                    $updated = true;
                    break; // Stop the loop once we've found and updated the relevant item
                }
            }

            if ($updated) {
                $notifyStudent->notify_data = $notifications; // Save the updated notifications back
                $notifyStudent->save();
            }
        }

        // return back(); // Redirect back to the previous page
        if($notification['type'] == "newGrading"){
            return redirect()->route('student.taskDetail', ['student' => $studentId, 'project' => $idProject, 'task' => $idTask]);
        }else{
            return back();
        }
    }

    public function markAsReadMentor($idNotify)
    {
        $mentorId = auth('mentor')->user()->id;
        $notifyMentor = NotifyMentor::where('id_mentors', $mentorId)->first();

        if ($notifyMentor && is_array($notifyMentor->notify_mentors_data)) {
            $notifications = $notifyMentor->notify_mentors_data;

            $updated = false;
            foreach ($notifications['notification'] as $key => &$notification) {
                if (isset($notification['idNotify']) && $notification['idNotify'] == $idNotify && $notification['isRead'] == 0) {
                    if($notification['type'] == "newSubmission"){
                        $idTask = $notification['idTask'];
                        $idSubmission = $notification['idSubmission'];
                    }
                    $idProject = $notification['idProject'];
                    $notification['isRead'] = 1;
                    $updated = true;
                    break; // Stop the loop once we've found and updated the relevant item
                }
            }

            if ($updated) {
                $notifyMentor->notify_mentors_data = $notifications; // Save the updated notifications back
                $notifyMentor->save();
            }
        }

        // return back(); // Redirect back to the previous page
        if($notification['type'] == "newSubmission"){
            return redirect()->route('dashboard.submission.singleSubmission', ['project' => $idProject, 'submission' => $idSubmission]);
        }else{
            return back();
        }
    }
}
