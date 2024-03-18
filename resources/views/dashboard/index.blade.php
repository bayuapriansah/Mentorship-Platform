@extends('layouts.admin2')
@section('title', 'Dashboard')
@section('more-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.45.0/dist/apexcharts.min.css">

    <style>
        .select2.select2-container {
            width: 403px !important;
        }

        .select2.select2-container .select2-selection {
            border: 1px solid #ccc;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            height: 34px;
            margin-bottom: 15px;
            padding-right: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
        }

        .select2.select2-container .select2-selection .select2-selection__rendered {
            color: #333;
            line-height: 32px;
            padding-right: 33px;
        }

        .select2.select2-container .select2-selection .select2-selection__arrow {
            background: #f8f8f8;
            border-left: 1px solid #ccc;
            -webkit-border-radius: 0 3px 3px 0;
            -moz-border-radius: 0 3px 3px 0;
            border-radius: 0 3px 3px 0;
            height: 32px;
            width: 33px;
        }

        .select2.select2-container.select2-container--open .select2-selection.select2-selection--single {
            background: #f8f8f8;
        }

        .select2.select2-container.select2-container--open .select2-selection.select2-selection--single .select2-selection__arrow {
            -webkit-border-radius: 0 3px 0 0;
            -moz-border-radius: 0 3px 0 0;
            border-radius: 0 3px 0 0;
        }

        .select2.select2-container.select2-container--open .select2-selection.select2-selection--multiple {
            border: 1px solid #34495e;
        }

        .select2.select2-container .select2-selection--multiple {
            height: auto;
            min-height: 34px;
        }

        .select2.select2-container .select2-selection--multiple .select2-search--inline .select2-search__field {
            margin-top: 0;
            height: 32px;
        }

        .select2.select2-container .select2-selection--multiple .select2-selection__rendered {
            display: block;
            padding: 0 4px;
            line-height: 29px;
        }

        .select2.select2-container .select2-selection--multiple .select2-selection__choice {
            background-color: #f8f8f8;
            border: 1px solid #ccc;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            margin: 4px 4px 0 0;
            padding: 0 6px 0 22px;
            height: 24px;
            line-height: 24px;
            font-size: 12px;
            position: relative;
        }

        .select2.select2-container .select2-selection--multiple .select2-selection__choice .select2-selection__choice__remove {
            position: absolute;
            top: 0;
            left: 0;
            height: 22px;
            width: 22px;
            margin: 0;
            text-align: center;
            color: #e74c3c;
            font-weight: bold;
            font-size: 16px;
        }

        .select2-container .select2-dropdown {
            background: transparent;
            border: none;
            margin-top: -5px;
        }

        .select2-container .select2-dropdown .select2-search {
            padding: 0;
        }

        .select2-container .select2-dropdown .select2-search input {
            outline: none !important;
            border: 1px solid #34495e !important;
            border-bottom: none !important;
            padding: 4px 6px !important;
        }

        .select2-container .select2-dropdown .select2-results {
            padding: 0;
        }

        .select2-container .select2-dropdown .select2-results ul {
            background: #fff;
            border: 1px solid #34495e;
        }

        .select2-container .select2-dropdown .select2-results ul .select2-results__option--highlighted[aria-selected] {
            background-color: #3498db;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        {{-- Non Customer --}}
        @if (!Auth::guard('customer')->check())
            {{-- Header --}}
            @if (!Auth::guard('mentor')->check())
                <h1 class="text-dark-blue font-medium text-[1.375rem]">
                    Dashboard
                </h1>
            @else
                <div class="flex justify-between gap-4">
                    <div class="space-y-2">
                        <h1 class="text-dark-blue font-medium text-[1.375rem]">
                            Hello, {{ Auth::guard('mentor')->user()->first_name }}!
                        </h1>
                        <p class="text-lg">
                            Welcome to the {{ Auth::guard('mentor')->user()->getTitle() }} Dashboard.
                        </p>
                    </div>

                    <img src="{{ asset('/assets/img/SL2-Registered-Logo.png') }}" class="h-[82px] w-auto" alt="SL2 Logo">
                </div>
            @endif
            {{-- ./Header --}}

            {{-- Cards --}}
            <div
                class="w-max lg:w-full mt-10 flex flex-col lg:flex-row @if (!Auth::guard('mentor')->check()) lg:justify-between @endif gap-6">
                <div style="background: linear-gradient(90deg, #D4D9FF 3.41%, #ECEDF3 95.32%);"
                    class="min-w-[180.34px] lg:min-w-[23.5%] min-h-[101.63px] p-3 rounded-xl border border-light-blue">
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

                @if (!Auth::guard('mentor')->check())
                    <div style="background: linear-gradient(90deg, #FBF6CC 3.41%, #FFFEF9 95.32%);"
                        class="min-w-[180.34px] lg:min-w-[23.5%] min-h-[101.63px] p-3 rounded-xl border border-light-blue">
                        <h2 class="text-lg text-light-black">
                            Total Mentors
                        </h2>

                        <p class="text-[2.125rem] text-end text-dark-blue font-medium">
                            {{ $mentors }}
                        </p>
                    </div>

                    <div style="background: linear-gradient(90deg, #CFF8D8 3.41%, #EBF9EE 95.32%);"
                        class="min-w-[180.34px] lg:min-w-[23.5%] min-h-[101.63px] p-3 rounded-xl border border-light-blue">
                        <h2 class="text-lg text-light-black">
                            Total Staffs
                        </h2>

                        <p class="text-[2.125rem] text-end text-dark-blue font-medium">
                            {{ $staffs }}
                        </p>
                    </div>
                @endif

                <div style="background: linear-gradient(90deg, #EFCBF8 3.41%, #FCEEFF 95.32%);"
                    class="min-w-[180.34px] lg:min-w-[23.5%] min-h-[101.63px] p-3 rounded-xl border border-light-blue">
                    <h2 class="text-lg text-light-black">
                        @if (Auth::guard('mentor')->check())
                            Total Assigned Participants
                        @else
                            Total Active Participants
                        @endif
                    </h2>

                    <p class="text-[2.125rem] text-end text-dark-blue font-medium">
                        @if (Auth::guard('mentor')->check())
                            {{ $assignStudents }}
                        @else
                            {{ $activeStudents }}
                        @endif
                    </p>
                </div>
            </div>
            {{-- ./Cards --}}

            {{-- Search --}}
            <div class="mt-14 flex justify-end">
                <select id="select-participant"></select>
            </div>
            {{-- ./Search --}}

            {{-- Participant --}}
            <div id="search-result-container" style="display: none;" class="my-6 justify-center items-center gap-12">
                <p class="text-sm text-darker-blue font-medium">
                    Full Name :&nbsp;
                    <span id="search-result-name" class="text-black font-normal">
                        Bayu Apriansah
                    </span>
                </p>

                <p class="text-sm text-darker-blue font-medium">
                    Team Name :&nbsp;
                    <span id="search-result-team-name" class="text-black font-normal">
                        Avengers
                    </span>
                </p>

                <p class="text-sm text-darker-blue font-medium">
                    Mentorship Track :&nbsp;
                    <span id="search-result-track" class="text-black font-normal">
                        Skills
                    </span>
                </p>
            </div>
            {{-- ./Participant --}}

            {{-- Charts --}}
            <div class="mt-9 flex flex-wrap justify-between">
                <div class="w-[48%] min-h-[293px] border border-grey rounded-2xl">
                    <h1 class="text-lg text-dark-blue px-5 py-3">
                        Participants Login Frequency
                    </h1>

                    <div id="login-chart" class="max-w-[95%] mt-2"></div>
                </div>

                <div class="w-[48%] min-h-[293px] border border-grey rounded-2xl flex flex-col">
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
                                Entrepreneur Track
                            </span>
                        </th>
                        <th class="col-span-2 flex justify-center items-center gap-3">
                            <span class="text-sm text-darker-blue font-medium">
                                Skills Track
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

                        <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] rounded-s-lg text-xs text-center">
                            {{ $sexCount['entrepreneur_track']['male'] }}
                        </td>

                        <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] text-xs text-center">
                            {{ $sexCount['skills_track']['male'] }}
                        </td>

                        <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] text-xs text-center">
                            {{ $sexCount['crypto_guides']['male'] }}
                        </td>

                        <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] text-xs text-center">
                            {{ $sexCount['eauto']['male'] }}
                        </td>

                        <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] rounded-e-lg text-xs text-center">
                            {{ $sexCount['web_helpers']['male'] }}
                        </td>
                    </tr>

                    <tr class="mt-[0.625rem] grid grid-cols-12 items-center">
                        <td class="col-span-2 text-sm text-darker-blue font-medium">
                            Female
                        </td>

                        <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] rounded-s-lg text-xs text-center">
                            {{ $sexCount['entrepreneur_track']['female'] }}
                        </td>

                        <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] text-xs text-center">
                            {{ $sexCount['skills_track']['female'] }}
                        </td>

                        <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] text-xs text-center">
                            {{ $sexCount['crypto_guides']['female'] }}
                        </td>

                        <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] text-xs text-center">
                            {{ $sexCount['eauto']['female'] }}
                        </td>

                        <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] rounded-e-lg text-xs text-center">
                            {{ $sexCount['web_helpers']['female'] }}
                        </td>
                    </tr>

                    <tr class="mt-[0.625rem] grid grid-cols-12 items-center">
                        <td class="col-span-2 text-sm text-darker-blue font-medium">
                            Total
                        </td>

                        <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] rounded-s-lg text-xs text-center">
                            {{-- {{ $sexCount['entrepreneur_track']['total'] }} --}}
                            {{ $sexCount['entrepreneur_track']['male']+$sexCount['entrepreneur_track']['female'] }}
                        </td>

                        <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] text-xs text-center">
                            {{-- {{ $sexCount['skills_track']['total'] }} --}}
                            {{ $sexCount['skills_track']['male']+$sexCount['skills_track']['female'] }}

                        </td>

                        <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] text-xs text-center">
                            {{-- {{ $sexCount['crypto_guides']['total'] }} --}}
                            {{ $sexCount['crypto_guides']['male'] + $sexCount['crypto_guides']['female'] }}
                        </td>

                        <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] text-xs text-center">
                            {{-- {{ $sexCount['eauto']['total'] }} --}}
                            {{ $sexCount['eauto']['male'] + $sexCount['eauto']['female'] }}
                        </td>

                        <td class="col-span-2 py-[0.625rem] bg-[#F9F9F9] rounded-e-lg text-xs text-center">
                            {{-- {{ $sexCount['web_helpers']['total'] }} --}}
                            {{ $sexCount['web_helpers']['male']+$sexCount['web_helpers']['female'] }}
                        </td>
                    </tr>
                </table>
            </div>
            {{-- ./Table --}}
            {{-- ./Non Customer --}}

            {{-- Customer --}}
        @else
            <div class="flex justify-between items-center">
                <div class="space-y-7">
                    <h3 class="text-dark-blue font-medium text-xl">Hi {{ Auth::guard('customer')->user()->first_name }}
                        {{ Auth::guard('customer')->user()->last_name }}</h3>
                    <p class="font-normal text-lg">Welcome to the Mentorship Program Platform Customer Dashboard.</p>
                </div>
                <img src="/storage/{{ Auth::guard('customer')->user()->company->logo }}"
                    class="w-80 h-44 object-scale-down" alt="">
            </div>

            <div class="flex justify-between space-x-7 my-4">
                <div
                    class="border border-light-blue bg-gradient-to-r from-light-blue to-white py-4 pl-4 pr-10 w-full rounded-xl">
                    <p class="font-normal text-[18px] text-left">Total Internships</p>
                    <p class="text-right text-dark-blue text-3xl">{{ $internshipsTotal }}</p>
                </div>

                <div
                    class="border border-light-blue bg-gradient-to-r from-[#FBF6CC] to-white py-4 pl-4 pr-10 w-full rounded-xl">
                    <p class="font-normal text-[18px] text-left">Ongoing Internships</p>
                    <p class="text-right text-dark-blue text-3xl">{{ $internshipsOngoing }}</p>
                </div>

                <div
                    class="border border-light-blue bg-gradient-to-r from-[#CFF8D8] to-white py-4 pl-4 pr-10 w-full rounded-xl">
                    <p class="font-normal text-[18px] text-left">Total Customers</p>
                    <p class="text-right text-dark-blue text-3xl">{{ $customerTotal }}</p>
                </div>

                <div
                    class="border border-light-blue bg-gradient-to-r from-[#EFCBF8] to-white py-4 pl-4 pr-10 w-full rounded-xl">
                    <p class="font-normal text-[18px] text-left">Total Submissions</p>
                    <p class="text-right text-dark-blue text-3xl">{{ $student_submissions }}</p>
                </div>
            </div>
            <h3 class="text-dark-blue font-medium text-xl mt-12">Tutorial</h3>
        @endif
        {{-- ./Customer --}}
    </div>
