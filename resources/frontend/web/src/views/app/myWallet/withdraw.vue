<template>
  <div class="">
    <div style="position: relative">
      <div
        v-if="isLoading"
        style="
          position: absolute;
          background-color: rgba(211, 211, 211, 0.2);
          height: 100%;
          width: 100%;
          z-index: 3;
          display: flex;
          justify-content: center;
          align-items: center;
        "
      >
        <span
          style="
            background-color: #c0dfff;
            color: #409eff;
            padding: 7px 30px;
            border-radius: 3px;
          "
          >{{ $t("loading...") }}</span
        >
      </div>
      <b-tabs pills align="start">
        
          <b-row align-h="center" @submit.prevent="sendOTP">
            <b-col md="5" class="p-0">
              <b-card :title="$t('withdraw')">
                <b-form>
                  
                  <b-form-group
                    id="input-group-2"
                    :label="'USDT '+$t('balance')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="point1"
                      type="text"
                      readonly
                      required
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    id="input-group-2"
                    :label="$t('address')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="address"
                      type="text"
                      required
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    id="input-group-2"
                    :label="$t('amount')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="amount"
                      type="number"
                      min="10"
                      required
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('fees') + '(USDT)'"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="fees"
                      type="text"
                      readonly
                      required
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    id="input-group-2"
                    :label="$t('reached_amount') + '(USDT)'"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      :value="amount == ''?0:amount-fees"
                      type="text"
                      readonly
                      required
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    id="input-group-2"
                    :label="$t('username')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="username"
                      type="text"
                      readonly
                      required
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    id="input-group-2"
                    :label="$t('vcode')"
                    label-for="input-2"
                  >
                    
                  </b-form-group>

                  <b-input-group>
                  <b-form-input
                    class="form-control mb-3 form-custom-prepend"
                    label="text"
                    type="number"
                    v-model="otp"
                    required
                  >
                  </b-form-input>

                  <b-input-group-append
                    class="form-custom-append"
                    style="position: relative"
                  >
                    <b-button
                      variant="light"
                      style="
                        border-bottom-right-radius: 0.5rem !important;
                        border-top-right-radius: 0.5rem !important;
                      "
                      :disabled="startCount || sending"
                      @click="getOTP"
                    >
                      <span v-if="!sending">{{ $t("get_vcode") }}</span
                      ><span v-else class="text-white">{{ $t("loading...") }}</span>
                    </b-button>
                    <div v-if="startCount" class="text-center py-2 overlay-text">
                      {{ timecount }} s
                    </div>
                  </b-input-group-append>
                </b-input-group>

                  <b-form-group
                    id="input-group-2"
                    :label="$t('sec_password')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="sec_password"
                      type="password"
                      required
                    ></b-form-input>
                  </b-form-group>

                  <b-button block type="submit" variant="primary">{{
                    $t("submit")
                  }}</b-button>
                </b-form>
              </b-card>
            </b-col>
          </b-row>
      </b-tabs>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  getMemberInfo,
  requestOTP,
  checkOTP,
  withdraw,
  getDownloadLink,
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
        fees: "",
        reachedAmount: "",
        point1: "",
        username: "",
        otp: "",
        amount: "",
        address: "",
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
      var result = getMemberInfo();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.isLoading = false;
          self.point1 = value.data.point1;
          self.username = value.data.email;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    getFees() {
      var result = getDownloadLink();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.isLoading = false;
          self.fees = value.data.data.system.WITHDRAW_FEE;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
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
      formData.append("address", this.address);
      formData.append("amount", this.amount);
      formData.append("sec_password", this.sec_password);
      var result = withdraw(formData);
      self.isLoading = true;

      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.otp='';
            self.address='';
            self.amount='';
            self.sec_password='';
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
    loadItems() {},
  },
  created() {
    this.loadItems();
    this.warningPopup();
    this.getInfo();
    this.getFees();
    this.username = localStorage.getItem("username");
  },
};
</script>