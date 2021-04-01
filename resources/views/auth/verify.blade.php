@extends('layouts.app')


@section('content')
{{--    @error('verification') <div></div> @enderror--}}
    
  <div class="flex justify-center h-screen md:pt-20 md:bg-gray-100">
    <div class="relative flex flex-col min-w-0 break-words w-full h-full md:border-2 md:rounded md:shadow-lg md:bg-white md:h-96 md:w-2/3 lg:w-1/3">
      <div class="flex-auto lg:justify-center">
        <div>
          <h1 class="flex flex-1 px-2 py-4 text-xl justify-center font-medium">
            Enter the code from the SMS
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              fill="currentColor"
              class="bi bi-chat-dots"
              style="margin:0px 4%;"
              viewBox="0 0 16 16"
            >
              <path
                d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"
              />
              <path
                d="M2.165 15.803l.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"
              />
            </svg>
          </h1>
          <hr />
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p>
                    {{ $messages['message'] ?? '' }} {{ $messages['login'] ?? '' }}
                </p>
            @endif
          <form class="grid grid-cols-1 h-1/2 gap-4 pb-24"  method="post" action="{{ route('verification.verify') }}">@csrf
            <p
              class="p-4"
            >Let us know this mobile number is yours. Enter the code in the SMS sent to 0542 08 53 19 (Algeria).</p>
            
            <input hidden name="method" value="{{ $method }}"/>
            <div class="flex justify-evenly">

                <input
                class="p-2 w-1/2 justify-self-center font-medium border-2 border-logo-black focus:border-logo-black focus:ring-logo-black outline-none rounded-lg"
                type="text"
                name="code"
                id="confirmation-code"
                placeholder="QL-"
                />
                <button class="p-2 w-1/4 justify-self-center font-medium border-2 border-transparent focus:border-transparent focus:ring-2 focus:ring-offset-2  focus:ring-logo-red outline-none focus:outline-none rounded-lg text-logo-white bg-logo-red hover:bg-red-500 cursor-pointer" type="submit">{{ __("submit") }}</button>
            </div>
          </form>
          <hr />
          <form class="flex justify-center items-center pt-4" method="post" action="{{ route('verification.resend') }}">@csrf
              {{-- Add 30 second timer --}}
              <p>{{ __("didn't receive the code?") }}<button type="submit" class="p-2 justify-self-center text-logo-red hover:underline" >{{ __("send another") }}</button></p>
              <input hidden name="method" value="{{ $method }}"/>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection
