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
            <a href="{{ route('participant.projects.create') }}" class="hover:underline">
                Add Project
            </a>
            <span class="ml-2 mr-4">></span>
            Add Task
        </h1>

        <div class="w-full tab:w-[641px] mt-7 mx-auto flex flex-col items-center">
            {{-- Task Name --}}
            <input
                type="text"
                placeholder="Task Name *"
                class="w-full h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none"
            >

            {{-- Due Date --}}
            <div class="w-full mt-6 flex flex-col gap-3">
                <h2 class="font-medium text-darker-blue text-xl">
                    Due Date:
                </h2>

                <input
                    type="date"
                    class="h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none"
                >
            </div>

            {{-- Details --}}
            <textarea
                rows="10"
                placeholder="Task Details *"
                class="w-full mt-7 px-3 py-2 border border-grey rounded-lg focus:outline-none"
            ></textarea>

            {{-- Assignee --}}
            <div class="w-full mt-9 flex flex-col gap-2">
                <h2 class="font-medium text-darker-blue text-xl">
                    Task Assigned to (Optional)
                </h2>

                <select class="w-full h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none">
                    <option>Task Assigned to (Optional)</option>
                    <option>Lionel Messi</option>
                    <option>C. Ronaldo</option>
                </select>
            </div>

            {{-- Attachment --}}
            <div class="w-full mt-9">
                <h2 class="font-medium text-darker-blue text-xl">
                    Task Attachments
                    <span class="text-red-500">*</span>
                </h2>

                <div class="mt-3 flex flex-col gap-4">
                    <div class="flex justify-between items-center">
                        <input
                            type="text"
                            value="Summary of Future Goal/Expectations"
                            class="w-[290px] h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none"
                        >

                        <input
                            type="text"
                            value="docs.google.com/document/d/19M2o....."
                            class="w-[290px] h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none"
                        >

                        <button class="text-red-500">
                            <i class="fas fa-trash-alt fa-lg"></i>
                        </button>
                    </div>

                    <div class="flex justify-between items-center">
                        <input
                            type="text"
                            value="Document Name *"
                            class="w-[290px] h-12 px-3 py-2 bg-[#E8E8E8] border border-grey rounded-lg focus:outline-none"
                            readonly
                        >

                        <input
                            type="text"
                            value="Document Url *"
                            class="w-[290px] h-12 px-3 py-2 bg-[#E8E8E8] border border-grey rounded-lg focus:outline-none"
                            readonly
                        >

                        <button class="w-6 h-6 bg-primary text-white rounded-full">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-center">
        <button type="button" id="add-project-btn" class="min-w-[196px] py-2 px-3 bg-primary border border-primary rounded-full text-white text-lg">
            Submit
        </button>
    </div>
</div>
@endsection
