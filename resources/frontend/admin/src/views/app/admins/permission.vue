<template>
  <div class="main-content">
    <breadcumb :page="$t('permissionSetting')" :folder="$t('adminManage')" />
    <b-card :title="$t('permissionSetting')">
    </b-card>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getAdminList } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
export default {
  components: {
    Dialog,
  },
  data() {
    return {
      tabIndex: 0,
      username: "",
      password: "",
      mobile_no: "",
      isLoading: false,
      canClear: false,
      canEdit: false,
      totalRecords: 0,
      pageNumber: 1,
      rows: [],
    };
  },
  methods: {
    onPageChange(params) {
      this.pageNumber = params.currentPage;
      this.loadItems();
      var container = this.$el.querySelector("#table");
      var top = container.offsetTop;

      window.scrollTo(0, top);
    },
    onSearch() {
      this.pageNumber = 1;
      if (this.username != "" || this.phone != "") {
        this.canClear = true;
      }
      this.loadItems();
    },
    onCancel() {
      this.username = "";
      this.phone = "";
      this.canClear = false;
      this.loadItems();
    },
    loadItems() {
      console.log(localStorage.getItem("userToken"));
      var result = getAdminList(this.pageNumber);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.user.data;
          self.rows = dataList;
          self.totalRecords = value.data.data.user.total;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    // this.loadItems();
  },
};
</script>

<style>
.hiddenClass {
  pointer-events: none;
  display: none;
}
</style>