@extends('layouts.admin')
@section('content')
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Invite Mentor</h1>
  </div>

  <div class="row">
    <div class="col">
      <div class="card p-4">
        <form action="/dashboard/mentors/registered/{{$company->id}}/invite" method="post">
          @csrf
          <div class="mb-3">
            <label for="inputemail" class="form-label">Email</label>
            <input type="text" class="form-control" id="inputemail" name="email" value="{{old('email')}}">
            @error('email')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>
          <div class="mb-3">
            <label for="inputvalid" class="form-label">Project</label>
            <select class="form-control form-select" id="inputdomain" aria-label="Default select example" name="project_id">
              <option value="">--Select Project--</option>
              @forelse($projects as $project)
              <option value="{{$project->id}}" {{old('project_id') == $project->id ? 'selected': ''}} >{{$project->name}}</option>
              @empty
              <p>No aroject available</p>
              @endforelse
            </select>
            @error('project_id')
                <p class="text-danger text-sm mt-1">
                  {{$message}}
                </p>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>

  <div class="d-sm-flex align-items-center justify-content-between my-4">
    <h1 class="h3 mb-0 text-gray-800">Invited Mentors</h1>
  </div>
  <div class="row">
    <div class="col">
      <div class="card p-4">
        <table id="myTable" class="display responsive w-100" style="width: 100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Mentors name</th>
              <th>Project</th>
            </tr>
          </thead>
          <tbody>
            @php $no=1 @endphp  
            @foreach($mentor as $data_mentor)
            <tr>
              <td>{{$no}}</td>

              <td>{{$data_mentor->email}}</td>

              @foreach($data_mentor->projects as $data_project)
              <td>{{$data_project->name}}</td>
              @endforeach
            @php $no++ @endphp
            </tr>
            @endforeach
            {{-- @foreach($mentor->project as $data_mentor)
            <tr>
                <td>{{$no}}</td>
                <td>{{$mentorProject->mentor->name}}</td>
              <td>{{$mentorProject->project_id}}</td>
            </tr>
            @php $no++ @endphp
            @endforeach --}}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection