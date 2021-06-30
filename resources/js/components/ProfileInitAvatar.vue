<template>
  <div>
        <clipper-fixed init-width="200" init-height="200" class="w-40 h-40" src="/storage/images/8.jpeg" preview="preview"></clipper-fixed>
        <clipper-preview class="w-40 h-40" name="preview"></clipper-preview>
        <clipper-range v-model="zoom"></clipper-range>
  </div>
</template>
<script>
import clickaway from 'vue-clickaway';
export default {
    mixins: [clickaway],
    props:{
        uploadTarget:{
            type: String,
            required: true
        },
        imageUrl:{
            type: String,
            required: true
        },
    },
    data(){
        return {
            zoom: 1,
        }
    },
    methods: {
        
    }
};
</script>
