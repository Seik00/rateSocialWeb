<template>
  <div class="main-content">
    <breadcumb :page="'币种管理'" :folder="'钱包管理'" />
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
      <div slot="table-actions" class="mb-3">
        <b-button variant="primary" class="btn-rounded"> Add Button </b-button>
      </div>

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
    </vue-good-table>
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
          label: 'coinName',
          text: 'coinName',
          field: "coinName",
          thClass: "gull-th-class",
          value: 'coinName',
          sortable: false,
        },
        {
          label: 'coinSymbol',
          text: 'coinSymbol',
          field: "coinSymbol",
          thClass: "gull-th-class",
          value: 'coinSymbol',
          sortable: false,
        },
        {
          label: 'coinImage',
          text: 'coinImage',
          field: "coinImage",
          thClass: "gull-th-class",
          value: 'coinImage',
          sortable: false,
          html:true
        },
        {
          label: 'usd',
          text: 'usd',
          field: "usd",
          // width: "190px",
          thClass: "gull-th-class",
          value: 'usd',
          sortable: false,
        },
        {
          label: 'parentCoin',
          text: 'parentCoin',
          field: "parentCoin",
          thClass: "gull-th-class",
          value: 'parentCoin',
          sortable: false,
        },
        {
          label: 'maxFee',
          text: 'maxFee',
          field: "maxFee",
          thClass: "gull-th-class",
          value: 'maxFee',
          sortable: false,
        },
        {
          label: 'minFee',
          text: 'minFee',
          field: "minFee",
          thClass: "gull-th-class",
          value: 'minFee',
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
          id: 27,
          coinName: 'TRON/波场',
          coinSymbol: "TRX",
          coinImage: '<img width="50" height="50" src="http://trader.greatwallsolution.com/upload/icon/TRX.png">',
          usd: '1',
          parentCoin: '',
          maxFee: '0.000400',
          minFee: '0.001000',
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
      // localStorage.removeItem("boostToken");
    // });
  },
};
</script>