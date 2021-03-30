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
    
<style>
    .content {
        overflow-y: scroll;
        -webkit-mask-image: linear-gradient(to top, transparent, gray),
        linear-gradient(to left, transparent , gray );
        -webkit-mask-size: 100% 20000px;
        -webkit-mask-position: left bottom;
        transition: mask-position 0.3s, -webkit-mask-position 0.3s;
    }
  
    .content:hover {
        -webkit-mask-position: left top;
    }
    /* width */
    ::-webkit-scrollbar {
        width: 10px;
    }
    /* Track */
    ::-webkit-scrollbar-track {
        background: white; 
        border-radius: 5px;
    }
    
    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #888; 
        border-radius: 5px;
    }
    
    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555; 
    }
</style>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{asset('css/lightslider.css')}}" /> --}}
    @stack('header')
    {{-- <script src="{{asset('js/jQuery.js')}}"></script> --}}
    {{-- <script src="{{asset('js/lightslider.js')}}"></script> --}}

    {{--    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"--}}
{{--          rel="stylesheet">--}}
</head>
<body class="text-logo-black">
    @include('layouts.top-nav')
    <div id="app">
        @yield('content')
    </div>
    @stack('scripts')
</body>

</html>
