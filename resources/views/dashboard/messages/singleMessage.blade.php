@extends('layouts.admin2')
@section('content')
<div class="text-[#6973C6] hover:text-light-blue">
  <a href="/dashboard/messages/{{$injection->id}}"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
</div>

<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">{{substr($injection->title,0,35)}}{{strlen($injection->title) >=35?"...":''}} <i class="fa-solid fa-chevron-right"></i> Messages <i class="fa-solid fa-chevron-right"></i> {{$participant->first_name}} {{$participant->last_name}}</h3>
  <a href="/dashboard/messages/create" class="text-xl text-dark-blue"><i class="fa-solid fa-envelope"></i> New Message</a>
</div>

<div id="accordion-collapse" class="border border-light-blue rounded-lg p-4 bg-white" data-accordion="collapse">
  @php $no=1;  @endphp
  @foreach ($comments as $comment)
    <h2 id="accordion-collapse-heading-{{$no}}" class="">
      <button type="button" id="accordion-{{$no}}" class="flex items-center justify-between w-full p-5 mb-2 font-medium text-left text-black  border-b-2 border-gray-200" data-accordion-target="#accordion-collapse-body-{{$no}}" aria-expanded="false" aria-controls="accordion-collapse-body-{{$no}}">
        <div class="flex items-center space-x-4">
          <i class="text-dark-blue fa-solid fa-circle"></i>
          <div class="flex-col">
            <span class="font-medium">
              @if ($comment->mentor_id)
                {{$comment->mentor->first_name}} {{$comment->mentor->last_name}} (Supervisor)
              @elseif ($comment->user_id)
                {{$comment->user->name}} (Platform Admin)
              @elseif ($comment->customer_id)
                {{$comment->customer->first_name}} {{$comment->customer->last_name}} (Customer)
              @else
                {{$comment->student->first_name}} {{$comment->student->last_name}} (Student)
              @endif
            </span><br>
            <span class="font-light receiver">
              @if($comment->mentor_id == null && $comment->user_id == null && $comment->companies_id == null)
                to: {{$comment->student->mentor->first_name}} {{$comment->student->mentor->last_name}},
                @foreach ($customer_participants as $customer)
                  {{$customer->first_name}} {{$customer->last_name}},
                @endforeach
              @elseif($comment->mentor_id !=null)
                to: {{$comment->student->first_name}} {{$comment->student->last_name}},
                @foreach ($customer_participants as $customer)
                  {{$customer->first_name}} {{$customer->last_name}},
                @endforeach
              @elseif($comment->user_id !=null )
              to: {{$comment->student->first_name}} {{$comment->student->last_name}}, {{$comment->student->mentor->first_name}} {{$comment->student->mentor->last_name}},
                @foreach ($customer_participants as $customer)
                  {{$customer->first_name}} {{$customer->last_name}},
                @endforeach
              @endif
            </span>
            <span class="font-light message-top">{!!substr($comment->message,0,99)!!} {{strlen($comment->message)>=99?'...':''}}</span>
          </div>
        </div>

        <div class="text-xs text-light-blue font-light">
          {{$comment->created_at->format('d M Y')}}
          <i class="fa-sharp fa-solid fa-reply"></i>
        </div>
      </button>
    </h2>
    <div id="accordion-collapse-body-{{$no}}" class="hidden" aria-labelledby="accordion-collapse-heading-{{$no}}">
      <div class="p-5 font-light ">
        <p class="mb-2 text-base text-black ">{!!$comment->message!!}</p>
        @if($comment->file)
          <br>
          <a download="image.jpg" href="{{asset('storage/'.$comment->file)}}" class="flex w-1/2 py-2 px-4 rounded-xl justify-between items-center border border-light-blue">
            <img src="{{asset('assets/img/icon/Vector.png')}}" alt="">
            <span class="text-xs  font-normal text-black">click to download (.{{substr($comment->file, strpos($comment->file, ".") + 1)}})</span>
            <img src="{{asset('assets/img/icon/download.png')}}" alt="">
          </a>
        @endif
      </div>
    </div>
    @php $no++ @endphp
  @endforeach
    <a href="/dashboard/messages/{{$injection->id}}/reply/{{$participant->id}}" class="text-white bg-dark-blue hover:bg-darker-blue px-8 py-1 rounded-full">Reply</a>
</div>
@endsection
@section('more-js')
<script>
  $(document).ready(function() {
    $('.receiver').hide();

    $('[id^=accordion-]').on('click', function() {
      var messageTop = $(this).closest('button').find('.message-top');
      var receiver = $(this).closest('button').find('.receiver');
      receiver.toggle();
      messageTop.toggle();
    });
  });


</script>
@endsection
