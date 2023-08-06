<template>
    <div class="main-content" style="margin-bottom: 10vh;">
      <div class="appBar">
        <a @click="$router.go(-1)">
          <img src="../../../assets/images/digital/right.svg" alt="">
        </a>
        <span>{{ $t("legal") }}</span>
      </div>
      <div v-html="$t('LEGAL1')"></div>
      <div class="mt-3" v-html="$t('LEGAL2')"></div>
      <div class="mt-3" v-html="$t('LEGAL3')"></div>
      <div class="mt-3" v-html="$t('LEGAL4')"></div>
      <Dialog ref="msg"></Dialog>
    </div>
  </template>
  
  <script>
  import { getTicket } from "../../../system/api/api";
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
        isLoading: true,
        point1: [],
        dataList: [],
        canClear: false,
        wallet: "point1",
        wallet2: "point2",
        totalRecords: 0,
        pageNumber: 1,
        message: "",
        stock: "",
        money: "",
        status: true,
        balance: "",
        currentPage: 1,
        lastPage: 1,
      };
    },
    props: ["success"],
    methods: {
      clipboardSuccessHandler({ value }) {
        this.$bvToast.toast(value, {
          title: this.$t("copied"),
          variant: "success",
          solid: true,
        });
      },
  
      clipboardErrorHandler() {
        //// console.log('error', value)
      },
      onPageChange(params) {
        this.pageNumber = params.currentPage;
        this.loadItems(this.wallet);
        var container = this.$el.querySelector("#table");
        var top = container.offsetTop;
  
        window.scrollTo(0, top);
      },
      onSearch() {
        this.pageNumber = 1;
        this.loadItems(this.wallet);
      },
      onCancel() {
        this.canClear = false;
        this.loadItems(this.wallet);
      },
      loadItems() {
        var result = getTicket(this.currentPage);
        var self = this;
        this.isLoading = true;
        result
          .then(function (value) {
            var dataList = value.data.data.ticket;
            self.currentPage += 1;
            self.lastPage = value.data.data.last_page;
            for (let i = 0; i < dataList.length; i++) {
              console.log(dataList[i]);
              self.dataList.push(dataList[i]);
            }
            self.isLoading = false;
          })
          .catch(function (error) {
            console.log(error);
            self.isLoading = false;
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          });
      },
    },
    created() {
    },
  };
  </script>
  
  <style>
  #fileName span {
    white-space: nowrap;
    overflow: hidden;
    display: inline-block;
  }
  
  #fileName span:first-child {
    width: 60px;
    text-overflow: ellipsis;
  }
  
  #fileName span+span {
    width: 34px;
    direction: rtl;
    text-align: right;
    /* text-overflow: ellipsis; */
  }
  
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
  
  .addressWidth {
    max-width: 200px;
  }
  
  .txidWidth {
    max-width: 275px;
  }
  </style>