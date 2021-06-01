 <template>
  <div class="container">
    <div class="row">
      <v-col sm="12" md="6" lg="4" v-for="n in 4" :key="n">
        <router-link :to="{ name: 'kyouan.show', params: { kyouanId: 1 } }">
          <v-card class="mx-auto my-12 mx-1 mb-2">
            <template slot="progress">
              <v-progress-linear
                color="deep-purple"
                height="10"
                indeterminate
              ></v-progress-linear>
            </template>

            <v-img
              height="250"
              src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
            ></v-img>

            <v-card-title>Cafe Badilico</v-card-title>

            <v-card-text>
              <v-row align="center" class="mx-0">
                <v-rating
                  :value="4.5"
                  color="amber"
                  dense
                  half-increments
                  readonly
                  size="14"
                ></v-rating>

                <div class="grey--text ms-4">4.5 (413)</div>
              </v-row>

              <div class="my-4 subtitle-1">$ • Italian, Cafe</div>

              <div>
                Small plates, salads & sandwiches - an intimate setting with 12
                indoor seats plus patio seating.
              </div>
            </v-card-text>
          </v-card>
        </router-link>
      </v-col>
    </div>
  </div>
</template>
 <script>
export default {};
</script>