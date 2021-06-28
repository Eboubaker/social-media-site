@extends('layouts.app')


@section('content')    
  <div class="flex justify-center h-screen md:pt-20 md:bg-gray-100">
    <div class="relative flex flex-col min-w-0 break-words w-full max-w-lg">
      <div class="lg:justify-center border-2 rounded-lg md:shadow-lg p-4 bg-white">
        <div>
          <h1 class="flex flex-1 px-2 py-4 text-xl justify-center font-medium">
            @if($method == 'phone') 
              Enter the sms verification code <svg class="w-6 h-6 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            @else
              Enter the email verification code <svg class="w-6 h-6 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            @endif
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
                <p class="font-semibold text-lg mt-2 text-center">
                    {{ $messages['message'] ?? '' }} <span class="text-red-800 ">{{ $messages['login'] ?? '' }}</span> 
                </p>
            @endif
          <form class="grid grid-cols-1 h-1/2 gap-4 my-3"  method="post" action="{{ route('verification.verify') }}">@csrf
            <p class="tracking-tight text-center text-gray-500">
              @if($method == 'phone') 
                Let us know if this mobile number is yours. Enter the code in the SMS here.
              @else
                Let us know if this is your email. Enter the recieved code here
              @endif
            </p>
            <input hidden name="method" value="{{ $method }}"/>
            <div class="flex justify-evenly">

                <input
                class="p-2 w-1/2 justify-self-center font-medium border-2 border-logo-red focus:border-blue-400 outline-none rounded-lg"
                type="text"
                name="code"
                id="confirmation-code"
                placeholder="Enter receieved code"
                />
                <button class="p-2 w-1/4 justify-self-center font-medium border-2 border-transparent focus:border-transparent focus:ring-2 focus:ring-offset-2  focus:ring-logo-red outline-none focus:outline-none rounded-lg text-logo-white bg-logo-red hover:bg-red-500 cursor-pointer" type="submit">{{ __("submit") }}</button>
            </div>
          </form>
          <hr />
          <form class="flex justify-center items-center pt-4" method="post" action="{{ route('verification.resend') }}">@csrf
              {{-- Add 30 second timer --}}
              <p>{{ __("didn't receive the code?") }}<button type="submit" class="p-2 justify-self-center focus:outline-none text-logo-red hover:underline" >{{ __("send another") }}</button></p>
              <input hidden name="method" value="{{ $method }}"/>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection
