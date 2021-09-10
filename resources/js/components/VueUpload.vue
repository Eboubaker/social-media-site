<template>
  <div>
        <a  href="#" class="p-4 bg-gray-200 text-black" @click="toggleShow">set avatar</a>
        <VueUpload field="img"
            @crop-success="cropSuccess"
            @crop-upload-success="cropUploadSuccess"
            @crop-upload-fail="cropUploadFail"
            :value.sync="show"
            :width="200"
            :height="200"
            :url="uploadTarget"
            :params="params"
            :langType="'en'"
            :noRotate="false"
            :noSquare="true"
            :headers="headers"
            img-format="jpg"
        />
        <img :src="imgDataUrl">
  </div>
</template>
<script>
import VueUpload from 'vue-image-crop-upload';
import clickaway from 'vue-clickaway';
export default {
    mixins: [clickaway],
    props:{
        uploadTarget:{
            type: String,
            required: true
        },
    },
    data(){
        return {
            show: false,
            params: {
                token: '123456798',
                name: 'avatar'
            },
            headers: {
                smail: '*_~'
            },
            imgDataUrl: '' // the datebase64 url of created image
        }
    },
    components: {
        VueUpload
    },
    methods: {
        toggleShow() {
            this.show = !this.show;
            console.log("away");
        },
        /**
         * crop success
         *
         * [param] imgDataUrl
         * [param] field
         */
        cropSuccess(imgDataUrl, field){
            console.log('-------- crop success --------');
            this.imgDataUrl = imgDataUrl;
        },
        /**
         * upload success
         *
         * [param] jsonData  server api return data, already json encode
         * [param] field
         */
        cropUploadSuccess(jsonData, field){
            console.log('-------- upload success --------');
            console.log(jsonData);
            console.log('field: ' + field);
        },
        /**
         * upload fail
         *
         * [param] status    server api return error status, like 500
         * [param] field
         */
        cropUploadFail(status, field){
            console.log('-------- upload fail --------');
            console.log(status);
            console.log('field: ' + field);
        }
    }
};
</script>
