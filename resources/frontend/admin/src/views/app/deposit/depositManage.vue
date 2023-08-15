<template>
    <div class="main-content">
      <breadcumb :page="$t('depositManage')" :folder="$t('depositManage')" />
  
      <b-tabs pills align="end" v-model="tabIndex">
        <b-tab :title="$t('depositManage')" @click="clearData">
          <b-card :title="$t('depositManage')">
            <b-form class="mx-5" v-on:submit.prevent="changeW">
              <b-row align-h="center">
                <b-col md="10 mb-30">
                  <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">{{
                      $t("username")
                    }}</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        class="form-control"
                        id="username"
                        v-model="username"
                        required
                      />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="amount" class="col-sm-2 col-form-label">{{
                      $t("founds")
                    }}</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        class="form-control"
                        id="amount"
                        v-model="amount"
                        required
                      />
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
      <Dialog ref="msg"></Dialog>
    </div>
  </template>
  
  <script>
  import { depositManage } from "../../../system/api/api";
  import { handleError } from "../../../system/handleRes";
  import Dialog from "../../../components/dialog.vue";
  import { mapGetters } from "vuex";
  export default {
    computed: {
      ...mapGetters(["lang"]),
    },
    components: {
      Dialog,
    },
    data() {
      return {
        canEdit: false,
        tabIndex: 0,
        isLoading: false,
        canClear: false,
        message: "",
        username: "",
        amount: "",
      };
    },
    props: ["success"],
    methods: {
      changeW() {
        let formData = new FormData();
        formData.append("username", this.username);
        formData.append("amount", this.amount);
  
        var result = depositManage(formData);
        var self = this;
        result
          .then(function (value) {
            if (value.data.error_code == 0) {
              self.$refs.msg.makeToast("success", self.$t("successSubmit"));
              self.clearData();
            } else {
              self.$refs.msg.makeToast("danger", value.data.message);
            }
            self.tabIndex = 0;
            self.canEdit = false;
            self.loadItems();
          })
          .catch(function (error) {
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          });
      },
      clearData() {
        this.canEdit = false;
        var self = this;
        self.username = "";
        self.amount = "";
      },
    },
    created() {
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