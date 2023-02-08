<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;

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
        $checkCustomer = Customer::where('email', $request->email)->first();  
        if(!$checkCustomer){
            $link = route('student.register', [$request->email]);
            $student = $this->addCustomerToPartner($request,$partner_id);
            $sendmail = (new MailController)->EmailMentorInvitation($student->email,$link);
            $message = "Successfully Send Invitation to Members";
            return redirect('/dashboard/partners/'.$partner_id.'/members')->with('success', $message);
        }
    }

    public function addCustomerToPartner($request,$partner_id){
        $customer = new Customer;
        $customer->email = $request->email;
        $customer->company_id = $partner_id;
        $customer->is_confirm = 0;
        $customer->save();

        return $customer;
    }
}
