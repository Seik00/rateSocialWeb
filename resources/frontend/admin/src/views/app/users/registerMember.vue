<template>
  <div class="main-content">
    <breadcumb :page="$t('registerMember')" :folder="$t('userManage')" />
    <b-card :title="$t('registerMember')">
      <b-row align-h="center">
        <b-col md="8 mb-30">
          <b-form v-on:submit.prevent="register_member">
            <!-- <div class="form-group row">
              <label for="username2" class="col-sm-2 col-form-label">{{
                $t("username")
              }}</label>
              <div class="col-sm-10">
                <input
                  type="text"
                  class="form-control"
                  id="username"
                  v-model="username"
                />
              </div>
            </div> -->
            <div class="form-group row">
              <label for="email" class="col-sm-2 col-form-label">{{
                $t("email")
              }}</label>
              <div class="col-sm-10">
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  v-model="email"
                  required
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="country" class="col-sm-2 col-form-label">{{
                $t("country")
              }}</label>
              <div class="col-sm-10">
                <b-form-select
                  v-model="country"
                  :options="countryOptions"
                  id="country"
                >
                </b-form-select>
              </div>
            </div>
            <div class="form-group row">
              <label for="package" class="col-sm-2 col-form-label">{{
                $t("package")
              }}</label>
              <div class="col-sm-10">
                <b-form-select
                  v-model="packageType"
                  :options="selectOptions"
                  id="package"
                >
                </b-form-select>
              </div>
            </div>
            <div class="form-group row">
              <label for="ref_id" class="col-sm-2 col-form-label">{{
                $t("password")
              }}</label>
              <div class="col-sm-10">
                <b-form-input
                  class="form-control"
                  label="Name"
                  type="password"
                  v-model.trim="password"
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
              </div>
            </div>
            <div class="form-group row">
              <label for="ref_id" class="col-sm-2 col-form-label">{{
                $t("repeatPassword")
              }}</label>
              <div class="col-sm-10">
                <b-form-input
                  class="form-control"
                  label="Name"
                  type="password"
                  v-model.trim="$v.repeatPassword.$model"
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
              </div>
            </div>
            <div class="form-group row">
              <label for="ref_id" class="col-sm-2 col-form-label">{{
                $t("ref_id")
              }}</label>
              <div class="col-sm-10">
                <input
                  class="form-control"
                  label="ref_id"
                  v-model="refID"
                  required
                />
              </div>
            </div>
            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="mt-4 float-right">
                  <b-button type="submit" class="m-1" variant="primary">{{
                    $t("signUp")
                  }}</b-button>
                </div>
              </div>
            </div>
          </b-form>
        </b-col>
      </b-row>
    </b-card>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { registerMember, country_list } from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { handleError } from "../../../system/handleRes";
import { required, sameAs, minLength } from "vuelidate/lib/validators";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
    selectOptions() {
      return [{ value: "1", text: this.$t("huiyuan") }];
    },
  },
  components: {
    Dialog,
  },
  data() {
    return {
      username: "",
      contact_number: "",
      country_id: "",
      user_group_id: "",
      email: "",
      password: "",
      repeatPassword: "",
      refID: "",

      selectWalletType: "point1",

      isLoading: false,
      packageType: "1",
      country: null,
      countryList: [],
      countryOptions: [],
      package: [],
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
  },
  methods: {
    register_member() {
      // e.preventDefault();
      let formData = new FormData();
      formData.append("username", this.email);
      formData.append("country_id", this.country);
      formData.append("user_group", this.packageType);
      formData.append("email", this.email);
      formData.append("password", this.password);
      formData.append("password_confirmation", this.repeatPassword);
      formData.append("ref_id", this.refID);

      var result = registerMember(formData);
      var self = this;
      result
        .then(function (value) {
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t("successSubmit"));
            setTimeout(() => {
              self.$router.push("/manage/users/user");
            }, 500);
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          // self.makeToast("warning", error.response.statusText+", Please Login Again!");
          //   localStorage.removeItem("userToken");
          //   self.$router.push("/admin/sessions/signIn");
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
          self.countryList = value.data.data;
          self.country = value.data.data[0].id;
          for (let i = 0; i < value.data.data.length; i++) {
            var jsonObject = {};
            jsonObject["value"] = value.data.data[i].id;
            jsonObject["text"] =
              self.$i18n.locale == "en"
                ? value.data.data[i].name_en
                : value.data.data[i].name;
            self.countryOptions.push(jsonObject);
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          // localStorage.removeItem("userToken");
          // self.$router.push("/admin/sessions/signIn");
          // self.isLoading = false;
        });
    },
  },
  watch: {
    lang(val) {
      console.log(val);
      var self = this;
      self.countryOptions = [];
      for (let i = 0; i < self.countryList.length; i++) {
        var jsonContry = {};
        jsonContry["value"] = self.countryList[i].id;
        jsonContry["text"] =
          val == "en" ? self.countryList[i].name_en : self.countryList[i].name;
        self.countryOptions.push(jsonContry);
      }
    },
  },
  created() {
    this.getCountryList();
  },
};
</script>

<style>
.hiddenClass {
  pointer-events: none;
  display: none;
}

.bodyWidth {
  min-width: 120px;
}
</style>