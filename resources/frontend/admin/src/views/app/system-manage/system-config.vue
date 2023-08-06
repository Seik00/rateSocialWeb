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
          <div class="col-sm-6" v-else-if="item.global_key == 'MINING_START'">
            <div class="">
              <label>
                <input type="time" class="form-control" v-model="dataset[item.global_key]">
                <span>{{ $t("enter_start") }}</span>
              </label>
            </div>
          </div>
          <div class="col-sm-6" v-else-if="item.global_key == 'MINING_END'">
            <div class="">
              <label>
                <input type="time" class="form-control" v-model="dataset[item.global_key]">
                <span>{{ $t("enter_end") }}</span>
              </label>
            </div>
          </div>
          <div class="col-sm-6" v-else-if="item.global_key == 'DEFAULT_SETTINGS'">
            <div class="col-sm-10 py-2">
              <label>
                <button
                  type="button"
                  class="btn btn-default btn-edit"
                  v-b-popover.hover.top="$t('edit')"
                  @click="showSettings(dataset[item.global_key])"
                >
                  <i class="fa fa-pencil"> Setting</i>
                </button>
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
    <b-modal
      id="modal-1"
      size="xl"
      centered
      :title="$t('edit')"
      :hide-footer="true"
    >
      <b-tabs pills>
        <b-form v-on:submit.prevent="saveConfig">
          <div
            class="form-group row"
            v-for="(item, index) in form.setting"
            :key="item.id"
          >
            <label class="col-sm-1 col-form-label">{{
              $t("order") + "No" + (index + 1)
            }}</label>
            <div class="col-sm-1">
              <input
                type="number"
                class="form-control"
                v-model="form.setting[index]['order']"
                min="1"
                step="0.01"
                required
              />
            </div>
            <label class="col-sm-1 col-form-label">{{
              $t("price") + "(USD) " + "No" + (index + 1)
            }}</label>
            <div class="col-sm-1">
              <input
                type="number"
                class="form-control"
                v-model="form.setting[index]['price']"
                min="0"
                step="0.01"
                required
              />
            </div>
            <label class="col-sm-1 col-form-label">{{
              $t("profit") + "(%) " + "No" + (index + 1)
            }}</label>
            <div class="col-sm-1">
              <input
                type="number"
                class="form-control"
                v-model="form.setting[index]['profit_rate']"
                min="0"
                step="0.01"
                required
              />
            </div>
            <label class="col-sm-2 col-form-label">{{
              $t("products_price") + " No" + (index + 1)
            }}</label>
            <div class="col-sm-3">
              <SearchModal
                v-on:_productID="changeID"
                :index="index"
                :products="productOptions"
                :id="form.setting[index]['product_id']"
              ></SearchModal>
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
      </b-form>
      </b-tabs>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { systemConfig, saveSystemConfig } from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { handleError } from "../../../system/handleRes";
import SearchModal from "./searchOption.vue";
export default {
  components: {
    Dialog,
    SearchModal,
  },
  data() {
    return {
      form: {
        setting: [],
      },
      setting: [],
      selectedId: null,
      title: "",
      dataset: {},
      isLoading: false,
      canClear: false,
      totalRecords: 0,
      pageNumber: 1,
      message: "",
      rows: [],
      productOptions: [],
      utc4Start: "",
    };
  },
  props: ["success"],
  methods: {
    showSettings(setting) {
      console.log(setting);
      this.$bvModal.show("modal-1");
      this.form.setting = [];
      console.log(JSON.parse(setting));
      
      if (setting == null) {
        for (let i = 0; i < 30; i++) {
          var tmap = {};
          tmap["order"] = 1;
          tmap["price"] = 0;
          tmap["profit_rate"] = 0;
          tmap["product_id"] = "";
          this.form.setting.push(tmap);
        }
      } else {
        this.form.setting = JSON.parse(setting);
      }
    },
    changeID: function (item) {
      console.log("Event from child component emitted", item);
      this.form.setting[item.index]["product_id"] = item.productID;
      
      console.log(item.index, this.form.setting[item.index]["product_id"]);
    },
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

        }else if(value == "DEFAULT_SETTINGS"){
          this.dataset[value] = this.form.setting;
          this.$bvModal.hide("modal-1");
        }else if(value == "MINING_START"){
          if (this.dataset[value].length != 8) {
            this.dataset[value] = this.dataset[value] + ':00'.slice(0, 8);
          }
        }else if(value == "MINING_END"){
           if (this.dataset[value].length != 8) {
            this.dataset[value] = this.dataset[value] + ':00'.slice(0, 8);
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
            self.dataset = {};
            self.rows = [];
            self.loadItems();
          }else{
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          // localStorage.removeItem("userToken");
          // self.$router.push("/admin/sessions/signIn");
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
            } else if (item.global_key == "DEFAULT_SETTINGS") {
                self.form.setting = item.key_value;
                self.dataset[item.global_key] = self.form.setting;
                console.log('==============');
                console.log(self.form.setting);
                console.log('==============');
            }else {
              self.dataset[item.global_key] = item.key_value;
            }
          });

          self.productOptions = [];
          var emptyProduct = {};
          emptyProduct["value"] = null;
          emptyProduct["text"] = "";
          self.productOptions.push(emptyProduct);
          self.product = value.data.data.product;
          for (let i = 0; i < self.product.length; i++) {
            var jsonProduct = {};
            jsonProduct["value"] = self.product[i].id;
            jsonProduct["text"] =
              "(" + self.product[i].price + ") " + self.product[i].name_en;
            self.productOptions.push(jsonProduct);
          }

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
@media screen and (min-width: 480px) {
  .modal-dialog.modal-xl.modal-dialog-centered{
    width:1200px;
    max-width:1200px;
  }
}
</style>