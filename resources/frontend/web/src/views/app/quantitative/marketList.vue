<template>
  <div class="main-content">
    <div style="position: relative">
      <div
        v-if="isLoading"
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
      <b-tabs pills align="start">
        <b-tab no-body title="Binance" active @click="load('binance')">
          <h3>{{ $t("balance") }} : {{ balance }}</h3>
          <b-row class="justify-content-md-start">
            <b-col lg="12" xl="12" md="12" class="p-0">
              <b-row>
                <b-col md="4" lg="4" v-for="item in robotList" :key="item.id">
                  <router-link
                    tag="a"
                    :to="
                      '/quantitative/robotInfo?id=' +
                      (item.robot_info == null ? '' : item.robot_info.id) +
                      '&market=' +
                      item.market_name +
                      '&market_id=' +
                      item.id +
                      '&platform=binance'
                    "
                  >
                    <b-card
                      v-if="item.platform.toLowerCase() == 'binance'"
                      class="mb-30 o-hidden px-2"
                    >
                      <b-row align-h="between" align-v="center">
                        <b-row align-h="start" align-v="center" class="m-0">
                          <div
                            class="text-center"
                            style="width: 25px; height: 25px"
                          >
                            <img
                              :src="
                                'https://atozbot.live/images/coin/' +
                                item.market_name.split('/')[0] +
                                '.png'
                              "
                            />
                          </div>
                          <div>
                            <h6 class="text-muted mb-0 mx-1 text-12">
                              {{ item.market_name }}
                            </h6>
                          </div>
                          <div v-if="item.robot_info != null">
                            <div
                              class="bg-success px-2 py-0 rounded"
                              v-if="
                                item.robot_info.status == 0 &&
                                item.robot_info.show_msg == '卖出成功' &&
                                item.robot_info.values_str == ''
                              "
                            >
                              <small>{{ $t("sold") }}</small>
                            </div>
                            <div class="bg-success px-2 py-0 rounded" v-else>
                              <small
                                v-if="item.robot_info.recycle_status == 0"
                                >{{ $t("single") }}</small
                              >
                              <small v-else>{{ $t("cycle") }}</small>
                            </div>
                          </div>

                          <div v-if="item.robot_info != null">
                            <div
                              class="text-success mx-1"
                              :class="{
                                'text-danger': item.robot_info.status == 0,
                              }"
                            >
                              &#8226;
                              <small
                                v-if="
                                  item.robot_info.status == 0 &&
                                  item.robot_info.values_str != null
                                "
                                class="text-danger font-weight-bold text-8"
                                >{{ $t("stopped") }}</small
                              >
                              <small
                                v-else-if="
                                  item.robot_info.status == 0 &&
                                  item.robot_info.values_str == null
                                "
                                class="text-danger font-weight-bold"
                                >{{ $t("paused") }}</small
                              >
                            </div>
                          </div>
                        </b-row>
                        <div
                          v-if="item.robot_info != null"
                          class="bg-success px-2 py-0 rounded"
                        >
                          <small
                            >P/L :
                            {{
                              parseFloat(item.robot_info.revenue).toFixed(2)
                            }}%</small
                          >
                        </div>
                        <div v-else class="bg-success px-2 py-0 rounded">
                          <small>P/L : 0.00%</small>
                        </div>
                      </b-row>
                      <b-row class="my-2">
                        <b-col cols="6">
                          <b-row>
                            <span class="pr-1">{{ $t("market_price") }}</span>
                            {{ item.price }}</b-row
                          >
                        </b-col>
                        <b-col cols="6">
                          <b-row align-h="end">
                            <span class="pr-1">{{ $t("exchange_fluc") }}</span>
                            {{ parseFloat(item.change).toFixed(2) }}%
                          </b-row>
                        </b-col>
                      </b-row>
                      <b-row>
                        <b-col cols="6">
                          <b-row>
                            <span class="pr-1">{{ $t("quantity") }}</span>
                            <span v-if="item.robot_info != null">
                              {{ dealAmount(item) }} </span
                            ><span v-else>0.00</span></b-row
                          >
                        </b-col>
                        <b-col cols="6">
                          <b-row align-h="end">
                            <span class="pr-1">{{ $t("amount") }}</span>
                            <span v-if="item.robot_info != null">
                              {{ dealMoney(item) }} </span
                            ><span v-else>0.00</span>
                          </b-row>
                        </b-col>
                      </b-row>
                    </b-card>
                  </router-link>
                </b-col>
              </b-row>
            </b-col>
          </b-row>
        </b-tab>

        <b-tab title="Huobi" @click="load('huobi')">
          <h3>{{ $t("balance") }} : {{ balance }}</h3>
          <b-row class="justify-content-md-start">
            <b-col lg="12" xl="12" md="12" class="p-0">
              <b-row>
                <b-col md="4" lg="4" v-for="item in robotList2" :key="item.id">
                  <router-link
                    tag="a"
                    :to="
                      '/quantitative/robotInfo?id=' +
                      (item.robot_info == null ? '' : item.robot_info.id) +
                      '&market=' +
                      item.market_name +
                      '&market_id=' +
                      item.id +
                      '&platform=huobi'
                    "
                  >
                    <b-card
                      v-if="item.platform.toLowerCase() == 'huobi'"
                      class="mb-30 o-hidden px-2"
                    >
                      <b-row align-h="between" align-v="center">
                        <b-row align-h="start" align-v="center" class="m-0">
                          <div
                            class="text-center"
                            style="width: 25px; height: 25px"
                          >
                            <img
                              :src="
                                'https://atozbot.live/images/coin/' +
                                item.market_name.split('/')[0] +
                                '.png'
                              "
                            />
                          </div>
                          <div>
                            <h6 class="text-muted mb-0 mx-1 text-12">
                              {{ item.market_name }}
                            </h6>
                          </div>
                          <div v-if="item.robot_info != null">
                            <div
                              class="bg-success px-2 py-0 rounded"
                              v-if="
                                item.robot_info.status == 0 &&
                                item.robot_info.show_msg == '卖出成功' &&
                                item.robot_info.values_str == ''
                              "
                            >
                              <small>{{ $t("sold") }}</small>
                            </div>
                            <div class="bg-success px-2 py-0 rounded" v-else>
                              <small
                                v-if="item.robot_info.recycle_status == 0"
                                >{{ $t("single") }}</small
                              >
                              <small v-else>{{ $t("cycle") }}</small>
                            </div>
                          </div>

                          <div v-if="item.robot_info != null">
                            <div
                              class="text-success mx-1"
                              :class="{
                                'text-danger': item.robot_info.status == 0,
                              }"
                            >
                              &#8226;
                              <small
                                v-if="
                                  item.robot_info.status == 0 &&
                                  item.robot_info.values_str != null
                                "
                                class="text-danger font-weight-bold text-8"
                                >{{ $t("stopped") }}</small
                              >
                              <small
                                v-else-if="
                                  item.robot_info.status == 0 &&
                                  item.robot_info.values_str == null
                                "
                                class="text-danger font-weight-bold"
                                >{{ $t("paused") }}</small
                              >
                            </div>
                          </div>
                        </b-row>
                        <div
                          v-if="item.robot_info != null"
                          class="bg-success px-2 py-0 rounded"
                        >
                          <small
                            >P/L :
                            {{
                              parseFloat(item.robot_info.revenue).toFixed(2)
                            }}%</small
                          >
                        </div>
                        <div v-else class="bg-success px-2 py-0 rounded">
                          <small>P/L : 0.00%</small>
                        </div>
                      </b-row>
                      <b-row class="my-2">
                        <b-col cols="6">
                          <b-row>
                            <span class="pr-1">{{ $t("market_price") }}</span>
                            {{ item.price }}</b-row
                          >
                        </b-col>
                        <b-col cols="6">
                          <b-row align-h="end">
                            <span class="pr-1">{{ $t("exchange_fluc") }}</span>
                            {{ parseFloat(item.change).toFixed(2) }}%
                          </b-row>
                        </b-col>
                      </b-row>
                      <b-row>
                        <b-col cols="6">
                          <b-row>
                            <span class="pr-1">{{ $t("quantity") }}</span>
                            <span v-if="item.robot_info != null">
                              {{ dealAmount(item) }} </span
                            ><span v-else>0.00</span></b-row
                          >
                        </b-col>
                        <b-col cols="6">
                          <b-row align-h="end">
                            <span class="pr-1">{{ $t("amount") }}</span>
                            <span v-if="item.robot_info != null">
                              {{ dealMoney(item) }} </span
                            ><span v-else>0.00</span>
                          </b-row>
                        </b-col>
                      </b-row>
                    </b-card>
                  </router-link>
                </b-col>
              </b-row>
            </b-col>
          </b-row>
        </b-tab>
      </b-tabs>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getMarketList, getBalance } from "../../../system/api/api";
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
      isLoading: true,
      startLoading: false,
      robotList: [],
      robotList2: [],
      stopLoop1: false,
      stopLoop2: true,
      platform: "binance",
      balance: "0.00",
    };
  },
  props: ["success"],
  methods: {
    dealAmount(data) {
      if (
        data["robot_info"]["values_str"] != null &&
        data["robot_info"]["values_str"] != ""
      ) {
        var jsonData = JSON.parse(data["robot_info"]["values_str"]);
        return jsonData["deal_amount"].toFixed(5);
      } else {
        return "0.00";
      }
    },

    dealMoney(data) {
      if (
        data["robot_info"]["values_str"] != null &&
        data["robot_info"]["values_str"] != ""
      ) {
        var jsonData = JSON.parse(data["robot_info"]["values_str"]);
        return jsonData["deal_money"].toFixed(5);
      } else {
        return "0.00";
      }
    },
    load(p) {
      if (p == "binance") {
        this.loadBinance();
        this.stopLoop1 = false;
        this.stopLoop2 = true;
      } else {
        this.loadHuobi();
        this.stopLoop2 = false;
        this.stopLoop1 = true;
      }
      this.isLoading = true;
      if (this.robotList2.length == 0) {
        this.startLoading = true;
      }

      this.platform = p;
      this.balance = "0.00";
      this.loadBalance();
    },
    loadBinance() {
      this.platform = "binance";
      var result = getMarketList(this.platform);
      var self = this;
      console.log("part1");
      // this.isLoading = true;
      result
        .then(function (value) {
          self.robotList = value.data.data;
          self.isLoading = false;
          if (!self.stopLoop1) {
            setTimeout(() => {
              self.loadBinance();
            }, 1500);
          }
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    loadHuobi() {
      this.platform = "huobi";
      var result = getMarketList(this.platform);
      var self = this;
      console.log("part2");
      result
        .then(function (value) {
          self.robotList2 = value.data.data;
          self.isLoading = false;
          self.startLoading = false;
          if (!self.stopLoop2) {
            setTimeout(() => {
              self.loadHuobi();
            }, 1500);
          }
        })
        .catch(function (error) {
          self.isLoading = false;
          self.startLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    loadBalance() {
      let formData = new FormData();
      formData.append("platform", this.platform);
      var result = getBalance(formData);
      var self = this;
      result
        .then(function (value) {
          if (value.data.error_code == 0) {
            self.balance = value.data.data;
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.loadBinance();
    this.loadBalance();
  },
  beforeDestroy() {
    this.stopLoop1 = true;
    this.stopLoop2 = true;
  },
};
</script>