<template>
  <div class="main-content">
    <breadcumb :page="$t('tradePlan')" :folder="$t('tradeManage')" />
    <b-tabs pills align="end" v-model="tabIndex">
      <b-tab :title="$t('tradeList')" active @click="clearData">
        <b-card :title="$t('tradeList')">
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
              <span v-if="props.column.field == 'name'">
                <span v-if="$i18n.locale == 'en'">
                  {{ props.row.name_en }}
                </span>
                <span v-else>
                  {{ props.row.name }}
                </span>
              </span>
              <span v-else-if="props.column.field == 'created_at'">
                {{ props.row.created_at }}
              </span>
              <span v-else-if="props.column.field == 'action'">
                <button
                  type="submit"
                  class="btn btn-default btn-edit"
                  v-b-popover.hover.right="$t('editPlan')"
                  @click="editPlanView(props.row)"
                >
                  <i class="fa fa-pencil"></i>
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
      </b-tab>
      <b-tab
        :title="$t('editPlan')"
        :title-item-class="{ hiddenClass: !canEdit }"
      >
        <b-card :title="$t('editPlan')">
          <b-row align-h="center">
            <b-col md="8 mb-30">
              <b-form v-on:submit.prevent="tradeControl">
                <div class="form-group row">
                  <label for="name1" class="col-sm-2 col-form-label">{{
                    $t("tradeName")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="name1"
                      v-model="name"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="name_en1" class="col-sm-2 col-form-label">{{
                    $t("tradeNameEN")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="name_en1"
                      v-model="name_en"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label
                    for="max_order_count1"
                    class="col-sm-2 col-form-label"
                    >{{ $t("max_order_count") }}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="number"
                      class="form-control"
                      id="max_order_count1"
                      v-model="max_order_count"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label
                    for="stop_profit_rate1"
                    class="col-sm-2 col-form-label"
                    >{{ $t("stop_profit_rate") }}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="number"
                      class="form-control"
                      id="stop_profit_rate1"
                      step="any"
                      v-model="stop_profit_rate"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label
                    for="stop_profit_rate1"
                    class="col-sm-2 col-form-label"
                    >{{ $t("stop_profit_callback_rate") }}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="number"
                      class="form-control"
                      id="stop_profit_callback_rate1"
                      v-model="stop_profit_callback_rate"
                      step="any"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="cover_rate1" class="col-sm-2 col-form-label">{{
                    $t("cover_rate")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="number"
                      class="form-control"
                      id="cover_rate1"
                      v-model="cover_rate"
                      step="any"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label
                    for="cover_callback_rate1"
                    class="col-sm-2 col-form-label"
                    >{{ $t("cover_callback_rate") }}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="number"
                      class="form-control"
                      id="cover_callback_rate1"
                      v-model="cover_callback_rate"
                      step="any"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row justify-content-end">
                  <div class="col-sm-12">
                    <div class="mt-4 float-right">
                      <b-button type="submit" class="m-1" variant="primary">{{
                        $t("create")
                      }}</b-button>
                      <!-- <b-button type="button" variant="light">Back</b-button> -->
                    </div>
                  </div>
                </div>
              </b-form>
            </b-col>
          </b-row>
        </b-card>
      </b-tab>
      <b-tab :title="$t('createPlan')" @click="clearData">
        <b-card :title="$t('createPlan')">
          <b-row align-h="center">
            <b-col md="8 mb-30">
              <b-form v-on:submit.prevent="tradeControl">
                <div class="form-group row">
                  <label for="name" class="col-sm-2 col-form-label">{{
                    $t("tradeName")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="name"
                      v-model="name"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="name_en" class="col-sm-2 col-form-label">{{
                    $t("tradeNameEN")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="name_en"
                      v-model="name_en"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label
                    for="max_order_count"
                    class="col-sm-2 col-form-label"
                    >{{ $t("max_order_count") }}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="number"
                      class="form-control"
                      id="max_order_count"
                      v-model="max_order_count"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label
                    for="stop_profit_rate"
                    class="col-sm-2 col-form-label"
                    >{{ $t("stop_profit_rate") }}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="number"
                      class="form-control"
                      id="stop_profit_rate"
                      v-model="stop_profit_rate"
                      step="any"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label
                    for="stop_profit_rate"
                    class="col-sm-2 col-form-label"
                    >{{ $t("stop_profit_callback_rate") }}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="number"
                      class="form-control"
                      id="stop_profit_callback_rate"
                      v-model="stop_profit_callback_rate"
                      step="any"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="cover_rate" class="col-sm-2 col-form-label">{{
                    $t("cover_rate")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="number"
                      class="form-control"
                      id="cover_rate"
                      v-model="cover_rate"
                      step="any"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label
                    for="cover_callback_rate"
                    class="col-sm-2 col-form-label"
                    >{{ $t("cover_callback_rate") }}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="number"
                      class="form-control"
                      id="cover_callback_rate"
                      v-model="cover_callback_rate"
                      step="any"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row justify-content-end">
                  <div class="col-sm-12">
                    <div class="mt-4 float-right">
                      <b-button type="submit" class="m-1" variant="primary">{{
                        $t("create")
                      }}</b-button>
                      <!-- <b-button type="button" variant="light">Back</b-button> -->
                    </div>
                  </div>
                </div>
              </b-form>
            </b-col>
          </b-row>
        </b-card>
      </b-tab>
    </b-tabs>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { editPlan, getTradePlan } from "../../../system/api/api";
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
          label: this.$t("name"),
          text: "name",
          field: "name",
          thClass: "gull-th-class",
          value: "name",
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
          label: this.$t("updated_at"),
          text: "updated_at",
          field: "updated_at",
          thClass: "gull-th-class",
          value: "updated_at",
          sortable: false,
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

      selectedID: null,
      name: "",
      name_en: "",
      max_order_count: "",
      stop_profit_rate: "",
      stop_profit_callback_rate: "",
      cover_rate: "",
      cover_callback_rate: "",

      isLoading: false,
      canClear: false,
      canEdit: false,
      totalRecords: 0,
      tabIndex: 0,
      pageNumber: 1,
      pinLog: "",
      rows: [],
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
    showModal(row) {
      this.$bvModal.show("modal-1");
      this.pinLog = row;
    },
    onPageChange(params) {
      this.pageNumber = params.currentPage;
      this.loadItems();
      var container = this.$el.querySelector("#table");
      var top = container.offsetTop;

      window.scrollTo(0, top);
    },
    editPlanView(row) {
      this.tabIndex = 1;
      this.canEdit = true;
      this.selectedID = row.id;
      this.name = row.name;
      this.name_en = row.name_en;
      this.max_order_count = row.max_order_count;
      this.stop_profit_rate = row.stop_profit_rate;
      this.stop_profit_callback_rate = row.stop_profit_callback_rate;
      this.cover_rate = row.cover_rate;
      this.cover_callback_rate = row.cover_callback_rate;
    },
    clearData() {
      this.canEdit = false;
      this.selectedID = null;
      this.name = "";
      this.name_en = "";
      this.max_order_count = "";
      this.stop_profit_rate = "";
      this.stop_profit_callback_rate = "";
      this.cover_rate = "";
      this.cover_callback_rate = "";
    },
    tradeControl() {
      let formData = new FormData();
      if (this.selectedID != null) formData.append("id", this.selectedID);
      formData.append("name", this.name);
      formData.append("name_en", this.name_en);
      formData.append("max_order_count", this.max_order_count);
      formData.append("stop_profit_rate", this.stop_profit_rate);
      formData.append(
        "stop_profit_callback_rate",
        this.stop_profit_callback_rate
      );
      formData.append("cover_rate", this.cover_rate);
      formData.append("cover_callback_rate", this.cover_callback_rate);

      var result = editPlan(formData);
      var self = this;

      result
        .then(function (value) {
          if (value.data.code > 0) {
            self.$refs.msg.makeToast("danger", value.data.message);
          } else {
            self.$refs.msg.makeToast("success", self.$t("successSubmit"));
            self.canEdit = false;
            self.tabIndex = 0;
            self.rows = [];
            self.loadItems();
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    loadItems() {
      var result = getTradePlan(this.pageNumber);
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

<style>
.hiddenClass {
  pointer-events: none;
  display: none;
}
</style>