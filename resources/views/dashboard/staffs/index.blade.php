@extends('layouts.admin2')

@section('more-css')
    @livewireStyles
@endsection

@section('content')
{{-- Mentor --}}
<div class="flex justify-between items-center">
    <h1 class="text-dark-blue font-medium text-[1.375rem]">
        Mentor
    </h1>

    <a href="{{ route('dashboard.staffs.invite') . '?is_mentor=true' }}" class="flex items-center gap-3 text-xl text-dark-blue">
        <i class="fas fa-plus-circle mt-1 text-primary"></i>
        Add Mentor
    </a>
</div>

<div class="mt-6">
    @livewire('mentors-table', ['isStaff' => false])
</div>
{{-- ./Mentor --}}

{{-- Staff --}}
<div class="mt-20 flex justify-between items-center">
    <h1 class="text-dark-blue font-medium text-[1.375rem]">
        Staff
    </h1>

    <a href="{{ route('dashboard.staffs.invite') }}" class="flex items-center gap-3 text-xl text-dark-blue">
        <i class="fas fa-plus-circle mt-1 text-primary"></i>
        Add Staff
    </a>
</div>

<div class="mt-6">
    @livewire('mentors-table', ['isStaff' => true])
</div>
{{-- ./Staff --}}
@endsection

@section('more-js')
    @livewireScripts
@endsection
