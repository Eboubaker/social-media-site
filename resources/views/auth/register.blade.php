@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ route('register', app()->getLocale()) }}">@csrf
        <label>
            Phone or Email : <input name="login"/>
        </label>
        <label>
            Password : <input name="password"/>
        </label>
        <button type="submit">{{ __("submit") }}</button>
    </form>
@endsection
