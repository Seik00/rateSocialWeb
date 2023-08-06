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
          to="/manage/ticket/ticketList"
          class="mr-3"
          href="#"
        >
          <span class="text-danger font-weight-bold"
            >{{ unread + $t('unreadNotice')}} </span
          >
        </router-link>

        <b-link to="/manage/deposit/depositCoinList">
          <div style="margin:0 10px">
            <div style="font-size:10px;">
              {{ $t('deposit')}}
            </div>
            <i class="fa fa-dollar" style="font-size:24px"></i>
            <span class="text-danger font-weight-bold" style="vertical-align: top;" v-if="depositCount > 0">
              {{ depositCount}} 
            </span>
          </div>
        </b-link>
        
          <div style="margin:0 10px">
            <div style="font-size:10px">
              {{ $t('withdraw')}}
            </div>
            <i class="fa fa-credit-card" style="font-size:24px"></i>
            <span class="text-danger font-weight-bold" style="vertical-align: top;" v-if="withdrawCount > 0">
              {{ withdrawCount}} 
            </span>
          </div>
       

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
import { moneyCount } from "../../../system/api/api";
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
      depositCount: "",
      withdrawCount: "",
      ticketCount: "",
      stopLoop: false,
      soundurl : 'http://soundbible.com/mp3/Elevator Ding-SoundBible.com-685385892.mp3'
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

    playSound() {
      if (this.soundurl) {
        var audio = new Audio();
        audio.src = this.soundurl;
        audio.muted = false;
        audio.autoplay = "";
        audio.oncanplaythrough = () => {
          var playedPromise = audio.play();
          if (playedPromise) {
            playedPromise
              .catch((e) => {
                console.log(e);
                if (
                  e.name === "NotAllowedError" ||
                  e.name === "NotSupportedError"
                ) {
                  console.log(e.name);
                }
              })
              .then(() => {
                console.log("playing sound !!!");
              });
          }
        };
      }
    },

    moneyCountRead() {
      var result = moneyCount();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          console.log(value);
          self.moneyCount = value.data.data.record;
          self.depositCount = value.data.data.record.total_deposit;
          self.withdrawCount = value.data.data.record.total_withdraw;
          self.ticketCount = value.data.data.record.total_ticket;
          // if (self.depositCount > 0 || self.withdrawCount > 0 || self.ticketCount > 0) {
          //   self.playSound();
          // }
        })
        .catch(function (error) {
         console.log(error);
        });
    },

    logoutUser() {
      this.signOut();

      this.$router.push("/manage/sessions/signIn");
    },
  },
  created() {
    this.moneyCountRead();
    this.username = localStorage.getItem("username");
  },
  beforeDestroy() {
    this.stopLoop = true;
  },
};
</script>>