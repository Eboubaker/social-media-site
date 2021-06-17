<template>
  <div>
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
      posts: [],
      loading: false,
      profile:null
    };
    var arr = window.location.pathname.split('/')
    if(arr[1] === 'u')
      data.profile = arr[2]
    console.log('data');
    return data
  },
  created() {
    window.fetchData = this.fetchData;
    this.fetchData();
    document.body.onscroll = function() {
      const perc = this.scrollY / (document.body.offsetHeight - window.innerHeight);
      if (perc > 0.7) {
        console.log(perc);
        window.fetchData();
      }
    };
  },
  methods: {
    fetchData() {
      if(!this.loading)
      {
        this.loading = true;
        let url  = this.profile ? `/wapi/feed?skip=${this.posts.length}&username=${this.profile}` : `/wapi/feed?skip=${this.posts.length}`;
        axios
          .post(url, { parameters: {} })
          .then(res => {
            console.log(res);
            this.posts.push(...res.data.data);
          })
          .catch(err => {
            console.log(err);
          })
          .then(() => this.loading = false);
      }
      
    }
  }
};
</script>
