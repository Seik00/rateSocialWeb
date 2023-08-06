require('./bootstrap');
var cors = require('cors')

import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import GullKit from "./plugins/gull.kit";
import store from "./store";
import firebase from "firebase/app";
import "firebase/auth";
import {firebaseSettings} from "./data/config";
import i18n from "./lang/lang";
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'
import "font-awesome/css/font-awesome.min.css";
 
Vue.component('VueFontawesome', () => import("vue-fontawesome-icon/VueFontawesome.vue").default);

Vue.component("breadcumb", () => import("./components/breadcumb"));
import InstantSearch from 'vue-instantsearch';
 


Vue.use(InstantSearch);
Vue.use(GullKit);
Vue.use(cors)

firebase.initializeApp(firebaseSettings);


const app = new Vue({
    el: '#app', 
    router,
    store,
    i18n,
    components:{App}
});
