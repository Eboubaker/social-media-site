<template>
  <div>
    <div class="fixed z-40 w-full flex items-center justify-around px-4 py-1 bg-white">
      <div class="flex items-center space-x-2">
        <a title="Quick Look" href="/" alt="Quick Look">
          <!-- <img :class="!searchOpen ? 'block' : 'hidden'" class="h-10" src="/images/js.png" alt="Quick Look" /> -->
          <svg width="50" height="52" viewBox="0 0 50 52" xmlns="http://www.w3.org/2000/svg">
            <title>Logomark</title>
            <path
              d="M49.626 11.564a.809.809 0 0 1 .028.209v10.972a.8.8 0 0 1-.402.694l-9.209 5.302V39.25c0 .286-.152.55-.4.694L20.42 51.01c-.044.025-.092.041-.14.058-.018.006-.035.017-.054.022a.805.805 0 0 1-.41 0c-.022-.006-.042-.018-.063-.026-.044-.016-.09-.03-.132-.054L.402 39.944A.801.801 0 0 1 0 39.25V6.334c0-.072.01-.142.028-.21.006-.023.02-.044.028-.067.015-.042.029-.085.051-.124.015-.026.037-.047.055-.071.023-.032.044-.065.071-.093.023-.023.053-.04.079-.06.029-.024.055-.05.088-.069h.001l9.61-5.533a.802.802 0 0 1 .8 0l9.61 5.533h.002c.032.02.059.045.088.068.026.02.055.038.078.06.028.029.048.062.072.094.017.024.04.045.054.071.023.04.036.082.052.124.008.023.022.044.028.068a.809.809 0 0 1 .028.209v20.559l8.008-4.611v-10.51c0-.07.01-.141.028-.208.007-.024.02-.045.028-.068.016-.042.03-.085.052-.124.015-.026.037-.047.054-.071.024-.032.044-.065.072-.093.023-.023.052-.04.078-.06.03-.024.056-.05.088-.069h.001l9.611-5.533a.801.801 0 0 1 .8 0l9.61 5.533c.034.02.06.045.09.068.025.02.054.038.077.06.028.029.048.062.072.094.018.024.04.045.054.071.023.039.036.082.052.124.009.023.022.044.028.068zm-1.574 10.718v-9.124l-3.363 1.936-4.646 2.675v9.124l8.01-4.611zm-9.61 16.505v-9.13l-4.57 2.61-13.05 7.448v9.216l17.62-10.144zM1.602 7.719v31.068L19.22 48.93v-9.214l-9.204-5.209-.003-.002-.004-.002c-.031-.018-.057-.044-.086-.066-.025-.02-.054-.036-.076-.058l-.002-.003c-.026-.025-.044-.056-.066-.084-.02-.027-.044-.05-.06-.078l-.001-.003c-.018-.03-.029-.066-.042-.1-.013-.03-.03-.058-.038-.09v-.001c-.01-.038-.012-.078-.016-.117-.004-.03-.012-.06-.012-.09v-.002-21.481L4.965 9.654 1.602 7.72zm8.81-5.994L2.405 6.334l8.005 4.609 8.006-4.61-8.006-4.608zm4.164 28.764l4.645-2.674V7.719l-3.363 1.936-4.646 2.675v20.096l3.364-1.937zM39.243 7.164l-8.006 4.609 8.006 4.609 8.005-4.61-8.005-4.608zm-.801 10.605l-4.646-2.675-3.363-1.936v9.124l4.645 2.674 3.364 1.937v-9.124zM20.02 38.33l11.743-6.704 5.87-3.35-8-4.606-9.211 5.303-8.395 4.833 7.993 4.524z"
              fill="#FF2D20"
              fill-rule="evenodd"
            />
          </svg>
        </a>
        <div class="relative flex flex-row justify-start items-center rounded w-60 lg:w-80">
          <span class="material-icons absolute pl-2 w-7 h-7">search</span>
          <form class action="./confirm">
            <input
              type="text"
              class="bg-gray-100 pl-10 rounded outline-none border-none ring-0 focus:border-none focus:outline-none focus:ring-0"
              placeholder="Search"
            />
          </form>
        </div>
      </div>
      <div class="hidden md:flex md:flex-row md:justify-center md:space-x-2 md:w-2/3">
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
        <div class="notifications">
          <button
            title="Notifications"
            @click="notificationOpen = !notificationOpen"
            class="w-10 h-10 px-2 bg-white border shadow-2xl rounded-full flex justify-center items-center my-1 outline-none focus:outline-none focus:ring-logo-red focus:border-logo-red focus:text-logo-red hover:text-logo-red hover:border-logo-red"
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

          <Notifications v-if="notificationOpen" v-on-clickaway="hide" />
        </div>
        <!-- ````````````````Notifications end/````````````````  -->

        <!-- ````````````````/Messages start````````````````  -->
        <div class="messages">
          <button
            title="Messages"
            @click="messageOpen = !messageOpen"
            class="w-10 h-10 px-2 bg-white border shadow-2xl rounded-full flex justify-center items-center my-1 outline-none focus:outline-none focus:ring-logo-red focus:border-logo-red focus:text-logo-red hover:text-logo-red hover:border-logo-red"
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
          <Messages v-if="messageOpen" v-on-clickaway="hide" />
        </div>
        <!-- ````````````````Messages end/````````````````  -->

        <!-- ````````````````/Model start````````````````  -->
        <div class="Model">
          <!-- Model Block -->
          <Creatpost />
        </div>
        <!-- ````````````````/Model end````````````````  -->

        <!-- ````````````````/Settings start````````````````  -->
        <div class="Settings">
          <button
            title="Settings"
            @click="settingOpen = !settingOpen"
            class="w-10 h-10 px-2 bg-white border shadow-2xl rounded-full flex justify-center items-center my-1 outline-none focus:outline-none focus:ring-logo-red focus:border-logo-red focus:text-logo-red hover:text-logo-red hover:border-logo-red"
            type="button"
          >
            <span class="material-icons w-7 h-7">arrow_drop_down_circle</span>
          </button>
          <!-- Settings Block -->
          <Settings v-if="settingOpen" v-on-clickaway="hide" :user="user" />
        </div>
        <!-- ````````````````/Settings end````````````````  -->

        <!-- ````````````````/Menu start````````````````  -->
        <div class="Menu md:hidden">
          <button
            title="Menu"
            @click="isOpen = !isOpen"
            class="w-10 h-10 px-2 bg-white border shadow-2xl rounded-full flex justify-center items-center my-1 outline-none focus:outline-none focus:ring-logo-red focus:border-logo-red focus:text-logo-red hover:text-logo-red hover:border-logo-red"
            type="button"
          >
            <span class="material-icons w-7 h-7">menu</span>
          </button>
          <!-- Menu Block -->
          <Menu v-if="isOpen" v-on-clickaway="hide" />
        </div>
        <!-- ````````````````Menu end/````````````````  -->
      </div>
    </div>
    <hr />
    <div class="md:hidden flex flex-row justify-evenly bg-white p-2 space-x-2">
      <a
        class="flex flex-row justify-center items-center text-center px-4 py-2 space-x-2 hover:bg-red-50 hover:text-logo-red rounded w-32"
        href="/"
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
import { mixin as clickaway } from "vue-clickaway";
import Notifications from "./Notifications";
import Messages from "./Messages";
import Menu from "./Menu";
import Settings from "./Settings";
import Creatpost from "./CreatPost";
export default {
  mixins: [clickaway],
  components: {
    Menu,
    Messages,
    Notifications,
    Settings,
    Creatpost
  },
  data() {
    return {
      isOpen: false,
      accountOpen: false,
      searchOpen: false,
      notificationOpen: false,
      messageOpen: false,
      settingOpen: false,
      modelOpen: false,
      user: [],
      loading: false
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
  },
  methods: {
    hide: function() {
      this.notificationOpen = false;
      this.messageOpen = false;
      this.settingOpen = false;
      this.isOpen = false;
    }
  }
};
</script>