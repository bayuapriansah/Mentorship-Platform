@extends('layouts.admin2')
@section('content')
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/messages"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>

<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">{{substr($injection->title,0,35)}}{{strlen($injection->title) >=35?"...":''}} <i class="fa-solid fa-chevron-right"></i> Messages</h3>
  <a href="/dashboard/messages/create" class="text-xl text-dark-blue"><i class="fa-solid fa-envelope"></i> New Message</a>
</div>

<table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16">
  <thead class="text-dark-blue">
    <tr>
      <td>No</td>
      <td>Student Name</td>
      <td>Participant</td>
      <td>Unread Message</td>
      <td>View</td>
    </tr>
  </thead>
  <tbody>
    @php $no=1 @endphp
    @foreach ($participants as $participant)
    {{-- @dd($injection->project) --}}
    <tr>
      <td>{{$no}}</td>
      <td>{{$participant->first_name}} {{$participant->last_name}}</td>
      <td>
        {{$participant->mentor->first_name}} {{$participant->mentor->last_name}};
        @foreach ($customer_participants as $customer)
            {{$customer->first_name}} {{$customer->last_name}};
        @endforeach
      </td>
      <td>{{$comments->where('student_id', $participant->id)->count()}}</td>
      <td>
        <a href="/dashboard/messages/{{$injection->id}}/single/{{$participant->id}}" class="py-1 px-3 bg-dark-blue hover:bg-darker-blue rounded-md text-white">View Message 
          <i class="fa-xs fa-solid fa-chevron-right"></i>
      </td>
    </tr>
    @php $no++ @endphp
    @endforeach
  </tbody>
</table>
@endsection