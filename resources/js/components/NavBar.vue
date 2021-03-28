<template>
  <div>
    <div class="flex items-center justify-between px-4 py-1 bg-white">
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
      <div class="flex flex-row space-x-1 justify-evenly items-center">
        <div class="notifications relative">
          <button
            title="Notifications"
            :class="notificationOpen ? 'bg-gray-200' : 'bg-white'"
            @click="notificationOpen = !notificationOpen"
            class="p-1 text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-full focus:outline-none"
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
          <Notifications :class="notificationOpen ? 'block' : 'hidden'" />
        </div>
        <div class="messages">
          <button
            title="Messages"
            :class="messageOpen ? 'bg-gray-200' : 'bg-white'"
            @click="messageOpen = !messageOpen"
            class="p-1 text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-full focus:outline-none"
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
          <Messages :class="messageOpen ? 'block' : 'hidden'" />
        </div>
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
        <!-- <div
          :class="isOpen ? 'block' : 'hidden'"
          class="absolute inset-0 bg-white z-20 px-2 pb-2 my-2 space-y-2 border-b-2 sm:pb-0 sm:hidden"
        >
          <div class="flex flex-row justify-evenly items-center space-x-2">
            <a
              class="flex flex-auto align-center px-2 py-2 space-x-2 hover:bg-gray-200 rounded"
              href="#"
            >
              <span class="material-icons">account_circle</span>
              <p class>Abd Elhak</p>
            </a>
            <div>
              <button
                :class="accountOpen ? 'bg-gray-200' : 'bg-gray-100'"
                @click="accountOpen = !accountOpen"
                class="flex flex-row justify-between items-center px-2 py-2 space-x-2 hover:bg-gray-200 rounded focus:outline-none"
              >
                <p>switch account</p>
                <span class="material-icons">arrow_drop_down_circle</span>
              </button>
            </div>
          </div>
          <div
            :class="accountOpen ? 'block' : 'hidden'"
            class="bg-gray-200 rounded px-2 py-2 space-y-2"
          >
            <a
              class="flex flex-auto align-center px-2 py-2 space-x-2 hover:bg-gray-300 rounded"
              href="#"
            >
              <span class="material-icons">account_circle</span>
              <p class>Abd Elhak_2</p>
            </a>
            <a
              class="flex flex-auto align-center px-2 py-2 space-x-2 hover:bg-gray-300 rounded"
              href="#"
            >
              <span class="material-icons">account_circle</span>
              <p class>Abd Elhak_3</p>
            </a>
            <a
              class="flex flex-auto align-center px-2 py-2 space-x-2 hover:bg-gray-300 rounded"
              href="#"
            >
              <span class="material-icons">account_circle</span>
              <p class>Abd Elhak_4</p>
            </a>
          </div>
          <hr class="my-2" />
          <a
            class="flex flex-auto align-center my-1 px-2 py-2 space-x-2 hover:bg-gray-200 rounded"
            href="#"
          >
            <span class="material-icons">account_circle</span>
            <p>Home</p>
          </a>
          <a
            class="flex flex-auto align-center my-1 px-2 py-2 space-x-2 hover:bg-gray-200 rounded"
            href="#"
          >
            <span class="material-icons">account_circle</span>
            <p>Friend Request</p>
          </a>
          <hr class="my-2" />
          <a
            class="flex flex-auto align-center my-1 px-2 py-2 space-x-2 hover:bg-gray-200 rounded"
            href="#"
          >
            <span class="material-icons">account_circle</span>
            <p>Quick Food</p>
          </a>
          <a
            class="flex flex-auto align-center my-1 px-2 py-2 space-x-2 hover:bg-gray-200 rounded"
            href="#"
          >
            <span class="material-icons">account_circle</span>
            <p>Quick Shope</p>
          </a>
          <a
            class="flex flex-auto align-center my-1 px-2 py-2 space-x-2 hover:bg-gray-200 rounded"
            href="#"
          >
            <span class="material-icons">account_circle</span>
            <p>Quick Move</p>
          </a>
        </div>-->
      </div>
    </div>
    <hr />
  </div>
</template>
<script>
import Post from "./Post";
import Notifications from "./Notifications";
import Messages from "./Messages";
import Menu from "./Menu";
export default {
  components: {
    Post,
    Menu,
    Messages,
    Notifications
  },
  data() {
    return {
      isOpen: false,
      accountOpen: false,
      searchOpen: false,
      notificationOpen: false,
      messageOpen: false,
      messageSettingOpen: false,
      notiSettingOpen: false
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