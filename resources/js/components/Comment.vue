<template>
    <div class="flex" v-if="renderComponent">
        <a class="w-10 h-10 mr-1 flex-shrink-0" v-bind:href="'/u/'+comment.commentor.username">
            <img class="w-10 h-10 rounded-full" v-bind:src="comment.commentor.avatarImage.url" />
        </a>
        <div class="flex-grow">
            <div class="bg-gray-100 rounded-2xl px-3 py-1 ml-1">
                <a class="hover:underline font-semibold text-sm inline-block" v-bind:href="'/u/'+comment.commentor.username">{{ comment.commentor.username }}</a>
                <span class="text-sm inline-block">{{ comment.createdAt }}</span>
                <p class="block">
                {{ comment.body }}
                </p>
            </div> 
            <div class="space-x-1 ml-2">
                <svg v-on:click="this.unlike" v-if="this.comment.is_liked" class="inline-block w-5 h-5 cursor-pointer fill-current transition-all text-red-600 hover:text-red-500" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                <svg v-on:click="this.like" v-else class="inline-block w-5 h-5 cursor-pointer fill-current text-gray-500 transition-all duration-200 hover:text-red-500" viewBox="0 0 24 24"><path d="M12.1,18.55L12,18.65L11.89,18.55C7.14,14.24 4,11.39 4,8.5C4,6.5 5.5,5 7.5,5C9.04,5 10.54,6 11.07,7.36H12.93C13.46,6 14.96,5 16.5,5C18.5,5 20,6.5 20,8.5C20,11.39 16.86,14.24 12.1,18.55M16.5,3C14.76,3 13.09,3.81 12,5.08C10.91,3.81 9.24,3 7.5,3C4.42,3 2,5.41 2,8.5C2,12.27 5.4,15.36 10.55,20.03L12,21.35L13.45,20.03C18.6,15.36 22,12.27 22,8.5C22,5.41 19.58,3 16.5,3Z"/></svg>
                <a class="font-semibold text-sm hover:underline cursor-pointer" v-on:click="this.showReplies">Reply</a>
                <div v-if="this.comment.likes_count > 0" class="inline-block h-2"><div class="w-1 h-1 p-0 m-0 bg-gray-500 rounded-full" style="margin-top: .15rem;"></div></div>
                <p v-if="this.comment.likes_count > 0" class="ml-2 inline-block text-sm font-light tracking-tight">{{ this.pluralize('like', this.comment.likes_count, true) }}</p>
                <div v-if="this.comment.replies_count > 0" class="inline-block h-2"><div class="w-1 h-1 p-0 m-0 bg-gray-500 rounded-full" style="margin-top: .15rem;"></div></div>
                <p v-if="this.comment.replies_count > 0" class="ml-2 inline-block text-sm font-light tracking-tight">{{ this.pluralize('replies', this.comment.replies_count, true) }}</p>
                <div class="my-1"></div>
                <Comment v-for="reply in comment.replies" :post="post" :comment="reply" :level="level+1" :key="'p/'+post.id+'/r/'+reply.id"/>
                <a v-on:click="!loadingReplies ? loadMoreReplies() : null" v-if="comment.replies_count > comment.replies.length" v-bind:class="this.loadingReplies ? 'cursor-wait' : 'cursor-pointer'" class="hover:underline mt-1 mr-auto">View More Replies...<svg v-if="this.loadingReplies" class="inline-block mx-2 mt-1 text-gray-600 w-5 h-5 stroke-current" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient x1="8.042%" y1="0%" x2="65.682%" y2="23.865%" id="a"><stop stop-color="#000" stop-opacity="0" offset="0%"/><stop stop-color="#111" stop-opacity=".631" offset="63.146%"/><stop stop-color="#222" offset="100%"/></linearGradient></defs><g fill="none" fill-rule="evenodd"><g transform="translate(1 1)"><path d="M36 18c0-9.94-8.06-18-18-18" id="Oval-2" stroke="url(#a)" stroke-width="2"> <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="0.9s" repeatCount="indefinite" /></path><circle fill="#000" cx="36" cy="18" r="1"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="0.9s" repeatCount="indefinite" /></circle></g></g></svg></a>
                <div class="my-1"></div>
                <div v-if="replyOpen" class="flex justify-between items-center space-x-2 my-2" v-on-clickaway="closeReply">
                    <img class="w-7 h-7 rounded-full" v-bind:src="$currentProfile.avatarImage.url" />
                    <div class="flex-auto" >
                        <input v-on:keyup.enter="sendReply" v-model="reply"
                        class="bg-gray-100 w-full rounded-r-full rounded-l-full py-2 pl-5 px-2 border-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none focus:outline-none"
                        type="text"
                        ref="reply"
                        auto-compleat="off"
                        v-bind:placeholder="comment.replies > 0 ? 'add reply' : 'reply to u/' + comment.commentor.username"
                        />
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
    name: 'Comment',
    components:{
        Comment
    },
    props:{
        post: {
            type: Object
        },
        comment: {
            type: Object
        },
        level : {
            type: Number
        }
    },
    data(){
        return {
            renderComponent: true,
            reply: '',
            replyOpen: false,
            loadingReplies: false,
            callbacks: [],
            attachements : []
        }
    },
    created(){
        if(!this.comment.replies)
        {
            this.comment.replies = [];
        }
    },
    // updated: function () {
    //     this.$nextTick(function () {
    //         for(let callback of this.callbacks)
    //             callback(this);
    //         this.callbacks = [];
    //     })
    // },
    methods:{
        loadMoreReplies: function(){
            this.loadingReplies = true;
            axios.post('/r/'+this.comment.id+'/replies?skip='+this.comment.replies.length+'&limit=10',{
                skip: this.comment.replies.length
            })
            .then(res => {
                console.log(res);
                this.comment.replies.push(...res.data.data)
            })
            .catch(e => console.error(e))
            .then(e => {
                this.loadingReplies = false
            })
        },
        closeReply: function(){
            this.replyOpen = false;
        },
        showReplies: function(){
            this.replyOpen = !this.replyOpen
            if(this.replyOpen)
            {
                this.callbacks.push(function(instance) {
                    let el = instance.$refs.reply;
                    if (typeof jQuery === "function" && el instanceof jQuery) {
                        el = el[0];
                    }

                    var rect = el.getBoundingClientRect();
                    
                    (
                        rect.top >= 0 &&
                        rect.left >= 0 &&
                        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && /* or $(window).height() */
                        rect.right <= (window.innerWidth || document.documentElement.clientWidth) /* or $(window).width() */
                    ) && 
                    instance.$smoothScroll({
                        scrollTo: instance.$refs.reply,
                        offset: -window.innerHeight*.7,
                    })
                })
            }
        },
        sendReply: function(){
            axios.post('/r/'+this.comment.id+'/reply',{
                body: this.reply,
                attachements : this.attachements
            })
            .then(res => {
                console.log(res)
                this.reply = '';
                if(this.comment.replies === undefined)
                    this.comment.replies = []
                this.comment.replies.push(res.data);
                this.comment.replies_count++;
            })
            .catch(e => console.error(e))
        },
        like: function(){
            console.log("like");
            axios.post('/r/'+this.comment.id+'/like')
            .then(res => {
                this.comment.is_liked = true;
                this.comment.likes_count++;
                this.forceRerender();
            })
            .catch(e => console.error(e))
        },
        unlike: function(){
            console.log("unlike");
            axios.post('/r/'+this.comment.id+'/unlike')
            .then(res => {
                this.comment.is_liked = false;
                this.comment.likes_count--;
                this.forceRerender();
            })
            .catch(e => console.error(e))
        },
        loadReplies: function(){
            axios.post('/r/'+this.comment.id+'/replies?skip='+this.replies.length)
            .then(res => {
                this.replies.push(...res.data.data);
            })
            .catch(e => console.error(e))
        },
        forceRerender() {
            // Remove my-component from the DOM
            this.renderComponent = false;

            this.$nextTick(() => {
                // Add the component back in
                this.renderComponent = true;
            });
        }
    }
}
</script>