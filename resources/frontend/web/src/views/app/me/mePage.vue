<template>
  <div class="main-content" style="padding-bottom: 15vh;">
    <div class="appBar">
      <span>{{ $t("profile") }}</span>
    </div>
    <div style="padding: 5px 20px">

      <b-card class="mb-3 bg-greyblue">
        <div class="d-flex">
          <div class="avatar-circle big" :style="{ backgroundImage: 'url(' + `/images/level1/${currentPackage.toLowerCase()}.png` + ')' }"></div>
          <div class="text-left ml-3 flex-grow-1">
            <h5 class="font-weight-bold mb-0">{{ userID }}</h5>
            <p class="text-8 font-weight-bold mb-0">
              {{ $t("invi_code") }} <u>{{ ref_code }}</u></p>
            <div class="d-flex mt-2 justify-content-end align-items-center">
              <div class="mr-2">
                <p class="text-right text-8 font-weight-bold mb-1">
                  {{ $t("current_level") }} <br> <span class="text-14 text-white">{{ currentPackage
                  }}</span></p>

              </div>
              <!-- <img height="40px" :src="`/images/level1/${currentPackage.toLowerCase()}.png`" alt=""> -->

            </div>

          </div>
        </div>
      </b-card>

      <b-card class="mb-3 bg-greyblue">
        <h5 class="font-weight-bold mb-2">{{ $t('balance') }}</h5>
        <div class="d-flex justify-content-between align-items-end">
          <span class="text-20"><img height="20px" src="../../../assets/images/digital/currency.svg" alt=""></span>
          <div class="d-flex align-items-end">
            <span class="text-12 mb-0 mr-1">USDT</span>
            <h3 class="font-weight-bold mb-0">{{ point1 }}</h3>
          </div>
        </div>
      </b-card>

      <b-card class="mb-3 bg-greyblue">
        <h5 class="font-weight-bold mb-3">{{ $t('assets') }}</h5>
        <div v-for="item in assetList" :key="item.id">
          <img src="../../../assets/images/logo.png" @error="imageLoadError" alt="" height="24px">
          <span class="mx-2 text-white">{{ item.coin_name }}</span>

          <b-row>
            <b-col cols="6">
              <p class="mb-0">{{ $t('current_balance') }}</p>
              <p class="text-white">{{ item.asset_active }}</p>
            </b-col>
            <b-col cols="6">
              <p class="mb-0">{{ $t('freeze_wallet') }}</p>
              <p class="text-white">{{ item.asset_frozen }}</p>
            </b-col>
          </b-row>


        </div>
      </b-card>

      <b-card class="mb-3 bg-greyblue">
        <div class="d-flex justify-content-between">
          <div>
            <h5 class="font-weight-bold mb-3">{{ $t('level_benefit') }}</h5>
            <h6 class="text-12 ml-2 mb-2 font-weight-bold">{{ $t('current_level_benefit') }}</h6>

          </div>

        </div>

        <div class="ml-2">
          <b-row class="mb-2">
            <b-col cols="12">{{ $t(`benefit_${user_group_id}`) }}</b-col>
          </b-row>
          <h6 class="text-12 mb-2 font-weight-bold" v-if="user_group_id!=5">{{ $t('upLevel_hint') }}</h6>
          <b-row class="" v-if="user_group_id!=5">
            <b-col cols="12">
              <p class="mb-1">{{ $t(`upLevel_hint_${user_group_id + 1}`) }}</p>
            </b-col>
            <b-col cols="12">
              <div class="d-flex">
                <span class="text-white mr-2" style="white-space: nowrap;">{{ $t('benefit') }}</span>{{
                  $t(`benefit_${user_group_id + 1}`) }}
              </div>
            </b-col>
          </b-row>

        </div>
      </b-card>
      <b-row class="mb-3">
        <b-col cols="3" class="">
          <b-link to="/web/myWallet/walletRecord" class="">
            <div class="bg-greyblue rounded px-2 pt-2">
              <p class="mb-3 text-white text-8 font-weight-bold">{{ $t('record') }}</p>
              <div class="d-flex justify-content-end align-items-center w-100">
                <span class="text-24 mb-0"><img width="22px" src="../../../assets/images/digital/transaction.svg"
                    alt=""></span>
              </div>
            </div>
          </b-link>
        </b-col>
        <b-col cols="3" class="">
          <b-link to="/web/deposit">
            <div class="bg-greyblue rounded px-2 pt-2">
              <p class="mb-3 text-white text-8 font-weight-bold">{{ $t('topup') }}</p>
              <div class="d-flex justify-content-end align-items-center w-100">
                <span class="text-24 mb-0"><img width="22px" src="../../../assets/images/digital/deposit.svg"
                    alt=""></span>
              </div>
            </div>
          </b-link>
        </b-col>
        <b-col cols="3" class="">
          <b-link to="/web/withdraw/withdrawHistory">

            <div class="bg-greyblue rounded px-2 pt-2">
              <p class="mb-3 text-white text-8 font-weight-bold">{{ $t('withdraw') }}</p>
              <div class="d-flex justify-content-end align-items-center w-100">
                <span class="text-24 mb-0"><img width="22px" src="../../../assets/images/digital/Solid.svg" alt=""></span>
              </div>
            </div>
          </b-link>
        </b-col>
        <b-col cols="3" class="">
          <b-link to="/web/me/faq">

            <div class="bg-greyblue rounded px-2 pt-2">
              <p class="mb-3 text-white text-8 font-weight-bold">{{ $t('faq') }}</p>
              <div class="d-flex justify-content-end align-items-center w-100">
                <span class="text-24 mb-0"><img width="22px" src="../../../assets/images/digital/Layer 2.svg"
                    alt=""></span>
              </div>
            </div>
          </b-link>
        </b-col>
      </b-row>
      <span class="font-weight-bold">{{ $t('More') }}</span>
      <b-card class="bg-greyblue">
        <!-- <b-link to="/web/myTeam">
          <div class="list-box">
            <b-row align-h="start" align-v="center" class="m-0">
              <div class="text-center text-18">
                <img src="../../../assets/images/digital/user (3).svg" alt="">
              </div>

              <h6 class="mb-0 mx-3 text-10 text-primary">
                {{ $t("my_team") }}
              </h6>
              <i class="fa fa-angle-right" style="right: 30px; position: absolute; color: white"></i>
            </b-row>
          </div>
        </b-link> -->
        <!-- <b-link to="/web/me/faq">
          <div class="list-box">
            <b-row align-h="start" align-v="center" class="m-0">
              <div class="text-center text-18">
                <i style="width:16px" class="fa fa-question"></i>
              </div>

              <h6 class="mb-0 mx-3 text-10 text-primary">
                {{ $t("FAQ") }}
              </h6>
              <i class="fa fa-angle-right" style="right: 30px; position: absolute; color: white"></i>
            </b-row>
          </div>
        </b-link> -->
        <b-link to="/web/settings/settingCenter">
          <div class="list-box">
            <b-row align-h="start" align-v="center" class="m-0">
              <div class="text-center text-18">
                <img src="../../../assets/images/digital/setting.svg" alt="">
              </div>

              <h6 class="mb-0 mx-3 text-10 text-primary">
                {{ $t("settings") }}
              </h6>
              <i class="fa fa-angle-right" style="right: 30px; position: absolute; color: white"></i>
            </b-row>
          </div>
        </b-link>
        <b-link to="/web/ticket/ticket">
          <div class="list-box">
            <b-row align-h="start" align-v="center" class="m-0">
              <div class="text-center text-18">
                <img src="../../../assets/images/digital/ticket (3).svg" alt="">
              </div>

              <h6 class="mb-0 mx-3 text-10 text-primary">
                {{ $t("contact_service") }}
              </h6>
              <i class="fa fa-angle-right" style="right: 30px; position: absolute; color: white"></i>
            </b-row>
          </div>
        </b-link>
        <b-link to="/web/me/newsList">
          <div class="list-box">
            <b-row align-h="start" align-v="center" class="m-0">
              <div class="text-center text-18">
                <i style="width:16px" class="fa fa-bullhorn" aria-hidden="true"></i>
              </div>

              <h6 class="mb-0 mx-3 text-10 text-primary">
                {{ $t("news") }}
              </h6>
              <i class="fa fa-angle-right" style="right: 30px; position: absolute; color: white"></i>
            </b-row>
          </div>
        </b-link>
        <!-- <b-link href="https://t.me/Digitalalpha_CS">
          <div class="list-box">
            <b-row align-h="start" align-v="center" class="m-0">
              <div class="text-center text-18">
                <i style="width:16px" class="fa fa-telegram"></i>
              </div>

              <h6 class="mb-0 mx-3 text-10 text-primary">
                {{ $t("CS") }}
              </h6>
              <i class="fa fa-angle-right" style="right: 30px; position: absolute; color: white"></i>
            </b-row>
          </div>
        </b-link> -->

        <div class="list-box" @click="openRecord">
          <b-row align-h="start" align-v="center" class="m-0">
            <div class="text-center text-18">
              <img src="../../../assets/images/digital/paper.svg" alt="">
            </div>

            <h6 class="mb-0 mx-3 text-10 text-primary">
              {{ $t("bonus_record") }}
            </h6>
            <i class="fa fa-angle-right" style="right: 30px; position: absolute; color: white"></i>
          </b-row>
        </div>
        <!-- <b-link to="/web/me/legal">
          <div class="list-box">
            <b-row align-h="start" align-v="center" class="m-0">
              <div class="text-center text-18">
                <i style="width:16px" class="fa fa-question"></i>
              </div>

              <h6 class="mb-0 mx-3 text-10 text-primary">
                {{ $t("legal") }}
              </h6>
              <i class="fa fa-angle-right" style="right: 30px; position: absolute; color: white"></i>
            </b-row>
          </div>
        </b-link> -->
      </b-card>

      <b-button class="btn bg-greyblue submit_button w-100 mt-3" @click="logoutUser">
        {{ $t("sign_out") }}

      </b-button>
    </div>

    <b-modal id="modal-pending" size="md" centered :hide-footer="true" style="background-color: #5f646e !important">
      <b-form class="mx-5">
        <b-row align-h="center">
          <b-col md="12 mb-30">
            <b-row align-h="center" style="margin-bottom: 10px">
              <!-- <div class="form-group">
                   <i class="fa fa-clock-o" style="font-size:100px;color:purple"></i>
              </div> -->
              <div class="spinner spinner-primary m-2 text-50"></div>
              <div class="col-sm-12">
                <center>
                  <b-button class="mx-auto submit_button mt-5" variant="outline-secondary" @click="close()">{{ $t("close")
                  }}</b-button>
                </center>
              </div>
            </b-row>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getMemberInfo, checkAllowDeposit, getTicket, asset } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters, mapActions } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
  },
  data() {
    return {
      otp: "",
      email: "",
      isLoading: false,
      userID: 0,
      total_sponsor: "",
      point1: 0,
      point2: 0,
      user_group_id: 0,
      ref_code: "",
      currentPackage: "",
      approval: "",
      dataList: [],
      assetList: [],
      notic: [],
      marketInfo: null,
      show: false,
      inv_link: "",
    };
  },
  props: ["success"],
  methods: {
    ...mapActions(["signOut"]),
    imageLoadError(event) {
      event.target.src = require('../../../assets/images/logo/logo/logo.png');
    },
    checkApproval() {
      // if (this.approval == 2 || this.approval == 3) {
      //   this.$router.push("/web/requestDeposit");
      // } else if (this.approval == 1) {
      this.$router.push("/web/deposit");
      // } else if (this.approval == 0) {
      //   this.$bvModal.show("modal-pending");
      //   this.getSpin();
      // }
    },

    _asset() {
      var result = asset();

      var self = this;
      // this.isLoading = true;
      result
        .then(function (value) {
          console.log(value.data)
          for (let i = 0; i < value.data.data.asset.length; i++) {
            // if (value.data.data.asset[i].coin_name.includes(self.type.split('/')[0])) {
            self.assetList = value.data.data.asset;

            // }

          }
          // self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },


    getSpin() {
      var result = checkAllowDeposit();
      var self = this;
      // self.isLoading = true;

      result
        .then(function (value) {
          self.approval = value.data.data.data.approval;
          if (self.approval == 0) {
            setTimeout(() => {
              self.getSpin();
            }, 3000);
          } else {
            self.$router.push("/web/deposit");
          }

          console.log(value);
        })
        .catch(function (error) {
          console.log(error);
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
    },
    openOtp() {
      this.$bvModal.show("modal-logout");
    },
    close() {
      this.$bvModal.hide("modal-pending");
    },
    logoutUser() {
      this.signOut();

      this.$router.push("/web/sessions/signIn");
    },
    openRecord() {
      this.$router.push("/web/bonus/bonusCenter");
    },
    clipboardSuccessHandler() {
      this.$refs.msg.makeToast("success", this.$t("copied"));
    },
    clipboardErrorHandler() {
      //// console.log('error', value)
    },
    getInfo() {
      var result = checkAllowDeposit();
      var self = this;
      // self.isLoading = true;

      result
        .then(function (value) {
          self.approval = value.data.data.data.approval;
        })
        .catch(function (error) {
          console.log(error);
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
    },
    Notic() {
      var result = getTicket();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.data.ticket;
          for (let i = 0; i < dataList.length; i++) {
            console.log(dataList[i]);
            self.dataList.push(dataList[i].user_read);


          }
          self.showNotic();
          self.isLoading = false;
        })
        .catch(function (error) {
          console.log(error);
          self.isLoading = false;
        });
    },
    showNotic() {
      this.notic = this.dataList.includes(0);

      if (this.notic == true) {
        this.show = true;
      }
    },
    loadItems() {
      var result = getMemberInfo();

      var self = this;
      this.isLoading = true;
      self.inv_link = location.origin + "/register?ref_id=";
      result
        .then(function (value) {
          self.userID = value.data.data.id;
          self.user_group_id = value.data.data.user_group_id;
          self.currentPackage = value.data.data.package.package_name_en;
          self.total_sponsor = value.data.data.total_sponsor;
          self.point1 = value.data.data.point1;
          self.point2 = value.data.data.point2;
          self.ref_code = value.data.data.ref_code;
          // self.wallets = value.data.data.data.wallet;
          self.isLoading = false;
          self.Notic();
          localStorage.setItem('info', JSON.stringify(value.data.data));
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.getInfo();
    this.loadItems();
    this._asset();
    this.email = localStorage.getItem("username");
  },
};
</script>

<style>
.row {
  margin-right: -10px;
  margin-left: -10px;

}

.col-3 {
  padding-right: 10px;
  padding-left: 10px;

}

.imgBox {
  background: rgb(113, 33, 179);
  border-radius: 10px;
  padding: 4px;
  height: 40px;
  width: 40px;
  position: relative;
}

.imgBox img {
  padding: 8px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.list-box {
  margin-bottom: 10px;
  border-radius: 10px;
  color: #7b94c2 !important;
}

.label-box {
  background: rgb(201, 135, 243);
  border-radius: 5px;
  width: 100%;
  color: white;
}

.wallet-box {
  background: white;
  border-radius: 15px;
  position: relative;
  margin-bottom: 20px;
  width: 90%;
  box-shadow: 0px 5px 6px rgb(201, 135, 243);
}

.hiddenClass {
  pointer-events: none;
  display: none;
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

h5#modal-logout___BV_modal_title_ {
  margin: auto;
}

button.close {
  display: none;
}

.banner-image2 {
  background-image: url("../../../assets/images/purple_banner.png");
  background-size: 100% 100%;
  height: 30vh;
  background-repeat: no-repeat;
  padding-top: 25px;
  color: black;
  width: 100%;
  position: absolute;
  left: 0;
  top: 0;
}

i.fa.fa-exclamation-circle {
  color: red;
  font-size: 25px;
  position: absolute;
  right: -10px;
  top: -10px;
  border-radius: 25px;
  background: #000;
}
</style>