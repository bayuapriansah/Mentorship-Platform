@extends('layouts.index')
@section('content')
<div class="container">
  <div class="p-5 mb-4 text-center">
    <img src="{{asset('assets/img/image.png')}}" alt="" width="100%" height="250px">
  </div>

  @include('flash-message')
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
                <p>{{$project->company->name}}</p>
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
                    {{-- <p>Ini Data Section {{ $no }} yang selesai : {{ $dat = $section_count_complete->where('section',$no) }}</p>
                    <p>Jumlah Section yang selesai : {{ $section_complete = $section_count_complete->where('section',$no)->count() }}</p>
                    <p>Jumlah Section yang harus selesai : {{ $section_must_complete = $section_count->where('section', $no)->count() }}</p>
                    {{ $section_complete == $section_must_complete ? 'selesai' : 'belum' }} --}}
                    <div id="collapse{{$no}}" class="accordion-collapse collapse {{$no==1 ? 'show': ''}}" aria-labelledby="heading{{$no}}" data-bs-parent="#accordionExample">
                      {{-- <div class="accordion-body"> --}}
                      <div class="accordion-body {{\Carbon\Carbon::now()->toDateString() >= $date ? '': 'pe-none'}}">
                        {!!$project_section->description!!}
                        {{-- Start from {{$date}} --}}
                        @php
                            $date = $appliedDate->addDays(7)->toDateString();
                            $isNotCompleted = 0;
                        @endphp
                        {{-- SUBSECTION --}}
                        {{-- @dd($project) --}}
                        @foreach($project_section->sectionSubsections as $subsection)
                        {{-- isErrorPrevious --}}
                       
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
                        {{-- <p>
                          {{  !$isErrorPrevious ? "SHOW" : "ERROR" }}
                         </p> --}}
                        {{-- jumlah submission subsection --}}
                        {{-- @dd($subsection->submission->where('section_subsection_id', $subsection->id)->get()->count()) --}}

                        {{-- cari jumlah task per section --}}
                        {{-- @dd($project_section->sectionSubsections->count()) --}}
                        {{-- @dd($section_complete = $section_count_complete->where('section',$no)->count()) --}}
                        
                        {{--  --}}
                        {{-- @dd($subsection->submission->where('section_subsection_id', $subsection->id)->get()->count()) --}}
                        {{-- @dd($subsection->submission->where('section_subsection_id', $subsection->id)->get()->count() != $project_section->sectionSubsections->count() ? 'true': 'false') --}}
                        
                        {{-- @if ($subsection->submission->where('section_subsection_id', $subsection->id)->get()->count() != $project_section->sectionSubsections->count())
                            @dd('yee')
                        @else
                          @dd('ts')
                        @endif --}}
                        {{-- {{ $project_section->section == 1 ? 'OK' : 'GAGAL' }} --}}
                        {{-- @if($section_complete == $section_must_complete && $project_section->section == $no && \Carbon\Carbon::now()->toDateString() >= $date) --}}
                         {{-- KONDISI 1 =  --}}
                        {{-- {{ print_r($ErrorId, $subsection ? "BELUM KOMPLIT" :"UDAH KOMPLIT") }} --}}
                        @if (!$subsection->submission && $isNotCompleted != 0 && $ErrorId == $project_section->id)
                        {{-- <p>KONDISI 1</p> --}}

                        <a style="color: yellow !important" href="/projects/{{$student_id}}/applied/{{$project->id}}/task/{{$project_section->id}}/detail/{{$subsection->id}}/submission" class="text-decoration-none text-dark disabled-link">
                          <div class="card p-4 mb-2">
                              <div class="text-muted">{{$subsection->category}} {{$subsection->submission ? '[completed]': '[not complete yet]'}}</div>
                              {{$subsection->title}}
                          </div>
                        </a>
                        @elseif (!$subsection->submission && $isNotCompleted == 0 && $ErrorId == $project_section->id)
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
                          {{-- @endif --}}
                         

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
                     
                        {{-- @endif --}}
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
  
  {{-- <div class="card mt-5 text-center bg-light">
    
  </div> --}}

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