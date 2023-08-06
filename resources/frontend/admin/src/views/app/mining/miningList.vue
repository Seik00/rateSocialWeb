<template>
    <div class="main-content">
      <breadcumb :page="$t('mining')" :folder="$t('mining')" />
  
      <b-tabs pills align="end">
        <b-tab :title="$t('mining')" active>
          <b-card :title="$t('mining')">
            <!-- <b-row>
              <b-col md="12">
                <b-card class="mb-30">
                  <b-row align-v="center">
                    <b-col md="2" class="mt-3 mt-md-0">
                      <b-form-group
                        id="input-group-2"
                        :label="$t('contact_number')"
                        label-for="input-2"
                      >
                        <b-form-input
                          id="input-2"
                          type="text"
                          required
                          :placeholder="$t('Enter') + $t('contact_number')"
                          v-model="searchPhone"
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
            <vue-good-table
              id="table"
              mode="remote"
              :isLoading="isLoading"
              :columns="columns"
              :search-options="{
                enabled: false,
                placeholder: 'Search this table',
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
                
                <span v-if="props.column.field == 'created_at'">
                  {{ processDate(props.row.created_at) }}
                </span>
              </template>
            </vue-good-table>
  
            <div class="align-items-center mobile-adjust">
             
              <div
                class="d-flex flex-wrap align-items-center justify-content-end"
              >
               
  
       
              </div>
            </div>
          </b-card>
        </b-tab>
      </b-tabs>
      <Dialog ref="msg"></Dialog>
    </div>
  </template>
  
  <script>
  import {
    getMiningList,
  } from "../../../system/api/api";
  import Dialog from "../../../components/dialog.vue";
  import { handleError } from "../../../system/handleRes";
  import { mapGetters } from "vuex";
  export default {
    computed: {
      ...mapGetters(["lang"]),
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
            label: this.$t("username"),
            text: "username",
            field: "username",
            thClass: "gull-th-class",
            value: "username",
            sortable: false,
          },
          {
            label: this.$t("times_of_mining"),
            text: "times",
            field: "times",
            thClass: "gull-th-class",
            value: "times",
            tdClass: "dateWidth",
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
        username: "",
        isLoading: false,
        rows: [],
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
      makeToast(variant = null, msg) {
        this.$bvToast.toast(msg, {
          // title: ` ${variant || "default"}`,
          variant: variant,
          solid: true,
        });
      },
      loadItems() {
        var result = getMiningList();
        var self = this;
        this.isLoading = true;
        result
          .then(function (value) {
            var dataList = value.data.data.user;
            self.rows = dataList;
            self.isLoading = false;
  
          })
          .catch(function (error) {
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          });
      },
    },
    watch: {
      
    },
    created() {
      this.loadItems();
    },
  };
  </script>
  
  <style>
  .hiddenClass {
    pointer-events: none;
    display: none;
  }
  
  .bodyWidth {
    min-width: 140px;
  }
  
  .dateWidth {
    min-width: 100px;
  }
  </style>