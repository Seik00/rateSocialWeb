<template>
  <!-- <div
    class="auth-layout-wrap"
    :style="{ backgroundImage: 'url(' + bgImage + ')' }"
  > -->
  <div class="auth-layout-wrap" style="background: #484d54">
    <div class="auth-content">
      <div class="row justify-content-center rowAdjust">
        <div class="col-md-7 col-sm-12 colAdjust">
          <div
            class="card o-hidden cardHeight"
            style="background-color: rgb(33, 38, 48); color: #fff"
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
                  border: 3px #484d54 solid;
                  border-radius: 0.75rem !important;
                "
              />
            </div>
            <div class="p-4">
              <h1 class="mb-3 text-24 text-white">{{ $t("signUp") }}</h1>
              <b-form @submit.prevent="submit">
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
                      variant="muted"
                      style="
                        height: 100%;
                        border-bottom-right-radius: 0.5rem !important;
                        border-top-right-radius: 0.5rem !important;
                      "
                      :disabled="startCount"
                      @click="getOTP"
                    >
                      {{ $t("getCode") }}
                    </b-button>
                    <div
                      v-if="startCount"
                      class="text-center py-2 overlay-text"
                    >
                      {{ timecount }} s
                    </div>
                  </b-input-group-append>
                </b-input-group>
                <b-button
                  type="submit"
                  block
                  variant="outline-secondary"
                  style="background-color: #faee1c !important"
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
    <Dialog ref="msg"></Dialog>
  </div>
</template>
<script>
import { country_list, signUp } from "../../../system/api/api";
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
      bgImage: require("../../../assets/images/photo-wide-4.jpg"),
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
      timecount: 5,
      startCount: false,
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
            self.$refs.msg.makeToast("success", value.data.message);
            setTimeout(() => {
              window.location.href = location.origin;
            }, 2000);
          } else {
            self.$refs.msg.makeToast("danger", value.data.message);
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

    getOTP() {
      var myVar;

      this.startCount = true;
      myVar = setInterval(() => {
        this.timecount -= 1;
        if (this.timecount == 0) {
          clearInterval(myVar);
          this.startCount = false;
        }
      }, 1000);
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
  background-color: #5f646e !important;
  border: 3px #484d54 solid;
  color: #fff;
  border-radius: 0.75rem !important;
  height: calc(2.5rem + 2px);
}

.form-custom-prepend {
  background-color: #5f646e !important;
  border: 3px #484d54 solid;
  color: #fff;
  border-bottom-left-radius: 0.75rem !important;
  border-top-left-radius: 0.75rem !important;
  height: calc(2.5rem + 2px);
}

.form-custom-append {
  /* background-color: #5f646e !important; */
  border: 3px #484d54 solid;
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


