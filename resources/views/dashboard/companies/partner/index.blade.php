@extends('layouts.admin2')
@section('content')
<div class="min-h-screen">
  @if(!Auth::guard('customer')->check())
  <div class="text-[#6973C6] hover:text-light-blue">
    <a href="/dashboard/institutions_partners"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
  </div>
  @endif

  @if(Auth::guard('customer')->check())
  <div class="flex justify-between mb-10">
    <h3 class="text-dark-blue font-medium text-xl">{{Auth::guard('customer')->user()->company->name}} <i class="fa-solid fa-chevron-right"></i> Customers</h3>
    <a href="/dashboard/customers/invite" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-plus"></i>Invite Customer</a>
  </div>
  @else

  <div class="flex justify-between mb-10">
    <h3 class="text-dark-blue font-medium text-xl">{{$partner->name}} <i class="fa-solid fa-chevron-right"></i> Member</h3>
    <a href="/dashboard/partners/{{$partner->id}}/members/invite" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-plus"></i> Invite member</a>
  </div>
  @endif

  @include('flash-message')
  <table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16">
    <thead class="text-dark-blue">
      <tr>
        <th>No</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Email</th>
        <th>Status</th>
        @if(!Auth::guard('customer')->check())
        <th>View</th>
        @endif
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
        <td>
          @if ($member->is_confirm == 1)
            <span class="text-green-600">Active</span>
          @elseif($member->is_confirm == 2)
            <span class="text-red-600">Suspended</span>
          @else
            <span class="text-[#D89B33]">Pending</span>
          @endif
        </td>
        @if(!Auth::guard('customer')->check())
          <td>
            <div class="dropdown inline-block relative">

              <button id="dropdownHoverButton" class="text-black bg-white font-normal rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center" type="button">Option <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
              <!-- Dropdown menu -->
              <div class="z-10 dropdown-menu absolute hidden border border-light-blue bg-white divide-y divide-gray-100 rounded-lg shadow w-44" >
                  <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                    <li>
                      <a href="/dashboard/partners/{{$partner->id}}/members/{{$member->id}}/edit" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit Details</a>
                    </li>
                    <li>
                      <a href="/dashboard/partners/{{$partner->id}}/members/{{$member->id}}/suspend" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        @if($member->is_confirm == 1)
                        Deactivate
                        @else
                        Activate
                        @endif
                      </a>
                    </li>
                    <li>
                      <form action="/dashboard/partners/{{$partner->id}}/members/{{$member->id}}" method="post">
                        @method('delete')
                        @csrf
                        <input type="submit" onClick="return confirm('Delete this member?')" class="w-full text-left cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" value="Delete">
                      </form>
                    </li>
                  </ul>
              </div>
            </div>
          </td>
        @endif
      </tr>
      @php $no++ @endphp
      @endforeach
    </tbody>
  </table>
</div>
@endsection