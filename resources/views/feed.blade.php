@extends('layouts.app')     

@section('content')
<div class="flex flex-row justify-between bg-gray-100">
    <div class="md:w-1/2 mt-20">@include('layouts.left-side')</div>
    <div class="md:w-3/4 mt-20">
        <x-post-card />
        <x-post-card />
        <x-post-card />
    </div>
    <div class="md:w-1/2 mt-20">@include('layouts.right-side')</div>
</div>
@endsection