@extends('layouts.app')
@section('content')
{{--    This is the home page you are {{ Auth::guest() ? "not" : "" }} logged in {{ Auth::guest() ? "" : (" and your account is " . (Auth::user()->isVerified() ? "" : "not")." verified") }}--}}
{{--    @auth--}}
{{--        <form method="post" action="{{ route('logout') }}">@csrf--}}
{{--            <button type="submit">Logout</button>--}}
{{--        </form>--}}
{{--    @endauth--}}
<h1 class="bg-green-200 py-4 text-center text-2xl">Play Ground</h1>


<button title="Add new Post" class="modal-open w-full h-12 px-2 bg-white border shadow-2xl rounded-lg flex justify-center items-center mt-2 outline-none focus:outline-none focus:ring-logo-red focus:border-logo-red focus:text-logo-red hover:text-logo-red hover:border-logo-red">
    <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
</button>
@include('Posts.create-new')

<div x-data="{ open: false }">
    <button @click="open = true">Open Dropdown</button>

    <ul
        x-show="open"
        @click.away="open = false"
    >
        Dropdown Body
    </ul>
</div>
<div class="notifications relative"  x-data="{ open: false }">
    <button title="Notifications" @click="open = true" class="p-1 text-gray-500 bg-gray-100 hover:bg-red-50 hover:text-logo-red rounded-full focus:outline-none" type="button">drop</button>
    <!-- Notifications Block -->
      {{-- <div class="relative text-left" x-show="notificationOpen"> --}}
          <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="options-menu" >
          <div class="flex flex-row justify-between items-center" role="none">
              <p class="block px-4 py-2 text-xl text-gray-700" role="menuitem">Notifications</p>
              <button class="hover:bg-gray-100 m-2 p-1 w-9 h-9 outline-none focus:outline-none rounded-full" >
              drop</button>

              <div class="absolute right-2 top-12 py-2 space-y-2 w-64 bg-white rounded-lg shadow-lg ring-1 ring-gray-200">
                <a class="flex flex-row p-2 hover:bg-gray-100 items-center space-x-2" href="#">
                    <p>mark all as read</p>
                </a>
              </div>
          </div>
          <div class="py-1 space-y-1" role="none">
              <img class="rounded-full" width="50" src="/img/150x150.png" alt />
              <div>
                  <p>Abd Elhak</p>
                  <p>Lorem ipsum dolor sit consectetur...</p>
                  <p>23 m</p>
              </div>
              </a>
          </div>
          </div>
      {{-- </div> --}}
  </div>          
      {{-- ````````````````Notifications end/```````````````` --}}
@endsection
