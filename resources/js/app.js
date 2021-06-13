require("./bootstrap.js");
require("./scroll-view");
require("./create-posts");
// require('./int-tel-input');

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
//
import Vue from "vue";
// import VueResource from "vue-resource";
import "alpinejs";

// tell Vue to use the vue-resource plugin
// Vue.use(VueResource);
window.Vue = Vue;
Vue.component("feed", require("./components/Feed.vue").default);
Vue.component("nav-bar", require("./components/NavBar.vue").default);
Vue.component("post", require("./components/Post.vue").default);
Vue.component(
  "profile-type",
  require("./components/SocialBuisnessAccount.vue").default
);
Vue.component("play-ground", require("./components/PlayGround.vue").default);
Vue.component("creat-post", require("./components/CreatPost.vue").default);
Vue.component("posts-component", require("./components/Posts.vue").default);
// Vue.directive("clickaway", {
//   bind() {
//     this.event = (event) => this.vm.$emit(this.expression, event);
//     this.el.addEventListener("click", this.stopProp);
//     document.body.addEventListener("click", this.event);
//   },
//   unbind() {
//     this.el.removeEventListener("click", this.stopProp);
//     document.body.removeEventListener("click", this.event);
//   },

//   stopProp(event) {
//     event.stopPropagation();
//   },
// });

var app = new Vue({
  el: "#app",
});

var feed = new Vue({
  el: "#vue-feed",
});

axios.post("/wapi/profile/current").then((res) => {
  Vue.prototype.$currentProfile = res.data.data;
  var app = new Vue({
    el: "#g-app",
  });
  var feed = new Vue({
    el: "#vue-feed",
  });
});
