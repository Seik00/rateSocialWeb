<template>
  <div class="main-content">
    <breadcumb :page="$t('newsList')" :folder="$t('newsManage')" />

    <b-tabs pills align="end" v-model="tabIndex">
      <b-tab :title="$t('newsList')" active @click="clearData">
        <b-card :title="$t('newsList')">
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
              <span v-if="props.column.field == 'news_type'">
                <span v-if="props.row.news_type == 1">
                  <!-- <span class="badge badge-light">公告</span> -->
                  <b-badge href="#" variant="secondary  m-2">{{
                    $t("announce")
                  }}</b-badge>
                </span>
                <span v-else-if="props.row.news_type == 2">
                  <!-- <span class="badge badge-light">公告</span> -->
                  <b-badge href="#" variant="secondary  m-2">{{
                    $t("banner")
                  }}</b-badge>
                </span>
                <span v-else-if="props.row.news_type == 3">
                  <!-- <span class="badge badge-light">公告</span> -->
                  <b-badge v-if="$i18n.locale=='en'" href="#" variant="secondary  m-2">
                    Play Video
                  </b-badge>
                  <b-badge v-else href="#" variant="secondary  m-2">
                    放视频
                  </b-badge>
                </span>
                <span v-else-if="props.row.news_type == 4">
                  <!-- <span class="badge badge-light">公告</span> -->
                  <b-badge v-if="$i18n.locale=='en'" href="#" variant="secondary  m-2">
                    User Manual
                  </b-badge>
                  <b-badge v-else href="#" variant="secondary  m-2">
                    用户手册
                  </b-badge>
                </span>
                <span v-else-if="props.row.news_type == 5">
                  <b-badge v-if="$i18n.locale=='en'" href="#" variant="secondary  m-2">
                    News
                  </b-badge>
                  <b-badge v-else href="#" variant="secondary  m-2">
                    新闻
                  </b-badge>
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
              <span v-else-if="props.column.field == 'is_pop'">
                <span v-if="props.row.is_pop" style="color: green">
                  <i class="fa fa-check"></i>
                </span>
                <span v-else style="color: red">
                  <i class="fa fa-remove"></i>
                </span>
              </span>
              <span v-else-if="props.column.field == 'language'">
                <span v-if="props.row.language == 'en'"> English </span>
                <span v-else-if="props.row.language == 'in'"> Bahasa Indonesia </span>
                <span v-else> 中文 </span>
              </span>
              <span v-else-if="props.column.field == 'created_at'">
                {{ props.row.created_at }}
              </span>
              <span v-else-if="props.column.field == 'updated_at'">
                {{ props.row.updated_at }}
              </span>
              <span v-else-if="props.column.field == 'action'">
                <button
                  type="button"
                  class="btn btn-default btn-edit"
                  @click="newsInfo(props.row)"
                >
                  <i class="fa fa-pencil"></i>
                </button>
                <!-- <button type="button" class="btn btn-default btn-delete mx-1">
                  <i class="fa fa-trash"></i>
                </button>
                <button type="button" class="btn btn-default btn-push">
                  <i class="fa fa-hand-o-up"></i>
                </button> -->
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
        :title="$t('editNews')"
        :title-item-class="{ hiddenClass: !canEdit }"
      >
        <b-card :title="$t('editNews')">
          <b-form class="mx-5" v-on:submit.prevent="newsControl">
            <b-row align-h="center">
              <b-col md="7 mb-30">
                <div class="form-group row">
                  <label for="type2" class="col-sm-2 col-form-label">{{
                    $t("news_type")
                  }}</label>
                  <div class="col-sm-10">
                    <b-form-select
                      v-model="type"
                      :options="
                        $i18n.locale == 'zh' ? selectOptions : selectOptionsEn
                      "
                      id="type2"
                    >
                    </b-form-select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="title2" class="col-sm-2 col-form-label">{{
                    $t("title")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="title2"
                      v-model="title"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="description2" class="col-sm-2 col-form-label">{{
                    $t("description")
                  }}</label>
                  <div class="col-sm-10">
                    <b-form-textarea v-model="description" rows="3">
                    </b-form-textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="language2" class="col-sm-2 col-form-label">{{
                    $t("language")
                  }}</label>
                  <div class="col-sm-10 py-2">
                    <b-form-radio-group
                      v-model="language"
                      :options="languageOptions"
                      name="radio-inline"
                    ></b-form-radio-group>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="is_display2" class="col-sm-2 col-form-label">{{
                    $t("is_display")
                  }}</label>
                  <div class="col-sm-10 py-2">
                    <label class="switch switch-primary mr-3">
                      <input type="checkbox" v-model="is_display" />
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="is_pop" class="col-sm-2 col-form-label">{{
                    $t("is_pop")
                  }}</label>
                  <div class="col-sm-10 py-2">
                    <label class="switch switch-primary mr-3">
                      <input type="checkbox" v-model="is_pop" />
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>
              </b-col>
              <b-col md="5 mb-30">
                <label v-if="type==3" for="file2" class="">{{ $t("video") }}</label>
                <label v-else-if="type==4 || type==5" for="file2" class="">{{ $t("file") }}</label>
                <label v-else for="file2" class="">{{ $t("image") }}</label>
                <input
                  v-if="type == 3"
                  type="file"
                  name="video"
                  accept="video/mp4,video/x-m4v,video/*"
                  style="font-size: 1em; padding: 10px 0; width: 100%"
                  @change="setVideo"
                  ref="myBtn"
                />
                <input
                  v-else-if="type == 4 || type == 5"
                  type="file"
                  name="pdf"
                  accept="application/pdf"
                  style="font-size: 1em; padding: 10px 0; width: 100%"
                  @change="setVideo"
                  ref="myBtn"
                />
                <input
                  v-else
                  type="file"
                  name="image"
                  accept="image/*"
                  style="font-size: 1em; padding: 10px 0; width: 100%"
                  @change="setImage"
                  ref="myBtn"
                />
                <div v-if="type!=3 && type!=4 && type!=5"
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
              </b-col>
              <b-col>
                <div class="form-group row justify-content-end">
                  <div class="col-sm-12">
                    <div class="mt-4 float-right">
                      <b-button type="submit" class="m-1" variant="primary">{{
                        $t("submit")
                      }}</b-button>
                      <!-- <b-button type="button" variant="light">Back</b-button> -->
                    </div>
                  </div>
                </div>
              </b-col>
            </b-row>
          </b-form>
        </b-card>
      </b-tab>
      <b-tab :title="$t('createNews')" @click="clearData">
        <b-card :title="$t('createNews')">
          <b-form class="mx-5" v-on:submit.prevent="newsControl">
            <b-row align-h="center">
              <b-col md="7 mb-30">
                <div class="form-group row">
                  <label for="type" class="col-sm-2 col-form-label">{{
                    $t("news_type")
                  }}</label>

                  <div class="col-sm-10">
                    <b-form-select
                      v-model="type"
                      :options="
                        $i18n.locale == 'zh' ? selectOptions : selectOptionsEn
                      "
                      id="type"
                    >
                    </b-form-select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="title" class="col-sm-2 col-form-label">{{
                    $t("title")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="title"
                      v-model="title"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="description" class="col-sm-2 col-form-label">{{
                    $t("description")
                  }}</label>
                  <div class="col-sm-10">
                    <input
                      type="text"
                      class="form-control"
                      id="description"
                      v-model="description"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="language" class="col-sm-2 col-form-label">{{
                    $t("language")
                  }}</label>
                  <div class="col-sm-10 py-2">
                    <b-form-radio-group
                      v-model="language"
                      :options="languageOptions"
                      name="radio-inline"
                    ></b-form-radio-group>
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
                <div class="form-group row">
                  <label for="is_pop" class="col-sm-2 col-form-label">{{
                    $t("is_pop")
                  }}</label>
                  <div class="col-sm-10 py-2">
                    <label class="switch switch-primary mr-3">
                      <input type="checkbox" v-model="is_pop" />
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>
              </b-col>
              <b-col md="5 mb-30">
                <label v-if="type==3" for="file" class="">{{ $t("video") }}</label>
                <label v-else-if="type==4 || type==5" for="file" class="">{{ $t("file") }}</label>
                <label v-else for="file" class="">{{ $t("image") }}</label>
                <input
                  v-if="type == 3"
                  type="file"
                  name="video"
                  accept="video/mp4,video/x-m4v,video/*"
                  style="font-size: 1em; padding: 10px 0; width: 100%"
                  @change="setVideo"
                  ref="myBtn"
                />
                <input
                  v-else-if="type == 4 || type == 5"
                  type="file"
                  name="pdf"
                  accept="application/pdf"
                  style="font-size: 1em; padding: 10px 0; width: 100%"
                  @change="setVideo"
                  ref="myBtn"
                />
                <input
                  v-else
                  type="file"
                  name="image"
                  accept="image/*"
                  style="font-size: 1em; padding: 10px 0; width: 100%"
                  @change="setImage"
                  ref="myBtn"
                />
                <div v-if="type!=3 && type!=4 && type!=5"
                  style="height: 30vh; position: relative"
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
              </b-col>
              <b-col>
                <div class="form-group row justify-content-end">
                  <div class="col-sm-12">
                    <div class="mt-4 float-right">
                      <b-button type="submit" class="m-1" variant="primary">{{
                        $t("create")
                      }}</b-button>
                      <!-- <b-button type="submit" variant="light">Back</b-button> -->
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
import { getNewsList, controlNews } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
export default {
  computed: {
    columns() {
      return [
        {
          label: this.$t("id"),
          text: "id",
          field: "id",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t("title"),
          text: "title",
          field: "title",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t("news_type"),
          text: "type",
          field: "news_type",
          thClass: "gull-th-class",
          sortable: false,
        },
        {
          label: this.$t("language"),
          text: "language",
          field: "language",
          thClass: "gull-th-class",
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
          label: this.$t("is_pop"),
          text: "is_pop",
          field: "is_pop",
          // width: "190px",
          thClass: "gull-th-class",
          sortable: false,
          html: true,
        },
        {
          label: this.$t("updated_at"),
          text: "updated_at",
          field: "updated_at",
          thClass: "gull-th-class",
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
      imgSrc: "",
      selectedId: null,
      title: "",
      description: "",
      type: "1",
      language: "en",
      image: null,
      is_display: false,
      is_pop: false,
      isLoading: false,
      canClear: false,
      totalRecords: 0,
      pageNumber: 1,
      selectOptions: [
        // { value: "1", text: "公告" },
        // { value: "2", text: "首页展示图" },
        // { value: "3", text: "放视频" },
        // { value: "4", text: "用户手册" },
        { value: "5", text: "新闻" },
      ],
      selectOptionsEn: [
        // { value: "1", text: "Announcement" },
        // { value: "2", text: "Banner" },
        // { value: "3", text: "Play Video" },
        // { value: "4", text: "User Manual" },
        { value: "5", text: "News" },
      ],
      languageOptions: [
        { text: "English", value: "en" },
        { text: "中文", value: "cn" },
        // { text: "Bahasa Indonesia", value: "in" },
      ],
      message: "",
      rows: [],
    };
  },
  props: ["success"],
  methods: {
    myClickEvent() {
      const elem = this.$refs.myBtn;
      elem.click();
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
    setVideo(e) {
      var files = e.target.files[0] || e.dataTransfer.files[0];
      this.image = files;
      if (!files.length) return;
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
      this.loadItems();
    },
    onCancel() {
      this.canClear = false;
      this.loadItems();
    },
    addFile() {
      console.log("hello");
    },
    newsControl() {
      console.log(this.is_display);
      let formData = new FormData();
      if (this.selectedId != null) formData.append("id", this.selectedId);
      formData.append("title", this.title);
      formData.append("description", this.description);
      formData.append("news_type", this.type);
      formData.append("language", this.language);
      formData.append("is_display", this.is_display ? 1 : 0);
      formData.append("is_pop", this.is_pop ? 1 : 0);
      formData.append("file", this.image);

      var result = controlNews(formData);
      var self = this;
      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.error_code == "0") {
            self.tabIndex = 0;
            self.rows = [];
            self.loadItems();
            self.$refs.msg.makeToast("success", self.$t('successSubmit'));
            self.clearData();
          }
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    newsInfo(row) {
      this.$refs.myBtn.value = null;
      this.canEdit = true;
      var self = this;
      self.tabIndex = 1;
      var contentData = row;
      self.selectedId = contentData.id;
      self.title = contentData.title;
      self.description = contentData.description;
      self.type = contentData.news_type;
      self.language = contentData.language;
      self.is_display = contentData.is_display == 1 ? true : false;
      self.is_pop = contentData.is_pop == 1 ? true : false;
      self.image = null;
      if (contentData.banner) self.imgSrc = contentData.public_path;
    },
    clearData() {
      this.canEdit = false;
      var self = this;
      self.selectedId = null;
      self.title = "";
      self.description = "";
      self.type = "1";
      self.language = "";
      self.is_display = false;
      self.is_pop = false;
      self.image = null;
      self.imgSrc = "";
    },
    loadItems() {
      var result = getNewsList(this.pageNumber);
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