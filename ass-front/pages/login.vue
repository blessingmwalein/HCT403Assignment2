<template>
  <v-content>
    <v-container fluid fill-height>
      <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4>
          <v-card class="elevation-12">
            <v-toolbar dark>
              <v-btn depressed text>Login Form</v-btn>
            </v-toolbar>
            <v-card-text>
              <v-form>
                <v-text-field
                  outlined
                  name="login"
                  label="Login"
                  type="text"
                  v-model="credentials.email"
                ></v-text-field>
                <v-text-field
                  id="password"
                  name="password"
                  outlined
                  label="Password"
                  type="password"
                  v-model="credentials.password"
                ></v-text-field>
              </v-form>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn depressed text @click.prevent="submitForm()">Login</v-btn>
            </v-card-actions>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </v-content>
</template>

<script>
import { mapActions, mapState, mapGetters } from "vuex";
export default {
  layout: "auth",
  data() {
    return {
      credentials: {},
    };
  },
  computed: {
    ...mapGetters({
      error: "app/getError",
      loading: "app/getLoading",
      message: "app/getMessage",
    }),
  },
  methods: {
    ...mapActions({
      login: "app/login",
    }),
    submitForm() {
      var data = new FormData();
      data.append("email", this.credentials.email);
      data.append("password", this.credentials.password);
      this.login(data);
    },
  },
};
</script>
