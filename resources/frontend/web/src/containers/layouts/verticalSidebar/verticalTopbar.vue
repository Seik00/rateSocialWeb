<template>
  <div class="mb-30">
    <header
      class="
        main-header
        vertical-header
        bg-white
        d-flex
        justify-content-between
      "
    >
      <div class="menu-toggle vertical-toggle" @click="mobileSidebar">
        <div></div>
        <div></div>
        <div></div>
      </div>
      <div class="header-toggle"></div>
      <div style="margin: auto"></div>

      <div class="header-part-right">
        <!-- Full screen toggle -->
        <!-- <i
          class="i-Full-Screen header-icon d-none d-sm-inline-block"
          @click="handleFullScreen"
        ></i> -->
        <!-- <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i> -->
        <!-- Grid menu Dropdown -->
        <!-- Notificaiton -->
        <!-- Notificaiton End -->
        <!-- <i class="i-Bell text-muted header-icon"></i> -->
        <router-link
          v-if="unread > 0"
          tag="a"
          to="/web/manage/ticket/ticketList"
          class="mr-3"
          href="#"
        >
          <span class="text-danger font-weight-bold"
            >{{ unread + $t('unreadNotice')}} </span
          >
        </router-link>

        <b-dropdown
          id="dropdown-1"
          toggle-class="text-decoration-none"
          variant="link"
          no-caret
        >
          <template slot="button-content">
            <div
              class="btn dropdown-toggle nav-item"
              style="padding-right: 25px !important"
            >
              <span>{{ $t("language") }}</span>
            </div>
          </template>

          <b-dropdown-item
            class="dropdown-menu-right"
            @click="changeLang('en')"
          >
            <i class="header-icon"><flag iso="US" /></i>

            English
          </b-dropdown-item>

          <b-dropdown-item
            class="dropdown-menu-right"
            @click="changeLang('zh')"
          >
            <i class="header-icon"><flag iso="CN" /></i>

            中文
          </b-dropdown-item>
        </b-dropdown>

        <!-- User avatar dropdown -->

        <div class="dropdown">
          <b-dropdown
            id="dropdown-1"
            right
            text="Right align"
            class="m-md-2 user col align-self-end"
            toggle-class="text-decoration-none"
            no-caret
            variant="link"
          >
            <template slot="button-content">
              <img
                src="../../../assets/images/faces/user.png"
                id="userDropdown"
                alt
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              />
            </template>

            <div class="dropdown-menu-right" aria-labelledby="userDropdown">
              <div class="dropdown-header">
                <i class="i-Lock-User mr-1"></i> {{ username }}
              </div>
              <a class="dropdown-item" href="#" @click.prevent="logoutUser">{{
                $t("sign_out")
              }}</a>
            </div>
          </b-dropdown>
        </div>
      </div>
    </header>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import Util from "../../../utils";

export default {
  computed: {
    ...mapGetters([
      "getVerticalCompact",
      "getVerticalSidebar",
      "getSideBarToggleProperties",
      "unread",
    ]),
  },
  data() {
    return {
      username: "",
    };
  },
  methods: {
    ...mapActions([
      "switchSidebar",
      "sidebarCompact",
      "removeSidebarCompact",
      "mobileSidebar",
      "signOut",
      "changeLan",
    ]),

    handleFullScreen() {
      Util.toggleFullScreen();
    },

    changeLang(lang) {
      // console.log(lang);
      this.$i18n.locale = lang;
      this.changeLan(lang);
    },

    logoutUser() {
      this.signOut();

      this.$router.push("/web/sessions/signIn");
    },
  },
  created() {
    this.username = localStorage.getItem("web_username");
  },
};
</script>>