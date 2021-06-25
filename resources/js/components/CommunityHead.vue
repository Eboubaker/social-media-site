<template>
    <div class="w-full h-full" v-if="community !== null">
        <div class="z-10 w-11/12 mx-auto h-40  bg-blue-600 relative rounded-md rounded-t-none bg-cover"
            :style="'background-image: url('+community.coverImage.url+')'"
        >
            <div style="bottom: -5.2rem" class="absolute left-6">
                <div class="flex">
                    <div :style="'background-image: url('+community.iconImage.url+')'" class="w-28 h-28 bg-cover border-4 border-blue-100 rounded-full bg-green-500"></div>
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
            .then(res => this.community.currentIsMember = false)
            .catch(err => console.err(err))
        },
        join: function(){
            axios.post(`/c/${this.community.id}/join`)
            .then(res => this.community.currentIsMember = true)
            .catch(err => console.err(err))
        }
    }
}
</script>