<template>
  <div class="main-content">
    <div class="appBar">
    <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
    </a>
      <span>{{ $t("record") }}</span>
    </div>
    <div class="main-content m-1 px-2">
    <b-card class="bg-greyblue mt-3">
        <b-link to="/web/bonus/dynamicBonusRecord">
          <div class="list-box mb-3">
            <b-row align-h="start" align-v="center" class="m-0">
              <div class="text-center text-18">
                <img src="../../../assets/images/boost/bonus.png" alt="" style="height:30px;"> 
              </div>

              <h6 class="mb-0 mx-3 text-10 text-primary">
                {{ $t("mined_reward") }}
              </h6>
              <i class="fa fa-angle-right" style="right: 30px; position: absolute; color: white"></i>
            </b-row>
          </div>
        </b-link>
        <b-link to="/web/bonus/bonusRecord">
          <div class="list-box mb-3">
            <b-row align-h="start" align-v="center" class="m-0">
              <div class="text-center text-18">
                <img src="../../../assets/images/boost/bonus.png" alt="" style="height:30px;"> 
              </div>

              <h6 class="mb-0 mx-3 text-10 text-primary">
                {{ $t("da_bonus") }}
              </h6>
              <i class="fa fa-angle-right" style="right: 30px; position: absolute; color: white"></i>
            </b-row>
          </div>
        </b-link>
      </b-card>
     
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getUserBonusRecord, getMemberInfo } from "../../../system/api/api";
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
      point1: [],
      dataList: [],
      canClear: false,
      wallet: "point1",
      wallet2: "point2",
      totalRecords: 0,
      pageNumber: 1,
      message: "",
      stock: "",
      money: "",
      status: true,
      balance: "",
      currentPage: 1,
      lastPage: 1,
    };
  },
  props: ["success"],
  methods: {
     static_bonus() {
      this.$router.push("/web/bonus/bonusRecord");
    },
    dynamic_bonus() {
      this.$router.push("/web/bonus/dynamicBonusRecord");
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
    loadItems() {
      var result = getUserBonusRecord("static_bonus", this.currentPage);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
            
          var dataList = value.data.data.record.data;
          console.log(dataList);
          
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
    this.loadItems();
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
#fileName span + span {
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