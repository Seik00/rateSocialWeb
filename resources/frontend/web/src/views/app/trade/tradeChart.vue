<template>
    <div class="main-content d-flex flex-column flex-grow-1 mx-3 " style="height:100vh">
        <div class="appBar position-relative">
            <!-- <a @click="$router.go(-1)">
                <img src="../../../assets/images/digital/right.svg" alt="">
            </a> -->
            <p>{{ type }}</p>
            <a class="right-side" @click="$router.push('/web/trade/tradeHistory?type=DA/USDT')">
                <i class="fa fa-history"></i>
            </a>
            <!-- <b-select class="w-50" v-model="type" :options="coinList"></b-select> -->
        </div>

        <h4 class="font-weight-bold" v-if="marketInfo">{{ (parseFloat(marketInfo.chart_price)).toFixed(4) }}</h4>
        <div class="mb-4">
            <trading-vue ref="tradingVue" :data="chart" :titleTxt="type" :width="width" :height="300"></trading-vue>
            <div class="mx-0" v-if="typeID == 1" style="">
                <div class="bg-greyblue p-3 w-100" style="">
                    <b-row>
                        <b-col cols="6">
                            <b-button block variant="success" @click="$bvModal.show('modal-buy')">{{ $t('buy')
                            }}</b-button></b-col>
                        <b-col cols="6">
                            <b-button block variant="danger" @click="checkUser">{{ $t('sell')
                            }}</b-button></b-col>
                    </b-row>

                </div>

            </div>
        </div>
        <div class="flex-grow-1 pb-5">
            <b-tabs>
                <b-tab :title="$t('assets')">
                    <img src="/images/coin/USDT.png" alt="" height="24px">
                    <span class="mx-2 text-white">USDT</span>

                    <b-row>
                        <b-col cols="6">
                            <p class="mb-0">{{ $t('current_balance') }}</p>
                            <p class="text-white">{{ parseFloat(point1).toFixed(2) }}</p>
                        </b-col>
                        <b-col cols="6">
                            <p class="mb-0">{{ $t('freeze_wallet') }}</p>
                            <p class="text-white">{{ parseFloat(point2).toFixed(2) }}</p>
                        </b-col>
                    </b-row>
                    <div v-for="item in assetList" :key="item.id">
                        <img :src="'/images/coin/' + item.coin_name + '.png'" @error="imageLoadError" alt="" height="24px">
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
                </b-tab>
                <b-tab v-if="this.userID == 1000000" :title="$t('open_orders')">
                    <b-card class="card-order mb-3" v-for="item in myOrderList" :key="item.id">
                        <div class="d-flex">
                            <h6>{{ item.market_name }}</h6>
                            <div class="ml-1 flex-grow-1">
                                <b-badge :variant="item.order_type == 'BUY' ? 'success' : 'danger'">{{ item.order_type
                                }}</b-badge>

                            </div>
                            <span>{{ item.updated_at }}</span>

                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-1 text-white">{{ $t('amount') + '(USDT)' }}</p>
                            <p class="mb-1">{{ (parseFloat(item.order_amount - item.order_left)).toFixed(2) + ' / ' +
                                (parseFloat(item.order_amount)).toFixed(2) }}</p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <p class="mb-1 text-white">{{ $t('price') }}</p>
                            <p class="mb-1">{{ (parseFloat(item.order_price)).toFixed(4) }}</p>
                        </div>

                        <div class="d-flex justify-content-end" v-if="item.match_status == 0 || item.match_status == 1">
                            <b-button @click="_cancelOrder(item)">{{ $t('cancel_order') }}</b-button>
                        </div>

                    </b-card>
                    <b-button v-if="currentPage <= lastPage" class="mx-auto submit_button mb-5" variant="outline-secondary"
                        @click="_myOrder">{{ isLoading ? $t("loading...") : $t("load_more") }}</b-button>

                </b-tab>
                <b-tab v-if="this.userID == 1000000" :title="$t('order_book')">
                    <b-row>
                        <b-col cols="6">
                            <span>{{ $t('buy') }}</span>

                        </b-col>
                        <b-col cols="6">
                            <span>{{ $t('sell') }}</span>

                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col cols="6">
                            <b-row v-for="item in buyList" :key="item.id">
                                <b-col cols="6">
                                    <span>{{ (parseFloat(item.order_left)).toFixed(4) }}</span>

                                </b-col>
                                <b-col cols="6">
                                    <span class="text-success">{{ (parseFloat(item.order_price)).toFixed(4) }}</span>

                                </b-col>
                            </b-row>

                        </b-col>
                        <b-col cols="6">
                            <b-row v-for="item in sellList" :key="item.id">
                                <b-col cols="6">
                                    <span class="text-danger">{{ (parseFloat(item.order_price)).toFixed(4) }}</span>

                                </b-col>
                                <b-col cols="6">
                                    <span>{{ (parseFloat(item.order_left)).toFixed(4) }}</span>

                                </b-col>
                            </b-row>

                        </b-col>
                    </b-row>

                </b-tab>
            </b-tabs>

        </div>
        <b-modal id="modal-buy" size="sm" centered :title="$t('buy') + ' ' + type" :hide-footer="true">
            <b-form class="mx-2" @submit.prevent="buyOrder">
                <b-form-group class="form-customize" :label="`${$t('price')} (${type.split('/')[1]})`" label-for="input-2">
                    <b-form-input class="form-control form-custom" min="1" step="any" v-model="price" type="number" readonly
                        ></b-form-input>
                </b-form-group>
                <b-form-group class="form-customize" :label="`${$t('amount')} (${type.split('/')[0]})`" label-for="input-2">
                    <b-form-input class="form-control form-custom" min="1" step="any" v-model="amount" type="number" 
                        required></b-form-input>
                </b-form-group>
                <b-form-group class="form-customize" :label="`${$t('estimate_cost')} (${type.split('/')[1]})`" label-for="input-2">
                    <b-form-input class="form-control form-custom" min="1" step="any" :value="price*amount" type="number" 
                        readonly></b-form-input>
                </b-form-group>
                <!-- <b-form-group class="form-customize" :label="$t('sec_password')" label-for="input-2">
                    <b-form-input class="form-control form-custom" v-model="sec_password" type="password"
                        required></b-form-input>
                </b-form-group> -->

                <b-button type="submit" block class="mt-4" variant="success" :disabled="isLoading">{{ $t("buy")
                }}</b-button>
            </b-form>
        </b-modal>
        <b-modal id="modal-sell" size="sm" centered :title="$t('sell') + ' ' + type" :hide-footer="true">
            <b-form class="mx-2" @submit.prevent="sellOrder">
                <b-form-group class="form-customize" :label="`${$t('price')} (${type.split('/')[1]})`" label-for="input-2">
                    <b-form-input class="form-control form-custom" min="1" step="any" v-model="sell_price" type="number"
                        required></b-form-input>
                </b-form-group>
                <b-form-group class="form-customize" :label="`${$t('amount')} (${type.split('/')[0]})`" label-for="input-2">
                    <b-form-input class="form-control form-custom" min="1" step="any" v-model="amount" type="number"
                        required></b-form-input>
                </b-form-group>
                <b-form-group class="form-customize" :label="`${$t('estimate_cost')} (${type.split('/')[1]})`" label-for="input-2">
                    <b-form-input class="form-control form-custom" min="1" step="any" :value="sell_price*amount" type="number" 
                        readonly></b-form-input>
                </b-form-group>
                <!-- <b-form-group class="form-customize" :label="$t('sec_password')" label-for="input-2">
                    <b-form-input class="form-control form-custom" v-model="sec_password" type="password"
                        required></b-form-input>
                </b-form-group> -->

                <b-button type="submit" block class="mt-4" variant="danger" :disabled="isLoading">{{ $t("sell")
                }}</b-button>
            </b-form>
        </b-modal>
        <Dialog ref="msg"></Dialog>
    </div>
