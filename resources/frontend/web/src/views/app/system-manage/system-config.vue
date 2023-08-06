<template>
  <div class="main-content">
    <breadcumb :page="$t('system_config')" :folder="$t('system_setting')" />
    <b-card title=" ">
      <b-form class="mx-5" v-on:submit.prevent="saveConfig">
        <div v-for="item in rows" :key="item.id" class="form-group row justify-content-center">
          <label :for="item.global_key" class="col-sm-3 col-form-label">
            {{ $t(item.global_key) }}
          </label>
          <div class="col-sm-6" v-if="item.global_key == 'BONUS_SWITCH'">
            <div class="col-sm-10 py-2">
              <label class="switch switch-primary mr-3">
                <input type="checkbox" v-model="dataset[item.global_key]" />
                <span class="slider"></span>
              </label>
            </div>
          </div>
          <div class="col-sm-6" v-else-if="item.global_key == 'SITE_ON'">
            <div class="col-sm-10 py-2">
              <label class="switch switch-primary mr-3">
                <input type="checkbox" v-model="dataset[item.global_key]" />
                <span class="slider"></span>
              </label>
            </div>
          </div>
          <div class="col-sm-6" v-else>
            <b-form-input
              type="text"
              class="form-control"
              :id="item.global_key"
              v-model="dataset[item.global_key]"
              required
            />
          </div>
        </div>
        <div class="form-group row justify-content-center">
          <div class="col-sm-9">
            <div class="mt-4 float-right">
              <b-button type="submit" class="m-1" variant="primary">{{
                $t("submit")
              }}</b-button>
            </div>
          </div>
        </div>
      </b-form>
    </b-card>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { systemConfig, saveSystemConfig } from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { handleError } from "../../../system/handleRes";
export default {
  components: {
    Dialog,
  },
  data() {
    return {
      selectedId: null,
      title: "",
      dataset: {},
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
      var d = new Date(rawDate);
      var dMinute = d.getMinutes();
      var dHour = d.getHours();
      if (dMinute.toString().length == 1) {
        dMinute = "0" + dMinute;

      }
      
      if(dHour.toString().length == 1){
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
      this.loadItems();
    },
    onCancel() {
      this.canClear = false;
      this.loadItems();
    },
    addFile() {
      console.log("hello");
    },
    saveConfig() {
      for (var value in this.dataset) {
        if (value == "SITE_ON") {
          if (this.dataset[value]) {
            this.dataset[value] = 1;
          } else {
            this.dataset[value] = 0;
          }
        }else if(value == "BONUS_SWITCH"){
          if (this.dataset[value]) {
            this.dataset[value] = 1;
          } else {
            this.dataset[value] = 0;
          }

        }
        // console.log(this.dataset[value]);
      }
      let formData = JSON.stringify(this.dataset);

      var result = saveSystemConfig(formData);
      var self = this;
      result
        .then(function (value) {
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t("successSubmit"));
          }
          self.dataset = {};
          self.rows = [];
          self.loadItems();
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          // localStorage.removeItem("boostToken");
          // self.$router.push("/web/admin/sessions/signIn");
        });
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
      var result = systemConfig();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          var dataList = value.data.data.record;
          self.rows = dataList;
          self.isLoading = false;

          dataList.forEach((item) => {
            if (item.global_key == "BONUS_SWITCH") {
              if (item.key_value == 1) {
                self.dataset[item.global_key] = true;
              } else {
                self.dataset[item.global_key] = false;
              }
            } else if (item.global_key == "SITE_ON") {
              if (item.key_value == 1) {
                self.dataset[item.global_key] = true;
              } else {
                self.dataset[item.global_key] = false;
              }
            } else {
              self.dataset[item.global_key] = item.key_value;
            }
          });
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