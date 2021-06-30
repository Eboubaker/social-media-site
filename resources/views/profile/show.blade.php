@extends('layouts.app')     

@section('content')
    <nav-bar class="hidden sm:block"></nav-bar>
      <div class="pt-16">
        <main role="main">
          <div class="flex flex-col items-start py-2 w-10/12 md:w-2/3 lg:w-1/2 bg-white mx-auto">
            <section class="w-10/12 mx-auto " >
              <script id="profilejson" type="application/json">
                {!! $profileJson !!}
            </script>
              <profile-head></profile-head>
              <feed :profile="{{ $profile_id }}" class="space-y-4" style="margin-top: 250px"></feed>
            </section>
          </div>
        </main>
      </div>
    </div>
@endsection
