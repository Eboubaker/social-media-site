<template>
  <div class="space-y-4" v-if="renderComponent">
    <div class="flex justify-center w-full mr-auto">
      <!-- <div> -->
      <button
        title="Add new Post"
        class="modal-open w-full h-10 px-2 bg-white border shadow-2xl rounded-lg flex justify-center items-center my-1 outline-none focus:outline-none focus:ring-logo-red focus:border-logo-red focus:text-logo-red hover:text-logo-red hover:border-logo-red"
      >
      <span class="text-lg font-semibold">Create New Post</span>

        <svg
          class="w-7 h-7 ml-4"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
      </button>

      <!--Modal-->
      <div
        class="modal z-20 opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center"
      >
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

        <div class="modal-container bg-white w-1/2 mx-auto rounded shadow-lg z-50 overflow-y-auto">
          <!-- Add margin if you want to see some of the overlay behind the modal-->
          <div class="modal-content px-2 divide-y">
            <!--Title-->
            <div class="flex items-center py-2">
              <span class="w-full text-center text-xl font-semibold">Create Post</span>
              <button
                class="modal-close z-50 flex items-center rounded-md hover:bg-red-50 hover:text-logo-red p-2"
              >
                <span class="material-icons">close</span>
              </button>
            </div>

            <!--Body-->
            <form class action="#">
              <div class="flex justify-between items-center space-x-2 my-4">
                <div class="flex place-items-center space-x-2">
                  <a href="#">
                    <img
                      class="w-14 h-14 rounded-full"
                      v-bind:src="this.$currentProfile.profileImage.url"
                      alt
                    />
                  </a>
                  <div>
                    <p class="text-xl font-semibold">{{ this.$currentProfile.username }}</p>
                  </div>
                </div>
                <t-rich-select
                  v-if="null == profile == community"
                  v-model="form.pageable"
                  :options="options"
                  class="w-2/3"
                  :fetch-options="fetchOptions"
                  placeholder="where are you going to post"
                  value-attribute="full_name"
                  text-attribute="full_name"
                  :minimum-input-length="1"
                >
                  <template
                    class="divide-y"
                    slot="label"
                    slot-scope="{ className, option, query, options, selectedOption }"
                  >
                    <div class="flex flex-col ml-2 text-gray-800">
                      <strong>{{ options[1] }}</strong>
                    </div>
                    <div class="flex">
                      <span class="flex-shrink-0">
                        <img class="w-10 h-10 rounded-full" :src="option.raw.owner.avatar_url" />
                      </span>
                      <div class="flex flex-col ml-2 text-gray-800">
                        <strong>{{ option.raw.full_name }}</strong>
                        <span class="text-sm leading-tight text-gray-700">{{ option.raw.description }}</span>
                      </div>
                    </div>
                  </template>
                </t-rich-select>
              </div>
              <input
                v-model="form.title"
                type="text"
                class="w-full mb-2 rounded text-lg focus:ring-logo-red focus:border-logo-red"
                name="title"
                id="title"
                placeholder="Post title"
              />
              <textarea
                v-model="form.body"
                class="w-full h-52 rounded text-lg focus:ring-logo-red focus:border-logo-red"
                name="body"
                id="body"
                placeholder="Write your post"
              ></textarea>
              <div class="flex items-center justify-center space-x-4">
                <input
                  type="file"
                  multiple
                  name="attachements[]"
                  v-on:change="refreshAttachements"
                  id="image"
                  hidden
                />
                <label
                  title="upload image"
                  class="flex items-center justify-center rounded-md p-2 w-12 cursor-pointer hover:bg-red-50 hover:text-logo-red transition-all ease-in-out"
                  for="image"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                    />
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                  </svg>
                </label>
                <input type="file" multiple name="attachements[]" id="video" hidden />
                <label
                  title="upload video"
                  class="flex items-center justify-center rounded-md p-2 w-12 cursor-pointer hover:bg-red-50 hover:text-logo-red transition-all ease-in-out"
                  for="video"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"
                    />
                  </svg>
                </label>
                <input type="file" name="attachements[]" id="audio" hidden />
                <label
                  title="upload audio"
                  class="flex items-center justify-center rounded-md p-2 w-12 cursor-pointer hover:bg-red-50 hover:text-logo-red transition-all ease-in-out"
                  for="audio"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"
                    />
                  </svg>
                </label>
              </div>
              <button
                class="modal-close w-11/12 mx-7 my-4 py-2 text-center text-white bg-gray-700 hover:bg-logo-black transition-all ease-in-out rounded-md"
                type="button"
                v-on:click="submit()"
              >Post</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div v-if="profile===null" class="flex flex-col w-full">
      <div
        class="mr-auto w-full flex flex-row justify-center place-items-center space-x-1 lg:space-x-4 border bg-white p-4 rounded-lg"
      >
        <div>
          <div
            :class="sortBy === 'best' ? 'text-logo-red bg-red-50 border-logo-red' : ''"
            @click="sortBy = 'best'"
            role="button"
            class="rounded-full cursor-pointer px-4 py-2 font-black flex place-items-center space-x-2 hover:text-logo-red hover:bg-red-50 hover:border-logo-red"
          >
            <div>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z"
                  clip-rule="evenodd"
                />
              </svg>
            </div>
            <div>Best</div>
            <!--v-if-->
          </div>
        </div>
        <div class="hidden lg:block">
          <div
            :class="sortBy === 'hot' ? 'text-logo-red bg-red-50 border-logo-red' : ''"
            @click="sortBy = 'hot'"
            role="button"
            class="rounded-full cursor-pointer px-4 py-2 font-black flex place-items-center space-x-2 hover:text-logo-red hover:bg-red-50 hover:border-logo-red"
          >
            <div>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                  clip-rule="evenodd"
                />
              </svg>
            </div>
            <div>Hot</div>
            <!--v-if-->
          </div>
        </div>
        <div>
          <div
            :class="sortBy === 'top' ? 'text-logo-red bg-red-50 border-logo-red' : ''"
            @click="sortBy = 'top'"
            role="button"
            class="rounded-full cursor-pointer px-4 py-2 font-black flex place-items-center space-x-2 hover:text-logo-red hover:bg-red-50 hover:border-logo-red"
          >
            <div>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"
                />
              </svg>
            </div>
            <div>Top</div>
            <!--v-if-->
          </div>
        </div>
        <div>
          <div
            :class="sortBy === 'new' ? 'text-logo-red bg-red-50 border-logo-red' : ''"
            @click="sortBy = 'new'"
            role="button"
            class="rounded-full cursor-pointer px-4 py-2 font-black flex justify-center items-center space-x-2 hover:text-logo-red hover:bg-red-50 hover:border-logo-red"
          >
            <div class="flex justify-center items-center">
              <span class="material-icons w-5 h-5">plus_one</span>
            </div>
            <div>New</div>
            <!--v-if-->
          </div>
        </div>
        <div class="hidden xl:block">
          <div
            :class="sortBy === 'active' ? 'text-logo-red bg-red-50 border-logo-red' : ''"
            @click="sortBy = 'active'"
            role="button"
            class="rounded-full cursor-pointer px-4 py-2 font-black flex justify-center items-center space-x-2 hover:text-logo-red hover:bg-red-50 hover:border-logo-red"
          >
            <div class="flex justify-center items-center">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"
                />
                <path
                  d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"
                />
              </svg>
            </div>
            <div>Active</div>
            <!--v-if-->
          </div>
        </div>
      </div>
    </div>
    <Post class="mx-1" :withPageIcon="!community && !profile" v-for="post in posts" :key="'p/'+post.id" :post="post" />
  </div>
