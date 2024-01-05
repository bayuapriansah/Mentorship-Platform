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
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        return view('dashboard.staffs.index');
    }

    public function invite(Request $request)
    {
        return view('dashboard.staffs.invite', [
            'isMentor' => $request->has('is_mentor'),
        ]);
    }

    public function sendInvite(Request $request)
    {
        $isMentor = $request->has('is_mentor') && boolval($request->input('is_mentor'));

        if ($request->has('emails')) {
            $emails = explode(',', $request->input('emails'));
        } else {
            $emails = $request->input('emails_check');
        }

        $emails = array_filter($emails, function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        });

        if (count($emails) == 0) {
            toastr()->error('Please enter valid emails', '', ['timeOut' => 10000]);
            return redirect()->back()->withInput();
        }

        $countInvited = 0;

        DB::transaction(function () use ($emails, $isMentor, &$countInvited) {
            $institution_id = 0;

            if ($isMentor) {
                $institution_id = Institution::orderBy('id')->first()->id;
            }

            foreach ($emails as $email) {
                $checkStudent = Student::where('email', $email)->first();
                $checkUser = User::where('email', $email)->first();
                $checkMentor = Mentor::where('email', $email)->first();
                $checkCustomer = Customer::where('email', $email)->first();

                if (!$checkStudent && !$checkUser && !$checkMentor && !$checkCustomer) {
                    Mentor::create([
                        'email' => $email,
                        'is_confirm' => 0,
                        'institution_id' => $institution_id,
                    ]);

                    $encEmail = (new SimintEncryption)->encData($email);
                    $link = route('supervisor.register', [$encEmail]);
                    (new MailController)->EmailStaffInvitation($email, $link);

                    $countInvited++;
                }
            }
        });

        $target = $isMentor ? 'Mentor' : 'Staff';
        toastr()->success($countInvited . ' ' . $target .'(s) invited successfully');

        return redirect()->route('dashboard.staffs.index');
    }

    public function edit(Mentor $staff)
    {
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

        if ($request->has('password') && $request->input('password') !== '') {
            $supervisor->password = Hash::make($request->input('password'));
        }

        $supervisor->save();

        toastr()->success('Data updated successfully');

        return redirect('/dashboard/staffs');
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

        toastr()->success($message);

        return back();
      }else{
        $message = "Cant deactivate staff member";

        toastr()->error($message);

        return back();
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

        toastr()->success($message);

        return back();
      }else{
        $message = "Cant delete staff member";

        toastr()->error($message);

        return back();
      }
    }
}
