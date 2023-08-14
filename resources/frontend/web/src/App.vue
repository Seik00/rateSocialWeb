<template>
  <div class="web-setup">
    <router-view></router-view>

    <!-- <customizer></customizer> -->
  </div>
</template>


<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {};
  },
  computed: {
    ...mapGetters(["getThemeMode"]),
    themeName() {
      return this.getThemeMode.dark ? "dark-theme" : " ";
    },
    rtl() {
      return this.getThemeMode.rtl ? "rtl" : " ";
    }
  },
  metaInfo() {
    return {
      // if no subcomponents specify a metaInfo.title, this title will be used
      title: "Asia Pacific",
      // all titles will be injected into this template
      titleTemplate: "%s",
      bodyAttrs: {
        class: [this.themeName, "text-left"]
      },
      htmlAttrs: {
        dir: this.rtl
      },
      meta: [
        { charset: "utf-8" },
        { name: "description", content: "WHY Asia Pacific ? Asia Pacific is developed with Artificial Intelligence Martingale calculation formula to replace human's Hedging Trading Strategy, using Crypto market cap's, market volume and historical data." },
        { name: "viewport", content: "width=device-width, initial-scale=1" },
      ],
    };
  }
};
</script>

<style>
.web-setup{
  max-width: 420px;
  margin: auto;
}
</style>


