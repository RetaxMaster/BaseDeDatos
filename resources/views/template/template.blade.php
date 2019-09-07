<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset(env("css")."bootstrap.min.css") }}">
    <link rel="stylesheet" href="{{ asset(env("css")."style.css") }}">
    <link rel="stylesheet" href="{{ asset(env("css")."queries.css") }}">
    <link rel="stylesheet" href="{{ asset(env("css")."modal.css") }}">
    @yield('css', "")
    <title>@yield('title', "Base de datos")</title>
</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="{{ route("home") }}">Base de datos</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            @if (auth()->user())      
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Panel de admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-power-off"></i></a>
                    </li>
                </ul>
            </div>
            @endif
        </nav>
    </header>
    
    <div class="margin-grid">
        @yield('content')
    </div>

    @routes
    <script src="{{ asset(env("js")."lib/bootstrap.min.js") }}"></script>
    <script src="{{ asset(env("js")."lib/all.min.js") }}"></script>
    <script src="{{ asset(env("js")."lib/modifiers.js") }}"></script>
    @yield('scripts', "")
</body>
</html>