<template>
  <div class="main-content homepage2 flex-grow-1 d-flex flex-column">
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
      <div class="d-flex justify-content-between">
        <h5 class="font-weight-medium">{{ $t('earnings') }}</h5>
        <span class="text-14 text-black font-weight-bold">{{ currentPackage }} <img height="14px"
            src="../../../assets/images/digital/currency.svg" alt=""></span>
      </div>
      <b-row class="mx-0 mb-4">
        <b-col cols="6" class="pl-0 pr-3">
          <b-card class="card-primary">
            <div class="d-flex">
              <div class="mr-2 h-100 flex-grow-1" style="aspect-ratio: 1;"></div>
              <div>
                <span class="text-10 text-white">Today App Rated</span>
                <h5 class="text-white mb-0"><span class="font-weight-bold">10</span> <span class="text-10">/35</span></h5>
              </div>

            </div>

          </b-card></b-col>
        <b-col cols="6" class="pr-0 pl-3">
          <b-card>
            <div class="d-flex">
              <div class="mr-1 h-100 flex-grow-1" style="aspect-ratio: 1;"></div>
              <div>
                <span class="text-10 text-green">Today App Rated</span>
                <h5 class="text-green mb-0"><span class="font-weight-bold">10</span> </h5>
              </div>

            </div>

          </b-card></b-col>
      </b-row>
      <h5 class="font-weight-medium">{{ $t('features') }}</h5>
      <b-row class="">
        <b-col cols="4" class="">
          <b-link to="/web/deposit" class="btn">
            <div class="d-flex flex-column justify-content-center align-items-center w-100 my-3">
              <span class="text-24 mb-2"><img src="../../../assets/images/digital/deposit.png" alt=""></span>
              <span class="text-center text-primary">{{ $t('deposit') }}</span>
            </div>
          </b-link>
        </b-col>
        <b-col cols="4" class="">
          <b-link to="/web/withdraw" class="btn">
            <div class="d-flex flex-column justify-content-between align-items-center w-100 my-3">
              <span class="text-24 mb-2"><img src="../../../assets/images/digital/withdraw.png" alt=""></span>

              <span class="text-center text-primary">{{ $t('withdraw') }}</span>
            </div>
          </b-link>
        </b-col>
        <b-col cols="4" class="">
          <b-link to="/web/ticket/createTicket" class="btn">
            <div class="d-flex flex-column justify-content-between align-items-center w-100 my-3">

              <span class="text-24 mb-2"><img src="../../../assets/images/digital/event.png" alt=""></span>
              <span class="text-center text-primary">{{ $t('contact_service') }}</span>
            </div>
          </b-link>
        </b-col>
      </b-row>
      <b-row class="mt-3">
        <b-col cols="4" class="">
          <b-link to="/web/myWallet/walletRecord" class="btn">
            <div class="d-flex flex-column justify-content-between align-items-center w-100 my-3">

              <span class="text-24 mb-2"><img src="../../../assets/images/digital/transaction.png" alt=""></span>
              <span class="text-center text-primary">{{ $t('transaction') }}</span>
            </div>
          </b-link>
        </b-col>
        <b-col cols="4" class="">
          <b-link to="/web/referral/bonus" class="btn">
            <div class="d-flex flex-column justify-content-between align-items-center w-100 my-3">

              <span class="text-24 mb-2"><img src="../../../assets/images/digital/referral.png" alt=""></span>
              <span class="text-center text-primary">{{ $t('referral') }}</span>
            </div>
          </b-link>
        </b-col>
        <b-col cols="4" class="">
          <b-link to="/web/ticket/createTicket" class="btn">
            <div class="d-flex flex-column justify-content-between align-items-center w-100 my-3">

              <span class="text-24 mb-2"><img src="../../../assets/images/digital/vip.png" alt=""></span>
              <span class="text-center text-primary">{{ $t('vip_level') }}</span>
            </div>
          </b-link>
        </b-col>
      </b-row>

    </div>

    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Dialog from "../../../components/dialog.vue";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
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