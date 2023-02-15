<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function indexPartner(Company $partner)
    {
        $members = Customer::where('company_id', $partner->id)->get();
        return view('dashboard.companies.partner.index', compact('members','partner'));
    }

    public function invite(Company $partner)
    {
        return view('dashboard.companies.partner.invite', compact('partner'));
    }

    public function sendInvitePartner(Request $request,$partner_id)
    {
        $message = "Successfully Send Invitation to Student";
        foreach (array_filter($request->email) as $email) {
            $checkCustomer = Customer::where('email', $email)->first();
            if(!$checkCustomer){
                $encEmail = (new SimintEncryption)->encData($email);
                $link = route('mentor.register', [$encEmail]);
                $student = $this->addCustomerToPartner($email,$partner_id);
                $sendmail = (new MailController)->EmailMemberInvitation($student->email,$link);
                $message .= "\n$email";
            }
            // else{
            //     return redirect()->back()->with('error', 'Email already invited');
            // }
        }

        return redirect()->route('dashboard.partner.partnerMember', [$partner_id])->with('success', $message);
    }

    // Register customer
    public function register($email)
    {
        $emails = (new SimintEncryption)->decData($email);
        $checkCustomer = Customer::where('email', $emails)->where('is_confirm',0)->first();
        if(!$checkCustomer){
            return redirect()->route('index');
        }elseif($checkCustomer){
            $GetInstituionData = (new InstitutionController)->GetInstituionData();
            return view('customer.index', compact(['checkCustomer','GetInstituionData','email']));
        }
    }

    public function completedRegister(Request $request, $email)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'company' => 'required',
            'password' => 'required|confirmed|min:8|',
            'g-recaptcha-response' => 'required|recaptcha',
            'tnc' => 'required',
        ]);

        $validated = $validator->validated();
        $emails = (new SimintEncryption)->decData($email);
        if($validated){
            $company = Customer::where('email',$emails)->first();
            $company->email = $validated['email'];
            $company->first_name = $validated['first_name'];
            $company->last_name = $validated['last_name'];
            $company->sex = $validated['sex'];
            $company->company_id = $validated['company'];
            $company->is_confirm = 1;
            $compPwd = $validated['password'];
            $compPwdhash = Hash::make($compPwd) ;
            $company->password = $compPwdhash;
            if (!Hash::check($compPwd, $compPwdhash)) {
                return redirect()->back();
            }
            $company->save();
            $sendmail = (new MailController)->EmailMemberRegister($company->email);
            $message = "Successfully Register as Customer, Now you can login to your account";
            return redirect()->route('login')->with('success', $message);
        }else{
            return redirect()->back();
        }
    }

    public function addCustomerToPartner($email,$partner_id){
        $customer = Customer::create([
            'email' => $email,
            'company_id' => $partner_id,
            'is_confirm' => 0
        ]);

        return $customer;
    }
}
