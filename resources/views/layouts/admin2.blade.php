<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin</title>
  <link rel="icon" type="image/x-icon" href="{{asset('assets/img/icon/favicon.ico')}}">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script src="https://kit.fontawesome.com/682a164d7d.js" crossorigin="anonymous"></script>
  {{-- <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet"> --}}
  @vite(['resources/css/app.css','resources/js/app.js'])


</head>
<body>
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-darker-blue">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
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
