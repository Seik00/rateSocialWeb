<template>
  <div class="main-content">
    <breadcumb :page="$t('userRobotManage')" :folder="$t('robotManage')" />
    <b-card :title="$t('userRobotManage')">
      <b-row>
        <b-col md="12">
          <b-card class="mb-30">
            <b-row align-v="center">
              <b-col md="2">
                <b-form-group
                  id="input-group-1"
                  label="UID"
                  label-for="input-1"
                >
                  <b-form-input
                    id="input-1"
                    type="text"
                    required
                    :placeholder="$t('Enter') + 'UID'"
                    v-model="username"
                  ></b-form-input>
                </b-form-group>
              </b-col>

              <b-col md="2">
                <b-form-group
                  id="input-group-1"
                  :label="$t('platform')"
                  label-for="input-1"
                >
                  <b-form-select
                    v-model="platform"
                    class="form-control"
                    :options="platformOptions"
                    id="platform"
                    required
                  >
                  </b-form-select>
                </b-form-group>
              </b-col>

              <b-col md="1" class="mt-3 mt-md-0">
                <b-button variant="primary" @click="onSearch">{{
                  $t("search")
                }}</b-button>
              </b-col>
              <b-col md="1" class="mt-3 mt-md-0" v-if="canClear">
                <b-button variant="danger" @click="onCancel">{{
                  $t("clear")
                }}</b-button>
              </b-col>
            </b-row>
          </b-card>
        </b-col>
      </b-row>
      <vue-good-table
        id="table"
        mode="remote"
        @on-page-change="onPageChange"
        :totalRows="totalRecords"
        :isLoading="isLoading"
        :columns="columns"
        :search-options="{
          enabled: false,
          placeholder: 'Search this table',
        }"
        :pagination-options="{
          enabled: false,
          perPageDropdownEnabled: false,
          perPageDropdown: [10],
          dropdownAllowAll: false,
          rowsPerPageLabel: $t('rowPerPage'),
          nextLabel: $t('next'),
          prevLabel: $t('previous'),
          mode: 'pages',
              pageLabel: $t('page'),
          setCurrentPage: pageNumber,
        }"
        styleClass="tableOne vgt-table table-striped"
        :selectOptions="{
          enabled: false,
          selectionInfoClass: 'table-alert__box',
        }"
        :rows="rows"
      >
        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field == 'type'">
            <span v-if="props.row.type == 1">
              <b-badge href="#" variant="secondary  m-2">{{
                $t("spot")
              }}</b-badge>
            </span>
          </span>
          <span v-else-if="props.column.field == 'recycle_status'">
            <span v-if="props.row.recycle_status == 1">
              {{ $t("recycle") }}
            </span>
            <span v-else>
              {{ $t("single") }}
            </span>
          </span>
          <span v-else-if="props.column.field == 'status'">
            <span v-if="props.row.status == 1">
              <b-badge href="#" variant="success  m-2">{{
                $t("normal")
              }}</b-badge>
            </span>
            <span v-else>
              <b-badge href="#" variant="danger m-2">{{
                $t("stopped")
              }}</b-badge>
            </span>
          </span>
          <span v-else-if="props.column.field == 'revenue'">
            <span>
              {{ parseFloat(props.row.revenue).toFixed(6) }}
            </span>
          </span>
          <span v-else-if="props.column.field == 'created_at'">
            {{ props.row.created_at }}
          </span>
          <span v-else-if="props.column.field == 'action'">
            <button
              v-if="props.row.values_str!='' && props.row.values_str!=null"
              type="submit"
              class="btn btn-default btn-push"
              v-b-popover.hover.right="$t('clearRobot')"
              @click="confirmMessage(props.row)"
            >
              <i class="fa fa-trash"></i>
            </button>
          </span>
        </template>
      </vue-good-table><div class="align-items-center mobile-adjust">
        <div
          v-if="totalRecords > 0"
          class="d-flex flex-wrap align-items-center justify-content-start mt-3"
        >
          <p class="text-light text-16 mr-2">{{ $t("total") }}</p>
          <p class="text-muted text-16" style="font-weight: bold">
            {{ totalRecords }}
          </p>
        </div>
        <div v-else></div>
        <div class="d-flex flex-wrap align-items-center justify-content-end">
          <b-pagination
            class="pagi-margin pt-3"
            v-model="pageNumber"
            :total-rows="totalRecords"
            :per-page="10"
            :first-text="$t('first')"
            :prev-text="$t('prev')"
            :next-text="$t('next')"
            :last-text="$t('last')"
            @input="loadItems()"
          >
          </b-pagination>

          <b-input-group class="ml-3" style="width: 160px">
            <b-form-input
              v-model="pageNumber"
              :placeholder="$t('PageNo')"
            ></b-form-input>
            <b-input-group-append>
              <b-button
                variant="primary"
                @keypress="loadItems()"
                @click="loadItems()"
                >{{ $t("go") }}</b-button
              >
            </b-input-group-append>
          </b-input-group>
        </div>
      </div>
    </b-card>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getTradeRobot, deleteValueStr } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
