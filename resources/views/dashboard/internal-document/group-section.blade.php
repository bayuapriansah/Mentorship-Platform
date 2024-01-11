@extends('layouts.admin2')

@section('more-css')
    @livewireStyles
@endsection

@section('content')
    @livewire('internal-document-group-sections-table')
@endsection

@section('more-js')
    @livewireScripts
@endsection
