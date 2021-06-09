@extends('layouts.app')
@section('content')

<nav-bar class="hidden sm:block"></nav-bar>
{{-- <div class="md:flex md:py-4">
    <div class="hidden md:block md:w-96 md:fixed md:left-0 content md:overflow-auto md:h-full md:pl-4 md:pb-20">@include('layouts.left-side')</div>
    <div class="hidden md:block md:w-96"></div>
    <div class="hidden pt-2 md:pt-0 md:w-1/2 mt-4">
        <div class="md:w-5/6 md:mx-auto"> 
        <x-scroll-view class="" auto-scroll keep-scrolling chevron-class="w-14" chevron-inner-color="">
            @for($i = 1; $i < 10; $i++)
                <div class="mx-1">
                    <a href="#" class="box flex flex-col justify-center items-center w-36 h-44 bg-white divide-y divide-gray-100 shadow-lg rounded-lg overflow-hidden m-8"> 
                        <div class="slide-img">Quick 123</div> 
                        <img class="flex-auto" src="/img/logo.png" alt/>
                    </a>
                </div>
                <div class="mx-1">
                    <a href="#" class="box flex flex-col justify-center items-center w-36 h-44 bg-white divide-y divide-gray-100 shadow-lg rounded-lg overflow-hidden m-8"> 
                        <div class="slide-img">Quick 123</div> 
                        <img class="flex-auto" src="/img/logo.png" alt/>
                    </a>
                </div>
                <div class="mx-1">
                    <a href="#" class="box flex flex-col justify-center items-center w-36 h-44 bg-white divide-y divide-gray-100 shadow-lg rounded-lg overflow-hidden m-8"> 
                        <div class="slide-img">Quick 123</div> 
                        <img class="flex-auto" src="/img/logo.png" alt/>
                    </a>
                </div>
            @endfor
        </x-scroll-view>
        </div>
    </div>
    <div class="hidden md:block md:w-96"></div>
    <div class="hidden md:block md:w-96 md:fixed md:right-0 content md:overflow-auto md:h-full md:pb-20">@include('layouts.right-side')</div>
</div> --}}


