<template>
  <div
    class="side-content-wrap"
    @mouseenter="isMenuOver = true"
    @mouseleave="isMenuOver = false"
    @touchstart="isMenuOver = true"
  >
    <vue-perfect-scrollbar
      :settings="{ suppressScrollX: true, wheelPropagation: false }"
      :class="{ open: getCompactSideBarToggleProperties.isSideNavOpen }"
      ref="myData"
      class="sidebar-left rtl-ps-none ps"
    >
      <ul class="navigation-left">
        <div class="logo">
          <img alt="" src="../../../assets/images/logo.png" />
        </div>
        <li
          @mouseenter="toggleSubMenu"
          :class="{ active: selectedParentMenu == 'dashboards' }"
          class="nav-item"
          data-item="dashboards"
          :data-submenu="true"
        >
          <a class="nav-item-hold" href="#">
            <i class="nav-icon i-Business-Mens"></i>
            <span class="nav-text">用户管理</span>
          </a>

          <div class="triangle"></div>
        </li>
        <li
          @mouseenter="toggleSubMenu"
          class="nav-item"
          :class="{ active: selectedParentMenu == 'ui-kits' }"
          data-item="ui-kits"
          :data-submenu="true"
        >
          <a class="nav-item-hold" href="#">
            <i class="nav-icon i-Bitcoin"></i>
            <span class="nav-text">钱包管理</span>
          </a>
          <div class="triangle"></div>
        </li>
        <li
          @mouseenter="toggleSubMenu"
          class="nav-item"
          :class="{ active: selectedParentMenu == 'extrakits' }"
          data-item="extrakits"
          :data-submenu="true"
        >
          <a class="nav-item-hold" href="#">
            <i class="nav-icon i-Sync"></i>
            <span class="nav-text">行情汇率</span>
          </a>
          <div class="triangle"></div>
        </li>
        <li
          @mouseenter="toggleSubMenu"
          class="nav-item"
          :class="{ active: selectedParentMenu == 'apps' }"
          data-item="apps"
          :data-submenu="true"
        >
          <a class="nav-item-hold" href="#">
            <i class="nav-icon i-Link"></i>
            <span class="nav-text">三方授权API</span>
          </a>
          <div class="triangle"></div>
        </li>
        <li
          @mouseenter="toggleSubMenu"
          class="nav-item"
          :class="{ active: selectedParentMenu == 'charts' }"
          data-item="charts"
          :data-submenu="true"
        >
          <a class="nav-item-hold" href="#">
            <i class="nav-icon i-Android"></i>
            <span class="nav-text">量化机器人</span>
          </a>
          <div class="triangle"></div>
        </li>
        <li
          @mouseenter="toggleSubMenu"
          class="nav-item"
          :class="{ active: selectedParentMenu == 'widgets' }"
          data-item="widgets"
          :data-submenu="true"
        >
          <a class="nav-item-hold" href="#">
            <i class="nav-icon i-Key"></i>
            <span class="nav-text">激活码管理</span>
          </a>
          <div class="triangle"></div>
        </li>
        <li
          @mouseenter="toggleSubMenu"
          class="nav-item"
          :class="{ active: selectedParentMenu == 'forms' }"
          data-item="forms"
          :data-submenu="true"
        >
          <a class="nav-item-hold" href="#">
            <i class="nav-icon i-Management"></i>
            <span class="nav-text">内部管理</span>
          </a>
          <div class="triangle"></div>
        </li>
        <li
          class="nav-item"
          @mouseenter="toggleSubMenu"
          :class="{ active: selectedParentMenu == 'datatables' }"
          data-item="datatables"
          :data-submenu="true"
        >
          <a class="nav-item-hold" href="#">
            <i class="nav-icon i-Data-Center"></i>
            <span class="nav-text">插件中心</span>
          </a>
          <div class="triangle"></div>
        </li>
        <li
          @mouseenter="toggleSubMenu"
          class="nav-item"
          :class="{ active: selectedParentMenu == 'sessions' }"
          data-item="sessions"
          :data-submenu="true"
        >
          <a class="nav-item-hold" href="#">
            <i class="nav-icon i-File-Clipboard-File--Text"></i>
            <span class="nav-text">系统日志</span>
          </a>
          <div class="triangle"></div>
        </li>
        <li
          @mouseenter="toggleSubMenu"
          :class="{ active: selectedParentMenu == 'pages' }"
          class="nav-item"
          data-item="pages"
          :data-submenu="true"
        >
          <a class="nav-item-hold" href="#">
            <i class="nav-icon i-Administrator"></i>
            <span class="nav-text">管理员管理</span>
          </a>
          <div class="triangle"></div>
        </li>
        <li
          @mouseenter="toggleSubMenu"
          :class="{ active: selectedParentMenu == 'doc' }"
          class="nav-item"
          data-item="doc"
          :data-submenu="true"
        >
          <a class="nav-item-hold" href="#">
            <i class="nav-icon i-Gears"></i>

            <span class="nav-text">系统管理</span>
          </a>
          <div class="triangle"></div>
        </li>
      </ul>
    </vue-perfect-scrollbar>

    <vue-perfect-scrollbar
      :class="{ open: getCompactSideBarToggleProperties.isSideNavOpen }"
      :settings="{ suppressScrollX: true, wheelPropagation: false }"
      class="sidebar-left-secondary ps rtl-ps-none"
    >
      <div ref="sidebarChild">
        <i class="sidebar-close i-Close" @click="compactSideBarToggle"></i>
        <header>
          <div class="logo">
            <!-- <img src="../../../assets/images/laravel-logo.png" alt /> -->
          </div>
        </header>

        <!-- submenu-dashboards -->
        <div
          class="submenu-area"
          data-parent="dashboards"
          :class="{ 'd-block': selectedParentMenu == 'dashboards' }"
        >
          <header>
            <h6>用户管理</h6>
            <p>Lorem ipsum dolor sit.</p>
          </header>
          <ul class="childNav" data-parent="dashboards">
            <li class="nav-item">
              <router-link tag="a" class to="/app/dashboards/dashboard.v1">
                <i class="nav-icon i-Clock-3"></i>
                <span class="item-name">本站用户</span>
              </router-link>
            </li>
          </ul>
        </div>
        <!-- end dashboards -->
        <div
          class="submenu-area"
          data-parent="ui-kits"
          :class="{ 'd-block': selectedParentMenu == 'ui-kits' }"
        >
          <header>
            <h6>钱包管理</h6>
            <p>Lorem ipsum dolor sit.</p>
          </header>
          <ul class="childNav" data-parent="ui-kits">
            <li class="nav-item">
              <router-link tag="a" class to="/app/ui-kits/alerts">
                <i class="nav-icon i-Bell1"></i>
                <span class="item-name">币种管理</span>
              </router-link>
            </li>

            <li class="nav-item">
              <router-link tag="a" class to="/app/ui-kits/accordion">
                <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                <span class="item-name">钱包列表</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/ui-kits/badges">
                <i class="nav-icon i-Medal-2"></i>
                <span class="item-name">转账记录</span>
              </router-link>
            </li>
          </ul>
        </div>
        <!-- end ui-kits -->

        <div
          class="submenu-area"
          data-parent="extrakits"
          :class="{ 'd-block': selectedParentMenu == 'extrakits' }"
        >
          <header>
            <h6>行情汇率</h6>
            <p>Lorem ipsum dolor sit.</p>
          </header>
          <ul class="childNav" data-parent="extrakits">
            <li class="nav-item">
              <router-link tag="a" class to="/app/extraKits/dropdown">
                <i class="nav-icon i-Arrow-Down"></i>
                <span class="item-name">汇率管理</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/extraKits/imageCropper">
                <i class="nav-icon i-Crop-2"></i>
                <span class="item-name">市场行情</span>
              </router-link>
            </li>
          </ul>
        </div>
        <!-- end of extra kits -->
        <div
          class="submenu-area"
          data-parent="apps"
          :class="{ 'd-block': selectedParentMenu == 'apps' }"
        >
          <header>
            <h6>三方授权API</h6>
            <p>Lorem ipsum dolor sit.</p>
          </header>
          <ul class="childNav" data-parent="apps">
            <li class="nav-item">
              <router-link tag="a" class to="/app/extraKits/dropdown">
                <i class="nav-icon i-Arrow-Down"></i>
                <span class="item-name">第三方交易对</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/extraKits/imageCropper">
                <i class="nav-icon i-Crop-2"></i>
                <span class="item-name">授权API列表</span>
              </router-link>
            </li>
          </ul>
        </div>
        <!-- end of apps -->
        <div
          class="submenu-area"
          data-parent="charts"
          :class="{ 'd-block': selectedParentMenu == 'charts' }"
        >
          <header>
            <h6>量化机器人</h6>
            <p>Lorem ipsum dolor sit.</p>
          </header>
          <ul class="childNav" data-parent="charts">
            <li class="nav-item">
              <router-link tag="a" class to="/app/charts/eChart">
                <i class="nav-icon i-Line-Chart-2"></i>
                <span class="item-name">机器人列表</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/charts/eChart">
                <i class="nav-icon i-Line-Chart-2"></i>
                <span class="item-name">机器人订单</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/charts/eChart">
                <i class="nav-icon i-Line-Chart-2"></i>
                <span class="item-name">机器人日志</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/charts/eChart">
                <i class="nav-icon i-Line-Chart-2"></i>
                <span class="item-name">机器人收益</span>
              </router-link>
            </li>
          </ul>
        </div>
        <!-- end of charts -->

        <div
          class="submenu-area"
          data-parent="widgets"
          :class="{ 'd-block': selectedParentMenu == 'widgets' }"
        >
          <header>
            <h6>激活码管理</h6>
            <p>Lorem ipsum dolor sit.</p>
          </header>
          <ul class="childNav" data-parent="widgets">
            <li class="nav-item">
              <router-link tag="a" class to="/app/widgets/widgetCard">
                <i class="nav-icon i-Two-Windows"></i>
                <span class="item-name">激活码管理</span>
              </router-link>
            </li>
          </ul>
        </div>
        <!-- end of widgets -->

        <div
          class="submenu-area"
          data-parent="forms"
          :class="{ 'd-block': selectedParentMenu == 'forms' }"
        >
          <header>
            <h6>内容管理</h6>
            <p>Lorem ipsum dolor sit.</p>
          </header>
          <ul class="childNav" data-parent="forms">
            <li class="nav-item">
              <router-link tag="a" class to="/app/forms/basicForms">
                <i class="nav-icon i-File-Clipboard-Text--Image"></i>
                <span class="item-name">文章管理</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/forms/formLayouts">
                <i class="nav-icon i-Split-Vertical"></i>
                <span class="item-name">分类管理</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/forms/basicActionBar">
                <i class="nav-icon i-Receipt-4"></i>
                <span class="item-name">内页管理</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/forms/formComponent">
                <i class="nav-icon i-Close-Window"></i>
                <span class="item-name">页面管理</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/forms/formWizard">
                <i class="nav-icon i-Width-Window"></i>
                <span class="item-name">文章标签</span>
              </router-link>
            </li>
          </ul>
        </div>
        <!-- end of forms -->

        <div
          class="submenu-area"
          data-parent="datatables"
          :class="{ 'd-block': selectedParentMenu == 'datatables' }"
        >
          <header>
            <h6>插件中心</h6>
            <p>Lorem ipsum dolor sit.</p>
          </header>
          <ul class="childNav" data-parent="datatables">
            <li class="nav-item">
              <router-link tag="a" class to="/app/datatables/paging">
                <i class="nav-icon i-Split-Four-Square-Window"></i>
                <span class="item-name">钩子管理</span>
              </router-link>
            </li>
          </ul>
        </div>
        <!-- end of datatables -->

        <div
          class="submenu-area"
          data-parent="sessions"
          :class="{ 'd-block': selectedParentMenu == 'sessions' }"
        >
          <header>
            <h6>系统日志</h6>
            <p>Lorem ipsum dolor sit.</p>
          </header>
          <ul class="childNav" data-parent="sessions">
            <li class="nav-item">
              <router-link tag="a" class to="/admin/sessions/signIn">
                <i class="nav-icon i-Checked-User"></i>
                <span class="item-name">任务日志</span>
              </router-link>
            </li>
          </ul>
        </div>
        <!-- end of sessions -->

        <div
          class="submenu-area"
          data-parent="pages"
          :class="{ 'd-block': selectedParentMenu == 'pages' }"
        >
          <header>
            <h6>管理员管理</h6>
            <p>Lorem ipsum dolor sit.</p>
          </header>
          <ul class="childNav" data-parent="pages">
            <li class="nav-item">
              <router-link tag="a" class to="/app/pages/error">
                <i class="nav-icon i-Error-404-Window"></i>
                <span class="item-name">角色管理</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/pages/profile">
                <i class="nav-icon i-Male"></i>
                <span class="item-name">管理员</span>
              </router-link>
            </li>
          </ul>
        </div>
        <!-- end of pages -->
        <div
          class="submenu-area"
          data-parent="doc"
          :class="{ 'd-block': selectedParentMenu == 'doc' }"
        >
          <header>
            <h6>系统管理</h6>
            <p>Lorem ipsum dolor sit.</p>
          </header>
          <ul class="childNav" data-parent="doc">
            <li class="nav-item">
              <router-link tag="a" class to="/app/pages/error">
                <i class="nav-icon i-Error-404-Window"></i>
                <span class="item-name">网站信息</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/pages/profile">
                <i class="nav-icon i-Male"></i>
                <span class="item-name">邮箱配件</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/pages/error">
                <i class="nav-icon i-Error-404-Window"></i>
                <span class="item-name">banner图管理</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/pages/profile">
                <i class="nav-icon i-Male"></i>
                <span class="item-name">短信其他</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/pages/error">
                <i class="nav-icon i-Error-404-Window"></i>
                <span class="item-name">网站信息</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/pages/profile">
                <i class="nav-icon i-Male"></i>
                <span class="item-name">文件存储</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link tag="a" class to="/app/pages/profile">
                <i class="nav-icon i-Male"></i>
                <span class="item-name">运营配置</span>
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </vue-perfect-scrollbar>
    <div
      @click="removeOverlay()"
      class="sidebar-overlay"
      :class="{
        open:
          getCompactSideBarToggleProperties.isSideNavOpen && windowWidth <= 1200
      }"
    ></div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { isMobile } from "mobile-device-detect";
