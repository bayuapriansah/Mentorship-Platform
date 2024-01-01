@extends('layouts.admin2')

@section('more-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.45.0/dist/apexcharts.min.css">
@endsection

@section('content')
<div class="container">
    {{-- Admin --}}
    @if(Auth::guard('web')->check())
    <h1 class="text-dark-blue font-medium text-[1.375rem]">
        Dashboard
    </h1>

    {{-- Cards --}}
    <div class="w-max lg:w-full mt-4 flex flex-col lg:flex-row lg:justify-between gap-6">
        <div style="background: linear-gradient(90deg, #D4D9FF 3.41%, #ECEDF3 95.32%);" class="min-w-[180.34px] min-h-[101.63px] p-3 rounded-xl border border-light-blue">
            <h2 class="text-lg text-light-black">
                Total Participants
            </h2>

            <p class="text-[2.125rem] text-end text-dark-blue font-medium">
                {{ $students }}
            </p>
        </div>

        {{-- <div style="background: linear-gradient(90deg, #D4D9FF 3.41%, #ECEDF3 95.32%);" class="min-w-[180.34px] min-h-[101.63px] p-3 rounded-xl border border-light-blue">
            <h2 class="text-lg text-light-black">
                Total Login
            </h2>

            <p class="text-[2.125rem] text-end text-dark-blue font-medium">
                {{ $loginLog }}
            </p>
        </div> --}}

        <div style="background: linear-gradient(90deg, #FBF6CC 3.41%, #FFFEF9 95.32%);" class="min-w-[180.34px] min-h-[101.63px] p-3 rounded-xl border border-light-blue">
            <h2 class="text-lg text-light-black">
                Total Mentors
            </h2>

            <p class="text-[2.125rem] text-end text-dark-blue font-medium">
                {{ $mentors }}
            </p>
        </div>

        <div style="background: linear-gradient(90deg, #CFF8D8 3.41%, #EBF9EE 95.32%);" class="min-w-[180.34px] min-h-[101.63px] p-3 rounded-xl border border-light-blue">
            <h2 class="text-lg text-light-black">
                Total Staffs
            </h2>

            <p class="text-[2.125rem] text-end text-dark-blue font-medium">
                {{ $staffs }}
            </p>
        </div>

        <div style="background: linear-gradient(90deg, #EFCBF8 3.41%, #FCEEFF 95.32%);" class="min-w-[180.34px] min-h-[101.63px] p-3 rounded-xl border border-light-blue">
            <h2 class="text-lg text-light-black">
                Total Active Participants
            </h2>

            <p class="text-[2.125rem] text-end text-dark-blue font-medium">
                {{ $students }}
            </p>
        </div>
    </div>
    {{-- ./Cards --}}

    {{-- Search and Filters --}}
    <div class="mt-14 flex justify-end gap-14">
        <button type="button" class="flex items-center gap-4">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_4295_8096)">
                    <path d="M8.33333 15H11.6667V13.3333H8.33333V15ZM2.5 5V6.66667H17.5V5H2.5ZM5 10.8333H15V9.16667H5V10.8333Z" fill="#E96424"/>
                </g>
                <defs>
                    <clipPath id="clip0_4295_8096">
                    <rect width="20" height="20" fill="white"/>
                    </clipPath>
                </defs>
            </svg>
            <span class="text-sm">
                Filters
            </span>
        </button>

        <div class="relative">
            <input
                id="input-search-participant"
                type="text"
                placeholder="Search Participant name"
                class="w-[403px] h-[42px] pr-12 rounded-xl border border-grey"
                onchange="searchParticipant()"
            >

            <button id="search-btn" type="button" class="absolute top-2 right-4 text-light-brown" onclick="searchParticipant()">
                <i class="fas fa-search fa-lg"></i>
            </button>

            <button id="clear-search-btn" type="button" style="display: none;" class="absolute top-2 right-4 text-light-brown" onclick="clearSearchParticipant()">
                <i class="far fa-times-circle fa-lg"></i>
            </button>
        </div>
    </div>
    {{-- ./Search and Filters --}}

    {{-- Participant --}}
    <div id="participant-detail-container" style="display: none;" class="my-6 justify-center items-center gap-12">
        <p class="text-sm text-darker-blue font-medium">
            Full Name :&nbsp;
            <span class="text-black font-normal">
                Bayu Apriansah
            </span>
        </p>

        <p class="text-sm text-darker-blue font-medium">
            Team Name :&nbsp;
            <span class="text-black font-normal">
                Avengers
            </span>
        </p>

        <p class="text-sm text-darker-blue font-medium">
            Mentorship Track :&nbsp;
            <span class="text-black font-normal">
                Skills
            </span>
        </p>
    </div>
    {{-- ./Participant --}}

    {{-- Charts --}}
    <div class="mt-9 flex flex-wrap justify-between gap-8">
        <div class="w-[408px] min-h-[293px] border border-grey rounded-2xl">
            <h1 class="text-lg text-dark-blue px-5 py-3">
                Participants Login Frequency
            </h1>

            <div id="login-chart" class="max-w-[95%] mt-2"></div>
        </div>

        <div class="w-[408px] min-h-[293px] border border-grey rounded-2xl">
            <h1 class="text-lg text-dark-blue px-5 py-3">
                Message Frequency by Participants
            </h1>

            <div id="message-chart" class="max-w-[95%] mt-2"></div>
        </div>
    </div>
    {{-- ./Charts --}}

    {{-- Table --}}
    <div class="mt-12 px-6 pt-5 pb-6 rounded-2xl border border-grey">
        <table class="w-full">
            <tr class="grid grid-cols-12 items-center">
                <th class="col-span-2">&nbsp;</th>
                <th class="col-span-2 flex justify-center items-center gap-3">
                    <span class="text-sm text-darker-blue font-medium">
                        Entrepreneur
                    </span>
                </th>
                <th class="col-span-2 flex justify-center items-center gap-3">
                    <span class="text-sm text-darker-blue font-medium">
                        Skills
                    </span>
                </th>
                <th class="col-span-2 flex justify-center items-center gap-3">
                    <span class="text-sm text-darker-blue font-medium">
                        Crypto Guides
                    </span>
                </th>
                <th class="col-span-2 flex justify-center items-center gap-3">
                    <span class="text-sm text-darker-blue font-medium">
                        eAuto
                    </span>
                </th>
                <th class="col-span-2 flex justify-center items-center gap-3">
                    <span class="text-sm text-darker-blue font-medium">
                        Web Helpers
                    </span>
                </th>
            </tr>

            <tr class="mt-6 grid grid-cols-12 items-center">
                <td class="col-span-2 text-sm text-darker-blue font-medium">
                    Male
                </td>

                <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] rounded-s-lg text-xs text-center">52</td>
                <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] text-xs text-center">48</td>
                <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] text-xs text-center">79</td>
                <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] text-xs text-center">93</td>
                <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] rounded-e-lg text-xs text-center">114</td>
            </tr>

            <tr class="mt-[0.625rem] grid grid-cols-12 items-center">
                <td class="col-span-2 text-sm text-darker-blue font-medium">
                    Female
                </td>

                <td class="col-span-2 py-[0.625rem] rounded-s-lg text-xs text-center">43</td>
                <td class="col-span-2 py-[0.625rem] text-xs text-center">70</td>
                <td class="col-span-2 py-[0.625rem] text-xs text-center">53</td>
                <td class="col-span-2 py-[0.625rem] text-xs text-center">104</td>
                <td class="col-span-2 py-[0.625rem] rounded-e-lg text-xs text-center">98</td>
            </tr>

            <tr class="mt-[0.625rem] grid grid-cols-12 items-center">
                <td class="col-span-2 text-sm text-darker-blue font-medium">
                    Total
                </td>

                <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] rounded-s-lg text-xs text-center">106</td>
                <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] text-xs text-center">126</td>
                <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] text-xs text-center">137</td>
                <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] text-xs text-center">214</td>
                <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] rounded-e-lg text-xs text-center">235</td>
            </tr>
        </table>
    </div>
    {{-- ./Table --}}
    {{-- ./Admin --}}

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

