<template>
  <div
    class="auth-layout-wrap"
    :style="{ backgroundImage: 'url(' + bgImage + ')' }"
  >
    <div class="auth-content">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div
            class="card o-hidden"
            style="background-color: #001347 !important"
          >
            <div class="p-4">
              <div class="auth-logo text-center mb-30">
                <img
                  :src="logo"
                  alt=""
                  style="
                    height: auto !important;
                  "
                />
              </div>
              <h1
                class="mb-3 text-20 text-center text-white"
                style="font-weight: bold"
              >
                Download App
              </h1>
              <div class="row justify-content-center">
                <div class="col-md-4 col-6 p-0">
                  <a
                    block
                    type="button"
                    variant="outline-secondary"
                    style="background-color: #02daaf !important"
                    class="btn btn-icon m-1"
                    href="https://atozbot.live/Atozbot.apk"
                  >
                    <span class="ul-btn__icon"
                      ><i class="i-Android text-20"></i
                    ></span>
                    <span class="ul-btn__text ml-1">Android</span>
                  </a>
                </div>
                <!-- <div class="col-md-4 col-6 p-0">
                  <a
                    block
                    type="button"
                    variant="outline-secondary"
                    style="background-color: #02daaf !important"
                    class="btn btn-icon m-1"
                    :href="iosLink"
                  >
                    <span class="ul-btn__icon"
                      ><i class="i-iOS-Apple text-20"></i
                    ></span>
                    <span class="ul-btn__text ml-1">Apple IOS</span>
                  </a>
                </div> -->
              </div>
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
    title: "Asia Pacific",
  },
  data() {
    return {
      iosLink: "",
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
        .catch(function () {
          
        });
    },
  },

  created() {
    this.loadItems();
  },
};
</script>
