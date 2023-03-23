<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mentor;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Project;
use App\Models\Student;
use App\Mail\MailNotify;
use App\Models\Customer;
use App\Models\Submission;
use Illuminate\Http\Request;

use App\Models\ProjectSection;
use App\Models\EnrolledProject;
use Illuminate\Validation\Rule;
use App\Models\ReadNotification;
use App\Models\SectionSubsection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
      $students   = Student::get()->count();
      $mentors    = Mentor::where('institution_id', '>',0)->get()->count();
      $staffs    = Mentor::where('institution_id', 0)->get()->count();
      $eProjects  = EnrolledProject::get()->count();
      $companies  = Company::get()->count();
      
      if(Auth::guard('web')->check()){
          $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('user_id',Auth::guard('web')->user()->id)->get()->count();
          $submissionNotifications = Submission::where('is_complete', 1)
              ->whereNotIn('id', function($query) {
                  $query->select('submission_id')
                        ->from('read_notifications')
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
                          ->where('is_read', 1)
                          ->where('customer_id', Auth::guard('customer')->user()->id);
                })
                ->get();
          }
      $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;
      return view('dashboard.index', compact('students','staffs','mentors','eProjects','companies','totalNotificationAdmin','submissionNotifications'));
    }

    public function singleSubmissionReadNotification($projectID,$submissionID,$studentId){
      if(Auth::guard('web')->check()){
        $checkReadNotification = ReadNotification::where('submission_id',$submissionID)->where('user_id',Auth::guard('web')->user()->id)->first();
      }elseif(Auth::guard('mentor')->check()){
        $checkReadNotification = ReadNotification::where('submission_id',$submissionID)->where('mentor_id',Auth::guard('mentor')->user()->id)->first();
      }elseif(Auth::guard('customer')->check()){
        $checkReadNotification = ReadNotification::where('submission_id',$submissionID)->where('customer_id',Auth::guard('customer')->user()->id)->first();
      }
      if($checkReadNotification == NULL){
        $ReadNotification = new ReadNotification;
        $ReadNotification->student_id = $studentId;
        $ReadNotification->submission_id = $submissionID;
        $ReadNotification->type = 'submissions';
        $ReadNotification->is_read = 1;
        if(Auth::guard('web')->check()){
          $ReadNotification->user_id = Auth::guard('web')->user()->id;
        }elseif(Auth::guard('mentor')->check()){
          $ReadNotification->mentor_id = Auth::guard('mentor')->user()->id;
        }elseif(Auth::guard('customer')->check()){
          $ReadNotification->customer_id = Auth::guard('customer')->user()->id;
        }
        $ReadNotification->save();
        return redirect()->route('dashboard.submission.singleSubmission',[$projectID,$submissionID]);
      }else{
        return back();
      }
    }

    public function indexCustomer()
    {
      
      if(Auth::guard('web')->check()){
          $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('user_id',Auth::guard('web')->user()->id)->get()->count();
          $submissionNotifications = Submission::where('is_complete', 1)
              ->whereNotIn('id', function($query) {
                  $query->select('submission_id')
                        ->from('read_notifications')
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
                          ->where('is_read', 1)
                          ->where('customer_id', Auth::guard('customer')->user()->id);
                })
                ->get();
          }
      $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;

      $internshipsTotal  = EnrolledProject::whereHas('project', function($q){
        $q->where('company_id', Auth::guard('customer')->user()->company_id);
      })->get()->count();

      $internshipsOngoing = EnrolledProject::where('is_submited', 0)->whereHas('project', function($q){
        $q->where('company_id', Auth::guard('customer')->user()->company_id);
      })->get()->count();
      
      $customerTotal = Customer::where('company_id', Auth::guard('customer')->user()->company_id)->get()->count();

      $student_submissions = Submission::whereHas('project', function($q){
        $q->where('company_id', Auth::guard('customer')->user()->company_id);
      })->count();

      return view('dashboard.index', compact('internshipsTotal', 'internshipsOngoing', 'customerTotal', 'student_submissions','totalNotificationAdmin','submissionNotifications'));
    }

    public function allCustomer()
    {
      
      if(Auth::guard('web')->check()){
          $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('user_id',Auth::guard('web')->user()->id)->get()->count();
          $submissionNotifications = Submission::where('is_complete', 1)
              ->whereNotIn('id', function($query) {
                  $query->select('submission_id')
                        ->from('read_notifications')
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
                          ->where('is_read', 1)
                          ->where('customer_id', Auth::guard('customer')->user()->id);
                })
                ->get();
          }
      $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;
      $members = Customer::where('company_id', Auth::guard('customer')->user()->company_id)->get();
      return view('dashboard.companies.partner.index', compact('members','totalNotificationAdmin','submissionNotifications'));
    }

    public function allCustomerEdit(Customer $member)
    {
      return view('dashboard.companies.partner.edit',compact('member'));
    }

    public function indexMentor()
    { 
      if(Auth::guard('web')->check()){
          $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('user_id',Auth::guard('web')->user()->id)->get()->count();
          $submissionNotifications = Submission::where('is_complete', 1)
              ->whereNotIn('id', function($query) {
                  $query->select('submission_id')
                        ->from('read_notifications')
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
          if(Auth::guard('mentor')->user()->institution_id != 0){
            $students   = Student::where('institution_id', Auth::guard('mentor')->user()->institution_id)->get()->count();
            $assign_students   = Student::where('mentor_id', Auth::guard('mentor')->user()->id)->get()->count();
            $mentors    = Mentor::where('institution_id', Auth::guard('mentor')->user()->institution_id)->get()->count();
            $student_submissions = Submission::whereHas('student', function($q){
              $q->where('mentor_id', Auth::guard('mentor')->user()->id);
            })->count();
          }else{
            $students   = Student::get()->count();
            $assign_students   = Student::where('staff_id', Auth::guard('mentor')->user()->id)->get()->count();
            $mentors    = Mentor::where('institution_id', 0)->get()->count();
            $student_submissions = Submission::whereHas('student', function($q){
              $q->where('staff_id', Auth::guard('mentor')->user()->id);
            })->count();
          }
      } elseif(Auth::guard('customer')->check()){
          $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
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
      return view('dashboard.index', compact('students','assign_students','mentors','student_submissions','totalNotificationAdmin','submissionNotifications'));
    }

    public function allAssignedProjectsBEST()
    {
      $projects = Project::all();
      $enrolledProjects = EnrolledProject::select('project_id')->groupBy('project_id')->get();
      $totalStudents = EnrolledProject::selectRaw('count(DISTINCT student_id) as total, project_id')->groupBy('project_id')->get();

      return view('dashboard.admin.assignedProjects', compact('projects', 'enrolledProjects', 'totalStudents'));
    }

    public function allAssignedProjects()
    {
      $projects = Project::all();
      $enrolledProjects = EnrolledProject::all();
      return view('dashboard.admin.assignedProjects', compact('projects', 'enrolledProjects'));
    }

    public function sectionProjectAssign($project_id)
    {
        $project = Project::find($project_id);
        $project_sections =  ProjectSection::where('project_id', $project_id)->get();
        return view('dashboard.admin.assigned.section.index', compact(['project', 'project_sections']));
    }

    public function subsectionProjectAssign($project_id, $section_id)
    {
        $project = Project::find($project_id);
        $project_section = ProjectSection::find($section_id);
        $project_subsections =  SectionSubsection::where('project_section_id', $section_id)->get();
        // dd($project_subsections->submission);
        return view('dashboard.admin.assigned.section.subsection.index', compact(['project' ,'project_section', 'project_subsections']));
    }

    public function showAllStudentsChats($project_id, $section_id)
    {
        $enrolled_students = EnrolledProject::where('project_id', $project_id)->get();
        // dd($enrolled_students);
        return view('dashboard.admin.assigned.section.chat.index', compact(['project_id','section_id','enrolled_students']));
    }

    public function singleStudentChat($project_id, $section_id, $student_id)
    {
        $comments = Comment::where('project_id', $project_id)->where('project_section_id', $section_id)->get();
        return view('dashboard.admin.assigned.section.chat.show', compact(['project_id','section_id','student_id','comments']));
    }

    public function showAllStudentsSubmission($project_id, $section_id)
    {
        $enrolled_students = EnrolledProject::where('project_id', $project_id)->get();
        return view('dashboard.admin.assigned.section.submission.index', compact(['project_id','section_id','enrolled_students']));
    }

    public function singleStudentSubmission($project_id, $section_id, $student_id)
    {
        $submission = Submission::where('project_id', $project_id)->where('section_id', $section_id)->where('student_id', $student_id)->first();
        return view('dashboard.admin.assigned.section.submission.show', compact(['project_id','section_id','student_id','submission']));
    }

    // Profile

    public function profile($id){
      
      if(Auth::guard('web')->check()){
          $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('user_id',Auth::guard('web')->user()->id)->get()->count();
          $submissionNotifications = Submission::where('is_complete', 1)
              ->whereNotIn('id', function($query) {
                  $query->select('submission_id')
                        ->from('read_notifications')
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
                          ->where('is_read', 1)
                          ->where('customer_id', Auth::guard('customer')->user()->id);
                })
                ->get();
          }
      $totalNotificationAdmin = $submissionNotifications->count() - $submissionCountReadNotification;

      if (Auth::guard('web')->check()) {
        $user = User::find($id);
      }elseif(Auth::guard('mentor')->check()){
        $user = Mentor::find($id);
      }elseif(Auth::guard('customer')->check()){
        $user = Customer::find($id);

      }
      return view('dashboard.admin.profile.edit', compact('user','totalNotificationAdmin','submissionNotifications'));
    }

    public function updateProfile(Request $request, $id){
      if (Auth::guard('web')->check()) {
        $validated = $request->validate([
          'name' => ['required'],
          'email' => ['required'],
          'password' => ['nullable', 'min:5', 'confirmed', Rule::requiredIf(function () use ($request) {
            return !empty($request->input('password'));
          })],
          'password_confirmation' => ['nullable', Rule::requiredIf(function () use ($request) {
              return !empty($request->input('password'));
          })]
        ],
        [
          'name.required' => 'Name is required',
          'email.required' => 'Email is required',
          'password.confirmed' => 'Password confirmation must be the same',
          'password_confirmation.required'=> 'Please enter your confirmation password',
        ]);

        $user = User::find($id);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if(!empty($validated['password'])){
        $user->password = \Hash::make($validated['password']);
        }
        $user->save();
        return back()->with('successTailwind', 'Profile Edited');
      }elseif(Auth::guard('mentor')->check()){
        if(Auth::guard('mentor')->user()->institution_id != 0){
          $validated = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required'],
            'institution' => ['required'],
            'state' => ['required'],
            'country' => ['required'],
            'position' => ['required'],
            'password' => ['nullable', 'min:5', 'confirmed', Rule::requiredIf(function () use ($request) {
              return !empty($request->input('password'));
            })],
            'password_confirmation' => ['nullable', Rule::requiredIf(function () use ($request) {
                return !empty($request->input('password'));
            })]
          ],
          [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email is required',
            'institution.required' => 'Institution is required',
            'state.required' => 'State is required',
            'country.required' => 'Country is required',
            'position.required' => 'Position is required',
            'password.confirmed' => 'Password confirmation must be the same',
            'password_confirmation.required'=> 'Please enter your confirmation password',
          ]);
          $mentor = Mentor::find($id);
          $mentor->first_name = $validated['first_name'];
          $mentor->last_name = $validated['last_name'];
          $mentor->position = $validated['position'];
          if(!empty($validated['password'])){
          $mentor->password = \Hash::make($validated['password']);
          }
          $mentor->save();
        }else{
          $validated = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required'],
            'password' => ['nullable', 'min:5', 'confirmed', Rule::requiredIf(function () use ($request) {
              return !empty($request->input('password'));
            })],
            'password_confirmation' => ['nullable', Rule::requiredIf(function () use ($request) {
                return !empty($request->input('password'));
            })]
          ],
          [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email is required',
            'password.confirmed' => 'Password confirmation must be the same',
            'password_confirmation.required'=> 'Please enter your confirmation password',
          ]);
          $mentor = Mentor::find($id);
          $mentor->first_name = $validated['first_name'];
          $mentor->last_name = $validated['last_name'];
          if(!empty($validated['password'])){
          $mentor->password = \Hash::make($validated['password']);
          }
          $mentor->save();
        }
          return back()->with('successTailwind', 'Profile Edited');
      }elseif(Auth::guard('customer')->check()){
        $validated = $request->validate([
          'first_name' => ['required'],
          'last_name' => ['required'],
          'email' => ['required'],
          'company' => ['required'],
          'position' => ['required'],
          'password' => ['nullable', 'min:5', 'confirmed', Rule::requiredIf(function () use ($request) {
            return !empty($request->input('password'));
          })],
          'password_confirmation' => ['nullable', Rule::requiredIf(function () use ($request) {
              return !empty($request->input('password'));
          })]
        ],
        [
          'first_name.required' => 'First name is required',
          'last_name.required' => 'Last name is required',
          'email.required' => 'Email is required',
          'company.required' => 'Institution is required',
          'sex.required' => 'Sex is required',
          'position.required' => 'Position is required',
          'password.confirmed' => 'Password confirmation must be the same',
          'password_confirmation.required'=> 'Please enter your confirmation password',
        ]);

        $customer = Customer::find($id);
        $customer->first_name = $validated['first_name'];
        $customer->last_name = $validated['last_name'];
        $customer->position = $validated['position'];
        if(!empty($validated['password'])){
        $customer->password = \Hash::make($validated['password']);
        }
        $customer->save();
        return back()->with('successTailwind', 'Profile Edited');
      } 
      return back();
    }
  
  public function contact()
  {
    return view('contact');
  }
  
  public function sendContact(Request $request)
  {
    // dd($request->all());
    if (Auth::guard('student')->check()) {
      $validated = $request->validate([
        'message' => ['required'],
        'g-recaptcha-response' => 'required|recaptcha',
      ],[
        'message.required' => 'Message is required',
        'g-recaptcha-response.required' => 'Captcha is required',
      ]);
    }else{
      $validated = $request->validate([
        'first_name' => ['required'],
        'last_name' => ['required'],
        'email' => ['required'],
        'message' => ['required'],
        'g-recaptcha-response' => 'required|recaptcha',
      ],[
        'first_name.required' => 'First name is required',
        'last_name.required' => 'Last name is required',
        'email.required' => 'Email is required',
        'message.required' => 'Message is required',
        'g-recaptcha-response.required' => 'Captcha is required',
      ]);
    }
    
    $this->ContactUsMail('sip@sustainablelivinglab.org', $validated);
    return back()->with('successTailwind', 'Your message has been successfully sent to our team.');

  }

  public function ContactUsMail($mailto,$validated) //Email, urlInvitation
  {
    $data = [
      'subject' => 'Simulated Internship Contact-Us',
      'body' => $mailto,
      'first_name' => Auth::guard('student')->check()? Auth::guard('student')->user()->first_name : $validated['first_name'],
      'last_name' => Auth::guard('student')->check()? Auth::guard('student')->user()->last_name : $validated['last_name'],
      'email' => Auth::guard('student')->check()? Auth::guard('student')->user()->email : $validated['email'],
      'message'=> $validated['message'],
      'type' => 'contactUs',
    ];
    
    
    try
    {
        Mail::to($mailto)->send(new MailNotify($data));
        return response()->json(['Your message has been successfully sent to our team.']);
    } catch (\Exception $th) {
        return response()->json(['Sorry Something went wrong']);
    }
  }
}
