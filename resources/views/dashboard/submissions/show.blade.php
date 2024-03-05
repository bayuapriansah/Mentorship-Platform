@extends('layouts.admin2')

@section('more-css')
    <style>
        .invisible-scrollbar::-webkit-scrollbar {
            width: 0;
        }

        .invisible-scrollbar::-webkit-scrollbar-thumb {
            background-color: transparent;
        }
    </style>
@endsection

@section('content')
<div class="w-full lg:w-3/4">
    <a href="{{ route('dashboard.submission.show', ['project' => $project->id]) }}" class="group block w-max text-lg text-[#6973C6]">
        <
        <span class="ml-2 group-hover:underline">
            Back
        </span>
    </a>

    <div class="mt-2 flex justify-between items-center">
        <h3 class="text-dark-blue font-medium text-[1.375rem]">
            Review Submission
        </h3>

        @if ($submission->grade)
            @if ($submission->grade->status == 0)
                <div class="border-4 border-red-600 text-red-600 rounded-full w-24 h-24 flex items-center justify-center">
                    Revise
                </div>
            @elseif ($submission->grade->status == 1)
                <div class="border-4 border-green-600 text-green-600 rounded-full w-24 h-24 flex items-center justify-center">
                    Pass
                </div>
            @endif
        @endif
    </div>

    <div class="mt-8 grid grid-cols-12 gap-4">
        <div class="col-span-6">
            <p class="text-sm text-dark-blue font-medium">
                Project Name
            </p>

            <p class="mt-1">
                {{ $project->name }}
            </p>
        </div>

        <div class="col-span-6">
            <p class="text-sm text-dark-blue font-medium">
                Submission Number
            </p>

            <p class="mt-1">
                {{ formatOrdinal($submission->taskNumber) }} Submission
            </p>
        </div>
    </div>

    <div class="mt-6">
        <p class="text-sm text-dark-blue font-medium">
            Task Name
        </p>

        <p class="mt-1">
            {{ $submission->projectSection->title }}
        </p>
    </div>

    <div class="mt-10 grid grid-cols-12 gap-4">
        <div class="col-span-4">
            <p class="text-sm text-dark-blue font-medium">
                Participant Name
            </p>

            <p class="mt-1">
                {{ $submission->student->first_name }} {{ $submission->student->last_name }}
            </p>
        </div>

        <div class="col-span-4">
            <p class="text-sm text-dark-blue font-medium">
                Education Institution
            </p>

            <p class="mt-1">
                {{ $submission->student->institution->name }}
            </p>
        </div>

        <div class="col-span-4">
            <p class="text-sm text-dark-blue font-medium">
                Mentor
            </p>

            <p class="mt-1">
                {{ $submission->student->mentor->first_name }} {{ $submission->student->mentor->last_name }}
            </p>
        </div>
    </div>

    <div class="mt-10 grid grid-cols-12 gap-4">
        <div class="col-span-4">
            <p class="text-sm text-dark-blue font-medium">
                Started On
            </p>

            <p class="mt-1">
                {{ $submission->created_at->format('d/m/Y') }}
            </p>
        </div>

        <div class="col-span-4">
            <p class="text-sm text-dark-blue font-medium">
                Submitted On
            </p>

            <p class="mt-1">
                {{ $submission->updated_at->format('d/m/Y') }}
            </p>
        </div>

        <div class="col-span-4">
            <p class="text-sm text-dark-blue font-medium">
                Due On
            </p>

            <p class="mt-1">
                {{ date('d/m/Y', strtotime($submission->dueDate)) }}
            </p>
        </div>
    </div>
</div>

<div class="mt-10 space-y-10">
    <div class="space-y-4">
        <div class="text-dark-blue font-medium">
            Task Submission
        </div>

        <div class="py-4 px-6 w-3/4 bg-white hover:bg-[#F2F3FD] border border-light-blue rounded-xl flex justify-between">
            @if (strpos($submission->file, 'https://') !== false)
                <a href="{{ $submission->file }}" target="_blank" class="fa-solid fa-link"></a>
                <a href="{{ $submission->file }}" target="_blank" class="text-base">

                    Submission Link

                </a>
                <a href="{{ $submission->file }}" target="_blank" class="fa-solid fa-arrow-up-right-from-square"></a>
            @else
                <img src="{{ asset('/assets/img/icon/Vector.png') }}" class="object-scale-down">
                <a href="{{ asset('/storage/'.$submission->file) }}" target="_blank" class="text-base">
                    Submission file .{{ substr($submission->file, strpos($submission->file, '.')+1) }}
                </a>
                <img src="{{asset('assets/img/icon/download.png')}}" class="object-scale-down">
            @endif
            {{-- /dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/edit --}}
            {{-- <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/delete/{{1}}"><i class="text-red-600 fa-solid fa-trash-can fa-lg  my-auto"></i></a> --}}
        </div>
    </div>

    <div>
        @if($submission->dataset)
            <div class="text-dark-blue font-medium">Dataset</div>
                @php
                    $datasets = explode(';',$submission->dataset);
                    $no=1;
                @endphp
                <div class="flex flex-col text-center my-4">
                    <div class="flex flex-wrap justify-start pt-2">
                        @foreach ($datasets as $dataset)
                            <a href="{{$dataset}}" class="bg-light-brown hover:bg-dark-brown px-4 py-1 rounded-lg text-white mr-2 mb-2" target="_blank">Dataset {{$no}} <i class="fa-solid fa-chevron-right"></i></a>
                            @php $no++ @endphp
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if (!Auth::guard('customer')->check())
        @if(Auth::guard('web')->check() || Auth::guard('mentor')->user()->id == $submission->student->mentor_id || Auth::guard('mentor')->user()->id == $submission->student->staff_id )
        @if(!$submission->grade)
            @if (optional(Auth::guard('mentor')->user())->institution_id == 0 || Auth::guard('web')->check())

                <form action="/dashboard/submissions/project/{{$project->id}}/view/{{$submission->id}}/adminGrade" method="post">
                @csrf
                <div class="px-4 py-2 bg-white rounded-lg border border-light-blue">
                    <textarea id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0  focus:outline-none" name="message" placeholder="Add Comments (Optional)"></textarea>
                </div>
                <div class="flex space-x-6">
                    {{-- data-modal-target="defaultModal" data-modal-toggle="defaultModal" --}}

                    <input type="submit" class="text-white text-sm font-normal bg-[#11BF61] hover:bg-green-600 cursor-pointer px-12 py-3 mt-5  rounded-full" name="pass" value="PASS">

                    <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="text-white text-sm font-normal bg-[#AB0606] hover:bg-red-800 cursor-pointer px-12 py-3 mt-5  rounded-full" type="button">
                    NEED REVISION
                    </button>
                    <div id="popup-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                    <div class="relative w-full h-full max-w-md md:h-auto ">
                        <div class="relative bg-white rounded-lg border border-light-blue shadow ">
                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="popup-modal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-6 text-left">
                            <p class="text-dark-blue font-medium text-xl">Are you sure you want to mark this submission as revise submission?</p>
                            <p class="text-base">Once submission is marked as revise, you can let the student re-submit the solution.</p>
                            <br>
                            <div class="flex space-x-4">
                                <button type="submit" name="revision" value="revision" class="bg-dark-blue w-1/2 rounded-lg text-white py-2">
                                Confirm
                                </button>
                                <button type="button" data-modal-hide="popup-modal" type="button" class="bg-[#B52809] w-1/2 rounded-lg text-white py-2">
                                Cancel
                                </button>
                            </div>
                            {{-- <button data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                Yes, I'm sure
                            </button>
                            <button data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">No, cancel</button> --}}
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </form>
            @endif
        @endif
        @endif
    @endif

    <div class="space-y-2">
        <p class="text-dark-blue font-medium">
            Task Details
        </p>

        <button data-modal-target="task-detail-modal" data-modal-toggle="task-detail-modal" class="flex items-center gap-2 text-sm text-grey">
            <span class="underline">
                Show more details
            </span>
            >
        </button>

        <div id="task-detail-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="px-10 pt-8 pb-6">
                        <div class="flex justify-between items-center gap-4">
                            <h3 class="text-[1.375rem] font-medium text-dark-blue">
                                Task Details
                            </h3>

                            <button type="button" data-modal-hide="task-detail-modal">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>

                        <article class="prose lg:prose-lg h-[75vh] mt-6 overflow-y-auto invisible-scrollbar">
                            {!! $submission->projectSection->description !!}
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        @if ($submission->grade)
            @if ($submission->grade->status==0 || $submission->grade->status==1)
                <style>
                    body.modal-open {
                        overflow: visible !important;
                    }
                </style>

                @if (optional(Auth::guard('mentor')->user())->institution_id == 0 || Auth::guard('web')->check())
                    <div>
                        <div class="text-dark-blue font-medium">
                            Change Task Completion Status
                        </div>

                        <button id="detailButton" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeGradeModal">
                            More Detail
                        </button>
                    </div>

                    <div class="modal fade" id="changeGradeModal" tabindex="-1" aria-labelledby="changeGradeModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changeGradeModalLabel">Change Students Grade</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <form action="{{ route('dashboard.submission.changeGrade', ['project' => $project->id, 'submission' => $submission->id]) }}" method="post">
                                        @csrf

                                        <div class="mb-3">
                                            <textarea id="comment" rows="4" class="form-control" name="messageFeedback" placeholder="Add Comments (Optional)"></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Change Grade</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        @endif
    </div>
</div>
@endsection

@section('more-js')
    <script>
        $(document).ready(function () {
            $('#changeGradeModal').on('show.bs.modal', function (e) {
                $('#detailButton').text('Less Detail');
            });

            $('#changeGradeModal').on('hide.bs.modal', function (e) {
                $('#detailButton').text('More Detail');
            });
        });
    </script>
@endsection
