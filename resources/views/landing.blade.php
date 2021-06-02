@extends('layouts.app')
@section('content')

{{--    This is the home page you are {{ Auth::guest() ? "not" : "" }} logged in {{ Auth::guest() ? "" : (" and your account is " . (Auth::user()->isVerified() ? "" : "not")." verified") }}--}}
{{--    @auth--}}
{{--        <form method="post" action="{{ route('logout') }}">@csrf--}}
{{--            <button type="submit">Logout</button>--}}
{{--        </form>--}}
{{--    @endauth--}}
<h1 class="bg-green-200 py-4 text-center text-2xl top-0">Play Ground</h1>
{{-- @include('auth.register') --}}
@include('auth.login')
    {{-- <creat-post></creat-post> --}}

{{-- <button title="Add new Post" class="modal-open w-full h-12 px-2 bg-white border shadow-2xl rounded-lg flex justify-center items-center mt-2 outline-none focus:outline-none focus:ring-logo-red focus:border-logo-red focus:text-logo-red hover:text-logo-red hover:border-logo-red">
    <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
</button> --}}
{{-- @include('Posts.create-new') --}}
{{-- <post></post> --}}
{{-- <profile-type></profile-type> --}}
{{-- <play-ground></play-ground>  --}}
@endsection
