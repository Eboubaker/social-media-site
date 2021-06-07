<template>
  <div>
    <button
      title="Add new Post"
      class="modal-open w-10 h-10 px-2 bg-white border shadow-2xl rounded-full flex justify-center items-center my-1 outline-none focus:outline-none focus:ring-logo-red focus:border-logo-red focus:text-logo-red hover:text-logo-red hover:border-logo-red"
    >
      <svg
        class="w-7 h-7"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
        />
      </svg>
    </button>

    <!--Modal-->
    <div
      class="modal z-20 opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center"
    >
      <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

      <div class="modal-container bg-white w-1/2 mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <!-- Add margin if you want to see some of the overlay behind the modal-->
        <div class="modal-content px-2 divide-y">
          <!--Title-->
          <div class="flex items-center py-2">
            <span class="w-full text-center text-xl font-semibold">Create Post</span>
            <button
              class="modal-close z-50 flex items-center rounded-md hover:bg-red-50 hover:text-logo-red p-2"
            >
              <span class="material-icons">close</span>
            </button>
          </div>

          <!--Body-->
          <form class action="#">
            <div class="flex items-center space-x-2 my-4">
              <a href="#">
                <img class="w-10 h-10 rounded-full" src="/img/150x150.png" alt />
              </a>
              <div>
                <p class="text-sm">Abdelhak</p>
                <select name id class="p-0 w-16 h-5 rounded-none text-xs">
                  <option value>public</option>
                  <option value>friends</option>
                  <option value>private</option>
                </select>
              </div>
            </div>
            <textarea
              v-model="form.body"
              class="w-full h-52 rounded text-lg focus:ring-logo-red focus:border-logo-red"
              name="content"
              id="content"
              placeholder="Write your post"
            ></textarea>
            <div class="flex items-center justify-center space-x-4">
              <input type="file" name="image" id="image" hidden />
              <label
                title="upload image"
                class="flex items-center justify-center rounded-md p-2 w-12 cursor-pointer hover:bg-red-50 hover:text-logo-red transition-all ease-in-out"
                for="image"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                  />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                </svg>
              </label>
              <input type="file" name="video" id="video" hidden />
              <label
                title="upload video"
                class="flex items-center justify-center rounded-md p-2 w-12 cursor-pointer hover:bg-red-50 hover:text-logo-red transition-all ease-in-out"
                for="video"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"
                  />
                </svg>
              </label>
              <input type="file" name="audio" id="audio" hidden />
              <label
                title="upload audio"
                class="flex items-center justify-center rounded-md p-2 w-12 cursor-pointer hover:bg-red-50 hover:text-logo-red transition-all ease-in-out"
                for="audio"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"
                  />
                </svg>
              </label>
            </div>
            <button
              class="modal-close w-11/12 mx-7 my-4 py-2 text-center text-white bg-gray-700 hover:bg-logo-black transition-all ease-in-out rounded-md"
              type="button"
              v-on:click="submit()"
            >Post</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data(){
      return{
        form:{
          visibility:"public",
          body:"",
          attachements:[],

        }
      };
    },
    methods:{
      submit: function(){
        axios
        .post('/api/posts', this.form)
        .then((res)=>{
          
        })
        .catch((e)=>{

        }).then((e)=>{
          this.close();
        });
      },
      close () {
        // destroy the vue listeners, etc
        this.$destroy();
      }
    }
  };
</script>

