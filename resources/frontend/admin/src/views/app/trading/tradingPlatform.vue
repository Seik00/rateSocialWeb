<template>
    <div class="main-content">
      <breadcumb :page="$t('tradingPlatform')" :folder="$t('tradingPlatform')" />
  
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
                    required
                    :placeholder="$t('Enter') + $t('username')"
                    v-model="searchUsername"
                  ></b-form-input>
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
  
      <b-tabs pills align="end" v-model="tabIndex">
        <b-tab :title="$t('tradingPlatform')" active @click="clearData">
          <b-card :title="$t('tradingPlatform')">
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
                <!-- <span v-if="props.column.field == 'detail'">
                  <span v-if="$i18n.locale == 'zh'">
                    {{ props.row.detail }}
                  </span>
                  <span v-else>
                    {{ props.row.detailen }}
                  </span>
                </span> -->
                <span v-if="props.column.field == 'found'">
                  <span v-if="props.row.act == '-'" style="color: red">
                    -{{ props.row.amount }}
                  </span>
                  <span v-else style="color: green">
                    +{{ props.row.amount }}
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
        </b-tab>
        
        <b-tab :title="$t('adjust_coin')" @click="clearData">
          <b-card :title="$t('adjust_coin')">
            <b-form class="mx-5" v-on:submit.prevent="changeW">
              <b-row align-h="center">
                <b-col md="10 mb-30">
                  <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">{{
                      $t("username")
                    }}</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        class="form-control"
                        id="username"
                        v-model="username"
                        required
                      />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="wallet_type" class="col-sm-2 col-form-label">{{
                      $t("coin")
                    }}</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        class="form-control"
                        :placeholder="'DA'"
                        readonly
                      />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="adjust" class="col-sm-2 col-form-label">{{
                      $t("adjust")
                    }}</label>
                    <div class="col-sm-10">
                      <b-form-select
                        v-model="act"
                        :options="actOptions"
                        id="adjust"
                      >
                      </b-form-select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="amount" class="col-sm-2 col-form-label">{{
                      $t("founds")
                    }}</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        class="form-control"
                        id="amount"
                        v-model="amount"
                        required
                      />
                    </div>
                  </div>
                  <div class="form-group row justify-content-end">
                    <div class="col-sm-12">
                      <div class="mt-4 float-right">
                        <b-button type="submit" class="m-1" variant="primary">{{
                          $t("submit")
                        }}</b-button>
                      </div>
                    </div>
                  </div>
                </b-col>
              </b-row>
            </b-form>
          </b-card>
        </b-tab>
      </b-tabs>
      <Dialog ref="msg"></Dialog>
    </div>
  </template>
  
  <script>
  import { getADAdjust, daAdjustWallet } from "../../../system/api/api";
  import { handleError } from "../../../system/handleRes";
  import Dialog from "../../../components/dialog.vue";
  import { mapGetters } from "vuex";
  export default {
    computed: {
      ...mapGetters(["lang"]),
    
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
            label: this.$t("previousBalance"),
            text: "from_asset",
            field: "from_asset",
            thClass: "gull-th-class",
            value: "from_asset",
            sortable: false,
          },
          {
            label: this.$t("founds"),
            text: "found",
            field: "found",
            thClass: "gull-th-class",
            value: "found",
            sortable: false,
          },
          {
            label: this.$t("currentBalance"),
            text: "to_asset",
            field: "to_asset",
            thClass: "gull-th-class",
            value: "to_asset",
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
          {
            label: this.$t("action"),
            text: "action",
            field: "action",
            thClass: "gull-th-class",
            value: "action",
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
        details_en: "",
        details_cn: "",
        remark: "",
        wallets: "",
        walletOptions: [],
        searchUsernameWallet: "",
        selectWalletType: 1,
        searchUsername: "",
        from: "",
        to: "",
      };
    },
    props: ["success"],
    methods: {
      showWallet(username) {
        this.searchUsernameWallet = username;
        this.rows = [];
        this.pageNumber = 1;
  
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
      onSearch() {
        this.pageNumber = 1;
        if (this.searchUsername != "" || this.from != "" || this.to != "") {
          this.canClear = true;
        }
        this.loadItems();
      },
      onCancel() {
        this.searchUsername = "";
        this.from = "";
        this.to = "";
        this.canClear = false;
        this.loadItems();
      },
      changeW() {
        let formData = new FormData();
        if (this.selectedId != null) formData.append("id", this.selectedId);
        formData.append("username", this.username);
        formData.append("act", this.act);
        formData.append("amount", this.amount);
  
        var result = daAdjustWallet(formData);
        var self = this;
        result
          .then(function (value) {
            if (value.data.error_code == 0) {
              self.$refs.msg.makeToast("success", self.$t("successSubmit"));
            } else {
              self.$refs.msg.makeToast("danger", value.data.message);
            }
            self.tabIndex = 0;
            self.canEdit = false;
            self.rows = [];
            self.walletOptions = [];
            self.loadItems();
          })
          .catch(function (error) {
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          });
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
        self.details_en = contentData.detailen;
        self.details_cn = contentData.detail;
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
        this.walletOptions = [];
        var tempType = this.wallet_type;
        var result = getADAdjust(
          this.pageNumber,
          this.from,
          this.to,
          this.searchUsername
        );
        var self = this;
        this.isLoading = true;
        result
          .then(function (value) {
            console.log(value);
            var dataList = value.data.data.record.data;
            self.rows = dataList;
            self.totalRecords = value.data.data.record.total;
            self.wallets = value.data.data.wallet;
            self.isLoading = false;
  
            var w = self.wallets;
            self.wallet_type = self.wallets[1].found_type;
  
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
            self.wallet_type = tempType;
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
        console.log(self.walletOptions);
      },
    },
    created() {
      this.loadItems();
    },
  };
  </script>
  
  <style>
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
  </style>