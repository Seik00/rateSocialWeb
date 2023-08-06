<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="goBack">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
      <span>{{ $t("set_sec_password") }}</span>
    </div>
    <b-form @submit.prevent="submitForm">
      <div class="mainpage">
        <b-form-group class="form-customize"
          id="input-group-2"
          :label="$t('new_password')"
          label-for="input-2"
        >
          <b-form-input class="form-control form-custom"
            id="input-2"
            v-model="password"
            type="password"
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group class="form-customize"
          id="input-group-2"
          :label="$t('confirm_new_password')"
          label-for="input-2"
        >
          <b-form-input class="form-control form-custom"
            id="input-2"
            v-model="password_confirmation"
            type="password"
            required
          ></b-form-input>
        </b-form-group>

        <b-button
          class="mx-auto submit_button"
          style="margin-top: 20vh"
          variant="outline-secondary"
          type="submit"
          >{{ isLoading ? $t("loading...") : $t("submit") }}</b-button
        >
      </div>
    </b-form>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  setSecPassword,
} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
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
        password: "",
        password_confirmation: "",
        myVar: null,
        sending: false,
        isLoading: false,
    };
  },
  props: ["success"],
  methods: {
    ...mapActions([
      "signOut",
    ]),
    goBack(){
    this.signOut();

      this.$router.push("/web/sessions/signIn");
    },
    submitForm() {
      let formData = new FormData();
      var self = this;
      formData.append("password", this.password);
      formData.append("password_confirmation", this.password_confirmation);
      var result = setSecPassword(formData);
      self.isLoading = true;

      result
        .then(function (value) {
          console.log(value.data);
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.password='';
            self.password_confirmation='';
            setTimeout(() => {
                var current = location.origin+'/';
                window.location.href = current+"web";
              }, 2000);
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.sending = false;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.sending = false;
          self.isLoading = false;
        });
    },
    loadItems() {},
  },
  created() {
    this.loadItems();
    this.username = localStorage.getItem("username");
  },
};
</script>