<template>
  <div class="main-content">
    <breadcumb :page="$t('ticketList')" :folder="$t('ticketCenter')" />
    <b-card :title="$t('ticketList')">
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
          <span v-if="props.column.field == 'body'">
            <b-form-textarea
              v-model="props.row.body"
              rows="2"
              max-rows="3"
              no-resize
              plaintext
            >
            </b-form-textarea>
          </span>
          <span v-else-if="props.column.field == 'rebody'">
            <b-form-textarea
              v-model="props.row.rebody"
              rows="2"
              max-rows="3"
              no-resize
              plaintext
            >
            </b-form-textarea>
          </span>
          <span v-else-if="props.column.field == 'admin_read'">
            <span v-if="props.row.admin_read == 1">
              <b-badge href="#" variant="success  m-2">{{
                $t("read")
              }}</b-badge>
            </span>
            <span v-else>
              <b-badge href="#" variant="danger  m-2">{{
                $t("unread")
              }}</b-badge>
            </span>
          </span>
          <span v-else-if="props.column.field == 'user_read'">
            <span v-if="props.row.user_read == 1">
              <b-badge href="#" variant="success  m-2">{{
                $t("read")
              }}</b-badge>
            </span>
            <span v-else>
              <b-badge href="#" variant="danger  m-2">{{
                $t("unread")
              }}</b-badge>
            </span>
          </span>
          <span v-else-if="props.column.field == 'created_at'">
            {{ (props.row.created_at) }}
          </span>
          <span v-else-if="props.column.field == 'updated_at'">
            {{ (props.row.created_at) }}
          </span>
          <span v-else-if="props.column.field == 'action'">
            <button
              type="button"
              class="btn btn-default btn-edit"
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

    <b-modal id="modal-1" size="lg" centered title="Reply" :hide-footer="true">
      <b-form class="mx-5"  v-on:submit.prevent="ticketControl">
        <b-row align-h="center">
          <b-col md="12 mb-30">
            <div class="form-group row">
              <label for="title2" class="col-sm-2 col-form-label">{{$t('title')}}</label>
              <div class="col-sm-10">
                <input
                  type="text"
                  class="form-control"
                  id="title2"
                  v-model="title"
                  readonly
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="description2" class="col-sm-2 col-form-label"
                >{{$t('description')}}</label
              >
              <div class="col-sm-10">
                <b-form-textarea
                  v-model="body"
                  rows="3"
                  max-rows="6"
                  no-resize
                  plaintext
                >
                </b-form-textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="reply" class="col-sm-2 col-form-label">{{$t('rebody')}}</label>
              <div class="col-sm-10">
                <b-form-textarea
                  v-model="rebody"
                  rows="3"
                  max-rows="6"
                  no-resize
                  required
                  ref="inputText1"
                >
                </b-form-textarea>
              </div>
            </div>
            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="mt-4 float-right">
                  <b-button
                    type="submit"
                    class="m-1"
                    variant="primary"
                    >{{$t('submit')}}</b-button
                  >
                </div>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getTicketList, controlTicket, markRead, countRead} from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import {handleError} from "../../../system/handleRes";
import { mapActions } from "vuex";
export default {
  computed: {
    columns() {
      return [
        {
          label: this.$t('id'),
          text: "id",
          field: "id",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t('userId'),
          text: "user_id",
          field: "user_id",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t('title'),
          text: "title",
          field: "title",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t('description'),
          text: "body",
          field: "body",
          thClass: "gull-th-class",
          tdClass: "bodyWidth",
          sortable: false,
        },
        {
          label: this.$t('rebody'),
          text: "rebody",
          field: "rebody",
          thClass: "gull-th-class",
          tdClass: "bodyWidth",
          sortable: false,
        },
        {
          label: this.$t('user_read'),
          text: "user_read",
          field: "user_read",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t('admin_read'),
          text: "admin_read",
          field: "admin_read",
          thClass: "gull-th-class",
          value: "admin_read",
          sortable: false,
        },
        {
          label: this.$t('add_time'),
          text: "add_time",
          field: "add_time",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t('re_time'),
          text: "re_time",
          field: "re_time",
          // width: "190px",
          thClass: "gull-th-class",
          sortable: false,
          html: true,
        },
        {
          label: this.$t('action'),
          field: "action",
          tdClass: "linkWidth",
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
      title: "",
      body: "",
      rebody: "",
      isLoading: false,
      canClear: false,
      totalRecords: 0,
      pageNumber: 1,
      message: "",
      rows: [],
    };
  },
  props: ["success"],
  methods: {
    ...mapActions([
      "changeUnread",
    ]),

    processDate(rawDate) {
      var d = new Date((rawDate));
      var dMinute = d.getMinutes();
      var dHour = d.getHours();
      if(dMinute.toString().length==1){
        dMinute = "0"+dMinute;

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
      this.loadItems();
    },
    onCancel() {
      this.canClear = false;
      this.loadItems();
    },
    addFile() {
      console.log("hello");
    },
    ticketControl() {
      let formData = new FormData();
      formData.append("id", this.selectedId);
      formData.append("rebody", this.rebody);

      var result = controlTicket(formData);
      var self = this;
      result.then(function (value) {
        if (value.data.code == 0) {
          self.$refs.msg.makeToast("success", this.$t('successSubmit'));
        }
      })
      .catch(function (error) {
        self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
      });
      self.$bvModal.hide("modal-1");
      self.rows = [];
      self.loadItems();
    },
    showModal(row) {
      this.$bvModal.show("modal-1");

      var self = this;
      var contentData = row;
      self.selectedId = contentData.id;
      self.title = contentData.title;
      self.body = contentData.body;
      self.rebody = contentData.rebody;

      this.markAsRead(contentData.id);
    },

    markAsRead(id){
      let formData = new FormData();
      formData.append("id", id);

      var self = this;
      var result = markRead(formData);
      result.then(function () {
        self.countR();
      })
      .catch(function (error) {
        self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
      });
    },

    countR(){
      var result = countRead();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          console.log(value);
          self.loadItems();
          self.changeUnread(value.data.data.record);
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },

    clearData() {
      this.canEdit = false;
      var self = this;
      self.selectedId = null;
      self.title = "";
      self.description = "";
      self.type = "1";
      self.language = "";
      self.is_display = 0;
      self.imgSrc = "";
    },
    loadItems() {
      var result = getTicketList(this.pageNumber);
      var self = this;
      this.isLoading = true;
      result.then(function (value) {
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

.bodyWidth {
  min-width: 250px;
}

.overflow {
  white-space: nowrap;
  overflow: hidden;
  display: inline-block;
  width: 100%;
  text-overflow: ellipsis;
}
</style>