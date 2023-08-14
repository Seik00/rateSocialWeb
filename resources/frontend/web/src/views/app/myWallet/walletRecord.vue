<template>
  <div class="main-content d-flex flex-column flex-grow-1 px-4 ">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
    </div>
    <h3 class="mb-3 font-weight-bold text-black">{{ $t("transaction") }}</h3>
    <div class="d-flex pb-3" style="overflow-x: scroll;">
      <div class="card-option mr-2" :class="{'active':selectedType==item}" v-for="item in option" :key="item" @click="selectedType=item">
        {{ $t(item) }}
      </div>
    </div>
    <b-row align-h="center" class="mt-2" style="margin-bottom: 10px">
      <b-col cols="6" style="text-align: left">
        <b-card class="mb-3 bg-greyblue px-0">
          <div class="d-flex">
            <p class="text-10 font-weight-bold mb-0">{{ $t('today_income') }}</p>

          </div>
          <img src="../../../assets/images/digital/currency.svg" alt="">
          <div class="d-flex justify-content-end align-items-end mt-3">
            <div>
              <div class="d-flex align-items-end"><span class="text-8 mr-1 mb-1 text-white">USDT</span>
                <h6 class="mb-0 font-weight-bold">{{ parseFloat(today_bonus).toFixed(2) }}</h6>
              </div>
            </div>
          </div>

        </b-card>
      </b-col>
      <b-col cols="6" style="text-align: left">

        <b-card class="mb-3 bg-greyblue px-0">
          <div class="d-flex">
            <p class="text-10 font-weight-bold mb-0">{{ $t('total_income') }}</p>

          </div>
          <img src="../../../assets/images/digital/currency.svg" alt="">
          <div class="d-flex justify-content-end align-items-end mt-3">
            <div>
              <div class="d-flex align-items-end"><span class="text-8 mr-1 mb-0 text-white">USDT</span>
                <h6 class="mb-0 font-weight-bold">{{ parseFloat(info.total_income).toFixed(2) }}</h6>
              </div>
            </div>
          </div>

        </b-card>
      </b-col>
    </b-row>
    <!-- <b-button @click="$router.push('/web/myTeam')" class="submit_button w-100 mb-3 d-flex justify-content-between"
      variant="secondary">
      <img src="../../../assets/images/digital/group.svg" alt="">
      <div class="ml-3 text-left flex-grow-1">{{ $t("team") }}</div>
      <img src="../../../assets/images/digital/right.svg" alt="">
    </b-button> -->
    <div class="d-flex flex-column flex-grow-1" style="overflow-y: scroll; height: 5px;">
      <div v-if="currentPage > lastPage && dataList.length == 0" style="
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                      ">
        <p>No Data</p>
      </div>

      <div class="bg-greyblue px-4 py-2 mb-3 font-weight-600" style="border-radius: 10px" v-for="item in dataList"
        :key="item.id">
        <b-row align-v="center" align-h="between">
          <b-col cols="10">
            <p class="mb-1 text-white">{{ ($i18n.locale == "zh") ? item.detail : item.detailen }}</p>
            <!-- <span>{{ item.updated_at }}</span> -->
          </b-col>
          <b-col cols="2">
            <!-- <span class="text-white">{{ item.action }}{{ item.found }}</span> -->
          </b-col>
        </b-row>
        <b-row align-v="center" align-h="between">
          <b-col cols="6">
            <p class="mb-1 text-muted">{{ $t('previous_balance') }}</p>
          </b-col>
          <b-col cols="5">
            <span class="text-white text-right d-block">{{ item.previous }}</span>
          </b-col>
        </b-row><b-row align-v="center" align-h="between">
          <b-col cols="6">
            <p class="mb-1 text-muted">{{ $t('change') }}</p>
          </b-col>
          <b-col cols="5">
            <span class="text-white text-right d-block">{{ item.action }}{{ item.found }}</span>
          </b-col>
        </b-row><b-row align-v="center" align-h="between">
          <b-col cols="6">
            <p class="mb-1 text-muted">{{ $t('current_balance') }}</p>
            <!-- <span>{{ item.updated_at }}</span> -->
          </b-col>
          <b-col cols="5">
            <span class="text-white text-right d-block">{{ item.current }}</span>
          </b-col>
        </b-row>
      </div>
      <b-button v-if="currentPage <= lastPage" class="mx-auto submit_button mb-5" variant="outline-secondary"
        @click="loadItems">{{ isLoading ? $t("loading...") : $t("load_more") }}</b-button>

    </div>
    <div style="height:100px"></div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getUserWalletRecord, getMemberInfo, getOrderInfo } from "../../../system/api/api";
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
      selectedType: 'deposit',
      isLoading: true,
      point1: [],
      dataList: [],
      canClear: false,
      option: ['deposit', 'withdraw', 'referral', 'earning'],
      wallet: "point1",
      wallet2: "point2",
      totalRecords: 0,
      today_bonus: 0,
      pageNumber: 1,
      message: "",
      stock: "",
      money: "",
      status: true,
      balance: "",
      currentPage: 1,
      lastPage: 1,
      info: null
    };
  },
  props: ["success"],
  methods: {
    clipboardSuccessHandler({ value }) {
      this.$bvToast.toast(value, {
        title: this.$t("copied"),
        variant: "success",
        solid: true,
      });
    },

    clipboardErrorHandler() {
      //// console.log('error', value)
    },
    onPageChange(params) {
      this.pageNumber = params.currentPage;
      this.loadItems(this.wallet);
      var container = this.$el.querySelector("#table");
      var top = container.offsetTop;

      window.scrollTo(0, top);
    },
    onSearch() {
      this.pageNumber = 1;
      this.loadItems(this.wallet);
    },
    onCancel() {
      this.canClear = false;
      this.loadItems(this.wallet);
    },
    getInfo() {
      var result = getMemberInfo();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.balance = value.data.point1;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    orderInfo() {
      var result = getOrderInfo();

      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          console.log(value);
          self.today_bonus = value.data.data.today_bonus;
          // self.wallets = value.data.data.wallet;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    loadItems() {
      var result = getUserWalletRecord(this.wallet, this.currentPage);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.record.data;
          console.log(value.data.data.record.data);
          self.currentPage += 1;
          self.lastPage = value.data.data.record.last_page;
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
    this.info = JSON.parse(localStorage.getItem('info'));
    this.loadItems();
    this.orderInfo();
  },
};
</script>

<style>
#fileName span {
  white-space: nowrap;
  overflow: hidden;
  display: inline-block;
}

#fileName span:first-child {
  width: 60px;
  text-overflow: ellipsis;
}

#fileName span+span {
  width: 34px;
  direction: rtl;
  text-align: right;
  /* text-overflow: ellipsis; */
}

.upload-hint {
  position: absolute;
  width: 100%;
  height: 100%;
  border-style: dotted;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.hiddenClass {
  pointer-events: none;
  display: none;
}

.addressWidth {
  max-width: 200px;
}

.txidWidth {
  max-width: 275px;
}
</style>