<template>
  <div class="main-content">
    <breadcumb :page="$t('send_otp')" :folder="$t('userManage')" />

    <b-tabs pills align="end" v-model="tabIndex">
      <b-tab :title="$t('send_otp')" active @click="clearData">
        <b-card :title="$t('send_otp')">
          <b-row>
            <b-col md="12">
              <b-card class="mb-30">
                <b-row align-v="center">
                  <b-col md="2" class="mt-3 mt-md-0">
                    <b-form-group
                      id="input-group-2"
                      :label="$t('contact_number')"
                      label-for="input-2"
                    >
                      <b-form-input
                        id="input-2"
                        type="text"
                        required
                        :placeholder="$t('Enter') + $t('contact_number')"
                        v-model="searchPhone"
                      ></b-form-input>
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
              
              <span v-if="props.column.field == 'created_at'">
                {{ processDate(props.row.created_at) }}
              </span>
            </template>
          </vue-good-table>

          <div class="align-items-center mobile-adjust">
            <div
              v-if="totalRecords > 0"
              class="
                d-flex
                flex-wrap
                align-items-center
                justify-content-start
                mt-3
              "
            >
              <p class="text-light text-16 mr-2">{{ $t("total") }}</p>
              <p class="text-muted text-16" style="font-weight: bold">
                {{ totalRecords }}
              </p>
            </div>
            <div v-else></div>
            <div
              class="d-flex flex-wrap align-items-center justify-content-end"
            >
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
      </b-tab>
    </b-tabs>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  getOtpRecord,
} from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { handleError } from "../../../system/handleRes";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
    columns() {
      return [
        {
          label: this.$t("contact_number"),
          text: "contact_number",
          field: "contact_number",
          thClass: "gull-th-class",
          value: "contact_number",
          sortable: false,
        },
        {
          label: this.$t("vcode"),
          text: "code",
          field: "code",
          thClass: "gull-th-class",
          value: "code",
          sortable: false,
        },
        {
          label: this.$t("registerDate"),
          text: "created_at",
          field: "created_at",
          thClass: "gull-th-class",
          value: "created_at",
          tdClass: "dateWidth",
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
      username: "",
      searchUsername: "",
      searchPhone: "",
      searchUID: "",
      isLoading: false,
      canClear: false,
      totalRecords: 0,
      pageNumber: 1,
      walletPageNumber: 1,
      rows: [],
      walletRows: [],
      tabIndex: 0,
      canEdit: false,
      canShow: false,
      canSettings: false,
      packageType: "1",
      productType: "",
      country: null,
      countryOptions: [],
      package: [],
      product: [],
      selectOptions: [],
      productOptions: [],
      countryList: [],
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
        (d.getMonth() + 1) +
        "-" +
        d.getDate() +
        " " +
        dHour +
        ":" +
        dMinute;
      return date;
    },
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

    onWalletPageChange(params) {
      this.walletPageNumber = params.currentPage;
      this.getWRecord();
      var container = this.$el.querySelector("#table");
      var top = container.offsetTop;

      window.scrollTo(0, top);
    },
    onSearch() {
      this.pageNumber = 1;
      if (
        this.searchUsername != "" ||
        this.searchPhone != "" ||
        this.searchUID != ""
      ) {
        this.canClear = true;
      }
      this.loadItems();
    },
    onCancel() {
      this.searchUsername = "";
      this.searchPhone = "";
      this.searchUID = "";
      this.canClear = false;
      this.loadItems();
    },
    onCancelWallet() {
      this.from = "";
      this.to = "";
      this.canClearWallet = false;
      this.showWallet(this.searchUsernameWallet);
    },
    clearData() {
      this.canEdit = false;
      this.canShow = false;
      this.canSettings = false;
      var self = this;
      self.selectedId = null;
    },
    loadItems() {
      var result = getOtpRecord(
        this.pageNumber,
        this.searchPhone,
      );
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.record.data;
          self.rows = dataList;
          self.totalRecords = value.data.data.record.total;
          self.isLoading = false;

          self.selectOptions = [];
          self.package = value.data.data.package;

          for (let i = 0; i < self.package.length; i++) {
            var jsonPackage = {};
            jsonPackage["value"] = self.package[i].id;
            jsonPackage["text"] = self.package[i].package_name;
            self.selectOptions.push(jsonPackage);
          }

          self.productOptions = [];
          self.product = value.data.data.product;
          for (let i = 0; i < self.product.length; i++) {
            var jsonProduct = {};
            jsonProduct["value"] = self.product[i].id;
            jsonProduct["text"] = self.product[i].name_en + ' ('+self.product[i].price+')';
            self.productOptions.push(jsonProduct);
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  watch: {
    
  },
  created() {
    this.loadItems();
  },
};
</script>

<style>
.hiddenClass {
  pointer-events: none;
  display: none;
}

.bodyWidth {
  min-width: 140px;
}

.dateWidth {
  min-width: 100px;
}
</style>