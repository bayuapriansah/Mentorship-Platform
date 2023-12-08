@php
    $message = 'Bad Request';

    if (isset($exception)) {
        $message = $exception->getMessage() !== '' ? $exception->getMessage() : $message;
    }
@endphp

@extends('layouts.error')
@section('code', '400')
@section('message', $message)
