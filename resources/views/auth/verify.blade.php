@extends('layouts.app')


@section('content')
{{--    @error('verification') <div></div> @enderror--}}
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
    <form method="post" action="{{ route('verification.verify') }}">@csrf
        <input hidden name="method" value="{{ $method }}"/>
        <label>
            Code : <input class="border-2 border-red-900" name="code"/>
        </label>
        <button class="border-2 border-red-900" type="submit">{{ __("submit") }}</button>
    </form>
    <form method="post" action="{{ route('verification.resend') }}">@csrf
        {{-- Add 30 second timer --}}
        <p>{{ __("didn't receive the code?") }}<button type="submit" class="border-2 border-red-900">{{ __("send another") }}</button></p>
        <input hidden name="method" value="{{ $method }}"/>
    </form>
@endsection
