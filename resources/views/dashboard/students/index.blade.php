@php
    $allowToInvite = Route::is('dashboard.students.institutionStudents') || auth('web')->check();

    if (Route::is('dashboard.students.institutionStudents')) {
        $inviteUrl = url('/dashboard/institutions/' . $institution->id . '/students/invite');
    } else {
        $inviteUrl = route('dashboard.students.invite');
    }
@endphp

@extends('layouts.admin2')

@section('more-css')
    @livewireStyles
@endsection

@section('content')
{{-- Header --}}
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-dark-blue font-medium text-[1.375rem]">
        All Participants
    </h1>

    @if ($allowToInvite)
        <a href="{{ $inviteUrl }}" class="flex items-center gap-3 text-xl text-dark-blue">
            <i class="fas fa-plus-circle mt-1 text-primary"></i>
            Invite Participant
        </a>
    @endif
</div>
{{-- ./Header --}}

{{-- Table --}}
<div class="mt-6">
    @livewire('participants-table')
</div>
{{-- ./Table --}}
@endsection

@section('more-js')
    @livewireScripts
@endsection
