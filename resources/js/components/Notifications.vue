<template>
  <div class="relative text-left">
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
          v-if="notiSettingOpen"
          v-on-clickaway="hide"
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
          <img class="w-14 h-14 rounded-full" src="/img/150x150.png" alt />
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
          <img class="w-14 h-14 rounded-full" src="/img/150x150.png" alt />
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
          <img class="w-14 h-14 rounded-full" src="/img/150x150.png" alt />
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
          <img class="w-14 h-14 rounded-full" src="/img/150x150.png" alt />
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
          <img class="w-14 h-14 rounded-full" src="/img/150x150.png" alt />
          <div>
            <p>Abd Elhak</p>
            <p>Lorem ipsum dolor sit consectetur...</p>
            <p>23 m</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</template>
<script>
import { mixin as clickaway } from "vue-clickaway";
export default {
  mixins: [clickaway],
  data() {
    return {
      notiSettingOpen: false
    };
  },
  methods: {
    hide: function() {
      this.notiSettingOpen = false;
    }
  }
};
</script>