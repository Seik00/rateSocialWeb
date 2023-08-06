<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
      <span>{{ $t("setWithdraw") }}</span>
    </div>

    <div class="mx-4">
      <div class="mt-3" style="position: relative">
        <b-form @submit.prevent="setBank">
          <p style="color: red; font-weight: bold; margin: 0px 0px 10px 0px">
            {{ $t("setWithdrawHint") }}
          </p>

          <b-form-group :label="$t('bank_country')" class="form-customize mt-3">
            <b-form-select
              v-model="country"
              :options="countryOptions"
              id="country"
            >
            </b-form-select>
          </b-form-group>

          <b-form-group :label="$t('bank_name')" class="form-customize mt-3">
            <b-input-group>
              <b-form-input
                class="form-control form-custom"
                v-model="bank_name"
                type="text"
                required
              >
              </b-form-input>
            </b-input-group>
          </b-form-group>

          <b-form-group :label="$t('bank_user')" class="form-customize mt-3">
            <b-input-group>
              <b-form-input
                class="form-control form-custom"
                v-model="bank_user"
                type="text"
                required
              >
              </b-form-input>
            </b-input-group>
          </b-form-group>

          <b-form-group :label="$t('bank_number')" class="form-customize mt-3">
            <b-input-group>
              <b-form-input
                class="form-control form-custom"
                v-model="bank_number"
                type="number"
                required
              >
              </b-form-input>
            </b-input-group>
          </b-form-group>

          <b-form-group :label="$t('branch')" class="form-customize mt-3">
            <b-input-group>
              <b-form-input
                class="form-control form-custom"
                v-model="branch"
                type="text"
                required
              >
              </b-form-input>
            </b-input-group>
          </b-form-group>

          <b-form-group :label="$t('sec_password')" class="form-customize mt-3">
            <b-input-group>
              <b-form-input
                class="form-control form-custom"
                v-model="sec_pwd"
                type="password"
                required
              >
              </b-form-input>
            </b-input-group>
          </b-form-group>

          <b-button
            class="mx-auto submit_button my-5"
            variant="outline-secondary"
            type="submit"
            :disabled="isLoading"
            >{{ isLoading ? $t("loading...") : $t("submit") }}</b-button
          >
        </b-form>
        <Dialog ref="msg"></Dialog>
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
      <h4 class="text-center text-white">
        {{ this.$t("modalHeader") }}
      </h4>
      <b-form class="mx-5" v-on:submit.prevent="_checkOTP">
        <b-row align-h="center">
          <b-col md="12 mb-30">
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
  getBankInfo,
  setBankInfo,
  country_list,
  requestOTP,
  checkOTP,
} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
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
      bank_name: "",
      bank_user: "",
      bank_number: "",
      branch: "",
      amount: 0,
      confirm_amount: 0,
      convert_amount: 0,
      bankRate: 0,
      sec_pwd: "",
      selected: 0,
      isLoading: false,
      country: null,
      pSymbol: "",
      countryOptions: [],
      rows: [],
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
        formData.append("otp_type", "email");
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
    getCountryList() {
      var result = country_list();
      var self = this;
      self.countryOptions = [];
      this.isLoading = true;
      result
        .then(function (value) {
          console.log(value.data);
          self.country = value.data.data[0].id;
          self.bankRate = value.data.data[0].buy;
          self.pSymbol = value.data.data[0].short_form;
          for (let i = 0; i < value.data.data.length; i++) {
              // if (value.data.data[i].id == 83) {
                // self.country = value.data.data[i].id;
                var jsonObject = {};
                jsonObject["value"] = value.data.data[i].id;
                jsonObject["text"] =
                  self.$i18n.locale == "en"
                    ? value.data.data[i].name_en
                    : value.data.data[i].name;
                self.countryOptions.push(jsonObject);
                self.rows = value.data.data;
              // }
          }
          self.isLoading = false;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },

    setBank() {
        let formData = new FormData();
        formData.append("bank_country", this.country);
        formData.append("bank_name", this.bank_name);
        formData.append("bank_user", this.bank_user);
        formData.append("bank_number", this.bank_number);
        formData.append("branch", this.branch);
        formData.append("sec_password", this.sec_pwd);

        var result = setBankInfo(formData);
        var self = this;
        self.isLoading = true;

        result
          .then(function (value) {
            console.log(value.data);
            if (value.data.error_code == 0) {
              self.$refs.msg.makeToast("success", self.$t(value.data.message));
              setTimeout(() => {
                self.$router.push("/web/withdraw");
              }, 2000);
            } else {
              self.$refs.msg.makeToast("danger", self.$t(value.data.message));
            }
            self.sec_pwd = "";
            self.isLoading = false;
          })
          .catch(function (error) {
            console.log(error);
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
            self.isLoading = false;
            self.sec_pwd = "";
          });
    },

    getInfo() {
      var result = getBankInfo();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          console.log(value.data);
          self.bank_number = value.data.data.bank_number;
          self.bank_name = value.data.data.bank_name;
          self.bank_user = value.data.data.bank_user;
          self.branch = value.data.data.branch;
          // if (value.data.data.bank_number != null) {
          //   self.$bvModal.show("modal-otp");
          // }
          self.isLoading = false;
        })
        .catch(function (e) {
          console.log(e);
          self.isLoading = false;
        });
    },
  },
  watch: {},
  created() {
    this.getCountryList();
    this.getInfo();
  },
};
</script>

<style>
button.close {
  display: none;
}
h5#modal-warning___BV_modal_title_ {
  margin: auto;
}
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

.input-group{
  border-bottom: none;
  margin-bottom: 1rem !important;
}

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