@extends('layouts.admin2')
@section('content')
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">All Messages</h3>
  <a href="/dashboard/messages/create" class="text-xl text-dark-blue"><i class="fa-solid fa-envelope"></i> New Message</a>
</div>

<table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16">
  <thead class="text-dark-blue">
    <tr>
      <th>No</th>
      <th>Project name</th>
      <th>Project domain</th>
      <th>Task Name</th>
      <th>Messages</th>
    </tr>
  </thead>
  <tbody>
    @php $no=1 @endphp
    @foreach ($injections as $injection)
    <tr>
      <td>{{$no}}</td>
      <td>{{$injection->project->name}}</td>
      <td>{{$injection->project->project_domain}}</td>
      <td>{{substr($injection->title,0,35)}} {{strlen($injection->title)>=35?"...":''}}</td>
      <td>
        <a href="/dashboard/messages/{{$injection->id}}" class="py-1 px-3 bg-dark-blue hover:bg-darker-blue rounded-md text-white">Message
        <span class="bg-[#EA0202] p-1 rounded-full">
          {{$messages->where('project_section_id', $injection->id)->count()}}
        </span>
        <i class="fa-xs fa-solid fa-chevron-right"></i>
      </a>
      </td>
    </tr>
    @php $no++ @endphp
    @endforeach
  </tbody>
  {{-- @foreach ($messages as $message)
    <tr>
      <td>{{$no}}</td>
      <td>{{$message->project->name}}</td>
      <td>{{$message->project->project_domain}}</td>
      <td>{{$message->project_section->title}}</td>
      <td>5</td>
    </tr>
    @php $no++ @endphp
    @endforeach
  </tbody> --}}
</table>

@endsection
