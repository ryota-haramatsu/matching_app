<template>
  <footer class="footer text-center p-3 d-block" style="background: white">
    <div>
      <button class="button button--link" @click="logout">ログアウト</button>
      <router-link class="button button--link" to="/login">
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
};
</script>