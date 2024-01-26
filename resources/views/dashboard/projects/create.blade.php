@extends('layouts.admin2')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-dark-blue font-medium text-[1.375rem]">
        {{ $partner->name }}
        <span class="mx-3">></span>
        Add Project
    </h1>

    <a href="{{ $backUrl }}" class="flex items-center gap-3 text-xl">
        <i class="fas fa-times-circle mt-1 text-primary"></i>
        Cancel
    </a>
</div>

<form action="{{ $formAction }}" method="post" enctype="multipart/form-data" class="mt-10">
    @csrf

    <div>
        <input
            type="text"
            id="inputname"
            name="name"
            value="{{ old('name') }}"
            placeholder="Project Name *"
            class="border border-grey rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none"
        >

        @error('name')
            <p class="text-red-600 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mt-5 grid grid-cols-12 gap-4">
        <div class="col-span-4">
            <select id="inputdomain" name="project_domain" class="w-full border border-grey rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight invalid:text-lightest-grey focus:outline-none">
                <option value="" hidden>Select Project Domain *</option>
                <option value="nlp" {{ old('domain') == 'nlp' ? 'selected': '' }}>NLP</option>
                <option value="statistical" {{ old('domain') == 'statistical' ? 'selected': '' }}>Machine Learning</option>
                <option value="computer_vision" {{ old('domain') == 'computer_vision' ? 'selected': '' }}>Computer Vision</option>
            </select>

            @error('domain')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="col-span-4">
            <select id="inputperiod" name="period" class="w-full border border-grey rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight invalid:text-lightest-grey focus:outline-none">
                <option value="" hidden>Project Duration *</option>
                <option value="1" {{ old('period') == '1' ? 'selected': '' }}>A Week</option>
                <option value="1" {{ old('period') == '1' ? 'selected': '' }}>1 Month</option>
                <option value="2" {{ old('period') == '2' ? 'selected': '' }}>2 Month(s)</option>
                <option value="3" {{ old('period') == '3' ? 'selected': '' }}>3 Month(s)</option>
            </select>

            @error('period')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="col-span-4">
            <select id="inputtype" name="type" class="w-full border border-grey rounded-lg h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight invalid:text-lightest-grey focus:outline-none">
                <option value="" hidden>Project Type *</option>
                <option value="weekly" {{ old('type') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="monthly" {{ old('type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
            </select>

            @error('type')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>

    <div class="mt-5">
        <input readonly type="hidden" id="inputpartner" name="partner" value="{{ $partner->id }}">

        <select disabled class="border border-grey bg-[#D8D8D8] cursor-not-allowed rounded-lg w-full h-11 py-2 px-4 text-[#3D3D3D] font-medium leading-tight focus:outline-none">
            <option value="{{ $partner->id }}" hidden>{{ $partner->name }}</option>
        </select>

        @error('partner')
            <p class="text-red-600 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mt-5">
        <textarea name="problem" id="problem">
            {{ old('problem') }}
        </textarea>

        @error('problem')
            <p class="text-red-600 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mt-5">
        <input
            type="text"
            id="inputoverview"
            name="overview"
            value="{{ old('overview') }}"
            placeholder="Brief Project Overview (Optional)"
            class="border border-grey rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 focus:outline-none"
        >

        @error('overview')
            <p class="text-red-600 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mt-5">
        <select id="inputinstitution"  name="institution_id" class="border border-grey rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight invalid:text-lightest-grey focus:outline-none">
            <option value="" hidden>Select Institution</option>
            @foreach ($institutions as $institution)
                <option value="{{ $institution->id }}">
                    {{ $institution->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mt-5">
        <select id="inputprojecttype" name="projectType" class="border border-grey rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight invalid:text-lightest-grey focus:outline-none">
            <option value="" hidden>Select Project Privacy Settings *</option>
            <option value="private_project">Final project (private)</option>
            <option value="public">Public to all institutions</option>

            @if(Auth::guard('web')->check() || Auth::guard('customer')->check())
                <option value="private">Private to one institution</option>
            @elseif(Auth::guard('mentor')->check())
                @if (Auth::guard('mentor')->user()->institution_id != 0 )
                    <option value="private">Private to your institution ({{Auth::guard('mentor')->user()->institution->name}})</option>
                @else
                    <option value="private">Private to one institution</option>
                @endif
            @endif
        </select>

        @error('projectType')
            <p class="text-red-600 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mt-7">
        <div class="flex justify-between items-center gap-6">
            <h3 class="text-dark-blue font-medium text-xl">
                Datasets <span class="text-red-600">*</span>
            </h3>

            <button id="add-dataset-btn" type="button" class="flex items-center gap-3 text-xl">
                <i class="fas fa-circle-plus mt-1 text-primary"></i>
                Add Dataset
            </button>
        </div>

        <div id="dataset-fields-container" class="mt-4">
            @php
                $datasets = old('dataset', isset($project) ? $project->dataset : ['']);
                $datasetCount = count($datasets);
            @endphp

            @foreach ($datasets as $index => $datasetUrl)
                <div class="flex items-center mt-2 relative">
                    <input type="text" class="dataset-input border border-grey rounded-lg w-full h-11 py-2 pl-4 pr-10 text-lightest-grey::placeholder leading-tight focus:outline-none" placeholder="Add Data set URLs" name="dataset[]" value="{{ $datasetUrl }}" required>
                    @if ($index > 0)
                        <button type="button" class="remove-dataset-btn absolute right-2 top-1/2 transform -translate-y-1/2" onclick="removeDatasetInputField(this)"><i class="fas fa-circle-minus text-red-600"></i></button>
                    @endif
                </div>
            @endforeach
        </div>

        @error('dataset')
            <p class="text-red-600 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    @if (Auth::guard('web')->check())
        <div class="mt-10 flex justify-between">
            <h3 class="text-dark-blue font-medium text-xl">
                Task <span class="text-red-600">*</span>
            </h3>

            <div class="flex items-center gap-3 text-xl text-dark-blue">
                <i class="fas fa-circle-plus mt-1 text-primary"></i>
                <input type="submit" class="cursor-pointer" name="addInjectionCard" value="Add Task">
            </div>
        </div>
    @endif

    <div class="mt-10">
        @if (Auth::guard('web')->check())
            <input type="submit" class="py-2 px-11 rounded-full border-2 bg-primary text-center text-white text-sm cursor-pointer" name="addProject" value="Add Project">
        @elseif(Auth::guard('mentor')->check() || Auth::guard('customer')->check())
            <input type="submit" class="py-2 px-11 rounded-full border-2 bg-primary text-center text-white text-sm cursor-pointer" name="addProject" value="Propose Project">
        @endif
    </div>
</form>
@endsection

@if (Auth::guard('web')->check() || Auth::guard('customer')->check())
    @section('more-js')
        <script>
            $(document).ready(function () {
                $('#institution').on('change', function () {
                    var institutionVal = this.value;
                    var base_url = window.location.origin;
                    $("#ForState").html('');
                    $.ajax({
                        url: base_url + "/api/institution/" + institutionVal,
                        contentType: "application/json",
                        dataType: 'json',
                        success: function (result) {
                            console.log(result);
                            $('#ForCountry').val(result.countries);
                            $('#ForState').val(result.states);
                        }
                    });
                });

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
                    newInput.className = 'dataset-input border border-grey rounded-lg w-full h-11 py-2 pl-4 pr-10 text-lightest-grey::placeholder leading-tight focus:outline-none required';
                    newInput.placeholder = 'Add Data set URLs';
                    newInput.name = 'dataset[]';
                    newInput.value = value;
                    newInput.required = true;

                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.className = 'remove-dataset-btn absolute right-2 top-1/2 transform -translate-y-1/2';
                    removeButton.innerHTML = '<i class="fas fa-circle-minus text-red-600"></i>';
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
@elseif (Auth::guard('mentor')->check())
    @if (Auth::guard('mentor')->user()->institution_id != 0)
        @section('more-js')
            <script>
                $(document).ready(function () {
                    $('#institution').on('change', function () {
                        var institutionVal = this.value;
                        var base_url = window.location.origin;
                        $("#ForState").html('');
                        $.ajax({
                            url: base_url + "/api/institution/" + institutionVal,
                            contentType: "application/json",
                            dataType: 'json',
                            success: function (result) {
                                console.log(result);
                                $('#ForCountry').val(result.countries);
                                $('#ForState').val(result.states);
                            }
                        });
                    });

                    $('#inputinstitution').hide();
                });
            </script>
        @endsection
    @else
        @section('more-js')
            <script>
                $(document).ready(function () {
                    $('#institution').on('change', function () {
                        var institutionVal = this.value;
                        var base_url = window.location.origin;
                        $("#ForState").html('');
                        $.ajax({
                            url: base_url + "/api/institution/" + institutionVal,
                            contentType: "application/json",
                            dataType: 'json',
                            success: function (result) {
                                console.log(result);
                                $('#ForCountry').val(result.countries);
                                $('#ForState').val(result.states);
                            }
                        });
                    });

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
            </script>
        @endsection
    @endif
@endif
