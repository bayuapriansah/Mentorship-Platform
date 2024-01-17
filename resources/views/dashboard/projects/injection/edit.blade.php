@extends('layouts.admin2')
@section('content')
<div class="flex justify-between items-center">
    <h1 class="text-dark-blue font-medium text-[1.375rem]">
        {{ $project->company->name }}
        <span class="mx-3">></span>
        Project
        <span class="mx-3">></span>
        Edit Task
    </h1>

    <a href="{{ $backUrl }}" class="flex items-center gap-3 text-xl">
        <i class="fas fa-times-circle mt-1 text-primary"></i>
        Cancel
    </a>
</div>

<form action="{{ $formAction }}" method="post" enctype="multipart/form-data" class="mt-10">
    @csrf
    @method('PATCH')

    <div>
        <input
            type="text"
            id="inputtitle"
            name="title"
            value="{{ old('title', $injection->title) }}"
            placeholder="Task Name *"
            class="border border-grey rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
        >

        @error('title')
            <p class="text-red-600 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mt-5 grid grid-cols-12 gap-4">
        <div class="col-span-6">
            <select disabled class="border border-grey bg-[#D8D8D8] cursor-not-allowed rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 invalid:text-lightest-grey focus:outline-none">
                <option>{{ $project->getProjectDomainText() }}</option>
            </select>
        </div>

        <div class="col-span-6">
            <select id="inputcardduration" name="duration" class="border border-grey rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight invalid:text-lightest-grey focus:outline-none">
                <option value="" hidden>Task Duration *</option>

                @foreach (range(1,10) as $duration)
                    <option value="{{ $duration }}" {{ old('duration', $injection->duration) == $duration?'selected' : '' }}>
                        {{ $duration }} {{ $duration == 1 ? 'day' : 'days' }}
                    </option>
                @endforeach
            </select>

            @error('duration')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>

    <div class="mt-5">
        <select disabled id="inputproject" name="project" class="border border-grey bg-[#D8D8D8] cursor-not-allowed rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight mr-5 invalid:text-lightest-grey focus:outline-none">
            <option value="{{ $project->id }}" hidden>{{ $project->name }}</option>
        </select>

        @error('project')
            <p class="text-red-600 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mt-5">
        <textarea name="description" id="sectionDesc" placeholder="Task Details *">
            {{ old('description', $injection->description) }}
        </textarea>

        @error('description')
            <p class="text-danger text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mt-5">
        <input
            type="text"
            id="inputtitle"
            name="dataset"
            value="{{ old('dataset', $injection->dataset) }}"
            placeholder="Dataset"
            class="border border-grey rounded-lg w-full h-11 py-2 px-4 text-lightest-grey::placeholder leading-tight focus:outline-none"
        >

        @error('dataset')
            <p class="text-red-600 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- <div class="mb-3 mt-10 flex justify-between">
        <h3 class="text-dark-blue font-medium text-xl">File Attachment</h3>

        <div class="text-xl text-dark-blue">
            @if (Route::is('dashboard.partner.partnerProjectsInjectionEdit'))
                @if ($attachment_id)
                    <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/edit"><i class="fa-solid fa-circle-plus"></i> Add Attachment</a>
                @else
                    <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment"><i class="fa-solid fa-circle-plus"></i> Add Attachment</a>
                @endif
            @else
                @if ($attachment_id)
                    <a href="/dashboard/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/edit"><i class="fa-solid fa-circle-plus"></i> Add Attachment</a>
                @else
                    <a href="/dashboard/projects/{{$project->id}}/injection/{{$injection->id}}/attachment"><i class="fa-solid fa-circle-plus"></i> Add Attachment</a>
                @endif
            @endif
        </div>
    </div> --}}

    <div class="mt-6">
        <div id="drop-area" class="relative cursor-pointer" style="background-color: white;">
            <label for="file-input">
                <div class="relative cursor-pointer" id="drop-area">
                    <input type="file" class="absolute opacity-0" id="file-input">
                    <div class="p-6 border-2 border-dashed hover:bg-white rounded-md border-light-blue">
                        <div class="text-center">
                            <i class="fas fa-file fa-3x text-lighter-blue"></i>
                            <p class="mt-4 text-sm text-gray-600">
                                Click to upload or drag and drop document
                            </p>
                            <p class="text-xs text-gray-500 "> (MAX. 5MB)</p>
                            <p class="mt-2 text-sm text-gray-600" id="file-name"></p>
                        </div>
                    </div>
                </div>
            </label>
        </div>
    </div>

    <div class="mt-8 space-y-4">
        @foreach ($attachments as $attachment)
            @if ($attachment->file1)
                <div class="px-6 py-3 border border-light-blue rounded-lg flex items-center gap-7">
                    <i class="fas fa-file text-darker-blue"></i>

                    <a href="{{ asset('/storage/'.$attachment->file1) }}" target="_blank" class="text-sm hover:underline">
                        Attachment File 1
                    </a>

                    @if (Route::is('dashboard.partner.partnerProjectsInjectionEdit'))
                        <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/delete/{{1}}" class="ml-auto text-red-600">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    @else
                        <a href="/dashboard/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/delete/{{1}}" class="ml-auto text-red-600">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    @endif
                </div>
            @endif

            @if ($attachment->file2)
                <div class="px-6 py-3 border border-light-blue rounded-lg flex items-center gap-7">
                    <i class="fas fa-file text-darker-blue"></i>

                    <a href="{{ asset('/storage/'.$attachment->file2) }}" target="_blank" class="text-sm hover:underline">
                        Attachment File 2
                    </a>

                    @if (Route::is('dashboard.partner.partnerProjectsInjectionEdit'))
                        <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/delete/{{2}}" class="ml-auto text-red-600">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    @else
                        <a href="/dashboard/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/delete/{{2}}" class="ml-auto text-red-600">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    @endif
                </div>
            @endif

            @if ($attachment->file3)
                <div class="px-6 py-3 border border-light-blue rounded-lg flex items-center gap-7">
                    <i class="fas fa-file text-darker-blue"></i>

                    <a href="{{ asset('/storage/'.$attachment->file3) }}" target="_blank" class="text-sm hover:underline">
                        Attachment File 3
                    </a>

                    @if (Route::is('dashboard.partner.partnerProjectsInjectionEdit'))
                        <a href="/dashboard/partners/{{$partner->id}}/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/delete/{{3}}" class="ml-auto text-red-600">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    @else
                        <a href="/dashboard/projects/{{$project->id}}/injection/{{$injection->id}}/attachment/{{$attachment_id->id}}/delete/{{3}}" class="ml-auto text-red-600">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    @endif
                </div>
            @endif
        @endforeach

        <div id="files-container" class="space-y-4"></div>
    </div>

    <div class="mt-10">
        <input type="submit" class="py-2 px-11 mt-4 rounded-full bg-primary text-center text-white text-sm cursor-pointer" value="Update">
    </div>
