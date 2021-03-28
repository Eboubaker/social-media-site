<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/lightslider.css')}}" />
    <script src="{{asset('js/jQuery.js')}}"></script>
    <script src="{{asset('js/lightslider.js')}}"></script>
    
{{--    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"--}}
{{--          rel="stylesheet">--}}
</head>
<body class="text-logo-black">
    <div id="app">
        @yield('content')
    </div>
    @stack('scripts')
    <script src="{{asset('js/script.js')}}"></script>
</body>

</html>
