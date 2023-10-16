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
      <th>Project History</th>
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
            @php
                $arr = $enrolled_projects->where('student_id',  $student->id);
            @endphp
            @foreach ($arr as $key=> $enrolled_project)
            {{$enrolled_project->project->name}},
            @endforeach
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
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    });
</script>
@endsection