</form>
@endsection

@section('more-js')
    <script>
        const dropArea = document.getElementById('drop-area')
        const fileInput = document.getElementById('file-input')
        let uploadedFiles = []

        function renderFiles() {
            $('#files-container').html('')

            uploadedFiles.forEach((file, index) => {
                $('#files-container').append(`
                    <div class="px-6 py-3 border border-light-blue rounded-lg flex items-center gap-7">
                        <input hidden type="file" name="files[]">
                        <i class="fas fa-file text-darker-blue"></i>
                        <span class="text-sm">${file.name}</span>
                        <button class="ml-auto text-red-600" onclick="deleteFile(${index})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                `)
            })

            $('input[name="files[]"]').each(function(index, element) {
                const dataTransfer = new DataTransfer()
                dataTransfer.items.add(uploadedFiles[index])
                $(element).prop('files', dataTransfer.files)
            })
        }

        function addFile(file) {
            fileInput.value = ''

            if (uploadedFiles.length >= 3) {
                toastr.error('You can only upload up to 3 files')
                return
            }

            if (file) {
                if (file.size > 5500000) {
                    toastr.error('Maximum file size is 5 MB')
                } else {
                    uploadedFiles.push(file)
                    renderFiles()
                }
            }
        }

        function deleteFile(index) {
            uploadedFiles.splice(index, 1)
            renderFiles()
        }

        dropArea.addEventListener('dragover', e => {
            e.preventDefault()
            dropArea.style.backgroundColor = '#f2f2f2'
        })

        dropArea.addEventListener('dragleave', e => {
            e.preventDefault()
            dropArea.style.backgroundColor = 'white'
        })

        dropArea.addEventListener('drop', e => {
            e.preventDefault()
            dropArea.classList.remove('bg-gray-200')
            addFile(e.dataTransfer.files[0])
        })

        fileInput.addEventListener('change', e => {
            if (e.target.files.length > 0) {
                addFile(e.target.files[0])
            }
        })
    </script>
@endsection
