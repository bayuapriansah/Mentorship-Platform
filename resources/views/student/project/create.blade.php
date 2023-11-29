@extends('layouts.profile.index')

@section('content')
<div class="pt-14 pb-48 px-16 bg-white">
    <div class="py-6 px-11 bg-[#fafafa] border border-grey rounded-xl">
        {{-- Page Title --}}
        <h1 class="font-medium text-darker-blue text-[1.35rem]">
            <a href="{{ route('student.allProjects', ['student' => auth()->user()->id]) }}" class="hover:underline">
                My Project
            </a>
            <span class="ml-2 mr-4">></span>
            Add Project
        </h1>

        <div class="w-full tab:w-[641px] mt-7 mx-auto flex flex-col items-center">
            {{-- Project Name --}}
            <input
                type="text"
                placeholder="Project Name *"
                class="w-full h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none"
            >

            {{-- Project Domain and Duration --}}
            <div class="w-full mt-5 grid grid-cols-7 items-center gap-3">
                <select class="col-span-4 p-2.5 bg-white border border-grey text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block">
                    <option class="hover:bg-lightest-blue">Computer Vision (CV)</option>
                    <option class="hover:bg-lightest-blue">Natural Language Processing (NLP)</option>
                    <option class="hover:bg-lightest-blue">Machine Learning (ML)</option>
                </select>

                <input
                    type="text"
                    value="10 Weeks"
                    class="col-span-3 h-12 px-3 py-2 bg-[#D8D8D8] border border-grey rounded-lg focus:outline-none"
                    disabled
                >
            </div>

            {{-- Intel Corp --}}
            <input
                type="text"
                value="Intel Corp"
                class="mt-5 w-full h-12 px-3 py-2 bg-[#D8D8D8] border border-grey rounded-lg focus:outline-none"
                disabled
            >

            {{-- Description --}}
            <textarea
                rows="10"
                placeholder="- Problem Statement, Project Objective, or Use Case Description&#13;&#10;- Model Type&#13;&#10;- Current Performance Metrics&#13;&#10;- Summary of Future Goals/Expectations"
                class="w-full mt-5 px-3 py-2 border border-grey rounded-lg focus:outline-none"
            ></textarea>

            {{-- Overview --}}
            <input
                type="text"
                placeholder="Write a 2 - 3 sentence description of your project."
                class="mt-5 w-full h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none"
            >

            {{-- Logo --}}
            <div class="w-full mt-4 flex flex-col gap-2">
                <h2 class="font-medium text-darker-blue text-xl">
                    Logo Project (Optional)
                </h2>

                <div id="input-logo-trigger" class="w-full h-20 bg-white border border-dashed border-grey flex justify-center items-center cursor-pointer">
                    logo_project.jpg
                </div>

                <input type="file" id="input-logo" accept="image/*" hidden>
            </div>

            {{-- Datasets --}}
            <div class="w-full mt-4 flex flex-col gap-2">
                <h2 class="font-medium text-darker-blue text-xl">
                    Add Datasets
                    <span class="text-red-500">*</span>
                </h2>

                <input
                    type="url"
                    placeholder="Add a cloud link (Google Drive, SharePoint, etc.)"
                    class="w-full h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none"
                >
            </div>

            {{-- Task --}}
            <div class="w-full mt-6 flex justify-between items-center">
                <h2 class="font-medium text-darker-blue text-xl">
                    Task
                    <span class="text-red-500">*</span>
                </h2>

                <a href="{{ route('participant.projects.add-task') }}" class="text-darker-blue hover:underline">
                    Add Task
                </a>
            </div>

            {{-- Task List --}}
            <div class="w-full mt-3 flex flex-col gap-2">
                <p id="no-task-info" class="my-2 text-center italic">
                    Please add at least 1 task
                </p>

                <div id="task-list" class="flex-col gap-2" style="display: none">
                    @for ($i = 1; $i <= 2; $i++)
                        <div class="w-full h-16 pl-6 pr-4 bg-white border border-grey rounded-lg grid grid-cols-12 items-center gap-1">
                            <p class="col-span-4 text-sm">
                                Task {{ $i }}:-
                            </p>

                            <div class="col-span-2 text-xs">
                                <p>Assigned to:</p>
                                <p>-</p>
                            </div>

                            <div class="col-span-2 text-xs">
                                <p>Duration:</p>
                                <p>-</p>
                            </div>

                            <div class="col-span-2 text-xs">
                                <p>Due Date:</p>
                                <p>-/-/-</p>
                            </div>

                            <div class="col-span-2 flex items-center gap-6 ml-auto">
                                <button class="text-darker-blue">
                                    <i class="fas fa-pen"></i>
                                </button>

                                <button class="text-red-500">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-center">
        <button type="button" id="add-project-btn" class="min-w-[196px] py-2 px-3 bg-[#E9E9E9] border border-grey rounded-full text-[#838383] text-lg">
            Add Project
        </button>
    </div>
</div>
@endsection

@section('more-js')
    <script>
        $('#input-logo-trigger').on('click', function() {
            $('#input-logo').click()
        })

        $('#add-project-btn').on('click', function() {
            if ($(this).hasClass('bg-[#E9E9E9]')) {
                $('#no-task-info').css('display', 'none')
                $('#task-list').css('display', 'flex')
                $(this).removeClass('bg-[#E9E9E9] border-grey text-[#838383]').addClass('bg-primary border-primary text-white')
            } else {
                $('#no-task-info').css('display', 'block')
                $('#task-list').css('display', 'none')
                $(this).removeClass('bg-primary border-primary text-white').addClass('bg-[#E9E9E9] border-grey text-[#838383]')
            }
        })
    </script>
@endsection
