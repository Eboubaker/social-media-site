@extends('layouts.app')

@section('content')
<!--
  This example requires Tailwind CSS v2.0+ 
  
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ]
  }
  ```
-->
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <img class="mx-auto h-22 w-auto" src="/img/logo.png" alt="Quick Look">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Register new account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Already have one ?
          <a href="#" class="font-medium text-red-600 hover:text-red-500">
            login
          </a>
        </p>
      </div>
      <form class="mt-8 space-y-6 bg-white rounded-2xl shadow-lg p-4" action="{{ route('register') }}" method="POST">@csrf
        <input type="hidden" name="remember" value="true">
        <div class="rounded-md shadow-sm -space-y-px">
          <div>
            <label class="sr-only">Email or Phone Number</label>
            <input name="login" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-red-500 focus:border-red-500 focus:z-10 sm:text-sm" placeholder="Email or Phone Number">
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-red-500 focus:border-red-500 focus:z-10 sm:text-sm" placeholder="Password">
          </div>
        </div>
  
        <div class="flex items-center justify-center">
           @if ($errors->any())
                <div class=" flex-auto px-4 py-2 rounded-md bg-red-100 text-red-500">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
  
        <div>
          <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            Sign up
          </button>
        </div>
      </form>
    </div>
  </div>
  
{{-- <div class="flex justify-between w-full bg-gray-100">
    <div></div>
    <div>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="flex flex-col justify-between items-center space-y-4 bg-green-100" method="post" action="{{ route('register', app()->getLocale()) }}">@csrf
        <label>
            Phone or Email : <input name="login"/>
        </label>
        <label>
            Password : <input name="password"/>
        </label>
        <button class="" type="submit">{{ __("submit") }}</button>
    </form>
</div>
    <div></div>
</div> --}}
    
@endsection
