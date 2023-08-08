<template>
  <div class="auth-layout-wrap"
    style="height:100%;background-repeat: no-repeat;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;width:100%;max-height:100%;min-height: 100%;">
    <div class="d-flex flex-column col-md-12" style="height:100%;min-height:100%">
      <div class="o-hidden" style="-webkit-box-shadow:none!important;box-shadow:none!important;">
        <div class="p-4 mt-5">
          <!-- <div @click="changeLang('en')">
                eng
              </div>
               <div @click="changeLang('zh')">
                cn
              </div> -->
          <div class="auth-logo text-left mb-5 mt-4">
            <h1 class="text-title mb-3">Sign In</h1>
            <p class="text-unlock">Unlock the Fun: <span class="text-unlock-purple">Rate Apps</span>,  <span class="text-unlock-green">Earn Money</span>, and Embrace the Good Vibes!</p>
          </div>
          <!-- <h1 class="mb-3 text-18 text-white">Sign In</h1> -->
          <b-form @submit.prevent="formSubmit" style="margin-bottom:20px">
            <b-input-group class="form-customize mt-3">
              <!-- <b-input-group-prepend>
                <img src="../../../assets/images/digital/email.svg" alt="">
              </b-input-group-prepend> -->

              <b-form-input class="form-control form-custom" type="text" v-model="username" :placeholder="`${$t('username')}`"
                required></b-form-input>
            </b-input-group>

            <b-input-group class="form-customize mt-3">
              <!-- <b-input-group-prepend>
                <img src="../../../assets/images/digital/padlock.svg" alt="">
              </b-input-group-prepend> -->
              <b-form-input class="form-control form-custom" type="password" v-model="password" :placeholder="`${$t('password')}`"
                required></b-form-input>
            </b-input-group>

            <!-- <b-button block to="/web/" variant="primary btn-rounded mt-2"
                  >Sign In</b-button
                > -->
            <div class="d-flex justify-content-end">
              <div>
                <router-link to="/web/settings/forget-password" tag="a" class="text-primary">
                  <p class="text-purple"><u>{{ $t("forget_password") }} ?</u></p>
                </router-link>
              </div>
            </div>

            <b-button type="submit" tag="button" class="btn-block mt-5 submit_button w-100" variant="mt-2"
              :disabled="loading">
              {{ $t("sign_in") }}
            </b-button>
            <div v-once class="typo__p" v-if="loading">
              <div class="spinner sm spinner-light mt-3"></div>
            </div>
          </b-form>

            <div class="d-flex justify-content-center">
              <div>
                <router-link to="/register" tag="a" class="text-primary">
                  <p class="text-black">{{ $t("create_account") }}</p>
                </router-link>
              </div>
            </div>

        </div>
      </div>
      <!-- <div class="justify-content-center flex-grow-1 d-flex align-items-end pb-5">
        <router-link to="/register" tag="a" class="text-primary">
          <div>{{ $t('don_have_an_account') + ' ' + $t("sign_up") }}</div>
        </router-link>
      </div> -->
    </div>
    <b-modal id="modal-maintenance" size="md" centered :title="$t('system_maintenance')" :hide-footer="true"
      style="background-color: #5f646e !important" :no-close-on-backdrop="true" :no-close-on-esc="true">
      <b-form class="mx-5">
        <b-row align-h="center">
          <b-col md="12 mb-30">
            <b-row align-h="center" style="margin-bottom: 10px">
              <div class="form-group">
                <i class="fa fa-cog" style="font-size:100px;color:purple"></i>
              </div>
              <div class="col-sm-12">
                <center>
                  {{ $t('maintanence') }}
                </center>
              </div>
            </b-row>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>
<script>
import { getDownloadLink } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import { mapGetters, mapActions } from "vuex";
import Dialog from "../../../components/dialog.vue";
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
      bgImage: require("../../../assets/images/boost/bottom_banner_signin.png"),
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
  components: {
    Dialog,
  },
  methods: {
    ...mapActions(["login", "changeLan"]),
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
    changeLang(lang) {
      console.log(lang);
      this.$i18n.locale = lang;
      this.changeLan(lang);
    },
    maintenance() {
      var result = getDownloadLink();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var siteOn = value.data.data.system.SITE_ON;
          if (siteOn == 0) {
            self.$bvModal.show("modal-maintenance");
          }
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.maintenance();
  },
  watch: {
    loggedInUser(val) {
      if (val && val.length > 0) {
        this.makeToast("success", this.$t("login_ok"));

        setTimeout(() => {
          this.$router.push("/web/dashboard/dashboard");
        }, 500);
      }
    },
    error(val) {
      if (val != null) {
        this.makeToast("danger", this.$t(val));
      }
    },
  },
};
</script>

<style>
.input-group{
    margin-bottom: 2rem !important;

}

h5#modal-maintenance___BV_modal_title_ {
  margin: auto;
}

button.close {
  display: none;
}

.spinner.sm {
  height: 2em;
  width: 2em;
}
</style>
