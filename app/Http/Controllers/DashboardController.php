<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Mentor;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Project;
use App\Models\Student;
use App\Models\LoginLog;
use App\Mail\MailNotify;
use App\Models\Customer;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\ProjectSection;
use Illuminate\Support\Facades\Hash;
use App\Models\EnrolledProject;
use Illuminate\Validation\Rule;
use App\Models\ReadNotification;
use App\Models\SectionSubsection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    // public function index()
    // {
    //   $students   = Student::get()->count();
    //   $mentors    = Mentor::where('institution_id', '>',0)->get()->count();
    //   $staffs    = Mentor::where('institution_id', 0)->get()->count();
    //   $eProjects  = EnrolledProject::get()->count();
    //   $companies  = Company::get()->count();
    //   $student_complete_all = Student::withCount(['enrolled_projects' => function($q) {
    //                                     $q->where('is_submited', 1);
    //                                   }])
    //                                   ->having('enrolled_projects_count', '=', 4)
    //                                   ->get()->count();
    //   $student_complete_3 = Student::withCount(['enrolled_projects' => function($q) {
    //                                     $q->where('is_submited', 1);
    //                                   }])
    //                                   ->having('enrolled_projects_count', '=', 3)
    //                                   ->get()->count();

    //   return view('dashboard.index', compact('students','staffs','mentors','eProjects','companies', 'student_complete_all', 'student_complete_3'));
    // }

    // public function index()
    // {
    //     $data = [];

    //     $data['students'] = Student::count();
    //     $data['mentors']  = Mentor::where('institution_id', '>', 0)->count();
    //     $data['staffs']   = Mentor::where('institution_id', 0)->where('offboard',0)->count();
    //     $data['eProjects'] = EnrolledProject::count();
    //     $data['companies'] = Company::count();

    //     $data['student_complete_all'] = Student::whereHas('enrolled_projects', function($q) {
    //         $q->where('is_submited', 1);
    //     }, '=', 4)->whereDoesntHave('enrolled_projects', function($q) {
    //         $q->where('is_submited', 0);
    //     })->count();

    //     $data['student_complete_3'] = Student::whereHas('enrolled_projects', function($q) {
    //         $q->where('is_submited', 1);
    //     }, '=', 3)->count();

    //     // Students enrolled in project_id = 5 but haven't submitted yet
    //     $data['student_final_ongoing'] = Student::whereHas('enrolled_projects', function($q) {
    //         $q->where('project_id', 5)->where('is_submited', 0);
    //     })->count();

    //     // Students enrolled in project_id = 5 and have submitted
    //     $data['student_final_complete'] = Student::whereHas('enrolled_projects', function($q) {
    //         $q->where('project_id', 5)->where('is_submited', 1);
    //     })->count();

    //     return view('dashboard.index', $data);
    // }

    // public function index()
    // {
    //     $data = Cache::remember('dashboard_data', 60 * 24, function () {
    //         $data = [];

    //         $data['students'] = Student::count();
    //         $data['mentors']  = Mentor::where('institution_id', '>', 0)->count();
    //         $data['staffs']   = Mentor::where('institution_id', 0)->where('offboard',0)->count();
    //         $data['eProjects'] = EnrolledProject::count();
    //         $data['companies'] = Company::count();
    //         $data['loginLog'] = LoginLog::count();

    //         // Use withCount to optimize queries
    //         $studentsWithEnrolledProjects = Student::withCount([
    //             'enrolled_projects as total_enrolled_projects',
    //             'enrolled_projects as submitted_enrolled_projects' => function ($query) {
    //                 $query->where('is_submited', 1);
    //             }
    //         ])->get();

    //         $data['student_complete_all'] = $studentsWithEnrolledProjects->where('total_enrolled_projects', 4)
    //                                                                      ->where('submitted_enrolled_projects', 4)
    //                                                                      ->count();

    //         $data['student_complete_3'] = $studentsWithEnrolledProjects->where('total_enrolled_projects', '>=', 3)
    //                                                                    ->where('submitted_enrolled_projects', 3)
    //                                                                    ->count();

    //         // Combine ongoing and complete counts for project_id = 5
    //         $studentsWithSpecificProject = Student::withCount([
    //             'enrolled_projects as total_specific_project' => function ($query) {
    //                 $query->where('project_id', 5);
    //             },
    //             'enrolled_projects as submitted_specific_project' => function ($query) {
    //                 $query->where('project_id', 5)->where('is_submited', 1);
    //             }
    //         ])->get();

    //         $data['student_final_ongoing'] = $studentsWithSpecificProject->where('total_specific_project', '>', 0)
    //                                                                      ->where('submitted_specific_project', 0)
    //                                                                      ->count();

    //         $data['student_final_complete'] = $studentsWithSpecificProject->where('submitted_specific_project', '>', 0)
    //                                                                        ->count();

    //         // Get the start and end of the current week
    //         $startOfWeek = Carbon::now()->startOfWeek();
    //         $endOfWeek = Carbon::now()->endOfWeek();

    //         // Retrieve and count logins for each day of the current week
    //         $loginCounts = LoginLog::whereBetween('created_at', [$startOfWeek, $endOfWeek])
    //             ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
    //             ->groupBy('date')
    //             ->orderBy('date', 'asc')
    //             ->get()
    //             ->pluck('count', 'date');

    //         // Fill in missing days with zero count
    //         for ($date = $startOfWeek; $date->lte($endOfWeek); $date->addDay()) {
    //             $formattedDate = $date->format('Y-m-d');
    //             if (!isset($loginCounts[$formattedDate])) {
    //                 $loginCounts[$formattedDate] = 0;
    //             }
    //         }

    //         $data['loginCounts'] = $loginCounts->values();
    //         $data['loginDates'] = $loginCounts->keys();

    //         return $data;
    //     });
    //     // dd($data);
    //     return view('dashboard.index', $data);
    // }
    // Refactore code
    public function index()
    {
        // Cache the main dashboard data for 4 hours
        $dashboardData = Cache::remember('dashboard_data', 60 * 4, function () {
            return [
                'students' => Student::count(),
                'activeStudents' => Student::where('is_confirm', 1)->count(),
                'mentors' => Mentor::where('institution_id', '>', 0)->count(),
                'staffs' => Mentor::where('institution_id', 0)->where('offboard', 0)->count(),
                'eProjects' => EnrolledProject::count(),
                'companies' => Company::count(),
                'loginLog' => LoginLog::count(),
                'sexCount' => [
                    'entrepreneur_track' => [
                        'male' => Student::whereRaw('LOWER(sex) = "male"')->where('mentorship_type', 'entrepreneur_track')->count(),
                        'female' => Student::whereRaw('LOWER(sex) = "female"')->where('mentorship_type', 'entrepreneur_track')->count(),
                        'total' => Student::where('mentorship_type', 'entrepreneur_track')->count(),
                    ],
                    'skills_track' => [
                        'male' => Student::whereRaw('LOWER(sex) = "male"')->where('mentorship_type','skills_track')->count(),
                        'female' => Student::whereRaw('LOWER(sex) = "female"')->where('mentorship_type','skills_track')->count(),
                        'total' => Student::where('mentorship_type','skills_track')->count(),
                    ],
                    'crypto_guides' => [
                        'male' => EnrolledProject::where('project_id', 4)->whereHas('student', function ($query) {
                            $query->whereRaw('LOWER(sex) = "male"');
                        })->count(),

                        'female' => EnrolledProject::where('project_id', 4)->whereHas('student', function ($query) {
                            $query->whereRaw('LOWER(sex) = "female"');
                        })->count(),

                        'total' => EnrolledProject::where('project_id', 4)->count(),
                    ],
                    'eauto' => [
                        'male' => EnrolledProject::where('project_id', 1)->whereHas('student', function ($query) {
                            $query->whereRaw('LOWER(sex) = "male"');
                        })->count(),

                        'female' => EnrolledProject::where('project_id', 1)->whereHas('student', function ($query) {
                            $query->whereRaw('LOWER(sex) = "female"');
                        })->count(),

                        'total' => EnrolledProject::where('project_id', 1)->count(),
                    ],

                    'web_helpers' => [
                        'male' => EnrolledProject::where('project_id', 3)->whereHas('student', function ($query) {
                            $query->whereRaw('LOWER(sex) = "male"');
                        })->count(),

                        'female' => EnrolledProject::where('project_id', 3)->whereHas('student', function ($query) {
                            $query->whereRaw('LOWER(sex) = "female"');
                        })->count(),

                        'total' => EnrolledProject::where('project_id', 3)->count(),
                    ],
                ],
            ];
        });

        $dashboardDataGender = Cache::remember('dashboard_data_gender', 1 * 1, function () {
            return [
                'totalMale' => Student::where('sex','male')->count(),
                'totalFemale' => Student::where('sex','female')->count(),
                'totalMaleSkills_track' => Student::where('sex','male')->where('mentorship_type','skills_track')->count(),
                'totalFemaleSkills_track' => Student::where('sex','female')->where('mentorship_type','skills_track')->count(),
                'totalMaleEnterpreneur_track' => Student::where('sex','male')->where('mentorship_type','entrepreneur_track')->count(),
                'totalFemaleEnterpreneur_track' => Student::where('sex','female')->where('mentorship_type','enterpreneur_track')->count(),
                'maleStudentsWithEnrolledProjectsEAuto' => Student::where('sex', 'male')
                ->whereHas('enrolled_projects', function($query) {
                    // Apply the condition to the enrolled_projects relationship
                    $query->where('project_id', 1);
                })
                ->with('enrolled_projects')
                ->count(),

                'femaleStudentsWithEnrolledProjectsEAuto' => Student::where('sex', 'female')
                ->whereHas('enrolled_projects', function($query) {
                    // Apply the condition to the enrolled_projects relationship
                    $query->where('project_id', 1);
                })
                ->with('enrolled_projects')
                ->count(),

                'maleStudentsWithEnrolledProjectsWebHelpers' => Student::where('sex', 'male')
                ->whereHas('enrolled_projects', function($query) {
                    // Apply the condition to the enrolled_projects relationship
                    $query->where('project_id', 3);
                })
                ->with('enrolled_projects')
                ->count(),

                'femaleStudentsWithEnrolledProjectsWebHelpers' => Student::where('sex', 'female')
                ->whereHas('enrolled_projects', function($query) {
                    // Apply the condition to the enrolled_projects relationship
                    $query->where('project_id', 3);
                })
                ->with('enrolled_projects')
                ->count(),

                'maleStudentsWithEnrolledProjectsCryptoGuides' => Student::where('sex', 'male')
                ->whereHas('enrolled_projects', function($query) {
                    // Apply the condition to the enrolled_projects relationship
                    $query->where('project_id', 4);
                })
                ->with('enrolled_projects')
                ->count(),

                'femaleStudentsWithEnrolledProjectsCryptoGuides' => Student::where('sex', 'female')
                ->whereHas('enrolled_projects', function($query) {
                    // Apply the condition to the enrolled_projects relationship
                    $query->where('project_id', 4);
                })
                ->with('enrolled_projects')
                ->count(),
                // Other data...
            ];
        });

        // Cache the login data for 1 hour
        $loginData = Cache::remember('login_data', 60, function () {
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();

            $loginCounts = LoginLog::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get()
                ->pluck('count', 'date');

            for ($date = $startOfWeek; $date->lte($endOfWeek); $date->addDay()) {
                $formattedDate = $date->format('Y-m-d');
                if (!isset($loginCounts[$formattedDate])) {
                    $loginCounts[$formattedDate] = 0;
                }
            }

            return [
                'loginCounts' => $loginCounts->values(),
                'loginDates' => $loginCounts->keys(),
            ];
        });

        // Cache the message data for 1 hour
        $messageData = Cache::remember('message_data', 60, function () {
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();

            $messageCounts = Comment::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                                ->groupBy('date')
                                ->orderBy('date', 'asc')
                                ->get()
                                ->pluck('count', 'date');

            for ($date = $startOfWeek; $date->lte($endOfWeek); $date->addDay()) {
                $formattedDate = $date->format('Y-m-d');
                if (!isset($messageCounts[$formattedDate])) {
                    $messageCounts[$formattedDate] = 0;
                }
            }

            return [
                'messageCounts' => $messageCounts->values(),
                'messageDates' => $messageCounts->keys(),
            ];
        });

        // Combine the data arrays
        $data = array_merge($dashboardData, $loginData, $messageData);

        return view('dashboard.index', $data);
    }
    // Refactore code end

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
      $internshipsTotal  = EnrolledProject::whereHas('project', function($q){
        $q->where('company_id', Auth::guard('customer')->user()->company_id);
      })->get()->count();

      $internshipsOngoing = EnrolledProject::where('is_submited', 0)->whereHas('project', function($q){
        $q->where('company_id', Auth::guard('customer')->user()->company_id);
      })->get()->count();

      $customerTotal = Customer::where('company_id', Auth::guard('customer')->user()->company_id)->get()->count();

      $student_submissions = Submission::whereHas('project', function($q){
        $q->where('company_id', Auth::guard('customer')->user()->company_id);
      })->where('is_complete',1)->count();

      return view('dashboard.index', compact('internshipsTotal', 'internshipsOngoing', 'customerTotal', 'student_submissions'));
    }

    public function allCustomer()
    {
      $members = Customer::where('company_id', Auth::guard('customer')->user()->company_id)->get();
      return view('dashboard.companies.partner.index', compact('members'));
    }

    public function allCustomerEdit(Customer $member)
    {
      return view('dashboard.companies.partner.edit',compact('member'));
    }

    // public function indexMentor()
    // {
    //     if(Auth::guard('mentor')->user()->institution_id != 0){
    //     $students   = Student::where('institution_id', Auth::guard('mentor')->user()->institution_id)->get()->count();
    //     $assign_students   = Student::where('mentor_id', Auth::guard('mentor')->user()->id)->get()->count();
    //     $mentors    = Mentor::where('institution_id', Auth::guard('mentor')->user()->institution_id)->get()->count();
    //     $student_submissions = Submission::whereHas('student', function($q){
    //         $q->where('mentor_id', Auth::guard('mentor')->user()->id);
    //     })->where('is_complete', 1)->count();
    //     $student_complete_all = Student::where('mentor_id', Auth::guard('mentor')->user()->id)
    //                                               ->withCount(['enrolled_projects' => function($q) {
    //                                                   $q->where('is_submited', 1);
    //                                               }])
    //                                               ->having('enrolled_projects_count', '=', 4)
    //                                               ->get()->count();
    //     $student_complete_3 = Student::where('mentor_id', Auth::guard('mentor')->user()->id)
    //                                               ->withCount(['enrolled_projects' => function($q) {
    //                                                   $q->where('is_submited', 1);
    //                                               }])
    //                                               ->having('enrolled_projects_count', '=', 3)
    //                                               ->get()->count();
    //     }else{
    //     $students   = Student::get()->count();
    //     $assign_students   = Student::where('staff_id', Auth::guard('mentor')->user()->id)->get()->count();
    //     $mentors    = Mentor::where('institution_id', 0)->get()->count();
    //     $student_submissions = Submission::whereHas('student', function($q){
    //         $q->where('staff_id', Auth::guard('mentor')->user()->id);
    //     })->where('is_complete', 1)->count();
    //     $student_complete_all = Student::where('staff_id', Auth::guard('mentor')->user()->id)
    //                                               ->withCount(['enrolled_projects' => function($q) {
    //                                                   $q->where('is_submited', 1);
    //                                               }])
    //                                               ->having('enrolled_projects_count', '=', 4)
    //                                               ->get()->count();
    //     $student_complete_3 = Student::where('staff_id', Auth::guard('mentor')->user()->id)
    //                                               ->withCount(['enrolled_projects' => function($q) {
    //                                                   $q->where('is_submited', 1);
    //                                               }])
    //                                               ->having('enrolled_projects_count', '=', 3)
    //                                               ->get()->count();
    //     }

    //     return view('dashboard.index', compact('students','assign_students','mentors','student_submissions','student_complete_all', 'student_complete_3'));
    // }

    public function indexMentor()
    {
        return $this->index();

        $data = [];
        $mentor = Auth::guard('mentor')->user();

        if ($mentor->institution_id != 0) {
            $data['students'] = Student::where('institution_id', $mentor->institution_id)->count();
            $data['assign_students'] = Student::where('mentor_id', $mentor->id)->count();
            $data['mentors'] = Mentor::where('institution_id', $mentor->institution_id)->count();
        } else {
            $data['students'] = Student::count();
            $data['assign_students'] = Student::where('staff_id', $mentor->id)->count();
            $data['mentors'] = Mentor::where('institution_id', 0)->count();
        }

        $relationship = ($mentor->institution_id != 0) ? 'mentor_id' : 'staff_id';

        $data['student_submissions'] = Submission::whereHas('student', function($q) use ($relationship, $mentor) {
            $q->where($relationship, $mentor->id);
        })->where('is_complete', 1)->count();

        $data['student_complete_all'] = Student::where($relationship, $mentor->id)
            ->withCount(['enrolled_projects' => function($q) {
                $q->where('is_submited', 1);
            }])
            ->having('enrolled_projects_count', '=', 4)
            ->count();

        $data['student_complete_3'] = Student::where($relationship, $mentor->id)
            ->withCount(['enrolled_projects' => function($q) {
                $q->where('is_submited', 1);
            }])
            ->having('enrolled_projects_count', '=', 3)
            ->count();

        // Students enrolled in project_id = 5 but haven't submitted yet
        $data['student_final_ongoing'] = Student::where($relationship, $mentor->id)
            ->whereHas('enrolled_projects', function($q) {
                $q->where('project_id', 5)->where('is_submited', 0);
            })->count();

        // Students enrolled in project_id = 5 and have submitted
        $data['student_final_complete'] = Student::where($relationship, $mentor->id)
            ->whereHas('enrolled_projects', function($q) {
                $q->where('project_id', 5)->where('is_submited', 1);
            })->count();

        return view('dashboard.index', $data);
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

    public function profile($id)
    {
      if (Auth::guard('web')->check()) {
        $user = User::find($id);
      }elseif(Auth::guard('mentor')->check()){
        $user = Mentor::find($id);
      }elseif(Auth::guard('customer')->check()){
        $user = Customer::find($id);

      }
      return view('dashboard.admin.profile.edit', compact('user'));
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
        $user->password = Hash::make($validated['password']);
        }
        $user->save();

        toastr()->success('Profile Edited');

        return back();
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
          $mentor->password = Hash::make($validated['password']);
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
          $mentor->password = Hash::make($validated['password']);
          }
          $mentor->save();
        }

        toastr()->success('Profile Edited');

        return back();
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
        $customer->password = Hash::make($validated['password']);
        }
        $customer->save();

        toastr()->success('Profile Edited');

        return back();
      }
      return back();
    }

  public function contact()
  {
    return view('contact');
  }

  public function sendContact(Request $request)
  {

    $validated = $request->validate([
      'first_name' => ['required'],
      'last_name' => ['required'],
      'email' => ['required'],
      'user' => ['required'],
      'query' => ['required'],
      'message' => ['required'],
      'g-recaptcha-response' => 'required|recaptcha',
    ],[
      'first_name.required' => 'First name is required',
      'last_name.required' => 'Last name is required',
      'email.required' => 'Email is required',
      'user.required' => 'Type of user is required',
      'query.required' => 'Type of query is required',
      'message.required' => 'Message is required',
      'g-recaptcha-response.required' => 'Captcha is required',
    ]);

    $this->ContactUsMail('sip@sustainablelivinglab.org', $validated);

    toastr()->success('Your message has been successfully sent to our team.');

    return back();
  }

  public function ContactUsMail($mailto,$validated) //Email, urlInvitation
  {
      // if (Auth::guard('student')->check()) {
      //   $data = [
      //     'subject' => 'Simulated Internship Contact-Us',
      //     'body' => $mailto,
      //     'first_name' => Auth::guard('student')->user()->first_name,
      //     'last_name' => Auth::guard('student')->user()->last_name,
      //     'email' => Auth::guard('student')->user()->email,
      //     'message'=> $validated['message'],
      //     'type' => 'contactUs',
      //   ];
      // }else{
        $data = [
          'subject' => 'Simulated Internship Contact-Us',
          'body' => $mailto,
          'first_name' => Auth::guard('student')->check()? Auth::guard('student')->user()->first_name : $validated['first_name'],
          'last_name' => Auth::guard('student')->check()? Auth::guard('student')->user()->last_name : $validated['last_name'],
          'email' => Auth::guard('student')->check()? Auth::guard('student')->user()->email : $validated['email'],
          'user'=> $validated['user'],
          'query'=> $validated['query'],
          'message'=> $validated['message'],
          'type' => 'contactUs',
        ];
      // }

      try
      {
          Mail::to($mailto)->send(new MailNotify($data));
          return response()->json(['Your message has been successfully sent to our team.']);
      } catch (\Exception $th) {
          return response()->json(['Sorry Something went wrong']);
      }
  }

  public function studentCompleteAssign(Student $student)
  {
    $projects = Project::where('status', 'private_project')->get();
    return view('dashboard.students.complete.assign', compact('student', 'projects'));
  }

  public function studentCompleteAssignStore(Request $request,Student $student)
  {
    $enrolled_project = new EnrolledProject;
    $enrolled_project->student_id = $student->id;
    $enrolled_project->project_id = $request->project;
    $enrolled_project->is_submited = 0;
    $enrolled_project->save();
    return redirect('/dashboard/completed_all');
  }

