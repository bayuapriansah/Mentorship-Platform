<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simulated Internship</title>
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/icon/favicon.ico')}}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">
    {{-- <link href="{{asset('assets/css/normalize.css')}}" rel="stylesheet"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css','resources/js/app.js'])

    <script src="https://cdn.tiny.cloud/1/gm5482398yg3mbfrvxr3y0bok7hggsq0gervklzy8n1jpj1a/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
    tinymce.init({
        selector: 'textarea#comment', // Replace this CSS selector to match the placeholder element for TinyMCE
        height: 350,
        plugins: 'lists paste',
        menubar: '',
        toolbar: 'undo redo | styleselect | bold italic ',
        automatic_uploads: false,
        paste_as_text: true,
        setup: function (editor) {
        editor.on('change', function () {
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
          border:1px solid black;
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
  </head>
<body>
  <div class="w-full bg-profile-grey">
    <nav class="max-w-[1366px] mx-auto px-16 py-4 grid grid-cols-12 gap-14 grid-flow-col items-center">
      <a href="/" class="col-span-2">
        <img src="{{asset('assets/img/Intel-logo-2022.png')}}" class="" alt="">
      </a>
      <ul class="col-start-4 col-span-5 flex justify-between text-black">
        @if(Route::is('student.allProjects') || Route::is('student.ongoingProjects') || Route::is('student.completedProjects'))
          <li class="text-dark-blue intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/allProjects" class="hover:text-neutral-500">My Projects</a></li>
        @else
          <li class="text-black intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/allProjects" class="hover:text-neutral-500">My Projects</a></li>
        @endif

        @if(Route::is('student.allProjectsAvailable') || Route::is('student.availableProjectDetail'))
          <li class="text-dark-blue intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/allProjectsAvailable" class="hover:text-neutral-500">Internship Projects</a></li>
        @else
          <li class="text-black intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/allProjectsAvailable" class="hover:text-neutral-500">Internship Projects</a></li>
        @endif

        {{-- <li class="text-black intelOne font-light text-sm"><a href="#" class="hover:text-neutral-500">Certificate</a></li> --}}
        @if(Route::is('student.support'))
        <li class="text-dark-blue intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/support" class="hover:text-neutral-500">Support</a></li>
        @else
        <li class="text-black intelOne font-light text-sm"><a href="/profile/{{Auth::guard('student')->user()->id}}/support" class="hover:text-neutral-500">Support</a></li>
        @endif
                
      </ul>

      <div class="col-start-9 col-span-4 flex relative ">
        @if (!Route::is('student.edit') && !Route::is('student.allNotification'))
          @include('layouts.profile.sidebar')
          @else
          <div class="w-full bg-white absolute -top-5 rounded-xl border border-light-blue p-4">
            <div class="grid grid-cols-12 gap-2 grid-flow-col">
              <div class="col-span-2">
                <button type="button" data-modal-target="notification-modal" data-modal-toggle="notification-modal" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300" alt="notification_bel">
                  <svg class="w-6 h-6"  aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                  <span class="sr-only">Notifications Bell</span>
                  @if($notifActivityCount > 0)
                  <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-dark-blue hover:bg-dark-blue border-2 border-white rounded-full -top-2 -right-3">{{ $notifActivityCount }}</div>
                  @endif
                  </button>
              </div>
              <div class="col-span-2">
                <button type="button" data-modal-target="message-modal" data-modal-toggle="message-modal" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300" alt="message">
                  <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                  <span class="sr-only">Notifications Message</span>
                  @if($newMessage > 0)
                  <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-dark-blue hover:bg-dark-blue border-2 border-white rounded-full -top-2 -right-3">{{ $newMessage }}</div>
                  @endif
                </button>
              </div>
              <div class="col-span-2">
                <a href="/profile/{{Auth::guard('student')->user()->id}}/edit" type="button" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                  </svg>
                  <span class="sr-only">Profile edit</span>
                </a>
              </div>
              <div class="col-end-13">
                <form class="inline" method="post" action="{{ route('logout') }}">
                  @csrf
                  <button data-modal-target="popup-logout" data-modal-toggle="popup-logout" type="button" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300" alt="Logout">
                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                  </button>
                  <div id="popup-logout" tabindex="-1" class="fixed z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                    <div class="relative w-3/6 h-full max-w-4xl md:h-auto border-[3px] border-light-blue rounded-2xl">
                        <div class="relative bg-white rounded-xl shadow-2xl">
                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 text-sm p-1.5 ml-auto inline-flex items-center z-30" data-modal-hide="popup-logout">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-6 text-left space-x-4">
                                <img src="{{asset('assets/img/dots-1.png')}}" class="absolute top-0 right-0 w-[233px] h-[108px]" alt="">
                                {{-- <img src="{{asset('assets/img/dots-1.png')}}" class="absolute bottom-0 z-10 left-0 w-[233px] h-[108px]" alt=""> --}}
                                <h3 class="text-dark-blue text-2xl font-medium mb-3 text-left"> Logout?</h3>
                                <div class="relative z-50">
                                  <button data-modal-hide="popup-logout" type="submit" class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-12 py-3 rounded-full shadow-xl">
                                    Yes
                                  </button>
                                  <button data-modal-hide="popup-logout" type="button" class="intelOne  text-dark-blue text-sm font-normal hover:bg-neutral-100 px-12 py-3 rounded-full shadow-xl ">Cancel</button>
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
  <div id="message-modal" data-modal-placement="top-center" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-full h-full max-w-sm md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-5 border-b rounded-t">
                <h3 class="text-xl font-medium text-gray-900">
                    Message Notification
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="message-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                  <div class="max-h-60 overflow-y-auto">
                      {{-- code comment here --}}
                    @if($newMessage > 0)
                        @foreach ($dataMessages as $dataMessage)
                              @if ($dataMessage->read_message != 1 && $dataMessage->project_section )
                              <a href="
                              {{ route('student.readComment',
                              [$dataMessage->student_id,
                              $dataMessage->project_id,
                              $dataMessage->project_section_id,
                              $dataMessage->id]) }}" class="mb-2 text-sm font-normal text-dark-blue">
                              <div id="toast-message-cta" class="w-full max-w-xs text-gray-500 bg-white rounded-lg shadow mt-2 p-4 border border-blue-100 hover:bg-blue-100" role="alert">
                                  <div class="flex">
                                      <div class="ml-3 text-sm font-normal">
                                          <span class="mb-1 text-sm font-semibold text-dark-blue">New Message : </span><p>
                                          <span class="mb-1 text-sm font-normal text-blue-700">In Task {{ $dataMessage->project_section->section }} - {{ $dataMessage->project_section->title }} </span>
                                          <div class="mb-1 text-sm font-normal text-blue-300">{{ $dataMessage->project_section->updated_at }}</div>
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
    <div id="notification-modal" data-modal-placement="top-center" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-sm md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-medium text-gray-900">
                        Notification
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="notification-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                @php
                $mergedNotifs = $newActivityNotifs->merge($notifNewTasks)->sortByDesc('updated_at')->all();
                // $sortedNotifs = collect($mergedNotifs)->sortByDesc('created_at')->all();
                @endphp
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                  <div class="max-h-60 overflow-y-auto">
                      {{-- code comment here --}}
                      {{-- {{ $notifActivityCount}} --}}
                    @if($notifActivityCount > 0)
                        @foreach($mergedNotifs as $notification)
                              @if($notification->type == 'grade')
                                @if($notification->grade == !NULL)
                                  @if($notification->grade->readornot != 1)
                                    <a href="
                                    {{ route('student.readActivity',
                                    [$notification->grade->submission->student_id,
                                    $notification->grade->submission->project_id,
                                    $notification->grade->submission->section_id,
                                    $notification->grade->submission->id]) }}
                                    " class="mb-2 text-sm font-normal text-dark-blue">
                                      <div id="toast-message-cta" class="w-full max-w-xs text-gray-500 bg-white rounded-lg shadow mt-2 p-2 hover:bg-blue-100" role="alert">
                                        <div class="flex">
                                            <div class="ml-3 text-sm font-normal">
                                              <span class="mb-1 text-sm font-semibold text-dark-blue">New notification for grading. <p> Result Task : {{ $notification->grade->submission->projectSection->title }}</span>
                                                <p>
                                                  Hi {{$student->first_name}} {{$student->last_name}},
                                                    @if($notification->grade->status == 0)
                                                        {{ 'Sorry but you need to revise the Task' }}
                                                    @elseif($notification->grade->status == 1)
                                                        {{ 'Great you Complete the Task' }}
                                                    @else
                                                        {{ 'Nothing' }}
                                                    @endif.
                                              <div class="mb-2 text-sm font-normal text-blue-300">{{ $notification->grade->updated_at }}</div>
                                            </div>
                                        </div>
                                      </div>
                                    </a>
                                  @endif
                                @endif
                              @elseif($notification->type == 'notification')
                                @if($notification->project)
                                  @if($notification->status != 'deldraft')
                                    @if($notification->project->institution_id == $student->institution_id || $notification->project->institution_id == NULL)
                                      @if(optional($notification->read_notification)->firstWhere(['student_id' => $student->id, 'notifications_id' => $notification->id]) == NULL)
                                        <a href="{{ route('student.readActivityTask',[$student->id,$notification->project_id,$notification->id]) }}" class="mb-2 text-sm font-normal text-dark-blue">
                                          <div id="toast-message-cta" class="w-full max-w-xs text-gray-500 bg-white rounded-lg shadow mt-2 p-2 hover:bg-blue-100" role="alert">
                                            <div class="flex">
                                                <div class="ml-3 text-sm font-normal">
                                                  <span class="mb-1 text-sm font-semibold text-dark-blue">New Project available in {{ $notification->project->name }} .</span>
                                                  <p>
                                                  <div class="mb-2 text-sm font-normal text-blue-300">{{ $notification->updated_at }}</div>
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
                    <a href="/profile/{{$student->id}}/allNotification" class="text-[#6973C6] text-xs">View All Notifications</a>
                  </div>
                </div>
                
            </div>
        </div>
      </div>
  <main class="bg-profile-grey ">
    @yield('content')
  </main>

      <!-- Footer -->
      <footer class="bg-lightest-blue dark:bg-gray-900">
        <div class="max-w-screen-xl mx-auto px-6 py-4" id="AiForFuture">
            <div class="p-4 py-6 lg:py-8">
                <div class="mb-6 md:mb-0">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('assets/img/Digitalreadiness-logo 1.svg') }}"
                            class="object-scale-down h-15 w-auto py-4" alt="Intel Digital Readiness Logo" />
                    </a>
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-12 items-start">
                <div class="relative">
                    <p class="text-justify drop-shadow-md shadow-blue-600/50">Intel technologies may require enabled
                        hardware, software, or service activation. No product or component can be absolutely secure.
                        Your costs and results may vary. Performance varies by use, configuration, and other factors.
                        See our complete legal <a
                            href="https://edc.intel.com/content/www/us/en/products/performance/benchmarks/overview/#GUID-26B0C71C-25E9-477D-9007-52FCA56EE18C"
                            class="text-black font-bold">Notices and Disclaimers</a>. Intel is committed to respecting
                        human rights and avoiding complicity in human rights abuses. See <a
                            href="https://www.intel.com/content/www/us/en/policy/policy-human-rights.html"
                            class="text-black font-bold">Intel’s Global Human Rights Principles</a>. Intel’s products
                        and software are intended only to be used in applications that do not cause or contribute to a
                        violation of an internationally recognized human right.</p>
                </div>
                <div class="relative">
                    <div class="md:flex col-start-8 col-span-4">
                        <div class="mb-6 md:mb-0 md:flex-1">
                            <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Info</h2>
                            <ul class="text-gray-600 dark:text-gray-400 font-medium">
                                <li class="mb-4">
                                    <a href="/#AiForFuture" data-tooltip-target="Industry-Partners-hover"
                                        data-tooltip-trigger="hover" class="hover:underline">For Industry Partners</a>
                                </li>
                                <li class="mb-4">
                                    <a href="/#AiForFuture" data-tooltip-target="Industry-Partners-hover"
                                        data-tooltip-trigger="hover" class="hover:underline">For Institution</a>
                                </li>
                                <li>
                                    <a href="/#AiForFuture" data-tooltip-target="Industry-Partners-hover"
                                        data-tooltip-trigger="hover" class="hover:underline">For Students</a>
                                </li>
                            </ul>
                        </div>
                        <div class="mb-6 md:mb-0 md:flex-1">
                            <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Support</h2>
                            <ul class="text-gray-600 dark:text-gray-400 font-medium">
                                <li class="mb-4">
                                    {{-- <a href="/#AiForFuture" data-tooltip-target="Industry-Partners-hover"
                                        data-tooltip-trigger="hover" class="hover:underline ">About Us</a> --}}
                                    <a href="/#AiForFuture" class="hover:underline ">About Us</a>
                                </li>
                                <li class="mb-4">
                                    <a href="{{ route('faq') }}" class="hover:underline">FAQs</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact') }}" class="hover:underline">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                        <div class="mb-6 md:mb-0 md:flex-1">
                            <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
                            <ul class="text-gray-600 dark:text-gray-400 font-medium">
                                <li class="mb-4">
                                    <a href="{{ route('privacy-policy') }}" class="hover:underline">Privacy
                                        Policy</a>
                                </li>
                                <li>
                                    <a href="{{ route('terms-of-use') }}" class="hover:underline">Terms &amp;
                                        Conditions</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-6 border-black border-t-2 sm:mx-auto lg:my-8" />
            <div class="sm:flex sm:items-center sm:justify-between">
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ date('Y') }} <a
                        href="/" class="hover:underline">Simulated Internship</a>. All Rights Reserved.
                </span>
                {{-- <div class="flex mt-4 space-x-6 sm:justify-center sm:mt-0">
          <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
              <span class="sr-only">Facebook page</span>
          </a>
          <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
              <span class="sr-only">Instagram page</span>
          </a>
          <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
              <span class="sr-only">Twitter page</span>
          </a>
          <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
              <span class="sr-only">GitHub account</span>
          </a>
          <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z" clip-rule="evenodd" /></svg>
              <span class="sr-only">Dribbble account</span>
          </a>
      </div> --}}
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
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
      $( document ).ready(function() {
          $('[data-toggle="flag"]').tooltip().css({});
      });
    </script>
    <script>
      function certificate(){
        console.log('tes');
      }
    </script>
    
    @yield('more-js')
  </body>
</html>
