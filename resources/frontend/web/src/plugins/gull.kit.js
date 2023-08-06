import BootstrapVue from "bootstrap-vue";

import Vuelidate from "vuelidate";
import VueLazyload from "vue-lazyload";
import VueGoodTablePlugin from "vue-good-table";
import Meta from "vue-meta";
import FlagIcon from "vue-flag-icon";

import "../assets/styles/sass/themes/lite-purple.scss";

// locale.use(lang);

export default {
  install(Vue) {
    Vue.use(BootstrapVue);
    Vue.component(
      "large-sidebar",
      // The `import` function returns a Promise.
      () => import("../containers/layouts/largeSidebar")
    );

    Vue.component(
      "compact-sidebar",
      // The `import` function returns a Promise.
      () => import("../containers/layouts/compactSidebar")
    );
    Vue.component(
      "vertical-sidebar",
      // The `import` function returns a Promise.
      () => import("../containers/layouts/verticalSidebar")
    );
    Vue.component(
      "customizer",
      // The `import` function returns a Promise.
      () => import("../components/common/customizer.vue")
    );
    Vue.component("vue-perfect-scrollbar", () =>
      import("vue-perfect-scrollbar")
    );
    // Vue.component(VueCropper);
    Vue.use(Meta, {
      keyName: "metaInfo",
      attribute: "data-vue-meta",
      ssrAttribute: "data-vue-meta-server-rendered",
      tagIDKeyName: "vmid",
      refreshOnceOnNavigation: true
    });
    Vue.use(FlagIcon);
    Vue.use(Vuelidate);

    Vue.use(VueGoodTablePlugin);
    Vue.use(VueLazyload, {
      observer: true,
      // optional
      observerOptions: {
        rootMargin: "0px",
        threshold: 0.1
      }
    });
  }
};
