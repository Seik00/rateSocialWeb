<template>
  <div class="main-content chat-inner-bg mt-0 w-100">
    <div class="chat-bg pb-3 px-3">
      <div class="appBar ">
        <a @click="$router.go(-1)">
          <i class="fa fa-chevron-left"></i>
        </a>
      </div>

      <b-row class="row-sale mt-4" align-v="end">
        <b-col cols="8">
          <h4 class="text-uppercase mt-3 text-start font-weight-700">
            {{ dataList.title }}</h4>
          <p class="text-16 text-white mb-0">
            {{ dataList.created_at }}
          </p>
        </b-col>
        <b-col cols="4">
          <div class="text-right text-14">
            <span v-if="dataList.ruid != null" class="text-brightGreen font-weight-700">
              {{ $t("replied") }}
            </span>
            <span v-else class="text-grey font-weight-700" style="color:#96ABC7">
              {{ $t("pending") }}
            </span>
          </div>
        </b-col>
      </b-row>
    </div>
    <div class="px-3 pt-3 flex-grow-1" style="overflow-y: scroll;">
      <div class="card bg-gray w-75 ml-auto px-3 py-2 mb-4 text-white" style="background: #404040;">
        <p class="text-14">
          {{ dataList.body }}
        </p>
        <p class="text-right mb-0">{{ dataList.created_at }}</p>

      </div>
      <div v-if="dataList.ruid != null" class="card reply w-75 mr-auto px-3 py-2 mb-4">
        <p class="text-14">
          {{ dataList.rebody }}
        </p>
        <p class="text-right mb-0">{{ dataList.re_time }}</p>

      </div>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { readTicket } from "../../../system/api/api";
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
      dataList: null,
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
      var result = readTicket(this.$route.query.id);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.dataList = value.data.data.ticket;
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