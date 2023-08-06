<template>
  <div class="main-content">
    <div class="appBar">
        <a @click="$router.go(-1)">
          <i class="fa fa-chevron-left"></i>
        </a>
      <span>{{ $t("contact_service") }}</span>
    </div>
    <div class="m-1 px-3">
      <b-form @submit.prevent="submitTicket">
        <b-form-group :label="$t('title')" class="form-customize mt-3 ">
          <b-input-group>
            <b-form-input
              class="form-control form-custom"
              v-model="title"
              type="text"
              required
            >
            </b-form-input>
          </b-input-group>
        </b-form-group>

        <b-form-group :label="$t('description')" class="form-customize mt-3">
          <b-input-group>
            <b-form-textarea
              class="form-control form-custom"
              v-model="body"
              required
              rows="6"
            >
            </b-form-textarea>
          </b-input-group>
        </b-form-group>

        <b-button
          class="mx-auto submit_button mt-5"
          variant="outline-secondary"
          type="submit"
          :disabled="isLoading"
          >{{ isLoading ? $t("submitting") : $t("submit") }}</b-button
        >
      </b-form>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { createTicket } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
export default {
  components: {
    Dialog,
  },
  data() {
    return {
      title: "",
      body: "",
      isLoading: false,
    };
  },

  methods: {
    submitTicket() {
      let formData = new FormData();
      formData.append("title", this.title);
      formData.append("body", this.body);

      var result = createTicket(formData);
      var self = this;
      self.isLoading = true;

      result
        .then(function (value) {
          if (value.data.error_code == 0) {
            self.$refs.msg.makeToast("success", self.$t(value.data.message));
            self.title = "";
            self.body = "";
          } else {
            self.$refs.msg.makeToast("danger", self.$t(value.data.message));
          }
          self.isLoading = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          self.isLoading = false;
        });
    },
  },
};
</script>

<style>
</style>