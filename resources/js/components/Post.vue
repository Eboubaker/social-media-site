<template>
  <div class="w-11/12 mx-auto md:w-3/4">
    <div class="my-0 rounded-lg shadow-lg bg-white">
      <div class="flex flex-row justify-between items-center">
        <div v-if="post.pageable_type === 'Profile'" class="flex justify-start items-center pt-2 px-4 space-x-2 group">
          <a v-bind:href="post.author.url">
            <img class="w-14 h-14 rounded-full border-3 border-transparent group-hover:border-purple-600" v-bind:src="post.author.profileImage.url" alt="tree" />
          </a>
          <div class="flex flex-col -space-y-1">
            <a class="text-lg hover:underline" v-bind:href="post.author.url">
              <h4>{{ post.author.firstName + " " + post.author.lastName }}</h4>
            </a>
            <span>
              <small>{{ post.createdAt }}</small>
            </span>
          </div>
        </div>
        <div v-else-if="post.pageable_type === 'Community'" class="flex justify-start items-center pt-2 px-4 space-x-2">
          <a v-bind:href="post.pageable.url" class="inline-block group">
            <img class="w-6 h-6 rounded-full inline-block" v-bind:src="post.pageable.iconImage.url" alt="tree" />
            <p class="inline-block text-sm font-bold text-gray-800 group-hover:underline">c/{{ post.pageable.name }}</p>
          </a>
          <div class="inline-block h-2"><div class="w-1 h-1 p-0 m-0 bg-gray-500 rounded-full" style="margin-top: .15rem;"></div></div>
          <div class="inline-block">
            <a class="text-sm hover:underline inline-block" v-bind:href="post.author.url">posted by u/{{ post.author.username }}</a>
            <span class="text-sm tracking-tighter text-gray-600">
              <small>{{ post.createdAt }}</small>
            </span>
          </div>
        </div>
        <div class="relative items-center">
          <button
            class="relative z-30 rounded-full bg-gray-50 hover:bg-red-50 hover:text-logo-red h-10 p-2 m-2 outline-none focus:outline-none cursor-pointer"
            :class="isOpen ? 'bg-red-100 text-logo-red hover:text-logo-red ' : 'bg-transparent'"
            @click="isOpen = !isOpen"
          >
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
                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"
              />
            </svg>
          </button>
          <!-- <div
            v-if="isOpen"
            @click="isOpen = false"
            tabindex="-1"
            class="fixed z-20 top-0 right-0 left-0 bottom-0 w-full h-full bg-black opacity-10 cursor-default"
          ></div>-->
          <div
            v-if="isOpen"
            v-on-clickaway="hide"
            class="absolute z-30 right-0 w-72 bg-white ring-2 ring-gray-100 shadow-lg rounded-lg p-2"
          >
            <div class="flex flex-col space-y-2">
              <a
                class="flex flex-row justify-start items-center space-x-1 hover:bg-gray-100 rounded-lg py-2"
                href="#"
              >
                <span class="material-icons">bookmark</span>
                <p class>save post</p>
              </a>
              <a
                class="flex flex-row justify-start items-center space-x-1 hover:bg-gray-100 rounded-lg py-2"
                href="#"
              >
                <span class="material-icons">notifications</span>
                <p class>Turn on notifications</p>
              </a>
              <hr />
            </div>
            <div class="flex flex-col space-y-2 mt-2">
              <a
                class="flex flex-row justify-start items-center space-x-1 hover:bg-gray-100 rounded-lg py-2"
                href="#"
              >
                <span class="material-icons">cancel</span>
                <p>Hide post</p>
              </a>
              <a
                class="flex flex-row justify-start items-center space-x-1 hover:bg-gray-100 rounded-lg py-2"
                href="#"
              >
                <span class="material-icons">remove_circle</span>
                <p>Unfollow this person</p>
              </a>
              <a
                class="flex flex-row justify-start items-center space-x-1 hover:bg-gray-100 rounded-lg py-2"
                href="#"
              >
                <span class="material-icons">report</span>
                <p>Find support or report post</p>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="px-4 py-2">
        <h2 class="text-xl font-semibold">{{ post.title }}</h2>
        <p class="mt-2 tracking-tight">{{ post.body }}</p>
        
        <div class="w-full h-full mt-4 rounded-lg p-2" v-for="image in post.images" :image="image" :key='image.id' >
            <img style="max-height: 100vh; min-width: 450px" class="rounded-md mx-auto shadow-xl object-cover object-top" v-bind:src="image.url" v-bind:alt="image.name" />
        </div>
      </div>
      <div class="flex justify-start px-4 mt-2 text-sm">
        <div class="flex space-x-2">
          <div v-if="post.likes_count > 0">
            <a class="hover:underline cursor-pointer" v-on:click="this.showComments">{{ this.likesShort() + ' ' + this.pluralize('like', post.likes_count) }} </a>
          </div>
          <div v-if="post.comments_count > 0">
            <a class="hover:underline cursor-pointer" title="show comments" v-on:click="this.showComments">{{ this.pluralize('comment', post.comments_count, true) }}</a>
          </div>
          <div v-if="post.shares_count > 0">
            <a class="hover:underline cursor-pointer">{{ this.pluralize('share', post.shares_count, true) }}</a>
          </div>
        </div>
      </div>
      <div class="flex flex-row justify-evenly border-t">
        <div class="flex place-items-center">
          <button v-on:click="like"
            class="flex justify-center  focus:outline-none items-center hover:bg-red-50 hover:text-logo-red transition-all ease-in-out rounded-full h-10 w-10 m-1"
          >
            <svg v-if="this.post.is_liked" style="width:24px;height:24px" fill="red" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
            <svg v-else fill="currentColor"
             style="width:24px;height:24px" viewBox="0 0 24 24">
              <path
                d="M12.1,18.55L12,18.65L11.89,18.55C7.14,14.24 4,11.39 4,8.5C4,6.5 5.5,5 7.5,5C9.04,5 10.54,6 11.07,7.36H12.93C13.46,6 14.96,5 16.5,5C18.5,5 20,6.5 20,8.5C20,11.39 16.86,14.24 12.1,18.55M16.5,3C14.76,3 13.09,3.81 12,5.08C10.91,3.81 9.24,3 7.5,3C4.42,3 2,5.41 2,8.5C2,12.27 5.4,15.36 10.55,20.03L12,21.35L13.45,20.03C18.6,15.36 22,12.27 22,8.5C22,5.41 19.58,3 16.5,3Z"
              />
            </svg>
          </button>
        </div>
        <div class="flex place-items-center">
          <button
            class="flex justify-center items-center focus:outline-none hover:bg-red-50 hover:text-logo-red transition-all ease-in-out rounded-full h-10 w-10 m-1"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              height="24"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"
              />
            </svg>
          </button>
        </div>
        <div class="flex place-items-center">
          <button
            class="flex justify-center items-center hover:bg-red-50 hover:text-logo-red transition-all ease-in-out rounded-full h-10 w-10 m-1"
          >
            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
              <path
                fill="currentColor"
                d="M21,12L14,5V9C7,10 4,15 3,20C5.5,16.5 9,14.9 14,14.9V19L21,12Z"
              />
            </svg>
          </button>
        </div>
      </div>
      
      <div class="space-y-2 border-t-2 p-4 px-3">
        <div class="flex text-gray-600 text-sm font-bold tracking-tight">
          <a v-on:click="!loadingComments ? loadMoreComments() : null" v-if="this.post.comments_count > this.post.comments.length" v-bind:class="this.loadingComments ? 'cursor-wait' : 'cursor-pointer'" class="hover:underline mt-1 mr-auto">View {{ ((this.post.comments_count - this.post.comments.length) < 5) ? this.post.comments_count - this.post.comments.length : '' }} More {{ this.pluralize('comment', this.post.comments_count - this.post.comments.length) }}...<svg v-if="this.loadingComments" class="inline-block mx-2 mt-1 text-gray-600 w-5 h-5 stroke-current" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient x1="8.042%" y1="0%" x2="65.682%" y2="23.865%" id="a"><stop stop-color="#000" stop-opacity="0" offset="0%"/><stop stop-color="#111" stop-opacity=".631" offset="63.146%"/><stop stop-color="#222" offset="100%"/></linearGradient></defs><g fill="none" fill-rule="evenodd"><g transform="translate(1 1)"><path d="M36 18c0-9.94-8.06-18-18-18" id="Oval-2" stroke="url(#a)" stroke-width="2"> <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="0.9s" repeatCount="indefinite" /></path><circle fill="#000" cx="36" cy="18" r="1"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="0.9s" repeatCount="indefinite" /></circle></g></g></svg></a>
          <a v-if="this.post.comments_count > 10" class="hover:underline mt-1 ml-auto mr-1">Sort by newest</a>
        </div>
        <Comment v-for="comment in post.comments" :comment="comment" :post="post" :level="1" :key="comment.id" />
        <div class="flex justify-between items-center space-x-2">
          <img class="w-10 h-10 rounded-full" v-bind:src="$currentProfile.profileImage.url" />
          <div class="flex-auto">
            <input v-on:keyup.enter="comment" v-model="commentBody"
              class="bg-gray-100 w-full rounded-r-full rounded-l-full py-2 pl-5 px-2 border-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none focus:outline-none"
              type="text"
              auto-compleat="off"
              v-bind:placeholder="post.comments_count > 0 ? 'add comment' : 'be the first to comment'"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mixin as clickaway } from "vue-clickaway";
