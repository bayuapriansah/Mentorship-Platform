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
                {{ $project->name }}
            </h1>

            <div class="w-full tab:w-[941px] mt-7 mx-auto flex flex-col">
                <form id="project-form" action="{{ $formAction }}" method="post" enctype="multipart/form-data" class="mt-10">
                    @csrf
                    @method('PATCH')
                    <h2 class="font-medium text-darker-blue text-xl my-5">
                        Project Name
                        <span class="text-red-500">*</span>
                    </h2>
                    <div>
                        <input
                            reuq'
                            type="text"
                            id="inputname"
                            name="name"
                            value="{{ old('name', $project->name) }}"
                            placeholder="Project Name *"
                            class="border border-grey rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                        >

                        @error('name')
                            <p class="text-danger text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <h2 class="font-medium text-darker-blue text-xl my-5">
                        Project Type
                        <span class="text-red-500">*</span>
                    </h2>
                    <div class="mt-5 grid grid-cols-12 gap-4">
                        <div class="col-span-6">
                            <select required id="inputdomain" name="project_domain" class="w-full border border-grey rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight invalid:text-lightest-grey focus:outline-none required">
                                <option value="" hidden>Select Project Domain *</option>
                                <option value="nlp" {{ old('domain', $project->project_domain) == 'nlp' ? 'selected': '' }}>Natural Language Processing (NLP)</option>
                                <option value="statistical" {{ old('domain', $project->project_domain) == 'statistical' ? 'selected': '' }}>Machine Learning (ML)</option>
                                <option value="computer_vision" {{ old('domain', $project->project_domain) == 'computer_vision' ? 'selected': '' }}>Computer Vision (CV)</option>
                            </select>

                            @error('domain')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="col-span-6">
                            {{-- <select disabled id="inputperiod" name="period" class="w-full border border-grey rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight invalid:text-lightest-grey focus:outline-none"> --}}
                            <select disabled id="inputperiod" class="border border-grey bg-[#D8D8D8] cursor-not-allowed rounded-lg w-full h-11 py-2 px-4 text-[#3D3D3D] font-medium leading-tight focus:outline-none">
                                <option value="" hidden>Project Duration *</option>
                                <option value="10" {{ old('period', $project->period) == '10' ? 'selected': '' }}>10 Weeks</option>
                                {{-- <option value="1" {{ old('period', $project->period) == '1' ? 'selected': '' }}>A Week</option> --}}
                                {{-- <option value="1" {{ old('period', $project->period) == '1' ? 'selected': '' }}>1 Month</option>
                                <option value="2" {{ old('period', $project->period) == '2' ? 'selected': '' }}>2 Month(s)</option>
                                <option value="3" {{ old('period', $project->period) == '3' ? 'selected': '' }}>3 Month(s)</option> --}}
                            </select>

                            @error('period')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- <div class="col-span-4">
                            <select id="inputtype" name="type" class="w-full border border-grey rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight invalid:text-lightest-grey focus:outline-none">
                                <option value="" hidden>Project Type *</option>
                                <option value="weekly" {{ old('type', $project->type) == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            </select>

                            @error('type')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div> --}}
                    </div>

                    <div class="mt-5" hidden>
                        <input readonly type="hidden" id="inputpartner" name="partner" value="{{ optional($project->company)->id }}">

                        <select disabled class="border border-grey bg-[#D8D8D8] cursor-not-allowed rounded-lg w-full h-11 py-2 px-4 text-[#3D3D3D] font-medium leading-tight focus:outline-none">
                            <option value="{{ optional($project->company)->id }}" hidden>{{ optional($project->company)->name; }}</option>
                        </select>

                        @error('partner')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <h2 class="font-medium text-darker-blue text-xl my-5">
                        Project Details
                        <span class="text-red-500">*</span>
                    </h2>
                    <div class="mt-5">
                        <textarea name="problem" id="problem">
                            {{ old('problem', $project->problem) }}
                        </textarea>

                        @error('problem')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <h2 class="font-medium text-darker-blue text-xl mt-5">
                        Project Descriptions
                        <span class="text-red-500">(Optional)</span>
                    </h2>
                    <div class="mt-5">
                        <input
                            type="text"
                            id="inputoverview"
                            name="overview"
                            value="{{ old('overview', $project->overview) }}"
                            placeholder="Brief Project Overview (Optional)"
                            class="border border-grey rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none"
                        >

                        @error('overview')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
{{-- No Project Type since the activation will be location in another button --}}
                    {{-- <div class="mt-5" hidden>
                        <select id="inputprojecttype"  name="projectType" class="border border-grey rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight invalid:text-lightest-grey focus:outline-none">
                            <option value="" hidden>Select Project Privacy Settings *</option>
                            <option value="public" {{ !$project->institution_id ? 'selected' : '' }}>Public to all institutions</option>

                            @if (Auth::guard('web')->check() )
                                @if ($project->institution_id)
                                    <option value="private" {{ $project->institution_id ? 'selected' : '' }}>Private to specific institution ({{ $project->institution->name }})</option>
                                @else
                                    <option value="private">Private to one institution</option>
                                @endif
                            @elseif (Auth::guard('mentor')->check())
                                @if (Auth::guard('mentor')->user()->institution_id != 0)
                                    <option value="private" {{ $project->institution_id ? 'selected' : '' }}>Private to Your institution ({{ Auth::guard('mentor')->user()->institution->name }})</option>
                                @else
                                    @if ($project->institution_id)
                                        <option value="private" {{ $project->institution_id ? 'selected' : '' }}>Private to Your institution ({{ $project->institution->name }})</option>
                                    @else
                                        <option value="private">Private to one institution</option>
                                    @endif
                                @endif
                            @elseif (Auth::guard('customer')->check())
                                @if ($project->institution_id)
                                    <option value="private" {{ $project->institution_id ? 'selected': '' }}>Private to specific institution ({{ $project->institution->name }})</option>
                                @else
                                    <option value="private">Private to one institution</option>
                                @endif
                            @endif
                        </select>
                    </div> --}}

                    {{-- <input type="hidden" value="{{ $project->institution_id }}" name="existing_institute">

                    <div class="mt-5">
                        <select id="inputinstitution"  name="institution_id" class="border border-grey rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight invalid:text-lightest-grey focus:outline-none">
                            <option value="" hidden>Select Institution</option>
                            @foreach ($institutions as $institution)
                                <option value="{{$institution->id}}" >{{$institution->name}}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="mt-7">
                        <div class="flex justify-between items-center gap-6">
                            <h3 class="text-dark-blue font-medium text-xl">
                                Dataset(s)
                                <span class="text-red-500">*</span>
                                <i data-tooltip-target="tooltip-animation" class="fa fa-info-circle" aria-hidden="true"></i>

                                <div id="tooltip-animation" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Please put Valid URL links
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </h3>

                            <button id="add-dataset-btn" type="button" class="flex items-center gap-3 text-xl">
                                <i class="fas fa-circle-plus mt-1 text-primary"></i>
                                Add Dataset
                            </button>
                        </div>
                        <div id="dataset-fields-container" class="mt-4">
                            @php
                                // Ensure that $project->dataset is always an array
                                $datasets = $project->dataset ?? [];
                            @endphp

                            @foreach ($datasets as $index => $datasetUrl)
                                <div class="flex items-center mt-2 relative">
                                    <input type="text" class="dataset-input border border-grey rounded-lg w-full h-11 py-2 pl-4 pr-10 text-lightest-grey::placeholder leading-tight focus:outline-none" placeholder="Add Data set URLs" name="dataset[]" value="{{ $datasetUrl }}" required>
                                    {{-- <input type="text" class="dataset-input border border-grey rounded-lg w-full h-11 py-2 pl-4 pr-10 text-lightest-grey::placeholder leading-tight focus:outline-none" placeholder="Add Data set URLs" name="dataset[]" value="{{ $datasetUrl }}" required> --}}
                                    @if ($index > 0)
                                        <button type="button" class="remove-dataset-btn absolute right-2 top-1/2 transform -translate-y-1/2" onclick="removeDatasetInputField(this)"><i class="fas fa-circle-minus text-red-600"></i></button>
                                    @endif
                                </div>
                            @endforeach

                            @if (count($datasets) === 0)
                                <div class="flex items-center mt-2 relative">
                                    <input type="text" class="dataset-input border border-grey rounded-lg w-full h-11 py-2 pl-4 pr-10 text-lightest-grey::placeholder leading-tight focus:outline-none" placeholder="Add Data set URLs" name="dataset[]" required>
                                </div>
                            @endif
                        </div>

                        @error('dataset')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    @if (Auth::guard('student')->check())
                        <div class="mt-10 flex justify-between">
                            <h3 class="text-dark-blue font-medium text-xl">
                                Task <span class="text-red-600">*</span>
                            </h3>

                            <div class="text-xl text-dark-blue">
                                <a href="{{ route('participant.projects.task', ['project' => $project->id]) }}" class="flex items-center gap-3">
                                    <i class="fas fa-circle-plus mt-1 text-primary"></i>
                                    Add Task
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="mt-4 space-y-2">
                        @foreach ($cards as $card)
                            <div class="py-4 px-6 bg-white hover:bg-[#F2F3FD] border border-grey rounded-xl grid grid-cols-12 items-center gap-4">
                                <p class="col-span-6 text-sm">
                                    Task {{ $loop->iteration }}: {{ substr($card->title, 0, 38) }}...
                                </p>

                                <div class="col-span-2 flex flex-col">
                                    <span class="text-xs">Due Date:</span>
                                    <span class="text-xs text-dark-blue">
                                        {{ $card->due_date }}
                                        {{-- {{ $card->duration }} {{ $card->duration == 1 ? 'Day' : 'Days' }} --}}
                                    </span>
                                </div>

                                <div class="col-span-2 flex flex-col">
                                    <span class="text-xs">Added On:</span>
                                    <span class="text-xs text-dark-blue">
                                        {{ $card->created_at->format('d/m/Y') }}
                                    </span>
                                </div>

                                <div class="col-span-2 justify-self-end space-x-5">
                                    <a href="{{ route('participant.projects.edit-task', ['project' => $project->id, 'ProjectSection' => $card->id]) }}">
                                        <i class="fa-solid fa-pencil fa-lg text-dark-blue my-auto"></i>
                                    </a>
                                    <a href="{{ route('participant.projects.task.delete', ['project' => $project->id, 'ProjectSection' => $card->id]) }}">
                                        <i class="fa-solid fa-trash-can text-red-600 fa-lg my-auto"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-6 flex justify-center">
            <button type="button" id="add-project-btn" class="min-w-[196px] py-2 px-3 bg-[#E9E9E9] border border-grey rounded-full text-[#838383] text-lg">
                Apply Changes
            </button>
        </div>
    </div>
@endsection

@section('more-js')
<script>
    $(document).ready(function () {
        $('#inputinstitution').hide();
        $("#inputprojecttype").change(function () {
            var values = $("#inputprojecttype option:selected").val();
            if (values == 'private') {
                $('#inputinstitution').show();
            } else {
                $('#inputinstitution').hide();
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {

        const button = document.getElementById('add-project-btn');
        const form = document.getElementById('project-form');

        button.addEventListener('click', function(event) {
            // Check if the form is valid
            if (form.checkValidity()) {
                // Submit the form if all required fields are filled
                form.submit();
            } else {
                // If the form is invalid, trigger the browser's default validation UI
                form.reportValidity();
            }
        });

        const container = document.getElementById('dataset-fields-container');
        const addButton = document.getElementById('add-dataset-btn');

        addButton.addEventListener('click', function () {
            addDatasetInputField('');
        });

        function addDatasetInputField(value) {
            const inputWrapper = document.createElement('div');
            inputWrapper.className = 'flex items-center mt-2 relative';

            const newInput = document.createElement('input');
            newInput.type = 'text';
            newInput.className = 'dataset-input border border-grey rounded-lg w-full h-11 py-2 pl-4 pr-10 text-lightest-grey::placeholder leading-tight focus:outline-none';
            newInput.placeholder = 'Add Data set URLs';
            newInput.name = 'dataset[]';
            newInput.value = value;
            newInput.required = true;

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'remove-dataset-btn absolute right-2 top-1/2 transform -translate-y-1/2';
            removeButton.innerHTML = '<i class="fa-solid fa-circle-minus text-red-600"></i>';
            removeButton.onclick = function () {
                inputWrapper.remove();
            };

            inputWrapper.appendChild(newInput);
            inputWrapper.appendChild(removeButton);
            container.appendChild(inputWrapper);
        }

        // Function to remove dataset input field
        window.removeDatasetInputField = function (button) {
            button.parentElement.remove();
        };

        // Add remove functionality to existing dataset input fields
        const existingRemoveButtons = container.querySelectorAll('.remove-dataset-btn');
        existingRemoveButtons.forEach(button => {
            button.onclick = function () {
                this.parentElement.remove();
            };
        });
    });
</script>
@endsection
