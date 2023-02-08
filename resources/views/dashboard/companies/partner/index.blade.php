@extends('layouts.admin2')
@section('content')
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/institutions_partners"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>

<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">{{$partner->name}} <i class="fa-solid fa-chevron-right"></i> Member</h3>
  <a href="/dashboard/partners/{{$partner->id}}/members/invite" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-plus"></i> Invite Member</a>
</div>

@include('flash-message')
<table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16">
  <thead class="text-dark-blue">
    <tr>
      <th>No</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Sex</th>
      <th>Last Login</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @php $no=1 @endphp
    @foreach($members as $member)
    {{-- @dd($project->enrolled_project) --}}
    <tr>
      <td>{{$no}}</td>
      <td>{{$member->first_name}}</td>
      <td>{{$member->last_name}}</td>
      <td>{{$member->email}}</td>
      <td>{{$member->gender}}</td>
      <td>1/1/23</td>
      <td>
        <button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover{{$no}}" data-dropdown-trigger="hover" class="text-black bg-white font-normal rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center" type="button">Option <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
        <!-- Dropdown menu -->
        <div id="dropdownHover{{$no}}" class="z-10 hidden border border-light-blue bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit Details</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Deactivate</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
              </li>
            </ul>
        </div>
      </td>
    </tr>
    @php $no++ @endphp
    @endforeach
  </tbody>
</table>
@endsection