<template>
  <div>
    <div class="flex justify-start items-center space-x-2 py-1 px-2 h-12 border-b bg-white">
      <a href="#">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-4 w-4"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M11 17l-5-5m0 0l5-5m-5 5h12"
          />
        </svg>
      </a>
      <h1 class="text-xl">Create Post</h1>
    </div>
    <!--Body-->
    <form class action="#">
      <div class="flex items-center space-x-2 my-4 px-2">
        <a href="#">
          <img class="w-10 h-10 rounded-full" src="/img/150x150.png" alt />
        </a>
        <div>
          <p class="text-md">Abdelhak</p>
          <select name id class="p-0 w-16 h-5 rounded-none text-xs">
            <option value>public</option>
            <option value>friends</option>
            <option value>private</option>
          </select>
        </div>
      </div>
      <textarea
        class="w-full h-52 text-lg rounded-none focus:ring-transparent focus:border-transparent shadow-md"
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
        class="modal-close w-full py-2 text-center text-white bg-gray-700 hover:bg-logo-black transition-all ease-in-out"
        type="button"
      >Post</button>
    </form>
  </div>
</template>
<script>
export default {};
</script>