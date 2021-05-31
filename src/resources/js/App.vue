<template>
  <div>
    <header-component></header-component>

    <main>
      <div class="container">
        <router-view />
      </div>
    </main>
    <footer-component></footer-component>
  </div>
</template>

<script>
import HeaderComponent from "./components/HeaderComponent.vue";
import FooterComponent from "./components/FooterComponent.vue";

export default {
  components: {
    HeaderComponent,
    FooterComponent,
  },
};
</script>