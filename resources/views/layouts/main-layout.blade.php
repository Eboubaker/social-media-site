@extends('layouts.app')
@section('content')
    @include('layouts.top-nav')
    @yield('main-content')
    @include('layouts.right-side')
@endsection
