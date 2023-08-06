import firebase from "firebase/app";
import "firebase/auth";
import { login } from "../../system/api/api";
import { checkRes } from "../../system/handleRes";

export default {
  state: {
    loggedInUser:
      localStorage.getItem("userToken") != null
        ? localStorage.getItem("userToken")
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
        if (checkRes(value.data)&&value.data.data.user.role_info.name == 'admin') {
          const newToken = value.data.data.token;
          localStorage.setItem("userToken", newToken);
          localStorage.setItem("username", value.data.data.user.username);
          localStorage.setItem("path", value.data.data.user.role_info.pages);
          commit("setUser", newToken);

        } else {
          localStorage.removeItem("userToken");
          commit("setError", 'You are no permission to login!');

        }
      }).catch(function (error) {
        console.log(error);
        localStorage.removeItem("userToken");
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


    // firebase
    //   .auth()
    //   .signInWithEmailAndPassword(data.email, data.password)
    //   .then(user => {
    //     const newToken = {uid: user.user.uid};
    //     localStorage.setItem("userToken", JSON.stringify(newToken));
    //     commit("setUser", {uid: user.user.uid});
    //     console.log("user");
    //   })
    //   .catch(function(error) {
    //     // Handle Errors here.
    //     // var errorCode = error.code;
    //     // var errorMessage = error.message;
    //     // console.log(error);
    //     localStorage.removeItem("userToken");
    //     commit("setError", error);
    //     // ...
    //   });

    signUserUp({ commit }, data) {
      commit("setLoading", true);
      commit("clearError");
      firebase
        .auth()
        .createUserWithEmailAndPassword(data.email, data.password)
        .then(user => {
          commit("setLoading", false);

          const newToken = {
            uid: user.user.uid
          };
          console.log(newToken);
          localStorage.setItem("userToken", JSON.stringify(newToken));
          commit("setUser", newToken);
        })
        .catch(error => {
          commit("setLoading", false);
          commit("setError", error);
          localStorage.removeItem("userToken");
          console.log(error);
        });
    },
    signOut({ commit }) {
      // firebase
      //   .auth()
      //   .signOut()
      //   .then(
      //     () => {
      //       localStorage.removeItem("userToken");
      //       commit("setLogout");
      //     },
      //     // _error => { }
      //   );
      
      localStorage.removeItem("userToken");
      commit("setLogout");
    }
  }
};
