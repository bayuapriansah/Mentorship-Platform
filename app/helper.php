<?php

use App\Models\Comment;
use App\Models\Submission;
use App\Models\ReadNotification;
use Illuminate\Support\Facades\Auth;

if(!function_exists('getCommentMessages')){
    function getCommentMessages() {
        if(Auth::guard('web')->check()){
            $messages = Comment::where(function ($query) {
                $query->whereNull('mentor_id')
                    ->WhereNull('staff_id')
                    ->WhereNull('user_id')
                    ->WhereNull('customer_id');
            })->whereNotIn('id', function($query) {
                $query->select('comments_id')
                    ->from('read_notifications')
                    ->where('type', 'comments')
                    ->where('is_read', 1)
                    ->where('user_id', Auth::guard('web')->user()->id);
            })
                ->get();

        }elseif(Auth::guard('mentor')->check()){
            if(Auth::guard('mentor')->user()->institution_id != 0){
                $messages = Comment::whereHas('student', function($q){
                    $q->where('mentor_id', Auth::guard('mentor')->user()->id);
                })->where(function ($query) {
                    $query->whereNull('mentor_id')
                        ->WhereNull('staff_id')
                        ->WhereNull('user_id')
                        ->WhereNull('customer_id');
                })->whereNotIn('id', function($query) {
                    $query->select('comments_id')
                        ->from('read_notifications')
                        ->where('type', 'comments')
                        ->where('is_read', 1)
                        ->where('mentor_id', Auth::guard('mentor')->user()->id);
                })
                    ->get();
            }else{
                $messages = Comment::whereHas('student', function($q){
                    $q->where('staff_id', Auth::guard('mentor')->user()->id);
                })->where(function ($query) {
                    $query->whereNull('mentor_id')
                        ->WhereNull('staff_id')
                        ->WhereNull('user_id')
                        ->WhereNull('customer_id');
                })->whereNotIn('id', function($query) {
                    $query->select('comments_id')
                        ->from('read_notifications')
                        ->where('type', 'comments')
                        ->where('is_read', 1)
                        ->where('mentor_id', Auth::guard('mentor')->user()->id);
                })
                    ->get();
            }
        }elseif(Auth::guard('customer')->check()){
            $messages = Comment::whereHas('project', function($q){
                $q->where('company_id', Auth::guard('customer')->user()->company_id);
            })->where(function ($query) {
                $query->whereNull('mentor_id')
                    ->WhereNull('staff_id')
                    ->WhereNull('user_id')
                    ->WhereNull('customer_id');
            })->whereNotIn('id', function($query) {
                $query->select('comments_id')
                    ->from('read_notifications')
                    ->where('type', 'comments')
                    ->where('is_read', 1)
                    ->where('customer_id', Auth::guard('customer')->user()->id);
            })
                ->get();
        }

        return $messages;
    }
}

if(!function_exists('getNotificationSubmission')){
    function getNotificationSubmission(){
        if(Auth::guard('web')->check()){
            $submissionNotifications = Submission::where('is_complete', 1)->whereNotIn('id', function($query) {$query->select('submission_id')->from('read_notifications')->where('type', 'submissions')->where('is_read', 1)->where('user_id', Auth::guard('web')->user()->id);})->get();
        }elseif(Auth::guard('mentor')->check()){
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
            })->whereNotIn('id', function ($query) {
            $query->select('submission_id')
                ->from('read_notifications')
                ->where('type', 'submissions')
                ->where('is_read', 1)
                ->where('mentor_id', Auth::guard('mentor')->user()->id);
            })
            ->get();

        }elseif(Auth::guard('customer')->check()){
            $submissionNotifications = Submission::whereHas('project', function($query){
                $query->where('company_id', Auth::guard('customer')->user()->company_id);
                })
                ->where('is_complete', 1)
                ->whereNotIn('id', function($query) {
                    $query->select('submission_id')
                        ->from('read_notifications')
                        ->where('type', 'submissions')
                        ->where('is_read', 1)
                        ->where('customer_id', Auth::guard('customer')->user()->id);
                })
                ->get();
        }
        $totalNotificationAdmin = $submissionNotifications->count();

        return [
            'submissionNotifications' => $submissionNotifications,
            'totalNotificationAdmin' => $totalNotificationAdmin,
        ];
    }
}
