import Vue from "vue";
import store from "./store";
// import {isMobile} from "mobile-device-detect";
import Router from "vue-router";
import NProgress from "nprogress";
import authenticate from "./auth/authenticate";

Vue.use(Router);

// create new router

const routes = [
  {
    path: "/manage/",
    component: () => import("./views/app"), //webpackChunkName app
    beforeEnter: authenticate,
    redirect: "/manage/dashboard/dashboard",

    children: [
      {
        path: "/manage/dashboard",
        component: () => import("./views/app/dashboard"), //dashboard,
        children: [
          {
            path: "dashboard",
            component: () => import("./views/app/dashboard/dashboard"),
          },
        ]
      },
      {
        path: "/manage/products",
        component: () => import("./views/app/products"), //dashboard,
        meta: { permission: '1' },
        children: [
          {
            path: "productsManage",
            component: () => import("./views/app/products/productsManage"),
          },
        ]
      },
      {
        path: "/manage/country",
        component: () => import("./views/app/country"), //dashboard,
        meta: { permission: '1' },
        children: [
          {
            path: "countryManage",
            component: () => import("./views/app/country/countryManage"),
          },
          {
            path: "bankManage",
            component: () => import("./views/app/country/bankManage"),
          },
        ]
      },
      {
        path: "/manage/users",
        component: () => import("./views/app/users"), //dashboard,
        meta: { permission: '1' },
        children: [
          {
            path: "user",
            component: () => import("./views/app/users/user"),
            meta: { permission: '11' },
          },
          {
            path: "registerMember",
            component: () => import("./views/app/users/registerMember"),
            meta: { permission: '12' },
          },
          {
            path: "contactOtp",
            component: () => import("./views/app/users/contactOtp"),
            meta: { permission: '11' },
          },
        ]
      },
      {
        path: "/manage/mining",
        component: () => import("./views/app/mining"), //dashboard,
        meta: { permission: '1' },
        children: [
          {
            path: "miningList",
            component: () => import("./views/app/mining/miningList"),
            meta: { permission: '11' },
          },
        ]
      },
      {
        path: "/manage/trading",
        component: () => import("./views/app/trading"), //dashboard,
        meta: { permission: '1' },
        children: [
          {
            path: "tradingPlatform",
            component: () => import("./views/app/trading/tradingPlatform"),
            meta: { permission: '11' },
          },
          {
            path: "daPrice",
            component: () => import("./views/app/trading/daPrice"),
            meta: { permission: '11' },
          },
        ]
      },
      {
        path: "/manage/team",
        component: () => import("./views/app/team"), //dashboard,
        meta: { permission: '1' },
        children: [
          {
            path: "memberTree",
            component: () => import("./views/app/team/memberTree"),
            meta: { permission: '13' },
          },
        ]
      },

      //wallet
      {
        path: "/manage/wallet",
        component: () => import("./views/app/wallet"),
        redirect: "/manage/wallet/walletChangeRec",
        meta: { permission: '2' },
        children: [
          // {
          //   path: "coin",
          //   component: () => import("./views/app/wallet/coin")
          // },
          // {
          //   path: "walletList",
          //   component: () => import("./views/app/wallet/walletList")
          // },
          {
            path: "walletChangeRec",
            component: () => import("./views/app/wallet/walletChangeRec"),
            meta: { permission: '21' },
          },
        ]
      },

      //withdraw
      {
        path: "/manage/withdraw",
        component: () => import("./views/app/withdraw"),
        redirect: "/manage/withdraw/withdrawList",
        meta: { permission: '3' },
        children: [
          // {
          //   path: "coin",
          //   component: () => import("./views/app/wallet/coin")
          // },
          {
            path: "withdrawList",
            component: () => import("./views/app/withdraw/withdrawList"),
            meta: { permission: '31' },
          },
          {
            path: "withdrawHistory",
            component: () => import("./views/app/withdraw/withdrawHistory"),
            meta: { permission: '32' },
          },
          {
            path: "withdrawCash",
            component: () => import("./views/app/withdraw/withdrawCash"),
            meta: { permission: '31' },
          },
          {
            path: "withdrawCashHistory",
            component: () => import("./views/app/withdraw/withdrawCashHistory"),
            meta: { permission: '31' },
          },
        ]
      },

      //uimarket-exchange
      {
        path: "/manage/market-exchange",
        component: () => import("./views/app/market-exchange"),
        redirect: "/manage/market-exchange/exchange",
        meta: { permission: '6' },
        children: [
          {
            path: "market",
            component: () => import("./views/app/market-exchange/market"),
            meta: { permission: '61' },
          },
        ]
      },

      //deposit
      {
        path: "/manage/deposit",
        component: () => import("./views/app/deposit"),
        redirect: "/manage/deposit/depositList",
        meta: { permission: '4' },
        children: [
          {
            path: "depositManage",
            component: () => import("./views/app/deposit/depositManage"),
            meta: { permission: '41' },
          },
          {
            path: "depositList",
            component: () => import("./views/app/deposit/depositList"),
            meta: { permission: '41' },
          },
          {
            path: "depositCoinList",
            component: () => import("./views/app/deposit/depositCoinList"),
            meta: { permission: '42' },
          },
        ]
      },

      //trade
      {
        path: "/manage/trade",
        component: () => import("./views/app/trade"),
        redirect: "/manage/trade/orderList",
        meta: { permission: '5' },
        children: [
          {
            path: "tradePlan",
            component: () => import("./views/app/trade/tradePlan"),
            meta: { permission: '51' },
          },
          {
            path: "orderList",
            component: () => import("./views/app/trade/orderList"),
            meta: { permission: '52' },
          },
          {
            path: "revenueList",
            component: () => import("./views/app/trade/revenueList"),
            meta: { permission: '53' },
          },
        ]
      },

      // robots
      {
        path: "/manage/robots",
        component: () => import("./views/app/robots"),
        redirect: "/manage/robots/userRobot",
        meta: { permission: '7' },
        children: [
          {
            path: "userRobot",
            component: () => import("./views/app/robots/userRobot"),
            meta: { permission: '71' },
          },
          // {
          //   path: "userRobotPackage",
          //   component: () => import("./views/app/robots/userRobotPackage"),
          //   meta: { permission: '71' },
          // },
          // {
          //   path: "robotList",
          //   component: () => import("./views/app/robots/robotList")
          // },
          // {
          //   path: "robotLog",
          //   component: () => import("./views/app/robots/robotLog")
          // },
          // {
          //   path: "robotProfit",
          //   component: () => import("./views/app/robots/robotProfit")
          // },
        ]
      },
      
      {
        path: "/manage/record",
        component: () => import("./views/app/record"),
        redirect: "/manage/record/sponsor",
        meta: { permission: '8' },
        children: [
          // {
          //   path: "wallet",
          //   component: () => import("./views/app/record/wallet")
          // },
          {
            path: "sponsor",
            meta: { permission: '81' },
            component: () => import("./views/app/record/sponsor")
          },
          {
            path: "matching",
            meta: { permission: '82' },
            component: () => import("./views/app/record/matching")
          },
          {
            path: "dynamic",
            meta: { permission: '83' },
            component: () => import("./views/app/record/dynamic")
          },
          {
            path: "special",
            meta: { permission: '84' },
            component: () => import("./views/app/record/special")
          },
        ]
      },

      // activate-code
      {
        path: "/manage/activate-code",
        component: () => import("./views/app/activate-code"),
        redirect: "/manage/activate-code/code-manage",
        meta: { permission: '9' },
        children: [
          {
            path: "code-manage",
            meta: { permission: '91' },
            component: () => import("./views/app/activate-code/code-manage")
          }
        ]
      },

      // ticket
      {
        path: "/manage/ticket",
        component: () => import("./views/app/ticket"),
        redirect: "/manage/ticket/ticketList",
        meta: { permission: '11' },
        children: [
          {
            path: "ticketList",
            meta: { permission: '111' },
            component: () => import("./views/app/ticket/ticketList")
          }
        ]
      },

      // widget
      {
        path: "/manage/internal",
        meta: { permission: '10' },
        component: () => import("./views/app/internal"),
        redirect: "/manage/internal/article",
        children: [
          {
            path: "article",
            meta: { permission: '101' },
            component: () => import("./views/app/internal/article")
          },
          // {
          //   path: "classification",
          //   component: () => import("./views/app/internal/classification")
          // },
          // {
          //   path: "internal-page",
          //   component: () => import("./views/app/internal/internal-page")
          // },
          // {
          //   path: "pages",
          //   component: () => import("./views/app/internal/pages")
          // },
          // {
          //   path: "article-tag",
          //   component: () => import("./views/app/internal/article-tag")
          // }
        ]
      },

      // admins
      {
        path: "/manage/admins",
        component: () => import("./views/app/admins"),
        redirect: "/manage/admins/admin",
        meta: { permission: '12' },
        children: [
          {
            path: "role",
            component: () => import("./views/app/admins/permission")
          },
          {
            path: "admin",
            meta: { permission: '121' },
            component: () => import("./views/app/admins/admin")
          },
        ]
      },

      // system-manage
      {
        path: "/manage/system-manage",
        component: () => import("./views/app/system-manage"),
        redirect: "/manage/system-manage/system-config",
        meta: { permission: '13' },
        children: [
          {
            path: "system-config",
            meta: { permission: '131' },
            component: () => import("./views/app/system-manage/system-config")
          },
        ]
      },
    ]
  },
  // sessions
  {
    path: "/manage/sessions",
    component: () => import("./views/app/sessions"),
    redirect: "/manage/sessions/signIn",
    children: [
      {
        path: "signIn",
        component: () => import("./views/app/sessions/signIn")
      },
      // {
      //   path: "signUp",
      //   component: () => import("./views/app/sessions/signUp")
      // },
      // {
      //   path: "forgot",
      //   component: () => import("./views/app/sessions/forgot")
      // }
    ]
  },

  {
    path: "/register",
    component: () => import("./views/app/sessions/signUp"),
  },

  {
    path: "/",
    component: () => import("./views/app/sessions/download"),
  },

  // {
  //   path: "/vertical-sidebar",
  //   component: () => import("./containers/layouts/verticalSidebar")
  // },
  {
    path: "*",
    component: () => import("./views/app/pages/notFound")
  }
];

