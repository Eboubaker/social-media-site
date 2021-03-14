<template>
  <div class="bg-white sm:flex sm:justify-between sm:px-4 border-b-2">
    <div class="flex items-center justify-between px-4 py-1 sm:p-0 bg-white">
      <div class="flex items-center">
        <img class="h-10" src="/img/logo.png" alt />
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none">
              <path
                d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </span>
          <form action="./confirm">
            <input
              type="text"
              class="w-full py-2 pl-10 pr-4 text-gray-700 bg-white border border-gray-300 outline-none rounded-3xl bg-gray-100"
              placeholder="Search"
            />
          </form>
        </div>
      </div>
      <div class="sm:hidden">
        <button
          class="p-1 text-gray-500 hover:bg-gray-100 rounded focus:outline-none"
          type="button"
        >
          <svg
            class="w-8 h-8 text-gray-500 fill-current"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
            <path
              d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"
            />
          </svg>
        </button>
      </div>
      <div class="sm:hidden">
        <button
          class="p-1 text-gray-500 hover:bg-gray-100 rounded focus:outline-none"
          type="button"
        >
          <svg
            class="w-8 h-8 text-gray-500 fill-current"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"
            />
          </svg>
        </button>
      </div>
      <div class="sm:hidden">
        <button
          :class="isOpen ? 'bg-gray-100' : 'bg-white'"
          @click="isOpen = !isOpen"
          class="p-1 text-gray-500 hover:bg-gray-100 rounded focus:outline-none"
          type="button"
        >
          <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24">
            <path
              fill-rule="evenodd"
              d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"
            />
          </svg>
        </button>
      </div>
    </div>
    <hr />

    <div :class="isOpen ? 'block' : 'hidden'" class="px-2 pb-2 my-2 sm:pb-0 sm:hidden">
      <div class="flex align-center">
        <svg
          class="w-8 h-8 text-gray-500 fill-current"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
            clip-rule="evenodd"
          />
        </svg>
        <a class="block flex-auto hover:bg-gray-100 rounded px-2 mb-2" href="#">Abd Elhak</a>
      </div>
      <hr />
      <a class="mt-1 block hover:bg-gray-100 rounded py-2 px-2 sm:mt-0 sm:ml-2" href="#">Posts</a>
      <a
        class="mt-1 mb-2 block hover:bg-gray-100 rounded py-2 px-2 sm:mt-0 sm:ml-2"
        href="#"
      >Friend Request</a>
      <hr />
      <a
        class="mt-1 block hover:bg-gray-100 rounded py-2 px-2 sm:mt-0 sm:ml-2 sm:hidden"
        href="#"
      >Quick Food</a>
      <a
        class="mt-1 block hover:bg-gray-100 rounded py-2 px-2 sm:mt-0 sm:ml-2 sm:hidden"
        href="#"
      >Quick Shope</a>
      <a
        class="mt-1 block hover:bg-gray-100 rounded py-2 px-2 sm:mt-0 sm:ml-2 sm:hidden"
        href="#"
      >Quick Move</a>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      isOpen: false,
      searchOpen: false
    };
  }
};
</script>