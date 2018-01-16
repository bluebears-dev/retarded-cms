<?php
/**
 * User: pgorski42
 * Date: 22.10.17
 * Time: 00:09
 */
?>
<html lang="en">
@include('templates.default.head')
<body>
    <nav class="navbar navbar navbar-expand-lg navbar-dark bg-dark d-print-none">
        <ul class="navbar-nav mr-auto">
            @foreach(\App\Menu::all() as $entry)
                <?php $route = \App\Menu::fetch($entry->page) ?>
                <li class="nav-item {{ Request::path() === $route ? 'active' : ''}}">
                    <a class="nav-link" href="{{$route}}">{{ $entry->entry }}</a>
                </li>
            @endforeach
        </ul>
    </nav>
    <div class="jumbotron jumbotron-fluid mb-0 d-flex h-100">
        <main class="container">
            <h1 class="display-4">Simple site</h1>
            <hr>
            <p class="lead">@markdown($content)</p>
        </main>
    </div>
    <footer class="fixed-bottom d-flex p-1 bg-dark text-gray border border-secondary border-right-0 border-left-0 d-print-none">
        <small>Created by Paweł Górski 2018.01.16</small>
    </footer>
</body>
@include('templates.default.scripts')
</html>