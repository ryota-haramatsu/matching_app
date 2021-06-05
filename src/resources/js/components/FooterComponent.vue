<template>
  <footer class="footer text-center p-3 d-block" style="background: white">
    <div>
      <button v-if="isLogin" class="button button--link" @click="logout">
        ログアウト
      </button>
      <router-link v-else class="button button--link" to="/login">
        ログイン / 新規登録
      </router-link>
    </div>
    <div>
      <small>© 2021 kyoyou</small>
    </div>
  </footer>
</template>

<script>
export default {
  methods: {
    async logout() {
      await this.$store.dispatch("auth/logout");

      this.$router.push("/login");
    },
  },
  computed: {
    isLogin() {
      return this.$store.getters["auth/check"];
    },
  },
};
</script>