<?php

use App\Models\Comment;
use App\Models\Submission;
use App\Models\Student;
use App\Models\NotifyStudent;
use App\Models\NotifyMentor;
// use App\Models\NotifyStudent;
use Illuminate\Support\Facades\Crypt;
use App\Models\ReadNotification;
use Illuminate\Support\Facades\Auth;

if (!function_exists('teamList')) {
    function teamList($teamName)
    {
        $list_team = Student::where('team_name', $teamName)->get();
        return $list_team;
    }
}

if (!function_exists('encData')) {
    function encData($data)
    {
        $encrypted = Crypt::encryptString($data);
        return $encrypted;
    }
}

if (!function_exists('getRole')) {
    function getRole()
    {
        if (auth()->guard('web')->check()) {
            return 'admin';
        } elseif (Auth::guard('mentor')->check()) {
            if (auth()->user()->institution_id > 0) {
                return 'mentor';
            } else {
                return 'staff';
            }
        } elseif (Auth::guard('customer')->check()) {
            return 'sustomer';
        } elseif (Auth::guard('student')->check()) {
            return 'student';
        }
    }
}

if (!function_exists('decData')) {
    function decData($data)
    {
        // Check the format of the data
        if (!is_string($data) || strlen($data) < 1) {
            return 'Error: Invalid data format';
        }
        // Check if the encryption key is valid
        if (!config('app.key')) {
            return 'Error: Invalid key';
        }
        // Check if the payload is base64 encoded
        if (!base64_decode($data, true)) {
            return 'Error: Payload is not base64 encoded';
        }
        try {
            // Decrypt the data
            $decrypted = Crypt::decryptString($data);
            return $decrypted;
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return abort(403);
            return 'Error: Invalid payload';
        }
    }
}

if (!function_exists('isLoggedIn')) {
    function isLoggedIn()
    {
        return Auth::guard('student')->check() ||
            Auth::guard('web')->check() ||
            Auth::guard('mentor')->check() ||
            Auth::guard('customer')->check();
    }
}

