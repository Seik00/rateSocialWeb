<template>
    <div class="d-flex flex-column flex-grow-1" style="overflow: hidden;">
        <b-row class="mt-3 mb-2 font-weight-bold">
            <b-col cols="5"><span class="text-10">{{ $t('coin') }}</span></b-col>
            <b-col cols="4"><span class="text-10">{{ $t('price') }}</span></b-col>
            <b-col cols="3"><span class="text-10">{{ $t('24H_change') }}</span></b-col>
        </b-row>
        <div class="flex-grow-1 cursor-pointer" style="overflow: hidden scroll;">
            <b-row v-for="item in coinList" :key="item.id" class="mb-4"
                @click="$router.push('/web/trade/tradeChart?type=' + item.market)">
                <b-col cols="5"><span class="text-14 text-white">{{ item.market_name }}</span></b-col>
                <b-col cols="4"><span class="text-14 text-white">{{ (parseFloat(item.price)).toFixed(4) }}</span></b-col>
                <b-col cols="3"><b-badge :variant="item.change > 0 ? 'success' : 'danger'" class="text-14 text-white">{{
                    (item.change > 0 ? '+' : ' ') + (parseFloat(item.change)).toFixed(2) }}%</b-badge></b-col>
            </b-row>

        </div>

    </div>
</template>

<script>
import { market } from "../../../../system/api/api"
import { handleError } from "../../../../system/handleRes";
export default {
    props: ['isHome'],
    data() {
        return {
            coinList: [],
            isDestroyed: false,
            timer: null,
        }
    },
    methods: {
        marketInfo() {
            var result = market();

            var self = this;
            // this.isLoading = true;
            result
                .then(function (value) {
                    // if (self.isHome) {
                        for (let i = 0; i < value.data.data.trade_market.length; i++) {
                            if (i < 6) {
                                // if (self.coinList.length == 0) {
                                //     self.coinList.push(value.data.data.trade_market[i]);

                                // } else {
                                //     self.coinList[i] = value.data.data.trade_market[i];
                                // }

                                if(i==4){
                                    console.log(value.data.data.trade_market[4]['price']);
                                    // console.log(self.coinList[4]['price']);
                                }

                            } else {
                                break
                            }

                        }

                    // } else {
                        self.coinList = value.data.data.trade_market;

                    // }
                    if (self.isHome) {
                        self.coinList.splice(6);
                    }

                    let list = [];
                    for (let i = 0; i < value.data.data.trade_market.length; i++) {
                        let tmp = {};
                        tmp['value'] = value.data.data.trade_market[i].market;
                        tmp['text'] = value.data.data.trade_market[i].market;
                        tmp['price'] = value.data.data.trade_market[i].price;
                        tmp['id'] = value.data.data.trade_market[i].id;

                        list.push(tmp);
                    }
                    localStorage.setItem('market', JSON.stringify(list));

                    // self.isLoading = false;
                    self.timer = setTimeout(() => {
                        self.marketInfo();
                    }, 1000);


                })
                .catch(function (error) {
                    self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
                });
        },
    },
    created() {
        this.marketInfo();
    },
    beforeDestroy() {
        clearTimeout(this.timer);
    }

}
</script>