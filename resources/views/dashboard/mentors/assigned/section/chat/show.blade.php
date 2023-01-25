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
        @foreach($comments->where('student_id', $student_id)->where('mentor_id', null) as $comment)
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
        {{-- @dd($comments->where('mentor_id', Auth::guard('mentor')->user()->id)) --}}
        @foreach($comments->where('mentor_id', Auth::guard('mentor')->user()->id)->where('student_id', $student_id) as $mentorComment )
        <div class="row mb-2">
          <div class="col"></div>
          <div class="col align-self-end">
            <div class="border border-primary rounded-lg p-2 ">
              {{$mentorComment->message}}
              @if($mentorComment->file)
                <br>
                <a href="{{asset('storage/'.$mentorComment->file)}}" class="flex items-center">
                  <img src="{{asset('assets/img/icon/Vector.png')}}" alt="">
                  <span class="text-xs">click to download</span>
                </a>
              @endif
              
            </div>
            <p class="text-right">
              {{$mentorComment->created_at}}
            </p>
          </div>
          </div>
        @endforeach
      </div>
      <div class="form mt-2">
        <form action="/dashboard/{{Auth::guard('mentor')->user()->id}}/assigned_projects/{{$project_id}}/section/{{$section_id}}/student/{{$student_id}}/sendComment" method="post" id="form-chat" enctype="multipart/form-data">
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
          {{-- <div class="flex items-center justify-between px-3 py-2 bg-white ">
              <div class="flex pl-0 space-x-1 sm:pl-2">

                  <label for="file-chat-input" type="button" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 ">
                      <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"></path></svg>
                      <span class="sr-only"></span>
                  </label>
                  <div id="chatFileName"></div>
                  <input id="file-chat-input" class="hidden" type="file" name="file" />
              </div>
              <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200  hover:bg-blue-800">
                Post comment
              </button>
          </div> --}}
        </div>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection