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
                <a href="{{ $backUrl }}" class="hover:underline">
                    {{ $project->name }}
                </a>
                <span class="ml-2 mr-4">></span>
                Create Task
            </h1>

            <div class="w-full tab:w-[941px] mt-7 mx-auto flex flex-col">
                <form id="project-form" action="{{ $formAction }}" method="post" enctype="multipart/form-data" class="mt-10">
                    @csrf
                    @method('PATCH')
                    <h2 class="font-medium text-darker-blue text-xl my-5">
                        Task Label
                        <span class="text-red-500">*</span>
                    </h2>
                    <div>
                        <input
                            type="text"
                            id="inputname"
                            name="name"
                            value="{{ $ProjectSection->title }}"
                            placeholder="Task Label *"
                            class="border border-grey rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
                        >

                        @error('name')
                            <p class="text-danger text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="w-full mt-5 flex flex-col gap-3">
                        <h2 class="font-medium text-darker-blue text-xl">
                            Due Date
                            <span class="text-red-500">*</span>
                        </h2>

                        <input type="date" name="DueDate"
                            class="h-12 px-3 py-2 border border-grey rounded-lg focus:outline-none"
                            value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $ProjectSection->due_date)->format('Y-m-d') }}">
                    </div>

                    <div class="mt-5">
                        <textarea name="problem" id="problem">
                            {{ old('problem', $ProjectSection->description) }}
                        </textarea>

                        @error('problem')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <h2 class="font-medium text-darker-blue text-xl my-5">
                        Task Assigned to
                        <span class="text-red-500">(Optional)</span>
                    </h2>
                    @php
                        $teamStudents = teamList($student->team_name);
                    @endphp

                    {{-- @dd($teamStudents->where('team_name',$student->team_name)->where('id',317)); --}}
                    <div class="col-span-6">
                        <select required id="inputdomain" name="assign" class="w-full border border-grey rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none required">
                            <option value="" hidden>Select team members</option>
                            @foreach($teamStudents as $student)
                            <!-- Student data display -->
                            <option value="{{ $student->id }}" {{ $ProjectSection->assigned_to == $student->id ? 'selected' : '' }}>{{ $student->first_name }} {{ $student->last_name }}</option>
                            @endforeach
                        </select>

                        @error('assign')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mt-7">
                        <div class="flex justify-between items-center gap-6">
                            <h3 class="text-dark-blue font-medium text-xl">
                                Task Attachments
                                <span class="text-red-500">*</span>
                                <i data-tooltip-target="tooltip-animation" class="fa fa-info-circle" aria-hidden="true"></i>

                                <div id="tooltip-animation" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Please put Valid URL links
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </h3>

                            <button id="add-dataset-btn" type="button" class="flex items-center gap-3 text-xl">
                                <i class="fas fa-circle-plus mt-1 text-primary"></i>
                                Task Attachments
                            </button>
                        </div>
                        <div id="dataset-fields-container" class="mt-4">
                        @php
                            $datasetLabels = is_string($ProjectSection->dataset_label) ? json_decode($ProjectSection->dataset_label, true) : $ProjectSection->dataset_label;
                            $datasets = is_string($ProjectSection->dataset) ? json_decode($ProjectSection->dataset, true) : $ProjectSection->dataset;
                        @endphp

                        @if(is_array($datasetLabels) && is_array($datasets))
                            @foreach($datasetLabels as $index => $label)
                                <div class="flex flex-wrap gap-2 items-center mt-2 relative">
                                    {{-- Dataset Label Input --}}
                                    <input type="text" class="dataset-label-input border border-grey rounded-lg w-full md:w-auto flex-1 h-11 py-2 pl-4 pr-10 text-lightest-grey::placeholder leading-tight focus:outline-none" placeholder="Dataset Label" name="dataset_label[]" value="{{ $label }}" required>
                                    {{-- Dataset URL Input --}}
                                    @if(isset($datasets[$index]))
                                    <input type="text" class="dataset-input border border-grey rounded-lg w-full md:w-auto flex-1 h-11 py-2 pl-4 pr-10 text-lightest-grey::placeholder leading-tight focus:outline-none" placeholder="Add Data set URLs" name="dataset[]" value="{{ $datasets[$index] }}" required>
                                    @endif
                                    {{-- Remove Button --}}
                                    <button type="button" class="remove-dataset-btn absolute right-2 top-1/2 transform -translate-y-1/2">
                                        <i class="fas fa-minus-circle text-red-600"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    @error('dataset')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-6 flex justify-center">
            <button type="button" id="add-project-btn" class="min-w-[196px] py-2 px-3 bg-[#E9E9E9] border border-grey rounded-full text-[#838383] text-lg">
                Add Task
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
            addDatasetInputField('', '');
        });

        function addDatasetInputField(datasetValue, labelValue) {
            const inputWrapper = document.createElement('div');
            inputWrapper.className = 'flex flex-wrap gap-2 items-center mt-2 relative';

            // Input for Dataset URL
            const newInput = document.createElement('input');
            newInput.type = 'text';
            newInput.className = 'dataset-input border border-grey rounded-lg w-full md:w-auto flex-1 h-11 py-2 pl-4 pr-10 text-lightest-grey::placeholder leading-tight focus:outline-none';
            newInput.placeholder = 'Add Data set URLs';
            newInput.name = 'dataset[]';
            newInput.value = datasetValue;
            newInput.required = true;

            // Input for Dataset Label
            const newLabelInput = document.createElement('input');
            newLabelInput.type = 'text';
            newLabelInput.className = 'dataset-label-input border border-grey rounded-lg w-full md:w-auto flex-1 h-11 py-2 pl-4 pr-10 text-lightest-grey::placeholder leading-tight focus:outline-none';
            newLabelInput.placeholder = 'Dataset Label';
            newLabelInput.name = 'dataset_label[]';
            newLabelInput.value = labelValue;
            newLabelInput.required = true;

            // Remove Button
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'remove-dataset-btn absolute right-2 top-1/2 transform -translate-y-1/2';
            removeButton.innerHTML = '<i class="fa-solid fa-circle-minus text-red-600"></i>';
            removeButton.onclick = function () {
                inputWrapper.remove();
            };

            // Append Dataset URL Input and Dataset Label Input to the wrapper
            inputWrapper.appendChild(newLabelInput);
            inputWrapper.appendChild(newInput);
            inputWrapper.appendChild(removeButton);

            // Append the entire wrapper to the container
            container.appendChild(inputWrapper);
        }

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
