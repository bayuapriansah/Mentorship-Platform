@extends('layouts.index')

@section('more-css')
    <style>
        .active-button {
            background: linear-gradient(182deg, rgba(255, 143, 81, 0.15) 19.95%, rgba(255, 255, 255, 0.00) 99.87%);
        }
    </style>
@endsection

@section('content')
<div class="relative overflow-y-clip">
    {{-- Header --}}
    <div class="bg-black bg-center bg-cover bg-no-repeat" style="background-image: url({{ asset('/assets/img/main/header-bg.png') }})">
        <div class="max-w-[1366px] mx-auto px-[4.5rem] py-10">
            <h1 class="font-bold text-[#FF8F51] text-3xl">
                Frequently Asked Questions
            </h1>
        </div>
    </div>
    {{-- ./Header --}}

    {{-- Main Content --}}
    <div x-data="{ activeSection: 'General' }" class="relative z-[2] max-w-[1366px] mx-auto pt-14 pb-24 px-20">
        <div class="grid grid-cols-12 gap-12">
            <div class="col-span-4 space-y-5">
                @foreach ($faq as $section => $item)
                    <button
                        x-on:click="activeSection = '{{ $section }}'"
                        x-bind:class="activeSection == '{{ $section }}' && 'active-button'"
                        class="w-[285px] h-[58px] px-3 bg-white border border-grey rounded-xl flex justify-between items-center text-darker-blue hover:shadow-lg hover:scale-110 transition-transform duration-500"
                    >
                        <p class="text-2xl font-medium">
                            {{ $section }}
                        </p>

                        <i x-bind:class="activeSection == '{{ $section }}' ? 'fas fa-chevron-right' : 'fas fa-chevron-down'"></i>
                    </button>
                @endforeach
            </div>

            {{-- General --}}
            <template x-cloak x-if="activeSection == 'General'">
                <div class="col-span-8 space-y-4">
                    @foreach ($faq['General'] as $item)
                        <div
                            x-data="{ isExpanded: false }"
                            class="px-6 py-4 bg-white border border-grey rounded-xl hover:shadow-lg hover:scale-105 transition-transform duration-500"
                        >
                            <button
                                x-on:click="isExpanded = !isExpanded"
                                x-bind:class="isExpanded && 'font-medium'"
                                class="w-full flex justify-between items-center gap-4"
                            >
                                <p class="text-lg">
                                    {{ $item['question'] }}
                                </p>

                                <i x-bind:class="isExpanded ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                            </button>

                            <p x-cloak x-show="isExpanded" class="mt-5 text-sm">
                                {{ $item['answer'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </template>
            {{-- ./General --}}

            {{-- Skills Track --}}
            <template x-cloak x-if="activeSection == 'Skills Track'">
                <div class="col-span-8 space-y-4">
                    @foreach ($faq['Skills Track'] as $item)
                        <div
                            x-data="{ isExpanded: false }"
                            class="px-6 py-4 bg-white border border-grey rounded-xl hover:shadow-lg hover:scale-105 transition-transform duration-500"
                        >
                            <button
                                x-on:click="isExpanded = !isExpanded"
                                x-bind:class="isExpanded && 'font-medium'"
                                class="w-full flex justify-between items-center gap-4"
                            >
                                <p class="text-lg">
                                    {{ $item['question'] }}
                                </p>

                                <i x-bind:class="isExpanded ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                            </button>

                            <p x-cloak x-show="isExpanded" class="mt-5 text-sm">
                                {{ $item['answer'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </template>
            {{-- ./Skills Track --}}

            {{-- Entrepreneur Track --}}
            <template x-cloak x-if="activeSection == 'Entrepreneur Track'">
                <div class="col-span-8 space-y-4">
                    @foreach ($faq['Entrepreneur Track'] as $item)
                        <div
                            x-data="{ isExpanded: false }"
                            class="px-6 py-4 bg-white border border-grey rounded-xl hover:shadow-lg hover:scale-105 transition-transform duration-500"
                        >
                            <button
                                x-on:click="isExpanded = !isExpanded"
                                x-bind:class="isExpanded && 'font-medium'"
                                class="w-full flex justify-between items-center gap-4"
                            >
                                <p class="text-lg">
                                    {{ $item['question'] }}
                                </p>

                                <i x-bind:class="isExpanded ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                            </button>

                            <p x-cloak x-show="isExpanded" class="mt-5 text-sm">
                                {{ $item['answer'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </template>
            {{-- ./Entrepreneur Track --}}
        </div>
    </div>
    {{-- ./Main Content --}}

    {{-- Wave Effect --}}
    <div
        class="absolute -bottom-[5%] left-1/2 -translate-x-1/2 w-full h-[645.315px] bg-center bg-cover bg-no-repeat"
        style="background-image: url({{ asset('/assets/img/purple-wave.svg') }})"
    ></div>
</div>
@endsection
