<template>
  <div
    class="auth-layout-wrap"
    :style="{ backgroundImage: 'url(' + bgImage + ')' }"
  >
    <div class="auth-content">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card o-hidden">
            <div class="p-4">
              <div class="auth-logo text-center mb-30">
                <img :src="logo" />
              </div>
              <h1 class="mb-3 text-18">Sign In</h1>
              <b-form @submit.prevent="formSubmit">
                <b-form-group label="Username" class="text-12">
                  <b-form-input
                    class="form-control-rounded"
                    type="text"
                    v-model="username"
                    required
                  ></b-form-input>
                </b-form-group>

                <b-form-group label="Password" class="text-12">
                  <b-form-input
                    class="form-control-rounded"
                    type="password"
                    v-model="password"
                    required
                  ></b-form-input>
                </b-form-group>

                <!-- <b-button block to="/" variant="primary btn-rounded mt-2"
                  >Sign In</b-button
                > -->
                <b-button
                  type="submit"
                  tag="button"
                  class="btn-rounded btn-block mt-2"
                  variant="primary mt-2"
                  :disabled="loading"
                >
                  SignIn
                </b-button>
                <div v-once class="typo__p" v-if="loading">
                  <div class="spinner sm spinner-primary mt-3"></div>
                </div>
                <!-- <b-button
                  to="signUp"
                  block
                  variant="primary mt-2"
                  class="btn-rounded"
                  >Create an account</b-button
                > -->
              </b-form>

              <!-- <div class="mt-3 text-center">
                <router-link to="forgot" tag="a" class="text-muted">
                  <u>Forgot Password?</u>
                </router-link>
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  metaInfo: {
    // if no subcomponents specify a metaInfo.title, this title will be used
    title: "Sign In",
  },
  data() {
    return {
      username: "",
      password: "",
      // // password: "vue006",
      userId: "",
      bgImage: require("../../../assets/images/photo-wide-4.jpg"),
      logo: require("../../../assets/images/logo.png"),
      signInImage: require("../../../assets/images/photo-long-3.jpg"),
    };
  },
  computed: {
    validation() {
      return this.userId.length > 4 && this.userId.length < 13;
    },
    ...mapGetters(["loggedInUser", "loading", "error"]),
  },

  methods: {
    ...mapActions(["login"]),
    formSubmit() {
      this.login({ username: this.username, password: this.password });
    },
    makeToast(variant = null, msg) {
      this.$bvToast.toast(msg, {
        // title: ` ${variant || "default"}`,
        variant: variant,
        solid: true,
      });
    },
  },
  watch: {
    loggedInUser(val) {
      if (val && val.length > 0) {
        this.makeToast("success", this.$t('logInSuccess'));

        setTimeout(() => {
          this.$router.push("/manage");
        }, 500);
      }
    },
    error(val) {
      if (val != null) {
        this.makeToast("warning", val);
      }
    },
  },
};
</script>

<style>
.spinner.sm {
  height: 2em;
  width: 2em;
}
</style>
