<template>
  <div class="main-content">
    <breadcumb :page="$t('daPrice')" :folder="$t('tradingPlatform')" />
    <b-tabs pills align="end">
      <b-tab :title="$t('daPrice')" active>
        <b-card :title="$t('daPrice')">
          <i class="flag flag-united-states"></i>
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
      
     
    </b-tabs>
    
    <b-modal
      id="modal-1"
      size="md"
      centered
      :title="$t('edit')"
      :hide-footer="true"
    >
      <b-tabs pills>
          <b-form class="mx-5" v-on:submit.prevent="countryControl">
            <b-row align-h="center">
              <b-col md="12 my-30">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">{{
                    $t("price")
                  }}</label>
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      v-model="amount"
                      required
                    />
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
import { getDAPrice, controlDAPrice } from "../../../system/api/api";
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
          text: "stock",
          field: "stock",
          thClass: "gull-th-class",
          value: "stock",
          sortable: false,
        },
        {
          label: this.$t("price"),
          text: "price",
          field: "price",
          thClass: "gull-th-class",
          value: "price",
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
  data() {
    return {
      amount: "",
      isLoading: false,
      canClear: false,
      totalRecords: 0,
      totalFounds: 0,
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
      console.log(d)
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
    showModal(row) {
      console.log(row);
      this.$bvModal.show("modal-1");

      var self = this;
      var contentData = row;
      self.amount = contentData.amount;
    },
    countryControl() {
      let formData = new FormData();
      formData.append("amount", this.amount);

      var result = controlDAPrice(formData);
      var self = this;
      result
        .then(function (value) {
          if (value.data.error_code == 0) {
            self.rows = [];
            self.$refs.msg.makeToast("success", value.data.message);
            self.$bvModal.hide("modal-1");
            self.loadItems();
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    loadItems() {
      var result = getDAPrice(
        this.pageNumber
      );
      var self = this;
      this.isLoading = true;  
      result
        .then(function (value) {
          var dataList = value.data.data.record.data;
          console.log(dataList);
          self.rows = dataList;
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