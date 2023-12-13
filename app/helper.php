<?php

use App\Models\Comment;
use App\Models\Submission;
use Illuminate\Support\Facades\Crypt;
use App\Models\ReadNotification;
use Illuminate\Support\Facades\Auth;

if (!function_exists('encData')) {
    function encData($data) {
        $encrypted = Crypt::encryptString($data);
        return $encrypted;
    }
}

if (!function_exists('decData')) {
    function decData($data) {
      // Check the format of the data
      if(!is_string($data) || strlen($data) < 1) {
          return 'Error: Invalid data format';
      }
      // Check if the encryption key is valid
      if(!config('app.key')){
          return 'Error: Invalid key';
      }
      // Check if the payload is base64 encoded
      if(!base64_decode($data, true)){
          return 'Error: Payload is not base64 encoded';
      }
      try {
          // Decrypt the data
          $decrypted = Crypt::decryptString($data);
          return $decrypted;
      } catch(\Illuminate\Contracts\Encryption\DecryptException $e) {
          return abort(403);
          return 'Error: Invalid payload';
      }
    }
}

if(!function_exists('isLoggedIn')){
    function isLoggedIn() {
        return Auth::guard('student')->check() ||
               Auth::guard('web')->check() ||
               Auth::guard('mentor')->check() ||
               Auth::guard('customer')->check();
    }
}

if (!function_exists('emailUserAuth')) {
    function emailUserAuth() {
        if (Auth::guard('student')->check()) {
            return Auth::guard('student')->user()->email;
        } elseif (Auth::guard('web')->check()) {
            return Auth::guard('web')->user()->email;
        } elseif (Auth::guard('mentor')->check()) {
            return Auth::guard('mentor')->user()->email;
        } elseif (Auth::guard('customer')->check()) {
            return Auth::guard('customer')->user()->email;
        }

        return null; // or return a default value
    }
}

if (!function_exists('nameUserAuth')) {
    function nameUserAuth() {
        if (Auth::guard('student')->check()) {
            return Auth::guard('student')->user()->first_name . " " .  Auth::guard('student')->user()->last_name;
        } elseif (Auth::guard('web')->check()) {
            return Auth::guard('web')->user()->first_name . " " .  Auth::guard('web')->user()->last_name;
        } elseif (Auth::guard('mentor')->check()) {
            return Auth::guard('mentor')->user()->first_name . " " .  Auth::guard('mentor')->user()->last_name;
        } elseif (Auth::guard('customer')->check()) {
            return Auth::guard('customer')->user()->first_name . " " .  Auth::guard('customer')->user()->last_name;
        }

        return null; // or return a default value
    }
}

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
            $submissionNotifications = Submission::where('is_complete', 1)
            ->whereNotIn('id', function($query) {
                $query->select('submission_id')
                ->from('read_notifications')
                ->where('type', 'submissions')
                ->where('is_read', 1)
                ->where('user_id', Auth::guard('web')->user()->id);
            })->get();
        }elseif(Auth::guard('mentor')->check()){
            if(Auth::guard('mentor')->user()->institution_id != 0){
                $submissionNotifications = Submission::where('is_complete', 1)
                ->whereNotIn('id', function($query) {
                    $query->select('submission_id')
                    ->from('read_notifications')
                    ->where('type', 'submissions')
                    ->where('is_read', 1)
                    ->where('mentor_id', Auth::guard('mentor')->user()->id);
                })
                ->when(Auth::guard('mentor')->check(), function ($query) {
                    $query->whereIn('student_id', function($query){
                        $query->select('id')
                        ->from('students')
                        ->where('mentor_id', Auth::guard('mentor')->user()->id);
                    });
                })->get();
            }else{
                $submissionNotifications = Submission::where('is_complete', 1)
                ->whereNotIn('id', function($query) {
                    $query->select('submission_id')
                    ->from('read_notifications')
                    ->where('type', 'submissions')
                    ->where('is_read', 1)
                    ->where('mentor_id', Auth::guard('mentor')->user()->id);
                })
                ->when(Auth::guard('mentor')->check(), function ($query) {
                    $query->whereIn('student_id', function($query){
                        $query->select('id')
                        ->from('students')
                        ->where('staff_id', Auth::guard('mentor')->user()->id);
                    });
                })->get();
            }

        }elseif(Auth::guard('customer')->check()){
            $submissionNotifications = Submission::whereHas('project', function($query){
                $query->where('company_id', Auth::guard('customer')->user()->company_id);
            })->where('is_complete', 1)
            ->whereNotIn('id', function($query){
                $query->select('submission_id')
                ->from('read_notifications')
                ->where('type', 'submissions')
                ->where('is_read', 1)
                ->where('customer_id', Auth::guard('customer')->user()->id);
            })->get();
        }
        $totalNotificationAdmin = $submissionNotifications->count();

        // dd(Auth::getDefaultDriver());
        return [
            'submissionNotifications' => $submissionNotifications,
            'totalNotificationAdmin' => $totalNotificationAdmin,
        ];
    }
}

if(!function_exists('commentPerSection')){
    function commentPerSection($injections){
        if(Auth::guard('web')->check()){
            $comments = Comment::where('project_section_id',$injections->id)->where(function ($query) {
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
            })->get();
        }elseif(Auth::guard('mentor')->check()){
            if(Auth::guard('mentor')->user()->institution_id != 0){
              $comments = Comment::where('project_section_id',$injections->id)->where(function ($query) {
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
            })->whereHas('student', function($q){
                $q->where('mentor_id', Auth::guard('mentor')->user()->id);
            })
            ->get();
            }else{
                $comments = Comment::where('project_section_id',$injections->id)->where(function ($query) {
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
                })->whereHas('student', function($q){
                    $q->where('staff_id', Auth::guard('mentor')->user()->id);
                })
                ->get();
            }
        }elseif(Auth::guard('customer')->check()){
            $comments = Comment::where('project_section_id',$injections->id)->where(function ($query) {
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
            })->whereHas('student', function($q){
                $q->where('institution_id', Auth::guard('customer')->user()->id);
            })
            ->get();
        }
        return $comments;
    }
}

if (!function_exists('isSkillsTrack')) {
    function isSkillsTrack()
    {
        // return request()->query->has('is_skills_track');
        return auth('student')->user()->mentorship_type == 'skills_track';
    }
}
