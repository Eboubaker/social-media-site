<template>
    <div class="w-full h-full" v-if="community !== null">
        <div class="z-10 w-11/12 mx-auto h-40  bg-blue-600 relative rounded-md rounded-t-none bg-cover bg-center bg-no-repeat"
            :style="'background-image: url('+community.coverImage.url+')'"
        >
            <div style="bottom: -5.2rem" class="absolute left-6">
                <div class="flex">
                    <div :style="'background-image: url('+community.avatarImage.url+')'" class="w-28 h-28 bg-cover border-4 border-blue-100 rounded-full bg-green-500 relative">
                        <!-- <div class="absolute right-0 bottom-0 -mb-2 -ml-2 group hover:bg-white">
                            <svg class="w-6 h-6 text-white group-hover:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div> -->
                    </div>
                    <div class="justify-self-center self-center px-4 mt-4">
                        <span class="text-3xl text-white font-bold mr-3">{{ community.name }}</span>
                        <button v-if="this.community.currentIsMember" @click="leave()" class="border-2 focus:outline-none w-28 text-center cursor-pointer border-white rounded-full py-1 px-6 font-bold text-white group hover:bg-gray-100 hover:bg-opacity-10"><span class="inline-block group-hover:hidden">Joined</span><span class="hidden group-hover:inline-block">Leave</span></button>
                        <button v-else @click="join()" class="border-2 focus:outline-none w-28 text-center cursor-pointer bg-gray-50 hover:bg-gray-200 rounded-full py-1 px-6 font-bold text-gray-900">join</button>
                        <div class="text-white text-sm mt-2">{{ community.members_count }} Members</div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="w-11/12 mx-auto h-24 bg-gray-900 mb-10 z-0 rounded-md" style="margin-top: -.5rem"></div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            community: null
        }
    },
    mounted: function(){
        this.community = JSON.parse(document.getElementById('communityjson').innerHTML);
    },
    methods:{
        leave: function(){
            axios.post(`/c/${this.community.id}/leave`)
            .then(res => {
                this.community.currentIsMember = false
                this.community.members_count--;
            })
            .catch(err => console.err(err))
        },
        join: function(){
            axios.post(`/c/${this.community.id}/join`)
            .then(res => {
                this.community.currentIsMember = true
                this.community.members_count++;
            })
            .catch(err => console.err(err))
        }
    }
}
</script>