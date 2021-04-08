  <div class="my-0 md:my-4 px-2 rounded-lg shadow-lg bg-white">
    <div class="flex flex-row justify-between items-center">
      <div class="flex justify-start items-center pt-2 px-4 space-x-2">
        <a class="" href>
          <img class="w-14 rounded-full" src="{{$profileImage ?? '/img/150x150.png'}}" alt="tree" />
        </a>
        <div class="flex flex-col -space-y-1">
          <a class="text-lg hover:underline" href>
            <h4>abdelahk</h4>
          </a>
          <a class="hover:underline" href>
            <small>24 m</small>
          </a>
        </div>
      </div>
      <div class="relative items-center" x-data="{isOpen:false}">
        <button @click="isOpen = !isOpen" class="relative z-10 rounded-full bg-gray-50 hover:bg-red-50 hover:text-logo-red h-10 p-2 m-2 outline-none focus:outline-none cursor-pointer" :class="isOpen ? 'bg-red-100 text-logo-red hover:text-logo-red ' : 'bg-transparent'" @click="isOpen = !isOpen">
          <svg class="w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
          </svg>
        </button>
        <div x-show="isOpen" @click.away="isOpen = false" class=" absolute right-0 w-72 bg-white ring-2 ring-gray-100 shadow-lg rounded-lg p-2">
          <div class="flex flex-col space-y-2">
            <a class="flex flex-row justify-start items-center space-x-1 hover:bg-gray-100 rounded-lg py-2" href="#">
              <span class="material-icons">bookmark</span>
              <p class>save post</p>
            </a>
            <a class="flex flex-row justify-start items-center space-x-1 hover:bg-gray-100 rounded-lg py-2" href="#">
              <span class="material-icons">notifications</span>
              <p class>Turn on notifications</p>
            </a>
            <hr />
          </div>
          <div class="flex flex-col space-y-2 mt-2">
            <a class="flex flex-row justify-start items-center space-x-1 hover:bg-gray-100 rounded-lg py-2" href="#">
              <span class="material-icons">cancel</span>
              <p>Hide post</p>
            </a>
            <a class="flex flex-row justify-start items-center space-x-1 hover:bg-gray-100 rounded-lg py-2" href="#">
              <span class="material-icons">remove_circle</span>
              <p>Unfollow this person</p>
            </a>
            <a class="flex flex-row justify-start items-center space-x-1 hover:bg-gray-100 rounded-lg py-2" href="#">
              <span class="material-icons">report</span>
              <p>Find support or report post</p>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="px-4 py-2">
      <p>Accusantium blanditiis quas animi voluptate itaque aspernatur dignissimos, eaque mollitia ullam sit ad corporis, similique minus voluptas earum ipsam facere libero hic fugit rerum, aut fugiat aliquid. Id, unde laudantium. Blanditiis recusandae magnam debitis ad facere. Labore eaque minus, natus sed molestiae dolor tenetur rem at numquam commodi illum tempora hic? Numquam deserunt natus vitae fugiat. Sapiente assumenda rerum odio! Totam, ut. Similique, deserunt? Dolore eligendi voluptatem quae laboriosam accusantium tenetur error quam. A deserunt dolore soluta numquam perferendis enim ducimus quasi laborum, dolorum autem quos rem similique molestiae porro! Maxime sit obcaecati voluptatibus nulla eos et aspernatur rerum accusantium ipsa itaque vel sequi quasi nihil, similique officia quia aliquid dicta odio magnam? Repudiandae recusandae ab unde itaque illum id!</p>
    </div>
    <div class="flex justify-between px-2 text-sm">
      <div>
        <a class="hover:underline" href="#">700 Likes</a>
      </div>
      <div class="flex space-x-2">
        <div>
          <a class="hover:underline" href="#">70 Comments</a>
        </div>
        <div>
          <a class="hover:underline" href="#">40 Shares</a>
        </div>
      </div>
    </div>
    <div class="flex flex-row justify-evenly border-t">
      <button class="flex items-center justify-center hover:bg-gray-100 rounded h-10 w-1/3 m-1">
        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
          <path fill="currentColor" d="M12.1,18.55L12,18.65L11.89,18.55C7.14,14.24 4,11.39 4,8.5C4,6.5 5.5,5 7.5,5C9.04,5 10.54,6 11.07,7.36H12.93C13.46,6 14.96,5 16.5,5C18.5,5 20,6.5 20,8.5C20,11.39 16.86,14.24 12.1,18.55M16.5,3C14.76,3 13.09,3.81 12,5.08C10.91,3.81 9.24,3 7.5,3C4.42,3 2,5.41 2,8.5C2,12.27 5.4,15.36 10.55,20.03L12,21.35L13.45,20.03C18.6,15.36 22,12.27 22,8.5C22,5.41 19.58,3 16.5,3Z" />
        </svg>
        <p class="ml-1 text-lg">Like</p>
      </button>
      <button class="flex justify-center items-center hover:bg-gray-100 rounded h-10 w-1/3 m-1">
        <svg xmlns="http://www.w3.org/2000/svg" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
        </svg>
        <p class="ml-1 text-lg">Comment</p>
      </button>
      <button class="flex justify-center items-center hover:bg-gray-100 rounded h-10 w-1/3 m-1">
        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
          <path fill="currentColor" d="M21,12L14,5V9C7,10 4,15 3,20C5.5,16.5 9,14.9 14,14.9V19L21,12Z" />
        </svg>
        <p class="ml-1 text-lg">Share</p>
      </button>
    </div>
    <div class="space-y-2 border-t-2 pt-4 pb-2">
      <div class="flex justify-between items-center space-x-2">
        <img class="rounded-full w-10" src="/img/150x150.png" />
        <form class="flex-auto" action="#" method="#">
          <input class="bg-gray-100 w-full rounded-r-full rounded-l-full py-2 px-2 border-none focus:border-logo-black focus:ring-1 focus:ring-logo-black outline-none focus:outline-none" type="text" name="comment" id="comment" placeholder="Add a comment..." />
        </form>
      </div>
      <div class="grid md:grid-cols-12">
        <a class="w-10 h-10 mr-2 md:mr-0" href="#"><img class="rounded-full" src="/img/150x150.png" /></a>
        <div class="col-start-2 col-span-10 bg-gray-100 rounded-2xl px-3 py-1">
          <a class="hover:underline font-semibold text-sm" href="#">Abdelhak</a>
          <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Cumque, temporibus.</p>
        </div>
        <div class="col-start-2 col-span-3 space-x-1 ml-4">
          <a class="font-semibold text-sm hover:underline" href="#">Like</a>
          <a class="font-semibold text-sm hover:underline" href="#">Replay</a>
          <a class="text-sm hover:underline" href="#">1h</a>
        </div>
      </div>
    </div>
  </div>