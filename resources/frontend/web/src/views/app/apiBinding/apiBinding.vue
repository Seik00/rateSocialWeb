<template>
  <div class="main-content">
    <div style="position: relative" class="text-center">
      <b-row align-h="center">
        <b-col  cols="6">
          <b-button class="p-0 border-0" @click="openOtp('binance')">
            <b-card>
              <img :src="'https://atozbot.live/images/coin/BNB.png'" />
              <div class="mt-2">
                <span class="mt-4 font-weight-bold text-20"> Binance</span>
              </div>
            </b-card>
          </b-button>
        </b-col>
        <b-col  cols="6">
          <b-button class="p-0 border-0" @click="openOtp('huobi')">
            <b-card>
              <img :src="'https://atozbot.live/images/coin/HT.png'" />
              <div class="mt-2">
                <span class="font-weight-bold text-20"> Huobi</span>
              </div>
            </b-card>
          </b-button></b-col
        >
      </b-row>
    </div>
    <b-modal
      id="modal-otp"
      size="md"
      centered
      :title="$t('get_vcode')"
      :hide-footer="true"
      style="background-color: #5f646e !important"
      :no-close-on-backdrop="true"
      :no-close-on-esc="true"
    >
      <b-form class="mx-5" @submit.prevent="sendOTP">
        <b-row align-h="center">
          <b-col md="12 mb-30">
            <b-input-group>
              <b-form-input
                class="form-control mb-3"
                label="text"
                type="text"
                v-model="email"
                readonly
              >
              </b-form-input>
            </b-input-group>
            <b-input-group>
              <b-form-input
                class="form-control mb-3 form-custom-prepend"
                label="text"
                type="number"
                v-model="otp"
                :placeholder="$t('vcode')"
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
                    height: 100%;
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

            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="mt-4 float-right">
                  <b-button
                    type="submit"
                    class="m-1"
                    variant="outline-secondary"
                    style="background-color: #02daaf !important"
                    :disabled="isLoading"
                    >{{ $t("submit") }}</b-button
                  >
                </div>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>

    <b-modal
      id="modal-binding"
      size="md"
      centered
      :title="$t('api_binding')"
      :hide-footer="true"
      style="background-color: #5f646e !important"
      :no-close-on-backdrop="true"
      :no-close-on-esc="true"
    >
      <b-form
        v-if="canBind"
        class="mx-5"
        @submit.prevent="bindAPI"
      >
        <b-row align-h="center">
          <b-col md="12 mb-30">
            <b-form-group
              id="input-group-2"
              :label="$t('api_key')"
              label-for="input-2"
            >
              <b-form-input v-model="api_key" type="text" required></b-form-input>
            </b-form-group>
            <b-form-group
              id="input-group-2"
              :label="$t('secret_key')"
              label-for="input-2"
            >
              <b-form-input v-model="secret_key" type="text" required></b-form-input>
            </b-form-group>
            <b-form-group
              id="input-group-2"
              :label="$t('sec_password')"
              label-for="input-2"
            >
              <b-form-input
                v-model="sec_password"
                type="password"
                required
              ></b-form-input>
            </b-form-group>

            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="mt-4 float-right">
                  <b-button
                    type="submit"
                    class="m-1"
                    variant="outline-secondary"
                    style="background-color: #02daaf !important"
                    :disabled="isLoading"
                    >{{ $t("submit") }}</b-button
                  >
                </div>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-form>
      <b-form v-else class="mx-5" @submit.prevent="unbindAPI">
        <b-row align-h="center">
          <b-col md="12 mb-30">
            <b-form-group
              id="input-group-2"
              :label="$t('api_key')"
              label-for="input-2"
            >
              <b-form-input v-model="api_key" type="text"></b-form-input>
            </b-form-group>
            <b-form-group
              id="input-group-2"
              :label="$t('secret_key')"
              label-for="input-2"
            >
              <b-form-input v-model="secret_key" type="text"></b-form-input>
            </b-form-group>
            <b-form-group
              id="input-group-2"
              :label="$t('sec_password')"
              label-for="input-2"
            >
              <b-form-input
                v-model="sec_password"
                type="password"
                required
              ></b-form-input>
            </b-form-group>

            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="mt-4 float-right">
                  <b-button
                    type="submit"
                    class="m-1"
                    variant="outline-secondary"
                    style="background-color: #02daaf !important"
                    :disabled="isLoading"
                    >{{ $t("unbind") }}</b-button
                  >
                </div>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  requestOTP,
  checkOTP,
  addAPI,
  getAPI,
  removeAPI,
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
      robotList: [],
      otp: "",
      email: "",
      timecount: 60,
      startCount: false,
      myVar: null,
      sending: false,
      platform: "",
      api_key: null,
      secret_key: null,
      sec_password: "",
      isLoading: false,
      canBind: true,
    };
  },
  props: ["success"],
  methods: {
    openOtp(p) {
      this.platform = p;
      this.$bvModal.show("modal-otp");
      this.getInfo();
    },
    getInfo() {
      let formData = new FormData();
      var self = this;
      formData.append("platform", this.platform);
      var result = getAPI(formData);

      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.error_code == 0 && value.data.data != null) {
            self.api_key = value.data.data.api_key;
            self.secret_key = value.data.data.secret_key;
          }

          if (self.api_key == null && self.secret_key == null) {
            self.canBind = true;
          }else{
            self.canBind = false;

          }
          self.sending = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.sending = false;
        });
    },
    bindAPI() {
      let formData = new FormData();
      var self = this;
      formData.append("platform", this.platform);
      formData.append("api_key", this.api_key);
      formData.append("secret_key", this.secret_key);
      formData.append("sec_password", this.sec_password);
      var result = addAPI(formData);
      self.isLoading = true;

      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.$bvModal.hide("modal-binding");
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
    unbindAPI() {
      let formData = new FormData();
      var self = this;
      formData.append("platform", this.platform);
      formData.append("sec_password", this.sec_password);
      var result = removeAPI(formData);
      this.isLoading = true;

      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.$bvModal.hide("modal-binding");
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
            self.$bvModal.hide("modal-otp");
            self.$bvModal.show("modal-binding");
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
      if (this.email == "") {
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
    this.email = localStorage.getItem("username");
  },
};
</script>

<style>
#fileName span {
  white-space: nowrap;
  overflow: hidden;
  display: inline-block;
}
#fileName span:first-child {
  width: 60px;
  text-overflow: ellipsis;
}
#fileName span + span {
  width: 34px;
  direction: rtl;
  text-align: right;
  /* text-overflow: ellipsis; */
}

.upload-hint {
  position: absolute;
  width: 100%;
  height: 100%;
  border-style: dotted;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.hiddenClass {
  pointer-events: none;
  display: none;
}

.addressWidth {
  max-width: 200px;
}

.txidWidth {
  max-width: 275px;
}

.overlay-text {
  position: absolute;
  z-index: 2;
  height: 100%;
  width: 100%;
  color: #000;
  font-weight: 700;
  line-height: 1.5;
}



.form-custom-prepend {
  background-color: transparent !important;
  height: calc(2.5rem + 2px) !important;
}
</style>