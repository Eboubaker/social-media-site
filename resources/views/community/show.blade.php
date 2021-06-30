@extends('layouts.app')
@section('content')
<nav-bar class="mb-14"></nav-bar>
<div class="bg-white w-full h-full">
    <community-head></community-head>
    <div class="w-full sm:w-11/12 mx-auto h-full flex">
        <div class="md:mr-auto w-full md:w-7/12">
            <feed class="rounded bg-gray-50 min-h-screen p-2 sm:p-4 md:p-12 shadow-inner"></feed>
        </div>
        <div class="w-5/12 hidden ml-4 md:block h-full">
            <div class="w-full h-full bg-gray-50 rounded p-4 text-gray-900">
                <div class="font-semibold text-lg text-black flex justify-between">
                    <div>About Community</div>
                    <div class="bg-gray-300 rounded-full hover:bg-gray-900 p-1 group cursor-pointer"><svg class="w-6 h-6 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg></div>
                </div>
                <div class="font-semibold text-gray-700">{{ $community->description }}</div>
                <div class="w-full my-1 mx-auto bg-gray-300 " style="height: 1px"></div>
                <div class="font-semibold text-lg text-black flex justify-between">
                    <div>Rules</div>
                </div>
                <ol class="list-decimal list-inside divide-y divide-gray-300">
                    <li>No personal attacks or harassment. Please be nice to each other</li>
                    <li>No Advertising</li>
                    <li>Share personal information at your own risk</li>
                    <li>No Spamming</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script id="communityjson" type="application/json">
        {!! json_encode((new App\Http\Resources\CommunityResource($community))->toResponse(request())->getData()->data) !!}
    </script>
    <script>
        function jbtnclick(){
            this.addClass('hidden')
            this.removeClass('inline-block')
            let lbtn = document.getElementById('leave_btn');
            lbtn.style.display = 'block';
            lbtn.innerHTML = 'leave';
        }
        function lbtnclick(){
            this.style.display = 'none';
            document.getElementById('join_btn').style.display = 'block';
        }
    </script>
    
@endpush
