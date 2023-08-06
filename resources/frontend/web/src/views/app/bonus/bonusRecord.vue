<template>
  <div class="main-content">
    <div class="appBar">
    <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
    </a>
      <span>{{ $t("record") }}</span>
    </div>
    <div
      class="mainpage m-1 px-2"
    >
      <div
        v-if="currentPage > lastPage && dataList.length==0"
        style="
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
        "
      >
        <p>No Data</p>
      </div>
      <b-card class="bg-greyblue mb-2" v-for="item in dataList" :key="item.id">
        <div class="list-box">
          <b-row align-v="center">
            <b-col cols="2" >
              <!-- <img src="../../../assets/images/boost/deposit.png" alt="" /> -->
              <img class="ml-1" src="../../../assets/images/boost/withdraw_color.png" alt="" />
            </b-col>
            <b-col cols="6">
              <p class="mb-1">{{ ($i18n.locale=="zh")?item.detailen:item.detailen }}</p>
              <span>{{ item.updated_at }}</span>
            </b-col>
            <b-col cols="4">
              <span>{{ item.current }}</span>
            </b-col>
          </b-row>
        </div>
      </b-card>

      <b-button
        v-if="currentPage <= lastPage"
        class="mx-auto submit_button mb-5"
        variant="outline-secondary"
        @click="loadItems"
        >{{ isLoading ? $t("loading...") : $t("load_more") }}</b-button
      >
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getUserBonusRecord } from "../../../system/api/api";
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
      dataList: [],
      currentPage: 1,
      lastPage: 1,
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
    loadItems() {
      var result = getUserBonusRecord("special_bonus", this.currentPage);
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