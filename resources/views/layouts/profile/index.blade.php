<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simulated Internship</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/icon/favicon.ico') }}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    {{-- <link href="{{asset('assets/css/normalize.css')}}" rel="stylesheet"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tiny.cloud/1/gm5482398yg3mbfrvxr3y0bok7hggsq0gervklzy8n1jpj1a/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#comment', // Replace this CSS selector to match the placeholder element for TinyMCE
            height: 350,
            plugins: 'lists paste',
            menubar: '',
            toolbar: 'undo redo | styleselect | bold italic ',
            automatic_uploads: false,
            paste_as_text: true,
            setup: function(editor) {
                editor.on('change', function() {
                    tinymce.triggerSave();
                });
            }
        });
    </script>
    {{-- font --}}
    <link href="https://fonts.cdnfonts.com/css/intelone-display" rel="stylesheet">
    <meta name="theme-color" content="#712cf9">
    <style>
        .tooltip-inner {
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 0.375rem;
            border: 1px solid black;
            background-color: white
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        /* Hide the default scrollbar */
        ::-webkit-scrollbar {
            width: 0.5rem;
            height: 0.5rem;
        }

        ::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 9999px;
        }

        ::-webkit-scrollbar-track {
            background-color: rgba(0, 0, 0, 0.1);
        }

        /* Show the custom scrollbar on hover */
        ::-webkit-scrollbar-thumb:hover {
            background-color: rgba(0, 0, 0, 0.3);
        }
    </style>
    <!-- Custom styles for this template -->

    @yield('more-css')
</head>

<body>
    <div class="w-full bg-white">
        <nav class="max-w-[1366px] mx-auto px-16 py-4 grid grid-cols-12 gap-14 grid-flow-col items-center">
            <a href="{{ route('index') }}" class="col-span-2">
                <img src="{{ asset('assets/img/logo/AIGlobalImpactFestival_Logo.svg') }}" alt="Impact Festival Logo"
                    class="scale-125">
            </a>
            <ul class="col-start-4 col-span-5 flex justify-end gap-[3.5rem] text-black">
                <li class="text-black font-light text-sm">
                    <a href="{{ route('index') }}">
                        Home
                    </a>
                </li>

                <li class="text-black font-light text-sm">
                    <a href="#">
                        Internal Document
                    </a>
                </li>

                <li class="text-black font-light text-sm">
                    <a href="{{ route('projects.support') }}">
                        Support
                    </a>
                </li>

                {{-- @if (Route::is('student.allProjects') || Route::is('student.ongoingProjects') || Route::is('student.completedProjects'))
          <li class="text-dark-blue intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/allProjects" class="hover:text-neutral-500">My Projects</a></li>
        @else
          <li class="text-black intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/allProjects" class="hover:text-neutral-500">My Projects</a></li>
        @endif

        @if (Route::is('student.allProjectsAvailable') || Route::is('student.availableProjectDetail'))
          <li class="text-dark-blue intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/allProjectsAvailable" class="hover:text-neutral-500">Internship Projects</a></li>
        @else
          <li class="text-black intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/allProjectsAvailable" class="hover:text-neutral-500">Internship Projects</a></li>
        @endif --}}
                {{-- <li class="text-black intelOne font-light text-sm"><a href="#" class="hover:text-neutral-500">Certificate</a></li> --}}
                {{-- @if (Route::is('student.support'))
        <li class="text-dark-blue intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/support" class="hover:text-neutral-500">Support</a></li>
        @else
        <li class="text-black intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/support" class="hover:text-neutral-500">Support</a></li>
        @endif --}}

            </ul>

            <div class="col-start-9 col-span-4 flex relative ">
                @if (!Route::is('student.edit', 'student.allNotification', 'participant.projects.create', 'participant.projects.add-task'))
                    @include('layouts.profile.sidebar')
                @else
                    <div class="w-full bg-white absolute -top-5 rounded-xl border border-light-blue p-4">
                        <div class="grid grid-cols-12 gap-2 grid-flow-col">
                            <div class="col-span-2">
                                <button type="button" data-modal-target="notification-modal"
                                    data-modal-toggle="notification-modal"
                                    class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300"
                                    alt="notification_bel">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor"
                                        stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="sr-only">Notifications Bell</span>
                                    @if ($notifActivityCount > 0)
                                        <div
                                            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-dark-blue hover:bg-dark-blue border-2 border-white rounded-full -top-2 -right-3">
                                            {{ $notifActivityCount }}</div>
                                    @endif
                                </button>
                            </div>
                            <div class="col-span-2">
                                <button type="button" data-modal-target="message-modal"
                                    data-modal-toggle="message-modal"
                                    class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300"
                                    alt="message">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor"
                                        stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="sr-only">Notifications Message</span>
                                    @if ($newMessage > 0)
                                        <div
                                            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-dark-blue hover:bg-dark-blue border-2 border-white rounded-full -top-2 -right-3">
                                            {{ $newMessage }}</div>
                                    @endif
                                </button>
                            </div>
                            <div class="col-span-2">
                                <a href="/profile/{{ Auth::guard('student')->user()->id }}/edit" type="button"
                                    class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z">
                                        </path>
                                    </svg>
                                    <span class="sr-only">Profile edit</span>
                                </a>
                            </div>
                            <div class="col-end-13">
                                <form class="inline" method="post" action="{{ route('logout') }}">
                                    @csrf
                                    <button data-modal-target="popup-logout" data-modal-toggle="popup-logout"
                                        type="button"
                                        class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300"
                                        alt="Logout">
                                        <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                    <div id="popup-logout" tabindex="-1"
                                        class="fixed z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                                        <div
                                            class="relative w-3/6 h-full max-w-4xl md:h-auto border-[3px] border-light-blue rounded-2xl">
                                            <div class="relative bg-white rounded-xl shadow-2xl">
                                                <button type="button"
                                                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 text-sm p-1.5 ml-auto inline-flex items-center z-30"
                                                    data-modal-hide="popup-logout">
                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <div class="p-6 text-left space-x-4">
                                                    <img src="{{ asset('assets/img/dots-1.png') }}"
                                                        class="absolute top-0 right-0 w-[233px] h-[108px]"
                                                        alt="">
                                                    {{-- <img src="{{asset('assets/img/dots-1.png')}}" class="absolute bottom-0 z-10 left-0 w-[233px] h-[108px]" alt=""> --}}
                                                    <h3 class="text-dark-blue text-2xl font-medium mb-3 text-left">
                                                        Logout?</h3>
                                                    <div class="relative z-50">
                                                        <button data-modal-hide="popup-logout" type="submit"
                                                            class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-12 py-3 rounded-full shadow-xl">
                                                            Yes
                                                        </button>
                                                        <button data-modal-hide="popup-logout" type="button"
                                                            class="intelOne  text-dark-blue text-sm font-normal hover:bg-neutral-100 px-12 py-3 rounded-full shadow-xl ">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </nav>
    </div>
    {{-- Modals --}}
    {{-- Message Modal --}}
    <div id="message-modal" data-modal-placement="top-center" tabindex="-1"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-sm md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-medium text-gray-900">
                        Message Notification
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-hide="message-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <div class="max-h-60 overflow-y-auto">
                        {{-- code comment here --}}
                        @if ($newMessage > 0)
                            @foreach ($dataMessages as $dataMessage)
                                @if ($dataMessage->read_message != 1 && $dataMessage->project_section)
                                    <a href="
                              {{ route('student.readComment', [
                                  $dataMessage->student_id,
                                  $dataMessage->project_id,
                                  $dataMessage->project_section_id,
                                  $dataMessage->id,
                              ]) }}"
                                        class="mb-2 text-sm font-normal text-dark-blue">
                                        <div id="toast-message-cta"
                                            class="w-full max-w-xs text-gray-500 bg-white rounded-lg shadow mt-2 p-4 border border-blue-100 hover:bg-blue-100"
                                            role="alert">
                                            <div class="flex">
                                                <div class="ml-3 text-sm font-normal">
                                                    <span class="mb-1 text-sm font-semibold text-dark-blue">New Message
                                                        : </span>
                                                    <p>
                                                        <span class="mb-1 text-sm font-normal text-blue-700">In Task
                                                            {{ $dataMessage->project_section->section }} -
                                                            {{ $dataMessage->project_section->title }} </span>
                                                    <div class="mb-1 text-sm font-normal text-blue-300">
                                                        {{ $dataMessage->project_section->updated_at }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                                {{-- END HERE --}}
                            @endforeach
                        @else
                            {{ 'No New Message' }}
                        @endif
                    </div>
                    {{-- <div class="border-t border-light-blue ">
                    <a href="#" class="text-[#6973C6] text-xs">View All Message</a>
                    <a href="/profile/{{$student->id}}/allNotification" class="text-[#6973C6] text-xs">View All Message</a>
                  </div> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- Notification Modal --}}
    <div id="notification-modal" data-modal-placement="top-center" tabindex="-1"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-sm md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-medium text-gray-900">
                        Notification
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-hide="notification-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                @php
                    $mergedNotifs = $newActivityNotifs
                        ->merge($notifNewTasks)
                        ->sortByDesc('updated_at')
                        ->all();
                    // $sortedNotifs = collect($mergedNotifs)->sortByDesc('created_at')->all();
                @endphp
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <div class="max-h-60 overflow-y-auto">
                        {{-- code comment here --}}
                        {{-- {{ $notifActivityCount}} --}}
                        @if ($notifActivityCount > 0)
                            @foreach ($mergedNotifs as $notification)
                                @if ($notification->type == 'grade')
                                    @if ($notification->grade == !null)
                                        @if ($notification->grade->readornot != 1)
                                            <a href="
                                    {{ route('student.readActivity', [
                                        $notification->grade->submission->student_id,
                                        $notification->grade->submission->project_id,
                                        $notification->grade->submission->section_id,
                                        $notification->grade->submission->id,
                                    ]) }}
                                    "
                                                class="mb-2 text-sm font-normal text-dark-blue">
                                                <div id="toast-message-cta"
                                                    class="w-full max-w-xs text-gray-500 bg-white rounded-lg shadow mt-2 p-2 hover:bg-blue-100"
                                                    role="alert">
                                                    <div class="flex">
                                                        <div class="ml-3 text-sm font-normal">
                                                            <span class="mb-1 text-sm font-semibold text-dark-blue">New
                                                                notification for grading. <p> Result Task :
                                                                    {{ $notification->grade->submission->projectSection->title }}</span>
                                                            <p>
                                                                Hi {{ $student->first_name }}
                                                                {{ $student->last_name }},
                                                                @if ($notification->grade->status == 0)
                                                                    {{ 'Sorry but you need to revise the Task' }}
                                                                @elseif($notification->grade->status == 1)
                                                                    {{ 'Great you Complete the Task' }}
                                                                @else
                                                                    {{ 'Nothing' }}
                                                                @endif.
                                                            <div class="mb-2 text-sm font-normal text-blue-300">
                                                                {{ $notification->grade->updated_at }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    @endif
                                @elseif($notification->type == 'notification')
                                    @if ($notification->project)
                                        @if ($notification->status != 'deldraft')
                                            @if (
                                                $notification->project->institution_id == $student->institution_id ||
                                                    $notification->project->institution_id == null)
                                                @if (optional($notification->read_notification)->firstWhere([
                                                        'student_id' => $student->id,
                                                        'notifications_id' => $notification->id,
                                                    ]) == null)
                                                    <a href="{{ route('student.readActivityTask', [$student->id, $notification->project_id, $notification->id]) }}"
                                                        class="mb-2 text-sm font-normal text-dark-blue">
                                                        <div id="toast-message-cta"
                                                            class="w-full max-w-xs text-gray-500 bg-white rounded-lg shadow mt-2 p-2 hover:bg-blue-100"
                                                            role="alert">
                                                            <div class="flex">
                                                                <div class="ml-3 text-sm font-normal">
                                                                    <span
                                                                        class="mb-1 text-sm font-semibold text-dark-blue">New
                                                                        Project available in
                                                                        {{ $notification->project->name }} .</span>
                                                                    <p>
                                                                    <div
                                                                        class="mb-2 text-sm font-normal text-blue-300">
                                                                        {{ $notification->updated_at }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        @else
                            {{ 'No Notification' }}
                        @endif
                    </div>
                    <div class="border-t border-light-blue ">
                        <a href="/profile/{{ $student->id }}/allNotification" class="text-[#6973C6] text-xs">View
                            All Notifications</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <main class="bg-profile-grey ">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#e9e9e9] border-[#838383] text-black">
        <div class="max-w-screen-xl mx-auto px-6 py-4" id="AiForFuture">
            <div class="p-4 py-6 lg:py-8">
                <div class="mb-6 md:mb-0">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('assets/img/logo/footer-logo.svg') }}" class="tab:scale-125"
                            alt="Intel Digital Readiness Logo" />
                    </a>
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-12 items-start">
                <div class="relative">
                    <p class="text-justify">Intel technologies may require enabled
                        hardware, software, or service activation. // No product or component can be absolutely secure.
                        // Your costs and results may vary. // Performance varies by use, configuration, and other
                        factors.
                        // See our complete legal <a
                            href="https://edc.intel.com/content/www/us/en/products/performance/benchmarks/overview/#GUID-26B0C71C-25E9-477D-9007-52FCA56EE18C"
                            class="text-primary font-bold hover:underline">Notices and Disclaimers</a>. // Intel is
                        committed to respecting
                        human rights and avoiding complicity in human rights abuses. See <a
                            href="https://www.intel.com/content/www/us/en/policy/policy-human-rights.html"
                            class="text-primary font-bold hover:underline">Intel’s Global Human Rights Principles</a>.
                        Intel’s products
                        and software are intended only to be used in applications that do not cause or contribute to a
                        violation of an internationally recognized human right.</p>
                </div>
                <div class="relative tab:-top-10">
                    <div class="md:flex col-start-8 col-span-4">
                        <div class="mb-6 md:mb-0 md:flex-1">
                            <h2 class="text-sm font-semibold text-darker-blue">
                                INFO
                            </h2>

                            <ul class="mt-4 flex flex-col gap-2">
                                <li>
                                    <a href="{{ route('track-info.entrepreneur-track') }}" class="text-sm font-normal hover:underline">
                                        Entrepreneur Track
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('track-info.skills-track') }}" class="text-sm font-normal hover:underline">
                                        Skills Track
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="mb-6 md:mb-0 md:flex-1">
                            <h2 class="text-sm font-semibold text-darker-blue">
                                SUPPORT
                            </h2>

                            <ul class="mt-4 flex flex-col gap-2">
                                <li>
                                    <a href="{{ route('faq') }}" class="text-sm font-normal hover:underline">
                                        FAQs
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('contact') }}" class="text-sm font-normal hover:underline">
                                        Contact Us
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="mb-6 md:mb-0 md:flex-1">
                            <h2 class="text-sm font-semibold text-darker-blue">
                                LEGAL
                            </h2>

                            <ul class="mt-4 flex flex-col gap-2">
                                <li>
                                    <a href="{{ route('privacy-policy') }}"
                                        class="text-sm font-normal hover:underline">
                                        Privacy Policies
                                </li>

                                <li>
                                    <a href="{{ route('terms-of-use') }}"
                                        class="text-sm font-normal hover:underline">
                                        Terms &amp; Conditions
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-6 border-black sm:mx-auto lg:my-8" />
            <div class="sm:flex sm:items-center sm:justify-between">
                <span class="text-sm text-center tab:text-left">&copy; {{ date('Y') }} <a
                        href="{{ url('/') }}" class="hover:underline">Mentorship Platform</a>. All
                </span>

            </div>
        </div>
    </footer>

    {{-- <footer class="w-full bg-lightest-blue relative z-30">
    <div class="max-w-[1366px] mx-auto px-16 pt-24 pb-16 mb-0 grid grid-cols-12 gap-11 grid-flow-col container">
      <div class="col-span-4">
        <img src="{{asset('assets/img/Intel-logo-2022.png')}}" alt="">
        <p class="text-grey font-normal text-[10px] pt-2 ">Intel technologies may require enabled hardware, software or service activation. // No product or component can be absolutely secure. // Your costs and results may vary. // Performance varies by use, configuration and other factors. // See our complete legal <a href="https://edc.intel.com/content/www/us/en/products/performance/benchmarks/overview/#GUID-26B0C71C-25E9-477D-9007-52FCA56EE18C" class="text-black">Notices and Disclaimers</a>. // Intel is committed to respecting human rights and avoiding complicity in human rights abuses. See <a href="https://www.intel.com/content/www/us/en/policy/policy-human-rights.html" class="text-black">Intel's Global Human Rights Principles</a>. Intel's products and software are intended only to be used in applications that do not cause or contribute to a violation of an internationally recognised human right.</p>
      </div>
      <div class="col-start-6 col-span-2 flex flex-col">
        <ul class="text-dark-blue text-xs font-normal">
          <li class="pb-3"><a href="/#AiForFuture">For Industry Partners</a></li>
          <li class="pb-3"><a href="/#AiForFuture">For Institution</a></li>
          <li class="pb-3"><a href="/#AiForFuture">For Students</a></li>
        </ul>
      </div>
      <div class="col-start-8 col-span-2 flex flex-col">
        <ul class="text-dark-blue text-xs font-normal">
          <li class="pb-3"><a href="/#AiForFuture">About Us</a></li>
          <li class="pb-3"><a href="/faq">FAQs</a></li>
          <li class="pb-3">
            @if (Auth::guard('student')->check())
              <a data-modal-target="popup-contact-student" data-modal-toggle="popup-contact-student" type="button" class="cursor-pointer">Contact Us</a>
              <div id="popup-contact-student" tabindex="-1" class="fixed z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                <div class="relative w-3/6 h-full max-w-4xl md:h-auto border-[3px] border-light-blue rounded-2xl">
                    <div class="relative bg-white rounded-xl shadow-2xl">
                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 text-sm p-1.5 ml-auto inline-flex items-center z-30" data-modal-hide="popup-contact-student">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-6 text-left space-x-4">
                          <h3 class="text-dark-blue text-2xl font-medium mb-3 text-left">Please visit <a href="/profile/{{Auth::guard('student')->user()->id}}/support" class="underline hover:text-darker-blue">support page</a> to contact platform admin.</h3>
                        </div>
                    </div>
                </div>
              </div>
            @else
              <a href="/contact">Contact Us</a>
            @endif
          </li>
        </ul>
      </div>
      <div class="col-start-10 col-span-2 flex flex-col">
        <ul class="text-dark-blue intelOne text-xs font-normal">
          <li class="pb-3"><a href="/terms-of-use">Terms & Conditions</a></li>
          <li class="pb-3"><a href="/privacy-policy">Privacy Policies</a></li>
        </ul>
      </div>
    </div>
    <div class="w-full border-t border-grey">
      <div class="max-w-[1366px] mx-auto px-16 py-4 grid grid-cols-12 gap-11 grid-flow-col ">
        <div class="col-span-5 my-auto ">
          <p class="text-grey font-normal text-xs pt-2 intelOne">© 2023 Intel Simulated Internships. All rights reserved.</p>
        </div>
      </div>
    </div>

  </footer> --}}

    {{-- @php
      $top = exec("top -bn1 | grep 'Cpu(s)'");
      preg_match_all("/\s+([0-9\.]+)%\s+id/", $top, $cores);
      $cores = $cores[1];
      foreach ($cores as $index => $usage) {
        echo "Core " . ($index + 1) . ": " . $usage . "%<br>";
      }
  @endphp --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.1/flowbite.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.1/flowbite.min.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js">
    </script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="flag"]').tooltip().css({});
        });
    </script>
    <script>
        function certificate() {
            console.log('tes');
        }
    </script>

    @yield('more-js')
</body>

</html>
