<template>
  <div>
    <button @click="isOpen = !isOpen">drop</button>
    <div
      :class="isOpen ? 'block' : 'hidden'"
    >Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque alias dolores officia eveniet maxime animi magni sunt similique, id consectetur.</div>
  </div>
</template>

<script>
export default {
  name: "PlayGround",
  data() {
    return {
      isOpen: fasle
    };
  }
};
</script>

