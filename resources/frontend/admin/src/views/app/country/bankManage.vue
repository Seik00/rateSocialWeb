<template>
  <div class="main-content">
    <breadcumb :page="$t('bank_list')" :folder="$t('bank_list')" />
    <!-- <b-row>
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
    </b-row> -->
    <b-tabs pills align="end">
      <b-tab :title="$t('bank_list')" active @click="clearData">
        <b-card :title="$t('bank_list')">
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
                <span v-if="$i18n.locale == 'zh'">
                  {{ props.row.name }}
                </span>
                <span v-else>
                  {{ props.row.name_en }}
                </span>
              </span>
              <span v-else-if="props.column.field == 'is_display'">
                <span v-if="props.row.is_display" style="color: green">
                  <i class="fa fa-check"></i>
                </span>
                <span v-else style="color: red">
                  <i class="fa fa-remove"></i>
                </span>
              </span>
               <span v-else-if="props.column.field == 'country'">
                <span v-if="$i18n.locale == 'zh'">
                  {{ props.row.country.name }}
                </span>
                <span v-else>
                  {{ props.row.country.name_en }}
                </span>
              </span>
              <span v-else-if="props.column.field == 'created_at'">
                {{ (props.row.created_at) }}
              </span>
              <span v-else-if="props.column.field == 'action'">
                    <button
                      type="button"
                      class="btn btn-default btn-edit"
                      v-b-popover.hover.top="$t('edit')"
                      @click="showModal(props.row)"
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
      
      <b-tab :title="$t('create_bank')" @click="clearData">
        <b-card :title="$t('create_bank')">
          <b-form class="mx-5" v-on:submit.prevent="bankControl">
            <b-row align-h="center">
              <b-col md="10 mb-30">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{{
                    $t("country")
                  }}</label>
                  <div class="col-sm-10">
                    <b-form-select
                    v-model="bank_country"
                    :options="countryOptions"
                    id="country"
                  >
                  </b-form-select>
                  </div>
                </div>
                <!-- <b-form-group :label="$t('country')" class="form-customize mt-3">
                  <b-form-select
                    v-model="bank_country"
                    :options="countryOptions"
                    id="country"
                  >
                  </b-form-select>
                </b-form-group> -->
                  <!-- <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{{
                    $t("bank_country")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      v-model="bank_country"
                      required
                    />
                  </div>
                </div> -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{{
                    $t("bank_name")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      v-model="bank_name"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{{
                    $t("bank_number")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      v-model="bank_number"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{{
                    $t("bank_user")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      v-model="bank_user"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{{
                    $t("branch")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      v-model="branch"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{{
                    $t("swift_code")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      v-model="swift_code"
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="is_display" class="col-sm-2 col-form-label">{{
                    $t("is_display")
                  }}</label>
                  <div class="col-sm-10 py-2">
                    <label class="switch switch-primary mr-3">
                      <input type="checkbox" v-model="is_display" />
                      <span class="slider"></span>
                    </label>
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
    
    <b-modal
      id="modal-1"
      size="md"
      centered
      :title="$t('edit')"
      :hide-footer="true"
    >
      <b-tabs pills>
          <b-form class="mx-5" v-on:submit.prevent="bankControl">
            <b-row align-h="center">
              <b-col md="12 my-30">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">{{
                    $t("country")
                  }}</label>
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      v-model="bank_name"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">{{
                    $t("bank_name")
                  }}</label>
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      v-model="bank_name"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">{{
                    $t("bank_number")
                  }}</label>
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      v-model="bank_number"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">{{
                    $t("bank_user")
                  }}</label>
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      v-model="bank_user"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">{{
                    $t("branch")
                  }}</label>
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      v-model="branch"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">{{
                    $t("swift_code")
                  }}</label>
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      v-model="swift_code"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="is_display" class="col-sm-3 col-form-label">{{
                    $t("is_display")
                  }}</label>
                   <div class="col-sm-9">
                    <label class="switch switch-primary mr-3">
                      <input type="checkbox" v-model="is_display" />
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>
               
                <div class="form-group row justify-content-end">
                  <div class="col-sm-12">
                    <div class="mt-4 float-right">
                      <b-button type="submit" class="m-1" variant="primary">{{
                        $t("update")
                      }}</b-button>
                    </div>
                  </div>
                </div>
              </b-col>
            </b-row>
          </b-form>
      </b-tabs>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getBankList, controlBank } from "../../../system/api/api";
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
          label: this.$t("country"),
          text: "country",
          field: "country",
          thClass: "gull-th-class",
          value: "country",
          sortable: false,
        },
        {
          label: this.$t("bank_name"),
          text: "bank_name",
          field: "bank_name",
          thClass: "gull-th-class",
          value: "bank_name",
          sortable: false,
        },
        {
          label: this.$t("bank_number"),
          text: "bank_number",
          field: "bank_number",
          thClass: "gull-th-class",
          value: "bank_number",
          sortable: false,
        },
        {
          label: this.$t("bank_user"),
          text: "bank_user",
          field: "bank_user",
          thClass: "gull-th-class",
          value: "bank_user",
          sortable: false,
        },
        {
          label: this.$t("branch"),
          text: "branch",
          field: "branch",
          thClass: "gull-th-class",
          value: "branch",
          sortable: false,
        },
        {
          label: this.$t("swift_code"),
          text: "swift_code",
          field: "swift_code",
          thClass: "gull-th-class",
          value: "swift_code",
          sortable: false,
        },
        {
          label: this.$t("is_display"),
          text: "is_display",
          field: "is_display",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t("action"),
          field: "action",
          tdClass: "bodyWidth",
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
      id: "",
      bank_country: "",
      bank_name: "",
      bank_number: "",
      bank_user: "",
      branch: "",
      swift_code: "",
      country: null,
      countryList: [],
      countryOptions: [],
      is_display: false,
      searchUsername: "",
      from: "",
      to: "",
      amount: "",
      isLoading: false,
      canClear: false,
      totalRecords: 0,
      pageNumber: 1,
      pinLog: "",
      rows: [],
    };
  },
  methods: {
    myClickEvent() {
      const elem = this.$refs.myBtn;
      elem.click();
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
    showModal(row) {
      this.$bvModal.show("modal-1");

      var self = this;
      var contentData = row;
      self.id = contentData.id;
      self.bank_name = contentData.bank_name;
      self.bank_number = contentData.bank_number;
      self.bank_user = contentData.bank_user;
      self.branch = contentData.branch;
      self.swift_code = contentData.swift_code;
      self.is_display = contentData.is_display == 1 ? true : false;
    },
    bankControl() {
      let formData = new FormData();
      if (this.id != null) formData.append("id", this.id);
      formData.append("bank_country", this.bank_country);
      formData.append("bank_name", this.bank_name);
      formData.append("bank_number", this.bank_number);
      formData.append("bank_user", this.bank_user);
      formData.append("branch", this.branch);
      formData.append("swift_code", this.swift_code);
      formData.append("status", this.is_display ? 1 : 0);

      var result = controlBank(formData);
      var self = this;
      result
        .then(function (value) {
          if (value.data.code == 0) {
            self.rows = [];
            self.$refs.msg.makeToast("success", value.data.message);
            self.clearData();
            self.$bvModal.hide("modal-1");
            self.loadItems();
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    clearData() {
      var self = this;
      self.id = null;
      self.bank_country = "";
      self.bank_name = "";
      self.bank_number = "";
      self.bank_user = "";
      self.branch = "";
      self.swift_code = "";
      self.is_display = "";
    },
    loadItems() {
      var result = getBankList(
        this.pageNumber,
        this.from,
        this.to,
        this.searchUsername,
      );
      var self = this;
      self.countryOptions = [];
      self.countryList = [];
      this.isLoading = true;
      result
        .then(function (value) {
          console.log(value);
          var dataList = value.data.data.record.data;
          self.rows = dataList;
          self.totalRecords = value.data.data.record.total;

          self.countryList = value.data.data.country;
          for (let i = 0; i < value.data.data.country.length; i++) {
            var jsonObject = {};
            jsonObject["value"] = value.data.data.country[i].id;
            jsonObject["text"] =
              self.$i18n.locale == "en"
                ? value.data.data.country[i].name_en
                : value.data.data.country[i].name;
            self.countryOptions.push(jsonObject);
          }
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