<div
    class="flex flex-col pt-20 mx-auto max-w-4xl lg:max-w-5xl xl:max-w-6xl"
  >
    <div class="grid grid-cols-1 gap-y-4">
      <!-- trending today -->
      <div class="flex flex-col space-y-2">
        <div class="font-2xl font-medium">Trending Today</div>
        <div class="flex space-x-4">
          <div>
            <div class="relative">
              <img src="/images/01.png" alt class="rounded-xl object-cover h-36 xl:h-48 shadow" />
              <div
                class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"
              ></div>
              <div class="absolute bottom-4 left-4 right-4 text-white z-0">
                <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
                <div
                  class="text-sm xl:text-base font-bold overflow-hidden"
                >Vue CLI Setup Guide with Tailwind CSS</div>
              </div>
            </div>
          </div>
          <div>
            <div class="relative">
              <img src="/images/02.png" alt class="rounded-xl object-cover h-36 xl:h-48 shadow" />
              <div
                class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"
              ></div>
              <div class="absolute bottom-4 left-4 right-4 text-white z-0">
                <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
                <div
                  class="text-sm xl:text-base font-bold overflow-hidden"
                >Getting Started with Vim and VS Code</div>
              </div>
            </div>
          </div>
          <div>
            <div class="relative">
              <img src="/images/03.png" alt class="rounded-xl object-cover h-36 xl:h-48 shadow" />
              <div
                class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"
              ></div>
              <div class="absolute bottom-4 left-4 right-4 text-white z-0">
                <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
                <div
                  class="text-sm xl:text-base font-bold overflow-hidden"
                >Productive Mac OS Setup with Vim, iTerm2, and Oh My Zsh</div>
              </div>
            </div>
          </div>
          <div>
            <div class="relative">
              <img src="/images/04.png" alt class="rounded-xl object-cover h-36 xl:h-48 shadow" />
              <div
                class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"
              ></div>
              <div class="absolute bottom-4 left-4 right-4 text-white z-0">
                <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
                <div
                  class="text-sm xl:text-base font-bold overflow-hidden"
                >Vue.js Setup Guide in VS Code with Vetur &amp; Airbnb ESLint</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- popular posts -->
      {{-- <div class="flex flex-col space-y-2">
        <div class="font-2xl font-medium">Popular Posts</div>
        <div class="flex flex-col space-y-4">
          <!-- filter -->
          <div
            class="flex place-items-center justify-between border border-solid border-gray-400 bg-white p-4 rounded shadow"
          >
            <div class="flex space-x-1 lg:space-x-4">
              <div>
                <div
                  class="text-blue-500 bg-gray-200 rounded-full px-4 py-2 font-black flex place-items-center space-x-2 hover:bg-gray-300"
                >
                  <div>
                    <svg
                      class="svg-inline--fa fa-fire fa-w-12 text-xl"
                      aria-hidden="true"
                      focusable="false"
                      data-prefix="fas"
                      data-icon="fire"
                      role="img"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 384 512"
                    >
                      <path
                        class
                        fill="currentColor"
                        d="M216 23.86c0-23.8-30.65-32.77-44.15-13.04C48 191.85 224 200 224 288c0 35.63-29.11 64.46-64.85 63.99-35.17-.45-63.15-29.77-63.15-64.94v-85.51c0-21.7-26.47-32.23-41.43-16.5C27.8 213.16 0 261.33 0 320c0 105.87 86.13 192 192 192s192-86.13 192-192c0-170.29-168-193-168-296.14z"
                      />
                    </svg>
                  </div>
                  <div>Hot</div>
                  <!--v-if-->
                </div>
              </div>
              <div>
                <div
                  class="text-blue-500 bg-gray-200 rounded-full px-4 py-2 font-black flex place-items-center space-x-2 hover:bg-gray-300"
                >
                  <!--v-if-->
                  <div>United States</div>
                  <div>
                    <svg
                      class="svg-inline--fa fa-caret-down fa-w-10"
                      aria-hidden="true"
                      focusable="false"
                      data-prefix="fas"
                      data-icon="caret-down"
                      role="img"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 320 512"
                    >
                      <path
                        class
                        fill="currentColor"
                        d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"
                      />
                    </svg>
                  </div>
                </div>
              </div>
              <div>
                <div
                  class="text-blue-500 bg-gray-200 rounded-full px-4 py-2 font-black flex place-items-center space-x-2 hover:bg-gray-300"
                >
                  <!--v-if-->
                  <div>All</div>
                  <div>
                    <svg
                      class="svg-inline--fa fa-caret-down fa-w-10"
                      aria-hidden="true"
                      focusable="false"
                      data-prefix="fas"
                      data-icon="caret-down"
                      role="img"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 320 512"
                    >
                      <path
                        class
                        fill="currentColor"
                        d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"
                      />
                    </svg>
                  </div>
                </div>
              </div>
              <div>
                <div
                  class="text-gray-500 rounded-full p-2 font-black space-x-2 flex place-items-center hover:bg-gray-300"
                >
                  <div>
                    <svg
                      class="svg-inline--fa fa-certificate fa-w-16 text-xl"
                      aria-hidden="true"
                      focusable="false"
                      data-prefix="fas"
                      data-icon="certificate"
                      role="img"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 512 512"
                    >
                      <path
                        class
                        fill="currentColor"
                        d="M458.622 255.92l45.985-45.005c13.708-12.977 7.316-36.039-10.664-40.339l-62.65-15.99 17.661-62.015c4.991-17.838-11.829-34.663-29.661-29.671l-61.994 17.667-15.984-62.671C337.085.197 313.765-6.276 300.99 7.228L256 53.57 211.011 7.229c-12.63-13.351-36.047-7.234-40.325 10.668l-15.984 62.671-61.995-17.667C74.87 57.907 58.056 74.738 63.046 92.572l17.661 62.015-62.65 15.99C.069 174.878-6.31 197.944 7.392 210.915l45.985 45.005-45.985 45.004c-13.708 12.977-7.316 36.039 10.664 40.339l62.65 15.99-17.661 62.015c-4.991 17.838 11.829 34.663 29.661 29.671l61.994-17.667 15.984 62.671c4.439 18.575 27.696 24.018 40.325 10.668L256 458.61l44.989 46.001c12.5 13.488 35.987 7.486 40.325-10.668l15.984-62.671 61.994 17.667c17.836 4.994 34.651-11.837 29.661-29.671l-17.661-62.015 62.65-15.99c17.987-4.302 24.366-27.367 10.664-40.339l-45.984-45.004z"
                      />
                    </svg>
                  </div>
                  <div>New</div>
                  <!--v-if-->
                </div>
              </div>
              <div>
                <div
                  class="text-gray-500 rounded-full p-2 font-black space-x-2 flex place-items-center hover:bg-gray-300"
                >
                  <div>
                    <svg
                      class="svg-inline--fa fa-sort-amount-up fa-w-16 text-xl"
                      aria-hidden="true"
                      focusable="false"
                      data-prefix="fas"
                      data-icon="sort-amount-up"
                      role="img"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 512 512"
                    >
                      <path
                        class
                        fill="currentColor"
                        d="M304 416h-64a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zM16 160h48v304a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V160h48c14.21 0 21.38-17.24 11.31-27.31l-80-96a16 16 0 0 0-22.62 0l-80 96C-5.35 142.74 1.77 160 16 160zm416 0H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h192a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-64 128H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zM496 32H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h256a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"
                      />
                    </svg>
                  </div>
                  <div>Top</div>
                  <!--v-if-->
                </div>
              </div>
              <div>
                <div
                  class="text-gray-500 rounded-full p-2 font-black space-x-2 flex place-items-center hover:bg-gray-300"
                >
                  <div>
                    <svg
                      class="svg-inline--fa fa-arrow-circle-up fa-w-16 text-xl"
                      aria-hidden="true"
                      focusable="false"
                      data-prefix="fas"
                      data-icon="arrow-circle-up"
                      role="img"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 512 512"
                    >
                      <path
                        class
                        fill="currentColor"
                        d="M8 256C8 119 119 8 256 8s248 111 248 248-111 248-248 248S8 393 8 256zm143.6 28.9l72.4-75.5V392c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V209.4l72.4 75.5c9.3 9.7 24.8 9.9 34.3.4l10.9-11c9.4-9.4 9.4-24.6 0-33.9L273 107.7c-9.4-9.4-24.6-9.4-33.9 0L106.3 240.4c-9.4 9.4-9.4 24.6 0 33.9l10.9 11c9.6 9.5 25.1 9.3 34.4-.4z"
                      />
                    </svg>
                  </div>
                  <div>Rising</div>
                  <!--v-if-->
                </div>
              </div>
            </div>
            <div>
              <div
                class="text-blue-500 bg-gray-200 rounded-full px-4 py-2 font-black flex place-items-center space-x-2 hover:bg-gray-300"
              >
                <svg
                  class="svg-inline--fa fa-columns fa-w-16 text-xl"
                  aria-hidden="true"
                  focusable="false"
                  data-prefix="fas"
                  data-icon="columns"
                  role="img"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 512 512"
                >
                  <path
                    class
                    fill="currentColor"
                    d="M464 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zM224 416H64V160h160v256zm224 0H288V160h160v256z"
                  />
                </svg>
                <svg
                  class="svg-inline--fa fa-caret-down fa-w-10"
                  aria-hidden="true"
                  focusable="false"
                  data-prefix="fas"
                  data-icon="caret-down"
                  role="img"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 320 512"
                >
                  <path
                    class
                    fill="currentColor"
                    d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"
                  />
                </svg>
              </div>
            </div>
          </div>
          <!-- reddit posts -->
          <div class="flex flex-col space-y-4 pb-8">
            <div>
              <div class="border border-solid border-gray-400 bg-white rounded shadow flex">
                <div
                  class="flex flex-col place-items-center text-2xl p-2 bg-gray-100 justify-center"
                >
                  <div>
                    <svg
                      class="svg-inline--fa fa-chevron-circle-up fa-w-16 text-red-500"
                      aria-hidden="true"
                      focusable="false"
                      data-prefix="fas"
                      data-icon="chevron-circle-up"
                      role="img"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 512 512"
                    >
                      <path
                        class
                        fill="currentColor"
                        d="M8 256C8 119 119 8 256 8s248 111 248 248-111 248-248 248S8 393 8 256zm231-113.9L103.5 277.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L256 226.9l101.6 101.6c9.4 9.4 24.6 9.4 33.9 0l17-17c9.4-9.4 9.4-24.6 0-33.9L273 142.1c-9.4-9.4-24.6-9.4-34 0z"
                      />
                    </svg>
                  </div>
                  <div class="text-red-500 font-bold">6.9k</div>
                  <div>
                    <svg
                      class="svg-inline--fa fa-chevron-circle-down fa-w-16"
                      aria-hidden="true"
                      focusable="false"
                      data-prefix="fas"
                      data-icon="chevron-circle-down"
                      role="img"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 512 512"
                    >
                      <path
                        class
                        fill="currentColor"
                        d="M504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zM273 369.9l135.5-135.5c9.4-9.4 9.4-24.6 0-33.9l-17-17c-9.4-9.4-24.6-9.4-33.9 0L256 285.1 154.4 183.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L239 369.9c9.4 9.4 24.6 9.4 34 0z"
                      />
                    </svg>
                  </div>
                </div>
                <div class="flex flex-col pl-4">
                  <div class="flex place-items-center space-x-2">
                    <img src="/images/js.png" alt class="w-8 rounded-full py-2" />
                    <div class="font-bold">r/learnjavascript</div>
                    <div class="font-thin text-gray-600">Posted by u/SuboptimalEng 4 hrs ago</div>
                  </div>
                  <div class="text-2xl font-bold">How to Clone the Reddit UI with Tailwind CSS</div>
                  <div class="flex text-gray-500 space-x-4">
                    <div class="text-lg flex place-items-center space-x-2 p-2 hover:bg-gray-200">
                      <svg
                        class="svg-inline--fa fa-comment fa-w-16"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="comment"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                      >
                        <path
                          class
                          fill="currentColor"
                          d="M256 32C114.6 32 0 125.1 0 240c0 49.6 21.4 95 57 130.7C44.5 421.1 2.7 466 2.2 466.5c-2.2 2.3-2.8 5.7-1.5 8.7S4.8 480 8 480c66.3 0 116-31.8 140.6-51.4 32.7 12.3 69 19.4 107.4 19.4 141.4 0 256-93.1 256-208S397.4 32 256 32z"
                        />
                      </svg>
                      <div>Comments</div>
                    </div>
                    <div class="text-lg flex place-items-center space-x-2 p-2 hover:bg-gray-200">
                      <svg
                        class="svg-inline--fa fa-trophy fa-w-18"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="trophy"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 576 512"
                      >
                        <path
                          class
                          fill="currentColor"
                          d="M552 64H448V24c0-13.3-10.7-24-24-24H152c-13.3 0-24 10.7-24 24v40H24C10.7 64 0 74.7 0 88v56c0 35.7 22.5 72.4 61.9 100.7 31.5 22.7 69.8 37.1 110 41.7C203.3 338.5 240 360 240 360v72h-48c-35.3 0-64 20.7-64 56v12c0 6.6 5.4 12 12 12h296c6.6 0 12-5.4 12-12v-12c0-35.3-28.7-56-64-56h-48v-72s36.7-21.5 68.1-73.6c40.3-4.6 78.6-19 110-41.7 39.3-28.3 61.9-65 61.9-100.7V88c0-13.3-10.7-24-24-24zM99.3 192.8C74.9 175.2 64 155.6 64 144v-16h64.2c1 32.6 5.8 61.2 12.8 86.2-15.1-5.2-29.2-12.4-41.7-21.4zM512 144c0 16.1-17.7 36.1-35.3 48.8-12.5 9-26.7 16.2-41.8 21.4 7-25 11.8-53.6 12.8-86.2H512v16z"
                        />
                      </svg>
                      <div>Award</div>
                    </div>
                    <div class="text-lg flex place-items-center space-x-2 p-2 hover:bg-gray-200">
                      <svg
                        class="svg-inline--fa fa-share fa-w-16"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="share"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                      >
                        <path
                          class
                          fill="currentColor"
                          d="M503.691 189.836L327.687 37.851C312.281 24.546 288 35.347 288 56.015v80.053C127.371 137.907 0 170.1 0 322.326c0 61.441 39.581 122.309 83.333 154.132 13.653 9.931 33.111-2.533 28.077-18.631C66.066 312.814 132.917 274.316 288 272.085V360c0 20.7 24.3 31.453 39.687 18.164l176.004-152c11.071-9.562 11.086-26.753 0-36.328z"
                        />
                      </svg>
                      <div>Share</div>
                    </div>
                    <div class="text-lg flex place-items-center space-x-2 p-2 hover:bg-gray-200">
                      <svg
                        class="svg-inline--fa fa-bookmark fa-w-12"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="bookmark"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 384 512"
                      >
                        <path
                          class
                          fill="currentColor"
                          d="M0 512V48C0 21.49 21.49 0 48 0h288c26.51 0 48 21.49 48 48v464L192 400 0 512z"
                        />
                      </svg>
                      <div>Save</div>
                    </div>
                    <div class="text-lg flex place-items-center space-x-2 p-2 hover:bg-gray-200">
                      <svg
                        class="svg-inline--fa fa-ellipsis-h fa-w-16"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="ellipsis-h"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                      >
                        <path
                          class
                          fill="currentColor"
                          d="M328 256c0 39.8-32.2 72-72 72s-72-32.2-72-72 32.2-72 72-72 72 32.2 72 72zm104-72c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72zm-352 0c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72z"
                        />
                      </svg>
                      <div></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <div class="border border-solid border-gray-400 bg-white rounded shadow flex">
                <div
                  class="flex flex-col place-items-center text-2xl p-2 bg-gray-100 justify-center"
                >
                  <div>
                    <svg
                      class="svg-inline--fa fa-chevron-circle-up fa-w-16 text-red-500"
                      aria-hidden="true"
                      focusable="false"
                      data-prefix="fas"
                      data-icon="chevron-circle-up"
                      role="img"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 512 512"
                    >
                      <path
                        class
                        fill="currentColor"
                        d="M8 256C8 119 119 8 256 8s248 111 248 248-111 248-248 248S8 393 8 256zm231-113.9L103.5 277.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L256 226.9l101.6 101.6c9.4 9.4 24.6 9.4 33.9 0l17-17c9.4-9.4 9.4-24.6 0-33.9L273 142.1c-9.4-9.4-24.6-9.4-34 0z"
                      />
                    </svg>
                  </div>
                  <div class="text-red-500 font-bold">4.2k</div>
                  <div>
                    <svg
                      class="svg-inline--fa fa-chevron-circle-down fa-w-16"
                      aria-hidden="true"
                      focusable="false"
                      data-prefix="fas"
                      data-icon="chevron-circle-down"
                      role="img"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 512 512"
                    >
                      <path
                        class
                        fill="currentColor"
                        d="M504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zM273 369.9l135.5-135.5c9.4-9.4 9.4-24.6 0-33.9l-17-17c-9.4-9.4-24.6-9.4-33.9 0L256 285.1 154.4 183.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L239 369.9c9.4 9.4 24.6 9.4 34 0z"
                      />
                    </svg>
                  </div>
                </div>
                <div class="flex flex-col pl-4">
                  <div class="flex place-items-center space-x-2">
                    <img src="/images/js.png" alt class="w-8 rounded-full py-2" />
                    <div class="font-bold">r/learnjavascript</div>
                    <div class="font-thin text-gray-600">Posted by u/SuboptimalEng 10 hrs ago</div>
                  </div>
                  <div
                    class="text-2xl font-bold"
                  >Cracking the YouTube Algorithm with Suboptimal UI Clones</div>
                  <div class="flex text-gray-500 space-x-4">
                    <div class="text-lg flex place-items-center space-x-2 p-2 hover:bg-gray-200">
                      <svg
                        class="svg-inline--fa fa-comment fa-w-16"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="comment"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                      >
                        <path
                          class
                          fill="currentColor"
                          d="M256 32C114.6 32 0 125.1 0 240c0 49.6 21.4 95 57 130.7C44.5 421.1 2.7 466 2.2 466.5c-2.2 2.3-2.8 5.7-1.5 8.7S4.8 480 8 480c66.3 0 116-31.8 140.6-51.4 32.7 12.3 69 19.4 107.4 19.4 141.4 0 256-93.1 256-208S397.4 32 256 32z"
                        />
                      </svg>
                      <div>Comments</div>
                    </div>
                    <div class="text-lg flex place-items-center space-x-2 p-2 hover:bg-gray-200">
                      <svg
                        class="svg-inline--fa fa-trophy fa-w-18"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="trophy"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 576 512"
                      >
                        <path
                          class
                          fill="currentColor"
                          d="M552 64H448V24c0-13.3-10.7-24-24-24H152c-13.3 0-24 10.7-24 24v40H24C10.7 64 0 74.7 0 88v56c0 35.7 22.5 72.4 61.9 100.7 31.5 22.7 69.8 37.1 110 41.7C203.3 338.5 240 360 240 360v72h-48c-35.3 0-64 20.7-64 56v12c0 6.6 5.4 12 12 12h296c6.6 0 12-5.4 12-12v-12c0-35.3-28.7-56-64-56h-48v-72s36.7-21.5 68.1-73.6c40.3-4.6 78.6-19 110-41.7 39.3-28.3 61.9-65 61.9-100.7V88c0-13.3-10.7-24-24-24zM99.3 192.8C74.9 175.2 64 155.6 64 144v-16h64.2c1 32.6 5.8 61.2 12.8 86.2-15.1-5.2-29.2-12.4-41.7-21.4zM512 144c0 16.1-17.7 36.1-35.3 48.8-12.5 9-26.7 16.2-41.8 21.4 7-25 11.8-53.6 12.8-86.2H512v16z"
                        />
                      </svg>
                      <div>Award</div>
                    </div>
                    <div class="text-lg flex place-items-center space-x-2 p-2 hover:bg-gray-200">
                      <svg
                        class="svg-inline--fa fa-share fa-w-16"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="share"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                      >
                        <path
                          class
                          fill="currentColor"
                          d="M503.691 189.836L327.687 37.851C312.281 24.546 288 35.347 288 56.015v80.053C127.371 137.907 0 170.1 0 322.326c0 61.441 39.581 122.309 83.333 154.132 13.653 9.931 33.111-2.533 28.077-18.631C66.066 312.814 132.917 274.316 288 272.085V360c0 20.7 24.3 31.453 39.687 18.164l176.004-152c11.071-9.562 11.086-26.753 0-36.328z"
                        />
                      </svg>
                      <div>Share</div>
                    </div>
                    <div class="text-lg flex place-items-center space-x-2 p-2 hover:bg-gray-200">
                      <svg
                        class="svg-inline--fa fa-bookmark fa-w-12"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="bookmark"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 384 512"
                      >
                        <path
                          class
                          fill="currentColor"
                          d="M0 512V48C0 21.49 21.49 0 48 0h288c26.51 0 48 21.49 48 48v464L192 400 0 512z"
                        />
                      </svg>
                      <div>Save</div>
                    </div>
                    <div class="text-lg flex place-items-center space-x-2 p-2 hover:bg-gray-200">
                      <svg
                        class="svg-inline--fa fa-ellipsis-h fa-w-16"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="ellipsis-h"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                      >
                        <path
                          class
                          fill="currentColor"
                          d="M328 256c0 39.8-32.2 72-72 72s-72-32.2-72-72 32.2-72 72-72 72 32.2 72 72zm104-72c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72zm-352 0c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72z"
                        />
                      </svg>
                      <div></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <div class="border border-solid border-gray-400 bg-white rounded shadow flex">
                <div
                  class="flex flex-col place-items-center text-2xl p-2 bg-gray-100 justify-center"
                >
                  <div>
                    <svg
                      class="svg-inline--fa fa-chevron-circle-up fa-w-16 text-red-500"
                      aria-hidden="true"
                      focusable="false"
                      data-prefix="fas"
                      data-icon="chevron-circle-up"
                      role="img"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 512 512"
                    >
                      <path
                        class
                        fill="currentColor"
                        d="M8 256C8 119 119 8 256 8s248 111 248 248-111 248-248 248S8 393 8 256zm231-113.9L103.5 277.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L256 226.9l101.6 101.6c9.4 9.4 24.6 9.4 33.9 0l17-17c9.4-9.4 9.4-24.6 0-33.9L273 142.1c-9.4-9.4-24.6-9.4-34 0z"
                      />
                    </svg>
                  </div>
                  <div class="text-red-500 font-bold">1.1k</div>
                  <div>
                    <svg
                      class="svg-inline--fa fa-chevron-circle-down fa-w-16"
                      aria-hidden="true"
                      focusable="false"
                      data-prefix="fas"
                      data-icon="chevron-circle-down"
                      role="img"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 512 512"
                    >
                      <path
                        class
                        fill="currentColor"
                        d="M504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zM273 369.9l135.5-135.5c9.4-9.4 9.4-24.6 0-33.9l-17-17c-9.4-9.4-24.6-9.4-33.9 0L256 285.1 154.4 183.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L239 369.9c9.4 9.4 24.6 9.4 34 0z"
                      />
                    </svg>
                  </div>
                </div>
                <div class="flex flex-col pl-4">
                  <div class="flex place-items-center space-x-2">
                    <img src="/images/js.png" alt class="w-8 rounded-full py-2" />
                    <div class="font-bold">r/learnjavascript</div>
                    <div class="font-thin text-gray-600">Posted by u/SuboptimalEng 10 hrs ago</div>
                  </div>
                  <div class="text-2xl font-bold">Tech Coding Interviews are Kinda Sus</div>
                  <div class="flex text-gray-500 space-x-4">
                    <div class="text-lg flex place-items-center space-x-2 p-2 hover:bg-gray-200">
                      <svg
                        class="svg-inline--fa fa-comment fa-w-16"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="comment"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                      >
                        <path
                          class
                          fill="currentColor"
                          d="M256 32C114.6 32 0 125.1 0 240c0 49.6 21.4 95 57 130.7C44.5 421.1 2.7 466 2.2 466.5c-2.2 2.3-2.8 5.7-1.5 8.7S4.8 480 8 480c66.3 0 116-31.8 140.6-51.4 32.7 12.3 69 19.4 107.4 19.4 141.4 0 256-93.1 256-208S397.4 32 256 32z"
                        />
                      </svg>
                      <div>Comments</div>
                    </div>
                    <div class="text-lg flex place-items-center space-x-2 p-2 hover:bg-gray-200">
                      <svg
                        class="svg-inline--fa fa-trophy fa-w-18"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="trophy"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 576 512"
                      >
                        <path
                          class
                          fill="currentColor"
                          d="M552 64H448V24c0-13.3-10.7-24-24-24H152c-13.3 0-24 10.7-24 24v40H24C10.7 64 0 74.7 0 88v56c0 35.7 22.5 72.4 61.9 100.7 31.5 22.7 69.8 37.1 110 41.7C203.3 338.5 240 360 240 360v72h-48c-35.3 0-64 20.7-64 56v12c0 6.6 5.4 12 12 12h296c6.6 0 12-5.4 12-12v-12c0-35.3-28.7-56-64-56h-48v-72s36.7-21.5 68.1-73.6c40.3-4.6 78.6-19 110-41.7 39.3-28.3 61.9-65 61.9-100.7V88c0-13.3-10.7-24-24-24zM99.3 192.8C74.9 175.2 64 155.6 64 144v-16h64.2c1 32.6 5.8 61.2 12.8 86.2-15.1-5.2-29.2-12.4-41.7-21.4zM512 144c0 16.1-17.7 36.1-35.3 48.8-12.5 9-26.7 16.2-41.8 21.4 7-25 11.8-53.6 12.8-86.2H512v16z"
                        />
                      </svg>
                      <div>Award</div>
                    </div>
                    <div class="text-lg flex place-items-center space-x-2 p-2 hover:bg-gray-200">
                      <svg
                        class="svg-inline--fa fa-share fa-w-16"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="share"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                      >
                        <path
                          class
                          fill="currentColor"
                          d="M503.691 189.836L327.687 37.851C312.281 24.546 288 35.347 288 56.015v80.053C127.371 137.907 0 170.1 0 322.326c0 61.441 39.581 122.309 83.333 154.132 13.653 9.931 33.111-2.533 28.077-18.631C66.066 312.814 132.917 274.316 288 272.085V360c0 20.7 24.3 31.453 39.687 18.164l176.004-152c11.071-9.562 11.086-26.753 0-36.328z"
                        />
                      </svg>
                      <div>Share</div>
                    </div>
                    <div class="text-lg flex place-items-center space-x-2 p-2 hover:bg-gray-200">
                      <svg
                        class="svg-inline--fa fa-bookmark fa-w-12"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="bookmark"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 384 512"
                      >
                        <path
                          class
                          fill="currentColor"
                          d="M0 512V48C0 21.49 21.49 0 48 0h288c26.51 0 48 21.49 48 48v464L192 400 0 512z"
                        />
                      </svg>
                      <div>Save</div>
                    </div>
                    <div class="text-lg flex place-items-center space-x-2 p-2 hover:bg-gray-200">
                      <svg
                        class="svg-inline--fa fa-ellipsis-h fa-w-16"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="ellipsis-h"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                      >
                        <path
                          class
                          fill="currentColor"
                          d="M328 256c0 39.8-32.2 72-72 72s-72-32.2-72-72 32.2-72 72-72 72 32.2 72 72zm104-72c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72zm-352 0c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72z"
                        />
                      </svg>
                      <div></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> --}}
    </div>
  </div>
