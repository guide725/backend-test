<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>
        @include('layouts.partials.head')
        <!-- Fonts -->

    </head>
    <style>
        *{
            font-family: 'Nunito', sans-serif;
            margin:0;
            padding:0;
            box-sizing: border-box;
            text-decoration: none;
        }
    </style>
<body>
    @include('layouts.partials.nav')

    @yield('content')

    @include('layouts.partials.footer')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" ></script>
</body>
</html>
