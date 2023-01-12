@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Institution</h1>
      <a href="{{route('dashboard.institutions.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa-regular fa-plus"></i> Add Institutions</a>
  </div>

  <!-- Content Row -->
  <div class="row">
    <div class="col card p-4">
      @include('flash-message')
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Institution Name</th>
            <th>City</th>
            <th>State</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($institutions as $institution)
          <tr>
            <td>{{$no}}</td>
            <td>{{$institution->name}}</td>
            <td>{{$institution->city}}</td>
            <td>{{$institution->state}}</td>
            <td>
              <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/institutions/{{$institution->id}}/edit">Edit</a>
              <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/institutions/{{$institution->id}}/inviteMentors" >Invite Mentor</a>
              <form method="POST" action="/dashboard/institutions/{{ $institution->id }}" >
                @csrf
                @method('DELETE')
                <div class="control">
                <button type="submit" class="btn btn-danger ms-2" onClick="return confirm('Delete this company?')">Delete</button>
              </form>
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