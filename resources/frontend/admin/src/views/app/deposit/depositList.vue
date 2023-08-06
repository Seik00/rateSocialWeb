<template>
  <div class="main-content">
    <breadcumb :page="$t('depositList')" :folder="$t('depositManage')" />

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

    <b-card
      :title="canClear ? $t('searchTotal') + totalRecords : $t('depositList')"
    >
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
          <span v-if="props.column.field == 'detail'">
            <span v-if="$i18n.locale == 'zh'">
              {{ props.row.detail }}
            </span>
            <span v-else>
              {{ props.row.detailen }}
            </span>
          </span>
          <span v-else-if="props.column.field == 'found'">
            <span v-if="props.row.action == '-'" style="color: red">
              -{{ props.row.found }}
            </span>
            <span v-else style="color: green"> +{{ props.row.found }} </span>
          </span>
          <span v-else-if="props.column.field == 'country'">
            <span v-if="$i18n.locale == 'zh'">
              {{ props.row.country.name }}
            </span>
            <span v-else>
              {{ props.row.country.name_en }}
            </span>
          </span>
          <span v-else-if="props.column.field == 'status'">
            <span v-if="props.row.status == 0">
              <b-badge href="#" variant="warning m-2">{{
                $t("pending")
              }}</b-badge>
            </span>
            <span v-else-if="props.row.status == 1">
              <b-badge href="#" variant="success m-2">{{
                $t("approve")
              }}</b-badge>
            </span>
            <span v-else-if="props.row.status == 2">
              <b-badge href="#" variant="danger m-2">{{
                $t("reject")
              }}</b-badge>
            </span>
          </span>
          <span v-else-if="props.column.field == 'document'">
            <span>
               <img :src="props.row.uploaded_file[0].public_image_path" height="50">
                <button
                  class="my-auto mx-2"
                  type="button"
                  v-clipboard="() => props.row.uploaded_file[0].public_image_path"
                  v-clipboard:success="clipboardSuccessHandler"
                  v-clipboard:error="clipboardErrorHandler"
                  >
                  <span>{{ $t("copy") }}</span>
                </button>
            </span>
          </span>
          <!-- <span v-else-if="props.column.field == 'wallet_type'">
            <span v-if="$i18n.locale == 'zh'">
              <span v-if="props.row.action == '+'">
                {{ wallets[props.row.in_type].comments_cn }}
              </span>
              <span v-else>
                {{ wallets[props.row.out_type].comments_cn }}
              </span>
            </span>
            <span v-else>
              <span v-if="props.row.action == '+'">
                {{ wallets[props.row.in_type].comments_en }}
              </span>
              <span v-else>
                {{ wallets[props.row.out_type].comments_en }}
              </span></span
            >
          </span> -->
          <span v-else-if="props.column.field == 'created_at'">
            {{ props.row.created_at }}
          </span>
          <span v-else-if="props.column.field == 'action'">
            <button
              type="button"
              class="btn btn-default btn-push mx-1 px-2"
              v-b-popover.hover.top="$t('approve')"
              v-if="props.row.status == 0"
              @click="showModalApprove(props.row)"
            >
              <i class="fa fa-check"></i>
            </button>
            <button
              type="button"
              class="btn btn-default btn-wallet"
              v-b-popover.hover.top="$t('reject')"
              v-if="props.row.status == 0"
              @click="showModalReject(props.row)"
            >
              <i class="fa fa-times"></i>
            </button>
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
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getDepositList, controlDeposit } from "../../../system/api/api";
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
          label: this.$t("country"),
          text: "country",
          field: "country",
          thClass: "gull-th-class",
          value: "country",
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
        // {
        //   label: this.$t("pay_amount"),
        //   text: "pay_amount",
        //   field: "pay_amount",
        //   thClass: "gull-th-class",
        //   value: "pay_amount",
        //   sortable: false,
        // },
        {
          label: this.$t("status"),
          text: "status",
          field: "status",
          thClass: "gull-th-class",
          value: "status",
          sortable: false,
        },
        {
          label: this.$t("image"),
          text: "document",
          field: "document",
          thClass: "gull-th-class",
          value: "document",
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
          field: "action",
          tdClass: "bodyWidth",
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
      remark: "",
      searchUsername: "",
      from: "",
      to: "",
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
    clipboardSuccessHandler() {
      this.$refs.msg.makeToast("success", this.$t("copied"));
    },
    clipboardErrorHandler() {
      //// console.log('error', value)
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
    showModalApprove(row) {
      this.$swal({
        title: this.$t("are_you_sure_to_approve"),
        text: this.$t("double_confirm"),
        type: "warning",
        showCancelButton: true,
        cancelButtonText: this.$t("cancel"),
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: this.$t("approve")
      }).then(result => {
        if (result.value) {
          console.log(result.value);
          this.approved(row);
        }
      });
    },
    approved(row) {
      let formData = new FormData();
      formData.append("id", row.id);
      formData.append("action", 'APPROVE');

      var result = controlDeposit(formData);
      var self = this;
      result
        .then(function (value) {
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t("successUpdate"));
            self.rows = [];
            self.canEdit = false;
            self.loadItems();
          }else{
             self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });

      this.password = "";
    },
    showModalReject(row) {
      this.$swal({
        title: this.$t("are_you_sure_to_reject"),
        text: this.$t("double_confirm"),
        type: "warning",
        showCancelButton: true,
        cancelButtonText: this.$t("cancel"),
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: this.$t("reject")
      }).then(result => {
        if (result.value) {
          console.log(result.value);
          this.rejected(row);
        }
      });
    },
    rejected(row) {
      let formData = new FormData();
      formData.append("id", row.id);
      formData.append("action", 'REJECT');

      var result = controlDeposit(formData);
      var self = this;
      result
        .then(function (value) {
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t("successUpdate"));
            self.rows = [];
            self.canEdit = false;
            self.loadItems();
          }else{
             self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });

      this.password = "";
    },
    loadItems() {
      var result = getDepositList(this.pageNumber, this.from, this.to, this.searchUsername);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          console.log(value);
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
              //jsonPackageEn["text"] = w[index].comments_en;
              self.walletOptions.push(jsonPackageEn);
            }
          } else {
            for (var index2 in self.wallets) {
              var jsonPackage = {};
              jsonPackage["value"] = w[index2].found_type;
              //jsonPackage["text"] = w[index2].comments_cn;
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
      // var self = this;
      // var w = self.wallets;
      // self.walletOptions = [];
      // if (val == "en") {
      //   for (var index in self.wallets) {
      //     var jsonPackageEn = {};
      //     jsonPackageEn["value"] = w[index].found_type;
      //     jsonPackageEn["text"] = w[index].comments_en;
      //     self.walletOptions.push(jsonPackageEn);
      //   }
      // } else {
      //   for (var index2 in self.wallets) {
      //     var jsonPackage = {};
      //     jsonPackage["value"] = w[index2].found_type;
      //     jsonPackage["text"] = w[index2].comments_cn;
      //     self.walletOptions.push(jsonPackage);
      //   }
      // }
    },
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
</style>