<div class="md:flex bg-gray-100 h-full mt-20">
    {{-- <div class="hidden md:block md:w-96"></div> --}}
    <div class="flex-auto pb-8">
        <div class="flex flex-col space-y-2">
        <div class="font-2xl font-medium pl-32">Popular Posts</div>
        <feed class="space-y-4"></feed>
        </div>
    </div>
    <div class="hidden md:block mr-12 flex-none md:w-1/3">
    <!-- trending today -->
      <div class="flex flex-col space-y-2">
        <div class="font-2xl font-medium">Trending Videos</div>
        <div class="flex flex-col space-y-4">
          <div>
            <div class="relative">
              <img src="/images/01.png" alt class="rounded-xl object-cover h-52 xl:h-72 shadow" />
              <div
                class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"
              ></div>
              <div class="absolute bottom-4 left-4 right-4 text-white z-0">
                <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
                <div
                  class="text-sm xl:text-base font-bold overflow-hidden"
                >Vue CLI Setup Guide with Tailwind CSS</div>
              </div>
            </div>
          </div>
          <div>
            <div class="relative">
              <img src="/images/02.png" alt class="rounded-xl object-cover h-52 xl:h-72 shadow" />
              <div
                class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"
              ></div>
              <div class="absolute bottom-4 left-4 right-4 text-white z-0">
                <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
                <div
                  class="text-sm xl:text-base font-bold overflow-hidden"
                >Getting Started with Vim and VS Code</div>
              </div>
            </div>
          </div>
          <div>
            <div class="relative">
              <img src="/images/03.png" alt class="rounded-xl object-cover h-52 xl:h-72 shadow" />
              <div
                class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"
              ></div>
              <div class="absolute bottom-4 left-4 right-4 text-white z-0">
                <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
                <div
                  class="text-sm xl:text-base font-bold overflow-hidden"
                >Productive Mac OS Setup with Vim, iTerm2, and Oh My Zsh</div>
              </div>
            </div>
          </div>
          <div>
            <div class="relative">
              <img src="/images/04.png" alt class="rounded-xl object-cover h-52 xl:h-72 shadow" />
              <div
                class="absolute top-0 w-full h-full rounded-xl bg-gradient-to-b from-transparent to-black"
              ></div>
              <div class="absolute bottom-4 left-4 right-4 text-white z-0">
                <div class="text-sm xl:text-lg font-bold">@SuboptimalEng</div>
                <div
                  class="text-sm xl:text-base font-bold overflow-hidden"
                >Vue.js Setup Guide in VS Code with Vetur &amp; Airbnb ESLint</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<div>
    
    {{-- @include('post.create') --}}
</div>

@endsection
