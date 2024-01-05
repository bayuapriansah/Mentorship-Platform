@extends('layouts.admin2')

@section('content')
<div class="flex justify-between items-center">
    <h1 class="text-dark-blue font-medium text-[1.375rem]">
        Internal Document
        <span class="mx-3">></span>
        All Pages
    </h1>

    <a href="{{ route('dashboard.internal-document.all-pages.add') }}" class="flex items-center gap-3 text-xl text-dark-blue">
        <i class="fas fa-plus-circle mt-1 text-primary"></i>
        Add Page
    </a>
</div>
@endsection
