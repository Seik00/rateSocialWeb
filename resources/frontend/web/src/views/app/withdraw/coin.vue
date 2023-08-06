<template>
  <div class="mt-3 mx-4" style="position: relative">
    <div
      v-if="startLoading"
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
    <b-form @submit.prevent="checkSubmit">
      <!-- <h5 style="color: red; font-weight: bold">{{ $t("important_notes") }}</h5>
      <p
        style="color: red; font-weight: bold; margin: 0px 0px 10px 0px"
        @click="warning"
      >
        {{ $t("click_rules") }}
      </p> -->

      <b-form-group :label="$t('withdraw_type')" class="form-customize">
        <b-input-group>
          <b-form-select v-model="withdrawSelected" @change="updateWithdraw" type="text" class="form-control" :options="withdrawOptions" style="background:#122a58;min-height:40px;margin-bottom:0px!important;">
              </b-form-select>
        </b-input-group>
      </b-form-group>

      <p class="mb-0" v-if="show==false">{{ $t("withdrawAmount") }}</p>
      <!-- <span class="label px-1">{{ $t("withdrawRate") }} 1.5%</span> -->

      <b-form-group class="form-customize mt-2 p-0 mb-1" v-if="show==false">
        <b-form-input
          class="custom-input form-custom text-left"
          v-model="amount"
          type="number"
          :placeholder="$t('withdrawHint')"
          @change="updateAmount"
          @input="updateAmount"
          step="any"
          min="10"
        >
        </b-form-input>
      </b-form-group>

      <b-row align-h="between" class="mb-4"  v-if="show==false">
        <b-col>
          <span>{{ $t("amount") }}: {{ this.totalAmount }}</span>
        </b-col>
        <b-col class="text-right">
          <a target="_blank" rel="noopener noreferrer" @click="inputAll">{{
            $t("withdrawAll")
          }}</a>
        </b-col>
      </b-row>

       <p class="mb-0" v-if="show==true">{{ $t("withdrawDaAmount") }}</p>
        <!-- <span class="label px-1">{{ $t("withdrawRate") }} 1.5%</span> -->

        <b-form-group class="form-customize mt-2 p-0 mb-1" v-if="show==true">
          <b-form-input
            class="custom-input form-custom text-left"
            v-model="daAmount"
            type="number"
            :placeholder="$t('withdrawHint')"
            @change="updateDaAmount"
            @input="updateDaAmount"
            step="any"
            min="100"
          >
          </b-form-input>
        </b-form-group>

        <b-row align-h="between" class="mb-4"  v-if="show==true">
          <b-col>
            <span>DA {{ $t("amount") }}: {{ this.assetFrozen }}</span>
          </b-col>
          <b-col class="text-right">
            <a target="_blank" rel="noopener noreferrer" @click="inputDaAll">{{
              $t("withdrawAll")
            }}</a>
          </b-col>
        </b-row>

       <b-form-group :label="$t('wallet_type')" class="form-customize" v-if="show==false">
        <b-input-group>
          <b-form-select v-model="walletSelected" type="text" class="form-control" :options="walletOptions" style="min-height:40px;margin-bottom:0px!important;">
              </b-form-select>
        </b-input-group>
      </b-form-group>

      <b-form-group :label="$t('address')" class="form-customize" v-if="show==false">
        <b-input-group>
          <b-form-input
            class="form-control form-custom"
            v-model="address"
            type="text"
            required
          >
          </b-form-input>
          <!-- <b-input-group-append class="form-custom-append">
            <button
              class="my-auto mx-2"
              type="button"
              @click="$router.push('/web/withdraw/setCoin')"
            >
              <span>{{ $t("change") }}</span>
            </button>
          </b-input-group-append> -->
        </b-input-group>
      </b-form-group>

      <b-form-group :label="$t('market_price')" class="form-customize" v-if="show==true">
        <b-input-group>
          <b-form-input
            class="form-control form-custom"
            v-model="marketPrice"
            type="text"
            readonly
          >
          </b-form-input>
        </b-input-group>
      </b-form-group>

      <b-form-group :label="$t('fees') +' %'" class="form-customize mt-3">
        <b-input-group>
          <b-form-input
            class="form-control form-custom"
            v-model="fee"
            type="number"
            readonly
          >
          </b-form-input>
        </b-input-group>
      </b-form-group>

      <b-form-group
        :label="$t('get_amount')"
        class="form-customize mt-3"
      >
        <b-input-group>
          <b-form-input
            class="form-control form-custom"
            v-model="confirm_amount"
            type="number"
            readonly
          >
          </b-form-input>
        </b-input-group>
      </b-form-group>

      <b-form-group :label="$t('sec_password')" class="form-customize mt-3">
        <b-input-group>
          <b-form-input
            class="form-control form-custom"
            :placeholder="$t('assetPwdHint')"
            type="password"
            v-model="sec_pwd"
            required
          >
          </b-form-input>
        </b-input-group>
      </b-form-group>

      <!-- <b-form-group
          label-cols="6"
          label-size="sm"
          :label="$t('address')"
          label-for="input-sm"
          class="form-custom mb-1 mt-3 mx-0"
        >
          <b-form-input
            size="sm"
            class="custom-input"
            v-model="address"
            required
          ></b-form-input> </b-form-group
        ><b-form-group
          label-cols="6"
          label-size="sm"
          :label="$t('fees')+' (USDT)'"
          label-for="input-sm"
          class="form-custom mb-1 mx-0"
        >
          <b-form-input
            size="sm"
            class="custom-input"
            readonly
            v-model="fee"
          ></b-form-input> </b-form-group
        ><b-form-group
          label-cols="6"
          label-size="sm"
          :label="$t('get_amount')+' (USDT)'"
          label-for="input-sm"
          class="form-custom mb-1 mx-0"
        >
          <b-form-input
            size="sm"
            class="custom-input"
            readonly
            v-model="confirm_amount"
          ></b-form-input>
        </b-form-group>
        <b-form-group
          label-cols="6"
          label-size="sm"
          :label="$t('sec_password')"
          label-for="input-sm"
          class="form-custom mb-1 mx-0"
        >
          <b-form-input
            size="sm"
            class="custom-input"
            :placeholder="$t('assetPwdHint')"
            type="password"
            v-model="sec_pwd"
            required
          ></b-form-input>
        </b-form-group> -->

      <b-button
          :disabled="isLoading"
        class="mx-auto submit_button"
        style="margin-top: 10vh"
        variant="outline-secondary"
        type="submit"
        >{{ isLoading ? $t("loading...") : $t("withdraw") }}</b-button
      >
    </b-form>
    <Dialog ref="msg"></Dialog>
    <b-modal
      id="modal-warning"
      size="md"
      centered
      :title="$t('withdrawal_rules')"
      :hide-footer="true"
      style="background-color: #5f646e !important"
    >
      <b-form>
        <b-row align-h="center">
          <b-col md="12 mb-30">
            <div class="form-group">
              <div class="col-sm-12">
                <p>
                  {{ $t("withdrawal_rules1") }}
                </p>
                <p>
                  {{ $t("withdrawal_rules2") }}
                </p>
                <p>
                  {{ $t("withdrawal_rules3") }}
                </p>
                <p>
                  {{ $t("withdrawal_rules4") }}
                </p>
                <p>
                  {{ $t("withdrawal_rules5") }}
                </p>
                <p>
                  {{ $t("withdrawal_rules6") }}
                </p>
                <p>
                  {{ $t("withdrawal_rules7") }}
                </p>
                <p>
                  {{ $t("withdrawal_rules8") }}
                </p>
              </div>
              <div class="col-sm-12">
                <center>
                  <b-button
          :disabled="isLoading"
                    class="mx-auto submit_button mt-5"
                    variant="outline-secondary"
                    @click="close()"
                    >{{ $t("close") }}</b-button
                  >
                </center>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
