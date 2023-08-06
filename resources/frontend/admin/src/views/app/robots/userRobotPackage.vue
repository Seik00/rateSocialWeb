<template>
  <div class="main-content">
    <breadcumb :page="$t('userRobotPackage')" :folder="$t('robotManage')" />
    <b-card :title="$t('userRobotPackage')">
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
          <span v-if="props.column.field == 'package.package_name'">
            <span v-if="$i18n.locale == 'zh'">
              {{props.row.package.package_name}}
            </span>
            <span v-else>
              {{props.row.package.package_name_en}}
            </span>
          </span>
          <span v-else-if="props.column.field == 'created_at'">
            {{ (props.row.created_at) }}
          </span>
          <span v-else-if="props.column.field == 'action'">
            <button
              type="submit"
              class="btn btn-default btn-push"
              v-b-popover.hover.right="$t('pinLog')"
              @click="showModal(props.row.pin_log)"
            >
              <i class="fa fa-history"></i>
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
import { getUserRobotPackage } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
export default {
  components: {
    Dialog,
  },
  computed: {
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
          label: this.$t("packageName"),
          text: "pin",
          field: "package.package_name",
          thClass: "gull-th-class",
          value: "pin",
          sortable: false,
        },
        {
          label: this.$t("price"),
          text: "price",
          field: "price",
          thClass: "gull-th-class",
          value: "price",
          sortable: false,
        },
        {
          label: this.$t("created_at"),
          text: "created_at",
          field: "created_at",
          thClass: "gull-th-class",
          value: "created_at",
          sortable: false,
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
      amount: "",
      isLoading: false,
      canClear: false,
      totalRecords: 0,
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
if(dHour.toString().length == 1){
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
    loadItems() {
      var result = getUserRobotPackage(this.pageNumber);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.record.data;
          self.rows = dataList;
          self.totalRecords = value.data.data.record.total;
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