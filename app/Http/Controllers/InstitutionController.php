<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Student;
use App\Models\Institution;
use App\Models\Submission;
use App\Models\ReadNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\EnrolledProject;
use Illuminate\Support\Facades\Storage;
use App\Models\institution_world_data_view;;

class InstitutionController extends Controller
{
    public function GetInstituionData()
    {
        $GetInstitutionData = institution_world_data_view::get();
        return $GetInstitutionData;
    }

    public function GetInstituionById($id)
    {
        $GetInstitution = institution_world_data_view::where('id',$id)->first();
        return $GetInstitution;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function institutions_partners()
    {
        $institutions = institution_world_data_view::get();
        $companies = Company::get();
        return view('dashboard.institutions.index', compact('institutions', 'companies'));
    }
    public function index()
    {
        $institutions = institution_world_data_view::get();
        $companies = Company::get();
        return view('dashboard.institutions.index', compact('institutions', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = (new TheWorldController)->TheWorld();
        return view('dashboard.institutions.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'countries' => ['required'],
            'state' => ['required'],
            'logo' => ['required'],
            'email'=>['required']
        ]);

        $institutions = new Institution;
        $institutions->name = $validated['name'];
        $institutions->email = $validated['email'];
        $institutions->country = $validated['countries'];
        $institutions->state = $validated['state'];
        if($request->hasFile('logo')){
            // 5000000
            if( $request->file('logo')->extension() =='png' && $request->file('logo')->getSize() <=5000000 ||
                $request->file('logo')->extension() =='jpg' && $request->file('logo')->getSize() <=5000000 ||
                $request->file('logo')->extension() =='jpeg' && $request->file('logo')->getSize() <=5000000
                ){
                $logo = Storage::disk('public')->put('institutions', $validated['logo']);
                $institutions->logo = $logo;
            } else {
                toastr()->error('file extension is not png, jpg or jpeg. Or image size is too large');

                return redirect('dashboard/institutions_partners/');
            }

        }
        $institutions->save();
        $message = "Successfully Created Institution Data";

        toastr()->success($message);

        return redirect()->route('dashboard.institutions_partners');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $institutions = Institution::where('id',$id)->first();
        $institutions_view = institution_world_data_view::where('id',$id)->first();
        $countries = (new TheWorldController)->TheWorld();
        return view('dashboard.institutions.edit', compact('institutions','institutions_view','id','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'countries' => 'required',
            'state' => 'required',
        ]);
        $institutions = Institution::where('id',$id)->first();
        $institutions->name = $validated['name'];
        $institutions->country = $validated['countries'];
        $institutions->state = $validated['state'];
        $institutions->email = $validated['email'];
        if($request->hasFile('logo')){

            if(Storage::path($institutions->logo)) {
                Storage::disk('public')->delete($institutions->logo);
            }

            // save the new image
             if( $request->file('logo')->extension() =='png' && $request->file('logo')->getSize() <=5000000 ||
                $request->file('logo')->extension() =='jpg' && $request->file('logo')->getSize() <=5000000 ||
                $request->file('logo')->extension() =='jpeg' && $request->file('logo')->getSize() <=5000000
                ){
                $logo = Storage::disk('public')->put('institutions', $request->logo);
                $institutions->logo = $logo;
            } else {
                toastr()->error('file extension is not png, jpg or jpeg. Or image size is too large');

                return redirect('dashboard/institutions_partners/');
            }
        }
        if($request->hasFile('template_cert')){

            // dd($request->template_cert);
            if($institutions->template_cert && Storage::exists($institutions->template_cert)) {
                Storage::disk('public')->delete($institutions->template_cert);
            }

            // save the new image
             if( $request->file('template_cert')->extension() =='pdf' && $request->file('template_cert')->getSize() <=5000000){
                $template_cert = Storage::disk('public')->put('institutions/template', $request->template_cert);
                $institutions->template_cert = $template_cert;
            } else {
                toastr()->error('file extension is pdf or template size is too large');

                return redirect('dashboard/institutions_partners/');
            }
        }
        $institutions->save();
        $message = "Successfully Edited Institution Data";

        toastr()->success($message);

        return redirect()->route('dashboard.institutions_partners');
    }

    public function institutionStudents(Institution $institution)
    {
        $students = Student::where('institution_id', $institution->id)->get();
        $enrolled_projects = EnrolledProject::get();
        return view('dashboard.institutions.students.index', compact('students', 'institution', 'enrolled_projects'));
    }


    public function suspendInstitution($id)
    {
        $institution = Institution::find($id);
        // $students = Student::where('institution_id',$id)->get();
        // dd($students->is_confirm);
        if($institution->status==1){
            $institution->status = 0;
            $message = "Successfully Deactive Institution";
            Student::where('institution_id',$id)->where('is_confirm',1)->update(['is_confirm' => 2]);
        }else{
            $institution->status = 1;
            $message = "Successfully Activate Institution";
            Student::where('institution_id',$id)->where('is_confirm',2)->update(['is_confirm' => 1]);

        }
        $institution->save();

        toastr()->success($message);

        return redirect()->route('dashboard.institutions_partners');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institution = Institution::find($id);
        $institution->delete();
        $message = "Successfully Delete Institution";

        toastr()->success($message);

        return redirect('dashboard/institutions');
    }
}
