<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
      <span>{{ $t("forget_password") }}</span>
    </div>
    <b-form @submit.prevent="submitForm">
      <div class="mainpage">
        <!-- <b-form-group class="form-customize" :label="$t('username')" label-for="input-2">
          <b-form-input class="form-custom" v-model="username" type="text" required></b-form-input>
          
        </b-form-group> -->
        
        <!-- <b-form-group class="form-customize" :label="$t('country')" label-for="input-2">
          <b-input-group>
            <div class="form-control form-custom py-1" @click="openCountry()" id="demo">
              {{ $t("country") }}
            </div>
          </b-input-group>
        </b-form-group> -->
        <b-form-group class="form-customize" :label="$t('username')" label-for="input-2">
          <b-input-group>
            <b-form-input class="form-custom" v-model="username" type="text" required></b-form-input>
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

        <b-form-group class="form-customize" :label="$t('vcode')" label-for="input-2">
          <b-form-input class="form-custom" type="number" v-model="otp" required> </b-form-input>
        </b-form-group>

        <b-form-group class="form-customize" :label="$t('new_password')" label-for="input-2">
          <b-form-input class="form-custom" v-model="password" type="password" required></b-form-input>
        </b-form-group>

        <b-button class="mx-auto submit_button" style="margin-top: 20vh" variant="outline-secondary" type="submit">{{
          isLoading ? $t("loading...") : $t("submit") }}</b-button>
      </div>
    </b-form>
    <b-modal id="modal-otp" size="md" centered :title="$t('country')" :hide-footer="true"
      style="background-color: white !important">
      <b-container class="bv-example-row">
        <b-row @click="selectCountry(1, $t('india'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="IN" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("india") }}</b-col>
          <b-col cols="2" class="middle">+91</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(12, $t('aus'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="AU" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("aus") }}</b-col>
          <b-col cols="2" class="middle">+61</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(195, $t('uk'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="GB" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("uk") }}</b-col>
          <b-col cols="2" class="middle">+44</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(2, $t('malaysia'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="MY" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("malaysia") }}</b-col>
          <b-col cols="2" class="middle">+60</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(28, $t('brunei'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="BN" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("brunei") }}</b-col>
          <b-col cols="2" class="middle">+673</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(3, $t('china'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="CN" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("china") }}</b-col>
          <b-col cols="2" class="middle">+86</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(83, $t('indonesia'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="ID" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("indonesia") }}</b-col>
          <b-col cols="2" class="middle">+62</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(90, $t('japan'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="JP" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("japan") }}</b-col>
          <b-col cols="2" class="middle">+81</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(96, $t('korea_south'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="KR" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("korea_south") }}</b-col>
          <b-col cols="2" class="middle">+82</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(145, $t('philippines'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="PH" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("philippines") }}</b-col>
          <b-col cols="2" class="middle">+63</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(4, $t('singapore'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="SG" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("singapore") }}</b-col>
          <b-col cols="2" class="middle">+65</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(169, $t('south_africa'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="ZA" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("south_africa") }}</b-col>
          <b-col cols="2" class="middle">+27</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(180, $t('taiwan'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="TW" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("taiwan") }}</b-col>
          <b-col cols="2" class="middle">+886</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(193, $t('ukraine'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="UA" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("ukraine") }}</b-col>
          <b-col cols="2" class="middle">+380</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(69, $t('germany'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="DE" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("germany") }}</b-col>
          <b-col cols="2" class="middle">+49</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(65, $t('france'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="FR" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("france") }}</b-col>
          <b-col cols="2" class="middle">+33</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(86, $t('ireland'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="IE" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("ireland") }}</b-col>
          <b-col cols="2" class="middle">+353</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(150, $t('russia'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="RU" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("russia") }}</b-col>
          <b-col cols="2" class="middle">+7</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(35, $t('canada'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="CA" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("canada") }}</b-col>
          <b-col cols="2" class="middle">+1</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(207, $t('us'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="US" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("us") }}</b-col>
          <b-col cols="2" class="middle">+1</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(13, $t('austria'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="AT" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("austria") }}</b-col>
          <b-col cols="2" class="middle">+43</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(81, $t('hungary'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="HU" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("hungary") }}</b-col>
          <b-col cols="2" class="middle">+36</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(178, $t('switzerland'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="CH" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("switzerland") }}</b-col>
          <b-col cols="2" class="middle">+41</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(20, $t('belgium'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="BE" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("belgium") }}</b-col>
          <b-col cols="2" class="middle">+32</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(101, $t('latvia'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="LV" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("latvia") }}</b-col>
          <b-col cols="2" class="middle">+371</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(61, $t('estonia'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="EE" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("estonia") }}</b-col>
          <b-col cols="2" class="middle">+372</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(51, $t('denmark'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="DK" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("denmark") }}</b-col>
          <b-col cols="2" class="middle">+45</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(130, $t('netherlands'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="NL" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("netherlands") }}</b-col>
          <b-col cols="2" class="middle">+31</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(172, $t('spain'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="ES" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("spain") }}</b-col>
          <b-col cols="2" class="middle">+34</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(27, $t('brazil'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="BR" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("brazil") }}</b-col>
          <b-col cols="2" class="middle">+55</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(149, $t('romania'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="RO" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("romania") }}</b-col>
          <b-col cols="2" class="middle">+40</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(88, $t('italy'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="IT" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("italy") }}</b-col>
          <b-col cols="2" class="middle">+39</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(122, $t('monaco'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="MC" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("monaco") }}</b-col>
          <b-col cols="2" class="middle">+377</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(29, $t('bulgaria'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="BG" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("bulgaria") }}</b-col>
          <b-col cols="2" class="middle">+359</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(163, $t('albania'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="AL" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("albania") }}</b-col>
          <b-col cols="2" class="middle">+355</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(146, $t('poland'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="PL" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("poland") }}</b-col>
          <b-col cols="2" class="middle">+48</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(19, $t('belarus'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="BY" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("belarus") }}</b-col>
          <b-col cols="2" class="middle">+375</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(64, $t('finland'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="FI" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("finland") }}</b-col>
          <b-col cols="2" class="middle">+358</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(136, $t('norway'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="NO" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("norway") }}</b-col>
          <b-col cols="2" class="middle">+47</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(177, $t('sweden'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="SE" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("sweden") }}</b-col>
          <b-col cols="2" class="middle">+46</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(189, $t('turkey'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="TR" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("turkey") }}</b-col>
          <b-col cols="2" class="middle">+90</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="selectCountry(9, $t('argentina'))">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="AR" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t("argentina") }}</b-col>
          <b-col cols="2" class="middle">+54</b-col>
        </b-row>
      </b-container>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  country_list,
  sendOtp,
  checkOtpWithoutToken,
  forgetPassword,
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
      username: "",
      phone: "",
      country: "",
      otp: "",
      password: "",
      password_confirmation: "",
      timecount: 60,
      startCount: false,
      myVar: null,
      sending: false,
      isLoading: false,
      countryCode: "",
      countryOptions: [],
      country_id: "",
    };
  },
  props: ["success"],
  methods: {
    selectCountry(id, country_name) {
      this.country_id = id;
      document.getElementById("demo").innerHTML = country_name;
      this.$bvModal.hide("modal-otp");
      this.updateCode(id);
    },

    updateCode(id) {
      this.rows.forEach((item) => {
        if (id == item.id) {
          this.countryCode = item.country_code;
        }
      });
    },
    openCountry() {
      this.$bvModal.show("modal-otp");
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
          document.getElementById("demo").innerHTML =
            self.$i18n.locale == "en"
              ? value.data.data[0].name_en
              : value.data.data[0].name;
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
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
    },
    sendOTP() {
      var self = this;
      var result = checkOtpWithoutToken(this.phone, this.otp);
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
      formData.append("username", this.username);
      formData.append("password", this.password);
      var result = forgetPassword(formData);
      self.isLoading = true;

      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.otp = "";
            self.password = "";
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
      if (this.phone == "") {
        this.$refs.msg.makeToast("danger", this.$t("phoneEmpty"));
      } else {
        this.sending = true;
        this.isLoading = true;
        let formData = new FormData();
        var self = this;
        formData.append("country_id", this.country_id);
        formData.append("lang", this.$i18n.locale);
        formData.append("contact_number", this.phone);
        var result = sendOtp(formData);

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
  },
  created() {
    // this.getCountryList();
  },
};
</script>
<style>
.input-group {

  border-bottom: none;
  margin-bottom: 1.5rem !important;
}

i.header-icon-country {
  font-size: 20px;
}

.middle.col-7 {
  margin: auto;
}

.middle.col-2 {
  margin: auto;
  text-align: right;
}

hr.line {
  margin-top: 5px;
  margin-bottom: 5px;
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
</style>