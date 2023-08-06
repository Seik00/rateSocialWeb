<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
      <span>{{ $t("settings") }}</span>
    </div>
    <div class="mainpage">
      <b-card class="grey-card" @click="openLanguage()">
        <b-row align-h="between" align-v="center">
          <b-row align-h="start" align-v="center" class="m-0" style="width:100%;padding:0 10px 0 10px">

            <h6 class="text-muted mb-0 mx-1 text-12">
              {{ $t('language') }}
            </h6>
            <i class="fa fa-chevron-right" style="right: 20px;position: absolute;color:white"></i>


          </b-row>
        </b-row>
      </b-card>
      <b-link to="/web/settings/change-password">
        <b-card class="grey-card">
          <b-row align-h="between" align-v="center">
            <b-row align-h="start" align-v="center" class="m-0" style="width:100%;padding:0 10px 0 10px">

              <h6 class="text-muted mb-0 mx-1 text-12">
                {{ $t('change_password') }}
              </h6>
              <i class="fa fa-chevron-right" style="right: 20px;position: absolute;color:white"></i>


            </b-row>
          </b-row>
        </b-card>
      </b-link>

      <b-link to="/web/settings/change-sec-password">
        <b-card class="grey-card">
          <b-row align-h="between" align-v="center">
            <b-row align-h="start" align-v="center" class="m-0" style="width:100%;padding:0 10px 0 10px">

              <h6 class="text-muted mb-0 mx-1 text-12">
                {{ $t('change_secpassword') }}
              </h6>
              <i class="fa fa-chevron-right" style="right: 20px;position: absolute;color:white"></i>


            </b-row>
          </b-row>
        </b-card>
      </b-link>

      <b-link to="/web/settings/forget-sec-password">
        <b-card class="grey-card">
          <b-row align-h="between" align-v="center">
            <b-row align-h="start" align-v="center" class="m-0" style="width:100%;padding:0 10px 0 10px">

              <h6 class="text-muted mb-0 mx-1 text-12">
                {{ $t('forget_secpassword') }}
              </h6>
              <i class="fa fa-chevron-right" style="right: 20px;position: absolute;color:white"></i>


            </b-row>
          </b-row>
        </b-card>
      </b-link>
    </div>
    <b-modal id="modal-language" size="md" centered :title="$t('country')" :hide-footer="true"
      style="background-color: white !important">
      <b-container class="bv-example-row">
        <b-row @click="changeLang('en')">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="GB" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t('en') }}</b-col>
        </b-row>
        <hr class="line" />
        <b-row @click="changeLang('zh')">
          <b-col cols="1"><i class="header-icon-country">
              <flag iso="CN" />
            </i></b-col>
          <b-col cols="7" class="middle">{{ $t('zh') }}</b-col>
        </b-row>
      </b-container>
    </b-modal>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {

} from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { mapGetters, mapActions } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
  },
  data() {
    return {

      isLoading: false,
    };
  },
  props: ["success"],
  methods: {
    ...mapActions(["login", "changeLan"]),
    openLanguage() {
      this.$bvModal.show("modal-language");

    },
    changeLang(lang) {
      console.log(lang);
      this.$i18n.locale = lang;
      this.changeLan(lang);
      this.$bvModal.hide("modal-language");
    },



  },
  created() {
  },
};
</script>

<style>
i.header-icon-country {
  font-size: 20px;
}

.middle.col-7 {
  margin: auto;
}

hr.line {
  margin-top: 5px;
  margin-bottom: 5px
}

button.close {
  display: none;
}
</style>