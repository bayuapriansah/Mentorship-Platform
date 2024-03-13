@extends('layouts.profile.index')

@section('more-css')
    @livewireStyles
@endsection

@section('content')
<div class="max-w-[1366px] mx-auto px-16 py-12 bg-white grid grid-cols-12 gap-8 grid-flow-col items-center">
    <div class="col-span-8">
        <h1 class="text-2xl text-darker-blue font-medium">
            Chat with Team
        </h1>

        <p class="mt-3 text-lg font-light">
            Lorem ipsum dolor sit amet is simply a dummy text used as a placeholder. Lorem ipsum dolor sit amet is simply a dummy text used as a placeholder.
        </p>

        <div class="mt-9">
            @livewire('chat-with-team')
        </div>
    </div>
</div>
@endsection

@section('more-js')
    @livewireScripts
@endsection
