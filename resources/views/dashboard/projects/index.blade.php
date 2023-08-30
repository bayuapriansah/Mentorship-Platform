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
    <a href="/dashboard/projects/create" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-plus"></i> 
      @if(Auth::guard('mentor')->check() || Auth::guard('customer')->check())
        Submit Project Proposal
      @else
        Add Project
      @endif
    </a>
  </div>
@endif
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
<!-- Content Row -->

@include('flash-message')
{{-- allStudent Table --}}
<table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16 allStudent">
  <thead class="text-dark-blue">
    <tr>
      <th class="font-normal">No</th>
      <th>Project name</th>
      <th>Project domain</th>
      <th>Total enrollment</th>
      <th>Added on</th>
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
      <td>{{$project->name}}
        @if (Auth::guard('customer')->check())
          @if ($project->institution_id==null)
            (Public)
          @else
            (Private to {{$project->institution->name}})
          @endif
        @else
          @if ($project->institution_id==null)
            (Public)
          @else
            (Private to {{$project->institution->name}})
          @endif
        @endif
      </td>
      <td>{{$project->project_domain}}</td>
      <td class="text-center">
        @if (Auth::guard('mentor')->check())
          @php
              $count = 0
          @endphp
          @foreach ($project->enrolled_project as $item)
              @php
                if (Auth::guard('mentor')->user()->institution_id) {
                  $sum = $item->student->institution_id == Auth::guard('mentor')->user()->institution_id;
                }else{
                  $sum = $item->student->staff_id == Auth::guard('mentor')->user()->id;
                }
                if ($sum == 1) {
                  $count++;
                }
              @endphp
          @endforeach
          <a href="/dashboard/enrollment/project/{{encData($project->id)}}" class="py-1 px-8 bg-dark-blue hover:bg-darker-blue rounded-md text-white">{{$count}}</a>
        @else
          <a href="/dashboard/enrollment/project/{{encData($project->id)}}" class="py-1 px-8 bg-dark-blue hover:bg-darker-blue rounded-md text-white ">{{count($project->enrolled_project)}}</a>
        @endif
      </td>
      <td class="text-[#6672D3]">{{$project->created_at->format('d/m/Y')}}</td>
      <td class="capitalize">
        @if ($project->status == 'publish')
          <span class="text-green-600 ">{{$project->status}}</span>
        @elseif($project->status == 'draft')
          <span class="text-[#D89B33] ">{{$project->status}}</span>
        @elseif($project->status == 'private_project')
          <span class="text-blue-700">{{$project->status}}</span>
        @endif
      </td>
      <td>
        <a href="/dashboard/submissions/project/{{$project->id}}" class="py-1 px-3 bg-dark-blue hover:bg-darker-blue rounded-md text-white">Submissions</a>
      </td>
      <td>
        <div class="dropdown inline-block relative">
          <button id="dropdownHoverButton" class="inline-flex text-black bg-white font-normal rounded-lg text-sm px-4 py-2.5 text-center items-center" type="button">Option <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>
        <!-- Dropdown menu -->
          <div class="z-10 dropdown-menu absolute hidden border border-light-blue bg-white divide-y divide-gray-100 rounded-lg shadow w-44" style="transform: translate(-30px, 0px);">
              <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton">
                <li>
                  @if (Route::is('dashboard.partner.partnerProjects'))
                    <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/edit" class="block px-4 py-2 hover:bg-gray-100">Edit Details</a>
                  @else
                    @if(Auth::guard('web')->check())
                      <a href="/dashboard/projects/{{$project->id}}/edit" class="block px-4 py-2 hover:bg-gray-100">Edit Details</a>
                    @elseif(Auth::guard('mentor')->check() || Auth::guard('customer')->check() )
                      @if($project->status == 'draft')
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
                      <input type="submit" class="w-full text-left cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="return confirm('Delete this project?')" value="Delete">
                    </form>
                  </li>
                @elseif(Auth::guard('mentor')->check() || Auth::guard('customer')->check())
                  <a href="/dashboard/projects/{{$project->id}}/show" class="block px-4 py-2 hover:bg-gray-100">View Details</a>
                @endif
              </ul>
          </div>
        </div>
      </td>
    </tr>
    @php $no++ @endphp
    @endforeach
  </tbody>
</table>
@if(Auth::guard('mentor')->check())
{{-- supervisedStudent Table --}}
<table id="dataTable2" class="bg-white rounded-xl border border-light-blue mt-16 supervisedStudent">
  <thead class="text-dark-blue">
    <tr>
      <th>No</th>
      <th>Project name</th>
      <th>Project domain</th>
      <th>Total enrollment</th>
      <th>Added on</th>
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
      <td>{{$project->name}}
        @if (Auth::guard('customer')->check())
          @if ($project->institution_id==null)
            (Public)
          @else
            (Private to {{$project->institution->name}})
          @endif
        @else
          @if ($project->institution_id==null)
            (Public)
          @else
            (Private to {{$project->institution->name}})
          @endif
        @endif
      </td>
      <td>{{$project->project_domain}}</td>
      <td class="text-center">
        @php
              $count = 0
          @endphp
          @foreach ($project->enrolled_project as $item)
              @php
                $sum = $item->student->mentor_id == Auth::guard('mentor')->user()->id;
                if ($sum == 1) {
                  $count++;
                }
              @endphp
          @endforeach
          <a href="/dashboard/enrollment/project/{{encData($project->id)}}" class="py-1 px-8 bg-dark-blue hover:bg-darker-blue rounded-md text-white">{{$count}}</a>  
      </td>
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
        <div class="dropdown inline-block relative">
          <button id="dropdownHoverButton" class="inline-flex text-black bg-white font-normal rounded-lg text-sm px-4 py-2.5 text-center items-center" type="button">Option <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>
        <!-- Dropdown menu -->
          <div class="z-10 dropdown-menu absolute hidden border border-light-blue bg-white divide-y divide-gray-100 rounded-lg shadow w-44" style="transform: translate(-30px, 0px);">
              <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton">
                <li>
                  @if (Route::is('dashboard.partner.partnerProjects'))
                    <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/edit" class="block px-4 py-2 hover:bg-gray-100">Edit Details</a>
                  @else
                    @if(Auth::guard('web')->check())
                      <a href="/dashboard/projects/{{$project->id}}/edit" class="block px-4 py-2 hover:bg-gray-100">Edit Details</a>
                    @elseif(Auth::guard('mentor')->check() || Auth::guard('customer')->check() )
                      @if($project->status == 'draft')
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
                      <input type="submit" class="w-full text-left cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="return confirm('Delete this project?')" value="Delete">
                    </form>
                  </li>
                @elseif(Auth::guard('mentor')->check() || Auth::guard('customer')->check())
                  <a href="/dashboard/projects/{{$project->id}}/show" class="block px-4 py-2 hover:bg-gray-100">View Details</a>
                @endif
              </ul>
          </div>
        </div>
      </td>
    </tr>
    @php $no++ @endphp
    @endforeach
  </tbody>
</table>
@endif
<div class="mt-12"></div>
<div class="p-10">
</div>
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