import { withdraw, getMemberInfo, asset, marketInfo, withdrawDa } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import { mapGetters } from "vuex";
import Dialog from "../../../components/dialog.vue";
export default {
  props: ["fee", "totalAmount", "canWithdraw", "startLoading"],
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
  },
  data() {
    return {
      address: "",
      amount: 0,
      confirm_amount: 0,
      sec_pwd: "",
      selected: 0,
      isLoading: false,
      walletSelected: "USDT(TRC20)",
      withdrawSelected: "coin",
      walletOptions: [
        {
          value: "USDT(TRC20)",
          text: 'USDT(TRC20)',
        },
      ],
      withdrawOptions: [
        {
          value: 'coin',
          text: this.$t('coin'),
        },
         {
          value: 'freeze_coin',
          text: this.$t('da_interest'),
        },
      ],
      show: false,
      assetFrozen: 0,
      marketPrice: "",
      daAmount: 0,
    };
  },
  methods: {
    warning() {
      this.$bvModal.show("modal-warning");
    },
    close() {
      this.$bvModal.hide("modal-warning");
    },
    selectIndex(i) {
      this.selected = i;
      this.sec_pwd = "";
    },
    updateAmount() {
      this.confirm_amount = this.amount - (this.amount * this.fee) / 100;
      if (this.confirm_amount < 0) {
        this.confirm_amount = 0;
      }
    },
    updateDaAmount() {
      this.confirm_amount = (this.daAmount * this.marketPrice) - (this.daAmount * this.fee) /100;
      if (this.confirm_amount < 0) {
        this.confirm_amount = 0;
      }
    },
    updateWithdraw() {
      if (this.withdrawSelected =='coin') {
        this.show = false;
      }else{
        this.show = true;
      }
    },
    inputAll() {
      this.amount = this.totalAmount;
      this.confirm_amount = this.amount - (this.amount * this.fee) / 100;
    },
    inputDaAll() {
      this.daAmount = this.assetFrozen;
      this.confirm_amount = this.daAmount - (this.daAmount * this.fee) / 100;
    },
    checkSubmit(){
      if(this.show==false){
        this.doWithdraw();
      }else{
        this.doWithdrawDa();
      }
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
              setTimeout(() => {
                self.$router.push("/web/");
              }, 2000);
            } else {
              self.$refs.msg.makeToast("danger", self.$t(value.data.message));
            }
            self.sec_pwd = "";
            self.isLoading = false;
          })
          .catch(function (error) {
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
            self.isLoading = false;
            self.sec_pwd = "";
          });
    },
    doWithdrawDa() {
        let formData = new FormData();
        formData.append("amount", this.daAmount);
        formData.append("trade_market_id", 1);
        formData.append("sec_password", this.sec_pwd);
        console.log(formData);

        var result = withdrawDa(formData);
        var self = this;
        self.isLoading = true;

        result
          .then(function (value) {
            if (value.data.error_code == 0) {
              self.$refs.msg.makeToast("success", self.$t(value.data.message));
              setTimeout(() => {
                self.$router.push("/web/");
              }, 2000);
            } else {
              self.$refs.msg.makeToast("danger", self.$t(value.data.message));
            }
            self.sec_pwd = "";
            self.isLoading = false;
          })
          .catch(function (error) {
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
            self.isLoading = false;
            self.sec_pwd = "";
          });
    },
    daAsset() {
      var result = asset('DA');
      var self = this;
      result
        .then(function (value) {
            for (let i = 0; i < value.data.data.asset.length; i++) {
                if (value.data.data.asset[i].coin_name == "DA") {
                  self.assetFrozen = value.data.data.asset[i].asset_frozen;
                }
            }
        })
        .catch(function (error) {
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    _marketInfo() {
      var result = marketInfo(1);

      var self = this;
      result
          .then(function (value) {
              self.marketPrice = value.data.data.trade_market.price;
          })
          .catch(function (error) {
              self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          });
    },
  },
  created() {
    this.daAsset();
    this._marketInfo();
    this.info = JSON.parse(localStorage.getItem('info'));
    console.log(this.info.round);
    var result = getMemberInfo();
    var self = this;
    this.isLoading = true;
    result
      .then(function (value) {
        self.address = value.data.address;
        if (value.data.address != null) {
          self.$bvModal.show("modal-otp");
        }
        self.isLoading = false;
      })
      .catch(function (e) {
        console.log(e);
        self.isLoading = false;
      });
  },
};
</script>

<style>
</style>