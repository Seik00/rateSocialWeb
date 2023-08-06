<template>
  <div class="main-content">
    <breadcumb :page="$t('spotMarket')" :folder="$t('market')" />

    <b-tabs pills align="end" v-model="tabIndex">
      <b-tab :title="$t('marketList')" active @click="clearData">
        <b-card :title="$t('marketList')">
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
              <span v-if="props.column.field == 'type'">
                <span v-if="props.row.type == 1">
                  <!-- <span class="badge badge-light">公告</span> -->
                  <b-badge href="#" variant="secondary  m-2">{{$t('spot')}}</b-badge>
                </span>
              </span>
              <span v-else-if="props.column.field == 'status'">
                <span v-if="props.row.status == 1">
                  <!-- <span class="badge badge-light">公告</span> -->
                  <b-badge href="#" variant="success m-2">{{$t('is_display')}}</b-badge>
                </span>
                <span v-else-if="props.row.status == 0">
                  <!-- <span class="badge badge-light">公告</span> -->
                  <b-badge href="#" variant="danger m-2">{{$t('no_display')}}</b-badge>
                </span>
              </span>
              <span v-else-if="props.column.field == 'is_pop'">
                <span v-if="props.row.is_pop" style="color: green">
                  <i class="fa fa-check"></i>
                </span>
                <span v-else style="color: red">
                  <i class="fa fa-remove"></i>
                </span>
              </span>
              <span v-else-if="props.column.field == 'update_time'">
                {{ (props.row.update_time) }}
              </span>
              <span v-else-if="props.column.field == 'action'">
                <button
                  type="submit"
                  class="btn btn-default btn-edit"
                  v-b-popover.hover.right="$t('editMarket')"
                  @click="newsInfo(props.row)"
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
      <b-tab :title="$t('editMarket')" :title-item-class="{ hiddenClass: !canEdit }">
        <b-card :title="$t('editMarket')">
          <b-form class="mx-5" v-on:submit.prevent="marketControl">
            <b-row align-h="center">
              <b-col md="10 mb-30">
                <div class="form-group row">
                  <label for="title2" class="col-sm-2 col-form-label"
                    >{{$t('platform')}}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="title2"
                      v-model="platform"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="market_name" class="col-sm-2 col-form-label"
                    >{{$t('market_name')}}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="market_name"
                      v-model="market_name"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="market" class="col-sm-2 col-form-label"
                    >{{$t('market')}}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="market"
                      v-model="market"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="stock" class="col-sm-2 col-form-label"
                    >{{$t('stock')}}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="stock"
                      v-model="stock"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="money" class="col-sm-2 col-form-label"
                    >{{$t('money')}}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="money"
                      v-model="money"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="wr" class="col-sm-2 col-form-label">{{
                    $t("is_display")
                  }}</label>
                  <div class="col-sm-10 py-2">
                    <label class="switch switch-primary mr-3">
                      <input type="checkbox" v-model="status" />
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>
                <div class="form-group row justify-content-end">
                  <div class="col-sm-12">
                    <div class="mt-4 float-right">
                      <b-button
                        type="submit"
                        class="m-1"
                        variant="primary"
                        >{{$t('editMarket')}}</b-button
                      >
                    </div>
                  </div>
                </div>
              </b-col>
            </b-row>
          </b-form>
        </b-card>
      </b-tab>
      <b-tab :title="$t('createMarket')" @click="clearData">
        <b-card :title="$t('createMarket')">
          <b-form class="mx-5" v-on:submit.prevent="marketControl">
            <b-row align-h="center">
              <b-col md="10 mb-30">
                <div class="form-group row">
                  <label for="platform" class="col-sm-2 col-form-label"
                    >{{$t('platform')}}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="platform"
                      v-model="platform"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="market_name2" class="col-sm-2 col-form-label"
                    >{{$t('market_name')}}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="market_name2"
                      v-model="market_name"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="market2" class="col-sm-2 col-form-label"
                    >{{$t('market')}}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="market2"
                      v-model="market"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="stock2" class="col-sm-2 col-form-label"
                    >{{$t('stock')}}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="stock2"
                      v-model="stock"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="money2" class="col-sm-2 col-form-label"
                    >{{$t('money')}}</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="money2"
                      v-model="money"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="wr" class="col-sm-2 col-form-label">{{
                    $t("is_display")
                  }}</label>
                  <div class="col-sm-10 py-2">
                    <label class="switch switch-primary mr-3">
                      <input type="checkbox" v-model="status" />
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>
                <div class="form-group row justify-content-end">
                  <div class="col-sm-12">
                    <div class="mt-4 float-right">
                      <b-button
                        type="submit"
                        class="m-1"
                        variant="primary"
                        >{{$t('createMarket')}}</b-button
                      >
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
import {
  getSpotMarketList,
  controlSpotMarketControl,
} from "../../../system/api/api";
import {handleError} from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
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
          label: this.$t('platform'),
          text: "platform",
          field: "platform",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t('market_name'),
          text: "market_name",
          field: "market_name",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t('market'),
          text: "market",
          field: "market",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t('spot_type'),
          text: "type",
          field: "type",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t('stock'),
          text: "stock",
          field: "stock",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t('money'),
          text: "money",
          field: "money",
          // width: "190px",
          thClass: "gull-th-class",
          sortable: false,
          html: true,
        },
        {
          label: this.$t('min_money'),
          text: "min_money",
          field: "min_money",
          // width: "190px",
          thClass: "gull-th-class",
          sortable: false,
          html: true,
        },
        {
          label: this.$t('min_stock'),
          text: "min_stock",
          field: "min_stock",
          // width: "190px",
          thClass: "gull-th-class",
          sortable: false,
          html: true,
        },
        // {
        //   label: this.$t('update_time'),
        //   text: "update_time",
        //   field: "update_time",
        //   thClass: "gull-th-class",
        //   sortable: false,
        // },
        {
          label: this.$t('status'),
          text: "status",
          field: "status",
          thClass: "gull-th-class",
          sortable: false,
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
      canEdit: false,
      tabIndex: 0,
      selectedId: null,
      isLoading: false,
      canClear: false,
      totalRecords: 0,
      pageNumber: 1,
      message: "",
      rows: [],
      platform: "",
      market_name: "",
      market: "",
      stock: "",
      money: "",
      status: true
    };
  },
  props: ["success"],
  methods: {
    processDate(rawDate) {
      var d = new Date((rawDate*1000));
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
    marketControl() {
      let formData = new FormData();
      if (this.selectedId != null) formData.append("id", this.selectedId);
      formData.append("platform", this.platform);
      formData.append("market_name", this.market_name);
      formData.append("market", this.market);
      formData.append("stock", this.stock);
      formData.append("money", this.money);
      formData.append("status", this.status?1:0);

      var result = controlSpotMarketControl(formData);
      var self = this;
      result
        .then(function () {
          self.$refs.msg.makeToast("success", self.$t('successSubmit'));
          self.tabIndex = 0;
          self.canEdit = false;
          self.rows= [];
          self.loadItems();
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    newsInfo(row) {
      this.canEdit = true;
      var self = this;
      self.tabIndex = 1;
      var contentData = row;
      self.selectedId = contentData.id;
      self.platform = contentData.platform;
      self.market_name = contentData.market_name;
      self.market = contentData.market;
      self.stock = contentData.stock;
      self.money = contentData.money;
      self.status = contentData.status==1?true:false;
    },
    clearData() {
      this.canEdit = false;
      var self = this;
      self.selectedId = null;
      self.platform = "";
      self.market_name = "";
      self.market = "";
      self.stock = "";
      self.money = "";
      self.status = true;
    },
    loadItems() {
      var result = getSpotMarketList(this.pageNumber);
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