<template>
  <div>
    <div class="flex justify-center mx-auto md:w-3/4">
      <!-- <div> -->
      <button
        title="Add new Post"
        class="modal-open w-full h-10 px-2 bg-white border shadow-2xl rounded-full flex justify-center items-center my-1 outline-none focus:outline-none focus:ring-logo-red focus:border-logo-red focus:text-logo-red hover:text-logo-red hover:border-logo-red"
      >
        <span class="text-lg font-semibold">Create New Post</span>

        <svg
          class="w-7 h-7 ml-4"
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
                  <select id class="p-0 w-16 h-5 rounded-none text-xs">
                    <option value>public</option>
                    <option value>friends</option>
                    <option value>private</option>
                  </select>
                </div>
              </div>
              <input
                v-model="form.title"
                type="text"
                class="w-full mb-2 rounded text-lg focus:ring-logo-red focus:border-logo-red"
                name="title"
                id="title"
                placeholder="Post title"
              />
              <textarea
                v-model="form.body"
                class="w-full h-52 rounded text-lg focus:ring-logo-red focus:border-logo-red"
                name="body"
                id="body"
                placeholder="Write your post"
              ></textarea>
              <div class="flex items-center justify-center space-x-4">
                <input
                  type="file"
                  multiple
                  name="attachements[]"
                  v-on:change="refreshAttachements"
                  id="image"
                  hidden
                />
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
                <input type="file" multiple name="attachements[]" id="video" hidden />
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
                <input type="file" name="attachements[]" id="audio" hidden />
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
      <!-- </div> -->
      <!-- <Creatpost /> -->
      <!-- <form class="flex" action="#">
        <div class="flex flex-none items-center space-x-2">
          <a href="#">
            <img class="w-10 h-10 rounded-full" src="/img/150x150.png" alt />
          </a>
          <div>
            <p class="text-sm">Abdelhak</p>
            <select id class="p-0 w-16 h-5 rounded-none text-xs">
              <option value>public</option>
              <option value>friends</option>
              <option value>private</option>
            </select>
          </div>
        </div>
        <input
          v-model="form.title"
          type="text"
          class="w-full mx-2 rounded focus:ring-logo-red focus:border-logo-red"
          name="title"
          id="title"
          placeholder="Post title"
        />
        <textarea
          v-model="form.body"
          class="w-full h-52 rounded text-lg focus:ring-logo-red focus:border-logo-red"
          name="body"
          id="body"
          placeholder="Write your post"
        ></textarea>
        <div class="flex items-center justify-center space-x-4">
          <input
            type="file"
            multiple
            name="attachements[]"
            v-on:change="refreshAttachements"
            id="image"
            hidden
          />
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
          <input type="file" multiple name="attachements[]" id="video" hidden />
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
          <input type="file" name="attachements[]" id="audio" hidden />
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
          class="w-11/12 mx-7 my-4 py-2 text-center text-white bg-gray-700 hover:bg-logo-black transition-all ease-in-out rounded-md"
          type="button"
          v-on:click="submit()"
          hidden
        >Post</button>
      </form>-->
    </div>

    <div class="flex flex-col mx-auto md:w-3/4">
      <div
        class="flex flex-row justify-center place-items-center space-x-1 lg:space-x-4 border bg-white p-4 rounded"
      >
        <div>
          <button
            class="rounded-full px-4 py-2 font-black flex place-items-center space-x-2 hover:text-logo-red hover:bg-red-50 hover:border-logo-red"
          >
            <div>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z"
                  clip-rule="evenodd"
                />
              </svg>
            </div>
            <div>Best</div>
            <!--v-if-->
          </button>
        </div>
        <div>
          <button
            class="rounded-full px-4 py-2 font-black flex place-items-center space-x-2 hover:text-logo-red hover:bg-red-50 hover:border-logo-red"
          >
            <div>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                  clip-rule="evenodd"
                />
              </svg>
            </div>
            <div>Hot</div>
            <!--v-if-->
          </button>
        </div>
        <div>
          <button
            class="rounded-full px-4 py-2 font-black flex place-items-center space-x-2 hover:text-logo-red hover:bg-red-50 hover:border-logo-red"
          >
            <div>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"
                />
              </svg>
            </div>
            <div>Top</div>
            <!--v-if-->
          </button>
        </div>
        <div>
          <button
            class="rounded-full px-4 py-2 font-black flex justify-center items-center space-x-2 hover:text-logo-red hover:bg-red-50 hover:border-logo-red"
          >
            <div class="flex justify-center items-center">
              <span class="material-icons w-5 h-5">plus_one</span>
            </div>
            <div>New</div>
            <!--v-if-->
          </button>
        </div>
        <div>
          <button
            class="rounded-full px-4 py-2 font-black flex justify-center items-center space-x-2 hover:text-logo-red hover:bg-red-50 hover:border-logo-red"
          >
            <div class="flex justify-center items-center">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"
                />
                <path
                  d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"
                />
              </svg>
            </div>
            <div>Active</div>
            <!--v-if-->
          </button>
        </div>
        <div>
          <button
            class="rounded-full px-4 py-2 font-black flex place-items-center space-x-2 hover:text-logo-red hover:bg-red-50 hover:border-logo-red"
          >
            <div>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                  clip-rule="evenodd"
                />
              </svg>
            </div>
            <div>Location</div>
            <!--v-if-->
          </button>
        </div>
        <!-- <div>
            <button
              class="rounded-full px-4 py-2 font-black flex place-items-center space-x-2 hover:text-logo-red hover:bg-red-50 hover:border-logo-red"
            >
              <div>United States</div>
              <div>
                <svg
                  class="svg-inline--fa fa-caret-down fa-w-10"
                  aria-hidden="true"
                  focusable="false"
                  data-prefix="fas"
                  data-icon="caret-down"
                  role="img"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 320 512"
                >
                  <path
                    class
                    fill="currentColor"
                    d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"
                  />
                </svg>
              </div>
            </button>
        </div>-->
        <!-- <div>
            <div
              class="rounded-full px-4 py-2 font-black flex place-items-center space-x-2 hover:text-logo-red hover:bg-red-50 hover:border-logo-red"
            >
              <div>All</div>
              <div>
                <svg
                  class="svg-inline--fa fa-caret-down fa-w-10"
                  aria-hidden="true"
                  focusable="false"
                  data-prefix="fas"
                  data-icon="caret-down"
                  role="img"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 320 512"
                >
                  <path
                    class
                    fill="currentColor"
                    d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"
                  />
                </svg>
              </div>
            </div>
        </div>-->
        <!-- <div>
            <div
              class="text-gray-500 rounded-full p-2 font-black space-x-2 flex place-items-center hover:bg-gray-300"
            >
              <div>
                <svg
                  class="svg-inline--fa fa-certificate fa-w-16 text-xl"
                  aria-hidden="true"
                  focusable="false"
                  data-prefix="fas"
                  data-icon="certificate"
                  role="img"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 512 512"
                >
                  <path
                    class
                    fill="currentColor"
                    d="M458.622 255.92l45.985-45.005c13.708-12.977 7.316-36.039-10.664-40.339l-62.65-15.99 17.661-62.015c4.991-17.838-11.829-34.663-29.661-29.671l-61.994 17.667-15.984-62.671C337.085.197 313.765-6.276 300.99 7.228L256 53.57 211.011 7.229c-12.63-13.351-36.047-7.234-40.325 10.668l-15.984 62.671-61.995-17.667C74.87 57.907 58.056 74.738 63.046 92.572l17.661 62.015-62.65 15.99C.069 174.878-6.31 197.944 7.392 210.915l45.985 45.005-45.985 45.004c-13.708 12.977-7.316 36.039 10.664 40.339l62.65 15.99-17.661 62.015c-4.991 17.838 11.829 34.663 29.661 29.671l61.994-17.667 15.984 62.671c4.439 18.575 27.696 24.018 40.325 10.668L256 458.61l44.989 46.001c12.5 13.488 35.987 7.486 40.325-10.668l15.984-62.671 61.994 17.667c17.836 4.994 34.651-11.837 29.661-29.671l-17.661-62.015 62.65-15.99c17.987-4.302 24.366-27.367 10.664-40.339l-45.984-45.004z"
                  />
                </svg>
              </div>
              <div>New</div>
            </div>
        </div>-->
        <!-- <div>
            <div
              class="text-gray-500 rounded-full p-2 font-black space-x-2 flex place-items-center hover:bg-gray-300"
            >
              <div>
                <svg
                  class="svg-inline--fa fa-sort-amount-up fa-w-16 text-xl"
                  aria-hidden="true"
                  focusable="false"
                  data-prefix="fas"
                  data-icon="sort-amount-up"
                  role="img"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 512 512"
                >
                  <path
                    class
                    fill="currentColor"
                    d="M304 416h-64a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zM16 160h48v304a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V160h48c14.21 0 21.38-17.24 11.31-27.31l-80-96a16 16 0 0 0-22.62 0l-80 96C-5.35 142.74 1.77 160 16 160zm416 0H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h192a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-64 128H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zM496 32H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h256a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"
                  />
                </svg>
              </div>
              <div>Top</div>
            </div>
        </div>-->
        <!-- <div>
            <div
              class="text-gray-500 rounded-full p-2 font-black space-x-2 flex place-items-center hover:bg-gray-300"
            >
              <div>
                <svg
                  class="svg-inline--fa fa-arrow-circle-up fa-w-16 text-xl"
                  aria-hidden="true"
                  focusable="false"
                  data-prefix="fas"
                  data-icon="arrow-circle-up"
                  role="img"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 512 512"
                >
                  <path
                    class
                    fill="currentColor"
                    d="M8 256C8 119 119 8 256 8s248 111 248 248-111 248-248 248S8 393 8 256zm143.6 28.9l72.4-75.5V392c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V209.4l72.4 75.5c9.3 9.7 24.8 9.9 34.3.4l10.9-11c9.4-9.4 9.4-24.6 0-33.9L273 107.7c-9.4-9.4-24.6-9.4-33.9 0L106.3 240.4c-9.4 9.4-9.4 24.6 0 33.9l10.9 11c9.6 9.5 25.1 9.3 34.4-.4z"
                  />
                </svg>
              </div>
              <div>Rising</div>
            </div>
          </div>
        </div>-->
        <!-- <div>
          <div
            class="rounded-full px-4 py-2 font-black flex place-items-center space-x-2 hover:text-logo-red hover:bg-red-50 hover:border-logo-red"
          >
            <svg
              class="svg-inline--fa fa-columns fa-w-16 text-xl"
              aria-hidden="true"
              focusable="false"
              data-prefix="fas"
              data-icon="columns"
              role="img"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 512 512"
            >
              <path
                class
                fill="currentColor"
                d="M464 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zM224 416H64V160h160v256zm224 0H288V160h160v256z"
              />
            </svg>
            <svg
              class="svg-inline--fa fa-caret-down fa-w-10"
              aria-hidden="true"
              focusable="false"
              data-prefix="fas"
              data-icon="caret-down"
              role="img"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 320 512"
            >
              <path
                class
                fill="currentColor"
                d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"
              />
            </svg>
        </div>-->
      </div>
    </div>
    <Post class="sm:block" v-for="post in posts" :key="post.id" :post="post" />
  </div>
