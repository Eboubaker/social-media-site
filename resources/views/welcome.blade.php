@extends('layouts.app')
@section('content')
{{--    This is the home page you are {{ Auth::guest() ? "not" : "" }} logged in {{ Auth::guest() ? "" : (" and your account is " . (Auth::user()->isVerified() ? "" : "not")." verified") }}--}}
{{--    @auth--}}
{{--        <form method="post" action="{{ route('logout') }}">@csrf--}}
{{--            <button type="submit">Logout</button>--}}
{{--        </form>--}}
{{--    @endauth--}}
@endsection
