<template>
  <div class="main-content">
    <breadcumb :page="'钱包列表'" :folder="'钱包管理'" />
    <!-- <div class="wrapper"> -->
    <vue-good-table
      :columns="columns"
      :search-options="{
        enabled: true,
        placeholder: 'Search this table',
      }"
      :pagination-options="{
        enabled: true,
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

      <template slot="table-row" slot-scope="props">
        <span v-if="props.column.field == 'action'">
          <a href="">
            <i class="i-Eraser-2 text-25 text-success mr-2"></i>
            {{ props.row.button }}</a
          >
          <a href="">
            <i class="i-Close-Window text-25 text-danger"></i>
            {{ props.row.button }}</a
          >
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
  </div>
</template>

<script>
import { getMarketAll } from "../../../system/api/api";
export default {
  computed:{
    columns(){
      return[
        {
          label: 'id',
          text: 'id',
          field: "id",
          thClass: "gull-th-class",
          value: 'id',
          sortable: false,
        },
        {
          label: 'userID',
          text: 'userID',
          field: "userID",
          thClass: "gull-th-class",
          value: 'userID',
          sortable: false,
        },
        {
          label: 'username',
          text: 'username',
          field: "username",
          thClass: "gull-th-class",
          value: 'username',
          sortable: false,
        },
        {
          label: 'coin',
          text: 'coin',
          field: "coin",
          thClass: "gull-th-class",
          value: 'coin',
          sortable: false,
        },
        {
          label: 'genre',
          text: 'genre',
          field: "genre",
          // width: "190px",
          thClass: "gull-th-class",
          value: 'genre',
          sortable: false,
        },
        {
          label: 'cloudBalance',
          text: 'cloudBalance',
          field: "cloudBalance",
          thClass: "gull-th-class",
          value: 'cloudBalance',
          sortable: false,
        },
        {
          label: 'address',
          text: 'address',
          field: "address",
          thClass: "gull-th-class",
          value: 'address',
          sortable: false,
        },
        {
          label: 'memo',
          text: 'memo',
          field: "memo",
          thClass: "gull-th-class",
          value: 'memo',
          sortable: false,
        },
        {
          label: 'seed',
          text: 'seed',
          field: "seed",
          thClass: "gull-th-class",
          value: 'seed',
          sortable: false,
        },
        {
          label: 'createdOn',
          text: 'createdOn',
          field: "createdOn",
          thClass: "gull-th-class",
          value: 'createdOn',
          sortable: false,
        },
        {
          label: "action",
          field: "action",
          tdClass: "linkWidth",
          sortable: false,
        }, 
      ]
    }
  },
  data() {
    return {
      rows: [
        {
          id: 29,
          userID: '8000236',
          username: "",
          coin: 'USDT',
          genre: '云端钱包',
          cloudBalance: '0.000000000000000000',
          address: '',
          memo: '',
          seed: '',
          createdOn: '2021-06-06 18:23',
        },
      ],
    };
  },
  methods: {
    addFile() {
      console.log("hello");
    },
  },
  created() {
    console.log(localStorage.getItem("boostToken"));
    let formData = new FormData();
    var result = getMarketAll(formData);
    // var self = this;
    result.then(function (value) {
      console.log(value.data);
    })
    // .catch(function (error) {
    //   localStorage.removeItem("boostToken");
    // });
  },
};
</script>