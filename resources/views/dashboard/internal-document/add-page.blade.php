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
<div class="mt-10">
    {{-- Page Title --}}
    <div class="flex flex-col gap-3">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-darker-blue font-medium">
                Title Page
                <span class="text-[#EA0202]">*</span>
            </h2>

            <div class="flex items-center gap-3 text-primary">
                <button>
                    <i class="fas fa-plus"></i>
                </button>

                <button>
                    <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.16234 4.1484C3.07502 4.1484 3.81491 3.40852 3.81491 2.49583C3.81491 1.58314 3.07502 0.843262 2.16234 0.843262C1.24965 0.843262 0.509766 1.58314 0.509766 2.49583C0.509766 3.40852 1.24965 4.1484 2.16234 4.1484ZM8.11168 4.1484C9.02436 4.1484 9.76425 3.40852 9.76425 2.49583C9.76425 1.58314 9.02436 0.843262 8.11168 0.843262C7.19899 0.843262 6.45911 1.58314 6.45911 2.49583C6.45911 3.40852 7.19899 4.1484 8.11168 4.1484ZM15.7136 2.49583C15.7136 3.40852 14.9737 4.1484 14.061 4.1484C13.1483 4.1484 12.4084 3.40852 12.4084 2.49583C12.4084 1.58314 13.1483 0.843262 14.061 0.843262C14.9737 0.843262 15.7136 1.58314 15.7136 2.49583ZM2.16234 9.43644C3.07502 9.43644 3.81491 8.69656 3.81491 7.78387C3.81491 6.87118 3.07502 6.1313 2.16234 6.1313C1.24965 6.1313 0.509766 6.87118 0.509766 7.78387C0.509766 8.69656 1.24965 9.43644 2.16234 9.43644ZM9.76425 7.78387C9.76425 8.69656 9.02436 9.43644 8.11168 9.43644C7.19899 9.43644 6.45911 8.69656 6.45911 7.78387C6.45911 6.87118 7.19899 6.1313 8.11168 6.1313C9.02436 6.1313 9.76425 6.87118 9.76425 7.78387ZM14.061 9.43644C14.9737 9.43644 15.7136 8.69656 15.7136 7.78387C15.7136 6.87118 14.9737 6.1313 14.061 6.1313C13.1483 6.1313 12.4084 6.87118 12.4084 7.78387C12.4084 8.69656 13.1483 9.43644 14.061 9.43644Z" fill="#E96424"/>
                    </svg>
                </button>

                <button>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <input type="text" placeholder="Type Something. . ." class="h-11 px-4 py-2 border border-grey rounded-lg leading-tight focus:outline-none">
    </div>
    {{-- ./Page Title --}}

    {{-- Page Subtitle --}}
    <div class="mt-10 flex flex-col gap-3">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-darker-blue font-medium">
                Subtitle Page
                <span class="text-[#EA0202]">*</span>
            </h2>

            <div class="flex items-center gap-3 text-primary">
                <button>
                    <i class="fas fa-plus"></i>
                </button>

                <button>
                    <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.16234 4.1484C3.07502 4.1484 3.81491 3.40852 3.81491 2.49583C3.81491 1.58314 3.07502 0.843262 2.16234 0.843262C1.24965 0.843262 0.509766 1.58314 0.509766 2.49583C0.509766 3.40852 1.24965 4.1484 2.16234 4.1484ZM8.11168 4.1484C9.02436 4.1484 9.76425 3.40852 9.76425 2.49583C9.76425 1.58314 9.02436 0.843262 8.11168 0.843262C7.19899 0.843262 6.45911 1.58314 6.45911 2.49583C6.45911 3.40852 7.19899 4.1484 8.11168 4.1484ZM15.7136 2.49583C15.7136 3.40852 14.9737 4.1484 14.061 4.1484C13.1483 4.1484 12.4084 3.40852 12.4084 2.49583C12.4084 1.58314 13.1483 0.843262 14.061 0.843262C14.9737 0.843262 15.7136 1.58314 15.7136 2.49583ZM2.16234 9.43644C3.07502 9.43644 3.81491 8.69656 3.81491 7.78387C3.81491 6.87118 3.07502 6.1313 2.16234 6.1313C1.24965 6.1313 0.509766 6.87118 0.509766 7.78387C0.509766 8.69656 1.24965 9.43644 2.16234 9.43644ZM9.76425 7.78387C9.76425 8.69656 9.02436 9.43644 8.11168 9.43644C7.19899 9.43644 6.45911 8.69656 6.45911 7.78387C6.45911 6.87118 7.19899 6.1313 8.11168 6.1313C9.02436 6.1313 9.76425 6.87118 9.76425 7.78387ZM14.061 9.43644C14.9737 9.43644 15.7136 8.69656 15.7136 7.78387C15.7136 6.87118 14.9737 6.1313 14.061 6.1313C13.1483 6.1313 12.4084 6.87118 12.4084 7.78387C12.4084 8.69656 13.1483 9.43644 14.061 9.43644Z" fill="#E96424"/>
                    </svg>
                </button>

                <button>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <input type="text" placeholder="Type Something. . ." class="h-11 px-4 py-2 border border-grey rounded-lg leading-tight focus:outline-none">
    </div>
    {{-- ./Page Subtitle --}}

    {{-- Description --}}
    <div class="mt-10 flex flex-col gap-3">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-darker-blue font-medium">
                Description
                <span class="text-[#EA0202]">*</span>
            </h2>

            <div class="flex items-center gap-3 text-primary">
                <button>
                    <i class="fas fa-plus"></i>
                </button>

                <button>
                    <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.16234 4.1484C3.07502 4.1484 3.81491 3.40852 3.81491 2.49583C3.81491 1.58314 3.07502 0.843262 2.16234 0.843262C1.24965 0.843262 0.509766 1.58314 0.509766 2.49583C0.509766 3.40852 1.24965 4.1484 2.16234 4.1484ZM8.11168 4.1484C9.02436 4.1484 9.76425 3.40852 9.76425 2.49583C9.76425 1.58314 9.02436 0.843262 8.11168 0.843262C7.19899 0.843262 6.45911 1.58314 6.45911 2.49583C6.45911 3.40852 7.19899 4.1484 8.11168 4.1484ZM15.7136 2.49583C15.7136 3.40852 14.9737 4.1484 14.061 4.1484C13.1483 4.1484 12.4084 3.40852 12.4084 2.49583C12.4084 1.58314 13.1483 0.843262 14.061 0.843262C14.9737 0.843262 15.7136 1.58314 15.7136 2.49583ZM2.16234 9.43644C3.07502 9.43644 3.81491 8.69656 3.81491 7.78387C3.81491 6.87118 3.07502 6.1313 2.16234 6.1313C1.24965 6.1313 0.509766 6.87118 0.509766 7.78387C0.509766 8.69656 1.24965 9.43644 2.16234 9.43644ZM9.76425 7.78387C9.76425 8.69656 9.02436 9.43644 8.11168 9.43644C7.19899 9.43644 6.45911 8.69656 6.45911 7.78387C6.45911 6.87118 7.19899 6.1313 8.11168 6.1313C9.02436 6.1313 9.76425 6.87118 9.76425 7.78387ZM14.061 9.43644C14.9737 9.43644 15.7136 8.69656 15.7136 7.78387C15.7136 6.87118 14.9737 6.1313 14.061 6.1313C13.1483 6.1313 12.4084 6.87118 12.4084 7.78387C12.4084 8.69656 13.1483 9.43644 14.061 9.43644Z" fill="#E96424"/>
                    </svg>
                </button>

                <button>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <textarea name="problem" id="problem" cols="30" rows="10">{{old('problem')}}</textarea>
    </div>
    {{-- ./Description --}}

    {{-- Image or Video --}}
    <div class="mt-10 flex flex-col gap-3">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-darker-blue font-medium">
                Image or Video (Optional)
            </h2>

            <div class="flex items-center gap-3 text-primary">
                <button>
                    <i class="fas fa-plus"></i>
                </button>

                <button>
                    <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.16234 4.1484C3.07502 4.1484 3.81491 3.40852 3.81491 2.49583C3.81491 1.58314 3.07502 0.843262 2.16234 0.843262C1.24965 0.843262 0.509766 1.58314 0.509766 2.49583C0.509766 3.40852 1.24965 4.1484 2.16234 4.1484ZM8.11168 4.1484C9.02436 4.1484 9.76425 3.40852 9.76425 2.49583C9.76425 1.58314 9.02436 0.843262 8.11168 0.843262C7.19899 0.843262 6.45911 1.58314 6.45911 2.49583C6.45911 3.40852 7.19899 4.1484 8.11168 4.1484ZM15.7136 2.49583C15.7136 3.40852 14.9737 4.1484 14.061 4.1484C13.1483 4.1484 12.4084 3.40852 12.4084 2.49583C12.4084 1.58314 13.1483 0.843262 14.061 0.843262C14.9737 0.843262 15.7136 1.58314 15.7136 2.49583ZM2.16234 9.43644C3.07502 9.43644 3.81491 8.69656 3.81491 7.78387C3.81491 6.87118 3.07502 6.1313 2.16234 6.1313C1.24965 6.1313 0.509766 6.87118 0.509766 7.78387C0.509766 8.69656 1.24965 9.43644 2.16234 9.43644ZM9.76425 7.78387C9.76425 8.69656 9.02436 9.43644 8.11168 9.43644C7.19899 9.43644 6.45911 8.69656 6.45911 7.78387C6.45911 6.87118 7.19899 6.1313 8.11168 6.1313C9.02436 6.1313 9.76425 6.87118 9.76425 7.78387ZM14.061 9.43644C14.9737 9.43644 15.7136 8.69656 15.7136 7.78387C15.7136 6.87118 14.9737 6.1313 14.061 6.1313C13.1483 6.1313 12.4084 6.87118 12.4084 7.78387C12.4084 8.69656 13.1483 9.43644 14.061 9.43644Z" fill="#E96424"/>
                    </svg>
                </button>

                <button>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <input hidden type="file" id="input-image-video">

        <label for="input-image-video" class="min-h-[8rem] border-2 border-dashed border-grey flex flex-col justify-center items-center">
            <p class="text-lg text-grey font-light">
                Drag & Drop your file or Browse
            </p>

            <p class="mt-2 text-sm text-light-blue font-light">
                Maximum size 300kb
            </p>
        </label>
    </div>
    {{-- ./Image or Video --}}

    {{-- Upload File --}}
    <div class="mt-10 flex flex-col gap-3">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-darker-blue font-medium">
                Upload File (Optional)
            </h2>

            <div class="flex items-center gap-3 text-primary">
                <button>
                    <i class="fas fa-plus"></i>
                </button>

                <button>
                    <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.16234 4.1484C3.07502 4.1484 3.81491 3.40852 3.81491 2.49583C3.81491 1.58314 3.07502 0.843262 2.16234 0.843262C1.24965 0.843262 0.509766 1.58314 0.509766 2.49583C0.509766 3.40852 1.24965 4.1484 2.16234 4.1484ZM8.11168 4.1484C9.02436 4.1484 9.76425 3.40852 9.76425 2.49583C9.76425 1.58314 9.02436 0.843262 8.11168 0.843262C7.19899 0.843262 6.45911 1.58314 6.45911 2.49583C6.45911 3.40852 7.19899 4.1484 8.11168 4.1484ZM15.7136 2.49583C15.7136 3.40852 14.9737 4.1484 14.061 4.1484C13.1483 4.1484 12.4084 3.40852 12.4084 2.49583C12.4084 1.58314 13.1483 0.843262 14.061 0.843262C14.9737 0.843262 15.7136 1.58314 15.7136 2.49583ZM2.16234 9.43644C3.07502 9.43644 3.81491 8.69656 3.81491 7.78387C3.81491 6.87118 3.07502 6.1313 2.16234 6.1313C1.24965 6.1313 0.509766 6.87118 0.509766 7.78387C0.509766 8.69656 1.24965 9.43644 2.16234 9.43644ZM9.76425 7.78387C9.76425 8.69656 9.02436 9.43644 8.11168 9.43644C7.19899 9.43644 6.45911 8.69656 6.45911 7.78387C6.45911 6.87118 7.19899 6.1313 8.11168 6.1313C9.02436 6.1313 9.76425 6.87118 9.76425 7.78387ZM14.061 9.43644C14.9737 9.43644 15.7136 8.69656 15.7136 7.78387C15.7136 6.87118 14.9737 6.1313 14.061 6.1313C13.1483 6.1313 12.4084 6.87118 12.4084 7.78387C12.4084 8.69656 13.1483 9.43644 14.061 9.43644Z" fill="#E96424"/>
                    </svg>
                </button>

                <button>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <input hidden type="file" id="input-file">

        <label for="input-file" class="min-h-[8rem] border-2 border-dashed border-grey flex flex-col justify-center items-center cursor-pointer">
            <p class="text-lg text-grey font-light">
                Drag & Drop your file or Browse
            </p>

            <p class="mt-2 text-sm text-light-blue font-light">
                Maximum size 300kb
            </p>
        </label>
    </div>
    {{-- ./Upload File --}}

    {{-- Group Section --}}
    <div class="mt-10 flex flex-col gap-3">
        <div class="flex justify-between items-center">
            <h2 class="text-xl text-darker-blue font-medium">
                Group Section
                {{-- <span class="text-[#EA0202]">*</span> --}}
            </h2>
        </div>

        <select class="h-11 px-4 py-2 border border-grey rounded-lg leading-tight focus:outline-none">
            <option value="" hidden>Select Section</option>
            <option value="a">Section A</option>
            <option value="b">Section B</option>
            <option value="c">Section C</option>
        </select>
    </div>
    {{-- ./Group Section --}}

    <button class="mt-10 px-14 py-1 bg-primary rounded-full text-sm text-white">
        Save
    </button>
</div>
{{-- ./Form --}}
@endsection
