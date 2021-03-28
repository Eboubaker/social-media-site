    <template>
  <div
    class="fixed z-20 top-6 right-3 mt-5 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
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
</template>
    <script>
export default {
  data() {
    return {
      accountOpen: false
    };
  }
};
</script>