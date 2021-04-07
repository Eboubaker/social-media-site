{{-- @extends('layouts.app')


@section('content') --}}
<!--Modal-->
<div class="modal z-20 opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
  <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
  
  <div class="modal-container bg-white w-1/2 mx-auto rounded shadow-lg z-50 overflow-y-auto">
    
    <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50 p-2 mt-16 rounded-md hover:bg-gray-100 hover:text-logo-black">
      <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
      </svg>
      <span class="text-sm">(Esc)</span>
    </div>

    <!-- Add margin if you want to see some of the overlay behind the modal-->
    <div class="modal-content px-2 divide-y">
      <!--Title-->
        <div class="flex items-center py-2">
            <span class="w-full text-center text-xl font-semibold">Create Post</span>
            <button class="modal-close z-50 flex items-center rounded-md hover:bg-red-50 hover:text-logo-red p-2">
                <span class="material-icons">close</span>
            </button>
        </div>

      <!--Body-->
        <form method="post" action="{{ route('posts.store') }}">
            @csrf
            @apiToken
            <div class="flex items-center space-x-2 my-4">
                <a href="#"><img class="w-10 h-10 rounded-full" src="/img/150x150.png" alt=""></a>
                <div>
                    <p class="text-sm">Abdelhak</p>
                    <select class="p-0 hover:cursor-pointer h-6 w-14 rounded-md text-small" name="visibility" id="">
                        <option value="public">public</option>
                    </select>
                </div>
            </div>
            <textarea class="w-full h-52 rounded text-lg focus:ring-logo-red focus:border-logo-red"  name="body" id="content" placeholder="Write your post"></textarea>
            <div class="flex items-center justify-center space-x-4">
                <input type="file" name="image" id="image" hidden>
                <label title="upload image" class="flex items-center justify-center rounded-md p-2 w-12 cursor-pointer hover:bg-red-50 hover:text-logo-red transition-all ease-in-out" for="image">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </label>
                <input type="file" name="video" id="video" hidden>
                <label title="upload video" class="flex items-center justify-center rounded-md p-2 w-12 cursor-pointer hover:bg-red-50 hover:text-logo-red transition-all ease-in-out" for="video">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                    </svg>
                </label>
                <input type="file" name="audio" id="audio" hidden>
                <label title="upload audio" class="flex items-center justify-center rounded-md p-2 w-12 cursor-pointer hover:bg-red-50 hover:text-logo-red transition-all ease-in-out" for="audio">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                    </svg>
                </label>
            </div>
            <button class="w-11/12 mx-7 my-4 py-2 text-center text-white bg-gray-700 hover:bg-logo-black transition-all ease-in-out rounded-md" type="submit">Post</button>
        </form>
    </div>
  </div>
</div>
{{-- @endsection --}}
