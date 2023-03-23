<?php

namespace App\Services;

use App\Models\Submission;
use App\Models\ReadNotification;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public static function getNotifications()
    {

        $submissionCountReadNotification = 0;
        $submissionNotifications = [];

        if (Auth::guard('web')->check()) {
            $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('type','submissions')->where('user_id',Auth::guard('web')->user()->id)->get()->count();
            $submissionNotifications = Submission::where('is_complete', 1)->whereNotIn('id', function($query) {$query->select('submission_id')->from('read_notifications')->where('type', 'submissions')->where('is_read', 1)->where('user_id', Auth::guard('web')->user()->id);})->get();
            } elseif(Auth::guard('mentor')->check()){
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('type','submissions')->where('mentor_id',Auth::guard('mentor')->user()->id)->get()->count();
                $submissionNotifications = Submission::where('is_complete', 1)
                    ->whereNotIn('id', function($query) {
                        $query->select('submission_id')
                              ->from('read_notifications')
                              ->where('type', 'submissions')
                              ->where('is_read', 1)
                              ->where('mentor_id', Auth::guard('mentor')->user()->id);
                    })
                    ->when(Auth::guard('mentor')->check(), function ($query) {
                      $query->whereIn('student_id', function($query) {
                          $query->select('id')
                              ->from('students')
                              ->where('mentor_id', Auth::guard('mentor')->user()->id);
                      });
                  })
                    ->get();
            } elseif(Auth::guard('customer')->check()){
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('type','submissions')->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
                $submissionNotifications = Submission::whereHas('project', function($q){
                  $q->where('company_id', Auth::guard('customer')->user()->company_id);
                  })
                  ->where('is_complete', 1)
                  ->whereNotIn('id', function($query) {
                      $query->select('submission_id')
                            ->from('read_notifications')
                            ->where('is_read', 1)
                            ->where('customer_id', Auth::guard('customer')->user()->id);
                  })
                  ->get();
            }
        $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;

        return [
            'submissionCountNotification' => $submissionCountNotification,
            'submissionCountReadNotification' => $submissionCountReadNotification,
            'submissionNotifications' => $submissionNotifications,
            'totalNotificationAdmin' => $totalNotificationAdmin,
        ];
    }
}
