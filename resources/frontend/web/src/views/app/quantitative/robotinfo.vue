<template>
  <div class="">
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
      <b-button
        type="button"
        variant="outline-primary"
        class="mb-4"
        @click="backPage"
      >
        <i class="dd-arrow i-Arrow-Left"></i
      ></b-button>
      <b-row align-h="center">
        <b-col md="6">
          <b-card>
            <b-row align-h="between" align-v="center">
              <b-col cols="7">
                <b-row align-v="center">
                  <div
                    class="text-center ml-3 mr-2"
                    style="width: 25px; height: 25px"
                  >
                    <img
                      v-if="$route.query.platform == 'binance'"
                      :src="'https://atozbot.live/images/coin/BNB.png'"
                    />
                    <img
                      v-else
                      :src="'https://atozbot.live/images/coin/HT.png'"
                    />
                  </div>
                  <h6 class="text-muted mb-0 mx-1 text-12 font-weight-bold">
                    {{ marketName }}
                  </h6>
                  <div v-if="robotInfo != null">
                    <div
                      class="text-success mx-1"
                      :class="{
                        'text-danger': robotInfo.status == 0,
                      }"
                    >
                      &#8226;
                      <small
                        v-if="
                          robotInfo.status == 0 &&
                          robotInfo.values_str != null &&
                          robotInfo.values_str.length != 0
                        "
                        class="text-danger font-weight-bold text-8"
                        >{{ $t("stopped") }}</small
                      >
                      <small
                        v-if="
                          robotInfo.status == 0 && robotInfo.values_str == null
                        "
                        class="text-danger font-weight-bold"
                        >{{ $t("paused") }}</small
                      >
                      <!-- <small v-else class="text-danger font-weight-bold">{{
                        $t("paused")
                      }}</small> -->
                    </div>
                  </div>
                </b-row>
              </b-col>
              <b-col cols="5" class="text-right">
                <div>
                  <small>{{ $t("estimate_cover_price") }}</small>
                </div>
                <div>
                  <span v-if="robotInfo != null && robotInfo != ''">{{
                    robotInfo.estimate_cover_price
                  }}</span>
                  <span>0.00</span>
                </div>
              </b-col>
            </b-row>

            <b-row class="my-3">
              <b-col cols="5" class="text-left">
                <div>
                  <span v-if="infoDetail != null && infoDetail != ''">{{
                    infoDetail.deal_money
                  }}</span>
                  <span>0.00</span>
                </div>
                <div>
                  <small>{{ $t("position_amount") }} <br />(USDT)</small>
                </div>
              </b-col>
              <b-col cols="3" class="text-center p-0">
                <div>
                  <span v-if="infoDetail != null && infoDetail != ''">{{
                    infoDetail.base_price
                  }}</span>
                  <span>0.00</span>
                </div>
                <div>
                  <small>{{ $t("avg_price") }}</small>
                </div>
              </b-col>
              <b-col cols="4" class="text-right">
                <div>
                  <span v-if="infoDetail != null && infoDetail != ''">{{
                    infoDetail.order_count
                  }}</span>
                  <span>0.00</span>
                </div>
                <div>
                  <small>{{ $t("current_cycle_time") }}</small>
                </div>
              </b-col>
            </b-row>

            <b-row class="my-2">
              <b-col cols="5" class="text-left">
                <div>
                  <span v-if="infoDetail != null && infoDetail != ''">{{
                    infoDetail.deal_amount
                  }}</span>
                  <span>0.00</span>
                </div>
                <div>
                  <small>{{ $t("position_quantity") }} (USDT)</small>
                </div>
              </b-col>
              <b-col cols="3" class="text-center p-0">
                <div>
                  <span v-if="infoDetail != null && infoDetail != ''">{{
                    infoDetail.price
                  }}</span>
                  <span>0.00</span>
                </div>
                <div>
                  <small>{{ $t("current_price") }}</small>
                </div>
              </b-col>
              <b-col cols="4" class="text-right">
                <div>
                  <span v-if="infoDetail != null && infoDetail != ''">{{
                    infoDetail.revenue
                  }}</span>
                  <span>0.00</span>
                </div>
                <div>
                  <small>{{ $t("return_rate") }}</small>
                </div>
              </b-col>
            </b-row>
          </b-card>

          <b-col lg="12" xl="12" md="12" class="p-0">
            <b-row>
              <!-- Change Strategy -->
              <b-col md="6" lg="4" v-if="robotInfo == null" @click="nothing()">
                <div>
                  <b-card class="mt-30 o-hidden px-2">
                    <b-row align-v="center">
                      <div style="font-size:20px;margin-right:5px;">
                        1
                      </div>
                      <span>{{ $t("one_shot") }}</span>
                    </b-row>
                  </b-card>
                </div>
              </b-col>
              <b-col
                md="6"
                lg="4"
                v-if="robotInfo != null"
                v-b-modal.modal-strategy
                block
                variant="primary"
              >
                <b-card class="mt-30 o-hidden px-2">
                  <b-row align-v="center">
                    <div  v-if="robotInfo.recycle_status == 0" style="font-size:20px;margin-right:5px;">
                        1
                      </div>
                    <i
                      v-if="robotInfo.recycle_status == 1"
                      class="fa fa-refresh mr-2"
                      style="font-size: 20px"
                    ></i>
                    <span v-if="robotInfo.recycle_status == 0">{{ $t("one_shot") }}</span>
                    <span v-if="robotInfo.recycle_status == 1">{{ $t("circular") }}</span>
                  </b-row>
                </b-card>
              </b-col>
              <!-- Clearance Sale -->
              <b-col md="6" lg="4" v-if="robotInfo == null" @click="nothing()">
                <div>
                  <b-card class="mt-30 o-hidden px-2">
                    <b-row align-v="center">
                      <i
                        class="fa fa-trash mr-2"
                        style="font-size: 20px"
                      ></i>
                      <span>{{ $t("clearance_sale") }}</span>
                    </b-row>
                  </b-card>
                </div>
              </b-col>
              <b-col
                md="6"
                lg="4"
                v-if="robotInfo != null"
                v-b-modal.modal-delete
                block
                variant="primary"
              >
                <b-card class="mt-30 o-hidden px-2">
                  <b-row align-v="center">
                    <i
                      class="fa fa-trash mr-2"
                      style="font-size: 20px"
                    ></i>
                    <span>{{ $t("clearance_sale") }}</span>
                  </b-row>
                </b-card>
              </b-col>
              <!-- Margin Call -->
              <b-col md="6" lg="4" v-if="robotInfo == null" @click="nothing()">
                <div>
                  <b-card class="mt-30 o-hidden px-2">
                    <b-row align-v="center">
                      <i
                        class="fa fa-repeat mr-2"
                        style="font-size: 20px"
                      ></i>
                      <span>{{ $t("repleshiment") }}</span>
                    </b-row>
                  </b-card>
                </div>
              </b-col>
              <b-col
                md="6"
                lg="4"
                v-if="robotInfo != null"
                v-b-modal.modal-margin
                block
                variant="primary"
              >
                <div>
                  <b-card class="mt-30 o-hidden px-2">
                    <b-row align-v="center">
                      <i
                        class="fa fa-repeat mr-2"
                        style="font-size: 20px"
                      ></i>
                      <span>{{ $t("repleshiment") }}</span>
                    </b-row>
                  </b-card>
                </div>
              </b-col>
            </b-row>
          </b-col>
          <b-card class="my-4 p-0">
            <b-row class="">
              <b-col cols="6" class="border border-dark p-0">
                <b-row align-h="between" class="px-2 py-4">
                  <b-col cols="7">
                    <span>{{ $t("first_buy_in_amount") }}</span></b-col
                  >
                  <b-col cols="5"
                    ><div class="text-right">
                      <span v-if="robotInfo != null && robotInfo != ''">{{
                        robotInfo.first_order_value
                      }}</span>
                      <span></span></div
                  ></b-col>
                </b-row>
              </b-col>

              <b-col cols="6" class="border border-dark p-0">
                <b-row align-h="between" class="px-2 py-4">
                  <b-col cols="8">
                    <span>{{ $t("numbers_of_cover_up") }}</span></b-col
                  >
                  <b-col cols="4"
                    ><div class="text-right">
                      <span v-if="robotInfo != null && robotInfo != ''">{{
                        robotInfo.max_order_count
                      }}</span>
                      <span></span></div
                  ></b-col>
                </b-row>
              </b-col>

              <b-col cols="6" class="border border-dark p-0">
                <b-row align-h="between" class="px-2 py-4">
                  <b-col cols="7">
                    <span>{{ $t("take_profit_ratio") }}</span></b-col
                  >
                  <b-col cols="5"
                    ><div class="text-right">
                      <span v-if="robotInfo != null && robotInfo != ''"
                        >{{ robotInfo.stop_profit_rate }}%</span
                      >
                      <span></span></div
                  ></b-col>
                </b-row>
              </b-col>

              <b-col cols="6" class="border border-dark p-0">
                <b-row align-h="between" class="px-2 py-4">
                  <b-col cols="7">
                    <span>{{ $t("earnings_callback") }}</span></b-col
                  >
                  <b-col cols="5"
                    ><div class="text-right">
                      <span v-if="robotInfo != null && robotInfo != ''"
                        >{{ robotInfo.stop_profit_callback_rate }}%</span
                      >
                      <span></span></div
                  ></b-col>
                </b-row>
              </b-col>

              <b-col cols="6" class="border border-dark p-0 p-0">
                <b-row align-h="between" class="px-2 py-4">
                  <b-col cols="7">
                    <span>{{ $t("margin_call_drop") }}</span></b-col
                  >
                  <b-col cols="5"
                    ><div class="text-right">
                      <span v-if="robotInfo != null && robotInfo != ''"
                        >{{ robotInfo.cover_rate }}%</span
                      >
                      <span></span></div
                  ></b-col>
                </b-row>
              </b-col>

              <b-col cols="6" class="border border-dark p-0 p-0">
                <b-row align-h="between" class="px-2 py-4">
                  <b-col cols="7">
                    <span>{{ $t("buy_in_callback") }}</span></b-col
                  >
                  <b-col cols="5"
                    ><div class="text-right">
                      <span v-if="robotInfo != null && robotInfo != ''"
                        >{{ robotInfo.cover_callback_rate }}%</span
                      >
                      <span></span></div
                  ></b-col>
                </b-row>
              </b-col>
            </b-row>
          </b-card>
          <b-row>
            <b-col cols="6" class="pl-3 pr-1">
              <b-button
                block
                variant="primary"
                class="px-auto"
                @click="movePage"
                >{{
                  robotInfo == "" || robotInfo == null
                    ? $t("robot_setup")
                    : $t("transaction_settings")
                }}</b-button
              >
            </b-col>
            <b-col cols="6" class="pl-1 pr-3">
              <b-button
                v-if="
                  robotInfo != '' &&
                  robotInfo != null &&
                  robotInfo['status'] != 0
                "
                block
                variant="primary"
                v-b-modal.modal-pause
                >{{ $t("pause") }}</b-button
              >

              <b-button v-else v-b-modal.modal-play block variant="primary">{{
                $t("start_up")
              }}</b-button>
            </b-col>
          </b-row>
        </b-col>
      </b-row>
    </div>

    <b-modal
      id="modal-play"
      size="sm"
      centered
      :title="$t('start_robot')"
      hide-footer
    >
      <b-form
        class="mx-5"
        v-on:submit.prevent="playRobot"
        :disabled="isLoading"
      >
        <b-row align-h="center">
          <b-col md="10 mb-30">
            <div class="form-group row">
              <label for="pwd" class="col-sm-2 col-form-label">
                {{ $t("password") }}
              </label>
              <div class="col-sm-10">
                <input
                  type="password"
                  class="form-control"
                  id="pwd"
                  v-model="password"
                  required
                />
              </div>
            </div>
            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="mt-4 float-right">
                  <b-button
                    type="submit"
                    class="m-1"
                    variant="primary"
                    :disabled="isLoading"
                    >{{ $t("submit") }}</b-button
                  >
                </div>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>

    <b-modal
      id="modal-pause"
      size="sm"
      centered
      :title="$t('pause_robot')"
      hide-footer
    >
      <b-form
        class="mx-4"
        v-on:submit.prevent="pauseRobot"
        :disabled="isLoading"
      >
        <div class="form-group">
          <label for="pwd" class="col-form-label">
            {{ $t("password") }}
          </label>
          <div class="">
            <input
              type="password"
              class="form-control"
              id="pwd1"
              v-model="password"
              required
            />
          </div>
        </div>
        <div class="form-group row justify-content-end">
          <div class="col-sm-12">
            <div class="mt-4 float-right">
              <b-button
                type="submit"
                class="m-1"
                variant="primary"
                :disabled="isLoading"
                >{{ $t("submit") }}</b-button
              >
            </div>
          </div>
        </div>
      </b-form>
    </b-modal>

    <b-modal
      id="modal-strategy"
      size="sm"
      centered
      :title="$t('circular')"
      hide-footer
    >
      <b-form class="mx-5" v-on:submit.prevent="strategy" :disabled="isLoading">
        <b-row align-h="center">
          <b-col md="10 mb-30">
            <div class="form-group row">
              <label for="pwd" class="col-sm-2 col-form-label">
                {{ $t("password") }}
              </label>
              <div class="col-sm-10">
                <input
                  type="password"
                  class="form-control"
                  id="pwd"
                  v-model="password"
                  required
                />
              </div>
            </div>
            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="mt-4 float-right">
                  <b-button
                    type="submit"
                    class="m-1"
                    variant="primary"
                    :disabled="isLoading"
                    >{{ $t("submit") }}</b-button
                  >
                </div>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>

    <b-modal
      id="modal-delete"
      size="sm"
      centered
      :title="$t('clearance_sale')"
      hide-footer
    >
      <b-form
        class="mx-5"
        v-on:submit.prevent="clearance_sale"
        :disabled="isLoading"
      >
        <b-row align-h="center">
          <b-col md="10 mb-30">
            <div class="form-group row">
              <label for="pwd" class="col-sm-2 col-form-label">
                {{ $t("password") }}
              </label>
              <div class="col-sm-10">
                <input
                  type="password"
                  class="form-control"
                  id="pwd"
                  v-model="password"
                  required
                />
              </div>
            </div>
            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="mt-4 float-right">
                  <b-button
                    type="submit"
                    class="m-1"
                    variant="primary"
                    :disabled="isLoading"
                    >{{ $t("submit") }}</b-button
                  >
                </div>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>

    <b-modal
      id="modal-margin"
      size="sm"
      centered
      :title="$t('repleshiment')"
      hide-footer
    >
      <b-form class="mx-5" v-on:submit.prevent="margin" :disabled="isLoading">
        <b-row align-h="center">
          <b-col md="10 mb-30">
            <div class="form-group row">
              <label for="pwd" class="col-sm-2 col-form-label">
                {{ $t("password") }}
              </label>
              <div class="col-sm-10">
                <input
                  type="password"
                  class="form-control"
                  id="pwd"
                  v-model="password"
                  required
                />
              </div>
            </div>
            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="mt-4 float-right">
                  <b-button
                    type="submit"
                    class="m-1"
                    variant="primary"
                    :disabled="isLoading"
                    >{{ $t("submit") }}</b-button
                  >
                </div>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  getRobotInfo,
  play_Robot,
  pause_Robot,
  margin,
  strategy,
  clearanceSale,
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
      isLoading: true,
      stopLoop: false,
      robotInfo: null,
      infoDetail: null,
      password: "",
      marketName: "",
    };
  },
  methods: {
    playRobot() {
      let formData = new FormData();
      formData.append("robot_id", this.$route.query.id);
      formData.append("sec_password", this.password);
      var self = this;
      this.isLoading = true;
      var result = play_Robot(formData);
      result
        .then(function (value) {
          if (value.data.code > 0) {
            self.isLoading = false;
            self.$swal({
              icon: "error",
              text: self.$t(value.data.message),
            });
          } else {
            self.isLoading = false;
            self.$bvModal.hide("modal-play");
            self.password = "";
            self.$swal({
              icon: "success",
              text: self.$t(value.data.message),
            });
          }
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$bvModal.hide("modal-play");
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    pauseRobot() {
      let formData = new FormData();
      formData.append("robot_id", this.$route.query.id);
      formData.append("sec_password", this.password);
      var self = this;
      this.isLoading = true;
      var result = pause_Robot(formData);
      result
        .then(function (value) {
          if (value.data.code > 0) {
            self.isLoading = false;
            self.$swal({
              icon: "error",
              text: self.$t(value.data.message),
            });
          } else {
            self.isLoading = false;
            self.$bvModal.hide("modal-pause");
            self.password = "";
            self.$swal({
              icon: "success",
              text: self.$t(value.data.message),
            });
          }
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$bvModal.hide("modal-pause");
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    margin() {
      if (this.robotInfo.is_restock != 1 || this.robotInfo.values_str != null) {
        let formData = new FormData();
        formData.append("robot_id", this.$route.query.id);
        formData.append("sec_password", this.password);
        var self = this;
        this.isLoading = true;
        var result = margin(formData);
        result
          .then(function (value) {
            if (value.data.code > 0) {
              self.isLoading = false;
              self.$swal({
                icon: "error",
                text: self.$t(value.data.message),
              });
            } else {
              self.isLoading = false;
              self.$bvModal.hide("modal-margin");
              self.password = "";
              self.$swal({
                icon: "success",
                text: self.$t(value.data.message),
              });
            }
          })
          .catch(function (error) {
            self.isLoading = false;
            self.$bvModal.hide("modal-margin");
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          });
      } else {
        self.$refs.msg.makeToast("warning", self.$t("unable_operate"));
      }
    },
    strategy() {
      if (this.robotInfo.values_str != null) {
        let formData = new FormData();
        formData.append("robot_id", this.$route.query.id);
        formData.append("sec_password", this.password);
        var self = this;
        this.isLoading = true;
        var result = strategy(formData);
        result
          .then(function (value) {
            if (value.data.code > 0) {
              self.isLoading = false;
              self.$swal({
                icon: "error",
                text: self.$t(value.data.message),
              });
            } else {
              self.isLoading = false;
              self.$bvModal.hide("modal-strategy");
              self.password = "";
              self.$swal({
                icon: "success",
                text: self.$t(value.data.message),
              });
            }
          })
          .catch(function (error) {
            self.isLoading = false;
            self.$bvModal.hide("modal-strategy");
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          });
      } else {
        self.$refs.msg.makeToast("warning", self.$t("unable_operate"));
      }
    },
    clearance_sale() {
      if (this.robotInfo.values_str != null) {
        let formData = new FormData();
        formData.append("robot_id", this.$route.query.id);
        formData.append("sec_password", this.password);
        var self = this;
        this.isLoading = true;
        var result = clearanceSale(formData);
        result
          .then(function (value) {
            if (value.data.code > 0) {
              self.isLoading = false;
              self.$swal({
                icon: "error",
                text: self.$t(value.data.message),
              });
            } else {
              self.isLoading = false;
              self.$bvModal.hide("modal-delete");
              self.password = "";
              self.$swal({
                icon: "success",
                text: self.$t(value.data.message),
              });
            }
          })
          .catch(function (error) {
            self.isLoading = false;
            self.$bvModal.hide("modal-delete");
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          });
      } else {
        self.$refs.msg.makeToast("warning", self.$t("unable_operate"));
      }
    },
    nothing() {
      var self = this;
      self.$refs.msg.makeToast("warning", self.$t("unable_operate"));
    },
    backPage() {
      this.$router.go(-1);
    },
    movePage() {
      var isFirst = true;
      if (this.robotInfo == "" || this.robotInfo == null) {
        isFirst = true;
      } else {
        isFirst = false;
      }
      console.log(isFirst);
      this.$router.push({
        path: "/quantitative/robotSetting",
        query: {
          platform: this.$route.query.platform,
          isFirst: isFirst,
          marketID: this.$route.query.market_id,
          id: this.$route.query.id,
          marketName: this.$route.query.market,
          // item: JSON.stringify(this.robotInfo),
        },
      });
    },
    loadItems() {
      var robotID = this.$route.query.id;
      var result = getRobotInfo(robotID);
      var self = this;
      result
        .then(function (value) {
          self.robotInfo = value.data.data;
          console.log(self.robotInfo);
          if (self.robotInfo != null) {
            if (
              self.robotInfo.values_str != null &&
              self.robotInfo.values_str.length != 0
            ) {
              self.infoDetail = JSON.parse(value.data.data.values_str);
            }
          }
          self.isLoading = false;
          if (!self.stopLoop) {
            setTimeout(() => {
              self.loadItems();
            }, 1500);
          }
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.loadItems();
    this.marketName = this.$route.query.market;
  },
  beforeDestroy() {
    this.stopLoop = true;
  },
};
</script>