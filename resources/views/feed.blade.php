@extends('layouts.app')

@section('content')
<nav-bar class="hidden sm:block"></nav-bar>
<div class="flex flex-col pt-20 mx-auto max-w-4xl lg:max-w-5xl xl:max-w-6xl bg-gray-200">
  <div class="grid grid-cols-1 gap-y-4">
    <!-- trending today -->
    <div class="flex flex-col space-y-2">
      <div class="font-2xl font-medium">Trending Today</div>
      <div class="flex space-x-4">
        <div>
          <div class="relative">
            <img src="/images/01.png" alt class="rounded-xl object-cover h-36 xl:h-48 shadow" />
            <div class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"></div>
            <div class="absolute bottom-4 left-4 right-4 text-white z-0">
              <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
              <div class="text-sm xl:text-base font-bold overflow-hidden">Vue CLI Setup Guide with Tailwind CSS</div>
            </div>
          </div>
        </div>
        <div>
          <div class="relative">
            <img src="/images/02.png" alt class="rounded-xl object-cover h-36 xl:h-48 shadow" />
            <div class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"></div>
            <div class="absolute bottom-4 left-4 right-4 text-white z-0">
              <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
              <div class="text-sm xl:text-base font-bold overflow-hidden">Getting Started with Vim and VS Code</div>
            </div>
          </div>
        </div>
        <div>
          <div class="relative">
            <img src="/images/03.png" alt class="rounded-xl object-cover h-36 xl:h-48 shadow" />
            <div class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"></div>
            <div class="absolute bottom-4 left-4 right-4 text-white z-0">
              <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
              <div class="text-sm xl:text-base font-bold overflow-hidden">Productive Mac OS Setup with Vim, iTerm2, and
                Oh My Zsh</div>
            </div>
          </div>
        </div>
        <div>
          <div class="relative">
            <img src="/images/04.png" alt class="rounded-xl object-cover h-36 xl:h-48 shadow" />
            <div class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"></div>
            <div class="absolute bottom-4 left-4 right-4 text-white z-0">
              <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
              <div class="text-sm xl:text-base font-bold overflow-hidden">Vue.js Setup Guide in VS Code with Vetur &amp;
                Airbnb ESLint</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="flex w-full h-full mt-20">
  <div class="w-7/12 mx-auto h-full">
      <div class="md:mx-auto w-11/12">
        <feed class="rounded-lg bg-gray-400 min-h-screen p-2 sm:p-4 md:p-12 shadow-inner border-2 border-gray-300"></feed>
      </div>
  </div>
  <div class="hidden md:block flex-none md:w-5/12">
    <div class="flex flex-col space-y-2">
      <div class="font-2xl font-medium">Trending Videos</div>
      <div class="flex flex-col space-y-4">
        <div>
          <div class="relative">
            <img src="/images/01.png" alt class="rounded-xl object-cover h-52 xl:h-72 shadow" />
            <div class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"></div>
            <div class="absolute bottom-4 left-4 right-4 text-white z-0">
              <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
              <div class="text-sm xl:text-base font-bold overflow-hidden">Vue CLI Setup Guide with Tailwind CSS</div>
            </div>
          </div>
        </div>
        <div>
          <div class="relative">
            <img src="/images/02.png" alt class="rounded-xl object-cover h-52 xl:h-72 shadow" />
            <div class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"></div>
            <div class="absolute bottom-4 left-4 right-4 text-white z-0">
              <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
              <div class="text-sm xl:text-base font-bold overflow-hidden">Getting Started with Vim and VS Code</div>
            </div>
          </div>
        </div>
        <div>
          <div class="relative">
            <img src="/images/03.png" alt class="rounded-xl object-cover h-52 xl:h-72 shadow" />
            <div class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"></div>
            <div class="absolute bottom-4 left-4 right-4 text-white z-0">
              <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
              <div class="text-sm xl:text-base font-bold overflow-hidden">Productive Mac OS Setup with Vim, iTerm2, and
                Oh My Zsh</div>
            </div>
          </div>
        </div>
        <div>
          <div class="relative">
            <img src="/images/04.png" alt class="rounded-xl object-cover h-52 xl:h-72 shadow" />
            <div class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"></div>
            <div class="absolute bottom-4 left-4 right-4 text-white z-0">
              <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
              <div class="text-sm xl:text-base font-bold overflow-hidden">Vue.js Setup Guide in VS Code with Vetur &amp;
                Airbnb ESLint</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection