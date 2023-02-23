@extends('layouts.admin2')
@section('content')
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/institutions_partners"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>

<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">{{$institution->name}} <i class="fa-solid fa-chevron-right"></i> Students</h3>
  <a href="/dashboard/institutions/{{$institution->id}}/students/invite" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-plus"></i> Add Student</a>
</div>
@include('flash-message')
<table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16">
  <thead class="text-dark-blue">
    <tr>
      <th>No</th>
      <th>Full Name</th>
      <th>Email</th>
      <th>Institute Name</th>
      <th>Status</th>
      <th>View</th>
    </tr>
  </thead>
  <tbody>
    @php $no=1 @endphp
    @foreach($students as $student)
    <tr>
      <td>{{$no}}</td>
      <td>{{$student->first_name}} {{$student->last_name}}</td>
      <td>{{$student->email}}</td>
      <td>
        @if($student->institution)
        {{$student->institution->name}}
        @else
        Not Registered Yet
        @endif
      </td>
      <td>
        @if ($student->is_confirm == 1)
          <span class="text-green-600">Active</span>
        @elseif($student->is_confirm == 2)
          <span class="text-red-600">Suspended</span>
        @else
          <span class="text-[#D89B33]">Pending</span>
        @endif
      </td>
      <td class="text-center">
        <button class="view-details space-y-7"
                data-institution-id="{{ $institution->id }}"
                data-student-id="{{ $student->id }}"
                data-student-dob="{{ $student->date_of_birth }}"
                data-student-sex="{{ $student->sex }}"
                data-student-state="{{ $student->state }}"
                data-student-country="{{ $student->country }}"
                data-student-study_program="{{ $student->study_program }}"
                data-student-year_of_study="{{ $student->year_of_study }}"
                data-student-join="{{ $student->created_at->format('d/m/ Y') }}"
                data-student-is_confirm="{{ $student->is_confirm }}"
                data-student-start="{{ $student->created_at->format('d M Y') }}"
                data-student-btn="{{$student->is_confirm == 1 ? 'Suspend': 'Activate'}}"


        ><i class="fa-solid fa-chevron-down"></i></button>
      </td>
    </tr>
    @php $no++ @endphp
    @endforeach
  </tbody>
</table>

@endsection
@section('more-js')
<script>
  $(document).ready(function() {
    let table = $('#dataTable').DataTable({
    });
    // $('.view-details').html('<i class="fa-solid fa-chevron-down"></i>');

    $('#dataTable tbody').on('click', 'button.view-details', function() {
      let tr = $(this).closest('tr');
      let row = table.row(tr);
      let institutionId = $(this).data('institution-id');
      let studentId = $(this).data('student-id');
      let studentDob = $(this).data('student-dob');
      let studentSex = $(this).data('student-sex');
      let studentState = $(this).data('student-state');
      let studentCountry = $(this).data('student-country');
      let studentStudyProgram = $(this).data('student-study_program');
      let studentYear = $(this).data('student-year_of_study');
      let studentJoin = $(this).data('student-join');
      let studentIs_confirm = $(this).data('student-is_confirm');
      let studentStart = $(this).data('student-start');
      let textBtn = $(this).data('student-btn');
        console.log(studentIs_confirm);
      if (row.child.isShown()) {
        $(this).html('<i class="fa-solid fa-chevron-down"></i>');
        row.child.hide();

      } else {
        $(this).html('<i class="fa-solid fa-chevron-up"></i>');
        row.child.show();

        row.child(`
        <div class = "flex flex-col py-4 px-10 space-y-7 bg-[#EBEDFF] rounded-3xl">
          <div class = "flex justify-between">
            <p class="text-dark-blue font-mediun">Date Of Birth: <span class="text-black font-normal">${studentDob}</span></p>
            <p class="text-dark-blue font-mediun">Sex: <span class="text-black font-normal">${studentSex}</span></p>
            <p class="text-dark-blue font-mediun">State: <span class="text-black font-normal">${studentState}</span></p>
            <p class="text-dark-blue font-mediun">Country: <span class="text-black font-normal">${studentCountry}</span></p>
          </div>
          <div class = "flex space-x-10">
            <p class="text-dark-blue font-mediun">Study Program: <span class="text-black font-normal">${studentStudyProgram}</span></p>
            <p class="text-dark-blue font-mediun">Year Of Study: <span class="text-black font-normal">${studentYear}</span></p>
          </div>
          <div class="flex justify-between">
            <div class="flex space-x-4">
              <a href="/dashboard/institutions/${institutionId}/students/${studentId}/manage" class="bg-dark-blue px-6 py-2 text-white rounded-lg"> Edit Details</a>
              <form method="POST" action="/dashboard/institutions/${institutionId}/students/${studentId}/suspend" >
                @csrf
                <button type="submit"  class="bg-dark-yellow px-6 py-2 text-white rounded-lg">${textBtn} Account</button>
              </form>
              <form method="POST" action="/dashboard/students/${studentId}" >
                @csrf
                @method('DELETE')
                <button type="submit" onClick="return confirm('Delete this student?')" class="bg-dark-red px-6 py-2 text-white rounded-lg"> Delete Account</button>
              </form>
            </div>
            <div class="text-right">
              <p class="text-dark-blue font-mediun">Join Date: <span class="text-black font-normal">${studentJoin}</span></p>
            </div>
          </div>
        </div>
          `).show();
      }
    });
  });
</script>
@endsection
