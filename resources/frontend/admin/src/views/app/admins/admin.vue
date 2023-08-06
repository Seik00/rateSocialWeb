<template>
  <div class="main-content">
    <breadcumb :page="$t('adminList')" :folder="$t('adminManage')" />
    <b-tabs pills align="end" v-model="tabIndex">
      <b-tab :title="$t('adminList')" active @click="clearData">
        <b-card :title="$t('adminList')">
          <!-- <b-row>
            <b-col md="12">
              <b-card class="mb-30">
                <b-row align-v="center">
                  <b-col md="2">
                    <b-form-group
                      id="input-group-1"
                      label="Username"
                      label-for="input-1"
                    >
                      <b-form-input
                        id="input-1"
                        type="text"
                        required
                        placeholder="Enter username"
                        v-model="username"
                      ></b-form-input>
                    </b-form-group>
                  </b-col>

                  <b-col md="2" class="mt-3 mt-md-0">
                    <b-form-group
                      id="input-group-2"
                      label="Phone Number"
                      label-for="input-2"
                    >
                      <b-form-input
                        id="input-2"
                        type="text"
                        required
                        placeholder="Enter Phone Number"
                        v-model="phone"
                      ></b-form-input>
                    </b-form-group>
                  </b-col>

                  <b-col md="1" class="mt-3 mt-md-0">
                    <b-button variant="primary" @click="onSearch"
                      >Search</b-button
                    >
                  </b-col>
                  <b-col md="1" class="mt-3 mt-md-0" v-if="canClear">
                    <b-button variant="danger" @click="onCancel"
                      >Clear</b-button
                    >
                  </b-col>
                </b-row>
              </b-card>
            </b-col>
          </b-row> -->
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
              <span v-if="props.column.field == 'action'">
                <button
                  type="button"
                  class="btn btn-default btn-edit"
                  v-b-popover.hover.right="$t('edit')"
                  @click="adminInfo(props.row)"
                >
                  <i class="fa fa-pencil"></i>
                </button>
                <button
                  v-if="!props.row.active"
                  type="button"
                  class="btn btn-default btn-delete mx-1"
                  v-b-popover.hover.right="$t('delete')"
                  @click="deleteAdmin(props.row.id)"
                >
                  <i class="fa fa-trash"></i>
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
      </b-tab>

      <b-tab
        :title="$t('editAdmin')"
        :title-item-class="{ hiddenClass: !canEdit }"
      >
        <b-card :title="$t('editAdmin')">
          <b-row align-h="center">
            <b-col md="8 mb-30">
              <b-form class="mx-5"  v-on:submit.prevent="updateAdmin">
                <div class="form-group row">
                  <label for="username2" class="col-sm-2 col-form-label">{{
                    $t("username")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="username2"
                      v-model="username"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password2" class="col-sm-2 col-form-label">{{
                    $t("password")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="password"
                      class="form-control"
                      id="password2"
                      v-model="password"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="mobile_no2" class="col-sm-2 col-form-label">{{
                    $t("mobile")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="mobile_no2"
                      v-model="mobile_no"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row justify-content-end">
                  <div class="col-sm-12">
                    <div class="mt-4 float-right">
                      <b-button type="submit" class="m-1" variant="primary">{{
                        $t("edit")
                      }}</b-button>
                    </div>
                  </div>
                </div>
              </b-form>
            </b-col>
          </b-row>
        </b-card>
      </b-tab>
      <b-tab :title="$t('createAdmin')" @click="clearData">
        <b-card :title="$t('createAdmin')">
          <b-row align-h="center">
            <b-col md="8 mb-30">
              <b-form v-on:submit.prevent="createAdmin">
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
                  <label for="password" class="col-sm-2 col-form-label">{{
                    $t("password")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="password"
                      class="form-control"
                      id="password"
                      v-model="password"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="mobile_no" class="col-sm-2 col-form-label">{{
                    $t("mobile")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="mobile_no"
                      v-model="mobile_no"
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
import {
  getAdminList,
  create_admin,
  delete_admin,
  update_admin,
} from "../../../system/api/api";
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
          field: "username",
          thClass: "gull-th-class",
          value: "username",
          sortable: false,
        },
        {
          label: this.$t("email"),
          text: "email",
          field: "email",
          thClass: "gull-th-class",
          value: "email",
          sortable: false,
        },
        {
          label: this.$t("mobile"),
          text: "mobile",
          field: "contact_number",
          thClass: "gull-th-class",
          value: "contact_number",
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
      tabIndex: 0,
      username: "",
      password: "",
      mobile_no: "",
      isLoading: false,
      canClear: false,
      canEdit: false,
      totalRecords: 0,
      pageNumber: 1,
      rows: [],
    };
  },
  methods: {
    onPageChange(params) {
      this.pageNumber = params.currentPage;
      this.loadItems();
      var container = this.$el.querySelector("#table");
      var top = container.offsetTop;

      window.scrollTo(0, top);
    },
    onSearch() {
      this.pageNumber = 1;
      if (this.username != "" || this.phone != "") {
        this.canClear = true;
      }
      this.loadItems();
    },
    onCancel() {
      this.username = "";
      this.phone = "";
      this.canClear = false;
      this.loadItems();
    },

    clearData() {
      this.canEdit = false;
      var self = this;
      self.selectedId = null;
      self.username = "";
      self.password = "";
      self.mobile_no = "";
    },
    adminInfo(row) {
      this.canEdit = true;
      var self = this;
      self.tabIndex = 1;
      var contentData = row;
      self.selectedId = contentData.id;
      self.username = contentData.username;
      self.mobile_no = contentData.contact_number;
    },
    createAdmin() {
      let formData = new FormData();
      formData.append("username", this.username);
      formData.append("password", this.password);
      formData.append("mobile_no", this.mobile_no);
      formData.append("role_id", 1);

      var result = create_admin(formData);
      var self = this;
      result
        .then(function (value) {
          self.$refs.msg.makeToast("success", value.data.message);
          self.tabIndex = 0;
          self.rows = [];
          self.canEdit = false;
          self.loadItems();
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    updateAdmin() {
      let formData = new FormData();
      formData.append("id", this.selectedId);
      formData.append("username", this.username);
      formData.append("password", this.password);
      formData.append("mobile_no", this.mobile_no);

      var result = update_admin(formData);
      var self = this;
      result
        .then(function (value) {
          self.$refs.msg.makeToast("success", value.data.message);
          self.tabIndex = 0;
          self.rows = [];
          self.canEdit = false;
          self.loadItems();
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    deleteAdmin(id) {
      let formData = new FormData();
      formData.append("id", id);

      var result = delete_admin(formData);
      var self = this;
      result
        .then(function (value) {
          self.$refs.msg.makeToast("success", value.data.message);
          self.tabIndex = 0;
          self.rows = [];
          self.canEdit = false;
          self.loadItems();
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    loadItems() {
      console.log(localStorage.getItem("userToken"));
      var result = getAdminList(this.pageNumber);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.user.data;
          self.rows = dataList;
          self.totalRecords = value.data.data.user.total;
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