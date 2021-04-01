@extends('layouts.app')


@section('content')
    <form method="post" action="{{ route('posts.store') }}">
        @csrf
        @apiToken
        <input name="body" value="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam consequatur corporis dignissimos labore maiores mollitia, praesentium vitae. Fuga magnam, odio!" />
        <br/><br/><br/>
        <button type="submit">Submit</button>
    </form>
@endsection
