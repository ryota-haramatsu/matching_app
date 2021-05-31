<template>
  <v-container fluid fill-height>
    <v-row>
      <v-container>
        <v-row>
          <v-col cols="2" class="text-center">
            <v-avatar size="96" class="mr-4">
              <img :src="'/images/users/avatar-1.jpg'" alt="Avatar" />
            </v-avatar>
            <p class="mt-2">惣流・アスカ・ラングレー</p>
          </v-col>
          <v-col cols="10">
            <v-card>
              <v-card-text>
                <v-text-field v-model="form.name" label="名前"></v-text-field>
                <v-text-field
                  v-model="form.contactEmail"
                  label="Email Address"
                ></v-text-field>
              </v-card-text>
              <v-card-actions>
                <v-btn class="bg-danger text-white font-weight-bold">
                  保存
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-row>
  </v-container>
</template>

<script>
export default {
  pageTitle: "My Profile",
  data() {
    return {
      loading: false,
      form: {
        name: "惣流・アスカ・ラングレー",
        contactEmail: "john@doe.com",
      },
      showAvatarPicker: false,
    };
  },
  methods: {
    openAvatarPicker() {
      this.showAvatarPicker = true;
    },
    selectAvatar(avatar) {
      this.form.avatar = avatar;
    },
  },
};
</script>