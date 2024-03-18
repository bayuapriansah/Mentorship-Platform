@extends('layouts.admin2')
@section('content')
    <a href="{{ route('dashboard.messages.taskMessage', ['injection' => $injection->id]) }}" class="group block text-lg text-[#6973C6]">
        <
        <span class="ml-2 group-hover:underline">
            Back
        </span>
    </a>

    <div class="mt-2 flex justify-between items-center">
        <h1 class="text-dark-blue font-medium text-[1.375rem]">
            {{ substr($injection->title, 0, 35) }}{{ strlen($injection->title) >= 35 ? '...' : '' }}
            <span class="mx-3">></span>
            <a href="{{ route('dashboard.messages.taskMessage', ['injection'=> $injection->id]) }}">Messages</a>
            <span class="mx-3">></span>
            {{ $participant->first_name }} {{ $participant->last_name }}
        </h1>

        <a href="{{ route('dashboard.messages.create') }}" class="group flex items-center gap-3">
            <svg class="mt-1" width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_4187_8193)">
                    <path d="M26.9805 16.0417C27.2284 16.0417 27.4763 16.0563 27.7096 16.0855V10.0188C27.7096 8.51675 26.4846 7.29175 24.9825 7.29175H5.64505C4.14297 7.29175 2.91797 8.51675 2.91797 10.0188V24.9813C2.91797 26.4834 4.14297 27.7084 5.64505 27.7084H19.8346C19.2805 26.6147 18.9596 25.3751 18.9596 24.0626C18.9596 19.6292 22.5471 16.0417 26.9805 16.0417ZM15.168 18.9584L5.83464 13.4022V10.2084H6.17005L15.1826 15.5751L24.4138 10.2084H24.793V13.3584L15.168 18.9584Z" fill="#E96424"/>
                    <path d="M27.7083 18.9585L25.6521 21.0147L27.9563 23.3335H21.875V26.2502H27.9563L25.6521 28.5689L27.7083 30.6252L33.5417 24.7918L27.7083 18.9585Z" fill="#E96424"/>
                </g>
                <defs>
                    <clipPath id="clip0_4187_8193">
                        <rect width="35" height="35" fill="white"/>
                    </clipPath>
                </defs>
            </svg>

            <span class="text-xl text-dark-blue group-hover:underline">
                New Message
            </span>
        </a>
    </div>

    <div id="accordion-collapse" class="mt-8 border border-light-blue rounded-lg p-4 bg-white" data-accordion="collapse">
        @php $no=1;  @endphp
        @foreach ($comments as $comment)
            <h2 id="accordion-collapse-heading-{{ $no }}" class="">
                <button type="button" id="accordion-{{ $no }}"
                    class="flex items-center justify-between w-full p-5 mb-2 font-medium text-left text-black  border-b-2 border-gray-200"
                    data-accordion-target="#accordion-collapse-body-{{ $no }}" aria-expanded="false"
                    aria-controls="accordion-collapse-body-{{ $no }}">
                    <div class="flex items-center space-x-4">
                        <i class="text-primary fa-solid fa-circle"></i>
                        <div class="flex-col">
                            <span class="font-medium capitalize">
                                @if ($comment->mentor_id)
                                    {{ optional($comment->mentor)->first_name ?? 'NoName' }}
                                    {{ optional($comment->mentor)->last_name ?? '' }} (Supervisor)
                                @elseif($comment->staff_id)
                                    {{ optional($comment->staff)->first_name ?? 'NoName' }}
                                    {{ optional($comment->staff)->last_name ?? '' }} (Staff)
                                @elseif ($comment->user_id)
                                    {{ optional($comment->user)->name ?? 'NoName' }} (Platform Admin)
                                @elseif ($comment->customer_id)
                                    {{ optional($comment->customer)->first_name ?? 'NoName' }}
                                    {{ optional($comment->customer)->last_name ?? '' }} (Customer)
                                @else
                                    {{ optional($comment->student)->first_name ?? 'NoName' }}
                                    {{ optional($comment->student)->last_name ?? '' }} (Student)
                                @endif
                            </span><br>
                            <span class="font-light receiver capitalize">
                                @if ($comment->mentor_id == null && $comment->user_id == null && $comment->companies_id == null)
                                    cc: {{ $comment->student->mentor->first_name }}
                                    {{ $comment->student->mentor->last_name }},
                                    @foreach ($customer_participants as $customer)
                                        {{ $customer->first_name }} {{ $customer->last_name }},
                                    @endforeach
                                @elseif($comment->mentor_id != null)
                                    cc: {{ $comment->student->first_name }} {{ $comment->student->last_name }},
                                    @foreach ($customer_participants as $customer)
                                        {{ $customer->first_name }} {{ $customer->last_name }},
                                    @endforeach
                                @elseif($comment->user_id != null)
                                    cc: {{ $comment->student->first_name }} {{ $comment->student->last_name }},
                                    {{ $comment->student->mentor->first_name }}
                                    {{ $comment->student->mentor->last_name }},
                                    @foreach ($customer_participants as $customer)
                                        {{ $customer->first_name }} {{ $customer->last_name }},
                                    @endforeach
                                @endif
                            </span>
                            <span class="font-light message-top">{!! substr($comment->message, 0, 99) !!}
                                {{ strlen($comment->message) >= 99 ? '...' : '' }}</span>
                        </div>
                    </div>

                    <div class="text-xs text-light-blue font-light">
                        {{ $comment->created_at->format('d M Y') }}
                        <i class="fa-sharp fa-solid fa-reply"></i>
                    </div>
                </button>
            </h2>
            <div id="accordion-collapse-body-{{ $no }}" class="hidden"
                aria-labelledby="accordion-collapse-heading-{{ $no }}">
                <div class="p-5 font-light ">
                    <p class="mb-2 text-base text-black ">{!! $comment->message !!}</p>
                    @if ($comment->file)
                        <br>
                        <a target="_blank" href="{{ asset('storage/' . $comment->file) }}"
                            class="flex w-1/2 py-2 px-4 rounded-xl justify-between items-center border border-light-blue">
                            <img src="{{ asset('assets/img/icon/Vector.png') }}" alt="">
                            <span class="text-xs  font-normal text-black">click to download
                                (.{{ substr($comment->file, strpos($comment->file, '.') + 1) }})</span>
                            <img src="{{ asset('assets/img/icon/download.png') }}" alt="">
                        </a>
                    @endif
                </div>
            </div>
            @php $no++ @endphp
        @endforeach
        <a href="/dashboard/messages/{{ $injection->id }}/reply/{{ $participant->id }}"
            class="text-white bg-primary px-11 py-1 rounded-full">Reply</a>
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
