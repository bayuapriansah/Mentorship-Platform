@extends('layouts.admin2')

@section('content')
<div class="w-[75vw]">
    <h1 class="mt-2 text-dark-blue font-medium text-[1.375rem]">
        <a href="{{ route('dashboard.internal-document.all-pages.index') }}" class="hover:underline">
            Internal Document
        </a>
        <span class="mx-3">></span>
        View
        <span class="mx-3">></span>
        {{ substr($page->title, 0, 35) }}{{ strlen($page->title) >= 35 ? '...' : '' }}
    </h1>

    <hr class="mt-5 mb-8 border- border-grey">

    <div class="lg:px-16 flex flex-col items-center">
        <h1 class="text-3xl text-center text-darker-blue font-bold">
            {{ $page->title }}
        </h1>

        <article class="mt-16 prose prose-neutral lg:prose-lg">
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
</div>
@endsection
