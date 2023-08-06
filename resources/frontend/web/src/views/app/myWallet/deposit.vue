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
      <div style="position: relative" class="text-center">
      <b-row align-h="center">
          <b-button class="p-0 border-0">
            <b-card>
                <div class="mt-2">
                <span class="mt-4 font-weight-bold text-20"> TRC20</span>
              </div>
              <qrcode :background="background" :size="size" :cls="qrCls" :value="address"></qrcode>
                 <span class="mt-4 font-weight-bold text-14" style="color:black;margin-right:10px">{{ address }}</span>
                <button
                  type="submit"
                  class="btn btn-default btn-edit"
                  v-b-popover.hover.right="$t('copy')"
                  v-clipboard="() => address"
                  v-clipboard:success="clipboardSuccessHandler"
                  v-clipboard:error="clipboardErrorHandler"
                >
                  <i class="fa fa-copy"></i>
                </button>
                <div class="mt-2">
                    <span class="mt-4 font-weight-bold text-14" style="color:red">{{ $t("deposit_details1") }}</span>
                </div>
                <div class="mt-2">
                    <span class="mt-4 font-weight-bold text-12" style="color:grey">{{ $t("deposit_details2") }}</span>
                </div>
                <div class="mt-2">
                    <span class="mt-4 font-weight-bold text-12" style="color:grey">{{ $t("deposit_details3") }}</span>
                </div>
            </b-card>
          </b-button>
      </b-row>
    </div>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>
<script>
import {
  getDepositAddress,
} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import { mapGetters } from "vuex";
import Dialog from "../../../components/dialog.vue";
import Qrcode from 'v-qrcode/src/index'
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
    Qrcode,
  },
  data() {
    return {
        address: "",
        myVar: null,
        sending: false,
        isLoading: false,

        qrCls: 'qrcode',
        size: 300,
        
    };
  },
  props: ["success"],
  methods: {
    getInfo() {
      var result = getDepositAddress();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.isLoading = false;
          self.address = value.data.data;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
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
    },
  created() {
    this.getInfo();
  },
};
</script>