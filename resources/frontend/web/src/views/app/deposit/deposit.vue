<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
      <span>{{ $t("deposit") }}</span>
      <!-- <a
        class="right-side"
        @click="checkType"
      >
        <i class="fa fa-history"></i>
      </a> -->
    </div>
    <div class="mainpage">
      <!-- <p class="mb-0">{{ $t("depositHint1") }}</p>
      <p class="mb-0">{{ $t("depositHint2") }}</p>
      <span class="text-danger">{{ $t("depositWarning") }}</span> -->
      <b-row align-h="between" class="mt-3 ">
       
        <b-col cols="12">
          <div class="tabContainer text-center" :class="{ active: selected == 0 }" @click="selectIndex(0)">
            <div class="tabImage">
              <img src="../../../assets/images/digital/Cjdowner-Cryptocurrency-Flat-Tether-USDT.svg" alt="">
            </div>
            <span>{{ $t("crypto") }}</span>
          </div>
        </b-col>
        <!-- <b-col cols="6" class="pr-0">
          <div class="tabContainer text-center" :class="{ active: selected == 1 }" @click="selectIndex(1)">
            <div class="tabImage">
              <img src="../../../assets/images/digital/surface1.svg" alt="">
            </div>
            <span>{{ $t("bank") }}</span>
          </div>
        </b-col> -->
      </b-row>
      <b-form @submit.prevent="uploadImageCoin" v-if="deposit_type == 'bank'">
        <!-- <b-form-group :label="$t('coinPair')" class="form-customize mt-3">
          <b-form-select v-model="coin" :options="coinOptions" id="coin">
          </b-form-select>
        </b-form-group> -->

        

        <b-form-group :label="$t('address')" class="form-customize mt-3">
          <b-input-group>
            <b-form-input class="form-control form-custom-prepend" v-model="newCoinAddress" type="text" readonly>
            </b-form-input>
            <b-input-group-append class="form-custom-append">
              <button class="my-auto mx-2" type="button" v-clipboard="() => newCoinAddress"
                v-clipboard:success="clipboardSuccessHandler" v-clipboard:error="clipboardErrorHandler">
                <span>{{ $t("copy") }}</span>
              </button>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>

        <b-form-group
          :label="$t('coinPair')"
          class="form-customize mt-3"
        >
          <b-input-group>
            <b-form-input
              class="form-control form-custom"
              v-model="newCoinType"
              type="text"
              readonly
            >
            </b-form-input>
            <b-input-group-append class="form-custom-append">
            </b-input-group-append>
          </b-input-group>
        </b-form-group>

        <b-form-group label="TXID" class="form-customize mt-3">
          <b-input-group>
            <b-form-input class="form-control form-custom" v-model="tx_id" type="text">
            </b-form-input>
          </b-input-group>
        </b-form-group>

        <b-form-group :label="$t('depositAmount')" class="form-customize mt-3">
          <b-input-group>
            <b-form-input class="form-control form-custom" v-model="newAmount" type="number" required>
            </b-form-input>
            <b-input-group-append class="form-custom-append">
            </b-input-group-append>
          </b-input-group>
        </b-form-group>

        <b-form-group :label="$t('sec_password')" class="form-customize mt-3">
          <b-input-group>
            <b-form-input class="form-control form-custom" v-model="sec_pwd" type="password" required>
            </b-form-input>
          </b-input-group>
        </b-form-group>

        <input type="file" name="image" accept="image/*" style="display: none" @change="setImageCoin" ref="myBtn" />

        <div class="mx-auto upload-box mt-5" @click="myClickEvent">
          <div v-if="!imgSrcCoin" class="upload-hint" :class="{ active: showAlert }">
            <i class="fa fa-plus text-25"></i>
          </div>
          <img v-if="imgSrcCoin" :src="imgSrcCoin" style="width: auto; height: 100%; position: absolute; z-index: 2" />
        </div>
        <div class="text-danger text-center mb-4">
          <span>{{ $t("uploadDone") }}</span>
        </div>
        <p class="">{{ $t("depositHint3") }}</p>

        <b-button class="mx-auto submit_button mt-5" variant="outline-secondary" type="submit" :disabled="isLoading">{{
          isLoading ? $t("submitting") : $t("depositDone") }}</b-button>
      

        <!-- <b-button
          class="mx-auto submit_button mt-5"
          variant="outline-secondary"
          type="submit"
          :disabled="isLoading"
          >{{ isLoading ? $t("submitting") : $t("depositDone") }}</b-button
        > -->
      </b-form>
      <b-form @submit.prevent="uploadImage" v-else>
        <!-- <b-form-group :label="$t('country')" class="form-customize mt-3">
          <b-form-select
            v-model="country"
            :options="countryOptions"
            id="country"
          >
          </b-form-select>
        </b-form-group> -->

        <!-- <b-form-group :label="$t('country')" class="form-customize mt-3" v-if="$i18n.locale == 'zh'">
          <b-input-group>
            <b-form-input class="form-control form-custom-prepend" v-model="newCountryCN" type="text" required>
            </b-form-input>
          </b-input-group>
        </b-form-group>

        <b-form-group :label="$t('country')" class="form-customize mt-3" v-if="$i18n.locale == 'en'">
          <b-input-group>
            <b-form-input class="form-control form-custom-prepend" v-model="newCountryEN" type="text" required>
            </b-form-input>
          </b-input-group>
        </b-form-group> -->

        <b-form-group :label="$t('bank')" class="form-customize mt-3">
          <b-input-group>
            <b-form-input class="form-control form-custom-prepend" v-model="newBankName" type="text" readonly>
            </b-form-input>
            <b-input-group-append class="form-custom-append">
              <button class="my-auto mx-2" type="button" v-clipboard="() => newBankName"
                v-clipboard:success="clipboardSuccessHandler" v-clipboard:error="clipboardErrorHandler">
                <span>{{ $t("copy") }}</span>
              </button>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>

        <b-form-group :label="$t('bank_no')" class="form-customize mt-3">
          <b-input-group>
            <b-form-input class="form-control form-custom-prepend" v-model="newBankNumber" type="text" readonly>
            </b-form-input>
            <b-input-group-append class="form-custom-append">
              <button class="my-auto mx-2" type="button" v-clipboard="() => newBankNumber"
                v-clipboard:success="clipboardSuccessHandler" v-clipboard:error="clipboardErrorHandler">
                <span>{{ $t("copy") }}</span>
              </button>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>

        <b-form-group :label="$t('name')" class="form-customize mt-3">
          <b-input-group>
            <b-form-input class="form-control form-custom-prepend" v-model="newBankUser" type="text" readonly>
            </b-form-input>
            <b-input-group-append class="form-custom-append">
              <button class="my-auto mx-2" type="button" v-clipboard="() => newBankUser"
                v-clipboard:success="clipboardSuccessHandler" v-clipboard:error="clipboardErrorHandler">
                <span>{{ $t("copy") }}</span>
              </button>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>

        <b-form-group :label="$t('ref_no')" class="form-customize mt-3">
          <b-input-group>
            <b-form-input class="form-control form-custom-prepend" v-model="newSwiftCode" type="text" readonly>
            </b-form-input>
            <b-input-group-append class="form-custom-append">
              <button class="my-auto mx-2" type="button" v-clipboard="() => newSwiftCode"
                v-clipboard:success="clipboardSuccessHandler" v-clipboard:error="clipboardErrorHandler">
                <span>{{ $t("copy") }}</span>
              </button>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>

        <b-form-group :label="$t('depositAmount') + '(USD)'" class="form-customize mt-3">
          <b-input-group>
            <b-form-input class="form-control form-custom" v-model="newAmount" type="number" @input="changeRate">
            </b-form-input>
            <b-input-group-append class="form-custom-append">
            </b-input-group-append>
          </b-input-group>
        </b-form-group>

        <!-- <b-form-group
          :label="$t('depositAmount') + ' (' + pSymbol + ')'"
          class="form-customize mt-3"
        >
          <b-input-group>
            <b-form-input
              class="form-control form-custom"
              v-model="cPrice"
              type="number"
              readonly
            >
            </b-form-input>
            <b-input-group-append class="form-custom-append">
              <button
                class="my-auto mx-2"
                type="button"
                v-clipboard="() => cPrice"
                v-clipboard:success="clipboardSuccessHandler"
                v-clipboard:error="clipboardErrorHandler"
              >
                <span>{{ $t("copy") }}</span>
              </button>
            </b-input-group-append>
          </b-input-group>
        </b-form-group> -->

        <!-- <b-form-group :label="$t('payer')" class="form-customize mt-3">
          <b-input-group>
            <b-form-input
              class="form-control form-custom"
              v-model="bankUser"
              type="text"
              readonly
            >
            </b-form-input>
            <b-input-group-append class="form-custom-append">
            </b-input-group-append>
          </b-input-group>
        </b-form-group> -->

        <b-form-group :label="$t('sec_password')" class="form-customize mt-3">
          <b-input-group>
            <b-form-input class="form-control form-custom" v-model="sec_pwd" type="password" required>
            </b-form-input>
          </b-input-group>
        </b-form-group>

        <input type="file" name="image" accept="image/*" style="display: none" @change="setImage" ref="myBtn" />

        <div class="mx-auto upload-box mt-5" @click="myClickEvent">
          <div v-if="!imgSrc" class="upload-hint" :class="{ active: showAlert }">
            <i class="fa fa-plus text-25"></i>
          </div>
          <img v-if="imgSrc" :src="imgSrc" style="width: auto; height: 100%; position: absolute; z-index: 2" />
        </div>
        <div class="text-danger text-center mb-4">
          <span>{{ $t("uploadDone") }}</span>
        </div>
        <p class="">{{ $t("depositHint3") }}</p>

        <b-button class="mx-auto submit_button mt-5" variant="outline-secondary" type="submit" :disabled="isLoading">{{
          isLoading ? $t("submitting") : $t("depositDone") }}</b-button>
      </b-form>
      
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  getDepositBank,
  getDepositAddress,
  doDeposit,
  doDepositCoin,
  upload,
  getDownloadLink,
} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
    platformOptions() {
      return [
        { value: "binance", text: "Binance" },
        { value: "huobi", text: "Huobi" },
      ];
    },
  },
  components: {
    Dialog,
  },

  data() {
    return {
      deposit_type: "bank",
      newCountryCN: "",
      newCountryEN: "",
      newBankName: "",
      newBankNumber: "",
      newBankUser: "",
      newSwiftCode: "",
      newAmount: "",
      newCoinAddress: "",
      newCoinType: "TRC20",
      imgSrc: "",
      imgSrcCoin: "",
      selected: 0,
      bank: "",
      bankId: "",
      bankNo: "",
      bankRef: "",
      bankUser: "",
      bankRate: "",
      bankAmount: null,
      country: null,
      countryList: [],
      countryOptions: [],
      coin: null,
      coinList: [],
      coinOptions: [],
      image: null,
      imageId: null,
      imageCoin: null,
      imageIdCoin: null,
      showAlert: false,
      isLoading: false,
      tx_id: "",
      address: "",
      coinName: "",
      sec_pwd: "",
      cPrice: "",
      pSymbol: "",
    };
  },
  props: ["success"],
  methods: {
    checkType() {
      if (this.deposit_type == 'bank') {
        this.$router.push("/web/deposit/depositBankHistory");
      } else {
        this.$router.push("/web/deposit/depositHistory");
      }
    },
    clipboardSuccessHandler() {
      this.$refs.msg.makeToast("success", this.$t("copied"));
    },
    clipboardErrorHandler() { },
    selectIndex(i) {
      this.selected = i;
      this.deposit_type = this.selected == 0 ?'bank':'crypto';
      this.sec_pwd = "";
    },
    uploadImage() {
      if (this.image != null) {
        var self = this;
        console.log(this.image);
        let formData = new FormData();
        formData.append("file", this.image);
        var result = upload(formData);
        self.isLoading = true;

        result
          .then(function (value) {
            // if (value.data.error_code == 0) {
            self.imageId = value.data.data;
            self.ddepositBank();
          })
          .catch(function (error) {
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
            self.isLoading = false;
            self.sec_pwd = "";
          });
      } else {
        this.showAlert = true;
      }
    },
    uploadImageCoin() {
      if (this.imageCoin != null) {
        var self = this;
        let formData = new FormData();
        formData.append("file", this.imageCoin);
        var result = upload(formData);
        self.isLoading = true;

        result
          .then(function (value) {
            // if (value.data.error_code == 0) {
            self.imageIdCoin = value.data.data;
            self.ddepositCoin();
          })
          .catch(function (error) {
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
            self.isLoading = false;
            self.sec_pwd = "";
          });
      } else {
        this.showAlert = true;
      }
    },
    ddepositCoin() {
      let formData = new FormData();
      formData.append("amount", this.newAmount);
      formData.append("tx_id", this.tx_id);
      formData.append("address", this.newCoinAddress);
      formData.append("deposit_type", this.newCoinType);
      formData.append("sec_password", this.sec_pwd);
      formData.append("document", this.imageIdCoin);
      var self = this;
      self.isLoading = true;
      var result = doDepositCoin(formData);

      result
        .then(function (value) {
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            setTimeout(() => {
              var current = location.origin + "/";
              window.location.href = current + "web";
            }, 2000);
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.isLoading = false;
          self.sec_pwd = "";
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
          self.sec_pwd = "";
        });
    },
    ddepositBank() {
      // alert('789');
      let formData = new FormData();
      formData.append("amount", this.newAmount);
      formData.append("document", this.imageId);
      formData.append("system_bank_id", this.bankId.toString());
      formData.append("country_id", 207);
      formData.append("sec_password", this.sec_pwd);
      // formData.append("sec_password ", this.bankAmount);
      var result = doDeposit(formData);
      var self = this;
      self.isLoading = true;

      result
        .then(function (value) {
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            setTimeout(() => {
              var current = location.origin + "/";
              window.location.href = current + "web";
            }, 2000);
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.isLoading = false;
          self.sec_pwd = "";
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
          self.sec_pwd = "";
        });
    },
    getCoin() {
      var self = this;
      self.coinOptions = [];
      self.coinList = [];
      self.isLoading = true;
      var result = getDepositAddress();

      result
        .then(function (value) {
          if (value.data.error_code == 0) {
            self.coin = value.data.data[0].name;
            self.coinList = value.data.data;
            for (let i = 0; i < value.data.data.length; i++) {
              var jsonObject = {};
              jsonObject["value"] = value.data.data[i].name;
              jsonObject["text"] = value.data.data[i].name;
              self.coinOptions.push(jsonObject);
            }
          }
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
    },
    getBank() {
      var self = this;
      self.countryOptions = [];
      self.countryList = [];
      this.isLoading = true;
      var result = getDepositBank();
      result
        .then(function (value) {
          self.bankId = value.data.data[0].id;
          self.newBankName = value.data.data[0].bank_name;
          self.newBankNumber = value.data.data[0].bank_number;
          self.newBankUser = value.data.data[0].bank_user;
          self.newSwiftCode = value.data.data[0].swift_code;
          self.country = value.data.data[0].bank_country;
          self.bankRate = value.data.data[0].country.sell;
          self.pSymbol = value.data.data[0].country.short_form;
          self.countryList = value.data.data;
          for (let i = 0; i < value.data.data.length; i++) {
            var jsonObject = {};
            jsonObject["value"] = value.data.data[i].bank_country;
            jsonObject["text"] =
              self.$i18n.locale == "en"
                ? value.data.data[i].country.name_en
                : value.data.data[i].country.name;
            self.countryOptions.push(jsonObject);
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    // getAllowDeposit() {
    //   var self = this;
    //   self.countryOptions = [];
    //   self.countryList = [];
    //   this.isLoading = true;
    //   var result = checkAllowDeposit();
    //   result
    //     .then(function (value) {
    //       self.deposit_type = value.data.data.deposit_info.deposit_type;
    //       if (self.deposit_type == 'bank') {
    //         self.newCountryCN = value.data.data.deposit_info.bank_info.country.name;
    //         self.newCountryEN = value.data.data.deposit_info.bank_info.country.name_en;
    //         self.newBankName = value.data.data.deposit_info.bank_info.bank_name;
    //         self.newBankNumber = value.data.data.deposit_info.bank_info.bank_number;
    //         self.newBankUser = value.data.data.deposit_info.bank_info.bank_user;
    //         self.newSwiftCode = value.data.data.deposit_info.bank_info.swift_code;
    //         self.newAmount = value.data.data.deposit_info.amount;
    //       } else {
    //         console.log(value);
    //         self.newCoinAddress = value.data.data.deposit_info.address;
    //         self.newAmount = value.data.data.deposit_info.amount;
    //         self.newCoinType = value.data.data.deposit_info.deposit_type;
    //       }

    //     })
    //     .catch(function (error) {
    //       self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
    //     });
    // },
    changeRate() {
      var price = this.newAmount * this.bankRate;
      this.cPrice = price.toString();
    },
    myClickEvent() {
      const elem = this.$refs.myBtn;
      elem.click();
    },
    setImage(e) {
      const file = e.target.files[0];
      this.image = file;
      if (!file.type.includes("image/")) {
        alert("Please select an image file"); 
        return;
      }
      if (typeof FileReader === "function") {
        const reader = new FileReader();
        reader.onload = (event) => {
          this.imgSrc = event.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        alert("Sorry, FileReader API not supported");
      }
    },
    setImageCoin(e) {
      const file = e.target.files[0];
      this.imageCoin = file;
      if (!file.type.includes("image/")) {
        alert("Please select an image file");
        return;
      }
      if (typeof FileReader === "function") {
        const reader = new FileReader();
        reader.onload = (event) => {
          this.imgSrcCoin = event.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        alert("Sorry, FileReader API not supported");
      }
    },
    depositAddress() {
      var result = getDownloadLink();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.isLoading = false;
          self.newCoinAddress = value.data.data.system.DEPOSIT_ADDRESS;
         
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  watch: {
    country: function () {
      var self = this;
      for (let i = 0; i < self.countryList.length; i++) {
        if (self.countryList[i].bank_country == self.country.toString()) {
          self.bankId = self.countryList[i].id;
          self.bank = self.countryList[i].bank_name;
          self.bankNo = self.countryList[i].bank_number;
          self.bankRef = self.countryList[i].swift_code;
          self.bankUser = self.countryList[i].bank_user;
          self.bankRate = self.countryList[i].country.sell;
          self.pSymbol = self.countryList[i].country.short_form;
        }
      }
      self.changeRate();
    },
    coin: function () {
      var self = this;
      for (let i = 0; i < self.coinList.length; i++) {
        if (self.coinList[i].name == self.coin.toString()) {
          self.address = self.coinList[i].address;
        }
      }
    },
  },
  created() {
    this.getBank();
    // this.getAllowDeposit();
    this.getCoin();
    this.depositAddress();
  },
};
</script>

<style>
.input-group {
  border-bottom: none;
  margin-bottom: 1rem !important;
}

.upload-box {
  height: 10vh;
  position: relative;
  width: 30vw;
}

.upload-hint {
  position: absolute;
  width: 100%;
  height: 100%;
  border-style: solid;
  border-width: 1px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.upload-hint.active {
  border-color: red;
  background-color: transparent !important;
  color: red !important;
}
</style>