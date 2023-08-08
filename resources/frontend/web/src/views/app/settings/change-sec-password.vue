<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
      <!-- <span>{{ $t("change_secpassword") }}</span> -->
    </div>
    <b-form @submit.prevent="sendOTP">
      <div class="mainpage">

        <div class="text-left mb-2 mt-5">
          <h1 class="text-title mb-0">{{ $t("change_secpassword")}}</h1>
        </div>

        <b-form-group :label="$t('email')" class="form-customize">
          <!-- <b-form-input
            
            v-model="email"
            type="text"
            readonly
            required
          ></b-form-input> -->
          <b-input-group>
            <b-form-input class="form-custom" size="lg" v-model="email" :placeholder="$t('email')" readonly>
            </b-form-input>
          </b-input-group>
        </b-form-group>


        <!-- <b-form-group class="form-customize" :label="$t('old_password')" label-for="input-2">
          <b-form-input class="form-custom" v-model="old_password" type="password" required></b-form-input>
        </b-form-group> -->

        <b-form-group class="form-customize mb-3">
          <b-input-group>
            <b-form-input class="form-custom " label="text" type="number" v-model="otp" :placeholder="$t('vcode')" required>
            </b-form-input>
            <b-input-group-append class="form-custom-append" style="position: relative">
              <b-button variant="light" style="
                      border-bottom-right-radius: 0.5rem !important;
                      border-top-right-radius: 0.5rem !important;
                    " :disabled="startCount || sending" @click="getOTP">
                <span v-if="!sending">{{ $t("getCode") }}</span><span v-else class="text-white">{{ $t("loading...")
                }}</span>
              </b-button>
              <div v-if="startCount" class="text-center py-2 overlay-text">
                {{ timecount }} s
              </div>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>
        
        <b-form-group class="form-customize mt-3" id="input-group-2">
          <b-input-group>
            <b-form-input class="form-custom" v-model="sec_password" type="password" :placeholder="$t('old_sec_password')"  required></b-form-input>
          </b-input-group>
        </b-form-group>

        <b-form-group class="form-customize mt-3" id="input-group-2">
          <b-input-group>
            <b-form-input class="form-custom" v-model="password" type="password" :placeholder="$t('new_sec_password')" required></b-form-input>
          </b-input-group>
        </b-form-group>

        <b-form-group class="form-customize mt-3" id="input-group-2">
          <b-input-group>
            <b-form-input class="form-custom" v-model="password_confirmation" type="password" :placeholder="$t('confirm_sec_new_password')" required></b-form-input>
          </b-input-group>
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
  changeSecPassword,
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
      sec_password: "",
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
      formData.append("sec_password", this.sec_password);
      formData.append("password", this.password);
      formData.append("password_confirmation", this.password_confirmation);
      var result = changeSecPassword(formData);
      self.isLoading = true;

      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.otp = "";
            self.password = "";
            self.sec_password = "";
            self.password_confirmation = "";
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