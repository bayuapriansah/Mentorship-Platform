@extends('layouts.admin2')

@section('title', 'Participants')

@section('more-css')
    @livewireStyles
@endsection

@section('content')
<a href="{{ route('dashboard.staffs.index') }}" class="group block text-lg text-[#6973C6]">
    <
    <span class="ml-2 group-hover:underline">
        Back
    </span>
</a>

<h1 class="mt-2 text-dark-blue font-medium text-[1.375rem]">
    {{ $staff->institution_id === 0 ? 'Staff' : 'Mentor' }}
    <span class="mx-3">></span>
    {{ $staff->first_name }} {{ $staff->last_name }}
    <span class="mx-3">></span>
    Participants
</h1>

<div class="mt-6">
    @livewire('mentor-participants-table', ['mentor' => $staff])
</div>
@endsection

@section('more-js')
    @livewireScripts
@endsection
