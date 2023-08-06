<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
      <span>{{ $t("deposit_record") }}</span>
    </div>

    <!-- <div class="mainpage">
      <b-row align-h="between" class="mt-3">
        <b-col cols="5" class="pr-0">
          <div
            class="tabContainer text-center"
            :class="{ active: selected == 'BANK' }"
            @click="selectIndex('BANK')"
          >
            <div class="tabImage">
              <img
                src="../../../assets/images/boost/bank.png"
                alt=""
                height="15px"
              />
            </div>
            <span>{{ $t("bank") }}</span>
          </div>
        </b-col>
        <b-col cols="5" class="pl-0">
          <div
            class="tabContainer text-center"
            :class="{ active: selected == 'COIN' }"
            @click="selectIndex('COIN')"
          >
            <div class="tabImage">
              <img
                src="../../../assets/images/boost/crypto.png"
                alt=""
                height="15px"
              />
            </div>
            <span>{{ $t("crypto") }}</span>
          </div></b-col
        >
      </b-row>
    </div> -->
    <div
      class="m-3 px-2 mt-3 py-2"
      style="
        background: rgb(210 210 210);
        min-height: 90vh;
        border-radius: 10px;
        padding-bottom: 15vh !important;
        position: relative;
      "
    >
      <div
        v-if="currentPage > lastPage && dataList.length == 0"
        style="
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
        "
      >
        <p>No Data</p>
      </div>
      <div
        v-else-if="dataList.length == 0"
        style="
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
        "
      >
        <p>{{ $t("loading...") }}</p>
      </div>
      <div
        class="bg-white px-2 py-2 mb-2"
        style="border-radius: 10px"
        v-for="item in dataList"
        :key="item.id"
      >
        <b-row align-v="center">
          <b-col cols="2">
            <img src="../../../assets/images/boost/deposit_color.png" alt="" />
            <!-- <img v-if="item.detailen.toLowerCase().includes('deposit')" src="../../../assets/images/boost/deposit.png" alt="" />
            <img v-else-if="item.detailen.toLowerCase().includes('boost')" src="../../../assets/images/boost/shop.png" alt="" /> -->
          </b-col>
          <b-col cols="6">
            <p class="mb-0">{{ $t("deposit") }} {{ $t(site[item.status]) }}</p>
            <span class="text-10">{{ item.updated_at }}</span>
          </b-col>
          <b-col cols="4">
            <p class="mb-0">
              {{ item.amount }}
            </p>
            <span class="text-10" v-if="selected =='BANK'"
              >≈ {{ item.currency }} {{ item.get_amount }}</span
            >
          </b-col>
        </b-row>
      </div>
      <b-button
        v-if="currentPage <= lastPage && dataList.length != 0"
        class="mx-auto submit_button mb-5"
        variant="outline-secondary"
        @click="getRecord"
        >{{ isLoading ? $t("loading...") : $t("load_more") }}</b-button
      >
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getDepositRecord } from "../../../system/api/api";
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
      address: "",
      totalAmount: 0,
      amount: 0,
      confirm_amount: 0,
      fee: 0,
      sec_pwd: "",
      selected: "COIN",
      isLoading: false,
      dataList: [],
      currentPage: 1,
      lastPage: 1,
      site: ["pending", "approved","rejected"],
    };
  },
  props: ["success"],
  methods: {
    selectIndex(i) {
      this.selected = i;
      this.sec_pwd = "";
      this.dataList = [];
      this.currentPage = 1;
      this.lastPage = 1;

      this.getRecord();
    },

    getRecord() {
      var result = getDepositRecord(this.selected, this.currentPage);
      var self = this;
      self.isLoading = true;

      result
        .then(function (value) {
          var dataList = value.data.data.data;
          self.currentPage += 1;
          self.lastPage = value.data.data.last_page;
          for (let i = 0; i < dataList.length; i++) {
            self.dataList.push(dataList[i]);
          }
          self.isLoading = false;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.getRecord();
  },
};
</script>

<style>
</style>