<template>
  <div class="notifications" v-on-clickaway="closeNotifications">
    <button
      title="Notifications"
      @click="notificationOpen = !notificationOpen"
      class="w-10 h-10 px-2 relative bg-white border shadow-2xl rounded-full flex justify-center items-center my-1 outline-none focus:outline-none focus:ring-logo-red focus:border-logo-red focus:text-logo-red hover:text-logo-red hover:border-logo-red"
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
      <div v-if="this.notifications.filter(e => !e.read).length > 0" class="absolute w-2 h-2 rounded-full bg-red-600 bottom-0 right-0 opacity-80" style="margin:0 .35rem .35rem 0"></div>
    </button>
    <div class="relative text-left" v-if="notificationOpen" >
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
            v-on-clickaway="closeSettings"
            class="z-10 absolute right-2 top-12 py-2 space-y-2 w-64 bg-white rounded-lg shadow-lg ring-1 ring-gray-200"
          >
            <a class="flex flex-row p-2 hover:bg-gray-100 items-center space-x-2" href="#" @click="readNotifications()">
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
            v-for="notification in notifications"
            :key="notification.id"
            :href="notification.url"
            :class="!notification.read ? 'border-l-4 border-red-400' : ''"
            class="flex flex-row items-center relative space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
            role="menuitem"
          >
            <div v-if="notification.event == 'NewFollower'"  class="flex space-x-2 w-full h-full m-0 p-0">
              <img class="w-14 h-14 rounded-full" :src="notification.follower_avatarImage" alt />
              <div>
                <p class="text-md text-black font-semibold">You have new Followers</p>
                <p class="text-gray-900"><span class="font-semibold">{{ notification.follower_username }}</span> has started following you</p>
                <p>{{ notification.created_at }}</p>
              </div>
            </div>
          </a>
          <div v-if="notifications.length == 0" 
            class="flex flex-row items-center relative space-x-2 mx-1 px-4 py-2 rounded text-xs text-gray-700 hover:bg-gray-100 hover:text-gray-900"
          >
            You have no new Notifications
          </div>
        </div>
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
      notiSettingOpen: false,
      notificationOpen: false,
      notifications: [],
    };
  },
  created: function(){
    Echo.channel('quicklook')
        .listen('.new-follower-notification', e => console.log(e));
  },
  methods: {
    // fetchNotifications: function(){
    //   axios.post('/n/unread', {
    //     exclude: this.notifications.map(e => e.id)
    //   })
    //   .then(res => res.data.data.length > 0 ? this.notifications.push(...res.data.data) : 0)
    //   .catch(e => console.error(e))
    //   .then(e => setTimeout(this.fetchNotifications, 5000))
    // },
    readNotifications: function(){
      axios.post('/n/read', {
        ids: this.notifications.map(e => e.id)
      })
      .then(this.notifications.forEach(e => e.read = true))
      .catch(e => console.err(e))
      return false;
    },
    closeNotifications: function(){
      this.notificationOpen = false;
    },
    closeSettings: function(){
      this.notiSettingOpen = false;
    }
  }
};
</script>