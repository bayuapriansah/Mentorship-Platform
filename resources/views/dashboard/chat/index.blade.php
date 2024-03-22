@extends('layouts.admin2')
@section('more-css')
    @livewireStyles
@endsection

@section('content')
    <div class="flex gap-2">
        <div class="w-1/6">
            @foreach ($students->groupBy('team_name') as $key => $team)
                <a href="{{ route('dashboard.chat', ['team' => $key]) }}"
                    class="block p-3 rounded-lg border hover:bg-gray-100 cursor-pointer">
                    {{ $key }}
                </a>
            @endforeach
        </div>
        <div class="w-5/6">
            @livewire('chat-with-team', ['team_name' => $team_name])
        </div>
    </div>
@endsection
@section('more-js')
    @livewireScripts
@endsection
