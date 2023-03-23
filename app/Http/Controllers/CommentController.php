<?php

namespace App\Http\Controllers;

use App\Jobs\CommentReadJob;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Student;
use App\Models\EnrolledProject;
use App\Models\Customer;
use App\Models\Submission;
use App\Models\ReadNotification;
use Illuminate\Http\Request;
use App\Models\ProjectSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function store(Request $request, $student_id, $project_id, $task_id)
    {
        $validated = $request->validate([
            'message' => 'required',
        ]);
        $comment = new Comment;
        $comment->student_id = $student_id;
        $comment->project_id = $project_id;
        $comment->project_section_id = $task_id;
        $comment->message = $validated['message'];
        if($request->hasFile('file')){
            $file = Storage::disk('public')->put('comments/'.$student_id.'/project/'.$project_id.'/task/'.$task_id, $request->file);
            $comment->file = $file;
        }
        $comment->save();
        return redirect('/profile/'.$student_id.'/enrolled/'.$project_id.'/task/'.$task_id);
    }



    public function index()
    {

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
            $injections = ProjectSection::whereHas('comment')->get();
            $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('user_id',Auth::guard('web')->user()->id)->get()->count();
            $submissionNotifications = Submission::where('is_complete', 1)
                ->whereNotIn('id', function($query) {
                    $query->select('submission_id')
                          ->from('read_notifications')
                          ->where('type', 'submissions')
                          ->where('is_read', 1)
                          ->where('user_id', Auth::guard('web')->user()->id);
                })
                ->get();
                $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;
            return view('dashboard.messages.index', compact('messages','injections','totalNotificationAdmin','submissionNotifications'));
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

                $injections = ProjectSection::whereHas('comment', function($q){
                    $q->whereHas('student', function($q){
                        $q->where('mentor_id', Auth::guard('mentor')->user()->id);
                    });
                })->get();
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
                $injections = ProjectSection::whereHas('comment', function($q){
                    $q->whereHas('student', function($q){
                        $q->where('staff_id', Auth::guard('mentor')->user()->id);
                    });
                })->get();
            }
            $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('mentor_id',Auth::guard('mentor')->user()->id)->get()->count();
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
            $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;
            return view('dashboard.messages.index', compact('messages','injections','totalNotificationAdmin','submissionNotifications'));
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
            $injections = ProjectSection::whereHas('comment', function($q){
                $q->whereHas('project', function($q){
                    $q->where('company_id', Auth::guard('customer')->user()->company_id);
                });
            })->get();

            $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
            $submissionNotifications = Submission::whereHas('project', function($q){
                $q->where('company_id', Auth::guard('customer')->user()->company_id);
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
            $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;
            return view('dashboard.messages.index', compact('messages','injections','totalNotificationAdmin','submissionNotifications'));
        }
    }

    public function create()
    {

        if(Auth::guard('web')->check()){
            $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('user_id',Auth::guard('web')->user()->id)->get()->count();
            $submissionNotifications = Submission::where('is_complete', 1)
                ->whereNotIn('id', function($query) {
                    $query->select('submission_id')
                          ->from('read_notifications')
                          ->where('type', 'submissions')
                          ->where('is_read', 1)
                          ->where('user_id', Auth::guard('web')->user()->id);
                })
                ->get();
        } elseif(Auth::guard('mentor')->check()){
            $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('mentor_id',Auth::guard('mentor')->user()->id)->get()->count();
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
            $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
            $submissionNotifications = Submission::whereHas('project', function($q){
              $q->where('company_id', Auth::guard('customer')->user()->company_id);
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
        $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;

        if(Auth::guard('web')->check()){
        $projects = Project::get();
        $projectSections = ProjectSection::get();
        $students = Student::get();
        }elseif(Auth::guard('mentor')->check()){
        // dd(Auth::guard('mentor')->user()->institution_id);
        if(Auth::guard('mentor')->user()->institution_id != 0){
          $projects = Project::where('institution_id',Auth::guard('mentor')->user()->institution_id)->orWhere('institution_id', null)->whereIn('status', ['publish'])->get();
        }else{
          $projects = Project::where('status', 'publish')->get();
        }
        $projectSections = ProjectSection::get();
        $students = Student::get();
        }elseif(Auth::guard('customer')->check()){
        $projects = Project::get();
        $projectSections = ProjectSection::get();
        $students = Student::get();
        }
        return view('dashboard.messages.create', compact('projects', 'projectSections', 'students','totalNotificationAdmin','submissionNotifications'));
    }

    public function getdatacomment($id)
    {
        $projectSections = ProjectSection::where('project_id',$id)->get();
        return $projectSections;
    }

    public function getdatastudent($id)
    {
        $EnrolledProjects = EnrolledProject::where('project_id', $id)->get();
        $students = [];

        foreach ($EnrolledProjects as $EnrolledProject) {
            $students[] = $EnrolledProject->student;
        }

        return $students;
    }

    public function taskMessage(ProjectSection $injection)
    {

        if(Auth::guard('web')->check()){
            $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('user_id',Auth::guard('web')->user()->id)->get()->count();
            $submissionNotifications = Submission::where('is_complete', 1)
                ->whereNotIn('id', function($query) {
                    $query->select('submission_id')
                          ->from('read_notifications')
                          ->where('type', 'submissions')
                          ->where('is_read', 1)
                          ->where('user_id', Auth::guard('web')->user()->id);
                })
                ->get();
            } elseif(Auth::guard('mentor')->check()){
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('mentor_id',Auth::guard('mentor')->user()->id)->get()->count();
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
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
                $submissionNotifications = Submission::whereHas('project', function($q){
                  $q->where('company_id', Auth::guard('customer')->user()->company_id);
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
        $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;

        if(Auth::guard('web')->check()){
            $participants = Student::whereHas('comment')->get();
            $customer_participants = Customer::where('company_id',$injection->project->company_id)->get();
            $comments = Comment::where('project_section_id',$injection->id)->where('read_message', 0)->get();
            return view('dashboard.messages.taskMessage', compact('participants', 'injection','customer_participants', 'comments','totalNotificationAdmin','submissionNotifications'));
        }elseif(Auth::guard('mentor')->check()){
            if(Auth::guard('mentor')->user()->institution_id != 0){
              $participants = Student::whereHas('comment')->where('mentor_id',Auth::guard('mentor')->user()->id)->get();
            }else{
              $participants = Student::whereHas('comment')->where('staff_id',Auth::guard('mentor')->user()->id)->get();
            }
            $customer_participants = Customer::where('company_id',$injection->project->company_id)->get();
            $comments = Comment::where('project_section_id',$injection->id)->where('read_message', 0)->get();
            return view('dashboard.messages.taskMessage', compact('participants', 'injection','customer_participants', 'comments','totalNotificationAdmin','submissionNotifications'));
        }elseif(Auth::guard('customer')->check()){
            $participants = Student::whereHas('comment')->get();
            $customer_participants = Customer::where('company_id',Auth::guard('customer')->user()->company_id)->get();
            $comments = Comment::where('project_section_id',$injection->id)->where('read_message', 0)->get();
            return view('dashboard.messages.taskMessage', compact('participants', 'injection','customer_participants', 'comments','totalNotificationAdmin','submissionNotifications'));
        }
    }

    public function single(ProjectSection $injection, Student $participant)
    {

        if(Auth::guard('web')->check()){
            $roleUserId = Auth::guard('web')->user()->id;
            $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('user_id',Auth::guard('web')->user()->id)->get()->count();
            $submissionNotifications = Submission::where('is_complete', 1)
                ->whereNotIn('id', function($query) {
                    $query->select('submission_id')
                          ->from('read_notifications')
                          ->where('type', 'submissions')
                          ->where('is_read', 1)
                          ->where('user_id', Auth::guard('web')->user()->id);
                })
                ->get();
            } elseif(Auth::guard('mentor')->check()){
                $roleUserId = Auth::guard('mentor')->user()->id;
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('mentor_id',Auth::guard('mentor')->user()->id)->get()->count();
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
                $roleUserId = Auth::guard('customer')->user()->id;
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
                $submissionNotifications = Submission::whereHas('project', function($q){
                  $q->where('company_id', Auth::guard('customer')->user()->company_id);
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
        $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;
        $guard = Auth::getDefaultDriver();
        $comments = Comment::where('project_section_id', $injection->id)->where('student_id', $participant->id)->get();
        $customer_participants = Customer::where('company_id',$injection->project->company_id)->get();

        dispatch(new CommentReadJob($injection, $participant, $roleUserId, $guard));

        return view('dashboard.messages.singleMessage', compact('injection', 'participant', 'comments', 'customer_participants','totalNotificationAdmin','submissionNotifications'));
    }

    public function adminReply(ProjectSection $injection, Student $participant)
    {

        if(Auth::guard('web')->check()){
            $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('user_id',Auth::guard('web')->user()->id)->get()->count();
            $submissionNotifications = Submission::where('is_complete', 1)
                ->whereNotIn('id', function($query) {
                    $query->select('submission_id')
                          ->from('read_notifications')
                          ->where('type', 'submissions')
                          ->where('is_read', 1)
                          ->where('user_id', Auth::guard('web')->user()->id);
                })
                ->get();
            } elseif(Auth::guard('mentor')->check()){
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('mentor_id',Auth::guard('mentor')->user()->id)->get()->count();
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
                $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
                $submissionNotifications = Submission::whereHas('project', function($q){
                  $q->where('company_id', Auth::guard('customer')->user()->company_id);
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
        $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;

        $customer_participants = Customer::where('company_id',$injection->project->company_id)->get();
        return view('dashboard.messages.replyMessage', compact('injection', 'participant', 'customer_participants','totalNotificationAdmin','submissionNotifications'));
    }

    public function adminSendMessage (Request $request,ProjectSection $injection, Student $participant)
    {
        // dd($request->all());
        $validated = $request->validate([
            'message' => 'required',
        ]);
        $comment = new Comment;
        if(Auth::guard('web')->check()){
            $comment->user_id = Auth::guard('web')->user()->id;
            $comment->student_id = $participant->id;
        }elseif(Auth::guard('mentor')->check()){
            if(Auth::guard('mentor')->user()->institution_id != 0){
              $comment->mentor_id = Auth::guard('mentor')->user()->id;
            }else{
              $comment->staff_id = Auth::guard('mentor')->user()->id;
            }
            $comment->student_id = $participant->id;
        }elseif(Auth::guard('customer')->check()){
            $comment->customer_id = Auth::guard('customer')->user()->id;
            $comment->student_id = $participant->id;
        }
        $comment->project_id = $injection->project->id;
        $comment->project_section_id = $injection->id;
        $comment->message = $validated['message'];
        if($request->hasFile('file')){
            $file = Storage::disk('public')->put('message/project/'.$injection->project->id.'/task/'.$injection->id, $request->file);
            $comment->file = $file;
        }
        $comment->save();
        return redirect('/dashboard/messages/'.$injection->id.'/single/'.$participant->id);
    }

    public function adminSendMessageGlobal(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'project' => 'required',
            'injection' => 'required',
            'student' => 'required',
            'message' => 'required',
        ]);
        $comment = new Comment;
        if(Auth::guard('web')->check()){
            $comment->user_id = Auth::guard('web')->user()->id;
            $comment->student_id = $validated['student'];
        }elseif(Auth::guard('mentor')->check()){
            if(Auth::guard('mentor')->user()->institution_id != 0){
              $comment->mentor_id = Auth::guard('mentor')->user()->id;
            }else{
              $comment->staff_id = Auth::guard('mentor')->user()->id;
            }
            $comment->student_id = $validated['student'];
        }elseif(Auth::guard('customer')->check()){
            $comment->customer_id = Auth::guard('customer')->user()->id;
            $comment->student_id = $validated['student'];
        }
        $comment->project_id = $validated['project'];
        $comment->project_section_id = $validated['injection'];
        $comment->message = $validated['message'];
        if($request->hasFile('file')){
            $file = Storage::disk('public')->put('message/project/'.$validated['project'].'/task/'.$validated['injection'], $request->file);
            $comment->file = $file;
        }
        $comment->save();
        return redirect('/dashboard/messages/'.$validated['injection'].'/single/'.$validated['student']);
    }
}
