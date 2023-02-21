@extends('layouts.admin2')
@section('content')

@if (Route::is('dashboard.partner.partnerProjects'))
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/institutions_partners"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>
@endif

@if (Route::is('dashboard.partner.partnerProjects'))
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">{{$partner->name}} <i class="fa-solid fa-chevron-right"></i> Projects</h3>
  <a href="/dashboard/partners/{{$partner->id}}/projects/create" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-plus"></i> Add Project</a>
</div>
@else
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Projects</h3>
  <a href="/dashboard/projects/create" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-plus"></i> Add Project</a>
</div>
@endif
<!-- Content Row -->

@include('flash-message')
<table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16">
  <thead class="text-dark-blue">
    <tr>
      <th>No</th>
      <th>Project name</th>
      <th>Project domain</th>
      <th>Total Enrollment</th>
      <th>Added On</th>
      <th>Status</th>
      <th>Submissions</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @php $no=1 @endphp
    @foreach($projects as $project)
    {{-- @dd($project->enrolled_project) --}}
    <tr>
      <td>{{$no}}</td>
      <td>{{$project->name}} {{$project->institution_id == null ?'(Public)':'(Private)'}}</td>
      <td>{{$project->project_domain}}</td>
      <td>{{count($project->enrolled_project)}}</td>
      <td class="text-[#6672D3]">{{$project->created_at->format('d/m/Y')}}</td>
      <td class="capitalize">
        @if ($project->status == 'publish')
          <span class="text-green-600 ">{{$project->status}}</span>
        @else
          <span class="text-[#D89B33] ">{{$project->status}}</span>
        @endif
      </td>
      <td>
        <a href="/dashboard/submissions/project/{{$project->id}}" class="py-1 px-3 bg-dark-blue hover:bg-darker-blue rounded-md text-white">Submissions</a>
      </td>
      <td>
        <button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover{{$no}}" data-dropdown-trigger="hover" class="text-black bg-white font-normal rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center" type="button">Option <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
        <!-- Dropdown menu -->
        <div id="dropdownHover{{$no}}" class="z-10 hidden border border-light-blue bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton">
              <li>
                @if (Route::is('dashboard.partner.partnerProjects'))
                  <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/edit" class="block px-4 py-2 hover:bg-gray-100">Edit Details</a>
                @else
                  @if(Auth::guard('web')->check())
                    <a href="/dashboard/projects/{{$project->id}}/edit" class="block px-4 py-2 hover:bg-gray-100">Edit Details</a>
                  @elseif(Auth::guard('mentor')->check())
                    @if($project->status == 'proposed')
                      <a href="/dashboard/projects/{{$project->id}}/edit" class="block px-4 py-2 hover:bg-gray-100">Edit Details</a>
                    @endif
                  @endif
                @endif
              </li>
              @if (Auth::guard('web')->check())
                <li>
                  @if (Route::is('dashboard.partner.partnerProjects'))
                  <form action="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/publishDraft" method="post">
                  @else
                  <form action="/dashboard/projects/{{$project->id}}/publishDraft" method="post">
                  @endif
                    @method('patch')
                    @csrf
                    @if ($project->status == 'publish')
                      <input type="submit" class="w-full text-left cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" value="Draft">
                    @else
                      <input type="submit" class="w-full text-left cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" value="Publish">
                    @endif
                  </form>
                </li>
              
                <li>
                  @if (Route::is('dashboard.partner.partnerProjects'))
                  <form action="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}" method="post">
                  @else
                  <form action="/dashboard/projects/{{$project->id}}" method="post">
                  @endif
                    @method('delete')
                    @csrf
                    <input type="submit" class="w-full text-left cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" value="Delete">
                  </form>
                </li>
              @elseif(Auth::guard('mentor')->check())
                <a href="/dashboard/projects/{{$project->id}}/show" class="block px-4 py-2 hover:bg-gray-100">View Details</a>
                
              @endif

            </ul>
        </div>
        {{-- <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/projects/{{$project->id}}/edit" >Edit</a>
        <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/projects/{{$project->id}}/section" >Manage Task</a>

        <form method="POST" action="/dashboard/projects/{{ $project->id }}" >
          @csrf
          @method('DELETE')
          <div class="control">
          <button type="submit" class="btn btn-danger ms-2" onClick="return confirm('Delete this project?')">Delete</button>
        </form>

        @if($project->status == 'draft')
        <form method="POST" action="/dashboard/projects/{{ $project->id }}/publish" >
          @csrf
          @method('PATCH')
          <div class="control">
          <button type="submit" class="btn btn-success ms-2" onClick="return confirm('Publish this project??')">Publish</button>
        </form>
        @endif --}}
      </td>
    </tr>
    @php $no++ @endphp
    @endforeach
  </tbody>
</table>
<div class="mt-12"></div>

@endsection
@section('more-js')

@endsection
