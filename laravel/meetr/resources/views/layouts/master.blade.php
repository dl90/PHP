<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('pageTitle', 'Meetr: see you soon')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        body {
            margin: 0
        }
    </style>
</head>

<body>
<nav class="links">
    <a href={{ url('/') }}>Home</a>
    <a href={{ url('/about') }}>About</a>
    <a href={{ url('/profile') }}>Profile</a>
    <a href={{ url('/events') }}>Events</a>
</nav>
@yield('bodyContent')
</body>
</html>
