@extends('layouts.admin2')
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
              <p>{{$spvComment->message}}</p>
              @if($spvComment->file)
                <a href="{{asset('storage/'.$spvComment->file)}}" class="flex items-center">
                  <svg aria-hidden="true" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                  </svg>
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

          <label for="chat" class="sr-only">Your message</label>
          <div class="flex items-center px-3 py-2 rounded-lg bg-gray-50 dark:bg-gray-700">
              <a onclick="document.getElementById('file_input').click()" name="file" class="inline-flex justify-center p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                  <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"></path>
                  </svg>
                  <span class="sr-only">Upload image</span>
              </a>
              <input type="file" class="form form-control" name="file" id="file_input" style="display : none">
              <textarea id="comment" name="message" rows="1" class="block mx-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your message..." required></textarea>
                  <button type="submit" class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                  <svg aria-hidden="true" class="w-6 h-6 rotate-90" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                  <span class="sr-only">Send message</span>
              </button>
          </div>
      </form>        
        {{-- <form action="{{ route('dashboard.chat.SendComment',[Auth::guard('web')->user()->id,$project_id,$section_id,$student_id]) }}" method="post" id="form-chat" enctype="multipart/form-data">
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
        </form> --}}
      </div>
    </div>
  </div>

</div>
@endsection
@section('more-js')
<script>
$("#comment").keydown(function(event) {
  if (event.keyCode === 13 && !event.shiftKey) {
    event.preventDefault();
    $("#form-chat").submit();
  }
});
</script>
@endsection