</template>
<script>
import Post from "./Post";
export default {
  components: {
    Post
  },
  data() {
    var data = {
      form: {
        visibility: "public",
        body: "",
        title: "",
        attachements: []
      },
      posts: [],
      loading: false,
      profile: null,
      sortBy: "best" // possible value: [best,hot,top,new,active]
    };
    var arr = window.location.pathname.split("/");
    if (arr[1] === "u") data.profile = arr[2];
    console.log("data");
    return data;
  },
  watch: {
    sortBy: {
      handler: function(val, oldVal) {
        if (val !== oldVal) {
          this.posts = [];
          this.fetchData();
        }
      }
    }
  },
  created() {
    window.fetchData = this.fetchData;
    this.fetchData();
    document.body.onscroll = function() {
      const perc =
        this.scrollY / (document.body.offsetHeight - window.innerHeight);
      if (perc > 0.7) {
        console.log(perc);
        window.fetchData();
      }
    };
  },
  methods: {
    fetchData() {
      if (!this.loading) {
        this.loading = true;
        axios
          .post("/wapi/feed", {
            username: this.profile,
            skip: this.posts.length,
            sortBy: this.sortBy
          })
          .then(res => {
            console.log(res);
            this.posts.push(...res.data.data);
          })
          .catch(err => {
            console.log(err);
          })
          .then(() => (this.loading = false));
      }
    },
    refreshAttachements(e) {
      var files = e.target.files || e.dataTransfer.files;
      this.form.attachements.push(...files);
    },
    submit: function() {
      console.log("sub");
      var formData = new FormData();
      for (let i = 0; i < this.form.attachements.length; i++) {
        formData.append("attachements[" + i + "]", this.form.attachements[i]);
      }
      formData.append("body", this.form.body);
      formData.append("title", this.form.title);
      axios
        .post("/u/posts", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(res => {
          console.log("work");
          this.posts = [res.data.data, ...this.posts];
        })
        .catch(e => {
          console.log(e);
        })
        .then(e => {
          this.close();
        });
    },
    close() {
      // destroy the vue listeners, etc
      this.$destroy();
    }
  }
};
</script>
