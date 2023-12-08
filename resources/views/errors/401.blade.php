@php
    $message = 'Unauthorized';

    if (isset($exception)) {
        $message = $exception->getMessage() !== '' ? $exception->getMessage() : $message;
    }
@endphp

@extends('layouts.error')
@section('code', '401')
@section('message', $message)
