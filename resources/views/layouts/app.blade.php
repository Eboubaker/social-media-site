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
    {{-- <link rel="stylesheet" href="{{asset('css/lightslider.css')}}" /> --}}
    @stack('header')
    {{-- <script src="{{asset('js/jQuery.js')}}"></script> --}}
    {{-- <script src="{{asset('js/lightslider.js')}}"></script> --}}

       <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
{{--          rel="stylesheet">--}}

</head>
<body id="g-app" class="text-logo-black bg-gray-100">
    <div id="app">
        
        @yield('content')
    </div>
    @stack('scripts')
    <script defer>
        window.addEventListener('load', function(){
            Vue.prototype.$currentProfile = JSON.parse(`{!! json_encode((new App\Http\Resources\ProfileResource(App\Models\Profile::currentRelation()->with(['account', 'avatarImage', 'settings'])->firstOrNew()))->toResponse(request())->getData()->data) !!}`);
            window.app = new Vue({
                el: "#app",
            });
        })
    </script>
</body>

</html>