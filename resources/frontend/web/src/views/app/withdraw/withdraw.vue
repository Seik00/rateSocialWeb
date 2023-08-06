<template>
  <div class="main-content d-flex flex-column" style="max-height: 100vh">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
      <span>{{ $t("withdraw") }}</span>
      <!-- <a
        class="right-side"
        @click="$router.push('/web/withdraw/withdrawHistory')"
      >
        <i class="fa fa-history"></i>
      </a> -->
    </div>

    <div class="flex-grow-1">
      <div class="mx-4">
        <b-row align-h="between" class="mt-3 ">
          <b-col cols="6" class="pr-0">
            <div class="tabContainer text-center" :class="{ active: selected == 0 }" @click="selectIndex(0)">
              <div class="tabImage">
                <img src="../../../assets/images/digital/surface1.svg" alt="">
              </div>
              <span>{{ $t("bank") }}</span>
            </div>
          </b-col>
          <b-col cols="6" class="pl-0">
            <div class="tabContainer text-center" :class="{ active: selected == 1 }" @click="selectIndex(1)">
              <div class="tabImage">
                <img src="../../../assets/images/digital/Cjdowner-Cryptocurrency-Flat-Tether-USDT.svg" alt="">
              </div>
              <span>{{ $t("crypto") }}</span>
            </div>
          </b-col>
        </b-row>

      </div>
      <bank :fee="fee" :totalAmount="totalAmount" v-if="selected == 0" :canWithdraw="canWithdraw"
        :startLoading="isLoading"></bank>
      <coin :fee="fee" :totalAmount="totalAmount" v-if="selected == 1" :canWithdraw="canWithdraw"
        :startLoading="isLoading"></coin>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  getWithdrawRecord,
  getMemberInfo,
  withdraw,
} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
import bank from "../withdraw/bank.vue";
import coin from "../withdraw/coin.vue";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
    bank,
    coin
  },
  data() {
    return {
      address: "",
      totalAmount: 0,
      amount: 0,
      confirm_amount: 0,
      fee: 0,
      sec_pwd: "",
      selected: 0,
      isLoading: false,
      canWithdraw: false,
    };
  },
  props: ["success"],
  methods: {
    selectIndex(i) {
      this.selected = i;
      this.sec_pwd = "";
      this.getInfo();
      this.getRecord();
    },
    updateAmount() {
      this.confirm_amount = (this.amount * this.fee) / 100;
      if (this.confirm_amount < 0) {
        this.confirm_amount = 0;
      }
    },
    inputAll() {
      this.amount = this.totalAmount;
      this.confirm_amount = (this.amount * this.fee) / 100;
    },

    getInfo() {
      var result = getMemberInfo();
      var self = this;
      // self.isLoading = true;

      result
        .then(function (value) {
          // self.isLoading = false;
          self.totalAmount = value.data.data.point1;
        })
        .catch(function (error) {
          console.log(error);
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
    },

    getRecord() {
      var result = getWithdrawRecord();
      var self = this;
      self.isLoading = true;

      result
        .then(function (value) {
          self.isLoading = false;
          self.fee = value.data.fee;
          self.canWithdraw = !value.data.can_withdraw;
        })
        .catch(function (error) {
          console.log(error);
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
    },

    doWithdraw() {
      let formData = new FormData();
      formData.append("amount", this.amount);
      formData.append("address", this.address);
      formData.append("sec_password", this.sec_pwd);
      console.log(formData);

      var result = withdraw(formData);
      var self = this;
      self.isLoading = true;

      result
        .then(function (value) {
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.getInfo();
          self.getRecord();
          self.sec_pwd = "";
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
          self.sec_pwd = "";
        });
    },
  },
  created() {
    this.getInfo();
    this.getRecord();
  },
};
</script>

<style>
.input-group {
  border-bottom: none;
  margin-bottom: 1rem !important;
}
</style>