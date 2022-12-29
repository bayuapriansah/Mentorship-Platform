@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      @include('flash-message')
      <h1 class="h3 mb-0 text-gray-800">Invited mentors</h1>
      {{-- <a href="{{route('dashboard.mentors.invite')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa-regular fa-plus"></i> Invite Mentor</a> --}}
  </div>

  <!-- Content Row -->
  <div class="row">
    <div class="col">
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>address</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($companies as $company)
          <tr>
            <td>{{$no}}</td>
            <td>{{$company->name}}</td>
            <td>{{$company->address}}</td>
            <td>{{$company->email}}</td>
            <td><a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/mentors/registered/{{$company->id}}/invite" >Invite Mentor</a>
            </td>
          </tr>
          @php $no++ @endphp
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
@section('more-js')

@endsection