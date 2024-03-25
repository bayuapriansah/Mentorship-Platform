@extends('layouts.admin2')
@section('more-css')
    @livewireStyles
@endsection

@section('content')
    <div class="flex gap-2">
        <div class="w-1/6 ">
            <div class="text-xl font-medium mb-4 text-center">
                Team List
            </div>
            <div class="flex flex-col gap-1 max-h-[725px] overflow-y-auto">
                @foreach ($students->groupBy('team_name') as $key => $team)
                    @if ($key)
                        @if ($key == $team_name)
                            <a href="{{ route('dashboard.chat', ['team' => $key]) }}"
                                class="block p-3 rounded-xl border bg-gray-100 cursor-pointer">
                                {{ $key }}
                            </a>
                        @else
                            <a href="{{ route('dashboard.chat', ['team' => $key]) }}"
                                class="block p-3 rounded-xl border hover:bg-gray-100 cursor-pointer">
                                {{ $key }}
                            </a>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
        <div class="w-5/6">
            @livewire('chat-with-team', ['team_name' => $team_name])
        </div>
    </div>
@endsection
@section('more-js')
    @livewireScripts
@endsection
