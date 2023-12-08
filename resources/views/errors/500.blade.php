@php
    $message = 'Internal Server Error';

    if (isset($exception)) {
        $message = $exception->getMessage() !== '' ? $exception->getMessage() : $message;
    }
@endphp

@extends('layouts.error')
@section('code', '500')
@section('message', $message)
