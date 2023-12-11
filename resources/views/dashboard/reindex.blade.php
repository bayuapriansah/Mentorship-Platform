@extends('layouts.readmin')
@section('content')
<div class="container">
    @if(Auth::guard('web')->check())
    <h3 class="text-dark-blue font-medium text-xl">Dashboard</h3>
    <div class="flex justify-between space-x-7 mt-4">
        <div
            class="border border-light-blue bg-gradient-to-r from-light-blue to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-medium text-[15px]  text-left">Total Supervisors</p>
            <p class="text-right text-dark-blue text-3xl">{{$mentors}}</p>
        </div>
        <div
            class="border border-light-blue bg-gradient-to-r from-[#FBF6CC] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-medium text-[15px]  text-left">Total Student</p>
            <p class="text-right text-dark-blue text-3xl">{{$students}}</p>
        </div>
        <div
            class="border border-light-blue bg-gradient-to-r from-[#FBF6CC] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-medium text-[15px]  text-left">Total Staff Members</p>
            <p class="text-right text-dark-blue text-3xl">{{$staffs}}</p>
        </div>

        <div
            class="border border-light-blue bg-gradient-to-r from-[#CFF8D8] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-medium text-[15px]  text-left">Projects Enrolled</p>
            <p class="text-right text-dark-blue text-3xl">{{$eProjects}}</p>
        </div>

        <div
            class="border border-light-blue bg-gradient-to-r from-[#EFCBF8] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-medium text-[15px]  text-left">Total Partners</p>
            <p class="text-right text-dark-blue text-3xl">{{$companies}}</p>
        </div>
    </div>

    <div class="flex justify-between space-x-7 mt-4">
        <div
            class="border border-light-blue bg-gradient-to-r from-light-blue to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <a href="{{route('dashboard.student.completeAll')}}">
                <p class="font-medium text-[15px]  text-left">Final Presentation: To be Assigned</p>
                <p class="text-right text-dark-blue text-3xl">{{$student_complete_all}}</p>
            </a>
        </div>
        <div
            class="border border-light-blue bg-gradient-to-r from-[#EFCBF8] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <a href="{{route('dashboard.student.complete3')}}">
                <p class="font-medium text-[15px]  text-left">Students Approaching Final Presentation</p>
                <p class="text-right text-dark-blue text-3xl">{{$student_complete_3}}</p>
            </a>
        </div>
        <div
            class="border border-light-blue bg-gradient-to-r from-[#FBF6CC] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <a href="{{route('dashboard.student.finalPresentationOngoing')}}">
                <p class="font-medium text-[15px]  text-left">Final Presentation: Ongoing</p>
                <p class="text-right text-dark-blue text-3xl">{{ $student_final_ongoing }}</p>
            </a>
        </div>
        <div
            class="border border-light-blue bg-gradient-to-r from-[#CFF8D8] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <a href="{{route('dashboard.student.finalPresentationComplete')}}">
                <p class="font-medium text-[15px]  text-left">Final Presentation: Completed</p>
                <p class="text-right text-dark-blue text-3xl">{{ $student_final_complete }}</p>
            </a>
        </div>
    </div>
    @elseif(Auth::guard('mentor')->check())
    <div class="flex justify-between items-center">
        @if (Auth::guard('mentor')->user()->institution_id != 0)
        <div class="space-y-7">
            <h3 class="text-dark-blue font-medium text-xl">Hi {{Auth::guard('mentor')->user()->first_name}}
                {{Auth::guard('mentor')->user()->last_name}}</h3>
            <p class="font-normal text-lg">Welcome to the Simulated Internship Platform Supervisor Dashboard.</p>
        </div>
        <img src="/storage/{{Auth::guard('mentor')->user()->institution->logo}}" class="w-80 h-44 object-scale-down"
            alt="">
        @else
        <div class="space-y-7">
            <h3 class="text-dark-blue font-medium text-xl">Hi {{Auth::guard('mentor')->user()->first_name}}
                {{Auth::guard('mentor')->user()->last_name}}</h3>
            <p class="font-normal text-lg">Welcome to the Simulated Internship Platform Staff Member Dashboard.</p>
        </div>
        <img src="{{asset('assets/img/SL2-Registered-Logo.png')}}" class="w-80 h-44 object-scale-down" alt="">
        @endif
    </div>
    <div class="flex justify-between space-x-7 my-4">
        <div
            class="border border-light-blue bg-gradient-to-r from-light-blue to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-normal text-[18px] text-left">Total Students</p>
            <p class="text-right text-dark-blue text-3xl">{{$students}}</p>
        </div>

        <div
            class="border border-light-blue bg-gradient-to-r from-[#FBF6CC] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-normal text-[18px] text-left">Assigned To Me</p>
            <p class="text-right text-dark-blue text-3xl">{{$assign_students}}</p>
        </div>

        <div
            class="border border-light-blue bg-gradient-to-r from-[#CFF8D8] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-normal text-[18px] text-left">Total {{Auth::guard('mentor')->user()->institution_id != 0 ?
                'Supervisors': 'Staff Members'}}</p>
            <p class="text-right text-dark-blue text-3xl">{{$mentors}}</p>
        </div>

        <div
            class="border border-light-blue bg-gradient-to-r from-[#EFCBF8] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-normal text-[18px] text-left">Total Submissions</p>
            <p class="text-right text-dark-blue text-3xl">{{$student_submissions}}</p>
        </div>
    </div>

    <div class="flex justify-between space-x-7 mt-4">
        <div
            class="border border-light-blue bg-gradient-to-r from-light-blue to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <a href="{{route('dashboard.student.completeAll')}}">
                <p class="font-medium text-[15px]  text-left">Final Presentation: To be Assigned</p>
                <p class="text-right text-dark-blue text-3xl">{{$student_complete_all}}</p>
            </a>
        </div>
        <div
            class="border border-light-blue bg-gradient-to-r from-[#EFCBF8] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <a href="{{route('dashboard.student.complete3')}}">
                <p class="font-medium text-[15px]  text-left">Students Approaching Final Presentation</p>
                <p class="text-right text-dark-blue text-3xl">{{$student_complete_3}}</p>
            </a>
        </div>
        <div
            class="border border-light-blue bg-gradient-to-r from-[#FBF6CC] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <a href="{{route('dashboard.student.finalPresentationOngoing')}}">
                <p class="font-medium text-[15px]  text-left">Final Presentation: Ongoing</p>
                <p class="text-right text-dark-blue text-3xl">{{ $student_final_ongoing }}</p>
            </a>
        </div>
        <div
            class="border border-light-blue bg-gradient-to-r from-[#CFF8D8] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <a href="{{route('dashboard.student.finalPresentationComplete')}}">
                <p class="font-medium text-[15px]  text-left">Final Presentation: Completed</p>
                <p class="text-right text-dark-blue text-3xl">{{ $student_final_complete }}</p>
            </a>
        </div>
    </div>

    {{-- <h3 class="text-dark-blue font-medium text-xl mt-12">Tutorial</h3> --}}
    @elseif(Auth::guard('customer')->check())
    <div class="flex justify-between items-center">
        <div class="space-y-7">
            <h3 class="text-dark-blue font-medium text-xl">Hi {{Auth::guard('customer')->user()->first_name}}
                {{Auth::guard('customer')->user()->last_name}}</h3>
            <p class="font-normal text-lg">Welcome to the Simulated Internship Platform Customer Dashboard.</p>
        </div>
        <img src="/storage/{{Auth::guard('customer')->user()->company->logo}}" class="w-80 h-44 object-scale-down"
            alt="">
    </div>

    <div class="flex justify-between space-x-7 my-4">
        <div
            class="border border-light-blue bg-gradient-to-r from-light-blue to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-normal text-[18px] text-left">Total Internships</p>
            <p class="text-right text-dark-blue text-3xl">{{$internshipsTotal}}</p>
        </div>

        <div
            class="border border-light-blue bg-gradient-to-r from-[#FBF6CC] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-normal text-[18px] text-left">Ongoing Internships</p>
            <p class="text-right text-dark-blue text-3xl">{{$internshipsOngoing}}</p>
        </div>

        <div
            class="border border-light-blue bg-gradient-to-r from-[#CFF8D8] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-normal text-[18px] text-left">Total Customers</p>
            <p class="text-right text-dark-blue text-3xl">{{$customerTotal}}</p>
        </div>

        <div
            class="border border-light-blue bg-gradient-to-r from-[#EFCBF8] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-normal text-[18px] text-left">Total Submissions</p>
            <p class="text-right text-dark-blue text-3xl">{{$student_submissions}}</p>
        </div>
    </div>
    <h3 class="text-dark-blue font-medium text-xl mt-12">Tutorial</h3>

    @endif
</div>
@endsection
