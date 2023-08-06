<template>
  <div class="main-content">
    <breadcumb :page="$t('pinList')" :folder="$t('pinManage')" />
    <b-tabs pills align="end" v-model="tabIndex">
      <b-tab :title="$t('pinList')" active>
        <b-card :title="$t('pinList')">
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
              <span v-if="props.column.field == 'status'">
                <span v-if="props.row.news_type == 1">
                  <b-badge href="#" variant="success  m-2">{{
                    $t("used")
                  }}</b-badge>
                </span>
                <span v-else>
                  <b-badge href="#" variant="light  m-2">{{
                    $t("unused")
                  }}</b-badge>
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
      <!-- <b-tab :title="$t('createPin')">
        <b-card :title="$t('createPin')">
          <b-row align-h="center">
            <b-col md="8 mb-30">
              <b-form v-on:submit.prevent="addPin">
                <div class="form-group row">
                  <label for="inputRemark3" class="col-sm-2 col-form-label">{{
                    $t("username")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="inputRemark3"
                      v-model="username"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputAmount3" class="col-sm-2 col-form-label">{{
                    $t("pinAmount")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="inputAmount3"
                      v-model="amount"
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
      </b-tab> -->
    </b-tabs>
    <b-modal id="modal-1" size="lg" centered :title="$t('pinLog')">
      <vue-good-table
        id="table"
        mode="remote"
        :columns="pinLogLabel"
        :search-options="{
          enabled: false,
          placeholder: 'Search this table',
        }"
        :pagination-options="{
          enabled: false,
          perPageDropdownEnabled: false,
          mode: 'pages',
              pageLabel: $t('page'),
        }"
        styleClass="tableOne vgt-table table-striped"
        :selectOptions="{
          enabled: false,
          selectionInfoClass: 'table-alert__box',
        }"
        :rows="pinLog"
      >
      </vue-good-table>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { addPin, getPinList } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
export default {
  components: {
    Dialog,
  },
  computed: {
    pinLogLabel() {
      return [
        {
          label: this.$t("pin"),
          text: "pin",
          field: "pin",
          thClass: "gull-th-class",
          value: "pin",
          sortable: false,
        },
        {
          label: this.$t("userId"),
          text: "userId",
          field: "user_id",
          thClass: "gull-th-class",
          value: "userId",
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
          label: this.$t("pin"),
          text: "pin",
          field: "pin",
          thClass: "gull-th-class",
          value: "pin",
          sortable: false,
        },
        {
          label: this.$t("userId"),
          text: "userId",
          field: "user_id",
          thClass: "gull-th-class",
          value: "userId",
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
          label: this.$t("created_at"),
          text: "created_at",
          field: "created_at",
          thClass: "gull-th-class",
          value: "created_at",
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
      isLoading: false,
      canClear: false,
      totalRecords: 0,
      tabIndex: 0,
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
    addPin() {
      let formData = new FormData();
      formData.append("username", this.username);
      formData.append("amount", this.amount);

      var result = addPin(formData);
      var self = this;

      result
        .then(function (value) {
          if (value.data.code > 0) {
            self.$refs.msg.makeToast("danger", value.data.message);
          } else {
            self.$refs.msg.makeToast("success", self.$t("successSubmit"));
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
      var result = getPinList(this.pageNumber);
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