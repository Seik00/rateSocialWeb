// import "babel-polyfill";
import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import GullKit from "./plugins/gull.kit";
import store from "./store";
import Breadcumb from "./components/breadcumb";
import i18n from "./lang/lang";
import "font-awesome/css/font-awesome.min.css";
import Clipboard from 'v-clipboard'

Vue.use(Clipboard)

Vue.component('VueFontawesome', require('vue-fontawesome-icon/VueFontawesome.vue').default);

Vue.component("breadcumb", Breadcumb);
Vue.use(GullKit);

Vue.config.productionTip = false;

new Vue({
  store,
  router,
  i18n,
  render: h => h(App)
}).$mount("#app");
