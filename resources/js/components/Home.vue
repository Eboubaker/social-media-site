<template>
  <div class="lg:bg-gray-100 h-screen">
    <div
      class="grid grid-cols-1 md:grid md:grid-cols-2 md:text-xl md:gap-8 md:pt-36 md:pb-36 md:ml-12 md:mr-12 lg:grid lg:grid-cols-2 lg:text-xl lg:gap-44 lg:pt-36 lg:pb-36 lg:ml-48 lg:mr-40"
    >
      <div class="grid w-100 lg:h-72">
        <img
          class="w-48 h-24 justify-self-center md:w-56 md:h-32 md:justify-self-start lg:w-2/3 lg:h-56 lg:justify-self-start"
          src="/img/logo.png"
          alt
        />
        <h3
          class="opacity-0 md:-mt-20 md:opacity-100 lg:opacity-100 lg:mt-1 lg:text-3xl"
        >Connect with friends and expand your buisness</h3>
      </div>
      <div
        class="grid grid-cols-1 ml-10 mr-10 pr-1 pl-1 text-center md:bg-white md:p-5 md:border-2 md:rounded-lg md:shadow-2xl md:text-center md:w-80 lg:bg-white lg:p-5 lg:border-2 lg:rounded-lg lg:shadow-2xl lg:w-96 lg:h-96"
      >
        <form class="grid grid-cols-1 gap-4" action method>
          <input
            class="p-2 font-medium border-2 outline-none rounded-lg"
            type="text"
            name="email_phone"
            placeholder="Email or Phone Number"
          />
          <input
            class="p-2 font-medium border-2 outline-none rounded-lg"
            type="password"
            name="password"
            placeholder="Password"
          />
          <button
            class="p-2 font-medium border-2 outline-none focus:outline-none border-transparent rounded-lg text-white bg-logo-red hover:bg-red-500"
            type="submit"
          >Log In</button>
          <a class="text-sm text-red-500 hover:underline" href="#">forgot Password?</a>
        </form>
        <hr class="mt-4 mb-1" />
        <small class="mb-4">or</small>

        <router-link
          class="justify-self-center items-center w-48 px-1 py-2 font-medium border-transparent lg:w-64 rounded-lg text-white cursor-pointer outline-none bg-logo-black hover:bg-gray-900"
          :to="{ name: 'account'}"
        >Create New Account</router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>