export default {
  components: {
    Dialog,
  },
  computed: {
    platformOptions() {
      return [
        { value: "binance", text: "Binance" },
        { value: "huobi", text: "Huobi" },
      ];
    },
    columns() {
      return [
        {
          label: this.$t("id"),
          text: "id",
          field: "id",
          thClass: "gull-th-class",
          value: "id",
          sortable: false,
        },
        {
          label: "UID",
          text: "uid",
          field: "uid",
          thClass: "gull-th-class",
          value: "uid",
          sortable: false,
        },
        {
          label: this.$t("username"),
          text: "username",
          field: "user.username",
          thClass: "gull-th-class",
          value: "username",
          sortable: false,
        },
        {
          label: this.$t("platform"),
          text: "platform",
          field: "platform",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t("market"),
          text: "market",
          field: "market.market_name",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t("spot_type"),
          text: "type",
          field: "type",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t("max_order_count"),
          text: "max_order_count",
          field: "max_order_count",
          thClass: "gull-th-class",
          value: "max_order_count",
          sortable: false,
        },
        {
          label: this.$t("stop_profit_rate"),
          text: "stop_profit_rate",
          field: "stop_profit_rate",
          thClass: "gull-th-class",
          value: "stop_profit_rate",
          sortable: false,
        },
        {
          label: this.$t("stop_profit_callback_rate"),
          text: "stop_profit_callback_rate",
          field: "stop_profit_callback_rate",
          thClass: "gull-th-class",
          value: "stop_profit_callback_rate",
          sortable: false,
        },
        {
          label: this.$t("cover_rate"),
          text: "cover_rate",
          field: "cover_rate",
          thClass: "gull-th-class",
          value: "cover_rate",
          sortable: false,
        },
        {
          label: this.$t("cover_callback_rate"),
          text: "cover_callback_rate",
          field: "cover_callback_rate",
          thClass: "gull-th-class",
          value: "cover_callback_rate",
          sortable: false,
        },

        {
          label: this.$t("recycle"),
          text: "price",
          field: "recycle_status",
          // width: "190px",
          thClass: "gull-th-class",
          sortable: false,
          html: true,
        },
        {
          label: this.$t("revenue"),
          text: "revenue",
          field: "revenue",
          // width: "190px",
          thClass: "gull-th-class",
          sortable: false,
          html: true,
        },
        {
          label: this.$t("status"),
          text: "status",
          field: "status",
          // width: "190px",
          thClass: "gull-th-class",
          sortable: false,
          html: true,
        },
        {
          label: this.$t("created_at"),
          text: "ctime",
          field: "ctime",
          thClass: "gull-th-class",
          value: "ctime",
          sortable: false,
          tdClass: "bodyWidth",
        },
        {
          label: this.$t("action"),
          field: "action",
          tdClass: "linkWidth",
          sortable: false,
        },
      ];
    },
  },
  data() {
    return {
      username: "",
      amount: "",
      isLoading: false,
      canClear: false,
      totalRecords: 0,
      pageNumber: 1,
      platform: "",
      pinLog: "",
      rows: [
        // {
        //   id: 8000226,
        //   pin: 8000223,
        //   username: "第三方用户",
        //   created_at: '用户84749',
        //   avatar: '<img width="25" height="25" src="http://trader.greatwallsolution.com/upload/avatar.png">',
        //   email: '3@Gmail.com',
        //   mobile: '',
        //   verifyLevel: '',
        //   paypwd: '',
        //   ga: '',
        //   others: '',
        //   inviteCode: 'ZBg8iC',
        //   inviteCount: "0",
        //   inviteInfo: '',
        //   status: '正常',
        // },
      ],
    };
  },
  methods: {
    
    // confirm-message-alert
    confirmMessage(row) {
      this.$swal({
        title: this.$t("are_you_sure"),
        text: this.$t("double_confirm"),
        type: "warning",
        showCancelButton: true,
        cancelButtonText: this.$t("cancel"),
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: this.$t("confirm_clear")
      }).then(result => {
        if (result.value) {
          this.deleteStr(row);
        }
      });
    },
    onSearch() {
      this.pageNumber = 1;
      if (this.username != "" || this.platform != "") {
        this.canClear = true;
      }
      this.loadItems();
    },
    onCancel() {
      this.username = "";
      this.platform = "";
      this.canClear = false;
      this.loadItems();
    },
    processDate(rawDate) {
      var d = new Date(rawDate);
      var dMinute = d.getMinutes();
      var dHour = d.getHours();
      if (dMinute.toString().length == 1) {
        dMinute = "0" + dMinute;
      }
      if (dHour.toString().length == 1) {
        dHour = "0" + dHour;
      }
      var date =
        d.getFullYear() +
        "-" +
        (d.getMonth() + 1) +
        "-" +
        d.getDate() +
        " " +
        dHour +
        ":" +
        dMinute;
      return date;
    },
    onPageChange(params) {
      this.pageNumber = params.currentPage;
      this.loadItems();
      var container = this.$el.querySelector("#table");
      var top = container.offsetTop;

      window.scrollTo(0, top);
    },

    deleteStr(row) {
      let formData = new FormData();
      formData.append("id", row.id);

      var result = deleteValueStr(formData);
      var self = this;
      result
        .then(function () {
          self.$refs.msg.makeToast("success", self.$t("successUpdate"));
          self.tabIndex = 0;
          self.rows = [];
          self.canEdit = false;
          self.loadItems();
          self.$bvModal.hide("modal-1");
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });

      this.password = "";
    },
    loadItems() {
      var result = getTradeRobot(this.pageNumber, this.username, this.platform);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.data;
          self.rows = dataList;
          self.totalRecords = value.data.data.total;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.loadItems();
  },
};
</script>