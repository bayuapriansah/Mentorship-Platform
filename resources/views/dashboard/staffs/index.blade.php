@extends('layouts.admin2')
@section('content')
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Staffs</h3>
  <a href="/dashboard/staffs/invite" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-plus"></i> Add Staff</a>
</div>

<div class="flex flex-row-reverse">
  @include('flash-message')
</div>

<table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16">
  <thead class="text-dark-blue">
    <tr>
      <th>No</th>
      <th>Name</th>
      <th>Email</th>
      <th>Active</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @php $no=1 @endphp
    @foreach($staffs as $staff)
    <tr>
      <td>{{$no}}</td>
      <td>{{$staff->first_name}} {{$staff->last_name}}</td>
      <td>{{$staff->email}}</td>
      <td>
        @if ($staff->is_confirm == 1)
          <span class="text-green-600">Active</span>
        @else
          <span class="text-[#D89B33]">Pending</span>
        @endif
      </td>
      <td>
        <div class="dropdown inline-block relative">
          <button id="dropdownHoverButton" class="inline-flex text-black bg-white font-normal rounded-lg text-sm px-4 py-2.5 text-center items-center" type="button">Option <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          <!-- Dropdown menu -->
          <div class="z-10 dropdown-menu absolute hidden border border-light-blue bg-white divide-y divide-gray-100 rounded-lg shadow w-44" style="transform: translate(-30px, 80px);" >
              <ul class="py-2 text-sm text-left text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                <li>
                  <a href="{{ route('dashboard.staffs.edit' , [$staff->id])}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit Details</a>
                </li>
                <li>
                  <a href="{{ route('dashboard.staffs.suspend' , [$staff->id])}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                    @if($staff->is_confirm == 1)
                    Deactivate
                    @else
                    Activate
                    @endif
                  </a>
                </li>
                <li>
                  <form action="{{ route('dashboard.staffs.destroy', [$staff->id]) }}" method="post">
                    @method('delete')
                    @csrf
                    <input type="submit" class="w-full text-left cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onClick="return confirm('Delete this supervisor?')" value="Delete">
                  </form>
                </li>
              </ul>
          </div>
        </div>
      </td>
    </tr>
    @php $no++ @endphp
    @endforeach
  </tbody>
</table>
@endsection