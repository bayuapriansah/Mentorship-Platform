@php
    $message = 'Forbidden';

    if (isset($exception)) {
        $message = $exception->getMessage() !== '' ? $exception->getMessage() : $message;
    }
@endphp

@extends('layouts.error')
@section('code', '403')
@section('message', $message)