@endsection

@section('more-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.0/dist/apexcharts.min.js"></script>

    <script>
        let loginCounts = @json($loginCounts);
        let loginDates = @json($loginDates);
        let messageCounts = @json($messageCounts);
        let messageDates = @json($messageDates);

        let loginChart = new ApexCharts(document.querySelector("#login-chart"), {
            chart: {
                type: 'area',
                height: 300,
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: 'Login Frequency',
                data: loginCounts
            }],
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
                height: 300,
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: 'Message Frequency',
                data: messageCounts
            }],
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
                categories: messageDates
            }
        })

        loginChart.render()
        messageChart.render()

        $('#select-participant').select2({
            allowClear: true,
            placeholder: 'Search Participant Name',

            ajax: {
                url: "{{ url('/api/dashboard/participants') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        search: params.term,
                        @if (auth()->user()->institution_id != null)
                            @if (auth()->user()->institution_id)
                                mentor: '{{ Auth::guard('mentor')->user()->id }}'
                            @else
                                staff: '{{ Auth::guard('mentor')->user()->id }}'
                            @endif
                        @endif
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: false
            },
        });

        $('#select-participant').on('select2:select', function(e) {
            const data = e.params.data;

            if (data.id) {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('/api/dashboard/participants') }}/" + data.id,
                    dataType: 'json',
                    success: function(response) {
                        $('#search-result-name').text(
                            `${response.participant.first_name} ${response.participant.last_name}`);
                        $('#search-result-team-name').text(`${response.participant.team_name ?? '-'}`);
                        $('#search-result-track').text(response.track);

                        loginChart.updateSeries([{
                            name: 'Login Frequency',
                            data: response.loginCounts
                        }])

                        messageChart.updateSeries([{
                            name: 'Message Frequency',
                            data: response.messageCounts
                        }])

                        $('#search-result-container').css('display', 'flex');
                    },
                });
            }
        });

        $('#select-participant').on('select2:unselect', function(e) {
            $('#search-result-container').css('display', 'none');

            loginChart.updateSeries([{
                name: 'Login Frequency',
                data: loginCounts
            }])

            messageChart.updateSeries([{
                name: 'Message Frequency',
                data: messageCounts
            }])
        })
    </script>
@endsection
