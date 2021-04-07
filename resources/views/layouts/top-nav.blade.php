<div class="sticky z-30 w-full">
    <div class="flex items-center justify-between px-4 py-1 bg-white">
      <div class="flex items-center space-x-2 w-1/3">
        <a title="Quick Look" href="/" alt="Quick Look">
          <img
            :class="!searchOpen ? 'block' : 'hidden'"
            class="h-10"
            src="/img/logo.png"
            alt="Quick Look"
          />
        </a>
        <div class="hidden md:block relative flex flex-row rounded-full space-x-2">
          <button
            title="Search"
            @click="searchOpen=!searchOpen"
            class="hidden absolute right-0 flex items-center p-2 rounded-full cursor-pointer outline-none focus:outline-none hover:bg-red-50 hover:text-logo-red"
          >
            <span :class="!searchOpen ? 'block' : 'hidden'" class="material-icons w-6 h-6">search</span>
            <span :class="!searchOpen ? 'hidden' : 'block'" class="material-icons w-6 h-6">cancel</span>
          </button>
          <form v-if="searchOpen" class action="./confirm">
            <input
              type="text"
              class="w-64 p-2 rounded-full border border-logo-black focus:border-logo-black focus:ring-1 focus:ring-logo-black outline-none focus:outline-non"
              placeholder="Search"
            />
          </form>
        </div>
      </div>
      <div class="hidden md:inline md:flex md:flex-row md:justify-start md:space-x-2 md:w-2/3">
        <a
          class="flex flex-row justify-center items-center text-center px-4 py-2 space-x-2 hover:bg-red-50 hover:text-logo-red rounded w-32"
          href="#"
        >
          <span class="material-icons">public</span>
          <span>World</span>
        </a>
        <a
          class="flex flex-row justify-center items-center text-center px-4 py-2 space-x-2 hover:bg-red-50 hover:text-logo-red rounded w-32"
          href="#"
        >
          <span class="material-icons">group</span>
          <span>Groups</span>
        </a>
        <a
          class="flex flex-row justify-center items-center text-center px-4 py-2 space-x-2 hover:bg-red-50 hover:text-logo-red rounded w-32"
          href="#"
        >
          <span class="material-icons">video_library</span>
          <span>Videos</span>
        </a>
        <a
          class="flex flex-row justify-center items-center text-center px-4 py-2 space-x-2 hover:bg-red-50 hover:text-logo-red rounded w-32"
          href="#"
        >
          <span class="material-icons">trending_up</span>
          <span class>Following</span>
        </a>
      </div>
      <div class="flex flex-row space-x-1 justify-evenly items-center">

          {{-- ````````````````/Notifications start```````````````` --}}
        <div class="notifications relative">
          <button
            title="Notifications"
            :class="notificationOpen ? 'bg-gray-200' : 'bg-white'"
            @click="notificationOpen = !notificationOpen"
            class="p-1 text-gray-500 bg-gray-100 hover:bg-red-50 hover:text-logo-red rounded-full focus:outline-none"
            type="button"
          >
            <!-- <span class="material-icons">notifications</span> -->
            <svg
              class="w-7 h-7"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
              />
            </svg>
          </button>
          <!-- Notifications Block -->
            <div class="relative text-left hidden">
                <div
                class="origin-top-right absolute right-0 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="options-menu"
                >
                <div class="flex flex-row justify-between items-center" role="none">
                    <p class="block px-4 py-2 text-xl text-gray-700" role="menuitem">Notifications</p>
                    <button
                    :class="notiSettingOpen ? 'bg-gray-200' : 'bg-white'"
                    @click="notiSettingOpen = !notiSettingOpen"
                    class="hover:bg-gray-100 m-2 p-1 w-9 h-9 outline-none focus:outline-none rounded-full"
                    >
                    <svg
                        class="text-gray-700"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"
                        />
                    </svg>
                    </button>

                    <div
                    :class="notiSettingOpen ? 'block' : 'hidden'"
                    class="absolute right-2 top-12 py-2 space-y-2 w-64 bg-white rounded-lg shadow-lg ring-1 ring-gray-200"
                    >
                    <a class="flex flex-row p-2 hover:bg-gray-100 items-center space-x-2" href="#">
                        <svg
                        class="w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                        </svg>
                        <p>mark all as read</p>
                    </a>
                    <a class="flex flex-row p-2 hover:bg-gray-100 items-center space-x-2" href="#">
                        <svg
                        class="w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"
                        />
                        </svg>
                        <p>Notifications settings</p>
                    </a>
                    <a class="flex flex-row p-2 hover:bg-gray-100 items-center space-x-2" href="#">
                        <svg
                        class="w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                        </svg>
                        <p>Open notifications</p>
                    </a>
                    </div>
                </div>
                <div class="py-1 space-y-1" role="none">
                    <a
                    href="#"
                    class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                    >
                    <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                    <div>
                        <p>Abd Elhak</p>
                        <p>Lorem ipsum dolor sit consectetur...</p>
                        <p>23 m</p>
                    </div>
                    </a>
                    <a
                    href="#"
                    class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                    >
                    <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                    <div>
                        <p>Abd Elhak</p>
                        <p>Lorem ipsum dolor sit consectetur...</p>
                        <p>23 m</p>
                    </div>
                    </a>
                    <a
                    href="#"
                    class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                    >
                    <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                    <div>
                        <p>Abd Elhak</p>
                        <p>Lorem ipsum dolor sit consectetur...</p>
                        <p>23 m</p>
                    </div>
                    </a>
                    <a
                    href="#"
                    class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                    >
                    <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                    <div>
                        <p>Abd Elhak</p>
                        <p>Lorem ipsum dolor sit consectetur...</p>
                        <p>23 m</p>
                    </div>
                    </a>
                    <a
                    href="#"
                    class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                    >
                    <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                    <div>
                        <p>Abd Elhak</p>
                        <p>Lorem ipsum dolor sit consectetur...</p>
                        <p>23 m</p>
                    </div>
                    </a>
                </div>
                </div>
            </div>
        </div>          
            {{-- ````````````````Notifications end/```````````````` --}}

            {{-- ````````````````/Messages start```````````````` --}}
        <div class="messages">
          <button
            title="Messages"
            :class="messageOpen ? 'bg-gray-200' : 'bg-white'"
            @click="messageOpen = !messageOpen"
            class="p-1 text-gray-500 bg-gray-100 hover:bg-red-50 hover:text-logo-red rounded-full focus:outline-none"
            type="button"
          >
            <!-- <span class="material-icons leading-7 inline">question_answer</span> -->
            <svg
              class="w-7 h-7"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
              />
            </svg>
          </button>
          <!-- Messages Block -->
            <div class="hidden relative z-20 text-left ">
                <div
                class="origin-top-right absolute right-0 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="options-menu"
                >
                <div class="relative flex flex-row justify-between items-center" role="none">
                    <p class="block px-4 py-2 text-xl text-gray-700" role="menuitem">Messages</p>
                    <button
                    :class="messageSettingOpen ? 'bg-gray-200' : 'bg-white'"
                    @click="messageSettingOpen = !messageSettingOpen"
                    class="hover:bg-gray-100 m-2 p-1 w-9 h-9 outline-none focus:outline-none rounded-full"
                    >
                    <svg
                        class="text-gray-700"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"
                        />
                    </svg>
                    </button>
                    <div
                    :class="messageSettingOpen ? 'block' : 'hidden'"
                    class="absolute right-2 top-12 py-2 space-y-2 w-64 bg-white rounded-lg shadow-lg ring-1 ring-gray-200"
                    >
                    <a class="flex flex-row p-2 hover:bg-gray-100 items-center space-x-2" href="#">
                        <svg
                        class="w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                        </svg>
                        <p>mark all as read</p>
                    </a>
                    <a class="flex flex-row p-2 hover:bg-gray-100 items-center space-x-2" href="#">
                        <svg
                        class="w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"
                        />
                        </svg>
                        <p>Messages settings</p>
                    </a>
                    <a class="flex flex-row p-2 hover:bg-gray-100 items-center space-x-2" href="#">
                        <svg
                        class="w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                        </svg>
                        <p>Open messages</p>
                    </a>
                    </div>
                </div>
                <div class="hidden py-1 space-y-1 h-96 overflow-auto overscroll-contain" role="none">
                    <a
                    href="#"
                    class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                    >
                    <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                    <div>
                        <p>Abd Elhak</p>
                        <p>Lorem ipsum dolor sit consectetur...</p>
                        <p>23 m</p>
                    </div>
                    </a>
                    <a
                    href="#"
                    class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                    >
                    <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                    <div>
                        <p>Abd Elhak</p>
                        <p>Lorem ipsum dolor sit consectetur...</p>
                        <p>23 m</p>
                    </div>
                    </a>
                    <a
                    href="#"
                    class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                    >
                    <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                    <div>
                        <p>Abd Elhak</p>
                        <p>Lorem ipsum dolor sit consectetur...</p>
                        <p>23 m</p>
                    </div>
                    </a>
                    <a
                    href="#"
                    class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                    >
                    <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                    <div>
                        <p>Abd Elhak</p>
                        <p>Lorem ipsum dolor sit consectetur...</p>
                        <p>23 m</p>
                    </div>
                    </a>
                    <a
                    href="#"
                    class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                    >
                    <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                    <div>
                        <p>Abd Elhak</p>
                        <p>Lorem ipsum dolor sit consectetur...</p>
                        <p>23 m</p>
                    </div>
                    </a>
                    <a
                    href="#"
                    class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                    >
                    <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                    <div>
                        <p>Abd Elhak</p>
                        <p>Lorem ipsum dolor sit consectetur...</p>
                        <p>23 m</p>
                    </div>
                    </a>
                    <a
                    href="#"
                    class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                    >
                    <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                    <div>
                        <p>Abd Elhak</p>
                        <p>Lorem ipsum dolor sit consectetur...</p>
                        <p>23 m</p>
                    </div>
                    </a>
                </div>
                </div>
            </div>
        </div>
            {{-- ````````````````Messages end/```````````````` --}}

            {{-- ````````````````/Settings start```````````````` --}}
            <div class="messages">
              <button
                title="Messages"
                :class="messageOpen ? 'bg-gray-200' : 'bg-white'"
                @click="messageOpen = !messageOpen"
                class="flex items-center p-1 text-gray-500 bg-gray-100 hover:bg-red-50 hover:text-logo-red rounded-full focus:outline-none"
                type="button"
              >
              <span class="material-icons w-7 h-7">
                arrow_drop_down_circle
                </span>
              </button>
              <!-- Messages Block -->
                <div class="hidden relative z-20 text-left ">
                    <div
                    class="origin-top-right absolute right-0 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
                    role="menu"
                    aria-orientation="vertical"
                    aria-labelledby="options-menu"
                    >
                    <div class="relative flex flex-row justify-between items-center" role="none">
                        <p class="block px-4 py-2 text-xl text-gray-700" role="menuitem">Messages</p>
                        <button
                        :class="messageSettingOpen ? 'bg-gray-200' : 'bg-white'"
                        @click="messageSettingOpen = !messageSettingOpen"
                        class="hover:bg-gray-100 m-2 p-1 w-9 h-9 outline-none focus:outline-none rounded-full"
                        >
                        <svg
                            class="text-gray-700"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"
                            />
                        </svg>
                        </button>
                        <div
                        :class="messageSettingOpen ? 'block' : 'hidden'"
                        class="absolute right-2 top-12 py-2 space-y-2 w-64 bg-white rounded-lg shadow-lg ring-1 ring-gray-200"
                        >
                        <a class="flex flex-row p-2 hover:bg-gray-100 items-center space-x-2" href="#">
                            <svg
                            class="w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                            </svg>
                            <p>mark all as read</p>
                        </a>
                        <a class="flex flex-row p-2 hover:bg-gray-100 items-center space-x-2" href="#">
                            <svg
                            class="w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"
                            />
                            </svg>
                            <p>Messages settings</p>
                        </a>
                        <a class="flex flex-row p-2 hover:bg-gray-100 items-center space-x-2" href="#">
                            <svg
                            class="w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                            </svg>
                            <p>Open messages</p>
                        </a>
                        </div>
                    </div>
                    <div class="hidden py-1 space-y-1 h-96 overflow-auto overscroll-contain" role="none">
                        <a
                        href="#"
                        class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                        role="menuitem"
                        >
                        <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                        <div>
                            <p>Abd Elhak</p>
                            <p>Lorem ipsum dolor sit consectetur...</p>
                            <p>23 m</p>
                        </div>
                        </a>
                        <a
                        href="#"
                        class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                        role="menuitem"
                        >
                        <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                        <div>
                            <p>Abd Elhak</p>
                            <p>Lorem ipsum dolor sit consectetur...</p>
                            <p>23 m</p>
                        </div>
                        </a>
                        <a
                        href="#"
                        class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                        role="menuitem"
                        >
                        <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                        <div>
                            <p>Abd Elhak</p>
                            <p>Lorem ipsum dolor sit consectetur...</p>
                            <p>23 m</p>
                        </div>
                        </a>
                        <a
                        href="#"
                        class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                        role="menuitem"
                        >
                        <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                        <div>
                            <p>Abd Elhak</p>
                            <p>Lorem ipsum dolor sit consectetur...</p>
                            <p>23 m</p>
                        </div>
                        </a>
                        <a
                        href="#"
                        class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                        role="menuitem"
                        >
                        <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                        <div>
                            <p>Abd Elhak</p>
                            <p>Lorem ipsum dolor sit consectetur...</p>
                            <p>23 m</p>
                        </div>
                        </a>
                        <a
                        href="#"
                        class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                        role="menuitem"
                        >
                        <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                        <div>
                            <p>Abd Elhak</p>
                            <p>Lorem ipsum dolor sit consectetur...</p>
                            <p>23 m</p>
                        </div>
                        </a>
                        <a
                        href="#"
                        class="flex flex-row items-center space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                        role="menuitem"
                        >
                        <img class="rounded-full" width="50" src="/img/150x150.png" alt />
                        <div>
                            <p>Abd Elhak</p>
                            <p>Lorem ipsum dolor sit consectetur...</p>
                            <p>23 m</p>
                        </div>
                        </a>
                    </div>
                    </div>
                </div>
            </div>
            {{-- ````````````````/Settings end```````````````` --}}

            {{-- ````````````````/Menu start```````````````` --}}
        <div class="menu sm:hidden">
          <button
            title="Menu"
            :class="isOpen ? 'bg-gray-200' : 'bg-white'"
            @click="isOpen = !isOpen"
            class="relative p-1 text-gray-500 hover:bg-red-50 hover:text-logo-red rounded focus:outline-none"
            type="button"
          >
            <svg
              class="w-7 h-7"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
          </button>
        </div>
        <div
            class="hidden fixed z-20 top-6 right-3 mt-5 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="options-menu"
        >
            <p class="block px-4 py-2 text-xl" role="menuitem">Profile & Settings</p>
            <div class="flex flex-row justify-between items-center px-1 py-1 space-x-2">
            <a class="flex flex-auto align-center px-2 py-2 space-x-2 hover:bg-gray-200 rounded" href="#">
                <span class="material-icons">account_circle</span>
                <p class>Abd Elhak</p>
            </a>
            <button
                title="Switche Account"
                :class="accountOpen ? 'bg-red-100 text-logo-red hover:text-logo-red focus:ring-1 focus:ring-logo-red focus:ring-offset-1' : 'bg-gray-100'"
                @click="accountOpen = !accountOpen"
                class="w-10 h-10 hover:bg-red-100 hover:text-red-400 rounded focus:outline-none"
            >
                <span class="material-icons">arrow_drop_down_circle</span>
            </button>
            </div>
            <div :class="accountOpen ? 'block' : 'hidden'" class="mb-1 px-4 py-2 space-y-2 bg-gray-100">
            <a class="flex flex-auto align-center px-2 py-2 space-x-2 hover:bg-gray-200 rounded" href="#">
                <span class="material-icons">account_circle</span>
                <p class>Abd Elhak_2</p>
            </a>
            <a class="flex flex-auto align-center px-2 py-2 space-x-2 hover:bg-gray-200 rounded" href="#">
                <span class="material-icons">account_circle</span>
                <p class>Abd Elhak_3</p>
            </a>
            <a class="flex flex-auto align-center px-2 py-2 space-x-2 hover:bg-gray-200 rounded" href="#">
                <span class="material-icons">account_circle</span>
                <p class>Abd Elhak_4</p>
            </a>
            </div>
            <div class="py-1 space-y-1" role="none">
            <a
                class="flex flex-auto align-center mx-1 my-1 px-2 py-2 space-x-2 hover:bg-gray-200 rounded"
                href="#"
            >
                <span class="material-icons">account_circle</span>
                <p>Home</p>
            </a>
            <a
                class="flex flex-auto align-center mx-1 my-1 px-2 py-2 space-x-2 hover:bg-gray-200 rounded"
                href="#"
            >
                <span class="material-icons">account_circle</span>
                <p>Friend Request</p>
            </a>
            <hr class="my-2" />
            <a
                class="flex flex-auto align-center mx-1 my-1 px-2 py-2 space-x-2 hover:bg-gray-200 rounded"
                href="#"
            >
                <span class="material-icons">account_circle</span>
                <p>Quick Food</p>
            </a>
            <a
                class="flex flex-auto align-center mx-1 my-1 px-2 py-2 space-x-2 hover:bg-gray-200 rounded"
                href="#"
            >
                <span class="material-icons">account_circle</span>
                <p>Quick Shope</p>
            </a>
            <a
                class="flex flex-auto align-center mx-1 my-1 px-2 py-2 space-x-2 hover:bg-gray-200 rounded"
                href="#"
            >
                <span class="material-icons">account_circle</span>
                <p>Quick Move</p>
            </a>
            </div>
        </div>
            {{-- ````````````````Menu end/```````````````` --}}
      </div>
    </div>
    <hr />
  <div class="md:hidden flex flex-row justify-evenly bg-white p-2 space-x-2">
    <a
      class="flex flex-row justify-center items-center text-center px-4 py-2 space-x-2 hover:bg-red-50 hover:text-logo-red rounded w-32"
      href="#"
    >
      <span class="material-icons">public</span>
      <span>World</span>
    </a>
    <a
      class="flex flex-row justify-center items-center text-center px-4 py-2 space-x-2 hover:bg-red-50 hover:text-logo-red rounded w-32"
      href="#"
    >
      <span class="material-icons">group</span>
      <span>Groups</span>
    </a>
    <a
      class="flex flex-row justify-center items-center text-center px-4 py-2 space-x-2 hover:bg-red-50 hover:text-logo-red rounded w-32"
      href="#"
    >
      <span class="material-icons">video_library</span>
      <span>Videos</span>
    </a>
    <a
      class="flex flex-row justify-center items-center text-center px-4 py-2 space-x-2 hover:bg-red-50 hover:text-logo-red rounded w-32"
      href="#"
    >
      <span class="material-icons">trending_up</span>
      <span class>Following</span>
    </a>
  </div>
</div>
