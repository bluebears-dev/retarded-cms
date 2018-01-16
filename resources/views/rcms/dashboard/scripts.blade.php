<?php
/**
 * User: pgorski42
 * Date: 23.10.17
 * Time: 23:21
 */
?>
@extends('rcms.main.scripts')

@push('scripts')
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script src={{ url('/js/rcms/dashboard.js') }}></script>
@endpush