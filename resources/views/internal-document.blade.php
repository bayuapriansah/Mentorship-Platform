@extends('layouts.index')

@section('content')
<div id="main-content" class="relative min-h-screen max-w-screen-xl mx-auto px-8 py-16">
    {{-- Dots - top-right --}}
    <div
        class="absolute -top-14 -right-14 w-[339px] h-[186px] bg-no-repeat"
        style="background: url({{ asset('/assets/img/icon/profile/dots.png') }}), transparent -0.123px -12.977px / 100.073% 106.977% no-repeat"
    ></div>

    {{-- Dots - center-left --}}
    <div
        class="absolute top-[50%] -left-28 w-[339px] h-[186px] bg-no-repeat"
        style="background: url({{ asset('/assets/img/icon/profile/dots.png') }}), transparent -0.123px -12.977px / 100.073% 106.977% no-repeat"
    ></div>

    {{-- Shadow - top-left --}}
    <div
        class="absolute -top-20 -left-[40%] translate-x-[40%] w-[621px] h-[621px] bg-[#E4E7FF] rounded-full opacity-60 blur-[100px]"
    ></div>

    {{-- Shadow - center-right --}}
    <div
        class="absolute top-[47.5%] -right-[40%] -translate-x-[40%] w-[621px] h-[621px] bg-[#E4E7FF] rounded-full opacity-60 blur-[100px]"
    ></div>

    <h1 class="relative z-[2] text-center text-3xl text-darker-blue font-bold">
        {{ $page->title }}
    </h1>

    <div class="relative z-[2] mt-20 grid grid-cols-12 gap-8">
        {{-- Group Sections --}}
        <div class="col-span-2">
            <p class="text-xl text-darker-blue font-medium">
                Group Sections
            </p>

            <div class="mt-4 flex flex-col gap-5">
                @foreach ($groupSections as $section)
                    <div x-data="{ isExpanded: '{{ $section->id === $page->internal_document_group_section_id }}' }" class="flex flex-col gap-4 text-sm">
                        <button x-on:click="isExpanded = !isExpanded" class="w-max flex items-center gap-3 hover:font-medium">
                            <i x-bind:class="isExpanded ? 'fas fa-chevron-down fa-xs' : 'fas fa-chevron-right fa-xs'"></i>
                            {{ $section->name }}
                        </button>

                        @if (count($section->internalDocumentPages) > 0)
                            <div x-cloak x-show="isExpanded" class="pl-6 flex flex-col gap-3">
                                @foreach ($section->internalDocumentPages as $sectionPage)
                                    <a href="{{ route('internal-document', ['slug' => $sectionPage->slug]) }}" class="{{ $sectionPage->id === $page->id ? 'bg-[#E4E7FF]' : '' }} px-2 rounded-md hover:bg-[#E4E7FF]">
                                        {{ $sectionPage->title }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        {{-- ./Group Sections --}}

        {{-- Page Content --}}
        <div class="col-span-8 flex flex-col items-center">
            <article class="prose prose-neutral lg:prose-lg">
                {!! $page->description !!}
            </article>

            @if (count($files) > 0)
                <h1 class="mt-16 text-2xl text-center text-darker-blue font-medium">
                    Download Your File Document?
                </h1>

                <article class="mt-4 prose prose-neutral lg:prose-lg">
                    {!! $page->files_header_info !!}
                </article>

                <div class="w-full mt-8 pb-16 overflow-x-auto flex gap-8">
                    @foreach ($files as $file)
                        <div class="px-8 py-4 bg-white rounded-lg flex flex-col items-center gap-6 cursor-pointer hover:scale-110 transition-transform duration-300" style="box-shadow: 4px 4px 7px 0px rgba(0, 0, 0, 0.18);">
                            <img src="{{ $file['logo'] }}" alt="{{ $file['name'] }}" class="w-[100px] h-auto">

                            <div class="mt-auto">
                                <p class="text-sm text-center">
                                    {{ substr(str_replace('internal-document/', '', $file['name']), 0, 35) }}{{ strlen(str_replace('internal-document/', '', $file['name'])) >= 35 ? '...' : '' }}
                                </p>

                                <a href="{{ $file['url'] }}" target="_blank" class="mt-4 px-6 py-1 bg-primary rounded-full text-white text-sm flex justify-center items-center gap-3">
                                    Download
                                    <i class="fas fa-download fa-sm"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <article class="mt-12 prose prose-neutral lg:prose-lg">
                    {!! $page->files_footer_info !!}
                </article>
            @endif
        </div>
        {{-- ./Page Content --}}
        <style>
            /* This styles the scrollbar track */
            ::-webkit-scrollbar {
            width: 8px;
            height: 8px; /* height of the horizontal scrollbar */
            background-color: #f5f5f5; /* background of the scrollbar track */
            }

            /* This styles the scrollbar thumb (the draggable element) */
            ::-webkit-scrollbar-thumb {
            background-color: #888; /* color of the scrollbar thumb */
            border-radius: 6px; /* roundness of the scrollbar thumb */
            border: 2px solid #f5f5f5; /* creates padding around the scrollbar thumb */
            }

            /* This styles the scrollbar thumb on hover */
            ::-webkit-scrollbar-thumb:hover {
            background-color: #555; /* color of the scrollbar thumb on hover */
            }
        </style>
        {{-- Internal Page Sections --}}
        <div class="col-span-2">
            <p class="text-xl text-darker-blue font-medium">
                On This page
            </p>

            <div id="internal-section-link" class="mt-4 flex flex-col gap-5"></div>
        </div>
        {{-- ./Internal Page Sections --}}
    </div>
</div>
@endsection

@section('more-js')
    <script>
        $(function() {
            $('h3').each(function(index) {
                $(this).attr('id', `internal-section-${index + 1}`)

                $('#internal-section-link').append(`
                    <a href="#${$(this).attr('id')}" class="px-2 rounded-md hover:font-medium">
                        ${$(this).text()}
                    </a>
                `)
            })
        })
    </script>
@endsection
