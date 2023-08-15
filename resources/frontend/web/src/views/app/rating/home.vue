<template>
    <div class="main-content d-flex flex-column flex-grow-1 px-4 position-relative" style="height: 100vh;">
        <img class="rating-bg" src="../../../assets/images/digital/rating.png" alt="">
        <div class="appBar">
            <a @click="$router.go(-1)">
                <img src="../../../assets/images/digital/right.svg" alt="">
            </a>
        </div>
        <h3 class="mb-3 font-weight-bold text-black text-34" style="z-index: 3">{{ $t("rating") }}</h3>

        <b-card class="mb-1 mt-4 p-2 bg-darkpurple">
            <div class="d-flex justify-content-between align-items-end mb-3">

                <h6 class="font-weight-bold mb-0 text-white">{{ $t('balance') }}</h6>
                <span class="text-14 text-white font-weight-bold">{{ currentPackage }} <img height="14px"
                        src="../../../assets/images/digital/currency.svg" alt=""></span>
            </div>
            <div class="d-flex align-items-end">
                <h3 class="font-weight-bold mb-0 text-white">USDT {{ point1 }}</h3>

            </div>
        </b-card>
        <b-card class="mb-3 mt-4 p-2 bg-darkpurple">
            <h5 class="font-weight-bold mb-0 text-white">{{ $t('your_profile') }}</h5>
            <b-row class="mb-2 mt-3">
                <b-col cols="12" class="mb-4">
                    <b-card class="card-primary">
                        <div class="d-flex align-items-center">
                            <div class="mr-3 h-100" style="aspect-ratio: 1;flex-grow: 3;"></div>
                            <div style="flex-grow: 5;">
                                <span class=" text-white">Today App Rated</span>
                                <h4 class="text-white mb-0 font-weight-bold"><span class="">{{ today_completed_order
                                }}</span> <span class="">/
                                        {{ boost_time }}</span></h4>
                            </div>

                        </div>

                    </b-card>
                </b-col>
                <b-col cols="12" class="">
                    <b-card class="">
                        <div class="d-flex align-items-center">
                            <div class="mr-3 h-100" style="aspect-ratio: 1;flex-grow: 3;"></div>
                            <div style="flex-grow: 5;">
                                <span class=" text-green">{{ $t('today_boost_profit') }}</span>
                                <h4 class="text-green mb-0 font-weight-bold"><span class="">RM {{
                                    parseFloat(today_bonus).toFixed(2) }}</span></h4>
                            </div>

                        </div>

                    </b-card></b-col>
            </b-row>

        </b-card>
        <b-row>
            <b-col cols="6">
                <b-card class="bg-brightGreen" @click="getInfo">
                    <div v-if="isLoading" class="mb-0 text-center">
                        <div class="spinner spinner-primary text-16" style="height: 20px;width: 20px;"></div>
                    </div>
                    <p v-else class="mb-0 text-16 text-center font-weight-bold">{{ $t('app_rating') }}</p>
                </b-card></b-col>
            <b-col cols="6">
                <b-card class="" @click="$router.push('/web/rating/record')">
                    <p class="mb-0 text-16 text-center text-brightGreen font-weight-bold">{{ $t('record') }}</p>
                </b-card></b-col>
        </b-row>
        <vue-bottom-sheet ref="myBottomSheet" :max-height="'90vh'" class="position-relative">
            <div class="rating-icon">
                <img src="../../../assets/images/digital/app-example.png" alt="">
            </div>

            <div class="text-center mx-4" style="margin-top: 40px;">
                <h3 class="text-black font-weight-bold"><strong>Lorem Ipsum</strong></h3>
                <p>
                    Connect with friend , family & people
                </p>
                <b-card class="bg-purple">
                    <div class="d-flex align-items-center px-3 text-20">
                        <i class="fa fa-dollar text-white "></i>
                        <p class="flex-grow-1 text-14 text-center mb-0 text-white font-weight-bold">Rate to earn RM
                            {{ cOrder_total_return }}</p>

                    </div>
                </b-card>
                <p class="mt-3 font-weight-bold">
                    App Code : UxY338910Vq
                </p>
                <div class="d-flex justify-content-center mb-4">
                    <div v-for="item in 5" :key="item" class="mx-1" @click="rating = item">
                        <img v-if="item <= rating" src="../../../assets/images/digital/star_bright.png" alt="">
                        <img v-else src="../../../assets/images/digital/star.png" alt="">
                    </div>

                </div>

            </div>
            <div class="mx-4">
                <p class="font-weight-bold">Your Review ( Choose 1 )</p>

                <b-card class="mb-3">
                    <div class="d-flex justify-content-between p-2">
                        <p class="mb-0 text-brightGreen font-weight-bold">Fantastic app! Highly recommend</p>
                        <input type="checkbox" class="custom-checkbox" />

                    </div>
                </b-card>
                <b-card class="mb-3">
                    <div class="d-flex justify-content-between p-2">
                        <p class="mb-0 text-brightGreen font-weight-bold">Fantastic app! Highly recommend</p>
                        <input type="checkbox" class="custom-checkbox" />

                    </div>
                </b-card>
                <b-card class="mb-4">
                    <div class="d-flex justify-content-between p-2">
                        <p class="mb-0 text-brightGreen font-weight-bold">Fantastic app! Highly recommend</p>
                        <input type="checkbox" class="custom-checkbox" />

                    </div>
                </b-card>
                <b-button class="bg-brightGreen text-white btn-submit mb-1" block @click="boost">{{ $t('submit_rating') }}</b-button>
            </div>

        </vue-bottom-sheet>
        <Dialog ref="msg"></Dialog>
    </div>
</template>

<script>
import VueBottomSheet from "@webzlodimir/vue-bottom-sheet";
import {
    boostOrder,
    checkOrder,
    getOrderInfo,
    getMemberInfo,
} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
export default {
    components: {
        VueBottomSheet, Dialog
    },
    data() {
        return {
            rating: 0,
            point1: 0,
            point2: 0,
            price: "",
            today_bonus: "",
            yesterday_bonus: "",
            today_completed_order: "",
            boost_time: "",
            today_left_times: "",
            cOrder_total_cost: "",
            cOrder_profit: "",
            cOrder_total_return: "",
            product_id: "",
            public_path: "",
            approval: "",
            needDeposit: "",
            currentPackage: "",
            isLoading: true
        }
    },
    methods: {
        open() {
            this.$refs.myBottomSheet.open();
        },

        close() {
            this.$refs.myBottomSheet.close();
        },
        boost() {
            if (this.rating > 0) {
                let formData = new FormData();
                var self = this;
                formData.append("rating", this.rating);
                var result = boostOrder(formData);
                self.isLoading = true;

                result
                    .then(function (value) {
                        if (value.data.error_code == 0) {
                            self.$refs.msg.makeToast("success", self.$t("operation_success"));
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

            } else {
                this.$refs.msg.makeToast("danger", 'Please rate the app to submit');

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
                        self.open();
                    } else {
                        self.$refs.msg.makeToast("danger", self.$t(value.data.message));
                    }
                })
                .catch(function (error) {
                    self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
                    self.sending = false;
                });
        },
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
        memberInfo() {
            var result = getMemberInfo();

            var self = this;
            this.isLoading = true;
            result
                .then(function (value) {
                    self.point1 = value.data.data.point1;
                    self.point2 = value.data.data.point2;
                    self.currentPackage = value.data.data.package.package_name_en;
                    // self.wallets = value.data.data.wallet;
                    self.isLoading = false;
                })
                .catch(function (error) {
                    self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
                });
        },
    },
    mounted() {
        this.loadItems();
        this.email = localStorage.getItem("username");
        // this.open();
    }

}
</script>