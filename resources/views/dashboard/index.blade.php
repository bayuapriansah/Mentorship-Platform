@extends('layouts.admin2')
@section('content')
<div class="container">
    <h3 class="text-dark-blue font-medium text-xl">Dashboard</h3>
    <div class="flex justify-between space-x-7 mt-4">
        <div class="border border-light-blue bg-gradient-to-r from-light-blue to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-normal text-[18px] text-left">Total Student</p>
            <p class="text-right text-dark-blue text-3xl">{{$students}}</p>
        </div>

        <div class="border border-light-blue bg-gradient-to-r from-[#FBF6CC] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-normal text-[18px] text-left">Total Supervisor</p>
            <p class="text-right text-dark-blue text-3xl">{{$mentors}}</p>
        </div>

        <div class="border border-light-blue bg-gradient-to-r from-[#CFF8D8] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-normal text-[18px] text-left">Projects Enrolled</p>
            <p class="text-right text-dark-blue text-3xl">{{$eProjects}}</p>
        </div>

        <div class="border border-light-blu bg-gradient-to-r from-[#EFCBF8] to-white py-4 pl-4 pr-10 w-full rounded-xl">
            <p class="font-normal text-[18px] text-left">Total Partner</p>
            <p class="text-right text-dark-blue text-3xl">{{$companies}}</p>
        </div>
    </div>
</div>
@endsection