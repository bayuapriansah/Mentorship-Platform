@extends('layouts.admin2')

@section('more-css')
    @livewireStyles
@endsection

@section('content')
<a href="{{ route('dashboard.projects.index') }}" class="block text-lg text-[#6973C6]">
    <
    <span class="ml-2 hover:underline">
        Back
    </span>
</a>

<h1 class="mt-2 text-dark-blue font-medium text-[1.375rem]">
    {{ substr($project->name, 0, 34) }}
    <span class="mx-3">></span>
    Enrollment
</h1>

<div class="mt-6">
    @livewire('project-enrollment-table', ['project' => $project])
</div>
@endsection

@section('more-js')
    @livewireScripts
@endsection
