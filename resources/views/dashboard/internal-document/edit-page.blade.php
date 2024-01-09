@extends('layouts.admin2')

@section('content')
<a href="{{ route('dashboard.internal-document.all-pages.index') }}" class="group block text-lg text-[#6973C6]">
    <
    <span class="ml-2 group-hover:underline">
        Back
    </span>
</a>

<h1 class="mt-2 text-dark-blue font-medium text-[1.375rem]">
    Internal Document
    <span class="mx-3">></span>
    All Pages
    <span class="mx-3">></span>
    Edit Page
</h1>

{{-- Form --}}
<form action="{{ route('dashboard.internal-document.all-pages.update', ['id' => $page->id]) }}" method="POST" enctype="multipart/form-data" class="mt-10">
    @csrf
    @method('PUT')

    {{-- Page Title --}}
    <div class="flex flex-col gap-3">
        <h2 class="text-xl text-darker-blue font-medium">
            Page Title
            <span class="text-[#EA0202]">*</span>
        </h2>

        <input
            type="text"
            name="title"
            value="{{ old('title', $page->title) }}"
            placeholder="Type Something. . ."
            class="h-11 px-4 py-2 border border-grey rounded-lg leading-tight focus:outline-none"
            autofocus
            required
        >

        @error('title')
            <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
        @enderror
    </div>
    {{-- ./Page Title --}}

    {{-- Page Subtitle --}}
    <div class="mt-10 flex flex-col gap-3">
        <h2 class="text-xl text-darker-blue font-medium">
            Page Subtitle
            <span class="text-[#EA0202]">*</span>
        </h2>

        <input
            type="text"
            name="subtitle"
            value="{{ old('subtitle', $page->subtitle) }}"
            placeholder="Type Something. . ."
            class="h-11 px-4 py-2 border border-grey rounded-lg leading-tight focus:outline-none"
            required
        >

        @error('subtitle')
            <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
        @enderror
    </div>
    {{-- ./Page Subtitle --}}

    {{-- Description --}}
    <div class="mt-10 flex flex-col gap-3">
        <h2 class="text-xl text-darker-blue font-medium">
            Description
            <span class="text-[#EA0202]">*</span>
        </h2>

        <textarea id="problem" name="description" required>
            {{ old('problem', $page->description) }}
        </textarea>

        @error('description')
            <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
        @enderror
    </div>
    {{-- ./Description --}}

    {{-- Upload File --}}
    <div class="mt-10">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-darker-blue font-medium">
                File (Optional)
            </h2>

            <div class="flex items-center gap-3 text-primary">
                <button type="button" onclick="addFile()">
                    <i class="fas fa-plus fa-lg"></i>
                </button>
            </div>
        </div>

        @if (count($files) > 0)
            <div class="my-6 flex flex-col gap-4">
                @foreach ($files as $file)
                    <div class="px-6 py-3 border border-grey rounded-lg flex items-center">
                        <p class="text-sm">
                            {{ substr(str_replace('internal-document/', '', $file), 0, 50) }}{{ strlen(str_replace('internal-document/', '', $file)) >= 50 ? '...' : '' }}
                        </p>

                        <div class="ml-auto flex items-center gap-4">
                            <a href="{{ asset('storage/' . $file) }}" target="_blank" title="Download" class="text-darker-blue">
                                <i class="fas fa-download"></i>
                            </a>

                            <a href="{{ route('dashboard.internal-document.all-pages.delete-file', ['id' => $page->id, 'file_path' => urlencode($file)]) }}" title="Delete" class="delete-file-link">
                                <i class="fas fa-trash-alt text-red-600"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div id="file-list" class="mt-6 flex flex-col gap-8">
            <label for="input-file-1" class="relative min-h-[8rem] border-2 border-dashed border-grey flex flex-col justify-center items-center cursor-pointer">
                <button type="button" onclick="removeFile(this)" class="absolute -top-2 -right-2 w-6 h-6 bg-red-600 rounded-full flex justify-center items-center">
                    <i class="fas fa-times fa-sm text-white"></i>
                </button>

                <input hidden type="file" id="input-file-1" name="files[]" onchange="handleFileInput(this)" class="input-file">

                <p class="text-lg text-grey font-light">
                    Drag & Drop your file or Browse
                </p>

                <p class="file-name mt-2 text-sm text-light-blue font-light">
                    Maximum size 5 MB
                </p>
            </label>
        </div>
    </div>
    {{-- ./Upload File --}}

    {{-- Group Section --}}
    <div class="mt-10 flex flex-col gap-3">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-darker-blue font-medium">
                Group Section
                <span class="text-[#EA0202]">*</span>
            </h2>
        </div>

        <select name="internal_document_group_section_id" class="h-11 px-4 py-2 border border-grey rounded-lg leading-tight focus:outline-none" required>
            <option value="" hidden>Select Section</option>
            @foreach ($sections as $section)
                <option value="{{ $section->id }}" {{ old('internal_document_group_section_id', $page->internal_document_group_section_id) == $section->id ? 'selected' : '' }}>
                    {{ $section->name }}
                </option>
            @endforeach
        </select>

        @error('internal_document_group_section_id')
            <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
        @enderror
    </div>
    {{-- ./Group Section --}}

    <button type="submit" class="mt-10 px-14 py-1 bg-primary rounded-full text-sm text-white">
        Update
    </button>
</form>
{{-- ./Form --}}
@endsection

@section('more-js')
    <script>
        let fileCount = 1

        function removeFile(trigger) {
            $(trigger).parent().remove()
        }

        function addFile() {
            fileCount++

            $('#file-list').append(`
                <label for="input-file-${fileCount}" class="relative min-h-[8rem] border-2 border-dashed border-grey flex flex-col justify-center items-center cursor-pointer">
                    <button type="button" onclick="removeFile(this)" class="absolute -top-2 -right-2 w-6 h-6 bg-red-600 rounded-full flex justify-center items-center">
                        <i class="fas fa-times fa-sm text-white"></i>
                    </button>

                    <input hidden type="file" id="input-file-${fileCount}" name="files[]" onchange="handleFileInput(this)" class="input-file">

                    <p class="text-lg text-grey font-light">
                        Drag & Drop your file or Browse
                    </p>

                    <p class="file-name mt-2 text-sm text-light-blue font-light">
                        Maximum size 5 MB
                    </p>
                </label>
            `)
        }

        function handleFileInput(input) {
            const maxFileSize = 5.5 * 1024 * 1024
            const file = input.files[0]

            if(file) {
                if (file.size > maxFileSize) {
                    toastr.error('Maximum file size 5 MB')
                    input.value = ''
                } else {
                    $(input).parent().find('.file-name').text(file.name)
                }
            }
        }

        $('.delete-file-link').on('click', function(e) {
            e.preventDefault()

            let deleteConfirm = confirm('Are you sure you want to permanently delete this file?\u000AWARNING! This action cannot be undone.')

            if (deleteConfirm) {
                window.location.href = $(this).attr('href')
            }
        })
    </script>
@endsection
