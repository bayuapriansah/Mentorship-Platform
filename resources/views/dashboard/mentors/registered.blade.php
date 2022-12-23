@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Waiting to confirm mentors</h1>
      {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add Students</a> --}}
  </div>

  <!-- Content Row -->
  <div class="row">
    <div class="col">
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>gender</th>
            <th>Institution Name</th>
            <th>Position</th>
            <th>State</th>
            <th>Country</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($mentors as $mentor)
          <tr>
            <td>{{$no}}</td>
            <td>{{$mentor->name}}</td>
            <td>{{$mentor->email}}</td>
            <td>{{$mentor->gender}}</td>
            <td>{{$mentor->institution_name}}</td>
            <td>{{$mentor->position}}</td>
            <td>{{$mentor->state}}</td>
            <td>{{$mentor->country}}</td>
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