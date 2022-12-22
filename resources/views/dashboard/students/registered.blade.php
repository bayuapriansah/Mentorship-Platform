@extends('layouts.admin')
@section('content')
@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Students</h1>
      {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add Students</a> --}}
  </div>

  <!-- Content Row -->
  <div class="row">
    <table id="myTable" class="display responsive w-100" style="width: 100%">
      <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Email</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @php $no=1 @endphp
        @foreach($students as $student)
        <tr>
          <td>{{$no}}</td>
          <td>{{$student->name}}</td>
          <td>{{$student->email}}</td>
          <td>{{$student->is_confirm}}</td>
          <td></td>
        </tr>
        @php $no++ @endphp
        @endforeach
      </tbody>
    </table>
  </div>

</div>
@endsection
@section('more-js')

@endsection
@endsection