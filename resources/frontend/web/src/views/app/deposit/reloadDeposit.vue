<template>
  <div class="main-content">
    <breadcumb :page="$t('reloadRecord')" :folder="$t('depositManage')" />

    <b-card :title="$t('reloadRecord')">
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
        <!-- <div slot="table-actions" class="mb-3">
        <b-button variant="primary" class="btn-rounded"> Add Button </b-button>
      </div> -->

        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field == 'status'">
            <span v-if="props.row.status == 1">
              <b-badge href="#" variant="success  m-2">{{
                $t("success")
              }}</b-badge>
            </span>
            <span v-else>
              <b-badge href="#" variant="light  m-2">{{
                $t("unsuccess")
              }}</b-badge>
            </span>
          </span>
          <span v-else-if="props.column.field == 'groupingstatus'">
            <span v-if="props.row.groupingstatus == 1">
              <b-badge href="#" variant="success  m-2">{{
                $t("success")
              }}</b-badge>
            </span>
            <span v-else-if="props.row.groupingstatus == 0">
              <b-badge href="#" variant="light  m-2">{{
                $t("unsuccess")
              }}</b-badge>
            </span>
          </span>
          <span v-else-if="props.column.field == 'created_at'">
            {{ props.row.created_at }}
          </span>
          <span v-else-if="props.column.field == 'action'">
            <button
              type="submit"
              class="btn btn-default btn-edit"
              v-b-popover.hover.right="$t('editMarket')"
              @click="userInfo(props.row)"
            >
              <i class="fa fa-pencil"></i>
            </button>
          </span>
        </template>
      </vue-good-table>

      <div class="align-items-center mobile-adjust">
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
import { reloadDeposit } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
    // walletOptions() {
    //   return [
    //     { value: "point1", text: "USDT" },
    //     { value: "point2", text: this.$t("gasFee") },
    //     { value: "point3", text: this.$t("gasPanning") },
    //   ];
    // },
    actOptions() {
      return [
        { value: "-", text: "-" },
        { value: "+", text: "+" },
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
          label: this.$t("address"),
          text: "address",
          field: "address",
          thClass: "gull-th-class",
          value: "address",
          tdClass: "addressWidth",
          sortable: false,
        },
        {
          label: this.$t("founds"),
          text: "amount",
          field: "amount",
          thClass: "gull-th-class",
          value: "amount",
          sortable: false,
        },
        {
          label: "TXID",
          text: "txid",
          field: "txid",
          thClass: "gull-th-class",
          tdClass: "txidWidth",
          value: "txid",
          sortable: false,
        },
        {
          label: this.$t("status"),
          text: "status",
          field: "status",
          thClass: "gull-th-class",
          value: "status",
          sortable: false,
        },
        {
          label: this.$t("groupingamount"),
          text: "groupingamount",
          field: "groupingamount",
          thClass: "gull-th-class",
          value: "groupingamount",
          sortable: false,
        },
        {
          label: this.$t("groupingstatus"),
          text: "groupingstatus",
          field: "groupingstatus",
          thClass: "gull-th-class",
          value: "groupingstatus",
          sortable: false,
        },
        {
          label: this.$t("groupingtxid"),
          text: "groupingtxid",
          field: "groupingtxid",
          thClass: "gull-th-class",
          tdClass: "txidWidth",
          value: "groupingtxid",
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
        //   label: this.$t("action"),
        //   text: "action",
        //   field: "action",
        //   thClass: "gull-th-class",
        //   value: "action",
        //   sortable: false,
        // },
      ];
    },
  },
  components: {
    Dialog,
  },
  data() {
    return {
      canEdit: false,
      tabIndex: 0,
      selectedId: null,
      isLoading: false,
      canClear: false,
      totalRecords: 0,
      pageNumber: 1,
      message: "",
      rows: [],
      username: "",
      wallet_type: 1,
      act: "-",
      amount: "",
      remark: "",
      wallets: [
        {
          id: "point1",
          found_type: "1",
          lan_key: "POINT1",
          comments_cn: "USDT",
          comments_en: "USDT",
        },
        {
          id: "point2",
          found_type: "2",
          lan_key: "POINT2",
          comments_cn: "绩效费",
          comments_en: "Performance Fee",
        },
        {
          id: "point3",
          found_type: "3",
          lan_key: "pin",
          comments_cn: "GAS",
          comments_en: "GAS",
        },
      ],

      walletOptions: [],
    };
  },
  props: ["success"],
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
    onSearch() {
      this.pageNumber = 1;
      this.loadItems();
    },
    onCancel() {
      this.canClear = false;
      this.loadItems();
    },
    userInfo(row) {
      console.log(row);
      this.canEdit = true;
      var self = this;
      self.tabIndex = 2;
      var contentData = row;
      self.selectedId = contentData.id;
      self.username = contentData.user.username;
      self.wallet_type =
        contentData.action == "+" ? contentData.in_type : contentData.out_type;
      self.act = contentData.action;
      self.amount = contentData.found;
      self.remark = contentData.remark;
    },
    clearData() {
      this.canEdit = false;
      var self = this;
      self.selectedId = null;
      self.username = "";
      self.wallet_type = 1;
      self.act = "+";
      self.amount = "";
      self.remark = "";
    },
    loadItems() {
      var result = reloadDeposit(this.pageNumber);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.record.data;
          self.rows = dataList;
          self.totalRecords = value.data.data.record.total;
          // self.wallets = value.data.data.wallet;
          self.isLoading = false;

          var w = self.wallets;
          // self.wallet_type = self.wallets[1].found_type;

          if (self.$i18n.locale == "en") {
            for (var index in self.wallets) {
              var jsonPackageEn = {};
              jsonPackageEn["value"] = w[index].found_type;
              jsonPackageEn["text"] = w[index].comments_en;
              self.walletOptions.push(jsonPackageEn);
            }
          } else {
            for (var index2 in self.wallets) {
              var jsonPackage = {};
              jsonPackage["value"] = w[index2].found_type;
              jsonPackage["text"] = w[index2].comments_cn;
              self.walletOptions.push(jsonPackage);
            }
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  watch: {
    lang(val) {
      console.log(val);
      var self = this;
      var w = self.wallets;
      self.walletOptions = [];
      if (val == "en") {
        for (var index in self.wallets) {
          var jsonPackageEn = {};
          jsonPackageEn["value"] = w[index].found_type;
          jsonPackageEn["text"] = w[index].comments_en;
          self.walletOptions.push(jsonPackageEn);
        }
      } else {
        for (var index2 in self.wallets) {
          var jsonPackage = {};
          jsonPackage["value"] = w[index2].found_type;
          jsonPackage["text"] = w[index2].comments_cn;
          self.walletOptions.push(jsonPackage);
        }
      }
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