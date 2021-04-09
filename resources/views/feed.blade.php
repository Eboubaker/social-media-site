@extends('layouts.app')     

@section('content')
<navbar></navbar>

<div class="md:flex bg-gray-100 md:py-4">
    <div class="hidden md:block md:w-96 md:fixed md:left-0 content md:overflow-auto md:h-full md:pl-4 md:pb-20">@include('layouts.left-side')</div>
    <div class="hidden md:block md:w-96"></div>
    <div class="pt-24 md:pt-0 md:w-1/2  mt-4">
        <div class="md:w-5/6 md:mx-auto"> 
        <x-scroll-view class="" auto-scroll keep-scrolling chevron-class="w-14" chevron-inner-color="">
            @for($i = 1; $i < 10; $i++)
                <div class="mx-1">
                    <a href="#" class="box flex flex-col justify-center items-center w-36 h-44 bg-white divide-y divide-gray-100 shadow-lg rounded-lg overflow-hidden m-8"> 
                        <div class="slide-img">Quick {{ $i }}</div> 
                        <img class="flex-auto" src="/img/logo.png" alt/>
                    </a>
                </div>
            @endfor
        </x-scroll-view>
        </div>
    </div>
    <div class="hidden md:block md:w-96"></div>
    <div class="hidden md:block md:w-96 md:fixed md:right-0 content md:overflow-auto md:h-full md:pb-20">@include('layouts.right-side')</div>
</div>



<div class="md:flex bg-gray-100 h-full">
    <div class="hidden md:block md:w-96"></div>
    <div class="md:w-1/2 space-y-4 pb-8">
        <div class="w-11/12 mx-auto md:w-5/6">
            
        </div>
        <post></post>
        <post></post>
        <post></post>
    </div>
    <div class="hidden md:block md:w-96"></div>
</div>
<div>
    
    {{-- @include('post.create') --}}
</div>
@endsection