export default {
  data() {
    return {
      isMenuOver: false,
      selectedParentMenu: "",
      isMobile,
      windowWidth: window.innerWidth
    };
  },
  mounted() {
    this.toggleSelectedParentMenu();
    window.addEventListener("resize", this.handleWindowResize);
    document.addEventListener("click", this.returnSelectedParentMenu);
    this.handleWindowResize();
  },

  beforeDestroy() {
    document.removeEventListener("click", this.returnSelectedParentMenu);
    window.removeEventListener("resize", this.handleWindowResize);
  },
  computed: {
    ...mapGetters(["getCompactSideBarToggleProperties"])
  },

  methods: {
    ...mapActions(["changeCompactSidebarProperties"]),

    removeOverlay() {
      this.changeCompactSidebarProperties();
      // if (window.innerWidth<=1200) {
      //   this.changeSidebarProperties();
      // }
      this.toggleSelectedParentMenu();
    },

    compactSideBarToggle() {
      // console.log("test");
      if (this.getCompactSideBarToggleProperties.isSideNavOpen) {
        this.changeCompactSidebarProperties();
      }
    },

    handleWindowResize() {
      this.windowWidth = window.innerWidth;
      if (window.innerWidth <= 1200) {
        if (this.getCompactSideBarToggleProperties.isSideNavOpen) {
          this.changeCompactSidebarProperties();
        }
      } else {
        if (!this.getCompactSideBarToggleProperties.isSideNavOpen) {
          this.changeCompactSidebarProperties();
        }
      }
    },
    toggleSelectedParentMenu() {
      const currentParentUrl = this.$route.path
        .split("/")
        .filter(x => x !== "")[1];

      if (currentParentUrl !== undefined || currentParentUrl !== null) {
        this.selectedParentMenu = currentParentUrl.toLowerCase();
      } else {
        this.selectedParentMenu = "dashboards";
      }
    },
    toggleSubMenu(e) {
      let hasSubmenu = e.target.dataset.submenu;
      let parent = e.target.dataset.item;
      if (hasSubmenu) {
        this.selectedParentMenu = parent;
      } else {
        // this.selectedParentMenu = parent;
        this.toggleSelectedParentMenu();
      }
    },
    returnSelectedParentMenu() {
      if (!this.isMenuOver) {
        this.toggleSelectedParentMenu();
      }
    },

    toggleSidebarDropdwon(event) {
      let dropdownMenus = this.$el.querySelectorAll(".dropdown-sidemenu.open");

      event.currentTarget.classList.toggle("open");

      dropdownMenus.forEach(dropdown => {
        dropdown.classList.remove("open");
      });
    }
  }
};
</script>