<template>
  <div>
    <TopNav></TopNav>
    <Post></Post>
    <!-- <Notifications></Notifications> -->
    <!-- <CreatPost></CreatPost> -->
    <BottomNav></BottomNav>
  </div>
</template>
<script>
import Post from "./Post";
import Notifications from "./Notifications";
import TopNav from "./TopNav";
import BottomNav from "./BottomNav";
import CreatPost from "./CreatPost";
export default {
  components: {
    Post,
    Notifications,
    TopNav,
    BottomNav,
    CreatPost
  }
};
</script>