const router = new Router({
  mode: "history",
  linkActiveClass: "open",
  routes,
  // to, from, savedPosition
  scrollBehavior() {
    return { x: 0, y: 0 };
  }
});

router.beforeEach((to, from, next) => {
  // If this isn't an initial page load.
  if (to.path) {
    // Start the route progress bar.

    NProgress.start();
    NProgress.set(0.1);
  }
  // if (localStorage.getItem('path') != null) {
  //   var permissionList = localStorage.getItem('path');
  //   console.log((permissionList.includes(to.meta.permission)))
  //   try {
  //     // if (to.path == '/') {
  //     //   next('/');
  //     // }
      
  //     if (to.meta.permission != undefined && to.path != '/*') {
  //       if(permissionList.includes(to.meta.permission)){
  //         next();

  //       }else{
  //         next('*');
  //       }
  //     } else {
  //       next();
  //     }

  //   } catch (error) {
  //     console.log(error)
  //   }

  // } else {
  //   localStorage.removeItem("userToken");

  // }
  next();
});

router.afterEach(() => {
  // Remove initial loading
  const gullPreLoading = document.getElementById("loading_wrap");
  if (gullPreLoading) {
    gullPreLoading.style.display = "none";
  }
  // Complete the animation of the route progress bar.
  setTimeout(() => NProgress.done(), 500);
  // NProgress.done();
  // if (isMobile) {
  if (window.innerWidth <= 1200) {
    // console.log("mobile");
    store.dispatch("changeSidebarProperties");
    if (store.getters.getSideBarToggleProperties.isSecondarySideNavOpen) {
      store.dispatch("changeSecondarySidebarProperties");
    }

    if (store.getters.getCompactSideBarToggleProperties.isSideNavOpen) {
      store.dispatch("changeCompactSidebarProperties");
    }
  } else {
    if (store.getters.getSideBarToggleProperties.isSecondarySideNavOpen) {
      store.dispatch("changeSecondarySidebarProperties");
    }

    // store.state.sidebarToggleProperties.isSecondarySideNavOpen = false;
  }
});

export default router;
