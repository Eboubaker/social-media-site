<template>
  <div class="m-2 p-2 rounded shadow-lg">
    <div class="flex flex-row justify-between items-center">
      <div class="flex justify-start items-center pt-2 px-4">
        <a href>
          <img class="w-14 h-14 mr-4 rounded-full" src="img/logo.png" alt="tree" />
        </a>
        <div class>
          <a class="text-xl hover:underline" href>
            <h4>Abdelhak</h4>
          </a>
          <a class="hover:underline" href>
            <small>24 m</small>
          </a>
        </div>
      </div>
      <div class>
        <svg
          class="px-3 py-3 mr-8 text-red-500 rounded-full hover:bg-gray-200 cursor-pointer"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"
          />
        </svg>
      </div>
    </div>
    <div class="px-4 py-2">
      
      <p>Accusantium blanditiis quas animi voluptate itaque aspernatur dignissimos, eaque mollitia ullam sit ad corporis, similique minus voluptas earum ipsam facere libero hic fugit rerum, aut fugiat aliquid. Id, unde laudantium. Blanditiis recusandae magnam debitis ad facere. Labore eaque minus, natus sed molestiae dolor tenetur rem at numquam commodi illum tempora hic? Numquam deserunt natus vitae fugiat. Sapiente assumenda rerum odio! Totam, ut. Similique, deserunt? Dolore eligendi voluptatem quae laboriosam accusantium tenetur error quam. A deserunt dolore soluta numquam perferendis enim ducimus quasi laborum, dolorum autem quos rem similique molestiae porro! Maxime sit obcaecati voluptatibus nulla eos et aspernatur rerum accusantium ipsa itaque vel sequi quasi nihil, similique officia quia aliquid dicta odio magnam? Repudiandae recusandae ab unde itaque illum id!</p>
    </div>
    <div class="flex flex-row justify-evenly border-t">
      <button class="flex items-center justify-center hover:bg-gray-100 rounded h-10 w-1/2 m-1">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="36"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
          />
        </svg>
        <p class="ml-1 text-2xl">Like</p>
      </button>
      <button class="flex justify-center items-center hover:bg-gray-100 rounded h-10 w-1/2 m-1">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          height="28"
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
        <p class="ml-1 text-2xl">Comment</p>
      </button>
    </div>
  </div>
</template>
<script>
export default {};
</script>