//   public function studentComplete3()
//   {
//     if(Auth::guard('web')->check()){
//       $students = Student::withCount(['enrolled_projects' => function($q) {
//                               $q->where('is_submited', 1);
//                           }])
//                           ->having('enrolled_projects_count', '=', 3)
//                           ->get();
//       $enrolled_projects = EnrolledProject::get();
//     }elseif(Auth::guard('mentor')->check()){
//         if(Auth::guard('mentor')->user()->institution_id != 0){
//           $students = Student::where('mentor_id', Auth::guard('mentor')->user()->id)
//                     ->withCount(['enrolled_projects' => function($q) {
//                         $q->where('is_submited', 1);
//                     }])
//                     ->having('enrolled_projects_count', '=', 3)
//                     ->get();
//         }else{
//           $students = Student::where('staff_id', Auth::guard('mentor')->user()->id)
//                     ->withCount(['enrolled_projects' => function($q) {
//                         $q->where('is_submited', 1);
//                     }])
//                     ->having('enrolled_projects_count', '=', 3)
//                     ->get();
//         }
//         $enrolled_projects = EnrolledProject::get();
//     }
//     return view('dashboard.students.complete.all', compact('students', 'enrolled_projects'));
//   }

  public function studentComplete3()
  {
    $data = [];

    // Initialize the query
    $query = Student::withCount(['enrolled_projects' => function($q) {
        $q->where('is_submited', 1);
    }])->having('enrolled_projects_count', '=', 3);

    if (Auth::guard('web')->check()) {
        // No additional conditions for web guard
    } elseif (Auth::guard('mentor')->check()) {
        $mentor = Auth::guard('mentor')->user();
        if ($mentor->institution_id != 0) {
            $query->where('mentor_id', $mentor->id);
        } else {
            $query->where('staff_id', $mentor->id);
        }
    }

    $data['students'] = $query->get();
    $data['enrolled_projects'] = EnrolledProject::all();

    return view('dashboard.students.complete.all', $data);
  }

