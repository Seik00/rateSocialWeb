<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
      <span>{{ $t("request_deposit") }}</span>
    </div>
    <b-form @submit.prevent="RequestDeposit">
      <div class="mainpage">
        <b-row align-h="center">
          <b-button
            :disabled="isLoading"
            class="mx-auto deposit_button"
            variant="outline-secondary"
            v-on:click="someFunction(10000)"
            >{{ isLoading ? $t("loading...") : "10000" }}</b-button
          >

          <b-button
            :disabled="isLoading"
            class="mx-auto deposit_button"
            variant="outline-secondary"
            v-on:click="someFunction(50000)"
            >{{ isLoading ? $t("loading...") : "50000" }}</b-button
          >

          <b-button
            :disabled="isLoading"
            class="mx-auto deposit_button"
            variant="outline-secondary"
            v-on:click="someFunction(100000)"
            >{{ isLoading ? $t("loading...") : "100000" }}</b-button
          >
        </b-row>

        <b-row align-h="center">
          <b-button
            :disabled="isLoading"
            class="mx-auto deposit_button"
            variant="outline-secondary"
            v-on:click="someFunction(300000)"
            >{{ isLoading ? $t("loading...") : "300000" }}</b-button
          >

          <b-button
            :disabled="isLoading"
            class="mx-auto deposit_button"
            variant="outline-secondary"
            v-on:click="someFunction(500000)"
            >{{ isLoading ? $t("loading...") : "500000" }}</b-button
          >

          <b-button
            :disabled="isLoading"
            class="mx-auto deposit_button"
            variant="outline-secondary"
            v-on:click="someFunction(1000000)"
            >{{ isLoading ? $t("loading...") : "1000000" }}</b-button
          >
        </b-row>

        <p class="mb-0">{{ $t("depositAmount") }}</p>
        <!-- <span class="label px-1">{{ $t("withdrawRate") }} 1.5%</span> -->

        <b-form-group class="form-custom mt-2 p-0 mb-1">
          <b-form-input
            class="custom-input text-left"
            v-model="amount"
            type="number"
            :placeholder="$t('depositHint')"
            min="10"
          >
          </b-form-input>
        </b-form-group>

        <!-- <span style="color: red" v-if="selected == 'bank'">
          * {{ $t("minimun_depsoit") }}
        </span>
        <span style="color: red" v-if="selected != 'bank'">
          * {{ $t("minimun_depsoit_coin") }}
        </span> -->

        <b-form-group :label="$t('deposit_type')" class="form-customize mt-3">
          <b-form-select v-model="selected" :options="options"> </b-form-select>
        </b-form-group>

        <b-button
          :disabled="isLoading"
          class="mx-auto submit_button"
          style="margin-top: 20vh"
          variant="outline-secondary"
          type="submit"
          >{{ isLoading ? $t("loading...") : $t("submit") }}</b-button
        >
      </div>
    </b-form>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { doRequestDeposit, checkAllowDeposit } from "../../../system/api/api";
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
      approval: "",
      amount: 0,
      isLoading: false,
      selected: "bank",
      options: [
        // {
        //   value: "USDT-TRC20",
        //   text: "USDT-TRC20",
        // },
        {
            "value": "bank",
            "text": this.$t("bank")
        },
        // {
        //     "value": "USDT-ERC20",
        //     "text": 'USDT-ERC20'
        // },
        // {
        //     "value": "USDT-OMNI",
        //     "text":'USDT-OMNI'
        // },
      ],
    };
  },
  props: ["success"],
  methods: {
    someFunction(value) {
      this.amount = value;
    },
    checkStatus() {
      var result = checkAllowDeposit();
      var self = this;
      // self.isLoading = true;

      result
        .then(function (value) {
          console.log(value);
          self.approval = value.data.data.approval;
          self.statusAction();
          self.isLoading = true;
        })
        .catch(function (error) {
          console.log(error);
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
    },
    statusAction() {
      var self = this;
      var current = location.origin + "/";
      if (self.approval == 0) {
        window.location.href = current + "web";
      } else if (self.approval == 1) {
        window.location.href = current + "web/deposit";
      }
    },
    RequestDeposit() {
      let formData = new FormData();
      formData.append("amount", this.amount);
      formData.append("deposit_type", this.selected);
      console.log(formData);

      var result = doRequestDeposit(formData);
      var self = this;
      self.isLoading = true;

      result
        .then(function (value) {
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            setTimeout(() => {
              var current = location.origin + "/";
              window.location.href = current + "web";
            }, 1000);
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.amount = "";
          self.selected = "";
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
    },
  },
  created() {
    //this.checkStatus();
  },
};
</script>

<style>
</style>