@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Companies</h1>
      <a href="{{route('dashboard.companies.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa-regular fa-plus"></i> Add Companies</a>
  </div>

  <!-- Content Row -->
  <div class="row">
    <div class="col card p-4">
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Company Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($companies as $company)
          <tr>
            <td>{{$no}}</td>
            <td>{{$company->name}}</td>
            <td>{{$company->email}}</td>
            <td>{{$company->address}}</td>
            <td>
              <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/companies/{{$company->id}}/edit">Edit</a>
              <a class="btn btn-labeled bg-primary editbtn text-white" href="/dashboard/companies/{{$company->id}}/inviteMentors" >Invite Mentor</a>
              <form method="POST" action="/dashboard/companies/{{ $company->id }}" >
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
