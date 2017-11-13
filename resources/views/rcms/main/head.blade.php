<?php
/**
 * User: pgorski42
 * Date: 26.10.17
 * Time: 00:20
 */
?>
<head>
    <title>@yield('title')</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    @stack('css')
</head>