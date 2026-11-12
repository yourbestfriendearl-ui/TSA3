<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tasks for Today keeps daily tasks and the complete task list easy to find.">
    <title>@yield('title', 'Welcome') | Tasks for Today</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header">
    <div class="shell navigation">
        <a class="brand" href="{{ route('welcome') }}">Tasks for Today</a>
        <nav aria-label="Main navigation">
            <a href="{{ route('welcome') }}" @if(request()->routeIs('welcome')) aria-current="page" @endif>Today</a>
            <a href="{{ route('tasks.index') }}" @if(request()->routeIs('tasks.*')) aria-current="page" @endif>Task List</a>
            <a href="{{ route('profile') }}" @if(request()->routeIs('profile')) aria-current="page" @endif>Profile</a>
            <a href="{{ route('about') }}" @if(request()->routeIs('about')) aria-current="page" @endif>About</a>
        </nav>
    </div>
</header>
<main class="shell main-content" id="main">@yield('content')</main>
<footer class="shell site-footer">Developed by Earl Christian R. Velasquez <span>DX31 · IT0049 TSA3</span></footer>
</body>
</html>
