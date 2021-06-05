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
import { INTERNAL_SERVER_ERROR } from "./util";

export default {
  components: {
    HeaderComponent,
    FooterComponent,
  },
  computed: {
    errorCode() {
      return this.$store.state.error.code;
    },
  },
  watch: {
    errorCode: {
      handler(val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push("/500");
        }
      },
      immediate: true,
    },
    $route() {
      this.$store.commit("error/setCode", null);
    },
  },
};
</script>