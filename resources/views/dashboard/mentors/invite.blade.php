@extends('layouts.admin')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col">
      <div class="card p-4">
        <div class="mb-3">
          <label for="inputvalid" class="form-label">Project</label>
            <select class="form-control form-select" id="inputdomain" aria-label="Default select example" name="project_id">
            <option value="">--Select Project--</option>
            <option onselect="hideMentor()" value="1">okeh</option>
            <option onselect="hideMentor1()" value="2">okeh bro</option>
          </select>
        </div>
      </div>
    </div>
  </div>
  <br>

  <div id="hideMentorInvite">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Invite Mentor</h1>
    </div>
    <div class="row">
      <div class="col">
        <div class="card p-4">
          @include('flash-message')
          <form action="/dashboard/companies/{{$company->id}}/invite" method="post">
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
  </div>

  <div id="hideMentorInvite1">
    <div class="d-sm-flex align-items-center justify-content-between my-4">
      <h1 class="h3 mb-0 text-gray-800">Add Mentors to Project</h1>
    </div>
    <div class="row">
      <div class="col">
        <div class="card p-4">
          @include('flash-message')
          <form action="/dashboard/companies/{{$company->id}}/invite" method="post">
            @csrf
            <div class="mb-3">
              <label for="inputemail" class="form-label">Affiliated Mentors to This project</label>
              <select class="form-control form-select" id="inputemail" aria-label="Default select example" name="email">
                <option value="">--Select Registered Mentor--</option>
                @forelse($mentor as $data_mentor)
                <option value="{{$data_mentor->email}}">{{$data_mentor->email}}</option>
                @empty
                <p>There is still no Mentor available</p>
                @endforelse
              </select>
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
            @foreach($data_mentor->projects as $data_project)
            <tr>
              <td>{{$no}}</td>

              <td>{{$data_mentor->email}}</td>

              <td>{{$data_project->name}}</td>
            </tr>
            @php $no++ @endphp
            @endforeach
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