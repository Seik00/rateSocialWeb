<template>
  <div
    class="auth-layout-wrap"
    :style="{ backgroundImage: 'url(' + bgImage + ')' }"
  >
    <div class="auth-content">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div
            class="card o-hidden"
            style="background-color: #001347 !important;width:100%"
          >
            <div class="p-4">
              <div class="auth-logo text-center mb-30">
                <img :src="logo" alt="" style="height: 240px !important;width:240px;" />
              </div>
              <h1
                class="mb-3 text-20 text-center text-white"
                style="font-weight: bold"
              >
                GreatWall Login
              </h1>
              <b-row class="justify-content-center">
                
               
                <b-col cols="12" md="6" class="px-2">
                  <a
                    block
                    type="button"
                    variant="outline-secondary"
                    style="background-color: #02daaf !important; width:100%"
                    class="btn btn-icon m-1"
                    :href="currentURL"
                  >
                    <span class="ul-btn__icon"
                      ><i class="i-Windows-Microsoft text-20"></i
                    ></span>
                    <span class="ul-btn__text ml-1">Login</span>
                  </a>
                </b-col>
              </b-row>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { getDownloadLink } from "../../../system/api/api";
export default {
  metaInfo: {
    // if no subcomponents specify a metaInfo.title, this title will be used
    title: "GreatWall",
  },
  data() {
    return {
      iosLink: "",
      currentURL: "",
      bgImage: require("../../../assets/images/bg.jpg"),
      logo: require("../../../assets/logo.png"),
      formImage: require("../../../assets/images/photo-long-3.jpg"),
    };
  },

  methods: {
    loadItems() {
      var result = getDownloadLink(this.pageNumber);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.iosLink = value.data.data.system.IOS_DOWNLOAD_LINK;
          console.log(self.iosLink);
        })
        .catch(function () {});
    },
  },

  created() {
    this.currentURL = location.origin+'/web';
    this.loadItems();
  },
};
</script>
