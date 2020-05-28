<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/additional.css') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo_title.png') }}">
        <script src="{{ asset('js/etc.js') }}"></script>


        <title>{{ config('app.name', 'Laravel') }}</title>

    </head>
    <body>
        
        @yield('content')
    
        <!-- Scripts -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
        <script src="{{ asset('js/effects.js') }}"></script>
        <script src="{{ asset('js/additional.js') }}"></script>
        <script src="{{ asset('js/react-build.js') }}"></script>

        <script src="/react-utilities/static/js/2.629c8490.chunk.js"></script>
        <script src="/react-utilities/static/js/main.51143d39.chunk.js"></script>

    </body>
</html>