@section('more-js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.0/dist/apexcharts.min.js"></script>

    <script>
        function searchParticipant() {
            const search = $('#input-search-participant').val()

            if (search.length > 0) {
                $('#search-btn').css('display', 'none')
                $('#clear-search-btn').css('display', 'block')
                $('#participant-detail-container').css('display', 'flex')
            } else {
                $('#search-btn').css('display', 'block')
                $('#clear-search-btn').css('display', 'none')
                $('#participant-detail-container').css('display', 'none')
            }
        }

        function clearSearchParticipant() {
            $('#input-search-participant').val('')
            $('#search-btn').css('display', 'block')
            $('#clear-search-btn').css('display', 'none')
            $('#participant-detail-container').css('display', 'none')
        }

        let loginCounts = @json($loginCounts);
        let loginDates = @json($loginDates);

        let loginChart = new ApexCharts(document.querySelector("#login-chart"), {
            chart: {
                type: 'area',
                height: 240,
            },
            dataLabels: {
                enabled: false
            },
            series: [
                {
                    name: 'Login Frequency',
                    data: loginCounts
                }
            ],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: loginDates
            }
        })

        let messageChart = new ApexCharts(document.querySelector("#message-chart"), {
            chart: {
                type: 'area',
                height: 240,
            },
            dataLabels: {
                enabled: false
            },
            series: [
                {
                    name: 'Message Frequency',
                    data: [1100, 1550, 1400, 1550, 1200, 1600, 1450]
                }
            ],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: [
                    'Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'
                ]
            }
        })

        loginChart.render()
        messageChart.render()
    </script>
@endsection
