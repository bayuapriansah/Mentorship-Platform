@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Companies</h1>
      {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add Students</a> --}}
  </div>

  <!-- Content Row -->
  <div class="row">
    <table id="myTable" class="table table-striped table-responsive display responsive" style="width: 100%">
      <thead>
        <tr>
          <th>No</th>
          <th>Company Name</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        @php $no=1 @endphp
        @foreach($companies as $company)
        <tr>
          <td>{{$no}}</td>
          <td>{{$company->name}}</td>
          <td>{{$company->email}}</td>
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