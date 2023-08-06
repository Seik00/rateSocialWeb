<template>
  <div
    class="auth-layout-wrap"
    :style="{ backgroundImage: 'url(' + bgImage + ')' }"
  >
    <div class="auth-content">
      <div class="row justify-content-center rowAdjust">
        <div class="col-md-7 col-sm-12 colAdjust">
          <div
            class="card o-hidden cardHeight"
            style="background-color: #001347; color: #fff"
          >
            <b-dropdown
              id="dropdown-1"
              toggle-class="text-decoration-none"
              variant="link"
              no-caret
              style="margin-left: auto !important"
            >
              <template slot="button-content">
                <div
                  class="btn dropdown-toggle nav-item"
                  style="padding-right: 25px !important; color: #fff"
                >
                  <span>{{ $t("language") }}</span>
                </div>
              </template>

              <b-dropdown-item
                class="dropdown-menu-right"
                @click="changeLang('en')"
              >
                <i class="header-icon"><flag iso="US" /></i>

                English
              </b-dropdown-item>

              <b-dropdown-item
                class="dropdown-menu-right"
                @click="changeLang('zh')"
              >
                <i class="header-icon"><flag iso="CN" /></i>

                中文
              </b-dropdown-item>
            </b-dropdown>
            <div class="auth-logo text-center">
              <img
                :src="logo"
                style="
                  height: auto !important;
                "
              />
            </div>
            <div class="p-4">
              <h1 class="mb-3 text-24 text-white">{{ $t("signUp") }}</h1>
              <b-form @submit.prevent="checkOTP">
                <!-- <b-form-group :label="$t('username')">
                  <b-form-input
                    class="form-control"
                    label="Name"
                    v-model="username"
                    required
                    style="
                      background-color: #5f646e !important;
                      border: 3px #484d54 solid;
                      color: #fff;
                    "
                  >
                  </b-form-input>
                </b-form-group> -->

                <b-form-select
                  v-model="country"
                  class="form-control mb-3"
                  :value="country"
                  :options="countryOptions"
                  @change="updateCode"
                  id="country"
                  required
                  style="
                    border-radius: 0.75rem !important;
                    height: calc(2.5rem + 2px);
                    background-color: transparent !important;
                    border: 3px #02daaf solid;
                    color: #fff;
                  "
                >
                </b-form-select>

                <b-input-group>
                  <b-form-input
                    class="form-control mb-3 form-custom-prepend"
                    label="email"
                    v-model="email"
                    type="email"
                    :placeholder="$t('email')"
                    required
                  >
                  </b-form-input>
                  <b-input-group-append
                    class="form-custom-append"
                    style="position: relative"
                  >
                    <b-button
                      style="
                        height: 100%;
                        border-bottom-right-radius: 0.5rem !important;
                        border-top-right-radius: 0.5rem !important;
                      "
                      :disabled="startCount || sending"
                      @click="getOTP"
                    >
                      <span v-if="!sending">{{ $t("getCode") }}</span
                      ><span v-else class="">{{
                        $t("loading...")
                      }}</span>
                    </b-button>
                    <div
                      v-if="startCount"
                      class="text-center py-2 overlay-text"
                    >
                      {{ timecount }} s
                    </div>
                  </b-input-group-append>
                </b-input-group>

                <!-- <b-form-group :label="$t('mobile')">
                  <b-input-group :prepend="countryCode">
                    <b-form-input
                      class="form-control"
                      label="Name"
                      type="number"
                      v-model="mobile"
                      required
                      style="
                        background-color: #5f646e !important;
                        border: 3px #484d54 solid;
                        color: #fff;
                      "
                    >
                    </b-form-input>
                  </b-input-group>
                </b-form-group> -->

                <b-form-input
                  class="form-control mb-3 form-custom"
                  label="text"
                  v-model="otp"
                  type="text"
                  :placeholder="$t('otp')"
                  required
                >
                </b-form-input>

                <b-form-input
                  class="form-control mb-3 form-custom"
                  label="Name"
                  type="password"
                  v-model.trim="password"
                  :placeholder="$t('password')"
                  required
                >
                </b-form-input>

                <b-alert
                  show
                  variant="danger"
                  class="error col mt-1"
                  v-if="!$v.password.minLength"
                  >{{ $t("min") }} {{ $v.password.$params.minLength.min }}
                  {{ $t("character") }}</b-alert
                >

                <b-form-input
                  class="form-control mb-3 form-custom"
                  label="Name"
                  type="password"
                  v-model.trim="$v.repeatPassword.$model"
                  :placeholder="$t('repeatPassword')"
                  required
                >
                </b-form-input>

                <b-alert
                  show
                  variant="danger"
                  class="error col mt-1"
                  v-if="!$v.repeatPassword.sameAsPassword"
                  >{{ $t("passwordNotMatch") }}</b-alert
                >

                <b-form-input
                  class="form-control mb-3 form-custom"
                  label="ref_id"
                  v-model="refID"
                  :placeholder="$t('ref_id')"
                  required
                >
                </b-form-input>
                <b-button
                  type="submit"
                  block
                  variant="outline-secondary"
                  style="background-color: #02daaf !important"
                  :disabled="submitStatus === 'PENDING' || $v.$invalid"
                  >{{ $t("signUp") }}</b-button
                >

                <p v-once class="typo__p" v-if="submitStatus === 'OK'">
                  {{ makeToastTwo("success") }}
                  {{ this.$router.push("/") }}
                </p>
                <p v-once class="typo__p" v-if="submitStatus === 'ERROR'">
                  {{ makeToast("danger") }}
                </p>
                <div v-once class="typo__p" v-if="submitStatus === 'PENDING'">
                  <div class="spinner sm spinner-primary mt-3"></div>
                </div>
              </b-form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <b-modal
      id="modal-1"
      size="md"
      centered
      :title="$t('updatePwd')"
      :hide-footer="true"
      :hide-header="true"
      style="background-color: #5f646e !important"
    >
      <h4 class="text-center text-white">
        {{ this.$t("modalHeader") }}
      </h4>
      <p v-if="startCount" class="text-center" style="color: #faee1c">
        {{ $t("emailNotice") }}{{ this.email }}
      </p>
      <b-form class="mx-5" v-on:submit.prevent="checkOTP">
        <b-row align-h="center">
          <b-col md="12 mb-30">
            <b-input-group>
              <b-form-input
                class="form-control mb-3 form-custom-prepend"
                label="text"
                v-model="otp"
                type="text"
                :placeholder="$t('otp')"
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
    <Dialog ref="msg"></Dialog>
  </div>
