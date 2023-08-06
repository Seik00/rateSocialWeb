<template>
  <div class="main-content">
    <breadcumb :page="$t('revenueList')" :folder="$t('tradeManage')" />
    <b-row>
      <b-col md="12">
        <b-card class="mb-30">
          <b-row align-v="center">
            <b-col md="2">
              <b-form-group
                id="input-group-1"
                :label="$t('username')"
                label-for="input-1"
              >
                <b-form-input
                  id="input-1"
                  type="text"
                  :placeholder="$t('Enter') + $t('username')"
                  v-model="searchUsername"
                ></b-form-input>
              </b-form-group>
            </b-col>

            <b-col md="2">
              <b-form-group
                id="input-group-2"
                :label="$t('money')"
                label-for="input-2"
              >
                <b-form-input
                  id="input-2"
                  type="text"
                  :placeholder="$t('Enter') + $t('money')"
                  v-model="coin"
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

            <b-col md="3" class="mt-3 mt-md-0">
              <b-form-group
                id="input-group-2"
                :label="$t('from')"
                label-for="input-2"
              >
                <b-form-input
                  id="input-2"
                  type="date"
                  v-model="from"
                ></b-form-input>
              </b-form-group>
            </b-col>

            <b-col md="3" class="mt-3 mt-md-0">
              <b-form-group
                id="input-group-2"
                :label="$t('to')"
                label-for="input-2"
              >
                <b-form-input
                  id="input-2"
                  type="date"
                  v-model="to"
                ></b-form-input>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row align-v="center" align-h="end" class="">
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
    <b-card>
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
          <span v-else-if="props.column.field == 'deal_status'">
            <span v-if="props.row.deal_status == 1">
              <b-badge href="#" variant="success  m-2">{{
                $t("settle")
              }}</b-badge>
            </span>
            <span v-else>
              <b-badge href="#" variant="warning  m-2">{{
                $t("unsettle")
              }}</b-badge>
            </span>
          </span>
          <span v-else-if="props.column.field == 'deal_recycle_status'">
            <span v-if="props.row.deal_recycle_status == 1">
              {{ $t("recycle") }}
            </span>
            <span v-else>
              {{ $t("single") }}
            </span>
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
import { getRevenueList } from "../../../system/api/api";
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
          field: "market",
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
          label: this.$t("stock"),
          text: "stock",
          field: "stock",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t("money"),
          text: "money",
          field: "money",
          // width: "190px",
          thClass: "gull-th-class",
          sortable: false,
          html: true,
        },
        {
          label: this.$t("deal_recycle_status"),
          text: "deal_recycle_status",
          field: "deal_recycle_status",
          // width: "190px",
          thClass: "gull-th-class",
          sortable: false,
          html: true,
        },
        {
          label: this.$t("deal_status"),
          text: "deal_status",
          field: "deal_status",
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
          label: this.$t("created_at"),
          text: "ctime",
          field: "ctime",
          thClass: "gull-th-class",
          value: "ctime",
          sortable: false,
          tdClass: "bodyWidth",
        },
        // {
        //   label: this.$t("status"),
        //   text: "status",
        //   field: "status",
        //   thClass: "gull-th-class",
        //   value: "status",
        //   sortable: false,
        // },
        // {
        //   label: this.$t("action"),
        //   field: "action",
        //   tdClass: "linkWidth",
        //   sortable: false,
        // },
      ];
    },
  },
  data() {
    return {
      username: "",
      searchUsername: "",
      from: "",
      to: "",
      coin: "",
      platform: "",
      amount: "",
      isLoading: false,
      canClear: false,
      totalRecords: 0,
      totalFounds: 0,
      pageNumber: 1,
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
        (d.getMonth()+1) +
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
    onSearch() {
      this.pageNumber = 1;
      if (
        this.searchUsername != "" ||
        this.from != "" ||
        this.to != "" ||
        this.coin != "" ||
        this.platform != ""
      ) {
        this.canClear = true;
      }
      this.loadItems();
    },
    onCancel() {
      this.searchUsername = "";
      this.from = "";
      this.to = "";
      this.coin = "";
      this.platform = "";
      this.canClear = false;
      this.loadItems();
    },
    loadItems() {
      var result = getRevenueList(
        this.pageNumber,
        this.coin,
        this.platform,
        this.searchUsername,
        this.from,
        this.to
      );
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          // console.log(value.data);
          var dataList = value.data.data.record.data;
          self.rows = dataList;
          self.totalRecords = value.data.data.record.total;
          self.totalFounds = value.data.data.total;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.loadItems();
    console.log(this.$i18n.locale);
  },
};
</script>

<style>
.bodyWidth {
  min-width: 120px;
}
</style>