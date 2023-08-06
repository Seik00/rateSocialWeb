<template>
  <div class="main-content px-0 pb-0 w-100" style="height: 100vh">
    <div class="record-bg h-100 d-flex flex-column">
      <div class="appBar">
        <a @click="$router.go(-1)">
          <i class="fa fa-chevron-left"></i>
        </a>
        <span>{{ $t("contact_service") }}</span>
        <!-- 
      <a class="right-side" @click="openDeposit">
       -->
      </div>
      <div class="m-1 px-2 mt-3 flex-grow-1" style="overflow-y: scroll;">
        <div v-if="currentPage > lastPage && dataList.length == 0"
          style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
          <p class="text-white">No Data</p>
        </div>
        <div class="card mb-2 p-3 cursor-pointer" v-for="item in dataList" :key="item.id"
          @click="$router.push('/web/ticket/ticketDetail?id=' + item.id)">
          <b-row align-v="center" no-gutters>
            <b-col cols="6">
              <span>{{ item.updated_at }}</span>
              <p class="text-12 font-weight-700 mb-0">
                <span>{{ item.title }}</span>
              </p>
            </b-col>
            <b-col cols="6">
              <div class="text-right">
                <span v-if="item.ruid != null" class="text-brightGreen font-weight-700">
                  {{ $t("replied") }}
                </span>
                <span v-else class="text-grey font-weight-700" style="color:#96ABC7">
                  {{ $t("pending") }}
                </span>
              </div>
            </b-col>
          </b-row>
        </div>
        <b-button v-if="currentPage <= lastPage" class="mx-auto submit_button mb-5" variant="outline-secondary"
          :disabled="isLoading" @click="loadItems">{{ isLoading ? $t("loading...") : $t("load_more") }}</b-button>
      </div>
      <div class="mx-4">
        <b-button @click="$router.push('/web/ticket/createTicket')" class="mx-auto w-100 mt-5" style="margin-bottom: 10%;"
          variant="primary" :disabled="isLoading">{{
            $t("new_msg") }}</b-button>

      </div>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getTicket } from "../../../system/api/api";
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
    loadItems() {
      var result = getTicket(this.currentPage);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.ticket;
          self.currentPage += 1;
          self.lastPage = value.data.data.last_page;
          for (let i = 0; i < dataList.length; i++) {
            console.log(dataList[i]);
            self.dataList.push(dataList[i]);
          }
          self.isLoading = false;
        })
        .catch(function (error) {
          console.log(error);
          self.isLoading = false;
          self.$root.makeToast("warning", self.$t(handleError(error)), 'danger');
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
<style scoped>
.main-content {
  max-width: 420px;
  margin: auto;
}
</style>