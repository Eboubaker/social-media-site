<template>
  <div class="relative z-20 text-left">
    <div
      class="origin-top-right absolute right-0 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
      role="menu"
      aria-orientation="vertical"
      aria-labelledby="options-menu"
    >
      <p class="block px-4 py-2 text-xl text-gray-700" role="menuitem">Settings</p>
      <div class="py-1 space-y-1 overflow-auto overscroll-contain" role="none">
        <!-- ````````````````/Profile start````````````````  -->
        <a
          v-bind:href="'/u/'+this.$currentProfile.username"
          class="flex flex-row items-center border-b space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
          role="menuitem"
        >
          <img class="w-12 h-12 rounded-full" v-bind:src="this.$currentProfile.avatarImage.url" alt />
          <div>
            <p class="text-xl font-medium">{{ this.$currentProfile.username }}</p>
          </div>
        </a>
        <a
          class="flex flex-auto align-center mx-1 my-1 px-2 py-2 space-x-2 hover:bg-gray-200 rounded"
          href="#"
        >
          <span class="material-icons">manage_accounts</span>
          <p>Profile Parameter</p>
        </a>
        <a
          class="flex flex-auto align-center mx-1 my-1 px-2 py-2 space-x-2 hover:bg-gray-200 rounded"
          href="#"
        >
          <span class="material-icons">view_in_ar</span>
          <p>Apperance</p>
        </a>
        <hr class="my-2" />
        <div class="flex-auto w-full px-1">
          <button
            class="flex w-full align-center px-2 py-2 space-x-2 hover:bg-gray-200 rounded"
            v-on:click="logout"
          >
            <span class="material-icons">logout</span>
            Logout
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
    <script>
export default {
  methods: {
    logout: function() {
      axios
        .post("/logout")
        .then(res => {
          window.location.href = "/";
        })
        .catch(e => {});
    }
  }
};
</script>