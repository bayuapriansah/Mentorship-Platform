<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mentor;
use App\Models\Student;
use App\Mail\MailNotify;
use App\Models\Customer;
use App\Models\Institution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SimintEncryption;

class StaffController extends Controller
{
    public function index()
    {
      $staffs = Mentor::where('institution_id',0)->get();
      return view('dashboard.staffs.index', compact('staffs'));
    }

    public function invite()
    {
      return view('dashboard.staffs.invite');
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
}
