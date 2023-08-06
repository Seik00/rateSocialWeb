<template>
  <div class="main-content">
    <breadcumb :page="$t('withdrawCash')" :folder="$t('withdrawManage')" />

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
              <b-button
                :disabled="isLoading"
                variant="primary"
                @click="onSearch"
                >{{ $t("search") }}</b-button
              >
            </b-col>
            <b-col md="1" class="mt-3 mt-md-0" v-if="canClear">
              <b-button
                :disabled="isLoading"
                variant="danger"
                @click="onCancel"
                >{{ $t("clear") }}</b-button
              >
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>

    <b-card :title="$t('withdrawCash')">
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
        <b-button :disabled="isLoading"  variant="primary" class="btn-rounded"> Add Button </b-button>
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
          <span v-else-if="props.column.field == 'status'">
            <span v-if="props.row.status == 0">
              <b-badge href="#" variant="warning m-2">{{
                $t("pending")
              }}</b-badge>
            </span>
            <span v-else-if="props.row.status == 1">
              <b-badge href="#" variant="primary m-2">{{
                $t("approve")
              }}</b-badge>
            </span>
            <span v-else-if="props.row.status == 2">
              <b-badge href="#" variant="success m-2">{{
                $t("complete")
              }}</b-badge>
            </span>
            <span v-else>
              <b-badge href="#" variant="danger m-2">{{
                $t("reject")
              }}</b-badge>
            </span>
          </span>
          <span v-else-if="props.column.field == 'created_at'">
            {{ props.row.created_at }}
          </span>
          <span v-else-if="props.column.field == 'action'">
            <button
              :disabled="isLoading"
              type="submit"
              class="btn btn-default btn-edit py-3"
              @click="showModalEdit(props.row)"
            >
              <span>{{ $t("edit") }}</span>
            </button>
            <button
              :disabled="isLoading"
              v-if="props.row.status == 0"
              type="submit"
              class="btn btn-default btn-edit py-3"
              @click="showModalApprove(props.row, 'APPROVE')"
            >
              <span>{{ $t("approve") }}</span>
            </button>
            <button
              :disabled="isLoading"
              v-else-if="props.row.status == 1"
              type="submit"
              class="btn btn-default btn-edit py-3"
              @click="showModalCompleted(props.row, 'COMPLETED')"
            >
              <span>{{ $t("complete") }}</span>
            </button>
            <button
              :disabled="isLoading"
              v-if="props.row.status != 3"
              type="submit"
              class="btn btn-default btn-delete py-3 ml-1"
              @click="showRejectModal(props.row)"
            >
              <span>{{ $t("reject") }}</span>
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
                :disabled="isLoading"
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
    <b-modal
      id="modal-edit"
      size="md"
      centered
      :title="$t('edit')"
      :hide-footer="true"
    >
      <b-tabs pills>
        <b-form class="mx-5" v-on:submit.prevent="editControl">
          <b-row align-h="center">
            <b-col md="12 my-30">
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

              <div class="form-group row justify-content-end">
                <div class="col-sm-12">
                  <div class="mt-4 float-right">
                    <b-button
                      :disabled="isLoading"
                      type="submit"
                      class="m-1"
                      variant="primary"
                      >{{ $t("update") }}</b-button
                    >
                  </div>
                </div>
              </div>
            </b-col>
          </b-row>
        </b-form>
      </b-tabs>
    </b-modal>
    <b-modal
      id="modal-txid"
      size="lg"
      centered
      :title="$t('provideTXID')"
      hide-footer
    >
      <b-form class="mx-5" v-on:submit.prevent="changeW">
        <b-row align-h="center">
          <b-col md="10 mb-30">
            <div class="form-group row">
              <label for="remark" class="col-sm-2 col-form-label"> TXID </label>
              <div class="col-sm-10">
                <input
                  type="text"
                  class="form-control"
                  id="remark"
                  v-model="selectedTXID"
                  required
                />
              </div>
            </div>
            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="mt-4 float-right">
                  <b-button
                    :disabled="isLoading"
                    type="submit"
                    class="m-1"
                    variant="primary"
                    >{{ $t("submit") }}</b-button
                  >
                </div>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
    <b-modal
      id="modal-1"
      size="lg"
      centered
      :title="$t('provideRemark')"
      hide-footer
    >
      <b-form class="mx-5" v-on:submit.prevent="rejectW">
        <b-row align-h="center">
          <b-col md="10 mb-30">
            <div class="form-group row">
              <label for="remark" class="col-sm-2 col-form-label">{{
                $t("remark")
              }}</label>
              <div class="col-sm-10">
                <input
                  type="text"
                  class="form-control"
                  id="remark"
                  v-model="remark"
                  required
                />
              </div>
            </div>
            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="mt-4 float-right">
                  <b-button
                    :disabled="isLoading"
                    type="submit"
                    class="m-1"
                    variant="primary"
                    >{{ $t("submit") }}</b-button
                  >
                </div>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
