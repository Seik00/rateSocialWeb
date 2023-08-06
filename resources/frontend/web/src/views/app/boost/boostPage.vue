<template>
  <div class="main-content m-4">
    <div class="">
      <b-card class="position-relative mb-4 text-center bg-greyblue">
        <b-row align-h="center" style="margin-bottom: 10px">
          <b-col cols="6" style="text-align: left">

            <div class="mb-3 px-0">
              <div class="d-flex">
                <p class="text-10 font-weight-bold">{{ $t('today_boost_profit') }}</p>

              </div>
              <div class="d-flex justify-content-start align-items-end">
                <div>
                  <div class="d-flex align-items-end"><span class="text-8 mr-1 mb-1 text-white">USDT</span>
                    <h5 class="mb-0 font-weight-bold">{{ parseFloat(today_bonus).toFixed(2) }}</h5>
                  </div>
                </div>
              </div>

            </div>
          </b-col>
          <b-col cols="6" style="text-align: left">

            <div class="mb-3 bg-greyblue px-0">
              <div class="d-flex">
                <p class="text-10 font-weight-bold">{{ $t('current_balance') }}</p>

              </div>
              <div class="d-flex justify-content-start align-items-end">
                <div>
                  <div class="d-flex align-items-end"><span class="text-8 mr-1 mb-0 text-white">USDT</span>
                    <h5 class="mb-0 font-weight-bold">{{ parseFloat(point1).toFixed(2) }}</h5>
                  </div>
                </div>
              </div>

            </div>
          </b-col>
        </b-row>
        <b-row align-h="center" style="margin-bottom: 10px">
          <b-col cols="6" style="text-align: left">

            <div class="mb-3 bg-greyblue px-0">
              <div class="d-flex">
                <p class="text-10 font-weight-bold">{{ $t('freeze_wallet') }}</p>

              </div>
              <div class="d-flex justify-content-start align-items-end">
                <div>
                  <div class="d-flex align-items-end"><span class="text-8 mr-1 mb-0 text-white">USDT</span>
                    <h6 class="mb-0 font-weight-bold">{{ parseFloat(point2).toFixed(2) }}</h6>
                  </div>
                </div>
              </div>

            </div>
          </b-col>
          <b-col cols="6" style="text-align: left">

            <div class="mb-3 bg-greyblue px-0">
              <div class="d-flex">
                <p class="text-10 font-weight-bold">{{ $t('today_boost_time') }}</p>

              </div>
              <div class="d-flex justify-content-start align-items-end">
                <div>
                  <div class="d-flex align-items-end">
                    <h6 class="mb-0 font-weight-bold">{{ today_completed_order }} / {{ boost_time }}</h6>
                  </div>
                </div>
              </div>

            </div>
          </b-col>
        </b-row>
        <b-row align-h="start">
          <b-col cols="6" style="text-align: left">

            <div class="mb-3 bg-greyblue px-0">
              <div class="d-flex">
                <p class="text-10 font-weight-bold">{{ $t('yesterday_boost_profit') }}</p>

              </div>
              <div class="d-flex justify-content-start align-items-end">
                <div>
                  <div class="d-flex align-items-end"><span class="text-8 mr-1 mb-0 text-white">USDT</span>
                    <h6 class="mb-0 font-weight-bold">{{ parseFloat(yesterday_bonus).toFixed(2) }}</h6>
                  </div>
                </div>
              </div>

            </div>
          </b-col>
        </b-row>
      </b-card>
    </div>
    <b-button @click="openOtp()" class="submit_button w-100" variant="secondary" :disabled="isLoading">
      <span v-if="isLoading">
        <div class="spinner spinner-primary m-2 text-50"></div>
      </span>
      <span v-else>{{ $t("start_order") }}</span>
    </b-button>
    <div class="text-left my-4">
      <p>{{ $t("remind") }}</p>
      <p class="text-12">{{ $t("remind_1") }}<br />{{ $t("remind_2") }}</p>
    </div>

    <b-modal id="modal-otp" size="md" centered :title="$t('order_title')" :no-close-on-backdrop="true"
      :no-close-on-esc="true" :ok-title="$t('submit')" @ok="checkApproval" @cancel="isLoading = false">
      <b-form class="ml-1 mr-4">
        <b-row align-h="center">
          <b-col cols="6">
            <div class="my-auto" style="width: 100%; height: 100%; position: relative">
              <img src="../../../assets/images/logo.png" class="w-100 position-absolute top-50" style="height:150px!important;"/>
            </div>
          </b-col>
          <b-col cols="6">
            <b-row align-h="center" style="margin-bottom: 5px">
              <b-col cols="8" style="text-align: left">
                <div class="mt-2">
                  <span class="mt-4 font-weight-bold text-10">
                    {{ $t("total_cost") }}</span><br />
                </div>
              </b-col>
              <b-col cols="4" style="text-align: right">
                <div class="mt-2">
                  <span class="mt-4 font-weight-bold text-12">
                    {{ cOrder_total_cost }}</span><br />
                </div>
              </b-col>
            </b-row>
            <b-row align-h="center" style="margin-bottom: 5px">
              <b-col cols="8" style="text-align: left">
                <div class="mt-2">
                  <span class="mt-4 font-weight-bold text-10">
                    {{ $t("profit") }}</span><br />
                </div>
              </b-col>
              <b-col cols="4" style="text-align: right">
                <div class="mt-2">
                  <span class="mt-4 font-weight-bold text-12">
                    {{ cOrder_profit }}</span><br />
                </div>
              </b-col>
            </b-row>
            <b-row align-h="center" style="margin-bottom: 5px">
              <b-col cols="8" style="text-align: left">
                <div class="mt-2">
                  <span class="mt-4 font-weight-bold text-10">
                    {{ $t("total_return") }}</span><br />
                </div>
              </b-col>
              <b-col cols="4" style="text-align: right">
                <div class="mt-2">
                  <span class="mt-4 font-weight-bold text-12">
                    {{ cOrder_total_return }}</span><br />
                </div>
              </b-col>
            </b-row>

            <!-- <b-row align-h="center" style="margin-bottom:10px;">
              <div class="form-group">
                <div class="col-sm-12">
                  <div class="mt-4 float-left">
                    <b-button
                      type="submit"
                      class="m-1"
                      variant="outline-secondary"
                      style="background-color: #02daaf !important"
                      :disabled="isLoading==false"
                      >{{ $t("submit") }}</b-button
                    >
                  </div>
                </div>
              </div>
              <div class="form-group">
              <div class="col-sm-12">
                <div class="mt-4 float-right">
                  <b-button
                    class="m-1"
                    variant="outline-secondary"
                    style="background-color: #02daaf !important"
                    @click="close()"
                    >{{ $t("cancel") }}</b-button
                  >
                </div>
              </div>
            </div>
            </b-row> -->
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
    <b-modal id="modal-reload" size="md" centered :title="$t('deposit_reminder')" :no-close-on-backdrop="true"
      :no-close-on-esc="true" :ok-title="$t('go_deposit')" @ok="submitreload">
      <b-form class="mx-5">
        <b-row align-h="center">
          <b-col md="12 mb-30">
            <div style="text-align: center">
              <img src="../../../assets/images/boost/no_balance.png" height="100px" />
            </div>
            <b-row align-h="center" style="margin-bottom: 5px">
              <div class="mt-12" style="text-align: center">
                <span class="mt-4 font-weight-bold text-14" style=" font-size: 14px">{{
                  $t("deposit_reminder2") }} </span><br />
                <span class="mt-4 font-weight-bold text-14" style="font-size: 12px">{{
                  $t("deposit_reminder3") }} {{ needDeposit }}
                  {{ $t("deposit_reminder4") }}</span><br />
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
import {
  boostOrder,
  checkOrder,
  getOrderInfo,
  getMemberInfo,
  checkAllowDeposit,
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
      otp: "",
      email: "",
      timecount: 60,
      startCount: false,
      myVar: null,
      sending: false,
      api_key: null,
      secret_key: null,
      sec_password: "",
      isLoading: false,
      canBind: true,
      price: "",
      today_bonus: "",
      yesterday_bonus: "",
      today_completed_order: "",
      boost_time: "",
      today_left_times: "",
      point1: "",
      point2: "",
      cOrder_total_cost: "",
      cOrder_profit: "",
      cOrder_total_return: "",
      product_id: "",
      public_path: "",
      approval: "",
      needDeposit: "",
    };
  },
  props: ["success"],
  methods: {
    openOtp() {
      if (this.today_left_times > 0) {
        setTimeout(() => {
          this.getInfo();
        }, 1000);
        this.isLoading = true;
      } else {
        var self = this;
        self.$refs.msg.makeToast("warning", self.$t("today_reach_limit"));
      }
    },
    close() {
      this.$bvModal.hide("modal-otp");
    },
    getInfo() {
      var result = checkOrder();
      var self = this;
      this.isLoading = true;

      result
        .then(function (value) {
          console.log(value);
          if (value.data.error_code == 0) {
            self.$bvModal.show("modal-otp");
            self.cOrder_total_cost = value.data.data.total_cost;
            self.cOrder_profit = value.data.data.profit;
            self.cOrder_total_return = value.data.data.total_return;
            self.product_id = value.data.data.product.id;
            self.public_path = value.data.data.product.public_path;
            self.price = value.data.data.product.price;
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.sending = false;
        });
    },
    reload() {
      this.needDeposit =
        parseInt(this.cOrder_total_cost) - parseInt(this.point1);
      this.$bvModal.show("modal-reload");
    },
    submitreload() {
      if (this.approval == 2 || this.approval == 3) {
        this.$router.push("/web/requestDeposit");
      } else if (this.approval == 1) {
        this.$router.push("/web/deposit");
      } else if (this.approval == 0) {
        this.$bvModal.show("modal-pending");
        this.getSpin();
      }
    },
    checkApproval() {
      if (parseInt(this.cOrder_total_cost) > parseInt(this.point1)) {
        this.$bvModal.hide("modal-otp");
        this.reload();
      } else {
        this.boost();
      }
    },

    getSpin() {
      var result = checkAllowDeposit();
      var self = this;
      // self.isLoading = true;

      result
        .then(function (value) {
          self.approval = value.data.data.approval;
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
    boost() {
      let formData = new FormData();
      var self = this;
      formData.append("product_id", this.product_id);
      var result = boostOrder(formData);
      self.isLoading = true;

      result
        .then(function (value) {
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t("operation_success"));
            self.$bvModal.hide("modal-otp");
            self.loadItems();
          } else {
            self.$refs.msg.makeToast("danger", self.checkError(value.data));
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
    checkError(val) {
      if (val.error_code == 'E00047') {
        if (this.$i18n.locale == 'en') {
          return 'Please mine between ' + val.message;

        } else {
          return '请在' + val.message + '之间挖矿';
        }

      } else {
        return val.message;
      }

    },
    loadItems() {
      var result = getOrderInfo();

      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          console.log(value);
          self.today_bonus = value.data.data.today_bonus;
          self.yesterday_bonus = value.data.data.yesterday_bonus;
          self.today_completed_order = value.data.data.today_completed_order;
          self.today_left_times = value.data.data.today_left_times;
          self.boost_time = value.data.data.today_limit;
          // self.wallets = value.data.data.wallet;
          self.memberInfo();
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    memberInfo() {
      var result = getMemberInfo();

      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.point1 = value.data.data.point1;
          self.point2 = value.data.data.point2;
          // self.wallets = value.data.data.wallet;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.loadItems();
    this.email = localStorage.getItem("username");
  },
};
</script>