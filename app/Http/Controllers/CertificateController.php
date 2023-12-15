<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
      $students = Student::get();
      return view('dashboard.certificate.index', compact('students'));
    }

    public function edit(Student $student)
    {
      return view('dashboard.certificate.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
      // dd($request->all());
      $student = Student::find($student->id);
      if($request->hasFile('certificate')){
        if($student->certificate == null){
            if( $request->file('certificate')->extension() =='pdf' && $request->file('certificate')->getSize() <=5000000
            ){
                $certificate = Storage::disk('public')->put('students/'.$student->id.'/certificate', $request->file('certificate'));
                $student->certificate = $certificate;
            }else{
                toastr()->error('file extension is not pdf');

                return back();
            }
        }

        // save the new image
        if( $request->file('certificate')->extension() =='pdf' && $request->file('certificate')->getSize() <=5000000){
            if(Storage::path($student->certificate)) {
                Storage::disk('public')->delete($student->certificate);
            }
            $certificate = Storage::disk('public')->put('students/'.$student->id.'/certificate', $request->file('certificate'));
            $student->certificate = $certificate;
        }else{
            toastr()->error('file extension is not pdf');

            return back();
        }
      }

      $student->save();

      toastr()->success('Profile updated successfully');

      return redirect('/dashboard/certificate');
    }
}
