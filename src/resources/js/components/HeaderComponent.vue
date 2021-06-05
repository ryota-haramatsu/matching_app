<template>
  <div class="container-fluid header-bg">
    <div class="container">
      <nav class="navbar navbar-dark" style="flex-flow: row">
        <div class="d-flex">
          <!-- サービスロゴ -->
          <div class="navbar-brand-box">
            <router-link v-if="isLogin" :to="{ name: 'kyouan.list' }">
              キョウ遊 ~日本語教師のための教案共有サイト~
            </router-link>
            <div v-else>キョウ遊 ~日本語教師のための教案共有サイト~</div>
          </div>
        </div>

        <!-- ログイン済みのみ表示 -->
        <div v-if="isLogin">
          <!-- 新規作成 -->
          <router-link :to="{ name: 'kyouan.create' }" class="new_create">
            <v-icon>mdi-plus-circle-outline</v-icon>
            <span class="text-secondary">投稿</span>
          </router-link>
          <!-- 通知 -->
          <div class="dropdown d-inline-block">
            <button
              type="button"
              class="btn header-item noti-icon waves-effect"
              id="page-header-notifications-dropdown"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <v-icon>mdi-email</v-icon>
              <span class="badge badge-danger badge-pill">3</span>
            </button>
            <div
              class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
              aria-labelledby="page-header-notifications-dropdown"
            >
              <div class="p-3">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="m-0" key="t-notifications">通知</h6>
                  </div>
                </div>
              </div>
              <div data-simplebar style="max-height: 230px">
                <a href="" class="text-reset notification-item">
                  <div class="media">
                    <div class="avatar-xs mr-3">
                      <span
                        class="
                          avatar-title
                          bg-primary
                          rounded-circle
                          font-size-16
                        "
                      >
                        <i class="bx bx-cart"></i>
                      </span>
                    </div>
                    <div class="media-body">
                      <h6 class="mt-0 mb-1" key="t-your-order">
                        Your order is placed
                      </h6>
                      <div class="font-size-12 text-muted">
                        <p class="mb-1" key="t-grammer">
                          If several languages coalesce the grammar
                        </p>
                        <p class="mb-0">
                          <i class="mdi mdi-clock-outline"></i>
                          <span key="t-min-ago">3 min ago</span>
                        </p>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="p-2 border-top">
                <a
                  class="btn btn-sm btn-link font-size-14 btn-block text-center"
                  href="javascript:void(0)"
                >
                  <i class="mdi mdi-arrow-right-circle mr-1"></i>
                  <span key="t-view-more">もっと見る</span>
                </a>
              </div>
            </div>
          </div>
          <!-- ユーザー -->
          <div class="dropdown d-inline-block">
            <button
              type="button"
              class="btn header-item waves-effect"
              id="page-header-user-dropdown"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <span class="d-none d-xl-inline-block ml-1" key="">
                {{ username }}
              </span>
              <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <!-- プロフィールなど-->
              <router-link
                class="dropdown-item"
                :to="{ name: 'teacher.profile', params: { teacherId: 1 } }"
              >
                <i class="bx bx-user font-size-16 align-middle mr-1"></i>
                <span key="t-profile">プロフィール</span>
              </router-link>

              <a class="dropdown-item d-block" href="#"
                ><i class="bx bx-wrench font-size-16 align-middle mr-1"></i>
                <span key="t-settings">設定</span></a
              >
              <div class="dropdown-divider"></div>
              <a class="dropdown-item text-danger" href="#"
                ><i
                  class="
                    bx bx-power-off
                    font-size-16
                    align-middle
                    mr-1
                    text-danger
                  "
                ></i>
                <span key="t-logout" @click="logout">ログアウト</span></a
              >
            </div>
          </div>
        </div>
        <router-link v-else class="button button--link" to="/login">
          ログイン / 新規登録
        </router-link>
      </nav>
    </div>
  </div>
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
    username() {
      return this.$store.getters["auth/username"];
    },
  },
};
</script>

<style lang="scss" scoped>
</style>