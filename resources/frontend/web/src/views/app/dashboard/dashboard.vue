<template>
  <div class="main-content homepage2 flex-grow-1 d-flex flex-column pb-5" style="height:100vh">
    <!-- <div class="firstPart">
      <div class="banner"></div>
    </div> -->
    <div class="secondPart flex-grow-1 d-flex flex-column">
      <b-card class="mb-3">
        <div class="d-flex mb-5">
          <div class="avatar-circle"
            :style="{ backgroundImage: 'url(' + `/images/level1/${currentPackage.toLowerCase()}.png` + ')' }"></div>
          <h4 class="font-weight-bold ml-3">{{ username }}</h4>

        </div>
        <div class="d-flex justify-content-between align-items-end">
          <div class="ml-3">
            <img @click="$router.push('/web/deposit')" src="../../../assets/images/digital/plus (1).svg" alt="">

          </div>
          <div>
            <div class="d-flex align-items-end"><span class="text-12 mr-2 text-white">USDT</span>
              <div>
                <label class="mb-1">{{ $t('assets') }}</label>
                <h3 class="mb-0 font-weight-bold">{{ info.point1 }}</h3>
              </div>
            </div>
          </div>
        </div>

      </b-card>
      <b-row class="">
        <b-col cols="4" class="">
          <b-link to="/web/deposit" class="btn">
            <span class="mb-5 text-white">{{ $t('deposit') }}</span>
            <div class="d-flex justify-content-between align-items-center w-100 mt-3">
              <i class="fa fa-arrow-right"></i>
              <span class="text-24 mb-2"><img src="../../../assets/images/digital/deposit.svg" alt=""></span>
            </div>
          </b-link>
        </b-col>
        <b-col cols="4" class="">
          <b-link to="/web/withdraw" class="btn">
            <span class="mb-5 text-white">{{ $t('withdraw') }}</span>
            <div class="d-flex justify-content-between align-items-center w-100 mt-3">
              <i class="fa fa-arrow-right"></i>
              <span class="text-24 mb-2"><img src="../../../assets/images/digital/Solid.svg" alt=""></span>
            </div>
          </b-link>
        </b-col>
        <b-col cols="4" class="">
          <b-link to="/web/ticket/createTicket" class="btn">
            <span class="mb-5 text-white">{{ $t('contact_service') }}</span>
            <div class="d-flex justify-content-between align-items-center w-100 mt-3">
              <i class="fa fa-arrow-right"></i>
              <span class="text-24 mb-2"><img src="../../../assets/images/digital/Layer 2.svg" alt=""></span>
            </div>
          </b-link>
        </b-col>
      </b-row>
      <Market :isHome="true"></Market>
      <p class="text-center text-16 cursor-pointer" style="height:100px;" @click="$router.push('/web/trade/tradeList')">{{ $t('more') }}
        <span><img src="../../../assets/images/digital/right-arrow (5).svg" alt=""></span></p>
      <!-- <b-row class="mx-0">
        <b-col cols="6" class="">
          <b-button class="btn-tab btn-rounded mt-3" :class="{ 'btn-focus': tabIndex == 0 }" @click="changeIndex(0)">
            <span>{{ $t('latest_news') }}</span>
          </b-button>
        </b-col>
        <b-col cols="6" class="">
          <b-button class="btn-tab btn-rounded mt-3" :class="{ 'btn-focus': tabIndex == 1 }" @click="changeIndex(1)">
            <span>{{ $t('tnc') }}</span>
          </b-button>
        </b-col>
      </b-row> -->
      <!-- <p class="mb-1">{{ ($i18n.locale=="zh")?language:languageEN }}</p> -->
      <!-- <newsList v-if="tabIndex == 0"></newsList>
      <tnc v-if="tabIndex == 1"></tnc> -->

    </div>

    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Dialog from "../../../components/dialog.vue";
import Market from "../trade/modules/tradeMarket.vue"
// import newsList from "../me/newsList.vue";
// import tnc from "../me/tnc.vue";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
    Market
    // newsList,
    // tnc,
  },
  data() {
    return {
      tabIndex: 0,
      language: "",
      username: "",
      currentPackage: "",
      info: null,
      coinList: [

      ]
    };
  },
  props: ["success"],
  methods: {
    onSearch() {
      this.pageNumber = 1;
      if (this.from != "" || this.to != "") {
        this.canClear = true;
      }
      this.loadItems();
    },
    onCancel() {
      this.from = "";
      this.to = "";
      this.canClear = false;
      this.loadItems();
    },
    changeIndex(i) {
      this.tabIndex = i;
    },

    loadItems() {
      this.username = localStorage.getItem('web_username');
      this.info = JSON.parse(localStorage.getItem('info'));
      this.currentPackage = this.info.package.package_name_en;
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