import Comment from './Comment';
export default {
  components: {
    Comment
  },
  mixins: [clickaway],
  // components: { PlayGround },
  props: {
    post: {
      type: Object
    }
  },
  data() {
    return {
      isOpen: false,
      commentBody: '',
      loadingComments: false,
    };
  },
  computed: {
    // a computed getter
    
  },
  methods: {
    likesShort: function () {
      let num = this.post.likes_count;
      const lookup = [
        { value: 1, symbol: "" },
        { value: 1e3, symbol: "k" },
        { value: 1e6, symbol: "M" },
        { value: 1e9, symbol: "G" },
        { value: 1e12, symbol: "T" },
        { value: 1e15, symbol: "P" },
        { value: 1e18, symbol: "E" }
      ];
      const rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
      var item = lookup.slice().reverse().find(function(item) {
        return num >= item.value;
      });
      return item ? (num / item.value).toFixed(1).replace(rx, "$1") + item.symbol : "0";
    },
    hide: function() {
      this.isOpen = false;
    },
    showComments: function(){

    },
    loadMoreComments: function(){
      this.loadingComments = true;
      axios.post('/p/'+this.post.id+'/comments',{
        skip: this.post.comments.length
      })
      .then(res => {
        console.log(res);
        this.post.comments.push(...res.data.data)
      })
      .catch(e => console.error(e))
      .then(e => {
        this.loadingComments = false
      })
    },
    comment: function(){
      axios.post('/p/'+this.post.id+'/comment',{
        body: this.commentBody
      })
      .then(res => {
        this.commentBody = '';
        this.post.comments.push(res.data)
        this.post.comments_count++;
      })
      .catch(e => console.error(e));
    },
    like: function(){
      if(this.post.is_liked){
        axios.post('/p/'+this.post.id+'/unlike')
        .then(res => {
          this.post.is_liked=false
          this.post.likes_count--;
        }).catch(e => {
          console.log(e);
        })
      }else{
        axios.post('/p/'+this.post.id+'/like')
        .then(res => {
          this.post.is_liked=true
          this.post.likes_count++
        }).catch(e => {
          console.log(e);
        })
      }
    },
  }
};
</script>
