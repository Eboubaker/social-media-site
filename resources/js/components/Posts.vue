<template>
  <div class="flex flex-col bg-gray-100">
    <div class="space-y-4">
      <NavBar />
      <MainMenu />
      <QuickMenu class="" />
    </div>
    <div class="flex flex-row justify-between">
      <!-- keep the width for the large screen -->
      <div class="sm:w-1/2">
        <div></div>
      </div>
      <div class="sm:w-2/3">
        <Post />
        <Post />
        <Post />
      </div>
      <div class="sm:w-1/2"></div>
    </div>
  </div>
</template>
<script>
var slides = document.getElementsByClassName("slide");
var index = 0;
import Post from "./Post";
import NavBar from "./NavBar";
import MainMenu from "./MainMenu";
import QuickMenu from "./QuickMenu";
export default {
  components: {
    Post,
    NavBar,
    QuickMenu,
    MainMenu
  },
  data() {
    return {
      goLeft() {
        if (index == 0) index = slides.length - 1;
        else index++;
        slides[0].style.marginLeft = "-" + index * 100 + "px";
      }
    };
  }
};
</script>