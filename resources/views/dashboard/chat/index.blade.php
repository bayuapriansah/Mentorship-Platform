@extends('layouts.admin2')
@section('content')
    {{ $team_name }}
    @livewire('chat-with-team', ['team_name' => $team_name])
@endsection
@section('more-js')
@endsection
