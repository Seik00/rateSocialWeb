<template>
  <div class="main-content">
    <breadcumb :page="$t('revenue')" :folder="$t('revenue_list')" />
    <b-col lg="12" xl="12" md="12" class="p-0">
      <b-row>
        <b-col md="6" lg="4">
          <b-card class="mb-30 o-hidden px-2" >
            <b-row align-h="between" align-v="center">
              <div>
                <h6 class="mb-2 text-muted">
                  {{ $t("today_revenue") }}
                </h6>
                <h4 class="mb-2 text-muted">
                  {{ today_revenue }}
                </h4>
              </div>
            </b-row>
          </b-card>
        </b-col>
        <b-col md="6" lg="4">
          <b-card class="mb-30 o-hidden px-2" >
            <b-row align-h="between" align-v="center">
              <div>
                <h6 class="mb-2 text-muted">
                  {{ $t("month_revenue") }}
                </h6>
                <h4 class="mb-2 text-muted">
                  {{ month_revenue }}
                </h4>
              </div>
            </b-row>
          </b-card>
        </b-col>
        <b-col md="6" lg="4">
          <b-card class="mb-30 o-hidden px-2" >
            <b-row align-h="between" align-v="center">
              <div>
                <h6 class="mb-2 text-muted">
                  {{ $t("cumulative_profit") }}
                </h6>
                <h4 class="mb-2 text-muted">
                  {{ total_revenue }}
                </h4>
              </div>
            </b-row>
          </b-card>
        </b-col>
      </b-row>
    </b-col>
   
    
                    
    <b-card :title="$t('revenue_list')">
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
        <!-- <div slot="table-actions" class="mb-3">
        <b-button variant="primary" class="btn-rounded"> Add Button </b-button>
      </div> -->

        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field == 'revenue'">
            <span style="color: green">
              +{{ props.row.revenue }}
            </span>
          </span>
          <span v-else-if="props.column.field == 'date'">
            {{ props.row.date }}
          </span>
          <span v-else-if="props.column.field == 'action'">
            <button
              type="submit"
              class="btn btn-default btn-edit"
            >
              <i class="fa fa-copy"></i>
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
        <!-- <div class="d-flex flex-wrap align-items-center justify-content-end">
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
        </div> -->
      </div>
    </b-card>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getRevenueDay , getTotalRevenue} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
    columns() {
      return [
        {
          label: "ID",
          text: "pid",
          field: "pid",
          thClass: "gull-th-class",
          value: "pid",
          sortable: false,
        },
        {
          label: this.$t("profit_amount") + '(USDT)',
          text: "revenue",
          field: "revenue",
          thClass: "gull-th-class",
          value: "revenue",
          sortable: false,
        },
        {
          label: this.$t("exchange"),
          text: "platform",
          field: "platform",
          thClass: "gull-th-class",
          value: "platform",
          sortable: false,
        },
        {
          label: this.$t("sell_currency"),
          text: "market",
          field: "market",
          thClass: "gull-th-class",
          value: "market",
          sortable: false,
        },
        {
          label: this.$t("sell_time"),
          text: "ctime",
          field: "ctime",
          thClass: "gull-th-class",
          value: "ctime",
          sortable: false,
        },
      ];
    },
  },
  components: {
    Dialog,
  },
  data() {
    return {
      tabIndex: 0,
      selectedId: null,
      isLoading: false,
      totalRecords: 0,
      pageNumber: 1,
      start_date:"",
      end_date:"",
      date:"",
      today_revenue:"",
      total_revenue:"",
      month_revenue:"",
      rows: [],
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
    loadItems() {
      var revenueDate = this.$route.query.date;
      var result = getRevenueDay(revenueDate);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.data.data;
          self.today_revenue = value.data.data.today_revenue;
           console.log(dataList);
          self.rows = dataList;
          self.totalRecords = value.data.data.total;
          // self.wallets = value.data.data.wallet;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    loadItems2() {
      var result = getTotalRevenue(this.start_date,this.end_date);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
         
          self.total_revenue = value.data.data.total_revenue;
          self.month_revenue = value.data.data.month_revenue;
           
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  watch: {
    lang(val) {
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
    this.loadItems2();
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