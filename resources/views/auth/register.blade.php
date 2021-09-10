@extends('layouts.app')

@section('content')
{{-- {{ var_export($errors->all()) }} --}}
<div v-pre class="overflow-hidden">
    <!-- Container -->
    <div class="container mx-auto">
        <div class="flex justify-center px-6 my-12">
            <!-- Row -->
            <div class="w-full{{--  xl:w-3/4 lg:w-11/12 --}} flex">
                <!-- Col -->
                <div class="bg-auto bg-no-repeat bg-center h-auto hidden lg:block lg:w-5/6 rounded-l-lg"
                    style="background-image: url('/img/')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="600" height="500" viewBox="0 0 339 56">
                        <g id="Group_1" data-name="Group 1" transform="translate(-935 -509)">
                            <path id="laravel-logo_2_" data-name="laravel-logo (2)" d="M49.626,11.564a.809.809,0,0,1,.028.209V22.745a.8.8,0,0,1-.4.694l-9.209,5.3V39.25a.8.8,0,0,1-.4.694L20.42,51.01a.859.859,0,0,1-.14.058c-.018.006-.035.017-.054.022a.805.805,0,0,1-.41,0c-.022-.006-.042-.018-.063-.026a.832.832,0,0,1-.132-.054L.4,39.944A.8.8,0,0,1,0,39.25V6.334a.818.818,0,0,1,.028-.21c.006-.023.02-.044.028-.067a.788.788,0,0,1,.051-.124.748.748,0,0,1,.055-.071.815.815,0,0,1,.071-.093.781.781,0,0,1,.079-.06A.652.652,0,0,1,.4,5.64h0L10.011.107a.8.8,0,0,1,.8,0l9.61,5.533h0a.98.98,0,0,1,.088.068.946.946,0,0,1,.078.06.936.936,0,0,1,.072.094.738.738,0,0,1,.054.071.835.835,0,0,1,.052.124c.008.023.022.044.028.068a.809.809,0,0,1,.028.209V26.893l8.008-4.611V11.772a.808.808,0,0,1,.028-.208c.007-.024.02-.045.028-.068a.9.9,0,0,1,.052-.124c.015-.026.037-.047.054-.071a.823.823,0,0,1,.072-.093.768.768,0,0,1,.078-.06.807.807,0,0,1,.088-.069h0l9.611-5.533a.8.8,0,0,1,.8,0l9.61,5.533a.883.883,0,0,1,.09.068c.025.02.054.038.077.06a.935.935,0,0,1,.072.094.6.6,0,0,1,.054.071.793.793,0,0,1,.052.124.572.572,0,0,1,.028.068ZM48.052,22.282V13.158l-3.363,1.936-4.646,2.675v9.124l8.01-4.611Zm-9.61,16.505v-9.13l-4.57,2.61-13.05,7.448v9.216l17.62-10.144ZM1.6,7.719V38.787L19.22,48.93V39.716l-9.2-5.209,0,0,0,0a37.426,37.426,0,0,0-.162-.124l0,0a.762.762,0,0,1-.066-.084.855.855,0,0,1-.06-.078v0a.638.638,0,0,1-.042-.1.592.592,0,0,1-.038-.09h0a.766.766,0,0,1-.016-.117.694.694,0,0,1-.012-.09V12.33L4.965,9.654,1.6,7.72Zm8.81-5.994L2.4,6.334l8,4.609,8.006-4.61L10.41,1.725Zm4.164,28.764,4.645-2.674V7.719L15.858,9.655,11.212,12.33v20.1l3.364-1.937ZM39.243,7.164l-8.006,4.609,8.006,4.609,8.005-4.61L39.243,7.164Zm-.8,10.6L33.8,15.094l-3.363-1.936v9.124l4.645,2.674,3.364,1.937V17.769ZM20.02,38.33l11.743-6.7,5.87-3.35-8-4.606-9.211,5.3-8.4,4.833L20.02,38.33Z" transform="translate(935 511)" fill="#ff2d20" fill-rule="evenodd"/>
                            <text id="SocialWeb.Dev" transform="translate(1001 554)" fill="#ff2d20" font-size="42" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">SocialWeb</tspan><tspan y="0" fill="#333">.Dev</tspan></text>
                        </g>
                    </svg>
                </div>
                <!-- Col -->
                <div class="w-full lg:w-1/2 border p-5 rounded-lg shadow-md bg-white">
                  <h3 class="pt-4 pb-1 text-2xl text-center">Create an Account!</h3>
                  <hr/>
                  <form class="px-8 py-4 mb-2 rounded" method="POST" action="{{ route('register') }}">
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
                            User Name
                        </label>
                        <input
                            class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border @error('username') border-red-500 @enderror rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            id="username" type="username" name="username" placeholder="User Name" value="{{ old('username') }}"/>
                        @error('username') <p class="text-xs italic text-red-500">{{ $message }}</p> @enderror
                    </div>
                      <div class="mb-4">
                          <label class="block mb-2 text-sm font-bold text-gray-700" for="login">
                              Phone Number or Email
                          </label>
                          <input
                              class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border @error('login') border-red-500 @enderror rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                              id="login" type="text" name="login" placeholder="Phone Number or Email" value="{{ old('login') }}"/>
                          @error('login') <p class="text-xs italic text-red-500">{{ $message }}</p> @enderror
                      </div>
                      <div class="mb-4 md:flex md:justify-between">
                          <div class="mb-4 md:mr-2 md:mb-0">
                              <label class="block mb-2 text-sm font-bold text-gray-700" for="password">
                                  Password
                              </label>
                              <input
                                  class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border @error('password') border-red-500 @enderror rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                  id="password" name="password" type="password" value="{{ old('password') }}"
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
                                  id="c_password" type="password" name="password_confirmation" value="{{ old('password_confirmation') }}"
                                  placeholder="******************" />
                          </div>
                      </div>
                      <div class="mb-6 text-center">
                          <button
                              class="w-full px-4 py-2 font-bold transition-colors duration-75 border-red-500 border-2 text-logo-black bg-white rounded-xl hover:bg-red-500 hover:border-white hover:text-white focus:outline-none focus:shadow-outline"
                              type="submit">
                              Register
                          </button>
                      </div>
                      <hr class="mb-6 border-t" />
                      <div class="text-center">
                          <a class="inline-block text-sm align-baseline hover:underline"
                              href="{{ route('login') }}">
                              Already have an account? Login!
                          </a>
                      </div>
                      <div class="text-center">
                          <a class="inline-block text-sm align-baseline hover:underline"
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