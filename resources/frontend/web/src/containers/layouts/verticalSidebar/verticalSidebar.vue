<template>
  <vue-perfect-scrollbar
    class="sidebar-panel rtl-ps-none ps scroll"
    @mouseleave.native="
      sidebarCompact();
      returnSelectedParentMenu();
    "
    @mouseenter.native="removeSidebarCompact"
    :class="{
      'vertical-sidebar-compact': getVerticalCompact.isSidebarCompact,
      'sidebar-full-collapse': getVerticalSidebar.isMobileCompact,
    }"
    :settings="{ suppressScrollX: true, wheelPropagation: false }"
  >
    <div>
      <div
        class="
          gull-brand
          text-center
          d-flex
          align-items-center
          pl-2
          mb-2
          justify-content-between
        "
      >
        <div><img class="" src="../../../assets/images/logo.png" /></div>
        <div class="toggle-sidebar-compact">
          <label class="switch ul-switch switch-primary ml-auto">
            <input @click="switchSidebar" type="checkbox" />
            <span class="ul-slider o-hidden"></span>
          </label>
        </div>
      </div>

      <div class="close-mobile-menu" @click="mobileSidebar">
        <i class="text-16 text-primary i-Close-Window font-weight-bold"></i>
      </div>

      <div class="mt-4 main-menu">
        <ul class="ul-vertical-sidebar pl-4" id="menu">
          <!-- <p class="main-menu-title text-muted ml-3 font-weight-700 text-13 mt-4 mb-2">third-party</p> -->
          <li class="Ul_li--hover">
            <router-link
              tag="a"
              class="has-arrow"
              :to="'/dashboard/dashboard'"
              :class="{ active: selectedParentMenu == 'dashboard' }"
            >
              <i class="i-Home1 text-20 mr-2"></i>
              <span
                class="text-15"
                :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }"
                >{{ $t("dashboard") }}</span
              >
            </router-link>
          </li>

          <li class="Ul_li--hover">
            <router-link
              tag="a"
              class="has-arrow"
              :to="'/quantitative/marketList'"
              :class="{ active: selectedParentMenu == 'quantitative' }"
            >
              <i class="i-Compass-2 text-20 mr-2"></i>
              <span
                class="text-15"
                :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }"
                >{{ $t("quantity") }}</span
              >
            </router-link>
          </li>

          <li class="Ul_li--hover">
            <router-link
              tag="a"
              class="has-arrow"
              :to="'/apiBinding/apiBinding'"
              :class="{ active: selectedParentMenu == 'apiBinding' }"
            >
              <i class="i-Compass-2 text-20 mr-2"></i>
              <span
                class="text-15"
                :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }"
                >{{ $t("api_binding") }}</span
              >
            </router-link>
          </li>

          <li class="Ul_li--hover">
            <router-link
              tag="a"
              class="has-arrow"
              :to="'/pinManage/pinList'"
              :class="{ active: selectedParentMenu == 'pinList' }"
            >
              <i class="i-Compass-2 text-20 mr-2"></i>
              <span
                class="text-15"
                :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }"
                >{{ $t("pin_manage") }}</span
              >
            </router-link>
          </li>

          <li class="Ul_li--hover">
            <router-link
              tag="a"
              class="has-arrow"
              :to="'/revenueManage/revenue'"
              :class="{ active: selectedParentMenu == 'revenue' }"
            >
              <i class="i-Compass-2 text-20 mr-2"></i>
              <span
                class="text-15"
                :class="{
                  'vertical-item-name': getVerticalCompact.isItemName,
                }"
                >{{ $t("revenue") }}</span
              >
            </router-link>
          </li>

          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-0>
              <a
                class="has-arrow"
                href="#"
                :class="{ active: selectedParentMenu == 'team' }"
              >
                <i class="i-Compass-2 text-20 mr-2"></i>
                <span
                  class="text-15"
                  :class="{
                    'vertical-item-name': getVerticalCompact.isItemName,
                  }"
                  >{{ $t("my_team") }}</span
                >
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-0">
              <ul
                class="Ul_collapse"
                :class="{ 'vertical-item-name': getVerticalCompact.isItemName }"
              >
                <li>
                  <router-link tag="a" class to="/web/myTeam/team">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("my_team") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/web/myTeam/myTeamRevenue">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("team_revenue") }}</span>
                  </router-link>
                </li>
              
              
              </ul>
            </b-collapse>
          </li>

          
          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-1>
              <a
                class="has-arrow"
                href="#"
                :class="{ active: selectedParentMenu == 'myAssets' }"
              >
                <i class="i-Compass-2 text-20 mr-2"></i>
                <span
                  class="text-15"
                  :class="{
                    'vertical-item-name': getVerticalCompact.isItemName,
                  }"
                  >{{ $t("my_assets") }}</span
                >
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-1">
              <ul
                class="Ul_collapse"
                :class="{ 'vertical-item-name': getVerticalCompact.isItemName }"
              >
                <li>
                  <router-link tag="a" class to="/web/myWallet/walletRecord">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("wallet_record") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/web/myWallet/deposit">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("deposit") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/web/myWallet/depositRecord">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("deposit_record") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/web/myWallet/withdraw">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("withdraw") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/web/myWallet/withdrawRecord">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("withdraw_record") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/web/myWallet/transfer">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("transfer") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/web/myWallet/transferRecord">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("transfer_record") }}</span>
                  </router-link>
                </li>
              </ul>
            </b-collapse>
          </li>
          
          <li class="Ul_li--hover">
            <div v-b-toggle.accordion-2>
              <a
                class="has-arrow"
                href="#"
                :class="{ active: selectedParentMenu == 'settings' }"
              >
                <i class="i-Business-Mens text-20 mr-2"></i>
                <span
                  class="text-15"
                  :class="{
                    'vertical-item-name': getVerticalCompact.isItemName,
                  }"
                  >{{ $t("settings") }}</span
                >
                <arrowIcon />
              </a>
            </div>
            <b-collapse accordion="my-accordion" id="accordion-2">
              <ul
                class="Ul_collapse"
                :class="{ 'vertical-item-name': getVerticalCompact.isItemName }"
              >
                <li>
                  <router-link tag="a" class to="/web/settings/change-password">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("change_login_pwd") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/web/settings/change-sec-password">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("change_security_pwd") }}</span>
                  </router-link>
                </li>
                <li>
                  <router-link tag="a" class to="/web/settings/forget-sec-password">
                    <i class="i-Circular-Point mr-2"></i>
                    <span>{{ $t("forget_secpassword") }}</span>
                  </router-link>
                </li>
              </ul>
            </b-collapse>
          </li>
        </ul>
      </div>
    </div>
  </vue-perfect-scrollbar>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import arrowIcon from "../../../components/arrow/arrowIcon";
export default {
  components: {
     arrowIcon,
  },
  computed: {
    ...mapGetters(["getVerticalCompact", "getVerticalSidebar", "unread"]),
  },
  data() {
    return {
      selectedParentMenu: "",
    };
  },
  mounted() {
    this.toggleSelectedParentMenu();
    document.addEventListener("click", this.returnSelectedParentMenu);

    if (this.$i18n.locale == "vi") {
      this.$i18n.locale = "zh";
    }
  },
  beforeDestroy() {
    document.removeEventListener("click", this.returnSelectedParentMenu);
  },
  methods: {
    ...mapActions([
      "switchSidebar",
      "sidebarCompact",
      "removeSidebarCompact",
      "mobileSidebar",
    ]),

    toggleSelectedParentMenu() {
      const currentParentUrl = this.$route.path
        .split("/")
        .filter((x) => x !== "")[1];

      if (currentParentUrl !== undefined || currentParentUrl !== null) {
        this.selectedParentMenu = currentParentUrl.toLowerCase();
        console.log(currentParentUrl);
      } else {
        this.selectedParentMenu = "users";
      }
    },
    returnSelectedParentMenu() {
      this.toggleSelectedParentMenu();
    },
  },
};
</script>
<style>
</style>