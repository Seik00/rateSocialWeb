<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
      <span>{{ $t("setWithdraw") }}</span>
    </div>

    <div class="mainpage">
      <div class="mt-3" style="position: relative">
        <b-form @submit.prevent="setCoin">
          <p style="color: red; font-weight: bold; margin: 0px 0px 10px 0px">
            {{ $t("setWithdrawHint") }}
          </p>

          <b-form-group :label="$t('address')" class="form-customize mt-3">
            <b-input-group>
              <b-form-input
                class="form-control form-custom"
                v-model="address"
                type="text"
                required
              >
              </b-form-input>
            </b-input-group>
          </b-form-group>

          <b-button
            class="mx-auto submit_button"
            style="margin-top: 10vh"
            variant="outline-secondary"
            type="submit"
            :disabled="isLoading"
            >{{ isLoading ? $t("loading...") : $t("submit") }}</b-button
          >
        </b-form>
        <Dialog ref="msg"></Dialog>
        <b-modal
          id="modal-warning"
          size="md"
          centered
          :title="$t('withdrawal_rules')"
          :hide-footer="true"
          style="background-color: #5f646e !important"
        >
          <b-form>
            <b-row align-h="center">
              <b-col md="12 mb-30">
                <div class="form-group">
                  <div class="col-sm-12">
                    <p>
                      {{ $t("withdrawal_rules1") }}
                    </p>
                    <p>
                      {{ $t("withdrawal_rules2") }}
                    </p>
                    <p>
                      {{ $t("withdrawal_rules3") }}
                    </p>
                    <p>
                      {{ $t("withdrawal_rules4") }}
                    </p>
                    <p>
                      {{ $t("withdrawal_rules5") }}
                    </p>
                    <p>
                      {{ $t("withdrawal_rules6") }}
                    </p>
                    <p>
                      {{ $t("withdrawal_rules7") }}
                    </p>
                    <p>
                      {{ $t("withdrawal_rules8") }}
                    </p>
                  </div>
                  <div class="col-sm-12">
                    <center>
                      <b-button
                        class="mx-auto submit_button mt-5"
                        variant="outline-secondary"
                        @click="close()"
                        >{{ $t("close") }}</b-button
                      >
                    </center>
                  </div>
                </div>
              </b-col>
            </b-row>
          </b-form>
        </b-modal>
      </div>
    </div>

    <b-modal
      id="modal-otp"
      size="md"
      centered
      :hide-footer="true"
      :hide-header="true"
      style="background-color: #5f646e !important"
      :no-close-on-backdrop="true"
      :no-close-on-esc="true"
    >
      <b-form class="mx-5 mt-4" v-on:submit.prevent="_checkOTP">
        <b-row align-h="center">
          <b-col md="12">
            <b-input-group>
              <b-form-input
                class="form-control mb-3 form-custom-prepend2"
                label="text"
                v-model="otp"
                type="text"
                :placeholder="$t('otp')"
                required
              >
              </b-form-input>

              <b-input-group-append
                class="form-custom-append2"
                style="position: relative"
              >
                <b-button
                  variant="light"
                  style="
                    height: 100%;
                    border-bottom-right-radius: 0.5rem !important;
                    border-top-right-radius: 0.5rem !important;
                  "
                  :disabled="startCount || sending"
                  @click="getOTP"
                >
                  <span v-if="!sending">{{ $t("getCode") }}</span
                  ><span v-else class="text-white">{{ $t("loading...") }}</span>
                </b-button>
                <div v-if="startCount" class="text-center py-2 overlay-text">
                  {{ timecount }} s
                </div>
              </b-input-group-append>
            </b-input-group>

            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="mt-4 float-right">
                  <b-button
                    type="button"
                    class="m-1"
                    variant="danger"
                    @click="cancelOtp"
                    >{{ $t("cancel") }}</b-button
                  >
                  <b-button
                  :disabled="isLoading"
                    type="submit"
                    class="m-1"
                    variant="outline-secondary"
                    style="background-color: #02daaf !important"
                    >{{ $t("submit") }}</b-button
                  >
                </div>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
import {
  getMemberInfo,
  setCoinInfo,
  requestOTP,
  checkOTP,
} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import { mapGetters } from "vuex";
import Dialog from "../../../components/dialog.vue";
export default {
  props: ["fee", "totalAmount", "canWithdraw", "startLoading"],
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
  },
  data() {
    return {
      address: "",
      amount: 0,
      confirm_amount: 0,
      sec_pwd: "",
      selected: 0,
      isLoading: false,
      otp: "",
      timecount: 60,
      startCount: false,
      myVar: null,
      sending: false,
    };
  },
  methods: {
    warning() {
      this.$bvModal.show("modal-warning");
    },
    close() {
      this.$bvModal.hide("modal-warning");
    },

    cancelOtp() {
      this.$router.go(-1);
    },

    _checkOTP() {
      let formData = new FormData();
      formData.append("otp", this.otp);
      var result = checkOTP(formData);
      var self = this;

      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.error_code == 0) {
            self.$bvModal.hide("modal-otp");
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.sending = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.sending = false;
        });
    },

    getOTP() {
      if (this.mobile == "") {
        this.$refs.msg.makeToast("danger", this.$t("phoneEmpty"));
      } else {
        this.sending = true;
        let formData = new FormData();
        formData.append("contact_number", this.mobile);
        formData.append("country_id", this.country_id);
        formData.append("lang", this.$i18n.locale == "en" ? "en" : "cn");
        var result = requestOTP(formData);
        var self = this;

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
              self.$refs.msg.makeToast("danger", value.data.message);
            }
            self.sending = false;
          })
          .catch(function (error) {
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
            self.sending = false;
          });
      }
    },

    setCoin() {
      let formData = new FormData();
      formData.append("address", this.address);
      console.log(formData);

      var result = setCoinInfo(formData);
      var self = this;
      self.isLoading = true;

      result
        .then(function (value) {
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            setTimeout(() => {
              self.$router.push("/web/withdraw");
            }, 2000);
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.sec_pwd = "";
          // self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
          self.sec_pwd = "";
        });
    },

    getInfo() {
      var result = getMemberInfo();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.address = value.data.address;
          if (value.data.address != null) {
            self.$bvModal.show("modal-otp");
          }
          self.isLoading = false;
        })
        .catch(function (e) {
          console.log(e);
          self.isLoading = false;
        });
    },
  },
  created() {
    this.getInfo();
  },
};
</script>

<style>
.overlay-text {
  position: absolute;
  z-index: 2;
  height: 100%;
  width: 100%;
  color: black;
  font-weight: 700;
  line-height: 1.5;
}

/* .form-custom {
  background-color: transparent !important;
  border: 3px grey solid;
  color: black;
  border-radius: 0.75rem !important;
  height: calc(2.5rem + 2px);
  font-size: 16px !important;
}

.form-custom-none {
  background-color: transparent !important;
  border-top: 3px grey solid;
  border-bottom: 3px grey solid;
  color: black;
  height: calc(2.5rem + 2px);
  font-size: 16px !important;
} */

.form-custom-prepend2 {
  background-color: transparent !important;
  border: 3px grey solid;
  color: black;
  border-bottom-left-radius: 0.75rem !important;
  border-top-left-radius: 0.75rem !important;
  height: calc(2.5rem + 2px) !important;
}

.form-custom-append2 {
  /* background-color: #5f646e !important; */
  border: 3px grey solid;
  color: #fff;
  border-bottom-right-radius: 0.75rem !important;
  border-top-right-radius: 0.75rem !important;
  height: calc(2.5rem + 2px);
}
</style>