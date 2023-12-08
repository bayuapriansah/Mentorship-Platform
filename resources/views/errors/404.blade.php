@php
    $message = 'Page Not Found';

    if (isset($exception)) {
        $message = $exception->getMessage() !== '' ? $exception->getMessage() : $message;
    }
@endphp

@extends('layouts.error')
@section('code', '404')
@section('message', $message)
