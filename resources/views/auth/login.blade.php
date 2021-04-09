@extends('layouts.app')

@section('content')

<div v-pre id="register" class="">
    <!-- Container -->
    <div class="container mx-auto">
        <div class="flex justify-center px-6 my-12">
            <!-- Row -->
            <div class="w-full {{-- xl:w-3/4 lg:w-11/12 --}} flex">
                <!-- Col -->
                <div class="bg-auto bg-no-repeat bg-center h-auto hidden lg:block lg:w-5/6 rounded-l-lg"
                    style="background-image: url('/img/logo.png')"></div>
                <!-- Col -->
                <div class="w-full lg:w-1/2 border p-5 rounded-lg shadow-md">
                    <h3 class="pt-4 pb-1 text-2xl text-center">Login</h3>
                    <hr />
                    <form class="px-8 pt-6 pb-8 mb-4 bg-white rounded" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="login">
                                Email or Phone Number
                            </label>
                            <input
                                class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border @error('login') border-red-500 @enderror rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="login" type="email" name="login" placeholder="Email or Phone Number" />
                            @error('login') <p class="text-xs italic text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <div class="mb-4 md:mr-2 md:mb-0">
                                <label class="block mb-2 text-sm font-bold text-gray-700" for="password">
                                    Password
                                </label>
                                <input
                                    class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border @error('password') border-red-500 @enderror rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    id="password" name="password" type="password" placeholder="******************" />
                                @error('password') <p class="text-xs italic text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-6 text-center">
                            <button
                                class="w-full px-4 py-2 font-bold transition-colors duration-75 border-red-500 border-2 text-logo-black bg-white rounded-xl hover:bg-red-500 hover:border-white hover:text-white focus:outline-none focus:shadow-outline"
                                type="submit">
                                Login
                            </button>
                        </div>
                        <hr class="mb-6 border-t" />
                        <div class="text-center">
                            <a class="inline-block text-sm text-blue-500 align-baseline hover:underline" 
                            href="{{ route('register') }}">
                                Don't have an account? Register!
                            </a>
                        </div>
                        <div class="text-center">
                            <a class="inline-block text-sm text-blue-500 align-baseline hover:underline"
                                href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection