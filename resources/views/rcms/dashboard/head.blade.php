<?php
/**
 * User: pgorski42
 * Date: 23.10.17
 * Time: 23:18
 */
?>
@extends('rcms.main.head')

@section('title')
    {{--{{ Auth::user() }}--}}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('/css/dashboard.css') }}">
@endpush