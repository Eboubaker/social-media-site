@extends('layouts.app')     

@section('content')

<div class="md:block md:flex bg-gray-100 md:py-4">
    <div class="hidden md:block md:w-96 md:fixed md:left-0 content md:overflow-auto md:h-full md:pl-4 md:pb-20">@include('layouts.left-side')</div>
    <div class="hidden md:block md:w-96"></div>
    <div class="pt-24 md:pt-0 md:w-1/2">
        <div class="md:w-5/6 md:mx-auto"> 
        <x-scroll-view class="" auto-scroll keep-scrolling chevron-class="w-14" chevron-inner-color="text-red-600">
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
            <button title="Add new Post" class="modal-open w-full h-12 px-2 bg-white border shadow-2xl rounded-lg flex justify-center items-center mt-2 outline-none focus:outline-none focus:ring-logo-red focus:border-logo-red focus:text-logo-red hover:text-logo-red hover:border-logo-red">
                <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>
        <div class="w-11/12 mx-auto md:w-5/6"><x-post-card/></div>
        <div class="w-11/12 mx-auto md:w-5/6"><x-post-card/></div>
        <div class="w-11/12 mx-auto md:w-5/6"><x-post-card/></div>
    </div>
    <div class="hidden md:block md:w-96"></div>
</div>
<div>
    @include('post.create')
</div>
@endsection