import { login } from "../../system/api/api";
import { checkRes } from "../../system/handleRes";

export default {
  state: {
    loggedInUser:
      localStorage.getItem("boostToken") != null
        ? localStorage.getItem("boostToken")
        : null,
    loading: false,
    error: null,
    lang: 'zh',
    unread: 0,
  },
  getters: {
    loggedInUser: state => state.loggedInUser,
    loading: state => state.loading,
    error: state => state.error,
    lang: state => state.lang,
    unread: state => state.unread
  },
  mutations: {
    setLang(state, data){
      state.lang = data;

    },
    setUnread(state, data){
      state.unread = data;

    },
    setUser(state, data) {
      state.loggedInUser = data;
      state.loading = false;
      state.error = null;
    },
    setLogout(state) {
      state.loggedInUser = null;
      state.loading = false;
      state.error = null;
      // this.$router.go("/");
    },
    setLoading(state, data) {
      state.loading = data;
      state.error = null;
    },
    setError(state, data) {
      state.error = data;
      state.loggedInUser = null;
      state.loading = false;
    },
    clearError(state) {
      state.error = null;
    }
  },
  actions: {
    login({ commit }, data) {
      commit("clearError");
      commit("setLoading", true);

      var result = login(data);
      // var self = this;
      result.then(function (value) {
        if (checkRes(value.data)&&value.data.data.user.role_info.name == 'user') {
          const newToken = value.data.data.token;
          localStorage.setItem("boostToken", newToken);
          localStorage.setItem("web_username", value.data.data.user.username);
          localStorage.setItem("path", value.data.data.user.role_info.pages);
          commit("setUser", newToken);

        } else {
          localStorage.removeItem("boostToken");
          commit("setError", value.data.message);

        }
      }).catch(function (error) {
        console.log(error);
        localStorage.removeItem("boostToken");
        commit("setError", error);

      });
    },

    changeLan({ commit }, data){
      commit("setLang", data);

    },

    changeUnread({ commit }, data){
      console.log(data)
      commit("setUnread", data);

    },


    
    signOut({ commit }) {      
      localStorage.removeItem("boostToken");
      commit("setLogout");
    }
  }
};
