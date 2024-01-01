<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin</title>
  <link rel="icon" type="image/x-icon" href="{{asset('assets/img/icon/favicon.ico')}}">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">
  @vite(['resources/css/app.css','resources/js/app.js'])

  <script src="https://kit.fontawesome.com/f845b2d56c.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
  <script src="https://cdn.tiny.cloud/1/gm5482398yg3mbfrvxr3y0bok7hggsq0gervklzy8n1jpj1a/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    const imageUploadHandler = (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{ route("dashboard.project.image-upload") }}');

            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken); // Set CSRF token for Laravel

            // console.log('CSRF Token:', csrfToken); // Log the CSRF token

            xhr.upload.onprogress = (e) => {
            progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
            if (xhr.status === 403) {
            reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
            return;
            }

            if (xhr.status < 200 || xhr.status>= 300) {
                reject('HTTP Error: ' + xhr.status);
                return;
                }

                const json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                reject('Invalid JSON: ' + xhr.responseText);
                return;
                }

                resolve(json.location);
                // console.log(json.location);
                // console.log(resolve(json.location));
                };

                xhr.onerror = () => {
                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                };

                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());

                xhr.send(formData);
                });

      tinymce.init({
        selector: 'textarea#problem',
        height: 350,
        plugins: 'media image lists',
        menubar: 'file edit insert view format table tools help',
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullis | image',
        images_upload_url: '{{ route("dashboard.project.image-upload") }}',
        images_upload_handler: imageUploadHandler,
        automatic_uploads: true,
        paste_as_text: true,
        setup: function(editor) {
            editor.on('GetContent', function(e) {
                var content = e.content;
                var websiteUrl = window.location.origin; // Gets the base URL of the website

                var newContent = content.replace(/data-mce-src="\.\.\/\.\.\/\.\.\/storage\/uploads\//g, 'data-mce-src="' + websiteUrl + '/storage/uploads/');
                e.content = newContent;
            });
        },
      });

    tinymce.init({
        selector: 'textarea#sectionDesc', // Replace this CSS selector to match the placeholder element for TinyMCE
        height: 350,
        plugins: 'media image lists',
        menubar: 'file edit insert view format table tools help',
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist',
        images_upload_url: 'postAcceptor.php',
        automatic_uploads: false,
        paste_as_text: true
    });
    tinymce.init({
        selector: 'textarea#sectionDescDisable', // Replace this CSS selector to match the placeholder element for TinyMCE
        height: 300,
        readonly : true
    });

    tinymce.init({
        selector: 'textarea#comment', // Replace this CSS selector to match the placeholder element for TinyMCE
        height: 350,
        plugins: 'lists',
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

    .dropdown:hover .dropdown-menu {
        display: block;
        /* transform: translate(1247px, 750px); */
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

  @yield('more-css')
</head>
<body>
  <div class="max-w-[2000px] mx-auto">
    <div class="flex">
      <div class="w-1/5 min-h-screen bg-gradient-to-b from-darker-blue to-dark-blue items-center py-9 px-14 justify-center" >
        <div class="flex-col">
          <a href="{{ route('index') }}">
            <img src="{{asset('assets/img/intellogo2022_1.png')}}" class="w-[188px] h-[53px] object-scale-down mx-auto" alt="">
          </a>
        </div>
        <div class="flex flex-row-reverse py-14 text-white text-right">
          @include('layouts.admin.sidebar2')
        </div>
      </div>

      @php
        // $notifications = getNotificationSubmission();
        // $NotificationForAdmin = $notifications['totalNotificationAdmin'];
        // $DataSubmissionNotifications = $notifications['submissionNotifications'];
      @endphp

      <div class="w-full bg-white mx-auto py-11 px-10 relative">
        <div class="flex flex-row-reverse">
          <div class="space-x-9">
            {{-- <button type="button" data-modal-target="message-modal" data-modal-toggle="message-modal" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300" alt="notification_bel"> --}}
            <button type="button" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300" alt="notification_bel">
              <svg class="w-6 h-6"  aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
              <span class="sr-only">Notifications Bell</span>
              {{-- @if ($NotificationForAdmin > 0)
              <div class="absolute inline-flex items-center justify-center w-6 h-6 text-[10px] font-bold text-white bg-dark-blue hover:bg-dark-blue border-2 border-white rounded-full -top-2 -right-3">{{ $NotificationForAdmin > 99 ? "99+" : $NotificationForAdmin}}</div>
              @endif --}}

            </button>

            <a href="/dashboard/messages" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300" alt="message">
              <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
              <span class="sr-only">Notifications Message</span>
              {{-- @if (getCommentMessages()->count() > 0)
              <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-dark-blue hover:bg-dark-blue border-2 border-white rounded-full -top-2 -right-3">{{ getCommentMessages()->count() }}</div>
              @endif --}}
            </a>

            @if (Auth::guard('web')->check())
              <a href="/dashboard/profile/{{Auth::guard('web')->user()->id}}/edit" type="button" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300">
            @elseif (Auth::guard('mentor')->check())
              <a href="/dashboard/profile/{{Auth::guard('mentor')->user()->id}}/edit" type="button" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300">
            @elseif (Auth::guard('customer')->check())
              <a href="/dashboard/profile/{{Auth::guard('customer')->user()->id}}/edit" type="button" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300">
            @endif
              <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
              </svg>
              <span class="sr-only">Profile edit</span>
            </a>

            <form class="inline pl-10" method="post" action="{{ route('logout') }}">
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
                            <h3 class="text-dark-blue text-2xl font-medium mb-3 text-left">Are you sure you want to Logout?</h3>
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
        <div class="pt-12">
          @yield('content')
        </div>
      </div>
      {{-- message modal --}}
      {{-- <div id="message-modal" data-modal-placement="top-center" tabindex="-1" class="fixed top-0 left-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full" style="left: 23%;">
        <div class="relative w-full h-full max-w-sm md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-medium text-gray-900">
                        Notification
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="message-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="pl-6 pb-3 space-y-6">
                  <div class="max-h-60 overflow-y-auto mt-3">
                      @if ($NotificationForAdmin > 0)
                      @php
                          $numbercountpls = 1;
                      @endphp
                      @foreach ($DataSubmissionNotifications as $submissionNotification)
                          @if ($submissionNotification->student != NULL && (Auth::guard('web')->check() || (Auth::guard('mentor')->user() != NULL && ($submissionNotification->student->staff_id == Auth::guard('mentor')->user()->id || $submissionNotification->student->mentor_id == Auth::guard('mentor')->user()->id)) || Auth::guard('customer')->check()))
                              <a href="{{ route('dashboard.submission.singleSubmission.readNotification', [$submissionNotification->project_id,$submissionNotification->id,$submissionNotification->student->id]) }}" class="mb-2 text-sm font-normal text-dark-blue">
                                  <div id="toast-message-cta" class="relative w-full max-w-xs bg-white rounded-lg shadow text-gray-400 mt-2 p-2 hover:bg-blue-100" role="alert">
                                  <div class="flex justify-between items-center">
                                      <div class="ml-3 mr-4 text-sm font-normal">
                                      <span class="mb-1 text-sm font-semibold text-dark-blue">There is New Submission, From : {{ $submissionNotification->student->first_name }} {{ $submissionNotification->student->last_name }} at Section ({{ $submissionNotification->projectSection->title }})</span>
                                      <p>
                                      <div class="mb-2 text-sm font-normal text-blue-300">{{ $submissionNotification->updated_at }}</div>
                                      </div>
                                      <a href="#" class="absolute top-0 right-0 mr-2 mt-2 inline-flex items-center justify-center rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:ring focus:ring-gray-300" onclick="this.parentElement.parentElement.style.display='none';">
                                      <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                          <path fill-rule="evenodd" d="M6.293 6.293a1 1 0 011.414 0L10 8.586l2.293-2.293a1 1 0 011.414 1.414L11.414 10l2.293 2.293a1 1 0 01-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 10 6.293 7.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                      </svg>
                                      </a>
                                  </div>
                                  </div>
                              </a>
                              @php
                                  $numbercountpls++;
                              @endphp
                          @endif
                      @endforeach
                  @else
                      {{ 'No Notification' }}
                  @endif
                  </div>
                </div>
              </div>
      </div> --}}
      {{-- end message modal --}}
    </div>
  </div>


  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.1/flowbite.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.1/flowbite.min.js"></script> --}}
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  @yield('more-js')
  <script>
      const openToggle = (id)=>{
        // document.getElementById(`dropdownHover${id}`).classList.add('hidden');
        document.getElementById(`dropdownHover${id}`).classList.remove('hidden');

      if ( document.getElementById(`dropdownHover${id}`).classList.contains('hidden') )

      document.getElementById(`dropdownHover${id}`).classList.remove('hidden');
    }
</script>
</body>