if (!function_exists('emailUserAuth')) {
    function emailUserAuth()
    {
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
    function nameUserAuth()
    {
        if (Auth::guard('student')->check()) {
            return Auth::guard('student')->user()->first_name . " " .  Auth::guard('student')->user()->last_name;
        } elseif (Auth::guard('web')->check()) {
            return Auth::guard('web')->user()->name;
        } elseif (Auth::guard('mentor')->check()) {
            return Auth::guard('mentor')->user()->first_name . " " .  Auth::guard('mentor')->user()->last_name;
        } elseif (Auth::guard('customer')->check()) {
            return Auth::guard('customer')->user()->first_name . " " .  Auth::guard('customer')->user()->last_name;
        }

        return null; // or return a default value
    }
}

if (!function_exists('getCommentMessages')) {
    function getCommentMessages()
    {
        if (Auth::guard('web')->check()) {
            $messages = Comment::where(function ($query) {
                $query->whereNull('mentor_id')
                    ->WhereNull('staff_id')
                    ->WhereNull('user_id')
                    ->WhereNull('customer_id');
            })->whereNotIn('id', function ($query) {
                $query->select('comments_id')
                    ->from('read_notifications')
                    ->where('type', 'comments')
                    ->where('is_read', 1)
                    ->where('user_id', Auth::guard('web')->user()->id);
            })
                ->get();
        } elseif (Auth::guard('mentor')->check()) {
            if (Auth::guard('mentor')->user()->institution_id != 0) {
                $messages = Comment::whereHas('student', function ($q) {
                    $q->where('mentor_id', Auth::guard('mentor')->user()->id);
                })->where(function ($query) {
                    $query->whereNull('mentor_id')
                        ->WhereNull('staff_id')
                        ->WhereNull('user_id')
                        ->WhereNull('customer_id');
                })->whereNotIn('id', function ($query) {
                    $query->select('comments_id')
                        ->from('read_notifications')
                        ->where('type', 'comments')
                        ->where('is_read', 1)
                        ->where('mentor_id', Auth::guard('mentor')->user()->id);
                })
                    ->get();
            } else {
                $messages = Comment::whereHas('student', function ($q) {
                    $q->where('staff_id', Auth::guard('mentor')->user()->id);
                })->where(function ($query) {
                    $query->whereNull('mentor_id')
                        ->WhereNull('staff_id')
                        ->WhereNull('user_id')
                        ->WhereNull('customer_id');
                })->whereNotIn('id', function ($query) {
                    $query->select('comments_id')
                        ->from('read_notifications')
                        ->where('type', 'comments')
                        ->where('is_read', 1)
                        ->where('mentor_id', Auth::guard('mentor')->user()->id);
                })
                    ->get();
            }
        } elseif (Auth::guard('customer')->check()) {
            $messages = Comment::whereHas('project', function ($q) {
                $q->where('company_id', Auth::guard('customer')->user()->company_id);
            })->where(function ($query) {
                $query->whereNull('mentor_id')
                    ->WhereNull('staff_id')
                    ->WhereNull('user_id')
                    ->WhereNull('customer_id');
            })->whereNotIn('id', function ($query) {
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

if (!function_exists('getNotificationSubmission')) {
    function getNotificationSubmission($onlyCount = false)
    {
        $user = null;
        $userType = null;

        // Define the guards and their corresponding user types
        $guards = [
            'web' => 'user',
            'mentor' => 'mentor',
            'customer' => 'customer',
        ];

        // Iterate over each guard to find the authenticated user
        foreach ($guards as $guard => $type) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $userType = $type;
                break;
            }
        }

        // Early return if no user is authenticated
        if (!$user) {
            return [
                'submissionNotifications' => collect(),
                'totalNotificationAdmin' => 0,
            ];
        }

        // Common query for all user types
        $submissionNotifications = Submission::where('is_complete', 1)
            ->whereNotIn('id', function ($query) use ($user) {
                $query->select('submission_id')
                    ->from('read_notifications')
                    ->where('type', 'submissions')
                    ->where('is_read', 1)
                    ->where('user_id', $user->id);
            });

        // Additional conditions for 'mentor' type
        if ($userType === 'mentor') {
            $submissionNotifications = $submissionNotifications->whereHas('student', function ($query) use ($user) {
                $query->where('mentor_id', $user->id);
            });
        }

        // Additional conditions for 'customer' type
        if ($userType === 'customer') {
            $submissionNotifications = $submissionNotifications->whereHas('project', function ($query) use ($user) {
                $query->where('company_id', $user->company_id);
            });
        }

        if ($onlyCount) {
            return $submissionNotifications->count();
        }

        // Execute the query
        $submissionNotifications = $submissionNotifications->get();
        $totalNotificationAdmin = $submissionNotifications->count();

        return [
            'submissionNotifications' => $submissionNotifications,
            'totalNotificationAdmin' => $totalNotificationAdmin,
        ];
    }
}

// if(!function_exists('getNotificationSubmission')){
//     function getNotificationSubmission(){
//         if(Auth::guard('web')->check()){
//             $submissionNotifications = Submission::where('is_complete', 1)
//             ->whereNotIn('id', function($query) {
//                 $query->select('submission_id')
//                 ->from('read_notifications')
//                 ->where('type', 'submissions')
//                 ->where('is_read', 1)
//                 ->where('user_id', Auth::guard('web')->user()->id);
//             })->get();
//         }elseif(Auth::guard('mentor')->check()){
//             if(Auth::guard('mentor')->user()->institution_id != 0){
//                 $submissionNotifications = Submission::where('is_complete', 1)
//                 ->whereNotIn('id', function($query) {
//                     $query->select('submission_id')
//                     ->from('read_notifications')
//                     ->where('type', 'submissions')
//                     ->where('is_read', 1)
//                     ->where('mentor_id', Auth::guard('mentor')->user()->id);
//                 })
//                 ->when(Auth::guard('mentor')->check(), function ($query) {
//                     $query->whereIn('student_id', function($query){
//                         $query->select('id')
//                         ->from('students')
//                         ->where('mentor_id', Auth::guard('mentor')->user()->id);
//                     });
//                 })->get();
//             }else{
//                 $submissionNotifications = Submission::where('is_complete', 1)
//                 ->whereNotIn('id', function($query) {
//                     $query->select('submission_id')
//                     ->from('read_notifications')
//                     ->where('type', 'submissions')
//                     ->where('is_read', 1)
//                     ->where('mentor_id', Auth::guard('mentor')->user()->id);
//                 })
//                 ->when(Auth::guard('mentor')->check(), function ($query) {
//                     $query->whereIn('student_id', function($query){
//                         $query->select('id')
//                         ->from('students')
//                         ->where('staff_id', Auth::guard('mentor')->user()->id);
//                     });
//                 })->get();
//             }

//         }elseif(Auth::guard('customer')->check()){
//             $submissionNotifications = Submission::whereHas('project', function($query){
//                 $query->where('company_id', Auth::guard('customer')->user()->company_id);
//             })->where('is_complete', 1)
//             ->whereNotIn('id', function($query){
//                 $query->select('submission_id')
//                 ->from('read_notifications')
//                 ->where('type', 'submissions')
//                 ->where('is_read', 1)
//                 ->where('customer_id', Auth::guard('customer')->user()->id);
//             })->get();
//         }
//         $totalNotificationAdmin = $submissionNotifications->count();

//         // dd(Auth::getDefaultDriver());
//         return [
//             'submissionNotifications' => $submissionNotifications,
//             'totalNotificationAdmin' => $totalNotificationAdmin,
//         ];
//     }
// }

if (!function_exists('commentPerSection')) {
    function commentPerSection($injections)
    {
        if (Auth::guard('web')->check()) {
            $comments = Comment::where('project_section_id', $injections->id)->where(function ($query) {
                $query->whereNull('mentor_id')
                    ->WhereNull('staff_id')
                    ->WhereNull('user_id')
                    ->WhereNull('customer_id');
            })->whereNotIn('id', function ($query) {
                $query->select('comments_id')
                    ->from('read_notifications')
                    ->where('type', 'comments')
                    ->where('is_read', 1)
                    ->where('user_id', Auth::guard('web')->user()->id);
            })->get();
        } elseif (Auth::guard('mentor')->check()) {
            if (Auth::guard('mentor')->user()->institution_id != 0) {
                $comments = Comment::where('project_section_id', $injections->id)->where(function ($query) {
                    $query->whereNull('mentor_id')
                        ->WhereNull('staff_id')
                        ->WhereNull('user_id')
                        ->WhereNull('customer_id');
                })->whereNotIn('id', function ($query) {
                    $query->select('comments_id')
                        ->from('read_notifications')
                        ->where('type', 'comments')
                        ->where('is_read', 1)
                        ->where('mentor_id', Auth::guard('mentor')->user()->id);
                })->whereHas('student', function ($q) {
                    $q->where('mentor_id', Auth::guard('mentor')->user()->id);
                })
                    ->get();
            } else {
                $comments = Comment::where('project_section_id', $injections->id)->where(function ($query) {
                    $query->whereNull('mentor_id')
                        ->WhereNull('staff_id')
                        ->WhereNull('user_id')
                        ->WhereNull('customer_id');
                })->whereNotIn('id', function ($query) {
                    $query->select('comments_id')
                        ->from('read_notifications')
                        ->where('type', 'comments')
                        ->where('is_read', 1)
                        ->where('mentor_id', Auth::guard('mentor')->user()->id);
                })->whereHas('student', function ($q) {
                    $q->where('staff_id', Auth::guard('mentor')->user()->id);
                })
                    ->get();
            }
        } elseif (Auth::guard('customer')->check()) {
            $comments = Comment::where('project_section_id', $injections->id)->where(function ($query) {
                $query->whereNull('mentor_id')
                    ->WhereNull('staff_id')
                    ->WhereNull('user_id')
                    ->WhereNull('customer_id');
            })->whereNotIn('id', function ($query) {
                $query->select('comments_id')
                    ->from('read_notifications')
                    ->where('type', 'comments')
                    ->where('is_read', 1)
                    ->where('customer_id', Auth::guard('customer')->user()->id);
            })->whereHas('student', function ($q) {
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

if (!function_exists('notifyStudentCount')) {
    function notifyStudentCount()
    {
        $notifyStudent = NotifyStudent::where('id_students', auth('student')->user()->id)->first();

        if ($notifyStudent && is_array($notifyStudent->notify_data)) {
            $notifications = $notifyStudent->notify_data;

            if (isset($notifications['notification']) && is_array($notifications['notification'])) {
                // Filter and count notifications where 'isRead' is 0
                $unreadCount = 0;
                foreach ($notifications['notification'] as $notification) {
                    if (isset($notification['isRead']) && $notification['isRead'] == 0) {
                        $unreadCount++;
                    }
                }
                return $unreadCount;
            }
        }

        return 0; // Return 0 if there are no notifications or in case of any error
    }
}

if (!function_exists('notifyStudent')) {
    function notifyStudent()
    {
        $notifyStudent = NotifyStudent::where('id_students', auth('student')->user()->id)->first();

        if ($notifyStudent && is_array($notifyStudent->notify_data)) {
            return $notifyStudent->notify_data; // Return the entire notification data
        }

        return []; // Return an empty array if there are no notifications or in case of any error
    }
}

if (!function_exists('notifyMentor')) {
    function notifyMentor()
    {
        if (auth('mentor')->check()) {
            $notifyMentor = NotifyMentor::where('id_mentors', auth('mentor')->user()->id)->first();

            if ($notifyMentor && is_array($notifyMentor->notify_mentors_data)) {
                return $notifyMentor->notify_mentors_data; // Return the entire notification data
            }
        }
        return []; // Return an empty array if there are no notifications or in case of any error
    }
}

if (!function_exists('notifyMentorCount')) {
    function notifyMentorCount()
    {
        if (auth('mentor')->check()) {
            $notifyMentor = NotifyMentor::where('id_mentors', auth('mentor')->user()->id)->first();

            if ($notifyMentor && is_array($notifyMentor->notify_mentors_data)) {
                $notificationMentors = $notifyMentor->notify_mentors_data;

                if (isset($notificationMentors['notification']) && is_array($notificationMentors['notification'])) {
                    // Filter and count notificationMentors where 'isRead' is 0
                    $unreadCount = 0;
                    foreach ($notificationMentors['notification'] as $notification) {
                        if (isset($notification['isRead']) && $notification['isRead'] == 0) {
                            $unreadCount++;
                        }
                    }
                    return $unreadCount;
                }
            }
        }
        return 0; // Return 0 if there are no notifications or in case of any error
    }
}

if (!function_exists('formatOrdinal')) {
    function formatOrdinal(int $number): string
    {
        if (in_array(($number % 100), array(11, 12, 13))) {
            $suffix = 'th';
        } else {
            switch ($number % 10) {
                case 1:
                    $suffix = 'st';
                    break;
                case 2:
                    $suffix = 'nd';
                    break;
                case 3:
                    $suffix = 'rd';
                    break;
                default:
                    $suffix = 'th';
                    break;
            }
        }

        return $number . $suffix;
    }
}
