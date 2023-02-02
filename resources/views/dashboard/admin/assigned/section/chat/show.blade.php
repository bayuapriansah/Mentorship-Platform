@extends('layouts.admin')
@section('content')
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Student Comments</h1>
  </div>
  <div class="card p-4">
    <div class="chat">
      <div class="">
        @foreach($comments->where('student_id', $student_id)->where('user_id', null) as $comment)
          <div class="row mb-2">
            <div class="col align-self-end">
              <div class="border border-primary rounded-lg p-2 ">
                {{$comment->message}}
                @if($comment->file)
                  <br>
                  <a href="{{asset('storage/'.$comment->file)}}" class="flex items-center">
                    <img src="{{asset('assets/img/icon/Vector.png')}}" alt="">
                    <span class="text-xs">click to download</span>
                  </a>
                @endif
                
              </div>
              <p class="text-right">
                {{$comment->created_at}}
              </p>
            </div>
            <div class="col"></div>

          </div>
        @endforeach
        @foreach($comments->where('user_id', Auth::guard('web')->user()->id)->where('student_id', $student_id) as $spvComment )
        <div class="row mb-2">
          <div class="col"></div>
          <div class="col align-self-end">
            <div class="border border-primary rounded-lg p-2 ">
              {{$spvComment->message}}
              @if($spvComment->file)
                <br>
                <a href="{{asset('storage/'.$spvComment->file)}}" class="flex items-center">
                  <img src="{{asset('assets/img/icon/Vector.png')}}" alt="">
                  <span class="text-xs">click to download</span>
                </a>
              @endif
              
            </div>
            <p class="text-right">
              {{$spvComment->created_at}}
            </p>
          </div>
          </div>
        @endforeach
      </div>
      <div class="form mt-2">
        <form action="{{ route('dashboard.chat.SendComment',[Auth::guard('web')->user()->id,$project_id,$section_id,$student_id]) }}" method="post" id="form-chat" enctype="multipart/form-data">
        @csrf
        <div class="w-full mb-4">
          <textarea id="comment" rows="4" class="form form-control" name="message" required></textarea>
          <div class="row">
            <div class="col-8">
              <input type="file" class="form form-control" name="file">
            </div>
            <div class="col-4 text-right">
              <button type="submit" class="btn btn-primary">Send Comment</button>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection