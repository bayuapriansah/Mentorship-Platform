@extends('layouts.admin2')
@section('content')
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">
    {{$project->name}} <i class="fa-solid fa-chevron-right mr-2"></i> Injection Card
  </h3>
  <a href="/dashboard/projects/{{$project->id}}/show" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-xmark"></i> Cancel</a>
</div>

<div class="space-y-6">
  <div class="flex flex-col">
    <p class="text-light-blue">Injection Card / Task Name</p>
    <p>{{$injection->title}}</p>
  </div>
  
  <div class="flex flex-col">
    <p class="text-light-blue">Injection Card / Task Duration</p>
    <p>{{$injection->duration}} Days</p>
  </div>
  
  <div class="flex flex-col">
    <p class="text-light-blue">Injection Card / Task Details</p>
    <p>{!!$injection->description!!}</p>
  </div>

  <div class="flex flex-col w-1/2">
    <p class="text-light-blue">Attachment</p>
    @php
        $no=1;
    @endphp
    @foreach ($attachments as $attachment)
      <div class="py-4 px-6 mb-2 bg-white hover:bg-[#F2F3FD] border border-light-blue rounded-xl flex justify-between">
        <div><img src="{{asset('assets/img/icon/Vector.png')}}" alt=""></div>
        @php
          $ekstension = substr($attachment->file1, strpos($attachment->file1, ".") + 1);
        @endphp
        <div class="flex flex-col">
          <p>Attachment {{$no}} (.{{$ekstension}})</p>
        </div>
        <a  href="{{asset('storage/'.$attachment->file1)}}">
          <img  src="{{asset('assets/img/icon/download.png')}}" alt="">
        </a>
      </div>
    @php
        $no++
    @endphp
    @endforeach
  </div>
</div>
@endsection