<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin</title>
  <link rel="icon" type="image/x-icon" href="{{asset('assets/img/icon/favicon.ico')}}">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script src="https://kit.fontawesome.com/682a164d7d.js" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/simplebar@latest/dist/simplebar.min.js"></script>
  {{-- <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet"> --}}
  @vite(['resources/css/app.css','resources/js/app.js'])


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
        $notifications = getNotificationSubmission();
        $NotificationForAdmin = $notifications['totalNotificationAdmin'];
        $DataSubmissionNotifications = $notifications['submissionNotifications'];
      @endphp

      <div class="w-full bg-profile-grey mx-auto py-11 px-10 relative">
        <div class="flex flex-row-reverse">
          <div class="space-x-9">
            <button type="button" data-modal-target="message-modal" data-modal-toggle="message-modal" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300" alt="notification_bel">
              <svg class="w-6 h-6"  aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
              <span class="sr-only">Notifications Bell</span>
              @if ($NotificationForAdmin > 0)
              <div class="absolute inline-flex items-center justify-center w-6 h-6 text-[10px] font-bold text-white bg-dark-blue hover:bg-dark-blue border-2 border-white rounded-full -top-2 -right-3">{{ $NotificationForAdmin > 99 ? "99+" : $NotificationForAdmin}}</div>
              @endif

            </button>

            <a href="/dashboard/messages" class="relative inline-flex items-center text-sm font-medium text-center text-light-blue rounded-lg hover:text-dark-blue focus:ring-4 focus:outline-none focus:ring-blue-300" alt="message">
              <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
              <span class="sr-only">Notifications Message</span>
              @if (getCommentMessages()->count() > 0)
              <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-dark-blue hover:bg-dark-blue border-2 border-white rounded-full -top-2 -right-3">{{ getCommentMessages()->count() }}</div>
              @endif
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
                <a href="{{ route('index') }}" class="flex items-center">
                    <img src="{{ asset('assets/img/Digitalreadiness-logo 1.svg') }}" class="h-8 md:h-10 mr-3" alt="Digital Readiness Logo" />
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center gap-4 ml-3">
                <div>
                    <button type="button" class="relative inline-flex p-2 text-center rounded-lg">
                    <i class="flex fa-regular fa-bell hover:text-darker-blue cursor-pointer"></i>
                    <span class="sr-only">Notifications Bell</span>
                    <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -right-2 dark:border-gray-900">20</div>
                    </button>
                </div>
                <div>
                    <button type="button" class="relative inline-flex p-2 text-center rounded-lg">
                    <i class="flex fa-regular fa-message hover:text-darker-blue cursor-pointer"></i>
                    <span class="sr-only">Notifications Message</span>
                    <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -right-2 dark:border-gray-900">20</div>
                    </button>
                </div>
                <div>
                    <button type="button" class="relative inline-flex p-2 text-center rounded-lg">
                    <i class="flex fa-regular fa-user hover:text-darker-blue cursor-pointer"></i>
                    </button>
                </div>
                <div class="flex items-center ml-3">
                <div>
                    <i class="flex fa-solid fa-arrow-right-from-bracket hover:text-darker-blue cursor-pointer"></i>
                </div>
                </div>
            </div>
        </div>
        </div>
    </nav>
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-darker-blue border-r border-darker-blue sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-darker-blue dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="#" class="group flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100">
                    <span class="flex-1 ml-3 text-right whitespace-nowrap text-white group-hover:text-darker-blue">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" class="group flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100">
                    <span class="flex-1 ml-3 text-right whitespace-nowrap text-white group-hover:text-darker-blue">Students</span>
                </a>
            </li>
            <li>
                <a href="#" class="group flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100">
                    <span class="flex-1 ml-3 text-right whitespace-nowrap text-white group-hover:text-darker-blue">Staff</span>
                </a>
            </li>
            <li>
                <a href="#" class="group flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100">
                    <span class="flex-1 ml-3 text-right whitespace-nowrap text-white group-hover:text-darker-blue">Institutions & Partner</span>
                </a>
            </li>
            <li>
                <a href="#" class="group flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100">
                    <span class="flex-1 ml-3 text-right whitespace-nowrap text-white group-hover:text-darker-blue">Testimonials</span>
                </a>
            </li>
            <li>
                <a href="#" class="group flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100">
                    <span class="flex-1 ml-3 text-right whitespace-nowrap text-white group-hover:text-darker-blue">Projects</span>
                </a>
            </li>
        </ul>
        </div>
    </aside>
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            <h3 class="text-dark-blue font-medium text-xl mb-4">Dashboard</h3>
            <div class="grid grid-cols-2 tab:grid-cols-3 hd:grid-cols-5 gap-4 mb-4">
                <div class="flex flex-col justify-between p-2 h-28 rounded border border-light-blue bg-gradient-to-r from-light-blue to-white">
                    <p class="font-medium hd:text-md laptop:text-lg">Total Students</p>
                    <p class="text-dark-blue tab:text-xl hd:text-2xl laptop:text-4xl self-end">{{$students}}</p>
                </div>
                <div class="flex flex-col justify-between p-2 h-28 rounded border border-light-blue bg-gradient-to-r from-[#FBF6CC] to-white">
                    <p class="font-medium hd:text-md laptop:text-lg">Total Supervisors</p>
                    <p class="text-dark-blue tab:text-xl hd:text-2xl laptop:text-4xl self-end">{{$mentors}}</p>
                </div>
                <div class="flex flex-col justify-between p-2 h-28 rounded border border-light-blue bg-gradient-to-r from-[#FBF6CC] to-white">
                    <p class="font-medium hd:text-md laptop:text-lg">Total Staff Members</p>
                    <p class="text-dark-blue tab:text-xl hd:text-2xl laptop:text-4xl self-end">{{$staffs}}</p>
                </div>
                <div class="flex flex-col justify-between p-2 h-28 rounded border border-light-blue bg-gradient-to-r from-[#CFF8D8] to-white">
                    <p class="font-medium hd:text-md laptop:text-lg">Projects Enrolled</p>
                    <p class="text-dark-blue tab:text-xl hd:text-2xl laptop:text-4xl self-end">{{$eProjects}}</p>
                </div>
                <div class="flex flex-col justify-between p-2 h-28 rounded border border-light-blue bg-gradient-to-r from-[#EFCBF8] to-white">
                    <p class="font-medium hd:text-md laptop:text-lg">Total Partners</p>
                    <p class="text-dark-blue tab:text-xl hd:text-2xl laptop:text-4xl self-end">{{$companies}}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="flex flex-col justify-between p-2 h-28 rounded border border-light-blue bg-gradient-to-r from-light-blue to-white">
                    <p class="font-medium text-sm hd:text-md laptop:text-lg">Already completed 3 Projects + Onboarding</p>
                    <p class="text-dark-blue tab:text-xl hd:text-2xl laptop:text-4xl self-end">{{$student_complete_all}}</p>
                </div>
                <div class="flex flex-col justify-between p-2 h-28 rounded border border-light-blue bg-gradient-to-r from-light-blue to-white">
                    <p class="font-medium text-sm hd:text-md laptop:text-lg">Already completed 2 Projects + Onboarding</p>
                    <p class="text-dark-blue tab:text-xl hd:text-2xl laptop:text-4xl self-end">{{$student_complete_3}}</p>
                </div>
            </div>
            <div class="flex flex-col justify-between p-2 h-48 rounded bg-gray-50 dark:bg-gray-800">
                <p class="font-bold text-2xl">Share on LinkedIn</p>
                <p class="text-xl">Using LinkedIn API v2</p>
                <a href="" type="button" class="text-white bg-[#1E3050] hover:bg-[#1E3050]/90 focus:ring-4 focus:outline-none focus:ring-[#1E3050]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#1E3050]/55 mr-2 mb-2 gap-2">
                    <i class="fa-brands fa-linkedin"></i>
                Sign in with LinkedIn
                </a>
            </div>
            {{-- <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                        </svg>
                    </p>
                </div>
                <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                        </svg>
                    </p>
                </div>
                <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                        </svg>
                    </p>
                </div>
                <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                        </svg>
                    </p>
                </div>
            </div> --}}

        </div>
    </div>


</body>
</html>
