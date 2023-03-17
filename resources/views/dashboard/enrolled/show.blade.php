@extends('layouts.admin2')
@section('content')
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/projects"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">
    {{$project->name}} <i class="fa-solid fa-chevron-right mr-2"></i> Enrollment
  </h3>
</div>

@if(Auth::guard('mentor')->check())
  @if (Auth::guard('mentor')->user()->institution_id != 0)
  <div class="flex items-center mb-2 space-x-2">
    <label for="filter" class="text-base font-normal text-black my-auto">Filter</label>
    <select id="filter" class="bg-gray-50 border border-[#aaa] text-gray-900 text-md p-1 focus:ring-blue-500 focus:border-blue-500 rounded-md">
      <option selected>All Students</option>
      <option value="supervised">My Students</option>
    </select>
  </div>
  @endif
@endif

<table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16 allStudent">
  <thead class="text-dark-blue">
    <tr>
      <th>No</th>
      <th>Student Name</th>
      <th>Mentor Name</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @php $no=1 @endphp
    @foreach($enrolled_projects as $enrolled_project)
    <tr>
      <td>{{$no}}</td>
      <td>{{$enrolled_project->student->first_name}} {{$enrolled_project->student->last_name}}</td>
      <td>{{$enrolled_project->student->mentor->first_name}} {{$enrolled_project->student->mentor->last_name}}</td>
      <td>
        @if ($enrolled_project->is_submited == 1)
          <div class="text-green-600">Complete</div>
        @else
        <div class="text-[#D89B33]">Ongoing</div>
        @endif  
      </td>
    </tr>
    @php
      $no++;
    @endphp
    @endforeach
  </tbody>
</table>

@if(Auth::guard('mentor')->check())
  @if (Auth::guard('mentor')->user()->institution_id != 0)
    <table id="dataTable2" class="bg-white rounded-xl border border-light-blue mt-16 allStudent">
      <thead class="text-dark-blue">
        <tr>
          <th>No</th>
          <th>Student Name</th>
          <th>Mentor Name</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @php $no=1 @endphp
        @foreach($enrolled_projects_supervised as $enrolled_project)
        <tr>
          <td>{{$no}}</td>
          <td>{{$enrolled_project->student->first_name}} {{$enrolled_project->student->last_name}}</td>
          <td>{{$enrolled_project->student->mentor->first_name}} {{$enrolled_project->student->mentor->last_name}}</td>

          <td>
            @if ($enrolled_project->is_submited == 1)
              <div class="text-green-600">Complete</div>
            @else
            <div class="text-[#D89B33]">Ongoing</div>
            @endif
          </td>
        </tr>
        @php
            $no++;
        @endphp
        @endforeach
      </tbody>
    </table>
  @endif
@endif
@endsection
@section('more-js')
<script>
  $(document).ready(function () {
    // console.log('tes');
    let table2 = $('#dataTable2').DataTable();
    let table1 = $('#dataTable').DataTable();
    $('#dataTable2_wrapper').hide()
    $("#filter").change(function(){
      var values = $("#filter option:selected").val();
      console.log(values);
      if(values=='supervised'){
        $('#dataTable2_wrapper').show()
        $('#dataTable_wrapper').hide();
      }else{
        $('#dataTable_wrapper').show();
        $('#dataTable2_wrapper').hide();
      }
    })
  })
</script>
@endsection