<template>
  <div class="main-content d-flex flex-column flex-grow-1 mx-3 " style="height:100vh">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
      <span>{{ $t("withdraw") }}</span>
    </div>

    <div class="">
      
      <b-row align-h="between" class="mt-3 mb-3 ">
          <b-col cols="6" class="pr-0">
            <div class="tabContainer text-center" :class="{ active: selected == 'BANK' }" @click="selectIndex('BANK')">
              <div class="tabImage">
                <img src="../../../assets/images/digital/surface1.svg" alt="">
              </div>
              <span>{{ $t("bank") }}</span>
            </div>
          </b-col>
          <b-col cols="6" class="pl-0">
            <div class="tabContainer text-center" :class="{ active: selected == 'COIN' }" @click="selectIndex('COIN')">
              <div class="tabImage">
                <img src="../../../assets/images/digital/Cjdowner-Cryptocurrency-Flat-Tether-USDT.svg" alt="">
              </div>
              <span>{{ $t("crypto") }}</span>
            </div>
          </b-col>
        </b-row>
    </div>

    <b-card class="mb-3 bg-greyblue py-5" @click="$router.push('/web/withdraw/withdraw')">
      <!-- <h5 class="font-weight-bold mb-2">{{ $t('balance') }}</h5> -->
      <div class="d-flex align-items-end justify-content-center">
        <span class="text-12 mb-0 mr-2 text-white">USDT</span>
        <h3 class="font-weight-bold mb-0">{{ parseFloat(point1).toFixed(2) }}</h3>
      </div>
      <img class="position-absolute m-3" style="bottom: 0;right: 0" height="20px"
        src="../../../assets/images/digital/right-arrow (5).svg" alt="">
    </b-card>
    <div class="mt-2 d-flex flex-column flex-grow-1 position-relative" style="overflow-y: scroll;">

      <p class="font-weight-bold">{{ $t('withdraw_record') }}</p>
      <div v-if="currentPage > lastPage && dataList.length == 0" style="
                          position: absolute;
                          top: 50%;
                          left: 50%;
                          transform: translate(-50%, -50%);
                        ">
        <p>No Data</p>
      </div>
      <div v-else-if="dataList.length == 0" style="
                          position: absolute;
                          top: 50%;
                          left: 50%;
                          transform: translate(-50%, -50%);
                        ">
        <p>{{ $t("loading...") }}</p>
      </div>

      <div class="bg-greyblue px-4 py-2 mb-3 font-weight-600" style="border-radius: 10px" v-for="item in dataList"
        :key="item.id">
        <b-row align-v="center" align-h="between">
          <b-col cols="6">
            <p class="mb-1 text-white">{{ $t("withdraw") }}</p>
            <!-- <span>{{ item.updated_at }}</span> -->
          </b-col>
          <b-col cols="6">
            <span class="text-right d-block">{{ $t(site[item.status]) }}</span>
          </b-col>
        </b-row>
        <b-row align-v="center" align-h="between">
          <b-col cols="6">
            <p class="mb-1 text-muted">{{ $t('amount') }}</p>
          </b-col>
          <b-col cols="5">
            <span class="text-white text-right d-block">{{ item.amount }}</span>
            <span class="text-10 text-right d-block" v-if="selected == 'BANK'">≈ {{ item.currency }} {{ item.get_amount }}</span>
          </b-col>
        </b-row>
        <b-row align-v="center" align-h="between">
          <b-col cols="6">
            <p class="mb-1 text-muted">{{ $t('date') }}</p>
          </b-col>
          <b-col cols="6">
            <span class="text-white text-right d-block">{{ item.updated_at }}</span>
          </b-col>
        </b-row>

      </div>
      <b-button v-if="currentPage <= lastPage && dataList.length != 0" class="mx-auto submit_button mb-5"
        variant="outline-secondary" @click="getRecord">{{ isLoading ? $t("loading...") : $t("load_more") }}</b-button>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getWithdrawRecord } from "../../../system/api/api";
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
      point1: 0,
      confirm_amount: 0,
      fee: 0,
      sec_pwd: "",
      selected: "COIN",
      isLoading: false,
      dataList: [],
      currentPage: 1,
      lastPage: 1,
      site: ["pending", "approved", "success", "rejected"],
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
      var result = getWithdrawRecord(this.selected, this.currentPage);
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
    let info = JSON.parse(localStorage.getItem('info'));
    this.point1 = info.point1;
    this.getRecord();
  },
};
</script>

<style></style>