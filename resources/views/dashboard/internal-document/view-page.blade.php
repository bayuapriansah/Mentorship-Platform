@extends('layouts.admin2')

@section('more-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
@endsection

@section('content')
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

        <div role="group" class="splide w-[50vw] lg:w-[60vw] max-w-[1000px] mt-8 p-8">
            <div class="splide__track">
                <div class="splide__list">
                    @foreach ($files as $file)
                    <div class="splide__slide">
                        <div class="w-[250px] mx-auto px-4 py-8 bg-white border border-grey rounded-lg flex flex-col items-center">
                            <img src="{{ $file['logo'] }}" alt="{{ $file['name'] }}" class="w-[100px] h-[100px]">

                            <p class="mt-6 text-sm text-center">
                                {{ str_replace('internal-document/', '', $file['name']) }}
                            </p>

                            <a href="{{ $file['url'] }}" target="_blank" class="mt-4 px-6 py-1 bg-primary rounded-full text-white text-sm flex justify-center items-center gap-3">
                                Download
                                <i class="fas fa-download fa-sm"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>


        <article class="mt-12 prose prose-neutral lg:prose-lg">
            {!! $page->files_footer_info !!}
        </article>
    @endif
</div>
@endsection

@section('more-js')
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script>
        document.addEventListener( 'DOMContentLoaded', function() {
            new Splide('.splide', {
                perPage: 3,
                perMove: 1,
            }).mount()
        })
    </script>
@endsection
