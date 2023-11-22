@extends('layouts.index')
@section('content')

<section id="project" class="w-full">
    <div style="background-image: url({{ asset('assets/img/main/black_banner.jpg') }}); background-size: cover;"
        class="max-w-full bg-no-repeat py-80">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid md:grid-cols-2 gap-4 items-center">
                <div class="my-auto p-4">
                    <!-- Added p-4 for padding inside the container -->
                    <h2 class="intelOne text-white font-bold text-4xl leading-11 mb-2">
                        <!-- Added mb-2 for margin-bottom -->
                        <span class="text-primary-light">View Projects</span>
                    </h2>
                    <span class="intelOne text-white font-light text-2xl leading-9">
                        Take a look at the projects available for the skills track of the mentorship program.
                    </span>
                </div>

            </div>
        </div>
    </div>

    {{-- New Body Content --}}

    <div class="max-w-screen-xl my-6 p-6 mx-auto ">
        <h1 class="text-center text-4xl font-bold text-dark-blue">Skills Track</h1>
    </div>
    <div class="max-w-screen-xl my-6 p-6 mx-auto bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        @foreach ($projects as $project)
            <div class="max-w-full p-6 mb-6 bg-white border-2 border-gray-300 hover:border-darker-blue rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="flex space-x-2">
                    <div class="my-auto border-2 border-[#A4AADC] rounded-xl py-1 px-1 mr-2">
                        <img src="{{asset('storage/'.$project->company->logo)}}" class="w-16 h-12 object-cover mx-auto rounded-xl" alt="Logo">
                    </div>
                    <a href="#">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-dark-blue dark:text-white">{{$project->name}}</h5>
                    </a>
                </div>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $project->overview }}</p>

                <div class="flex justify-between">
                    <p class="intelOne text-black text-sm font-normal my-auto">Duration: <span class="font-medium">{{ $project->period }} {{ strtolower($project->name) == "onboarding week" ? 'Week' : ($project->period > 1 ? 'Months' : 'Month') }}</span></p>
                    <a href="{{ isLoggedIn() ? route('projects.show', ['project' => $project->id]) : route('multiLogIn') }}" class="intelOne text-white text-sm font-normal bg-primary border-2 hover:border-primary hover:bg-primary-800 px-3 py-2 rounded-full ">View Project</a>
                </div>
            </div>
        @endforeach
    </div>

    {{-- End New Body Content --}}

    {{-- Body Content 2 --}}
    <div class="max-w-full mx-auto px-6 py-4" id="AiForFuture">
        <div class="max-w-screen-xl mx-auto grid md:grid-cols-4 gap-8 items-start"> <!-- Increased gap for the grid -->
            <div class="relative col-span-3 mx-auto"> <!-- Centering the column content -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="m-0 text-2xl text-dark-blue font-semibold text-justify justify-start">Internship Projects</h2>
                </div>
                @foreach($projects as $project)
                <!-- Slide -->
                <div class="block p-5 rounded-lg shadow-lg hover:border-2 border-2 hover:border-darker-blue border-[#A4AADC] bg-white mx-auto mb-6 overflow-hidden"> <!-- Adjusted max-width and centered the card -->
                    <div class="flex space-x-2">
                        <div class="my-auto border-2 border-[#A4AADC] rounded-xl py-1 px-1 mr-2">
                            <img src="{{asset('storage/'.$project->company->logo)}}" class="w-16 h-12 object-cover mx-auto rounded-xl" alt="Logo">
                        </div>
                        <div class="flex-col">
                            <p class="intelOne text-dark-blue font-bold text-xl leading-7 m-0 overflow-ellipsis overflow-hidden">
                                {{$project->name}}
                            </p>
                            <p class="text-black font-normal text-sm m-0 overflow-ellipsis overflow-hidden">
                                {{$project->company->name}}
                            </p>
                            <div class="pt-2">
                                <p class="text-dark-blue font-normal text-sm bg-lightest-blue text-center rounded-full m-0 w-36 overflow-ellipsis overflow-hidden">
                                    {{ $project->project_domain == 'statistical' ? 'Statistical Data' : ($project->project_domain == 'computer_vision' ? 'Computer Vision' : 'NLP') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="text-grey font-normal text-base mb-2 pt-3 overflow-ellipsis overflow-hidden">
                        {{ $project->overview }}
                    </div>
                    <div class="flex justify-between">
                        <p class="intelOne text-black text-sm font-normal my-auto">Duration: <span class="font-medium">{{ $project->period }} {{ strtolower($project->name) == "onboarding week" ? 'Week' : ($project->period > 1 ? 'Months' : 'Month') }}</span></p>
                        <a href="{{ isLoggedIn() ? route('projects.show', ['project' => $project->id]) : route('multiLogIn') }}" class="intelOne text-white text-sm font-normal bg-darker-blue hover:bg-dark-blue px-3 py-2 rounded-full ">View Project</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</section>

@endsection
