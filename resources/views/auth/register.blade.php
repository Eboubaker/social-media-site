@extends('layouts.app')

@section('content')

<div v-pre class="font-mono bg-gray-400">
    <!-- Container -->
    <div class="container mx-auto">
        <div class="flex justify-center px-6 my-12">
            <!-- Row -->
            <div class="w-full xl:w-3/4 lg:w-11/12 flex">
                <!-- Col -->
                <div class="bg-cover h-auto bg-gray-400 hidden lg:block lg:w-5/12 rounded-l-lg"
                    style="background-image: url('/img/logo.png')"></div>
                <!-- Col -->
                <div class="w-full lg:w-7/12 bg-white p-5 rounded-lg lg:rounded-l-none">
                  <h3 class="pt-4 text-2xl text-center">Create an Account!</h3>
                  <hr/>
                  <form class="px-8 pt-6 pb-8 mb-4 bg-white rounded" method="POST" action="{{ route('register') }}">
                      @csrf
                      <div class="mb-4 md:flex md:justify-between">
                          <div class="mb-4 md:mr-2 md:mb-0">
                              <label class="block mb-2 text-sm font-bold text-gray-700" for="firstName">
                                  First Name
                              </label>
                              <input
                                  class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border @error('firstName') border-red-500 @enderror rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                  id="firstName" name="firstName" type="text" placeholder="First Name" value="{{ old('firstName') }}"/>
                              @error('firstName') <p class="text-xs italic text-red-500">{{ $message }}</p>
                              @enderror
                          </div>
                          <div class="md:ml-2">
                              <label class="block mb-2 text-sm font-bold text-gray-700" for="lastName">
                                  Last Name
                              </label>
                              <input
                                  class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border @error('lastName') border-red-500 @enderror rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                  id="lastName" name="lastName" type="text" placeholder="Last Name" value="{{ old('lastName') }}"/>
                              @error('lastName') <p class="text-xs italic text-red-500">{{ $message }}</p>
                              @enderror
                          </div>
                      </div>
                      <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="login">
                            Birth Date
                        </label>
                        <input
                            class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border @error('birthDate') border-red-500 @enderror rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            id="birthDate" type="date" name="birthDate" value="{{ old('birthDate') }}"/>
                        @error('birthDate') <p class="text-xs italic text-red-500">{{ $message }}</p> @enderror
                    </div>
                      <div class="mb-4">
                          <label class="block mb-2 text-sm font-bold text-gray-700" for="login">
                              Email or Phone Number
                          </label>
                          <input
                              class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border @error('login') border-red-500 @enderror rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                              id="login" type="email" name="login" placeholder="Email or Phone Number" value="{{ old('login') }}"/>
                          @error('login') <p class="text-xs italic text-red-500">{{ $message }}</p> @enderror
                      </div>
                      <div class="mb-4 md:flex md:justify-between">
                          <div class="mb-4 md:mr-2 md:mb-0">
                              <label class="block mb-2 text-sm font-bold text-gray-700" for="password">
                                  Password
                              </label>
                              <input
                                  class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border @error('password') border-red-500 @enderror rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                  id="password" name="password" type="password"
                                  placeholder="******************" />
                              @error('password') <p class="text-xs italic text-red-500">{{ $message }}</p>
                              @enderror
                          </div>
                          <div class="md:ml-2">
                              <label class="block mb-2 text-sm font-bold text-gray-700" for="c_password">
                                  Confirm Password
                              </label>
                              <input
                                  class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border @error('password') border-red-500 @enderror rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                  id="c_password" type="password" name="password_confirmation"
                                  placeholder="******************" />
                          </div>
                      </div>
                      <div class="mb-6 text-center">
                          <button
                              class="w-full px-4 py-2 font-bold transition-colors duration-75 border-primary-hard border-2 text-logo-black bg-white rounded-xl hover:bg-primary-hard hover:border-white hover:text-white focus:outline-none focus:shadow-outline"
                              type="submit">
                              Register
                          </button>
                      </div>
                      <hr class="mb-6 border-t" />
                      <div class="text-center">
                          <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
                              href="{{ route('login') }}">
                              Already have an account? Login!
                          </a>
                      </div>
                      <div class="text-center">
                          <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
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