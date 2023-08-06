<template>
    <div class="main-content d-flex flex-column flex-grow-1 mx-3 " style="height:100vh">
        <div class="appBar position-relative">
            <a @click="$router.go(-1)">
                <img src="../../../assets/images/digital/right.svg" alt="">
            </a>

            <span>{{ $t("tradeHistory") }}</span>
            <div class="position-absolute" style="right: 10px; top: 10px">
                <b-button @click="$bvModal.show('modal-search')" :variant="'primary'">
                    <i class="fa fa-filter  text-white">
                        <span class="ml-1">
                            {{ $t("filter") }}
                        </span>
                    </i>
                </b-button>
            </div>
        </div>

        <div class="mt-2 d-flex flex-column flex-grow-1 position-relative" style="overflow-y: scroll;">
            <div v-if="currentPage > lastPage && dataList.length == 0"
                style="position: absolute;top: 50%;left: 50%; transform: translate(-50%, -50%); ">
                <p>No Data</p>
            </div>
            <div v-else-if="dataList.length == 0"
                style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                <p>{{ $t("loading...") }}</p>
            </div>

            <div class="bg-greyblue px-4 py-2 mb-3 font-weight-600" style="border-radius: 10px" v-for="item in dataList"
                :key="item.id">
                <b-row align-v="center" align-h="between">
                    <b-col cols="6">
                        <p class="mb-1 text-white">{{ $t("trade") }}</p>
                        <!-- <span>{{ item.updated_at }}</span> -->
                    </b-col>
                    <b-col cols="6">
                        <span class="text-right d-block">{{ $t(site[item.status]) }}</span>
                    </b-col>
                </b-row>
                <b-row align-v="center" align-h="between">
                    <b-col cols="5">
                        <p class="mb-1 text-muted">{{ $t('from_asset')+' ('+ coinName +') ' }}</p>
                    </b-col>
                    <b-col cols="6">
                        <span class="text-white text-right d-block"> {{ item.from_asset }}</span>
                    </b-col>
                </b-row>
                <b-row align-v="center" align-h="between">
                    <b-col cols="5">
                        <p class="mb-1 text-muted">{{ $t('amount') }}</p>
                    </b-col>
                    <b-col cols="6">
                        <span class="text-white text-right d-block">{{ item.act }} {{ item.amount }}</span>
                    </b-col>
                </b-row>
                <b-row align-v="center" align-h="between">
                    <b-col cols="5">
                        <p class="mb-1 text-muted">{{ $t('to_asset') }}</p>
                    </b-col>
                    <b-col cols="6">
                        <span class="text-white text-right d-block"> {{ item.to_asset }}</span>
                    </b-col>
                </b-row>
                <b-row align-v="center" align-h="between">
                    <b-col cols="5">
                        <p class="mb-1 text-muted">{{ $t('date') }}</p>
                    </b-col>
                    <b-col cols="6">
                        <span class="text-white text-right d-block">{{ item.updated_at }}</span>
                    </b-col>
                </b-row>

            </div>
            <b-button v-if="currentPage <= lastPage && dataList.length != 0" class="mx-auto submit_button mb-5"
                variant="outline-secondary" @click="_asset">{{ isLoading ? $t("loading...") : $t("load_more") }}</b-button>
        </div>


        <b-modal id="modal-search" size="md" centered class="" :title="$t('filter')" :hide-footer="true">
            <b-row align-h="center">
                <b-col cols="10">
                    <b-form>
                        <b-form-group class="mb-3 form-customize" v-for="(item, index) in filterParam" :key="item.id"
                            label-for="item" :label="$t(index)">
                            <b-form-input type="date" v-model="filterParam[index]" class="form-control form-custom"
                                v-if="index == 'start_date' || index == 'end_date'"></b-form-input>
                        </b-form-group>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <b-button class="mt-3 w-100 text-white" variant="primary" @click="filter()">{{ $t("submit")
                                    }}</b-button>
                                </div>
                                <div class="col-sm-12" v-if="searched">
                                    <b-button class="mt-2 w-100" variant="danger" @click="clearFilter">
                                        <i class="fa fa-filter"><span class="ml-1">
                                                {{ $t("clear") }}
                                            </span></i></b-button>
                                </div>
                            </div>
                        </div>
                    </b-form>
                </b-col>
            </b-row>
        </b-modal>

        <Dialog ref="msg"></Dialog>
    </div>
</template>

<script>
import {
    assetLog,
} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";

export default {
    data() {
        return {
            type: '',
            typeID: '',
            coinName: '',
            amount: 0,
            price: 0,
            sec_password: '',
            isLoading: false,
            searched: false,
            timer: null,
            chartTimer: null,
            coinList: [],
            buyList: [],
            sellList: [],
            dataList: [],
            currentPage: 1,
            lastPage: 1,
            width: window.innerWidth,
            height: window.innerHeight,
            filterParam: {
                start_date: "",
                end_date: "",
            },
            chart: {
                ohlcv: [
                    // [1551128400000, 33, 37.1, 14, 14, 196],
                    // [1551132000000, 13.7, 30, 6.6, 30, 206],
                    // [1551135600000, 29.9, 33, 21.3, 21.8, 74],
                    // [1551139200000, 21.7, 25.9, 18, 24, 140],
                    // [1551142800000, 24.1, 24.1, 24, 24.1, 29],
                ]
            },
            site: ["pending", "approved", "success", "rejected"],
        }
    },
    components: {
        Dialog,
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
            console.log(this.typeID);
        }

    },
    methods: {
        clearFilter() {
            this.$bvModal.hide("modal-search");
            this.dataList = [];
            this.currentPage = 1;
            for (const item in this.filterParam) {
                this.filterParam[item] = "";
            }
            this.searched = false;
            this.loadItems();
        },
        filter() {
            this.$bvModal.hide("modal-search");
            this.currentPage = 1;
            this.dataList = [];
            for (const item in this.filterParam) {
                if (this.filterParam[item] != "") {
                    this.searched = true;
                }
            }
            this._asset();
        },
        _asset() {
            var searchParam = "";
            for (const item in this.filterParam) {
                var tmp = "&" + item + "=" + this.filterParam[item];
                searchParam = searchParam + tmp;
            }
            var result = assetLog(this.type.split('/')[0],
                this.currentPage, searchParam);

            var self = this;
            // this.isLoading = true;
            result
                .then(function (value) {
                    console.log(value.data);
                    self.dataList = value.data.data.record.data;
                    self.coinName = value.data.data.asset.coin_name;
                    self.currentPage += 1;
                    self.lastPage = value.data.data.record.last_page;
                    self.isLoading = false;
                })
                .catch(function (error) {
                    self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
                });
        },
        onResize() {
            this.width = window.innerWidth
            this.height = window.innerHeight
        }
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResize)
    },
    mounted() {
        window.addEventListener('resize', this.onResize);
        this.coinList = JSON.parse(localStorage.getItem('market'));
        console.log(this.coinList[0]);
        for (let i = 0; i < this.coinList.length; i++) {
            if (this.$route.query.type == this.coinList[i].value) {
                this.type = this.coinList[i].value;
                this.typeID = this.coinList[i].id;
                this.price = this.coinList[i].price;
            }

        }
        this._asset();
        // this._marketChart();
        // this.type = this.$route.query.type ?? this.coinList[0].value;

    }

}
</script>