<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
      <span>{{ $t("change_password") }}</span>
    </div>
    <b-form @submit.prevent="sendOTP">
      <div class="mainpage">
        <b-form-group class="form-customize" id="input-group-2" :label="$t('email')" label-for="input-2">
          <!-- <b-form-input class="form-custom"
            id="input-2"
            v-model="email"
            type="text"
            readonly
            required
          ></b-form-input> -->
          <b-input-group>
            <!-- <b-input-group-prepend>
              <span class="">{{ country }}</span>
            </b-input-group-prepend> -->
            <b-form-input class="form-custom" v-model="email" readonly>
            </b-form-input>
          </b-input-group>
        </b-form-group>

        <b-form-group class="form-customize" id="input-group-2" :label="$t('vcode')" label-for="input-2">
          <b-input-group>
            <b-form-input class="form-custom" label="text" type="number" v-model="otp" required>
            </b-form-input>
            <b-input-group-append class=" position-relative align-items-center">
              <b-button variant="primary" :disabled="startCount || sending" @click="getOTP">
                <span v-if="!sending">{{ $t("get_vcode") }}</span><span v-else class="text-white">{{ $t("loading...")
                }}</span>
              </b-button>
              <div v-if="startCount" class="text-center py-2 overlay-text">
                {{ timecount }} s
              </div>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>


        <b-form-group class="form-customize" id="input-group-2" :label="$t('old_password')" label-for="input-2">
          <b-form-input class="form-custom" id="input-2" v-model="old_password" type="password" required></b-form-input>
        </b-form-group>

        <b-form-group class="form-customize" id="input-group-2" :label="$t('new_password')" label-for="input-2">
          <b-form-input class="form-custom" id="input-2" v-model="password" type="password" required></b-form-input>
        </b-form-group>

        <b-form-group class="form-customize" id="input-group-2" :label="$t('confirm_new_password')" label-for="input-2">
          <b-form-input class="form-custom" id="input-2" v-model="password_confirmation" type="password"
            required></b-form-input>
        </b-form-group>

        <b-button class="mx-auto submit_button" style="margin-top: 20vh" variant="outline-secondary" type="submit">{{
          isLoading ? $t("loading...") : $t("submit") }}</b-button>
      </div>
    </b-form>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  requestOTP,
  checkOTP,
  changePassword,
} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
  },
  data() {
    return {
      email: "",
      country: "",
      otp: "",
      old_password: "",
      password: "",
      password_confirmation: "",
      timecount: 60,
      startCount: false,
      myVar: null,
      sending: false,
      isLoading: false,
    };
  },
  props: ["success"],
  methods: {
    getInfo() {
      var info = JSON.parse(localStorage.getItem('info'));
      
      this.email = info.email;
    },
    sendOTP() {
      let formData = new FormData();
      var self = this;
      formData.append("otp", this.otp);
      var result = checkOTP(formData);
      self.isLoading = true;

      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.submitForm();
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.sending = false;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.sending = false;
          self.isLoading = false;
        });
    },
    submitForm() {
      let formData = new FormData();
      var self = this;
      formData.append("old_password", this.old_password);
      formData.append("password", this.password);
      formData.append("password_confirmation", this.password_confirmation);
      var result = changePassword(formData);
      self.isLoading = true;

      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.otp = '';
            self.old_password = '';
            self.password = '';
            self.password_confirmation = '';
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.sending = false;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.sending = false;
          self.isLoading = false;
        });
    },
    getOTP() {
      if (this.username == "") {
        this.$refs.msg.makeToast("danger", this.$t("emailEmpty"));
      } else {
        this.sending = true;
        this.isLoading = true;
        let formData = new FormData();
        var self = this;
        formData.append("otp_type", "email");
        var result = requestOTP(formData);

        result
          .then(function (value) {
            console.log(value.data);
            if (value.data.error_code == 0) {
              self.$refs.msg.makeToast("success", self.$t("otp_sent"));
              self.startCount = true;
              self.myVar = setInterval(() => {
                self.timecount -= 1;
                if (self.timecount == 0) {
                  self.timecount = 60;
                  clearInterval(self.myVar);
                  self.startCount = false;
                }
              }, 1000);
            } else {
              self.$refs.msg.makeToast("danger", self.$t(value.data.message));
            }
            self.sending = false;
            self.isLoading = false;
          })
          .catch(function (error) {
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
            self.sending = false;
            self.isLoading = false;
          });
      }
    },
    loadItems() { },
  },
  created() {
    this.loadItems();
    this.getInfo();
    this.username = localStorage.getItem("username");
  },
};
</script>

<style>
.input-group {
  border-bottom: none;
  margin-bottom: 1rem !important;
}
</style>