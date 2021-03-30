@extends('layouts.app')
@section('content')
{{--    This is the home page you are {{ Auth::guest() ? "not" : "" }} logged in {{ Auth::guest() ? "" : (" and your account is " . (Auth::user()->isVerified() ? "" : "not")." verified") }}--}}
{{--    @auth--}}
{{--        <form method="post" action="{{ route('logout') }}">@csrf--}}
{{--            <button type="submit">Logout</button>--}}
{{--        </form>--}}
{{--    @endauth--}}
<div class="bg-red-100 w-full h-full">
    <x-scroll-view class="w-1/2 mx-auto" auto-scroll keep-scrolling chevron-class="w-14" {{--chevron-inner-color="text-red-600"--}}>
        @for($i = 1; $i < 10; $i++)
            <div class="mx-1"><a href="#" class="box flex flex-col justify-center items-center w-36 h-44 bg-white divide-y divide-gray-100 shadow-2xl rounded-lg overflow-hidden m-8"> <div class="slide-img">Quick {{ $i }}</div> <img class="flex-auto" src="/img/logo.png" alt/></a></div>
        @endfor
    </x-scroll-view>
</div>
@endsection
