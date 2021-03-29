@extends('layouts.app')
@section('content')
{{--    This is the home page you are {{ Auth::guest() ? "not" : "" }} logged in {{ Auth::guest() ? "" : (" and your account is " . (Auth::user()->isVerified() ? "" : "not")." verified") }}--}}
{{--    @auth--}}
{{--        <form method="post" action="{{ route('logout') }}">@csrf--}}
{{--            <button type="submit">Logout</button>--}}
{{--        </form>--}}
{{--    @endauth--}}
<div class="scroll-view-container w-1/2">
    <div class="scroll-left w-14">
        <svg class="w-full text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>        
    </div>
    <div class="scroll-view auto-scroll">
        <div class="flex view-slide">
            @for($i = 1; $i < 10; $i++)
                <div class="mx-1"><a href="#" class="box flex flex-col justify-center items-center w-36 h-44 bg-white divide-y divide-gray-100 shadow-2xl rounded-lg overflow-hidden m-8"><div class="slide-img">Quick {{ $i }}</div><img class="flex-auto" src="/img/logo.png" alt /></a></div>
            @endfor
        </div>
    </div>
    <div class="scroll-right w-14">
        <svg class="w-full text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </div>
</div>
@endsection
