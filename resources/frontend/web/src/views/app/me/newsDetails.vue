<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
      <span>{{ $t("news") }}</span>
    </div>
    <div class="mainpage m-1 px-2" style="
        min-height: 90vh;
        padding-bottom: 15vh !important;
        position: relative;
      ">
      <b-row class="mx-0">
        <b-col cols="12" class="px-2">
          <div class="imgbox mb-3" style="">
            <img class="mx-auto d-block" :src="item.public_path" alt="" height="100px">
          </div>
        </b-col>
        <b-col cols="12">
          <h5 class="text-black" style="text-align:right!important">{{ item.created_at }}</h5>
        </b-col>
        <b-col cols="12">
          <h2 class="text-black" style="margin-bottom:10px;">{{ item.title }}</h2>
        </b-col>
        <b-col cols="12">
          <h4 class="text-black" style="margin-bottom:10px;">{{ item.description }}</h4>
        </b-col>
      </b-row>
      <!-- <div>
        <b-col cols="12">
            <img :src="public_path" height="150">
        </b-col>
        <h4>
          {{ title }}
        </h4>
        <p class="text-12">
          {{ dataList.created_at }}
        </p>
        <p class="text-14" style="word-wrap: break-word">
          {{ dataList.body }}
        </p>

        <b-form-group
          :label="$t('reply')"
          class="form-customize mt-3"
          :description="dataList.re_time"
        >
          <b-input-group>
            <b-form-textarea
              class="form-control form-custom text-14"
              v-model="dataList.rebody"
              readonly
              rows="6"
            >
            </b-form-textarea>
          </b-input-group>
        </b-form-group>
      </div> -->
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
export default {
  props: ["item",],
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
  },
  data() {
    return {
      public_image: this.public_path,
      isLoading: true,
      point1: [],
      dataList: null,
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
  methods: {
    clipboardSuccessHandler({ value }) {
      this.$bvToast.toast(value, {
        title: this.$t("copied"),
        variant: "success",
        solid: true,
      });
    },

    clipboardErrorHandler() {
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
      console.log(this.item);

    },
  },
  created() {
    this.loadItems();
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