</template>

<script>
import {
    placeOrder, marketInfo, myOrder, asset, cancelOrder, marketChart, getMemberInfo
} from "../../../system/api/api";
import TradingVue from 'trading-vue-js'
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";

export default {
    data() {
        return {
            type: '',
            typeID: '',
            amount: 0,
            price: 0,
            sell_price: 0,
            sec_password: '',
            isLoading: false,
            coinList: [],
            assetList: [],
            marketInfo: null,
            buyList: [],
            sellList: [],
            myOrderList: [],
            point1: "",
            point2: "",
            currentPage: 1,
            lastPage: 1,
            timer: null,
            userID: null,
            chartTimer: null,
            // width: 420 - 32,
            width: window.innerWidth - 32,
            height: window.innerHeight,
            chart: {
                ohlcv: [
                ]
            }
        }
    },
    components: {
        Dialog, TradingVue
    },
    watch: {
        type() {
            for (let i = 0; i < this.coinList.length; i++) {
                if (this.type == this.coinList[i].value) {
                    this.type = this.coinList[i].value;
                    this.typeID = this.coinList[i].id;
                    this.price = this.coinList[i].price;
                }

            }
        }

    },
    methods: {
        imageLoadError(event) {
            event.target.src = require('../../../assets/images/logo/logo/logo.png');
        },
        checkUser() {
            if (this.userID == 1000000) {
                this.$bvModal.show('modal-sell');

            } else {
                this.$refs.msg.makeToast("danger", this.$t('temporary_not_sell'));

            }
        },
        _asset() {
            var result = asset(this.type);

            var self = this;
            // this.isLoading = true;
            result
                .then(function (value) {
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
        _marketChart() {
            if (this.chartTimer != null) {
                clearTimeout(this.chartTimer);

            }
            var result = marketChart(this.type);

            var self = this;
            // this.isLoading = true;
            result
                .then(function (value) {
                    // for (let i = 0; i < value.data.data.chart.length; i++) {
                    //     value.data.data.chart[i].map(function (str) {
                    //         return parseFloat(str);
                    //     });

                    // }
                    self.chart.ohlcv = value.data.data.chart;
                    self.$refs.tradingVue.resetChart();
                    // self.isLoading = false;
                    self.chartTimer = setTimeout(() => {
                        self._marketChart();
                    }, 2000);
                })
                .catch(function (error) {
                    self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
                });
        },
        _marketInfo() {
            if (this.timer != null) {
                clearTimeout(this.timer);

            }
            var result = marketInfo(this.typeID);

            var self = this;
            // this.isLoading = true;
            result
                .then(function (value) {
                    self.buyList = value.data.data.buy_order;
                    self.sellList = value.data.data.sell_order;
                    if (self.sell_price == 0) {
                        self.sell_price = value.data.data.trade_market.price;

                    }
                        self.price = value.data.data.trade_market.price;
                    self.marketInfo = value.data.data.trade_market;

                    // self.isLoading = false;
                    self.timer = setTimeout(() => {
                        self._marketInfo();
                    }, 5000);
                })
                .catch(function (error) {
                    self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
                });
        },
        _myOrder() {
            var result = myOrder(this.currentPage);

            var self = this;
            this.isLoading = true;
            result
                .then(function (value) {
                    for (let i = 0; i < value.data.data.trade_order.data.length; i++) {
                        if (value.data.data.trade_order.data[i].match_status == 0 || value.data.data.trade_order.data[i].match_status == 1) {
                            self.myOrderList.push(value.data.data.trade_order.data[i]);
                        }

                    }

                    self.currentPage += 1;
                    self.lastPage = value.data.data.trade_order.last_page;
                    self.isLoading = false;
                })
                .catch(function (error) {
                    self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
                });
        },
        _cancelOrder(item) {
            let formData = new FormData();
            var self = this;
            formData.append("trade_order_id", item.id);
            var result = cancelOrder(formData);
            self.isLoading = true;

            result
                .then(function (value) {
                    if (value.data.error_code == 0) {
                        self.$refs.msg.makeToast("success", self.$t("operation_success"));
                        self._asset();
                        self.memberInfo();
                        self.myOrderList = [];
                        self.currentPage = 1;
                        self._myOrder();

                        // self.loadItems();
                    } else {
                        self.$refs.msg.makeToast("danger", self.$t(value.data.message));
                    }

                    self.sending = false;
                    self.isLoading = false;
                })
                .catch(function (error) {
                    self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
                    self.sending = false;
                    self.isLoading = false;
                });
            // self.price = 0;
            self.amount = 0;
        },
        buyOrder() {
            let formData = new FormData();
            var self = this;
            formData.append("trade_market_id", this.typeID);
            formData.append("order_type", "BUY");
            formData.append("order_price", this.price);
            formData.append("order_amount", this.amount);
            var result = placeOrder(formData);
            self.isLoading = true;

            result
                .then(function (value) {
                    if (value.data.error_code == 0) {
                        self.$refs.msg.makeToast("success", self.$t("operation_success"));
                        self.$bvModal.hide("modal-buy");
                        self._asset();
                        self.memberInfo();
                        self.myOrderList = [];
                        self.currentPage = 1;
                        self._myOrder();
                        // self.loadItems();
                    } else {
                        self.$refs.msg.makeToast("danger", self.$t(value.data.message));
                    }

                    self.sending = false;
                    self.isLoading = false;
                })
                .catch(function (error) {
                    self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
                    self.sending = false;
                    self.isLoading = false;
                });
            // self.price = 0;
            self.amount = 0;
        },
        sellOrder() {
            let formData = new FormData();
            var self = this;
            formData.append("trade_market_id", this.typeID);
            formData.append("order_type", "SELL");
            formData.append("order_price", this.sell_price);
            formData.append("order_amount", this.amount);
            var result = placeOrder(formData);
            self.isLoading = true;

            result
                .then(function (value) {
                    if (value.data.error_code == 0) {
                        self.$refs.msg.makeToast("success", self.$t("operation_success"));
                        self.$bvModal.hide("modal-sell");
                        self._asset();
                        self.memberInfo();
                        self.myOrderList = [];
                        self.currentPage = 0;
                        self._myOrder();
                        // self.loadItems();
                    } else {
                        self.$refs.msg.makeToast("danger", self.$t(value.data.message));
                    }
                    self.sending = false;
                    self.isLoading = false;
                })
                .catch(function (error) {
                    self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
                    self.sending = false;
                    self.isLoading = false;
                });
            // self.price = 0;
            self.amount = 0;
        },
        onResize() {
            this.width = window.innerWidth - 32;
            this.height = window.innerHeight
        },
        memberInfo() {
            var result = getMemberInfo();

            var self = this;
            this.isLoading = true;
            result
                .then(function (value) {
                    self.userID = value.data.data.id
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
    beforeDestroy() {
        clearTimeout(this.timer);
        clearTimeout(this.chartTimer);
        window.removeEventListener('resize', this.onResize)
    },
    mounted() {
        if (this.width > 420) {
            this.width = 420 - 32;

        }
        window.addEventListener('resize', this.onResize);
        this.coinList = JSON.parse(localStorage.getItem('market'));
        for (let i = 0; i < this.coinList.length; i++) {
            if (this.$route.query.type == this.coinList[i].value) {
                this.type = this.coinList[i].value;
                this.typeID = this.coinList[i].id;
                this.price = this.coinList[i].price;
            }

        }
        this.memberInfo();
        this._marketInfo();
        this._myOrder();
        this._marketChart();
        this._asset();
        // this.type = this.$route.query.type ?? this.coinList[0].value;

    }

}
</script>