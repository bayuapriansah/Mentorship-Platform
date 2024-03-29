@extends('layouts.index')
@section('content')
<div class="container">
  <div class="p-5 mb-4 text-center">
    <img src="{{asset('assets/img/image.png')}}" alt="" width="100%" height="250px">
  </div>

  <div class="row">
    <div class="col-9">
      <div class="row">
        <div class="col">
            <div class="row">
              <div class="col-10">
                <h3>{{$project->name}}</h3>
              </div>
              <div class="col-2">
                {{-- <a class="btn btn-primary" href="/projects/{{Auth::guard('student')->user()->id}}/applied/{{$project->id}}/submission" role="button">Submission</a> --}}
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>{{optional($project->company)->name;}}</p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                @php
                  $appliedDate = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', $student_id)->where('project_id', $project->id)->first()->created_at);
                  $date = $appliedDate->format('Y-m-d');
                @endphp
                <p>applied at {{$date}}</p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p> {!!$project->problem!!}</p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>Domain : {{$project->project_domain}}</p>
              </div>
            </div>
            <div class="row">
              <div class="col">

              </div>
            </div>
            <div class="row mt-4">
              <div class="col">
                <div class="accordion" id="accordionExample">
                  @php
                    $no = 1;
                    $isErrorPrevious = false;
                    $ErrorId = 0;
                  @endphp

                  @foreach($project_sections as $project_section)
                  @php
                      $latest_id = $project_section->id;
                  @endphp
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{$no}}">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$no}}" aria-expanded="true" aria-controls="collapse{{$no}}">
                        Section {{$no}}
                      </button>
                    </h2>
                    <div id="collapse{{$no}}" class="accordion-collapse collapse {{$no==1 ? 'show': ''}}" aria-labelledby="heading{{$no}}" data-bs-parent="#accordionExample">
                      <div class="accordion-body {{\Carbon\Carbon::now()->toDateString() >= $date ? '': 'pe-none'}}">
                        {!!$project_section->description!!}
                        Start from {{$date}}
                        @php
                            $date = $appliedDate->addDays(7)->toDateString();
                            $isNotCompleted = 0;
                        @endphp
                        @foreach($project_section->sectionSubsections as $subsection)
                        @if (!isset($subsection->submission))

                            @if (!$isErrorPrevious)
                                @php
                                    $ErrorId = $project_section->id
                                @endphp
                            @endif

                            @php
                                $isErrorPrevious = true;
                            @endphp

                        @endif
                        @if (!$subsection->submission && $isNotCompleted != 0)
                        {{-- <p>KONDISI 1</p> --}}
                        {{-- @dd($subsection) --}}

                        <a style="color: yellow !important" href="/projects/{{$student_id}}/applied/{{$project->id}}/task/{{$project_section->id}}/detail/{{$subsection->id}}/submission" class="text-decoration-none text-dark disabled-link">
                          <div class="card p-4 mb-2">
                              <div class="text-muted">{{$subsection->category}} {{$subsection->submission ? '[completed]': '[not complete yet]'}}</div>
                              {{$subsection->title}}
                          </div>
                        </a>
                        @elseif (!$subsection->submission && $isNotCompleted == 0)
                        {{-- make sure link cant be accessed if time not meet yet --}}
                        {{-- @if($section_complete == 'selesai' && )   --}}
                        {{-- <p>KONDISI 2</p> --}}

                          <a style="color: red !important" href="/projects/{{$student_id}}/applied/{{$project->id}}/task/{{$project_section->id}}/detail/{{$subsection->id}}/submission" class="text-decoration-none text-dark"  >
                              <div class="card p-4 mb-2">
                                  <div class="text-muted">{{$subsection->category}} {{$subsection->submission ? '[completed]': '[not complete yet]'}}</div>
                                  {{$subsection->title}}
                              </div>
                            </a>
                            @php
                                $isNotCompleted = 1;
                            @endphp
                        @elseif($subsection->submission)
                        {{-- make sure link cant be accessed if time not meet yet --}}
                        {{-- <p>KONDISI 3</p> --}}

                          <a  style="color: green !important" href="/projects/{{$student_id}}/applied/{{$project->id}}/task/{{$project_section->id}}/detail/{{$subsection->id}}/submission" class="text-decoration-none text-dark"  >
                            <div class="card p-4 mb-2">
                                <div class="text-muted">{{$subsection->category}} {{$subsection->submission ? '[completed]': '[not complete yet]'}}</div>
                                {{$subsection->title}}
                            </div>
                          </a>

                        @else
                        {{-- <p>
                          KONDISI 4
                        </p> --}}
                        <a href="/projects/{{$student_id}}/applied/{{$project->id}}/task/{{$project_section->id}}/detail/{{$subsection->id}}/submission" class="text-decoration-none text-dark disabled-link">
                          <div class="card p-4 mb-2 ">
                              <div class="text-muted">{{$subsection->category}} {{$subsection->submission ? '[completed]': '[not complete yet]'}}</div>
                              {{$subsection->title}}
                          </div>
                        </a>
                        @endif
                        @endforeach
                      </div>
                    </div>
                  </div>
                  @php $no++ @endphp
                  @endforeach
                </div>
              </div>
            </div>

        </div>
      </div>
    </div>
    @include('projects.sidebar')
  </div>

  <div class="mt-5 text-center">
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="" width="30px" height="30px">
    <img src="https://upload.wikimedia.org/wikipedia/commons/4/4f/Twitter-logo.svg" alt="" width="30px" height="30px">
    <p>Checkout Sponsoring Company</p>
  </div>
  <div class="mt-5 text-center">
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="" width="30px" height="30px">
    <p>Download the dataset here</p>
  </div>



  <h2 class="mt-5">Get help for your project</h2>
  <a href="#" class="link-primary">Link to discussion forum</a><br>
  <a href="#" class="link-primary">Link to support document library</a>
</div>
@endsection
