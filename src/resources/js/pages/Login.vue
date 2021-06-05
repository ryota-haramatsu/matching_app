<template>
  <div class="container--small">
    <ul class="tab">
      <li
        class="tab__item"
        :class="{ 'tab__item--active': tab === 1 }"
        @click="tab = 1"
      >
        ログイン
      </li>
      <li
        class="tab__item"
        :class="{ 'tab__item--active': tab === 2 }"
        @click="tab = 2"
      >
        新規登録
      </li>
    </ul>
    <!-- ログイン -->
    <div class="panel bg-white" v-show="tab === 1">
      <form class="form" @submit.prevent="login">
        <div class="errors" v-if="loginErrors">
          <!-- メールアドレスのエラー -->
          <ul v-if="loginErrors.email">
            <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
          </ul>
          <!-- パスワードのエラー -->
          <ul v-if="loginErrors.password">
            <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
          </ul>
        </div>
        <label for="login-email">メールアドレス</label>
        <input
          type="text"
          class="form__item"
          id="login-email"
          v-model="loginForm.email"
        />
        <label for="login-password">パスワード</label>
        <input
          type="password"
          class="form__item"
          id="login-password"
          v-model="loginForm.password"
        />
        <div class="form__button">
          <button type="submit" class="button">ログイン</button>
        </div>
      </form>
    </div>
    <!-- 新規登録 -->
    <div class="panel bg-white" v-show="tab === 2">
      <form class="form" @submit.prevent="register">
        <div v-if="registerErrors" class="errors">
          <ul v-if="registerErrors.name">
            <li v-for="msg in registerErrors.name" :key="msg">{{ msg }}</li>
          </ul>
          <ul v-if="registerErrors.email">
            <li v-for="msg in registerErrors.email" :key="msg">{{ msg }}</li>
          </ul>
          <ul v-if="registerErrors.password">
            <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>
          </ul>
        </div>
        <label for="username">名前</label>
        <input
          type="text"
          class="form__item"
          id="username"
          v-model="registerForm.name"
        />
        <label for="email">メールアドレス</label>
        <input
          type="text"
          class="form__item"
          id="email"
          v-model="registerForm.email"
        />
        <label for="password">パスワード</label>
        <input
          type="password"
          class="form__item"
          id="password"
          v-model="registerForm.password"
        />
        <label for="password-confirmation">パスワード (確認用)</label>
        <input
          type="password"
          class="form__item"
          id="password-confirmation"
          v-model="registerForm.password_confirmation"
        />
        <div class="form__button">
          <button type="submit" class="button">新規登録</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  data() {
    return {
      tab: 1,
      loginForm: {
        email: "",
        password: "",
      },
      registerForm: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
    };
  },
  methods: {
    async register() {
      // this.$store からストアを参照できる
      // dispatchでアクションを呼び出し authの(actionの)registerメソッド
      // 第二引数はフォームの入力値
      await this.$store.dispatch("auth/register", this.registerForm);

      if (this.apiStatus) {
        // トップページに遷移
        this.$router.push("/kyouan/list");
      }
    },

    async login() {
      await this.$store.dispatch("auth/login", this.loginForm);

      // apiStatusがTRUEの時のみ処理
      if (this.apiStatus) {
        this.$router.push("/kyouan/list");
      }
    },
    clearError() {
      this.$store.commit("auth/setLoginErrorMessages", null);
      this.$store.commit("auth/setRegisterErrorMessages", null);
    },
  },
  created() {
    // created ライフサイクルフックでエラーをクリア
    this.clearError();
  },
  computed: {
    ...mapState({
      apiStatus: (state) => state.auth.apiStatus,
      loginErrors: (state) => state.auth.loginErrorMessages,
      registerErrors: (state) => state.auth.registerErrorMessages,
    }),
  },
};
</script>