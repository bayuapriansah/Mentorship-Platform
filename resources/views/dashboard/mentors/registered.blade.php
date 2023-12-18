@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Pending mentor invitation</h1>
      {{-- <a href="{{route('dashboard.mentors.invite')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa-regular fa-plus"></i> Invite Mentor</a> --}}
  </div>

  <!-- Content Row -->
  <div class="row">
    <div class="col">
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Email</th>
            <th>Company</th>
            <th>Project</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($mentors as $mentor)
          @foreach($mentor->projects as $data_project)
          <tr>
            <td>{{$no}}</td>
            <td>{{$mentor->email}}</td>
            <td>{{$mentor->company->name}}</td>
            <td>{{$data_project->name}}</td>
            <td>{{$mentor->is_confirm == 0 ? 'Invited' : 'Confirm'}}</td>
            </td>
          </tr>
          @php $no++ @endphp
          @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
@section('more-js')

@endsection
