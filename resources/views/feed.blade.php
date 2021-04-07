@extends('layouts.main-layout')

@section('main-content')
    <div class="md:block md:flex bg-gray-100 md:py-4">
        <div class="hidden md:block md:w-96"></div>
        <div class="pt-24 md:pt-0 md:w-1/2 md:mt-12">
            <div class="md:w-5/6 md:mx-auto">
            <x-scroll-view auto-scroll keep-scrolling chevron-class="w-14">
                @for($i = 1; $i < 10; $i++)
                    <div class="mx-1"><a href="#" class="box flex flex-col justify-center items-center w-36 h-44 bg-white divide-y divide-gray-100 shadow-lg rounded-lg overflow-hidden m-8"> <div class="slide-img">Quick {{ $i }}</div> <img class="flex-auto" src="/img/logo.png" alt/></a></div>
                @endfor
            </x-scroll-view>
            </div>
        </div>
        <div class="hidden md:block md:w-96"></div>
    </div>
    <div class="md:flex bg-gray-100 h-full">
        <div class="hidden md:block md:w-96"></div>
        <div class="md:w-1/2 space-y-4 pb-8">
            <div class="w-11/12 mx-auto md:w-5/6"><x-post-card/></div>
            <div class="w-11/12 mx-auto md:w-5/6"><x-post-card/></div>
            <div class="w-11/12 mx-auto md:w-5/6"><x-post-card/></div>
        </div>
        <div class="hidden md:block md:w-96"></div>
    </div>
{{-- <div class="flex flex-col">
    <div class="bg-gray-100 w-full h-full mt-12">
        <x-scroll-view class="w-1/2 mx-auto" auto-scroll keep-scrolling chevron-class="w-14" chevron-inner-color="text-red-600">
            @for($i = 1; $i < 10; $i++)
                <div class="mx-1"><a href="#" class="box flex flex-col justify-center items-center w-36 h-44 bg-white divide-y divide-gray-100 shadow-2xl rounded-lg overflow-hidden m-8"> <div class="slide-img">Quick {{ $i }}</div> <img class="flex-auto" src="/img/logo.png" alt/></a></div>
            @endfor
        </x-scroll-view>
    </div>
    <div class="flex flex-row justify-between bg-gray-100">
        <div class="md:w-1/2 mt-2 pb-40">@include('layouts.left-side')</div>
        <div class="md:w-3/4 mt-2">
            <x-post-card />
            <x-post-card />
            <x-post-card />
        </div>
        <div class="md:w-1/2 mt-2">@include('layouts.right-side')</div>
    </div>
</div> --}}
@endsection