//   public function studentCompleteAll()
//   {
//     if(Auth::guard('web')->check()){
//       $students = Student::withCount(['enrolled_projects' => function($q) {
//                               $q->where('is_submited', 1);
//                           }])
//                           ->having('enrolled_projects_count', '=', 4)
//                           ->get();
//       $enrolled_projects = EnrolledProject::get();
//     }elseif(Auth::guard('mentor')->check()){
//         if(Auth::guard('mentor')->user()->institution_id != 0){
//           $students = Student::where('mentor_id', Auth::guard('mentor')->user()->id)
//                     ->withCount(['enrolled_projects' => function($q) {
//                         $q->where('is_submited', 1);
//                     }])
//                     ->having('enrolled_projects_count', '=', 4)
//                     ->get();
//         }else{
//           $students = Student::where('staff_id', Auth::guard('mentor')->user()->id)
//                     ->withCount(['enrolled_projects' => function($q) {
//                         $q->where('is_submited', 1);
//                     }])
//                     ->having('enrolled_projects_count', '=', 4)
//                     ->get();
//         }
//         $enrolled_projects = EnrolledProject::get();
//     }
//     return view('dashboard.students.complete.all', compact('students', 'enrolled_projects'));
//   }

    public function studentCompleteAll()
    {
        $data = [];

        // Initialize the query
        $query = Student::whereHas('enrolled_projects', function($q) {
            $q->where('is_submited', 1);
        }, '=', 4)->whereDoesntHave('enrolled_projects', function($q) {
            $q->where('is_submited', 0);
        });

        if (Auth::guard('web')->check()) {
            // No additional conditions for web guard
        } elseif (Auth::guard('mentor')->check()) {
            $mentor = Auth::guard('mentor')->user();
            if ($mentor->institution_id != 0) {
                $query->where('mentor_id', $mentor->id);
            } else {
                $query->where('staff_id', $mentor->id);
            }
        }

        $data['students'] = $query->get();
        $data['enrolled_projects'] = EnrolledProject::all();

        return view('dashboard.students.complete.all', $data);
    }

    public function finalPresentationOngoing()
    {
        $data = [];

        // Students enrolled in project_id = 5 and have submitted
        $query = Student::whereHas('enrolled_projects', function($q) {
            $q->where('project_id', 5)->where('is_submited', 0);
        });

        if (Auth::guard('web')->check()) {
            // No additional conditions for web guard
        } elseif (Auth::guard('mentor')->check()) {
            $mentor = Auth::guard('mentor')->user();
            if ($mentor->institution_id != 0) {
                $query->where('mentor_id', $mentor->id);
            } else {
                $query->where('staff_id', $mentor->id);
            }
        }

        $data['students'] = $query->get();
        $data['enrolled_projects'] = EnrolledProject::all();

        return view('dashboard.students.complete.all', $data);
    }

    public function finalPresentationComplete()
    {
        $data = [];
        // Students enrolled in project_id = 5 and have submitted
        $query = Student::whereHas('enrolled_projects', function($q) {
            $q->where('project_id', 5)->where('is_submited', 1);
        })->withCount('enrolled_projects');

        if (Auth::guard('web')->check()) {
            // No additional conditions for web guard
        } elseif (Auth::guard('mentor')->check()) {
            $mentor = Auth::guard('mentor')->user();
            if ($mentor->institution_id != 0) {
                $query->where('mentor_id', $mentor->id);
            } else {
                $query->where('staff_id', $mentor->id);
            }
        }

        $data['students'] = $query->get();
        $data['enrolled_projects'] = EnrolledProject::all();

        return view('dashboard.students.complete.all', $data);
    }


//   End of Bracket Don't Delete this bracket
}
