import Vue from "vue";
import store from "./store";
// import {isMobile} from "mobile-device-detect";
import Router from "vue-router";
import NProgress from "nprogress";
// import checkStatus from "./auth/checkStatus";
// import checkInfo from "./views/app/withdraw/checkInfo";
import checkRequestDeposit from "./auth/checkRequestDeposit";
import checkSecPassword from "./auth/checkSecPassword";
// import authenticate from "./auth/authenticate";
Vue.use(Router);

// create new router

const routes = [
  {
    path: "/web/",
    component: () => import("./views/app"), //webpackChunkName app
    beforeEnter: checkSecPassword,
    redirect: "/web/dashboard/dashboard",

    children: [
      {
        path: "/web/dashboard/dashboard",
        // beforeEnter: checkSecPassword,
        component: () => import("./views/app/dashboard/dashboard"),
      },
      {
        path: "/web/rating",
        component: () => import("./views/app/rating"),
        redirect: "/web/rating/home",
        children: [
          {
            path: "home",
            component: () => import("./views/app/rating/home"),
          },
    
        ]
      },
      {
        path: "/web/boost",
        // beforeEnter: checkSecPassword,
        component: () => import("./views/app/boost"),
        children: [
          {
            path: "boostPage",
            component: () => import("./views/app/boost/boostPage"),

          },
        ]
      },
      {
        path: "/web/trade",
        component: () => import("./views/app/trade/"),
        redirect: "/web/trade/tradeChart",
        children: [
          {
            path: "tradeList",
            component: () => import("./views/app/trade/tradeList"),

          },

          {
            path: "/web/trade/tradeChart",
            component: () => import("./views/app/trade/tradeChart"),

          },
        ]
      },
      {
        path: "/web/me",
        // beforeEnter: checkSecPassword,
        component: () => import("./views/app/me"),
        children: [
          {
            path: "mePage",
            component: () => import("./views/app/me/mePage"),

          },
          {
            path: "faq",
            component: () => import("./views/app/me/faq"),

          },
          {
            path: "faqDetail",
            component: () => import("./views/app/me/faqDetail"),

          },
          {
            path: "newsList",
            component: () => import("./views/app/me/newsList"),

          },
          {
            path: "newsDetails",
            name: "newDetails",
            props: true,
            component: () => import("./views/app/me/newsDetails"),

          },
          {
            path: "tnc",
            component: () => import("./views/app/me/tnc"),

          },
          {
            path: "legal",
            component: () => import("./views/app/me/legal"),

          },
        ]
      },
      {
        path: "/web/quantitative",
        component: () => import("./views/app/quantitative"), //dashboard,
        meta: { permission: '1' },
        children: [
          {
            path: "marketList",
            component: () => import("./views/app/quantitative/marketList"),

          },
          {
            path: "robotInfo",
            component: () => import("./views/app/quantitative/robotinfo"),

            props: true
          },
          {
            path: "robotSetting",
            component: () => import("./views/app/quantitative/robotSetting"),

            props: true
          },
        ]
      },
      {
        path: "/web/apiBinding",
        component: () => import("./views/app/apiBinding"),
        children: [
          {
            path: "apiBinding",
            component: () => import("./views/app/apiBinding/apiBinding"),

          },
        ]
      },
      {
        path: "/web/revenueManage",
        component: () => import("./views/app/revenueManage"),
        children: [
          {
            path: "revenue",
            component: () => import("./views/app/revenueManage/revenue"),

          },
          {
            path: "revenueDetails",
            component: () => import("./views/app/revenueManage/revenueDetails"),

          },
        ]
      },
      {
        path: "/web/myWallet",
        component: () => import("./views/app/myWallet"),
        children: [
          {
            path: "walletRecord",
            component: () => import("./views/app/myWallet/walletRecord"),

          },
          {
            path: "deposit",
            component: () => import("./views/app/myWallet/deposit"),

          },
          {
            path: "depositRecord",
            component: () => import("./views/app/myWallet/depositRecord"),

            props: true
          },
          {
            path: "withdraw",
            component: () => import("./views/app/myWallet/withdraw"),

            props: true
          },
          {
            path: "withdrawRecord",
            component: () => import("./views/app/myWallet/withdrawRecord"),

            props: true
          },
          {
            path: "transfer",
            component: () => import("./views/app/myWallet/transfer"),

            props: true
          },
          {
            path: "transferRecord",
            component: () => import("./views/app/myWallet/transferRecord"),

            props: true
          },
        ]
      },
      // settings
      {
        path: "/web/settings",
        beforeEnter: checkSecPassword,
        component: () => import("./views/app/settings"),
        children: [
          // {
          //   path: "settingCenter",
          //   component: () => import("./views/app/settings/settingCenter")
          // },
          // {
          //   path: "change-password",
          //   meta: { permission: '111' },
          //   component: () => import("./views/app/settings/change-password")
          // },
          // {
          //   path: "change-sec-password",
          //   component: () => import("./views/app/settings/change-sec-password"),

          //   props: true
          // },
          // {
          //   path: "forget-sec-password",
          //   component: () => import("./views/app/settings/forget-sec-password"),

          //   props: true
          // },
        ]
      },
    ]
  },
  {
    path: "/web/trade/tradeHistory",
    component: () => import("./views/app/trade/tradeHistory"),

  },
  {
    path: "/web/myTeam",
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/team/memberTree"),
  },
  {
    path: "/web/requestDeposit",
    beforeEnter: checkRequestDeposit,
    component: () => import("./views/app/deposit/requestDeposit"),
  },
  {
    path: "/web/deposit",
    // beforeEnter: checkSecPassword,
    component: () => import("./views/app/deposit"),
    redirect: "/web/deposit/deposit",
    children: [
      {
        path: "deposit",
        component: () => import("./views/app/deposit/deposit"),
      },
      {

        path: "depositHistory",
        component: () => import("./views/app/deposit/depositHistory"),
      },
      {

        path: "depositBankHistory",
        component: () => import("./views/app/deposit/depositBankHistory"),
      },
    ]
  },
  {


    path: "/web/withdraw",
    component: () => import("./views/app/withdraw"),
    // beforeEnter: checkSecPassword,
    redirect: "/web/withdraw/withdrawHistory",
    children: [
      {
        path: "withdraw",
        component: () => import("./views/app/withdraw/withdraw"),
      },
      {
        path: "setCoin",
        component: () => import("./views/app/withdraw/setCoin"),
      },
      {
        path: "setBank",
        component: () => import("./views/app/withdraw/setBank"),
      },
      {

        path: "withdrawHistory",
        // beforeEnter: checkInfo,
        component: () => import("./views/app/withdraw/withdrawHistory"),
      },
    ]
  },

  {
    path: "/web/boost/boostPage",
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/boost/boostPage"),
  },
  {
    path: "/web/referral",
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/referral"),
    redirect: "/web/referral/bonus",
    children: [
      {
        path: "bonus",
        component: () => import("./views/app/referral/bonus"),
      },

    ]
  },

  {
    path: "/web/settings",
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/settings"),
    redirect: "/web/settings/settingCenter",
    children: [
      {
        path: "settingCenter",
        component: () => import("./views/app/settings/settingCenter"),
      },
      {
        path: "change-password",
        component: () => import("./views/app/settings/change-password"),
      },
      {
        path: "change-sec-password",
        component: () => import("./views/app/settings/change-sec-password"),
      },
      {
        path: "forget-sec-password",
        component: () => import("./views/app/settings/forget-sec-password"),
      },
      // {
      //   path: "set-sec-password",
      //   // beforeEnter: authenticate,
      //   component: () => import("./views/app/settings/set-sec-password"),
      // },

    ]
  },

  {
    path: "/web/ticket",
    // beforeEnter: checkSecPassword,
    component: () => import("./views/app/ticket/"),
    redirect: "/web/ticket/ticket",
    children: [
      {
        path: "ticket",
        component: () => import("./views/app/ticket/ticket"),
      },
      {
        path: "ticketDetail",
        component: () => import("./views/app/ticket/ticketDetail"),
      },
      {
        path: "createTicket",
        component: () => import("./views/app/ticket/createTicket"),

      },
    ]
  },

  {
    path: "/web/settings/set-sec-password",
    component: () => import("./views/app/settings/set-sec-password"),
  },
  {
    path: "/web/settings/forget-password",
    component: () => import("./views/app/settings/forget-password"),
  },

  {
    path: "/web/bonus/bonusCenter",
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/bonus/bonusCenter"),
  },
  {
    path: "/web/bonus/bonusRecord",
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/bonus/bonusRecord"),
  },
  {
    path: "/web/bonus/dynamicBonusRecord",
    beforeEnter: checkSecPassword,
    component: () => import("./views/app/bonus/dynamicBonusRecord"),
  },



  // sessions
  {
    path: "/web/sessions",
    component: () => import("./views/app/sessions"),
    redirect: "/web/sessions/signIn",
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
  //   localStorage.removeItem("boostToken");

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