import {
  getWithdrawCashList,
  dowithdrawCashControl,
  editWithdrawCashControl,
} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
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
          label: this.$t("bank_name"),
          text: "bank_name",
          field: "bank_name",
          thClass: "gull-th-class",
          value: "bank_name",
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
          label: this.$t("bank_number"),
          text: "bank_number",
          field: "bank_number",
          thClass: "gull-th-class",
          value: "bank_number",
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
          label: this.$t("status"),
          text: "status",
          field: "status",
          thClass: "gull-th-class",
          value: "status",
          sortable: false,
        },
        {
          label: this.$t("currency"),
          text: "currency",
          field: "currency",
          thClass: "gull-th-class",
          tdClass: "txidWidth",
          value: "currency",
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
        //   label: this.$t("get_amount"),
        //   text: "get_amount",
        //   field: "get_amount",
        //   thClass: "gull-th-class",
        //   value: "get_amount",
        //   sortable: false,
        // },
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
      selectedId: null,
      bank_id: "",
      bank_name: "",
      bank_user: "",
      bank_number: "",
      branch: "",
      isLoading: false,
      canClear: false,
      totalRecords: 0,
      pageNumber: 1,
      message: "",
      rows: [],
      username: "",
      wallet_type: 1,
      amount: "",
      remark: "",
      wallets: "",
      selectedTXID: "",
      searchUsername: "",
      from: "",
      to: "",
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
    showModalEdit(row) {
      console.log(row);
      this.$bvModal.show("modal-edit");

      var self = this;
      var contentData = row;
      self.bank_id = contentData.id;
      self.bank_name = contentData.bank_name;
      self.bank_user = contentData.bank_user;
      self.bank_number = contentData.bank_number;
      self.branch = contentData.branch;
    },
    editControl() {
      let formData = new FormData();
      formData.append("id", this.bank_id);
      formData.append("bank_name", this.bank_name);
      formData.append("bank_user", this.bank_user);
      formData.append("bank_number", this.bank_number);
      formData.append("branch", this.branch);

      var result = editWithdrawCashControl(formData);
      var self = this;
      result
        .then(function (value) {
          self.isLoading = false;
          if (value.data.code == 0) {
            self.rows = [];
            self.$refs.msg.makeToast("success", self.$t("successUpdate"));
            self.clearData();
            self.$bvModal.hide("modal-edit");
            self.loadItems();
          }
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
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
        confirmButtonText: this.$t("approve"),
      }).then((result) => {
        if (result.value) {
          console.log(result.value);
          this.approved(row);
        }
      });
    },
    approved(row) {
      let formData = new FormData();
      formData.append("id", row.id);
      formData.append("action", "APPROVE");

      this.isLoading = true;
      var result = dowithdrawCashControl(formData);
      var self = this;
      result
        .then(function () {
          self.isLoading = false;
          self.$refs.msg.makeToast("success", self.$t("successUpdate"));
          self.rows = [];
          self.canEdit = false;
          self.loadItems();
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });

      this.password = "";
    },
    showModalCompleted(row) {
      this.$swal({
        title: this.$t("are_you_sure_to_approve"),
        text: this.$t("double_confirm"),
        type: "warning",
        showCancelButton: true,
        cancelButtonText: this.$t("cancel"),
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: this.$t("approve"),
      }).then((result) => {
        if (result.value) {
          console.log(result.value);
          this.completed(row);
        }
      });
    },
    completed(row) {
      let formData = new FormData();
      formData.append("id", row.id);
      formData.append("action", "COMPLETED");

      this.isLoading = true;
      var result = dowithdrawCashControl(formData);
      var self = this;
      result
        .then(function () {
          self.isLoading = false;
          self.$refs.msg.makeToast("success", self.$t("successUpdate"));
          self.rows = [];
          self.canEdit = false;
          self.loadItems();
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });

      this.password = "";
    },
    showModal(row, action) {
      this.selectedId = row.id;
      this.selectedAction = action;
      this.$bvModal.show("modal-txid");
    },
    showRejectModal(row) {
      this.selectedId = row.id;
      this.selectedTXID = row.txid;
      this.$bvModal.show("modal-1");
    },
    rejectW() {
      let formData = new FormData();
      formData.append("id", this.selectedId);
      formData.append("action", "REJECT");
      formData.append("remark", this.remark);

      this.isLoading = true;
      var result = dowithdrawCashControl(formData);
      var self = this;
      result
        .then(function (value) {
          self.isLoading = false;
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t("successSubmit"));
          } else {
            self.$refs.msg.makeToast("danger", value.data.message);
          }
          self.rows = [];
          self.$bvModal.hide("modal-1");
          self.selectedId = null;
          self.selectedTXID = "";
          self.remark = "";
          self.loadItems();
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    changeW() {
      let formData = new FormData();
      formData.append("id", this.selectedId);
      formData.append("action", this.selectedAction);
      // formData.append("remark", this.remark);

      this.isLoading = true;
      var result = dowithdrawCashControl(formData);
      var self = this;
      result
        .then(function (value) {
          self.isLoading = false;
          if (value.data.code == 0) {
            self.$refs.msg.makeToast("success", self.$t("successSubmit"));
          } else {
            self.$refs.msg.makeToast("danger", value.data.message);
          }
          self.rows = [];
          self.$bvModal.hide("modal-txid");
          self.selectedId = null;
          self.selectedTXID = "";
          self.selectedAction = "";
          self.loadItems();
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
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
      var result = getWithdrawCashList(
        this.pageNumber,
        this.from,
        this.to,
        this.searchUsername
      );
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.isLoading = false;
          console.log(value);
          var dataList = value.data.data.record.data;
          self.rows = dataList;
          self.totalRecords = value.data.data.record.total;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.isLoading = false;
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

.txidWidth {
  max-width: 275px;
}
.btn-edit {
  margin: 5px;
}
</style>