</template>
<script>
import {
  country_list,
  signUp,
  sendOtp,
  checkotp,
} from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { handleError } from "../../../system/handleRes";
import { required, sameAs, minLength } from "vuelidate/lib/validators";
import { mapGetters, mapActions } from "vuex";
export default {
  metaInfo: {
    // if no subcomponents specify a metaInfo.title, this title will be used
    title: "SignUp",
  },
  components: {
    Dialog,
  },

  data() {
    return {
      username: "",
      email: "",
      bgImage: require("../../../assets/images/bg.jpg"),
      logo: require("../../../assets/images/logo.png"),
      signInImage: require("../../../assets/images/photo-long-3.jpg"),
      password: "",
      repeatPassword: "",
      submitStatus: null,
      mobile: "",
      country: null,
      countryCode: "",
      countryOptions: [],
      rows: [],
      refID: "",
      otp: "",
      timecount: 60,
      startCount: false,
      myVar: null,
      sending: false,
    };
  },

  validations: {
    password: {
      required,
      minLength: minLength(5),
    },
    repeatPassword: {
      sameAsPassword: sameAs("password"),
    },

    // add input
    // peopleAdd: {
    //   required,
    //   minLength: minLength(3),
    //   $each: {
    //     multipleName: {
    //       required,
    //       minLength: minLength(5)
    //     }
    //   }
    // },
    // validationsGroup:['peopleAdd.multipleName']
  },

  computed: {
    ...mapGetters(["loggedInUser", "loading", "error", "lang"]),
  },

  methods: {
    ...mapActions(["changeLan"]),
    //   validate form
    changeLang(lang) {
      this.$i18n.locale = lang;
      this.changeLan(lang);
    },
    otpModal() {
      this.$bvModal.show("modal-1");
    },

    cancelOtp() {
      this.$bvModal.hide("modal-1");
      this.startCount = false;
      this.timecount = 60;
      this.otp = "";
      clearInterval(this.myVar);
    },

    checkOTP() {
      var result = checkotp(this.email, this.otp);
      var self = this;

      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.code == 0) {
            self.submit();
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
      if (this.email == "") {
        this.$refs.msg.makeToast("danger", this.$t("emailEmpty"));
      } else {
        this.sending = true;
        let formData = new FormData();
        formData.append("email", this.email);
        formData.append("country_id", this.country);
        formData.append("lang", this.$i18n.locale == "en" ? "en" : "cn");
        var result = sendOtp(formData);
        var self = this;

        result
          .then(function (value) {
            console.log(value.data);
            if (value.data.code == 0) {
              self.$refs.msg.makeToast("success", self.$t("emailNotice")+self.email);
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
    submit() {
      let formData = new FormData();
      formData.append("username", this.email);
      formData.append("email", this.email);
      formData.append("country_id", this.country);
      // formData.append("contact_number", this.mobile);
      formData.append("password", this.password);
      formData.append("password_confirmation", this.repeatPassword);
      formData.append("ref_id", this.refID);

      var result = signUp(formData);
      var self = this;
      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t("registerSuccess"));
            self.$bvModal.hide("modal-1");
            setTimeout(() => {
              window.location.href = location.origin;
            }, 2000);
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },

    updateCode() {
      // this.countryCode = code;
      console.log(this.country);
      this.rows.forEach((item) => {
        if (this.country == item.id) {
          this.countryCode = item.country_code;
        }
      });
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
          self.countryCode = value.data.data[0].country_code;
          for (let i = 0; i < value.data.data.length; i++) {
            var jsonObject = {};
            jsonObject["value"] = value.data.data[i].id;
            jsonObject["text"] =
              self.$i18n.locale == "en"
                ? value.data.data[i].name_en
                : value.data.data[i].name;
            self.countryOptions.push(jsonObject);
            self.rows = value.data.data;
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    makeToast(variant = null) {
      this.$bvToast.toast("Please fill the form correctly.", {
        title: `Variant ${variant || "default"}`,
        variant: variant,
        solid: true,
      });
    },
    makeToastTwo(variant = null) {
      this.$bvToast.toast("Successfully Created Account", {
        title: `Variant ${variant || "default"}`,
        variant: variant,
        solid: true,
      });
    },

    inputSubmit() {
      console.log("submitted");
    },
  },

  created() {
    var url_string = window.location.href;
    var url = new URL(url_string);
    this.refID = url.searchParams.get("ref_id");
    this.getCountryList();
  },

  watch: {
    lang(val) {
      console.log(val);
      var self = this;
      self.countryOptions = [];
      for (let i = 0; i < self.rows.length; i++) {
        var jsonPackageEn = {};
        jsonPackageEn["value"] = self.rows[i].id;
        jsonPackageEn["text"] =
          val == "en" ? self.rows[i].name_en : self.rows[i].name;
        self.countryOptions.push(jsonPackageEn);
      }
    },
  },
};
</script>
<style>
.modal-header,
.modal-body,
.modal-content {
  background-color: rgb(33, 38, 48);
  color: #fff;
}
select,
input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
  /* border-color: #fff; */
  color: #fff;
}
.spinner.sm {
  height: 2em;
  width: 2em;
}

.overlay-text {
  position: absolute;
  z-index: 2;
  height: 100%;
  width: 100%;
  color: #fff;
  font-weight: 700;
  line-height: 1.5;
}

.form-custom {
  background-color: transparent !important;
  border: 3px #02daaf solid;
  color: #fff;
  border-radius: 0.75rem !important;
  height: calc(2.5rem + 2px);
}

.form-custom-prepend {
  background-color: transparent !important;
  border: 3px #02daaf solid;
  color: #fff;
  border-bottom-left-radius: 0.75rem !important;
  border-top-left-radius: 0.75rem !important;
  height: calc(2.5rem + 2px) !important;
}

.form-custom-append {
  /* background-color: #5f646e !important; */
  border: 3px #02daaf solid;
  color: #fff;
  border-bottom-right-radius: 0.75rem !important;
  border-top-right-radius: 0.75rem !important;
  height: calc(2.5rem + 2px);
}

@media screen and (max-width: 600px) {
  .colAdjust {
    padding: 0px;
  }

  .rowAdjust {
    margin: 0px;
  }

  .cardHeight {
    min-height: 100vh;
  }

  .auth-content {
    width: 100%;
    padding: 0px !important;
  }
}
</style>


