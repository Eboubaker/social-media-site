<template>
  <div>
    <!-- <t-input value="Hello world" name="my-input" /> -->

    <button
      title="Add new Post"
      class="modal-open w-10 h-10 px-2 bg-white border shadow-2xl rounded-full flex justify-center items-center my-1 outline-none focus:outline-none focus:ring-logo-red focus:border-logo-red focus:text-logo-red hover:text-logo-red hover:border-logo-red"
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
                    v-bind:src="this.$currentProfile.avatarImage.url"
                    alt
                  />
                </a>
                <div>
                  <p class="text-xl font-semibold">{{ this.$currentProfile.username }}</p>
                </div>
              </div>
              <t-rich-select
                v-model="selected"
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
</template>
<script>
export default {
  data() {
    return {
      form: {
        visibility: "public",
        body: "",
        title: "",
        attachements: []
      },
      selected: null,
      options: ["Option 1", "Option 2"]
    };
  },
  methods: {
    //  createOption (text) {
    //   this.options.push(text)
    //   this.selected = text
    // },
    fetchOptions(q) {
      return fetch(
        `https://api.github.com/search/repositories?q=${q}&type=public`
      )
        .then(response => response.json())
        .then(data => ({ results: data.items }));
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
          console.log(res);
        })
        .catch(e => {
          console.log(e);
        })
        .then(e => {
          this.close();
        });
    },
    close() {
      // destroy the vue listeners, etc
      this.$destroy();
    }
  }
};
</script>

