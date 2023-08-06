<template>
  <div class="main-content">
    <div
      class="mainpage m-1 px-2"
      style="
        position: relative;
        margin-top:20px!important;
      "
    >
      <div
        style="
          position: absolute;
          padding-bottom:100px;
        "
      >
        <h4>{{$t('tnc')}}</h4>
        <h5 style="color:black;font-weight:bold">{{$t('tnc_title')}}</h5>
        <p>{{$t('privacy_notice')}}</p>
        <p>{{$t('tnc_des1')}}</p>
        <p>{{$t('tnc_des2')}}</p>
        <p>{{$t('tnc_des3')}}</p>
        <p>{{$t('tnc_des4')}}</p>
        <p>{{$t('tnc_des5')}}</p>
        <p>{{$t('tnc_des6')}}</p>
        <p>{{$t('tnc_des7')}}</p>

        <p style="color:black;font-weight:bold">{{$t('tnc_title2')}}</p>
        <p>{{$t('personal_data_protection_policy')}}</p>
        <p>{{$t('tnc_des8')}}</p>
        <p>{{$t('personal_data')}}</p>
        <p>{{$t('tnc_des9')}}</p>
        <p>{{$t('collection_of_personal_data')}}</p>
        <p>{{$t('tnc_des10')}}</p>
        <li>{{$t('tnc_des11')}}</li>
        <li>{{$t('tnc_des12')}}</li>
        <li>{{$t('tnc_des13')}}</li>
        <li>{{$t('tnc_des14')}}</li>
        <li>{{$t('tnc_des15')}}</li>
        <li>{{$t('tnc_des16')}}</li>
        <li>{{$t('tnc_des17')}}</li>

        <p>{{$t('tnc_des18')}}</p>
        <li>{{$t('tnc_des19')}}</li>
        <li>{{$t('tnc_des20')}}</li>
        <li>{{$t('tnc_des21')}}</li>
        <li>{{$t('tnc_des22')}}</li>
        <li>{{$t('tnc_des23')}}</li>
        <li>{{$t('tnc_des24')}}</li>
        <li>{{$t('tnc_des25')}}</li>
        <p>{{$t('tnc_des26')}}</p>
        <p>{{$t('tnc_des27')}}</p>
        <p>{{$t('tnc_des28')}}</p>
      </div>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
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
    };
  },
  props: ["success"],
  methods: {
    loadItems() {
     
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
#fileName span + span {
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