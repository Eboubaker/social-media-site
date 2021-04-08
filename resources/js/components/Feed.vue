<template>
  <div>
    <div v-for="post in posts" :key="post.id">
      <Post :post="post" />
    </div>
  </div>
</template>
<script>
import Post from "./Post";
export default {
  components: {
    Post,
  },
  data() {
    return {
      posts: [],
      loading: false,
    };
  },
  created() {
    console.log("feed created");
    this.fetchData();
    document.body.onscroll = function() {
      const perc =
        this.scrollY / (document.body.offsetHeight - window.innerHeight);
      if (!this.loading && perc > 0.7) {
        this.loading = true;
        this.fetchData();
      }
    };
  },
  methods: {
    fetchData() {
      axios
        .post("/api/feed", { parameters: {} })
        .then((res) => {
          this.posts.push(res.data);
        })
        .catch((err) => {
          console.log(err);
        })
        .then(() => (this.loading = false));
    },
  },
};
</script>
