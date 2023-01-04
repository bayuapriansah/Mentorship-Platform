@extends('layouts.index')
@section('content')
<div class="container">
  @include('flash-message')
  <div class="row">
    <div class="col">
      <h1>{{$project->name}}</h1>
    </div>
  </div>
  

  <div class="row mt-1">
    <div class="col">
      <p class="text-bold mb-0">Problem : </p>
      <p>{!! $project->problem !!}</p>
    </div>
  </div>

  <div class="row mt-1">
    <div class="col">
      <p class="text-bold mb-0">type : </p>
      <p>{{$project->type}}</p>
    </div>
  </div> 
  
  <div class="row mt-1">
    <div class="col">
      <p class="text-bold mb-0">Period : </p>
      <p>{{$project->period}} Month</p>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col">
      <p class="text-bold mb-0">Domain : </p>
      <p>{{$project->project_domain}}</p>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col">
      <p class="text-bold mb-0">{{$project->company->name}}</p>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col">
      <div class="accordion" id="accordionExample">
        @php $no = 1 @endphp
        @foreach($project_sections as $project_section)
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading{{$no}}">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$no}}" aria-expanded="true" aria-controls="collapse{{$no}}">
              Section {{$no}}
            </button>
          </h2>
          <div id="collapse{{$no}}" class="accordion-collapse collapse {{$no==1 ? 'show': ''}}" aria-labelledby="heading{{$no}}" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              {!!$project_section->description!!}
              @foreach($project_section->sectionSubsections as $subsection)
              <a href="/projects/{{$project->id}}/detail/{{$subsection->id}}" class="text-decoration-none text-dark">
                <div class="card p-4 mb-2">
                    {{$subsection->title}}
                </div>
              </a>
              @endforeach
            </div>
          </div>
        </div>
      @php $no++ @endphp
      @endforeach

      </div>
    </div>
  </div>
 
  <div class="row mt-2">
    <div class="col">
      <form method="POST" action="{{ $project->id }}/apply" >
        @csrf
        <div class="control">
          <button type="submit" class="btn btn-success">Apply</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection