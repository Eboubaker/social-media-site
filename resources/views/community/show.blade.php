@extends('layouts.app')
@section('content')
<nav-bar class="mb-14"></nav-bar>
<div class="bg-gray-200 w-full h-full">
    <div class="z-10 w-11/12 mx-auto h-40  bg-blue-600 relative rounded-md rounded-t-none bg-cover"
        style="background-image: url({{ $community->coverImage->url }})"
    >
        <div style="bottom: -4.5rem" class="absolute left-6">
            <div class="flex">
                <div style="background-image: url({{ $community->iconImage->url }})" class="w-28 h-28 bg-cover border-4 border-blue-100 rounded-full bg-green-500"></div>
                <div class="justify-self-center self-center px-4">
                    <span class="text-3xl text-white font-bold">{{ $community->name }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="w-11/12 mx-auto h-24 bg-gray-400 mb-10 z-0 rounded-md" style="margin-top: -1rem"></div>
    <div class="w-full sm:w-11/12 mx-auto h-full flex">
        <div class="md:mr-auto w-full md:w-7/12">
            <feed class="rounded-lg bg-gray-400 min-h-screen p-2 sm:p-4 md:p-12 shadow-inner border-2 border-gray-300"></feed>
        </div>
        <div class="w-5/12 hidden ml-4 md:block h-full">
            <div class="w-full h-full bg-gray-100 rounded p-4 text-gray-900">
                <div class="font-semibold text-lg text-black flex justify-between">
                    <div>About Community</div>
                    <div class="bg-gray-300 rounded-full hover:bg-gray-900 p-1 group cursor-pointer"><svg class="w-6 h-6 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg></div>
                </div>
                <div class="font-semibold text-gray-700">{{ $community->description }}</div>
            </div>
        </div>
    </div>
</div>


@endsection
