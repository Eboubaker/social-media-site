require("./bootstrap.js");
require("./scroll-view");
require("./create-posts");
// require('./int-tel-input');

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
//
import Vue from "vue";

import {
  TInput,
  TTextarea,
  TSelect,
  TRadio,
  TCheckbox,
  TButton,
  TInputGroup,
  TCard,
  TAlert,
  TModal,
  TDropdown,
  TRichSelect,
  TPagination,
  TTag,
  TRadioGroup,
  TCheckboxGroup,
  TTable,
  TDatepicker,
  TToggle,
  TDialog,
} from "vue-tailwind/dist/components";
import VueTailwind from "vue-tailwind";
// import VueResource from "vue-resource";
import "alpinejs";
window.pluralize = require("pluralize");
// tell Vue to use the vue-resource plugin
// Vue.use(VueResource);
window.Vue = Vue;
import VueSmoothScroll from "vue2-smooth-scroll";
Vue.use(VueSmoothScroll);
Vue.component("feed", require("./components/Feed.vue").default);
Vue.component("nav-bar", require("./components/NavBar.vue").default);
Vue.component("post", require("./components/Post.vue").default);
Vue.component(
  "profile-type",
  require("./components/SocialBuisnessAccount.vue").default
);
Vue.component("play-ground", require("./components/PlayGround.vue").default);
Vue.component("creat-post", require("./components/CreatPost.vue").default);
Vue.component("posts-component", require("./components/Posts.vue").default);
Vue.component("comment", require("./components/Comment.vue").default);
Vue.component("community-head", require("./components/CommunityHead.vue").default);
Vue.component("profile-head", require("./components/ProfileHead.vue").default);

Vue.prototype.pluralize = (...atts) => window.pluralize(...atts);
// Vue.directive("clickaway", {
//   bind() {
//     this.event = (event) => this.vm.$emit(this.expression, event);
//     this.el.addEventListener("click", this.stopProp);
//     document.body.addEventListener("click", this.event);
//   },
//   unbind() {
//     this.el.removeEventListener("click", this.stopProp);
//     document.body.removeEventListener("click", this.event);
//   },

//   stopProp(event) {
//     event.stopPropagation();
//   },
// });

const settings = {
  // Use the following syntax
  // {component-name}: {
  //   component: {importedComponentObject},
  //   props: {
  //     {propToOverride}: {newDefaultValue}
  //     {propToOverride2}: {newDefaultValue2}
  //   }
  // }
  "t-input": {
    component: TInput,
    props: {
      classes: "border-2 block w-full rounded text-gray-800",
      // ...More settings
    },
  },
  "t-textarea": {
    component: TTextarea,
    props: {
      classes: "border-2 block w-full rounded text-gray-800",
      // ...More settings
    },
  },
  "t-rich-select": {
    component: TRichSelect,
    props: {
      fixedClasses: {
        wrapper: "relative",
        buttonWrapper: "inline-block relative w-full",
        selectButton:
          "w-full flex text-left justify-between items-center px-3 py-2 text-black transition duration-100 ease-in-out border rounded shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed",
        selectButtonLabel: "block truncate",
        selectButtonPlaceholder: "block truncate",
        selectButtonIcon: "fill-current flex-shrink-0 ml-1 h-4 w-4",
        selectButtonClearButton:
          "rounded flex flex-shrink-0 items-center justify-center absolute right-0 top-0 m-2 h-6 w-6 transition duration-100 ease-in-out",
        selectButtonClearIcon: "fill-current h-3 w-3",
        dropdown:
          "absolute w-full z-10 -mt-1 absolute border-b border-l border-r rounded-b shadow-sm z-10",
        dropdownFeedback: "",
        loadingMoreResults: "",
        optionsList: "overflow-auto",
        searchWrapper: "inline-block w-full",
        searchBox: "inline-block w-full",
        optgroup: "",
        option: "cursor-pointer",
        disabledOption: "opacity-50 cursor-not-allowed",
        highlightedOption: "cursor-pointer",
        selectedOption: "cursor-pointer",
        selectedHighlightedOption: "cursor-pointer",
        optionContent: "",
        optionLabel: "truncate block",
        selectedIcon: "fill-current h-4 w-4",
        enterClass: "",
        enterActiveClass: "",
        enterToClass: "",
        leaveClass: "",
        leaveActiveClass: "",
        leaveToClass: "",
      },
      classes: {
        wrapper: "",
        buttonWrapper: "",
        selectButton: "bg-white border-gray-300",
        selectButtonLabel: "",
        selectButtonPlaceholder: "text-gray-400",
        selectButtonIcon: "text-gray-600",
        selectButtonClearButton: "hover:bg-blue-100 text-gray-600",
        selectButtonClearIcon: "",
        dropdown: "bg-white border-gray-300",
        dropdownFeedback: "pb-2 px-3 text-gray-400 text-sm",
        loadingMoreResults: "pb-2 px-3 text-gray-400 text-sm",
        optionsList: "",
        searchWrapper: "p-2 placeholder-gray-400",
        searchBox:
          "px-3 py-2 bg-gray-50 text-sm rounded border focus:outline-none focus:shadow-outline border-gray-300",
        optgroup: "text-gray-400 uppercase text-xs py-1 px-2 font-semibold",
        option: "",
        disabledOption: "",
        highlightedOption: "bg-blue-100",
        selectedOption:
          "font-semibold bg-gray-100 bg-blue-500 font-semibold text-white",
        selectedHighlightedOption:
          "font-semibold bg-gray-100 bg-blue-600 font-semibold text-white",
        optionContent: "flex justify-between items-center px-3 py-2",
        optionLabel: "",
        selectedIcon: "",
        enterClass: "opacity-0",
        enterActiveClass: "transition ease-out duration-100",
        enterToClass: "opacity-100",
        leaveClass: "opacity-100",
        leaveActiveClass: "transition ease-in duration-75",
        leaveToClass: "opacity-0",
      },
      variants: {
        danger: {
          selectButton: "border-red-300 bg-red-50 text-red-900",
          selectButtonPlaceholder: "text-red-200",
          selectButtonIcon: "text-red-500",
          selectButtonClearButton: "hover:bg-red-200 text-red-500",
          dropdown: "bg-red-50 border-red-300",
        },
        success: {
          selectButton: "border-green-300 bg-green-50 text-green-900",
          selectButtonIcon: "text-green-500",
          selectButtonClearButton: "hover:bg-green-200 text-green-500",
          dropdown: "bg-green-50 border-green-300",
        },
      },
    },
  },
  // ...Rest of the components
};

Vue.use(VueTailwind, settings);