<template>
  <div>
    <div class="flex flex-row justify-items-center">
      <div>start</div>
      <div>start</div>
    </div>
    <div class="flex flex-col">
      <div>Sort Posts By</div>
      <div class="felx justify-center bg-red-200">
        <a href="#" class>
          <span class="material-icons">auto_awesome</span>
        </a>

        <a href="#" class>
          <span class="material-icons">local_fire_department</span>
        </a>

        <a href="#" class>
          <span class="material-icons">local_fire_department</span>
        </a>

        <a href="#" class>
          <span class="material-icons">local_fire_department</span>
        </a>

        <a href="#" class>
          <span class="material-icons">local_fire_department</span>
        </a>
      </div>
    </div>
    <div>
      <form class action="#">
        <div class="flex items-center space-x-2 my-4">
          <a href="#">
            <img class="w-10 h-10 rounded-full" src="/img/150x150.png" alt />
          </a>
          <div>
            <p class="text-sm">Abdelhak</p>
            <select id class="p-0 w-16 h-5 rounded-none text-xs">
              <option value>public</option>
              <option value>friends</option>
              <option value>private</option>
            </select>
          </div>
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
          class="w-11/12 mx-7 my-4 py-2 text-center text-white bg-gray-700 hover:bg-logo-black transition-all ease-in-out rounded-md"
          type="button"
          v-on:click="submit()"
        >Post</button>
      </form>
    </div>
    <Post class="sm:block" v-for="post in posts" :key="post.id" :post="post" />
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
      form: {
        visibility: "public",
        body: "",
        title: "",
        attachements: []
      },
      posts: [],
      loading: false,
      profile: null,
      sortBy: "best" // possible value: [best,hot,top,new,active]
    };
    var arr = window.location.pathname.split("/");
    if (arr[1] === "u") data.profile = arr[2];
    console.log("data");
    return data;
  },
  // watch: {
  //   sortBy: {
  //     handler: function(val, oldVal) {
  //       if (val !== oldVal) {
  //         this.posts = [];
  //         this.fetchData();
  //       }
  //     }
  //   }
  // },
  created() {
    window.fetchData = this.fetchData;
    this.fetchData();
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
    fetchData() {
      if (!this.loading) {
        this.loading = true;
        axios
          .post("/wapi/feed", {
            username: this.profile,
            skip: this.posts.length,
            sortBy: this.sortBy
          })
          .then(res => {
            console.log(res.data.data);
            this.posts.push(...res.data.data);
            console.log(this.posts);
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
          console.log(res.data.data);
          this.posts.unshift(res.data.data);
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
