@php
    if (Route::is('dashboard.partner.partnerProjects')) {
        $backUrl = route('dashboard.institutions_partners');
        $partnerId = $partner->id;
        $partnerName = $partner->name;
        $addProjectUrl = route('partner.partnerProjectsCreate', ['partner' => $partner->id]);
    } else {
        $backUrl = null;
        $partnerId = null;
        $partnerName = 'Intel Corp.';
        $addProjectUrl = route('dashboard.projects.create');
    }

    $isDraft = Route::is('dashboard.projects.draft');
@endphp

@extends('layouts.admin2')
@section('title', 'Projects')
@section('more-css')
    @livewireStyles
@endsection

@section('content')
@if ($backUrl)
    <div class="mb-2">
        <a href="{{ $backUrl }}" class="text-lg text-[#6973C6] hover:underline">
            <span class="mr-3"><</span>
            Back
        </a>
    </div>
@endif

{{-- Header --}}
<div class="flex justify-between items-center">
    <h1 class="text-dark-blue font-medium text-[1.375rem]">
        {{ $partnerName }}
        <span class="mx-3">></span>
        Projects
    </h1>

    @if (Auth::guard('web')->check())
        <a href="{{ $addProjectUrl }}" class="flex items-center gap-3 text-xl text-dark-blue">
            <i class="fas fa-plus-circle mt-1 text-primary"></i>
            Add Project
        </a>
    @endif
</div>
{{-- ./Header --}}

<div class="mt-6">
    @livewire('projects-table', ['partnerId' => $partnerId, 'isDraft' => $isDraft])
</div>
@endsection

@section('more-js')
    @livewireScripts
@endsection
