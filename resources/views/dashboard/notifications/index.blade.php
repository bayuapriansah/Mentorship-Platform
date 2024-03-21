@extends('layouts.admin2')

@section('title', 'Notifications')

@section('more-css')
    @livewireStyles
@endsection

@section('content')
<a href="{{ route('dashboard.admin') }}" class="group block w-max text-lg text-[#6973C6]">
    <
    <span class="ml-2 group-hover:underline">
        Back
    </span>
</a>

<h1 class="mt-2 text-dark-blue font-medium text-[1.375rem]">
    All Notifications
</h1>

<div class="mt-14">
    @livewire('notifications-table')
</div>
@endsection

@section('more-js')
    @livewireScripts
@endsection
