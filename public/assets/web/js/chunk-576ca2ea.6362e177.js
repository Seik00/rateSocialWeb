(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-576ca2ea"],{"0968":function(t,s,a){t.exports=a.p+"img/currency.1b215774.svg"},"0e2f":function(t,s,a){t.exports=a.p+"img/Solid.f3502ba4.svg"},1968:function(t,s,a){t.exports=a.p+"img/deposit.dcb1fae6.svg"},"1e1a":function(t,s,a){t.exports=a.p+"img/paper.2e83a1d3.svg"},"221f":function(t,s,a){},3606:function(t,s,a){t.exports=a.p+"img/ticket (3).d194d1a4.svg"},"36a7":function(t,s,a){t.exports=a.p+"img/transaction.4b68a333.svg"},"62ec":function(t,s,a){t.exports=a.p+"img/setting.a902dee7.svg"},9565:function(t,s,a){"use strict";var e=function(){var t=this,s=t._self._c;return s("div")},i=[],o={methods:{makeToast:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,s=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(s,{variant:t,solid:!0})}},watch:{testProp:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"success",s=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(s,{variant:t,solid:!0})}}},n=o,c=a("2877"),l=Object(c["a"])(n,e,i,!1,null,null,null);s["a"]=l.exports},"9d64":function(t,s,a){t.exports=a.p+"img/logo.f318ec47.png"},bb79:function(t,s,a){t.exports=a.p+"img/Layer 2.6a950080.svg"},cb2e:function(t,s,a){t.exports=a.p+"img/logo.0f0bba86.png"},d25d:function(t,s,a){"use strict";a.r(s);var e=function(){var t=this,s=t._self._c;return s("div",{staticClass:"main-content",staticStyle:{"padding-bottom":"15vh"}},[s("div",{staticClass:"appBar"},[s("span",[t._v(t._s(t.$t("profile")))])]),s("div",{staticStyle:{padding:"5px 20px"}},[s("b-card",{staticClass:"mb-3 bg-greyblue"},[s("div",{staticClass:"d-flex"},[s("div",{staticClass:"avatar-circle big",style:{backgroundImage:"url("+"/images/level1/".concat(t.currentPackage.toLowerCase(),".png")+")"}}),s("div",{staticClass:"text-left ml-3 flex-grow-1"},[s("h5",{staticClass:"font-weight-bold mb-0"},[t._v(t._s(t.userID))]),s("p",{staticClass:"text-8 font-weight-bold mb-0"},[t._v(" "+t._s(t.$t("invi_code"))+" "),s("u",[t._v(t._s(t.ref_code))])]),s("div",{staticClass:"d-flex mt-2 justify-content-end align-items-center"},[s("div",{staticClass:"mr-2"},[s("p",{staticClass:"text-right text-8 font-weight-bold mb-1"},[t._v(" "+t._s(t.$t("current_level"))+" "),s("br"),t._v(" "),s("span",{staticClass:"text-14 text-white"},[t._v(t._s(t.currentPackage))])])])])])])]),s("b-card",{staticClass:"mb-3 bg-greyblue"},[s("h5",{staticClass:"font-weight-bold mb-2"},[t._v(t._s(t.$t("balance")))]),s("div",{staticClass:"d-flex justify-content-between align-items-end"},[s("span",{staticClass:"text-20"},[s("img",{attrs:{height:"20px",src:a("0968"),alt:""}})]),s("div",{staticClass:"d-flex align-items-end"},[s("span",{staticClass:"text-12 mb-0 mr-1"},[t._v("USDT")]),s("h3",{staticClass:"font-weight-bold mb-0"},[t._v(t._s(t.point1))])])])]),s("b-card",{staticClass:"mb-3 bg-greyblue"},[s("h5",{staticClass:"font-weight-bold mb-3"},[t._v(t._s(t.$t("assets")))]),t._l(t.assetList,(function(e){return s("div",{key:e.id},[s("img",{attrs:{src:a("9d64"),alt:"",height:"24px"},on:{error:t.imageLoadError}}),s("span",{staticClass:"mx-2 text-white"},[t._v(t._s(e.coin_name))]),s("b-row",[s("b-col",{attrs:{cols:"6"}},[s("p",{staticClass:"mb-0"},[t._v(t._s(t.$t("current_balance")))]),s("p",{staticClass:"text-white"},[t._v(t._s(e.asset_active))])]),s("b-col",{attrs:{cols:"6"}},[s("p",{staticClass:"mb-0"},[t._v(t._s(t.$t("freeze_wallet")))]),s("p",{staticClass:"text-white"},[t._v(t._s(e.asset_frozen))])])],1)],1)}))],2),s("b-card",{staticClass:"mb-3 bg-greyblue"},[s("div",{staticClass:"d-flex justify-content-between"},[s("div",[s("h5",{staticClass:"font-weight-bold mb-3"},[t._v(t._s(t.$t("level_benefit")))]),s("h6",{staticClass:"text-12 ml-2 mb-2 font-weight-bold"},[t._v(t._s(t.$t("current_level_benefit")))])])]),s("div",{staticClass:"ml-2"},[s("b-row",{staticClass:"mb-2"},[s("b-col",{attrs:{cols:"12"}},[t._v(t._s(t.$t("benefit_".concat(t.user_group_id))))])],1),5!=t.user_group_id?s("h6",{staticClass:"text-12 mb-2 font-weight-bold"},[t._v(t._s(t.$t("upLevel_hint")))]):t._e(),5!=t.user_group_id?s("b-row",{},[s("b-col",{attrs:{cols:"12"}},[s("p",{staticClass:"mb-1"},[t._v(t._s(t.$t("upLevel_hint_".concat(t.user_group_id+1))))])]),s("b-col",{attrs:{cols:"12"}},[s("div",{staticClass:"d-flex"},[s("span",{staticClass:"text-white mr-2",staticStyle:{"white-space":"nowrap"}},[t._v(t._s(t.$t("benefit")))]),t._v(t._s(t.$t("benefit_".concat(t.user_group_id+1)))+" ")])])],1):t._e()],1)]),s("b-row",{staticClass:"mb-3"},[s("b-col",{attrs:{cols:"3"}},[s("b-link",{attrs:{to:"/web/myWallet/walletRecord"}},[s("div",{staticClass:"bg-greyblue rounded px-2 pt-2"},[s("p",{staticClass:"mb-3 text-white text-8 font-weight-bold"},[t._v(t._s(t.$t("record")))]),s("div",{staticClass:"d-flex justify-content-end align-items-center w-100"},[s("span",{staticClass:"text-24 mb-0"},[s("img",{attrs:{width:"22px",src:a("36a7"),alt:""}})])])])])],1),s("b-col",{attrs:{cols:"3"}},[s("b-link",{attrs:{to:"/web/deposit"}},[s("div",{staticClass:"bg-greyblue rounded px-2 pt-2"},[s("p",{staticClass:"mb-3 text-white text-8 font-weight-bold"},[t._v(t._s(t.$t("topup")))]),s("div",{staticClass:"d-flex justify-content-end align-items-center w-100"},[s("span",{staticClass:"text-24 mb-0"},[s("img",{attrs:{width:"22px",src:a("1968"),alt:""}})])])])])],1),s("b-col",{attrs:{cols:"3"}},[s("b-link",{attrs:{to:"/web/withdraw/withdrawHistory"}},[s("div",{staticClass:"bg-greyblue rounded px-2 pt-2"},[s("p",{staticClass:"mb-3 text-white text-8 font-weight-bold"},[t._v(t._s(t.$t("withdraw")))]),s("div",{staticClass:"d-flex justify-content-end align-items-center w-100"},[s("span",{staticClass:"text-24 mb-0"},[s("img",{attrs:{width:"22px",src:a("0e2f"),alt:""}})])])])])],1),s("b-col",{attrs:{cols:"3"}},[s("b-link",{attrs:{to:"/web/me/faq"}},[s("div",{staticClass:"bg-greyblue rounded px-2 pt-2"},[s("p",{staticClass:"mb-3 text-white text-8 font-weight-bold"},[t._v(t._s(t.$t("faq")))]),s("div",{staticClass:"d-flex justify-content-end align-items-center w-100"},[s("span",{staticClass:"text-24 mb-0"},[s("img",{attrs:{width:"22px",src:a("bb79"),alt:""}})])])])])],1)],1),s("span",{staticClass:"font-weight-bold"},[t._v(t._s(t.$t("More")))]),s("b-card",{staticClass:"bg-greyblue"},[s("b-link",{attrs:{to:"/web/settings/settingCenter"}},[s("div",{staticClass:"list-box"},[s("b-row",{staticClass:"m-0",attrs:{"align-h":"start","align-v":"center"}},[s("div",{staticClass:"text-center text-18"},[s("img",{attrs:{src:a("62ec"),alt:""}})]),s("h6",{staticClass:"mb-0 mx-3 text-10 text-primary"},[t._v(" "+t._s(t.$t("settings"))+" ")]),s("i",{staticClass:"fa fa-angle-right",staticStyle:{right:"30px",position:"absolute",color:"white"}})])],1)]),s("b-link",{attrs:{to:"/web/ticket/ticket"}},[s("div",{staticClass:"list-box"},[s("b-row",{staticClass:"m-0",attrs:{"align-h":"start","align-v":"center"}},[s("div",{staticClass:"text-center text-18"},[s("img",{attrs:{src:a("3606"),alt:""}})]),s("h6",{staticClass:"mb-0 mx-3 text-10 text-primary"},[t._v(" "+t._s(t.$t("contact_service"))+" ")]),s("i",{staticClass:"fa fa-angle-right",staticStyle:{right:"30px",position:"absolute",color:"white"}})])],1)]),s("b-link",{attrs:{to:"/web/me/newsList"}},[s("div",{staticClass:"list-box"},[s("b-row",{staticClass:"m-0",attrs:{"align-h":"start","align-v":"center"}},[s("div",{staticClass:"text-center text-18"},[s("i",{staticClass:"fa fa-bullhorn",staticStyle:{width:"16px"},attrs:{"aria-hidden":"true"}})]),s("h6",{staticClass:"mb-0 mx-3 text-10 text-primary"},[t._v(" "+t._s(t.$t("news"))+" ")]),s("i",{staticClass:"fa fa-angle-right",staticStyle:{right:"30px",position:"absolute",color:"white"}})])],1)]),s("div",{staticClass:"list-box",on:{click:t.openRecord}},[s("b-row",{staticClass:"m-0",attrs:{"align-h":"start","align-v":"center"}},[s("div",{staticClass:"text-center text-18"},[s("img",{attrs:{src:a("1e1a"),alt:""}})]),s("h6",{staticClass:"mb-0 mx-3 text-10 text-primary"},[t._v(" "+t._s(t.$t("bonus_record"))+" ")]),s("i",{staticClass:"fa fa-angle-right",staticStyle:{right:"30px",position:"absolute",color:"white"}})])],1)],1),s("b-button",{staticClass:"btn bg-greyblue submit_button w-100 mt-3",on:{click:t.logoutUser}},[t._v(" "+t._s(t.$t("sign_out"))+" ")])],1),s("b-modal",{staticStyle:{"background-color":"#5f646e !important"},attrs:{id:"modal-pending",size:"md",centered:"","hide-footer":!0}},[s("b-form",{staticClass:"mx-5"},[s("b-row",{attrs:{"align-h":"center"}},[s("b-col",{attrs:{md:"12 mb-30"}},[s("b-row",{staticStyle:{"margin-bottom":"10px"},attrs:{"align-h":"center"}},[s("div",{staticClass:"spinner spinner-primary m-2 text-50"}),s("div",{staticClass:"col-sm-12"},[s("center",[s("b-button",{staticClass:"mx-auto submit_button mt-5",attrs:{variant:"outline-secondary"},on:{click:function(s){return t.close()}}},[t._v(t._s(t.$t("close")))])],1)],1)])],1)],1)],1)],1),s("Dialog",{ref:"msg"})],1)},i=[],o=a("5530"),n=(a("14d9"),a("caad"),a("2532"),a("e9c4"),a("06e0")),c=a("402a"),l=a("9565"),r=a("2f62"),d={computed:Object(o["a"])({},Object(r["c"])(["lang"])),components:{Dialog:l["a"]},data:function(){return{otp:"",email:"",isLoading:!1,userID:0,total_sponsor:"",point1:0,point2:0,user_group_id:0,ref_code:"",currentPackage:"",approval:"",dataList:[],assetList:[],notic:[],marketInfo:null,show:!1,inv_link:""}},props:["success"],methods:Object(o["a"])(Object(o["a"])({},Object(r["b"])(["signOut"])),{},{imageLoadError:function(t){t.target.src=a("cb2e")},checkApproval:function(){this.$router.push("/web/deposit")},_asset:function(){var t=Object(n["b"])(),s=this;t.then((function(t){console.log(t.data);for(var a=0;a<t.data.data.asset.length;a++)s.assetList=t.data.data.asset})).catch((function(t){s.$refs.msg.makeToast("warning",s.$t(Object(c["b"])(t)))}))},getSpin:function(){var t=Object(n["h"])(),s=this;t.then((function(t){s.approval=t.data.data.data.approval,0==s.approval?setTimeout((function(){s.getSpin()}),3e3):s.$router.push("/web/deposit"),console.log(t)})).catch((function(t){console.log(t),s.$refs.msg.makeToast("warning",s.$t(Object(c["b"])(t))),s.isLoading=!1}))},openOtp:function(){this.$bvModal.show("modal-logout")},close:function(){this.$bvModal.hide("modal-pending")},logoutUser:function(){this.signOut(),this.$router.push("/web/sessions/signIn")},openRecord:function(){this.$router.push("/web/bonus/bonusCenter")},clipboardSuccessHandler:function(){this.$refs.msg.makeToast("success",this.$t("copied"))},clipboardErrorHandler:function(){},getInfo:function(){var t=Object(n["h"])(),s=this;t.then((function(t){s.approval=t.data.data.data.approval})).catch((function(t){console.log(t),s.$refs.msg.makeToast("warning",s.$t(Object(c["b"])(t))),s.isLoading=!1}))},Notic:function(){var t=Object(n["J"])(),s=this;this.isLoading=!0,t.then((function(t){for(var a=t.data.data.data.ticket,e=0;e<a.length;e++)console.log(a[e]),s.dataList.push(a[e].user_read);s.showNotic(),s.isLoading=!1})).catch((function(t){console.log(t),s.isLoading=!1}))},showNotic:function(){this.notic=this.dataList.includes(0),1==this.notic&&(this.show=!0)},loadItems:function(){var t=Object(n["E"])(),s=this;this.isLoading=!0,s.inv_link=location.origin+"/register?ref_id=",t.then((function(t){s.userID=t.data.data.id,s.user_group_id=t.data.data.user_group_id,s.currentPackage=t.data.data.package.package_name_en,s.total_sponsor=t.data.data.total_sponsor,s.point1=t.data.data.point1,s.point2=t.data.data.point2,s.ref_code=t.data.data.ref_code,s.isLoading=!1,s.Notic(),localStorage.setItem("info",JSON.stringify(t.data.data))})).catch((function(t){s.$refs.msg.makeToast("warning",s.$t(Object(c["b"])(t)))}))}}),created:function(){this.getInfo(),this.loadItems(),this._asset(),this.email=localStorage.getItem("username")}},b=d,g=(a("e1f5"),a("2877")),u=Object(g["a"])(b,e,i,!1,null,null,null);s["default"]=u.exports},e1f5:function(t,s,a){"use strict";a("221f")}}]);
//# sourceMappingURL=chunk-576ca2ea.6362e177.js.map