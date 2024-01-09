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
    Add Page
</h1>

{{-- Form --}}
<form action="{{ route('dashboard.internal-document.all-pages.save') }}" method="POST" enctype="multipart/form-data" class="mt-10">
    @csrf

    {{-- Page Title --}}
    <div class="flex flex-col gap-3">
        <h2 class="text-xl text-darker-blue font-medium">
            Page Title
            <span class="text-[#EA0202]">*</span>
        </h2>

        <input
            type="text"
            name="title"
            value="{{ old('title') }}"
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
            value="{{ old('subtitle') }}"
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
            {{ old('description') }}
        </textarea>

        @error('description')
            <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
        @enderror
    </div>
    {{-- ./Description --}}

    {{-- Upload File --}}
    <div class="mt-10 flex flex-col gap-6">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-darker-blue font-medium">
                Files (Optional)
            </h2>

            <div class="flex items-center gap-3 text-primary">
                <button type="button" onclick="addFile()">
                    <i class="fas fa-plus fa-lg"></i>
                </button>
            </div>
        </div>

        <div id="file-list" class="flex flex-col gap-8">
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

    {{-- Files Header Info --}}
    <div class="mt-10 flex flex-col gap-3">
        <h2 class="text-xl text-darker-blue font-medium">
            Files Header Info (Optional)
        </h2>

        <textarea id="problem" name="files_header_info" required>
            {{ old('files_header_info') }}
        </textarea>

        @error('files_header_info')
            <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
        @enderror
    </div>
    {{-- ./Files Header Info --}}

    {{-- Files Footer Info --}}
    <div class="mt-10 flex flex-col gap-3">
        <h2 class="text-xl text-darker-blue font-medium">
            Files Footer Info (Optional)
        </h2>

        <textarea id="problem" name="files_footer_info" required>
            {{ old('files_footer_info') }}
        </textarea>

        @error('files_footer_info')
            <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
        @enderror
    </div>
    {{-- ./Files Footer Info --}}

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
                <option value="{{ $section->id }}" {{ old('internal_document_group_section_id') == $section->id ? 'selected' : '' }}>
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
        Save
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
    </script>
@endsection
