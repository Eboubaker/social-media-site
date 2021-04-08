<template>
  <div>
    <div class="fixed z-30 w-full flex items-center justify-between px-4 py-1 bg-white">
      <div class="flex items-center space-x-2">
        <a title="Quick Look" href="/" alt="Quick Look">
          <img
            :class="!searchOpen ? 'block' : 'hidden'"
            class="h-10"
            src="/img/logo.png"
            alt="Quick Look"
          />
        </a>
        <div class="flex flex-row rounded-full bg-gray-100 space-x-2">
          <button
            title="Search"
            @click="searchOpen=!searchOpen"
            class="flex items-center p-2 rounded-full cursor-pointer outline-none focus:outline-none hover:bg-gray-200"
          >
            <span :class="!searchOpen ? 'block' : 'hidden'" class="material-icons w-6 h-6">search</span>
            <span :class="!searchOpen ? 'hidden' : 'block'" class="material-icons w-6 h-6">cancel</span>
          </button>
          <form v-if="searchOpen" class action="./confirm">
            <input
              type="text"
              class="px-2 py-1 my-1 rounded-full outline-none focus:outline-none bg-gray-100"
              placeholder="Search"
            />
          </form>
        </div>
      </div>
      <div class="hidden md:flex md:flex-row md:justify-start md:space-x-2 md:w-2/3">
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
        <!-- ````````````````/Notifications start````````````````  -->
        <div class="notifications relative" x-data="{notificationOpen: false}">
          <button
            title="Notifications"
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

          <Notifications
            :class="notificationOpen ? 'block' : 'hidden'"
            v:click.away="notificationOpen"
          />
        </div>
        <!-- ````````````````Notifications end/````````````````  -->

        <!-- ````````````````/Messages start````````````````  -->
        <div class="messages" x-data="{messageOpen: false}">
          <button
            title="Messages"
            @click="messageOpen = !messageOpen"
            class="p-1 text-gray-500 bg-gray-100 hover:bg-red-50 hover:text-logo-red rounded-full focus:outline-none"
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
                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
              />
            </svg>
          </button>
          <!-- Messages Block -->
          <Messages :class="messageOpen ? 'block' : 'hidden'" />
        </div>
        <!-- ````````````````Messages end/````````````````  -->

        <!-- ````````````````/Settings start````````````````  -->
        <div class="Settings" x-data="{messageOpen: false}">
          <button
            title="Settings"
            @click="settingOpen = !settingOpen"
            class="flex justify-center items-center p-1 text-gray-500 bg-gray-100 hover:bg-red-50 hover:text-logo-red rounded-full focus:outline-none"
            type="button"
          >
            <span class="material-icons w-7 h-7">arrow_drop_down_circle</span>
          </button>
          <!-- Settings Block -->
          <Settings :class="settingOpen ? 'block' : 'hidden'" />
        </div>
        <!-- ````````````````/Settings end````````````````  -->

        <!-- ````````````````/Menu start````````````````  -->
        <div class="menu sm:hidden">
          <button
            title="Menu"
            :class="isOpen ? 'bg-gray-200' : 'bg-white'"
            @click="isOpen = !isOpen"
            class="relative p-1 text-gray-500 hover:bg-gray-200 rounded focus:outline-none"
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
        <Menu :class="isOpen ? 'block' : 'hidden'" />
        <!-- ````````````````Menu end/````````````````  -->
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
</template>
<script>
import Post from "./Post";
import Notifications from "./Notifications";
import Messages from "./Messages";
import Menu from "./Menu";
import Settings from "./Settings";
export default {
  components: {
    Post,
    Menu,
    Messages,
    Notifications,
    Settings
  },
  data() {
    return {
      isOpen: false,
      accountOpen: false,
      searchOpen: false,
      notificationOpen: false,
      messageOpen: false,
      settingOpen: false
    };
  },
  created() {
    const handleEscape = e => {
      if (e.key === "Esc" || e.key === "Escape") {
        this.isOpen = false;
        this.searchOpen = false;
      }
    };
    document.addEventListener("keydown", handleEscape);
    this.$once("hook:beforeDestroy", () => {
      document.removeEventListener("keydown", handleEscape);
    });
  }
};
</script>