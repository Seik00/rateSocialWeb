<template>
  <div class="main-content">
    <breadcumb :page="$t('products')" :folder="$t('products_list')" />
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
    <b-tabs pills align="end" v-model="tabIndex">
      <b-tab :title="$t('products_list')" active @click="clearData">
        <b-card :title="$t('products_list')">
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
              <span v-else-if="props.column.field == 'status'">
                <span v-if="props.row.status" style="color: green">
                  <i class="fa fa-check"></i>
                </span>
                <span v-else style="color: red">
                  <i class="fa fa-remove"></i>
                </span>
              </span>
              <span v-else-if="props.column.field == 'public_path'">
                <img :src="props.row.public_path" style="height:50px">
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
      
      <b-tab :title="$t('create_products')" @click="clearData">
        <b-card :title="$t('create_products')">
          <b-form class="mx-5" v-on:submit.prevent="productControl">
            <b-row align-h="center">
              <b-col md="10 mb-30">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{{
                    $t("name")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      v-model="productName"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{{
                    $t("name") + '(English)'
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      v-model="productName_EN"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{{
                    $t("price")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control" 
                      v-model="productPrice"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="is_display" class="col-sm-2 col-form-label">{{
                    $t("is_display")
                  }}</label>
                  <div class="col-sm-10 py-2">
                    <label class="switch switch-primary mr-3">
                      <input type="checkbox" v-model="status" checked/>
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>
                 <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{{
                    $t("image")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="file"
                      name="image"
                      accept="image/*"
                      style="font-size: 1em; padding: 10px 0; width: 100%"
                      @change="setImage"
                      ref="myBtn"
                    />
                    <div
                    style="height: 25vh; position: relative"
                    @click="myClickEvent"
                  >
                    <div v-if="!imgSrc" class="upload-hint">
                      <i class="i-Upload text-25"></i>
                      <p>{{ $t("upload_hint") }}</p>
                    </div>
                    <img
                      v-if="imgSrc"
                      :src="imgSrc"
                      style="
                        width: auto;
                        height: 100%;
                        position: absolute;
                        z-index: 2;
                      "
                    />
                  </div>
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
          <b-form class="mx-5" v-on:submit.prevent="productControl">
            <b-row align-h="center">
              <b-col md="12 my-30">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">{{
                    $t("name")
                  }}</label>
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      v-model="productName"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">{{
                    $t("name") + '(English)'
                  }}</label>
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      v-model="productName_EN"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">{{
                    $t("price")
                  }}</label>
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      v-model="productPrice"
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
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">{{
                    $t("image")
                  }}</label>
                  <div class="col-sm-9">
                     <img :src="image" style="height:50px">
                  </div>
                  <div class="col-sm-3">
                    
                  </div>
                  <div class="col-sm-9">
                    <input
                      type="file"
                      name="image"
                      class="form-control"
                       @change="setImage"
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
import { getProductList, controlProduct } from "../../../system/api/api";
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
          label: this.$t("founds"),
          text: "price",
          field: "price",
          thClass: "gull-th-class",
          value: "price",
          sortable: false,
        },
        {
          label: this.$t("is_display"),
          text: "status",
          field: "status",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t("image"),
          text: "public_path",
          field: "public_path",
          thClass: "gull-th-class",
          value: "public_path",
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
      productName: "",
      productName_EN: "",
      productPrice: "",
      image:"",
      is_display: true,
      imgSrc: "",
      searchUsername: "",
      from: "",
      to: "",
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
      self.productName = contentData.name;
      self.productName_EN = contentData.name_en;
      self.productPrice = contentData.price;
      self.is_display = contentData.status == 1 ? true : false;
      self.image = contentData.public_path;
    },
    setImage(e) {
      const file = e.target.files[0];
      this.image = file;
      if (!file.type.includes("image/")) {
        alert("Please select an image file");
        return;
      }
      if (typeof FileReader === "function") {
        const reader = new FileReader();
        reader.onload = (event) => {
          this.imgSrc = event.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        alert("Sorry, FileReader API not supported");
      }
    },
    productControl() {
      let formData = new FormData();
      if (this.id != null) formData.append("id", this.id);
      formData.append("name", this.productName);
      formData.append("name_en", this.productName_EN);
      formData.append("price", this.productPrice);
      formData.append("status", this.is_display ? 1 : 0);
      formData.append("file", this.image);

      var result = controlProduct(formData);
      var self = this;
      result
        .then(function (value) {
          if (value.data.error_code == 0) {
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
      self.productName = "";
      self.productName_EN = "";
      self.productPrice = "";
      self.image = null;
    },
    loadItems() {
      var result = getProductList(
        this.pageNumber,
        this.from,
        this.to,
        this.searchUsername,
      );
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          // console.log(value.data);
          var dataList = value.data.data.record.data;
          self.rows = dataList;
          self.totalRecords = value.data.data.record.total;
          self.totalFounds = value.data.data.total;
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