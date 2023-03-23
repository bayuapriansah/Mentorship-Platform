<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mentor;
use App\Models\Student;
use App\Mail\MailNotify;
use App\Models\Customer;
use App\Models\Institution;
use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\ReadNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SimintEncryption;

class StaffController extends Controller
{
    public function index()
    {
        if(Auth::guard('web')->check()){

          $submissionNotifications = Submission::where('is_complete', 1)->whereNotIn('id', function($query) {$query->select('submission_id')->from('read_notifications')->where('type', 'submissions')->where('is_read', 1)->where('user_id', Auth::guard('web')->user()->id);})->get();
          } elseif(Auth::guard('mentor')->check()){
              $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('type','submissions')->where('mentor_id',Auth::guard('mentor')->user()->id)->get()->count();
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
              $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('type','submissions')->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
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
      $totalNotificationAdmin = $submissionNotifications->count();
      $staffs = Mentor::where('institution_id',0)->get();
      return view('dashboard.staffs.index', compact('staffs'));
    }

    public function invite()
    {
      if(Auth::guard('web')->check()){

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
    $totalNotificationAdmin = $submissionNotifications->count();
      return view('dashboard.staffs.invite',compact('totalNotificationAdmin','submissionNotifications'));
    }

    public function addStaff($email){
      return Mentor::create([
          'email' => $email,
          'institution_id' => 0,
          'is_confirm' => 0
      ]);
    }

    public function StaffMemberInvitation($mailto, $urlInvitation)
    {
        $data = [
            'subject' => 'Invitation to join as a Staff Member',
            'body' => $mailto,
            'body2' => $urlInvitation,
            'body3' => 'Simulated Internship Platform',
            'type' => 'staffmember',
        ];
        try {
            Mail::to($mailto)->send(new MailNotify($data));
            return response()->json(['message' => 'Staff Invitation Email sent successfully']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function sendInvite(Request $request)
    {
      $message = "Successfully Send Invitation to Staff Member";
        foreach (array_filter($request->email) as $email) {
          $checkStudent = Student::where('email', $email)->first();
          $checkUser = User::where('email', $email)->first();
          $checkMentor = Mentor::where('email', $email)->first();
          $checkCustomer = Customer::where('email', $email)->first();
          if (!$checkStudent && !$checkUser && !$checkMentor && !$checkCustomer) {
              $encEmail = (new SimintEncryption)->encData($email);
              $link = route('supervisor.register', [$encEmail]);
              $mentors = $this->addStaff($email);
              // $institution_detail = Institution::where('id',$institution_id)->first();
              // $nameInstitution = $institution_detail->name;
              // $InstitutionLogo = $institution_dStaffMemberInvitationetail->logo;
              $sendmail = $this->StaffMemberInvitation($mentors->email,$link);
              // dd($sendmail);
              $message .= "\n$email";
          }else{
              return redirect()->back()->with('error', 'Email is already registered');
          }
        }
        return redirect()->route('dashboard.staffs.index')->with('successTailwind', $message);
    }

    public function edit(Mentor $staff)
    {
        if(Auth::guard('web')->check()){

          $submissionNotifications = Submission::where('is_complete', 1)->whereNotIn('id', function($query) {$query->select('submission_id')->from('read_notifications')->where('type', 'submissions')->where('is_read', 1)->where('user_id', Auth::guard('web')->user()->id);})->get();
          } elseif(Auth::guard('mentor')->check()){
              $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('type','submissions')->where('mentor_id',Auth::guard('mentor')->user()->id)->get()->count();
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
              $submissionCountReadNotification = ReadNotification::where('is_read',1)->where('type','submissions')->where('customer_id',Auth::guard('customer')->user()->id)->get()->count();
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
      $totalNotificationAdmin = $submissionNotifications->count();
      return view('dashboard.staffs.edit', compact('staff'));
    }

    public function update(Request $request,Mentor $staff)
    {
      $validated = $request->validate([
        'email' => 'required|email',
        'first_name' => 'required',
        'last_name' => 'required',
    ]);

    $supervisor = Mentor::find($staff->id);
    $supervisor->email = $validated['email'];
    $supervisor->first_name = $validated['first_name'];
    $supervisor->last_name = $validated['last_name'];
    $supervisor->save();
    $message = "Successfully updated Staff Member";
    return redirect('/dashboard/staffs')->with('successTailwind', $message );
    }

    public function suspend(Mentor $staff)
    {
      $staff_count = Mentor::where('is_confirm',1)->where('institution_id', 0)->get()->count();
      if($staff_count != 1){
        if ($staff->is_confirm == 1) {
          $staff->is_confirm = 0;
          $message = "Successfully Pending Account";

          $new_staff = Mentor::inRandomOrder()
                      ->where('institution_id',0)->where('id', '!=', $staff->id)->get()->pluck('id')->toArray();
          $students = Student::where('staff_id', $staff->id)->get();
          foreach ($students as $student) {
              DB::table('students')
              ->where('id', $student->id)
              ->update(['staff_id' => $new_staff[array_rand($new_staff,1)]]);
          }
        }else{
          $staff->is_confirm = 1;
          $message = "Successfully Activate Account";
        }
        $staff->save();
        return back()->with('successTailwind', $message);
      }else{
        $message = "Cant deactivate staff member";
        return back()->with('errorTailwind', $message);
      }
    }

    public function destroy(Mentor $staff)
    {
      $staff_count = Mentor::where('is_confirm',1)->where('institution_id', 0)->get()->count();
      if($staff_count != 1){
        $new_staff = Mentor::inRandomOrder()
                        ->where('institution_id',0)
                        ->where('is_confirm',1)
                        ->where('id', '!=', $staff->id)->get()->pluck('id')->toArray();
        $students = Student::where('staff_id', $staff->id)->get();
        foreach ($students as $student) {
            DB::table('students')
            ->where('id', $student->id)
            ->update(['staff_id' => $new_staff[array_rand($new_staff,1)]]);
        }
        $staff->delete();

        $message = "Successfully Delete Account";
        return back()->with('successTailwind', $message);
      }else{
        $message = "Cant delete staff member";
        return back()->with('errorTailwind', $message);
      }
    }
}
