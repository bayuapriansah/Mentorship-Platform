@extends('layouts.admin2')

@section('more-css')
    @livewireStyles
@endsection

@section('content')
<a href="{{ route('dashboard.admin') }}" class="group block text-lg text-[#6973C6]">
    <
    <span class="ml-2 group-hover:underline">
        Back
    </span>
</a>

<div class="mt-2 flex justify-between items-center">
    <h1 class="text-dark-blue font-medium text-[1.375rem]">
        All Messages
    </h1>

    <a href="{{ route('dashboard.messages.create') }}" class="group flex items-center gap-3">
        <svg class="mt-1" width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_4187_8193)">
                <path d="M26.9805 16.0417C27.2284 16.0417 27.4763 16.0563 27.7096 16.0855V10.0188C27.7096 8.51675 26.4846 7.29175 24.9825 7.29175H5.64505C4.14297 7.29175 2.91797 8.51675 2.91797 10.0188V24.9813C2.91797 26.4834 4.14297 27.7084 5.64505 27.7084H19.8346C19.2805 26.6147 18.9596 25.3751 18.9596 24.0626C18.9596 19.6292 22.5471 16.0417 26.9805 16.0417ZM15.168 18.9584L5.83464 13.4022V10.2084H6.17005L15.1826 15.5751L24.4138 10.2084H24.793V13.3584L15.168 18.9584Z" fill="#E96424"/>
                <path d="M27.7083 18.9585L25.6521 21.0147L27.9563 23.3335H21.875V26.2502H27.9563L25.6521 28.5689L27.7083 30.6252L33.5417 24.7918L27.7083 18.9585Z" fill="#E96424"/>
            </g>
            <defs>
                <clipPath id="clip0_4187_8193">
                    <rect width="35" height="35" fill="white"/>
                </clipPath>
            </defs>
        </svg>

        <span class="text-xl text-dark-blue group-hover:underline">
            New Message
        </span>
    </a>
</div>

<div class="mt-6">
    @livewire('messages-table')
</div>
@endsection

@section('more-js')
    @livewireScripts
@endsection
