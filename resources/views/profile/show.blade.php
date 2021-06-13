@extends('layouts.app')     

@section('content')
    <nav-bar class="hidden sm:block"></nav-bar>
    {{-- <div class="flex pt-14">
      <div class="w-1/6 min-h-screen bg-white divide-y space-y-2">
        <div class="flex flex-col items-center py-4">
          <img class="rounded-full h-44 w-44 mb-4" src="/img/150x150.png" alt />
          <p class="text-xl">Abdelhak Darbeida</p>
          <p class="text-sm">@abdelhak.darbeida</p>
        </div>
        <div class="flex flex-col place-items-center divide-y space-y-2">
          <a class="flex justify-between items-center w-full px-2 pt-2 text-center" href="#">
            Profile
            <span class="material-icons">arrow_drop_down_circle</span>
          </a>
          <a class="flex justify-between items-center w-full px-2 pt-2 text-center" href="#">
            Account
            <span class="material-icons">arrow_drop_down_circle</span>
          </a>
          <a class="flex justify-between items-center w-full px-2 pt-2 text-center" href="#">
            Saved Content
            <span class="material-icons">arrow_drop_down_circle</span>
          </a>
          <a class="flex justify-between items-center w-full px-2 pt-2 text-center" href="#">
            Settings
            <span class="material-icons">arrow_drop_down_circle</span>
          </a>
          <a class="flex justify-between items-center w-full px-2 pt-2 text-center" href="#">
            About
            <span class="material-icons">arrow_drop_down_circle</span>
          </a>
        </div>
      </div> --}}
      <div class="pt-16">
        <main role="main">
          <div class="flex flex-col items-start py-2 w-1/2 bg-white mx-auto">
            {{-- <div class="px-4 py-2">
                <a
                    href
                    class="text-2xl font-medium rounded-full border hover:border-logo-red hover:text-logo-red float-right "
                >
                    <svg class="m-2 h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                    <g>
                        <path
                        d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6c-.39.39-.39 1.023 0 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L7.414 13H20c.553 0 1-.447 1-1s-.447-1-1-1z"
                        />
                    </g>
                    </svg>
                </a>
            </div> --}}
            <section class="w-10/12 mx-auto " >
              <!--Content (Center)-->
              <!-- Nav back-->
              {{-- <div>
                <div class="flex justify-start">
                    <div class="px-4 py-2 mx-2">
                        <a
                            href
                            class="text-2xl font-medium rounded-full border hover:border-logo-red hover:text-logo-red float-right "
                        >
                            <svg class="m-2 h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <g>
                                <path
                                d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6c-.39.39-.39 1.023 0 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L7.414 13H20c.553 0 1-.447 1-1s-.447-1-1-1z"
                                />
                            </g>
                            </svg>
                        </a>
                    </div>
                    <div class="mx-2">
                        <h2 class="mb-0 text-xl font-bold ">Abdelhak Darbeida</h2>
                        <p class="mb-0 w-48 text-xs text-gray-400">@darbeida_abdelhak</p>
                    </div>
                </div>
              </div> --}}

              <!-- User card-->
              <div>
                <div
                  class="w-full bg-cover bg-no-repeat bg-center"
                  style="height: 200px; background-image: url(https://pbs.twimg.com/profile_banners/2161323234/1585151401/600x200);"
                >
                  <img
                    class="opacity-0 w-full h-full"
                    src="https://pbs.twimg.com/profile_banners/2161323234/1585151401/600x200"
                    alt
                  />
                </div>
                <div class="p-4">
                  <div class="relative flex w-full">
                    <!-- Avatar -->
                    <div class="flex flex-1">
                      <div style="margin-top: -6rem;">
                        <div
                          style="height:9rem; width:9rem;"
                          class="md rounded-full relative avatar"
                        >
                          <img
                            style="height:9rem; width:9rem;"
                            class="md rounded-full relative border-4 border-gray-900"
                            src="https://pbs.twimg.com/profile_images/1254779846615420930/7I4kP65u_400x400.jpg"
                            alt
                          />
                          <div class="absolute"></div>
                        </div>
                      </div>
                    </div>
                    <!-- Follow Button -->
                    <div class="flex flex-col text-right">
                      <button
                        class="flex justify-center max-h-max whitespace-nowrap focus:outline-none focus:ring rounded-full max-w-max border bg-transparent border-red-400 text-red-400 hover:border-logo-red hover:text-logo-red items-center hover:shadow-sm font-bold py-2 px-4 mr-0 ml-auto"
                      >Edit Profile</button>
                    </div>
                  </div>

                  <!-- Profile info -->
                  <div class="space-y-1 justify-center w-full mt-3 ml-3">
                    <!-- User basic-->
                    <div>
                      <h2
                        class="text-xl leading-6 font-bold"
                      >ℜ𝔦𝔠𝔞𝔯𝔡𝔬ℜ𝔦𝔟𝔢𝔦𝔯𝔬.dev</h2>
                      <p class="text-sm leading-5 font-medium text-gray-600">@Ricardo_oRibeir</p>
                    </div>
                    <!-- Description and others -->
                    <div class="mt-3">
                      <p class="leading-tight mb-2">
                        Software Engineer / Designer / Entrepreneur
                        <br />Visit my website to test a working
                        <b>Twitter Clone.</b>
                      </p>
                      <div class="text-gray-600 flex">
                        <span class="flex mr-2">
                          <svg viewBox="0 0 24 24" class="h-5 w-5 paint-icon">
                            <g>
                              <path
                                d="M11.96 14.945c-.067 0-.136-.01-.203-.027-1.13-.318-2.097-.986-2.795-1.932-.832-1.125-1.176-2.508-.968-3.893s.942-2.605 2.068-3.438l3.53-2.608c2.322-1.716 5.61-1.224 7.33 1.1.83 1.127 1.175 2.51.967 3.895s-.943 2.605-2.07 3.438l-1.48 1.094c-.333.246-.804.175-1.05-.158-.246-.334-.176-.804.158-1.05l1.48-1.095c.803-.592 1.327-1.463 1.476-2.45.148-.988-.098-1.975-.69-2.778-1.225-1.656-3.572-2.01-5.23-.784l-3.53 2.608c-.802.593-1.326 1.464-1.475 2.45-.15.99.097 1.975.69 2.778.498.675 1.187 1.15 1.992 1.377.4.114.633.528.52.928-.092.33-.394.547-.722.547z"
                              />
                              <path
                                d="M7.27 22.054c-1.61 0-3.197-.735-4.225-2.125-.832-1.127-1.176-2.51-.968-3.894s.943-2.605 2.07-3.438l1.478-1.094c.334-.245.805-.175 1.05.158s.177.804-.157 1.05l-1.48 1.095c-.803.593-1.326 1.464-1.475 2.45-.148.99.097 1.975.69 2.778 1.225 1.657 3.57 2.01 5.23.785l3.528-2.608c1.658-1.225 2.01-3.57.785-5.23-.498-.674-1.187-1.15-1.992-1.376-.4-.113-.633-.527-.52-.927.112-.4.528-.63.926-.522 1.13.318 2.096.986 2.794 1.932 1.717 2.324 1.224 5.612-1.1 7.33l-3.53 2.608c-.933.693-2.023 1.026-3.105 1.026z"
                              />
                            </g>
                          </svg>
                          <a
                            href="#"
                            target="#"
                            class="leading-5 ml-1 text-logo-red"
                          >www.abdelhak-darbeida.com</a>
                        </span>
                        <span class="flex mr-2">
                          <svg viewBox="0 0 24 24" class="h-5 w-5 paint-icon">
                            <g>
                              <path
                                d="M19.708 2H4.292C3.028 2 2 3.028 2 4.292v15.416C2 20.972 3.028 22 4.292 22h15.416C20.972 22 22 20.972 22 19.708V4.292C22 3.028 20.972 2 19.708 2zm.792 17.708c0 .437-.355.792-.792.792H4.292c-.437 0-.792-.355-.792-.792V6.418c0-.437.354-.79.79-.792h15.42c.436 0 .79.355.79.79V19.71z"
                              />
                              <circle cx="7.032" cy="8.75" r="1.285" />
                              <circle cx="7.032" cy="13.156" r="1.285" />
                              <circle cx="16.968" cy="8.75" r="1.285" />
                              <circle cx="16.968" cy="13.156" r="1.285" />
                              <circle cx="12" cy="8.75" r="1.285" />
                              <circle cx="12" cy="13.156" r="1.285" />
                              <circle cx="7.032" cy="17.486" r="1.285" />
                              <circle cx="12" cy="17.486" r="1.285" />
                            </g>
                          </svg>
                          <span class="leading-5 ml-1">Joined December, 2019</span>
                        </span>
                      </div>
                    </div>
                    <div
                      class="pt-3 flex justify-start items-start w-full divide-x divide-gray-800 divide-solid"
                    >
                      <div class="text-center pr-3">
                        <span class="font-bold">520</span>
                        <span class="text-gray-600">Following</span>
                      </div>
                      <div class="text-center px-3">
                        <span class="font-bold">23,4m</span>
                        <span class="text-gray-600">Followers</span>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="border-gray-800" />
              </div>

              <ul class="list-none">
                <li>
                  <feed class="space-y-4"></feed>
                  <!--second tweet-->
                  <article class="border rounded-lg mt-6">
                    <div class="flex flex-shrink-0 p-4 pb-0">
                      <a href="#" class="flex-shrink-0 group block">
                        <div class="flex items-center">
                          <div>
                            <img
                              class="inline-block h-10 w-10 rounded-full"
                              src="https://pbs.twimg.com/profile_images/1121328878142853120/e-rpjoJi_bigger.png"
                              alt
                            />
                          </div>
                          <div class="ml-3">
                            <p class="text-base leading-6 font-medium ">
                              Sonali Hirave
                              <span
                                class="text-sm leading-5 font-medium text-gray-400 group-hover:text-gray-300 transition ease-in-out duration-150"
                              >@ShonaDesign . 16 April</span>
                            </p>
                          </div>
                        </div>
                      </a>
                    </div>

                    <div class="pl-16">
                      <p class="text-base width-auto font-medium  flex-shrink">
                        Day 07 of the challenge
                        <a href="#" class="text-blue-400">#100DaysOfCode</a>
                        I was wondering what I can do with
                        <a href="#" class="text-blue-400">#tailwindcss</a>, so just started building
                        Twitter UI using Tailwind and so far it looks so promising. I will post my code after completion.
                        [07/100]
                        <a
                          href="#"
                          class="text-blue-400"
                        >#WomenWhoCode #CodeNewbie</a>
                      </p>

                      <div class="md:flex-shrink pr-6 pt-3">
                        <div
                          class="bg-cover bg-no-repeat bg-center rounded-lg w-full h-64"
                          style="height: 200px; background-image: url(https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=448&amp;q=80);"
                        >
                          <img
                            class="opacity-0 w-full h-full"
                            src="https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=448&amp;q=80"
                            alt
                          />
                        </div>
                      </div>

                      <div class="flex items-center py-4">
                        <div
                          class="flex-1 flex items-center  text-xs text-gray-400 hover:text-blue-400 transition duration-350 ease-in-out"
                        >
                          <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                            <g>
                              <path
                                d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z"
                              />
                            </g>
                          </svg>
                          12.3 k
                        </div>
                        <div
                          class="flex-1 flex items-center  text-xs text-gray-400 hover:text-green-400 transition duration-350 ease-in-out"
                        >
                          <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                            <g>
                              <path
                                d="M23.77 15.67c-.292-.293-.767-.293-1.06 0l-2.22 2.22V7.65c0-2.068-1.683-3.75-3.75-3.75h-5.85c-.414 0-.75.336-.75.75s.336.75.75.75h5.85c1.24 0 2.25 1.01 2.25 2.25v10.24l-2.22-2.22c-.293-.293-.768-.293-1.06 0s-.294.768 0 1.06l3.5 3.5c.145.147.337.22.53.22s.383-.072.53-.22l3.5-3.5c.294-.292.294-.767 0-1.06zm-10.66 3.28H7.26c-1.24 0-2.25-1.01-2.25-2.25V6.46l2.22 2.22c.148.147.34.22.532.22s.384-.073.53-.22c.293-.293.293-.768 0-1.06l-3.5-3.5c-.293-.294-.768-.294-1.06 0l-3.5 3.5c-.294.292-.294.767 0 1.06s.767.293 1.06 0l2.22-2.22V16.7c0 2.068 1.683 3.75 3.75 3.75h5.85c.414 0 .75-.336.75-.75s-.337-.75-.75-.75z"
                              />
                            </g>
                          </svg>
                          14 k
                        </div>
                        <div
                          class="flex-1 flex items-center  text-xs text-gray-400 hover:text-red-600 transition duration-350 ease-in-out"
                        >
                          <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                            <g>
                              <path
                                d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z"
                              />
                            </g>
                          </svg>
                          14 k
                        </div>
                        <div
                          class="flex-1 flex items-center  text-xs text-gray-400 hover:text-blue-400 transition duration-350 ease-in-out"
                        >
                          <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                            <g>
                              <path
                                d="M17.53 7.47l-5-5c-.293-.293-.768-.293-1.06 0l-5 5c-.294.293-.294.768 0 1.06s.767.294 1.06 0l3.72-3.72V15c0 .414.336.75.75.75s.75-.336.75-.75V4.81l3.72 3.72c.146.147.338.22.53.22s.384-.072.53-.22c.293-.293.293-.767 0-1.06z"
                              />
                              <path
                                d="M19.708 21.944H4.292C3.028 21.944 2 20.916 2 19.652V14c0-.414.336-.75.75-.75s.75.336.75.75v5.652c0 .437.355.792.792.792h15.416c.437 0 .792-.355.792-.792V14c0-.414.336-.75.75-.75s.75.336.75.75v5.652c0 1.264-1.028 2.292-2.292 2.292z"
                              />
                            </g>
                          </svg>
                        </div>
                      </div>
                    </div>
                    <hr class="border-gray-800" />
                  </article>
                </li>
              </ul>
            </section>
          </div>
        </main>
      </div>
    </div>
@endsection
