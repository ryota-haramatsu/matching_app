<template>
  <v-app>
    <v-container fluid fill-height class="home-hero__content">
      <v-row>
        <v-container>
          <v-row class="home-hero__content-text">
            <div class="overlay1"></div>
            <v-col id="movie_image">
              <!-- 左側 画像 -->
              <v-img
                v-on:click="play"
                class="rounded-lg"
                height="250"
                src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
              ></v-img> 
              <!-- 動画リンクか画像を選択 -->
            </v-col>
            <v-col>
              <p>「あなたの教案タイトル」</p>
              <p class="home-hero__content-text-sub mb-0">
                対象学習者: JLPT N5レベル
              </p>
              <v-rating
                :value="4.5"
                color="amber"
                dense
                half-increments
                readonly
                size="18"
              ></v-rating>
              <div class="home-hero__content-teacher">
                <!-- プロフィール -->
                <span class="home-hero__content-text-name"
                  >作成者: トニー・スターク</span
                >
              </div>
              <div>
                <span class="home-hero__content-text-name"
                  >指導案のダウンロード</span
                >
                <v-icon large color="white">mdi-download-circle-outline</v-icon>
              </div>
              <div>
                <!-- いいね -->
                <v-btn icon>
                  <v-icon color="white">mdi-heart</v-icon>
                </v-btn>
                <!-- ブックマーク -->
                <v-btn icon>
                  <v-icon color="white">mdi-bookmark</v-icon>
                </v-btn>
                <!-- シェア -->
                <v-btn icon>
                  <v-icon color="white">mdi-share-variant</v-icon>
                </v-btn>
              </div>
            </v-col>
          </v-row>
        </v-container>
        <!-- 右側 -->
      </v-row>
    </v-container>
    <v-container>
      <v-row>
        <h3>学習目標</h3>
      </v-row>
      <v-row>
        <h3>指導</h3>
      </v-row>
      <v-row>
        <h3>学習指導計画</h3>
      </v-row>
    </v-container>
  </v-app>
</template>

<script>
export default {
  // methods:{
  //   play: function(event) {
  //     event.preventDefault();

  //     alert("good")
  //   }
  // }
};
</script>

<style  lang="scss" scoped>
.home-hero__content {
  background: url("/images/bg-teacher-profile.png");
  background-size: cover;
  background-position: center center;
  width: 100%;
  height: auto;
  padding: 2%;
  margin-bottom: 100px;

  &-text {
    .target1 {
      background-color: red;
    }
    color: white;
    text-align: left;
    font-size: 28px;
    font-weight: bold;
    &-sub {
      font-size: 18px;
    }
    &-name {
      font-size: 14px;
    }
  }
  &-flow {
    background-color: ghostwhite;
    color: white;
    text-align: left;
    font-weight: bold;
    font-size: 18px;
    text-align: center;
    &-icon {
      color: black;
    }
  }
}
</style>