@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Confirmed students</h1>
      {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add Students</a> --}}
  </div>

  <!-- Content Row -->
  <div class="row">
    <div class="col">
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Date of birth</th>
            <th>Github Link</th>
            <th>State</th>
            <th>Join since</th>
            <th>Country</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($students as $student)
          <tr>
            <td>{{$no}}</td>
            <td>{{$student->first_name}}</td>
            <td>{{$student->last_name}}</td>
            <td>{{$student->email}}</td>
            <td>{{$student->gender}}</td>
            <td>{{$student->date_of_birth}}</td>
            <td>{{$student->github_link}}</td>
            <td>{{$student->state}}</td>
            <td>{{$student->created_at->format('m-d-Y')}}</td>
            <td>{{$student->country}}</td>
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