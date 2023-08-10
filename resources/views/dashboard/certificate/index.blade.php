@extends('layouts.admin2')
@section('content')
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Certificate </h3>
</div>
<div class="mt-3">
  @include('flash-message')
</div>
<table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16">
  <thead class="text-dark-blue">
    <tr>
      <th>No</th>
      <th>Full Name</th>
      <th>Email</th>
      <th>Institute Name</th>
      <th>Supervisor Name</th>
      <th>Status</th>
      <th>Certificate</th>
      <th>Actions</th>
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
          @if ($student->is_confirm == 1)
            <span class="text-green-600">Active</span>
          @elseif($student->is_confirm == 2)
            <span class="text-red-600">Suspended</span>
          @else
            <span class="text-[#D89B33]">Pending</span>
          @endif
        </td>
        <td class="">
          @if ($student->certificate)
            <a href="{{asset('storage/'.$student->certificate)}}" target="_blank" class="flex items-center text-dark-blue ">Certificate</a>
          @else
            Certificate is not uploaded yet
          @endif
        </td>
        <td class="text-center whitespace-nowrap">
          <a href="/dashboard/certificate/add/{{$student->id}}" class="px-5 pb-2 py-2 rounded-lg text-white bg-darker-blue hover:bg-dark-blue">Add Certificate</a>
        </td>
      
    </tr>
    @php $no++ @endphp
    @endforeach
  </tbody>
</table>
@endsection