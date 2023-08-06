<template>
  <div class="main-content">
    <breadcumb :page="'系统配置'" :folder="'配套管理'" />
    <b-card title="List">
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
          mode: 'pages',
              pageLabel: $t('page'),
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
      </vue-good-table>
    </b-card>

    <b-modal id="modal-1" size="lg" centered title="Reply" :hide-footer="true">
      <b-form class="mx-5">
        <b-row align-h="center">
          <b-col md="12 mb-30">
            <div class="form-group row">
              <label for="title2" class="col-sm-2 col-form-label">title</label>
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
                >description</label
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
              <label for="reply" class="col-sm-2 col-form-label">Reply</label>
              <div class="col-sm-10">
                <b-form-textarea
                  v-model="rebody"
                  rows="3"
                  max-rows="6"
                  no-resize
                  required
                >
                </b-form-textarea>
              </div>
            </div>
            <div class="form-group row justify-content-end">
              <div class="col-sm-12">
                <div class="mt-4 float-right">
                  <b-button
                    type="button"
                    class="m-1"
                    variant="primary"
                    @click="ticketControl"
                    >Submit</b-button
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
import { packageConfig, savePackageConfig } from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
export default {
  computed: {
    columns() {
      return [
        {
          label: "id",
          text: "id",
          field: "id",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: "global_key",
          text: "global_key",
          field: "global_key",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: "key_value",
          text: "key_value",
          field: "key_value",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: "created_at",
          text: "created_at",
          field: "created_at",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: "updated_at",
          text: "updated_at",
          field: "updated_at",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: "action",
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

      var result = savePackageConfig(formData);
      var self = this;
      result.then(function (value) {
        if(value.data.code == 0){
          
          self.$refs.msg.makeToast("success", this.$t('successSubmit'));
        }
      });
      // .catch(function (error) {
      // self.makeToast("warning", error.response.statusText+", Please Login Again!");
      //   localStorage.removeItem("userToken");
      //   self.$router.push("/admin/sessions/signIn");
      // });
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
      var result = packageConfig();
      var self = this;
      this.isLoading = true;
      result.then(function (value) {
        var dataList = value.data.data.record;
        self.rows = dataList;
        // self.totalRecords = value.data.data.record.total;
        self.isLoading = false;
      });
      // .catch(function (error) {
      //   self.$refs.msg.makeToast("warning", error.response.statusText+", Please Login Again!");
      //     localStorage.removeItem("userToken");
      //     self.$router.push("/admin/sessions/signIn");
      //   self.isLoading = false;
      // });
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