</template>
<script>
import Post from "./Post";
export default {
  components: {
    Post
  },
  data() {
    var data = {
      renderComponent: true,
      options: [{
        "1": "yes"
      }],
      form: {
        pageable: "u/"+this.$currentProfile.username,
        body: "",
        title: "",
        attachements: []
      },
      posts: [],
      loading: false,
      profile: null,
      community: null,
      sortBy: this.$currentProfile.settings.sortBy // possible value: [best,hot,top,new,active]
    };
    var arr = window.location.pathname.split("/");
    if (arr[1] === "u") data.profile = arr[2];
    else if (arr[1] === "c") data.community = arr[2];
    return data;
  },
  watch: {
    sortBy: {
      handler: function(val, oldVal) {
        if (val !== oldVal) {
          this.posts = [];
          this.fetchData();
        }
      }
    }
  },
  created() {
    window.fetchData = this.fetchData;
    this.fetchData(null, this.profile ? 10 : 20);
    document.body.onscroll = function() {
      const perc =
        this.scrollY / (document.body.offsetHeight - window.innerHeight);
      if (perc > 0.7) {
        console.log(perc);
        window.fetchData();
      }
    };
  },
  methods: {
    fetchData(skip=null, count=null) {
      if (!this.loading) {
        this.loading = true;
        axios
          .post("/wapi/feed", {
            username: this.profile,
            community: this.community,
            skip: skip || this.posts.length,
            count: count || 10,
            sortBy: this.sortBy
          })
          .then(res => {
            this.posts.push(...res.data.data);
          })
          .catch(err => {
            console.log(err);
          })
          .then(() => (this.loading = false));
      }
    },
    refreshAttachements(e) {
      var files = e.target.files || e.dataTransfer.files;
      this.form.attachements.push(...files);
    },
    submit: function() {
      var formData = new FormData();
      for (let i = 0; i < this.form.attachements.length; i++) {
        formData.append("attachements[" + i + "]", this.form.attachements[i]);
      }
      formData.append("body", this.form.body);
      formData.append("title", this.form.title);
      axios
        .post("/u/posts", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(res => {
          console.log("work");
          this.posts.unshift(res.data.data);
          // this.forceRerender();
        })
        .catch(e => {
          console.log(e);
        })
        .then(e => {
          this.close();
        });
    },
    forceRerender() {
        // Remove my-component from the DOM
        this.renderComponent = false;
        this.$nextTick(() => {
            // Add the component back in
            this.renderComponent = true;
        });
    },
    fetchOptions(q) {
      return fetch(
        `/communities/search/${$q}`
      )
        .then(response => response.json())
        .then(data => ({ results: [this.$currentProfile.username ,...data] }));
    },
    close() {
      // destroy the vue listeners, etc
      this.$destroy();
    }
  }
};
</script>
