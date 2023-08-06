<template>
  <div class="main-content">
    <breadcumb :page="'机器人列表'" :folder="'量化机器人'" />
    <b-row>
      <b-col md="12">
        <b-card class="mb-30">
          <b-row align-v="center">
            <b-col md="2">
              <b-form-group
                id="input-group-1"
                label="platform"
                label-for="input-1"
              >
                <b-form-input
                  id="input-1"
                  type="text"
                  required
                  placeholder="Enter platform"
                  v-model="platform"
                ></b-form-input>
              </b-form-group>
            </b-col>

            <b-col md="2" class="mt-3 mt-md-0">
              <b-form-group
                id="input-group-2"
                label="userId Number"
                label-for="input-2"
              >
                <b-form-input
                  id="input-2"
                  type="text"
                  required
                  placeholder="Enter userId Number"
                  v-model="userId"
                ></b-form-input>
              </b-form-group>
            </b-col>

            <b-col md="1" class="mt-3 mt-md-0">
              <b-button variant="primary" @click="onSearch">Search</b-button>
            </b-col>
            <b-col md="1" class="mt-3 mt-md-0" v-if="canClear">
              <b-button variant="danger" @click="onCancel">Clear</b-button>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
    <vue-good-table
      id="table"
      mode="remote"
      @on-page-change="onPageChange"
      @on-search="onSearch"
      :totalRows="totalRecords"
      :isLoading="isLoading"
      :columns="columns"
      :search-options="{
        enabled: false,
        placeholder: 'Search this table',
      }"
      :pagination-options="{
        enabled: true,
        perPageDropdownEnabled: false,
        mode: 'pages',
              pageLabel: $t('page'),
      }"
      styleClass="tableOne vgt-table table-striped"
      :selectOptions="{
        enabled: false,
        selectionInfoClass: 'table-alert__box',
      }"
      :rows="rows"
    >
      <!-- <div slot="table-actions" class="mb-3">
        <b-button variant="primary" class="btn-rounded"> Add Button </b-button>
      </div> -->

      <template slot="table-row" slot-scope="props">
        <span v-if="props.column.field == 'action'">
          <a href="">
            <i class="i-Eraser-2 text-25 text-success mr-2"></i>
            {{ props.row.button }}</a
          >
          <a href="">
            <i class="i-Close-Window text-25 text-danger"></i>
            {{ props.row.button }}</a
          >
        </span>
      </template>
    </vue-good-table>
  </div>
</template>

<script>
import { getTicketList } from "../../../system/api/api";
export default {
  computed: {
    columns() {
      return [
        {
          label: "id",
          text: "id",
          field: "id",
          thClass: "gull-th-class",
          value: "id",
          sortable: false,
        },
        {
          label: "referId",
          text: "referId",
          field: "sponsor.id",
          thClass: "gull-th-class",
          value: "referId",
          sortable: false,
        },
        {
          label: "platform",
          text: "platform",
          field: "platform",
          thClass: "gull-th-class",
          value: "platform",
          sortable: false,
        },
        {
          label: "nickname",
          text: "nickname",
          field: "nickname",
          thClass: "gull-th-class",
          value: "nickname",
          sortable: false,
        },
        {
          label: "avatar",
          text: "avatar",
          field: "avatar",
          // width: "190px",
          thClass: "gull-th-class",
          value: "avatar",
          sortable: false,
          html: true,
        },
        {
          label: "email",
          text: "email",
          field: "email",
          thClass: "gull-th-class",
          value: "email",
          sortable: false,
        },
        {
          label: "mobile",
          text: "mobile",
          field: "contact_number",
          thClass: "gull-th-class",
          value: "contact_number",
          sortable: false,
        },
        {
          label: "verifyLevel",
          text: "verifyLevel",
          field: "verifyLevel",
          thClass: "gull-th-class",
          value: "verifyLevel",
          sortable: false,
        },
        {
          label: "paypwd",
          text: "paypwd",
          field: "paypwd",
          thClass: "gull-th-class",
          value: "paypwd",
          sortable: false,
        },
        {
          label: "ga",
          text: "ga",
          field: "ga",
          thClass: "gull-th-class",
          value: "ga",
          sortable: false,
        },
        {
          label: "others",
          text: "others",
          field: "others",
          thClass: "gull-th-class",
          value: "others",
          sortable: false,
        },
        {
          label: "inviteCode",
          text: "inviteCode",
          field: "inviteCode",
          thClass: "gull-th-class",
          value: "inviteCode",
          sortable: false,
        },
        {
          label: "inviteCount",
          text: "inviteCount",
          field: "inviteCount",
          thClass: "gull-th-class",
          value: "inviteCount",
          sortable: false,
        },
        {
          label: "inviteInfo",
          text: "inviteInfo",
          field: "inviteInfo",
          thClass: "gull-th-class",
          value: "inviteInfo",
          sortable: false,
        },
        {
          label: "status",
          text: "status",
          field: "status",
          thClass: "gull-th-class",
          value: "status",
          sortable: false,
        },
        {
          label: "action",
          field: "action",
          tdClass: "linkWidth",
          sortable: false,
        },
      ];
    },
  },
  data() {
    return {
      platform: "",
      userId: "",
      isLoading: false,
      canClear: false,
      totalRecords: 0,
      pageNumber: 1,
      rows: [],
    };
  },
  methods: {
    makeToast(variant = null, msg) {
      this.$bvToast.toast(msg, {
        // title: ` ${variant || "default"}`,
        variant: variant,
        solid: true,
      });
    },
    onPageChange(params) {
      this.pageNumber = params.currentPage;
      this.loadItems();
      var container = this.$el.querySelector("#table");
      var top = container.offsetTop;

      window.scrollTo(0, top);
    },
    onSearch() {
      this.pageNumber = 1;
      if (this.platform != "" || this.userId != "") {
        this.canClear = true;
      }
      this.loadItems();
    },
    onCancel() {
      this.platform = "";
      this.userId = "";
      this.canClear = false;
      this.loadItems();
    },
    addFile() {
      console.log("hello");
    },
    loadItems() {
      var result = getTicketList(this.pageNumber, this.platform, this.userId);
      var self = this;
      this.isLoading = true;
      result
        .then(function () {
        //   var dataList = value.data.data.user.data;
        //   self.rows = dataList;
        //   self.totalRecords = value.data.data.user.total;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.makeToast("warning", error.response.statusText+", Please Login Again!");
          localStorage.removeItem("userToken");
          self.$router.push("/admin/sessions/signIn");
          self.isLoading = false;
        });
    },
  },
  created() {
    this.loadItems();
  },
};
</script>