@extends('layouts.admin2')
@section('content')
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/institutions_partners"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>

<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">{{$institution->name}} <i class="fa-solid fa-chevron-right"></i> Students</h3>
  <a href="/dashboard/institutions/{{$institution->id}}/students/invite" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-plus"></i> Add Student</a>
</div>

<table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16">
  <thead class="text-dark-blue">
    <tr>
      <th>No</th>
      <th>Full Name</th>
      <th>Email</th>
      <th>Institute Name</th>
      <th>Supervisor Name</th>
      <th>Staff Name</th>
      <th>Account Status</th>
      <th>Internship Status</th>
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
          @if($student->mentor)
            {{$student->mentor->first_name}} {{$student->mentor->last_name}}
          @else
            Student not completed the registration yet
          @endif
        </td>
        <td>
          @if($student->staff)
            {{$student->staff->first_name}} {{$student->staff->last_name}}
          @else
            Student not completed the registration yet
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
        <td>
          @if($student->end_date)
            @php
                $completed_months = \App\Models\Project::whereHas('enrolled_project', function($q){
                  $q->where('is_submited',1);
                })->get();
                $totalMonth = $completed_months->map(function ($item) {
                  return $item['period'] ;
                });
            @endphp
            @if($total = $totalMonth->sum()==3 && \Carbon\Carbon::now() > $student->end_date)
              <span class="text-green-600">Finished</span>
            @elseif($total = $totalMonth->sum()<3 && \Carbon\Carbon::now()->format('Y-m-d') > $student->end_date)
              <span class="text-red-600">Incomplete</span>
            @else
              <span class="text-[#D89B33]">Ongoing</span>
            @endif
          @else
          Student not completed the registration yet
          @endif
        </td>
        <td class="text-center">
          @php
              // $collection = collect(['name' => 'Desk', 'price' => 200]);
              $collection = collect([['name' => 'Desk', 'price' => 200], ['name' => 'Desk', 'price' => 200]]);
              $dataDate = App\Http\Controllers\SimintEncryption::daytimeline($student->created_at,$student->end_date);
          @endphp
          <button class="view-details space-y-7"
                  data-student-id="{{ $student->id }}"
                  data-student-dob="{{ $student->date_of_birth }}"
                  data-student-sex="{{ $student->sex }}"
                  data-student-state="{{ $student->state }}"
                  data-student-country="{{ $student->country }}"
                  data-student-study_program="{{ $student->study_program }}"
                  data-student-year_of_study="{{ $student->year_of_study }}"
                  data-student-join="{{ $student->created_at->format('d/m/ Y') }}"
                  data-student-is_confirm="{{ $student->is_confirm }}"
                  data-student-start="{{ $student->created_at->format('d-M-Y') }}"
                  data-student-btn="{{$student->is_confirm == 1 ? 'Deactive': 'Activate'}}"
                  data-student-text="{{$student->is_confirm == 1 ? 'Internship Timeline': 'Student not completed the registration yet'}}"
                  data-student-instution-id = {{ $student->institution->id }}
                  data-student-end_date = {{date_format(new DateTime($student->end_date), "d-M-Y")}}
                  data-timeline="{{$collection->toJson()}}"
                  data-date="{{$dataDate >=100 ? 100: $dataDate}}"
                  data-flag = "@php
                                $tipNumber = 1 ;
                                $arr = $enrolled_projects->where('is_submited',1)->where('student_id',  $student->id);
                              @endphp
                              @foreach ($arr as $key=> $enrolled_project)
                              <p class='absolute -top-5 font-medium text-left flex-wrap text-[10px] overflow-hidden whitespace-nowrap' style='margin-left: {{$enrolled_project->flag_checkpoint>=90?'90':$enrolled_project->flag_checkpoint- 4}}%'>
                                {{substr($enrolled_project->project->name,0,15)}}{{strlen($enrolled_project->project->name) >=15?"...":''}}
                              </p>
                              <img src='{{asset('assets/img/icon/flag.png')}}' class='absolute top-0' style='margin-left: {{$enrolled_project->flag_checkpoint>=90?'99':$enrolled_project->flag_checkpoint}}%'>
                              @php $tipNumber++ @endphp
                              @endforeach"
                  data-info = "@php $num = 1 @endphp
                              @foreach ($enrolled_projects->where('is_submited',1)->where('student_id',  $student->id) as $enrolled_project)
                              <p class='absolute font-medium text-left flex-wrap overflow-hidden whitespace-nowrap text-[8px]' style='margin-left: {{$enrolled_project->flag_checkpoint>=90?100-6:$enrolled_project->flag_checkpoint-2}}%'>{{Carbon\Carbon::parse($enrolled_project->updated_at)->format('d M Y')}}</p>
                              <p class='absolute mt-3 font-medium text-left text-[10px]' style='margin-left: {{$enrolled_project->flag_checkpoint>=90?99-4:$enrolled_project->flag_checkpoint-2}}%'>Project {{$num}}</p>
                              @php $num++ @endphp
                              @endforeach
                              "
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
      // SuspendActiveBtn
      // $('.view-details').html('<i class="fa-solid fa-chevron-down"></i>');

      $('#dataTable tbody').on('click', 'button.view-details', function() {
        let tr = $(this).closest('tr');
        let row = table.row(tr);
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
        let studentBtn = $(this).data('student-btn');
        let studentText = $(this).data('student-text');
        let studentInstitutionId = $(this).data('student-instution-id')
        let studentEnd = $(this).data('student-end_date')
        let timeline = $(this).data('timeline');
        let dataDate = $(this).data('date');
        let dataFlag = $(this).data('flag');
        let dataInfo = $(this).data('info');
        console.log(studentEnd);
        // if(studentIs_confirm == 1){
          // $('#BitTitle').html('activate');
        //   $('#SuspendActiveBtn').html('tes');
        // }
          console.log(studentIs_confirm);
        if (row.child.isShown()) {
          $(this).html('<i class="fa-solid fa-chevron-down"></i>');
          row.child.hide();

        } else {
          $(this).html('<i class="fa-solid fa-chevron-up"></i>');
          row.child.show();
          let rowData = `
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
            <div class="border border-light-blue rounded-xl px-3 py-8 text-center bg-white">
              <p class="text-black text-xs font-normal mb-4">${studentText}</p>
              <div class="flex justify-between">
                <p class="text-black text-xs ">${studentStart}</p>
                <div class="w-full relative ">
                  ${dataFlag}
                  <div class="bg-gray-200 rounded-full h-1.5 mt-4 ">
                    <div class="bg-[#11BF61] h-1.5 rounded-full " style="width:${dataDate}%"></div>
                  </div>
                  ${dataInfo}
                </div>
                <p class="text-black text-xs ">${studentEnd}</p>
              </div>
            </div>
            <div class="flex justify-between">
              <div class="flex space-x-4">
                <a href="/dashboard/students/${studentId}/manage" class="bg-dark-blue px-6 py-2 text-white rounded-lg"> Edit Details</a>
                <form method="POST" action="/dashboard/students/${studentId}/suspend" >
                  @csrf
                  <input type="hidden" name="institution" value="${studentInstitutionId}">
                  <button type="submit"  class="bg-dark-yellow px-6 py-2 text-white rounded-lg" id='SuspendActiveBtn'>${studentBtn} Account</button>
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
          `;

          row.child(rowData).show();
        }
      });
    });
</script>
@endsection
