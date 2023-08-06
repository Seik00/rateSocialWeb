<template>
  <div class="app-admin-wrap layout-sidebar-vertical clearfix sidebar-full">
    <verticalSidebar v-bind:unread='count'/>
    <main>
      <div
        class="main-content-wrap mt-0 bg-off-white"
        :class="{
          'vertical-sidebar': getVerticalSidebar.isVerticalSidebar,
          compact: getVerticalSidebar.isVerticalCompact
        }"
      >
        <verticalTopbar/>
        <transition name="page" mode="out-in">
          <router-view />
        </transition>
        <!-- <appFooter /> -->
      </div>
    </main>
  </div>
</template>
<script>
import verticalSidebar from "./verticalSidebar";
import verticalTopbar from "./verticalTopbar";
import { countRead } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
// import appFooter from "../common/footer";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    verticalSidebar,
    verticalTopbar,
    // appFooter
  },
  computed: {
    ...mapGetters(["getVerticalSidebar"])
  },
  data() {
    return {
      count: 0
    };
  },
  methods: {
    ...mapActions([
      "changeUnread",
    ]),

    loadItems() {
      var result = countRead();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.count = value.data.data.record;
          self.changeUnread(self.count);
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },

  created() {
    this.loadItems();
  },
};
</script>
