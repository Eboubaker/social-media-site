  <template>
  <div class="flex flex-wrap h-screen bg-gray-100 justify-center pt-12">
    <div class="w-screen h-5/6 mx-8 md:w-1/2">
      <ul class="flex flex-col justify-center ml-2 mb-0 list-none pt-3 pb-4 sm:flex-row">
        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
          <a
            class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal cursor-pointer"
            v-on:click="toggleTabs(1)"
            v-bind:class="{'text-logo-black bg-white': openTab !== 1, 'text-white bg-logo-red': openTab === 1}"
          >
            <i class="fas fa-space-shuttle text-base mr-1"></i> Social Account
          </a>
        </li>
        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
          <a
            class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal cursor-pointer"
            v-on:click="toggleTabs(2)"
            v-bind:class="{'text-logo-black bg-white': openTab !== 2, 'text-white bg-logo-black': openTab === 2}"
          >
            <i class="fas fa-cog text-base mr-1"></i> Buisness Account
          </a>
        </li>
      </ul>
      <div
        class="relative flex flex-col min-w-0 break-words bg-white w-full h-5/6 mb-6 shadow-lg rounded sm:h-full"
      >
        <div class="px-4 py-5 flex-auto">
          <div class="tab-content tab-space">
            <div v-bind:class="{'hidden': openTab !== 1, 'block': openTab === 1}">
              <p class="pb-4 text-center">Social Account for friends and family</p>
              <form class="grid grid-cols- gap-4 mx-2" action="./confirm">
                <input
                  class="p-2 font-medium border-2 outline-none rounded-lg"
                  type="text"
                  name="first-name"
                  id="first-name"
                  placeholder="First Name"
                />
                <input
                  class="p-2 font-medium border-2 outline-none rounded-lg"
                  type="text"
                  name="last-name"
                  id="last-name"
                  placeholder="Last Name"
                />
                <input
                  class="p-2 font-medium border-2 outline-none rounded-lg"
                  type="text"
                  name="email-phone"
                  id="email-phone"
                  placeholder="Email or Phone Number"
                />
                <input
                  class="p-2 font-medium border-2 outline-none rounded-lg"
                  type="password"
                  name="password"
                  id="password"
                  placeholder="Password"
                />
                <input
                  class="p-2 font-medium border-2 outline-none rounded-lg"
                  type="date"
                  name="birth-date"
                  id="birth-date"
                />
                <input
                  class="p-2 font-medium border-2 outline-none rounded-lg text-logo-white bg-logo-red hover:bg-red-500 cursor-pointer sm:mt-8 sm:w-1/2 sm:justify-self-center"
                  type="submit"
                  value="Sign Up"
                />
              </form>
            </div>
            <div v-bind:class="{'hidden': openTab !== 2, 'block': openTab === 2}">
              <p class="pb-4 text-center">Buisness Account for colleuges and customers</p>
              <form class="grid grid-cols-1 gap-4 mx-2" action="./confirm">
                <input
                  class="p-2 font-medium border-2 outline-none rounded-lg"
                  type="text"
                  name="first-name"
                  id="first-name"
                  placeholder="First Name"
                />
                <input
                  class="p-2 font-medium border-2 outline-none rounded-lg"
                  type="text"
                  name="last-name"
                  id="last-name"
                  placeholder="Last Name"
                />
                <input
                  class="p-2 font-medium border-2 outline-none rounded-lg"
                  type="text"
                  name="email-phone"
                  id="email-phone"
                  placeholder="Buisness Email or Phone Number"
                />
                <input
                  class="p-2 font-medium border-2 outline-none rounded-lg"
                  type="password"
                  name="password"
                  id="password"
                  placeholder="Password"
                />
                <select
                  class="p-2 font-medium border-2 outline-none rounded-lg"
                  name="job-category"
                  id="job-category"
                >
                  <option value="buisness-category" selected>Buisness Category</option>
                  <option value="food">Food</option>
                  <option value="transport">Transport</option>
                </select>
                <input
                  class="p-2 font-medium border-2 outline-none rounded-lg text-logo-white bg-logo-black hover:bg-gray-900 cursor-pointer sm:mt-8 sm:w-1/2 sm:justify-self-center"
                  type="submit"
                  value="Sign Up"
                />
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "pink-tabs",
  data() {
    return {
      openTab: 1
    };
  },
  methods: {
    toggleTabs: function(tabNumber) {
      this.openTab = tabNumber;
    }
  }
};
</script>