@extends('layouts.app')

@section('content')
    <div class="w-full h-full min-h-screen bg-gray-50">
        <div class="w-full lg:w-11/12 p-4 h-full mx-auto">
            <div id='upload-init' class="w-full max-w-4xl p-4 mt-10 h-96 rounded-xl mx-auto shadow-lg border bg-white border-yellow-200">
                <clipper-fixed class="w-40 h-40" :src="image64" preview="preview">
                    <div slot="placeholder" @click="selectImage" class="p-1 transition-all  cursor-pointer text-center rounded-md border hover:text-white font-semibold border-blue-100 hover:bg-black hover:bg-opacity-70 group">
                        <input ref="inputimage" style="display: none" id="inputimage" type="file" @change="imageChanged">
                        <span class="group-hover:hidden block">No image selected</span><span class="group-hover:block hidden">Select image</span>
                    </div>
                </clipper-fixed>
                <clipper-preview class="w-40 h-40" name="preview"></clipper-preview>
                <clipper-range class="w-32" v-model="zoom"></clipper-range>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script defer>
        window.onload = function(){
            window.uploader = new Vue({
                el: "#upload-init",
                data(){
                    return{
                        zoom: 1,
                        image64: '',
                    }
                }, 
                methods:{
                    selectImage: function(){
                        this.$refs.inputimage.click();
                    },
                    imageChanged: function(){
                        this.getBase64(this.$refs.inputimage.files[0])
                        .then(base64 => this.image64 = base64)
                    },
                    getBase64: function(file) {
                        return new Promise((resolve, reject) => {
                            const reader = new FileReader();
                            reader.readAsDataURL(file);
                            reader.onload = () => resolve(reader.result);
                            reader.onerror = error => reject(error);
                        });
                    }
                }
            });
        }
    </script>
@endpush