(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-72b3f902"],{1148:function(t,s,a){"use strict";var e=a("5926"),i=a("577e"),o=a("1d80"),n=RangeError;t.exports=function(t){var s=i(o(this)),a="",r=e(t);if(r<0||r==1/0)throw n("Wrong number of repetitions");for(;r>0;(r>>>=1)&&(s+=s))1&r&&(a+=s);return a}},"3cbd":function(t,s,a){"use strict";a.r(s);a("b680");var e=function(){var t=this,s=t._self._c;return s("div",{staticClass:"main-content m-4"},[s("div",{},[s("b-card",{staticClass:"position-relative mb-4 text-center bg-greyblue"},[s("b-row",{staticStyle:{"margin-bottom":"10px"},attrs:{"align-h":"center"}},[s("b-col",{staticStyle:{"text-align":"left"},attrs:{cols:"6"}},[s("div",{staticClass:"mb-3 px-0"},[s("div",{staticClass:"d-flex"},[s("p",{staticClass:"text-10 font-weight-bold"},[t._v(t._s(t.$t("today_boost_profit")))])]),s("div",{staticClass:"d-flex justify-content-start align-items-end"},[s("div",[s("div",{staticClass:"d-flex align-items-end"},[s("span",{staticClass:"text-8 mr-1 mb-1 text-white"},[t._v("USDT")]),s("h5",{staticClass:"mb-0 font-weight-bold"},[t._v(t._s(parseFloat(t.today_bonus).toFixed(2)))])])])])])]),s("b-col",{staticStyle:{"text-align":"left"},attrs:{cols:"6"}},[s("div",{staticClass:"mb-3 bg-greyblue px-0"},[s("div",{staticClass:"d-flex"},[s("p",{staticClass:"text-10 font-weight-bold"},[t._v(t._s(t.$t("current_balance")))])]),s("div",{staticClass:"d-flex justify-content-start align-items-end"},[s("div",[s("div",{staticClass:"d-flex align-items-end"},[s("span",{staticClass:"text-8 mr-1 mb-0 text-white"},[t._v("USDT")]),s("h5",{staticClass:"mb-0 font-weight-bold"},[t._v(t._s(parseFloat(t.point1).toFixed(2)))])])])])])])],1),s("b-row",{staticStyle:{"margin-bottom":"10px"},attrs:{"align-h":"center"}},[s("b-col",{staticStyle:{"text-align":"left"},attrs:{cols:"6"}},[s("div",{staticClass:"mb-3 bg-greyblue px-0"},[s("div",{staticClass:"d-flex"},[s("p",{staticClass:"text-10 font-weight-bold"},[t._v(t._s(t.$t("freeze_wallet")))])]),s("div",{staticClass:"d-flex justify-content-start align-items-end"},[s("div",[s("div",{staticClass:"d-flex align-items-end"},[s("span",{staticClass:"text-8 mr-1 mb-0 text-white"},[t._v("USDT")]),s("h6",{staticClass:"mb-0 font-weight-bold"},[t._v(t._s(parseFloat(t.point2).toFixed(2)))])])])])])]),s("b-col",{staticStyle:{"text-align":"left"},attrs:{cols:"6"}},[s("div",{staticClass:"mb-3 bg-greyblue px-0"},[s("div",{staticClass:"d-flex"},[s("p",{staticClass:"text-10 font-weight-bold"},[t._v(t._s(t.$t("today_boost_time")))])]),s("div",{staticClass:"d-flex justify-content-start align-items-end"},[s("div",[s("div",{staticClass:"d-flex align-items-end"},[s("h6",{staticClass:"mb-0 font-weight-bold"},[t._v(t._s(t.today_completed_order)+" / "+t._s(t.boost_time))])])])])])])],1),s("b-row",{attrs:{"align-h":"start"}},[s("b-col",{staticStyle:{"text-align":"left"},attrs:{cols:"6"}},[s("div",{staticClass:"mb-3 bg-greyblue px-0"},[s("div",{staticClass:"d-flex"},[s("p",{staticClass:"text-10 font-weight-bold"},[t._v(t._s(t.$t("yesterday_boost_profit")))])]),s("div",{staticClass:"d-flex justify-content-start align-items-end"},[s("div",[s("div",{staticClass:"d-flex align-items-end"},[s("span",{staticClass:"text-8 mr-1 mb-0 text-white"},[t._v("USDT")]),s("h6",{staticClass:"mb-0 font-weight-bold"},[t._v(t._s(parseFloat(t.yesterday_bonus).toFixed(2)))])])])])])])],1)],1)],1),s("b-button",{staticClass:"submit_button w-100",attrs:{variant:"secondary",disabled:t.isLoading},on:{click:function(s){return t.openOtp()}}},[t.isLoading?s("span",[s("div",{staticClass:"spinner spinner-primary m-2 text-50"})]):s("span",[t._v(t._s(t.$t("start_order")))])]),s("div",{staticClass:"text-left my-4"},[s("p",[t._v(t._s(t.$t("remind")))]),s("p",{staticClass:"text-12"},[t._v(t._s(t.$t("remind_1"))),s("br"),t._v(t._s(t.$t("remind_2")))])]),s("b-modal",{attrs:{id:"modal-otp",size:"md",centered:"",title:t.$t("order_title"),"no-close-on-backdrop":!0,"no-close-on-esc":!0,"ok-title":t.$t("submit")},on:{ok:t.checkApproval,cancel:function(s){t.isLoading=!1}}},[s("b-form",{staticClass:"ml-1 mr-4"},[s("b-row",{attrs:{"align-h":"center"}},[s("b-col",{attrs:{cols:"6"}},[s("div",{staticClass:"my-auto",staticStyle:{width:"100%",height:"100%",position:"relative"}},[s("img",{staticClass:"w-100 position-absolute top-50",staticStyle:{height:"150px!important"},attrs:{src:a("9d64")}})])]),s("b-col",{attrs:{cols:"6"}},[s("b-row",{staticStyle:{"margin-bottom":"5px"},attrs:{"align-h":"center"}},[s("b-col",{staticStyle:{"text-align":"left"},attrs:{cols:"8"}},[s("div",{staticClass:"mt-2"},[s("span",{staticClass:"mt-4 font-weight-bold text-10"},[t._v(" "+t._s(t.$t("total_cost")))]),s("br")])]),s("b-col",{staticStyle:{"text-align":"right"},attrs:{cols:"4"}},[s("div",{staticClass:"mt-2"},[s("span",{staticClass:"mt-4 font-weight-bold text-12"},[t._v(" "+t._s(t.cOrder_total_cost))]),s("br")])])],1),s("b-row",{staticStyle:{"margin-bottom":"5px"},attrs:{"align-h":"center"}},[s("b-col",{staticStyle:{"text-align":"left"},attrs:{cols:"8"}},[s("div",{staticClass:"mt-2"},[s("span",{staticClass:"mt-4 font-weight-bold text-10"},[t._v(" "+t._s(t.$t("profit")))]),s("br")])]),s("b-col",{staticStyle:{"text-align":"right"},attrs:{cols:"4"}},[s("div",{staticClass:"mt-2"},[s("span",{staticClass:"mt-4 font-weight-bold text-12"},[t._v(" "+t._s(t.cOrder_profit))]),s("br")])])],1),s("b-row",{staticStyle:{"margin-bottom":"5px"},attrs:{"align-h":"center"}},[s("b-col",{staticStyle:{"text-align":"left"},attrs:{cols:"8"}},[s("div",{staticClass:"mt-2"},[s("span",{staticClass:"mt-4 font-weight-bold text-10"},[t._v(" "+t._s(t.$t("total_return")))]),s("br")])]),s("b-col",{staticStyle:{"text-align":"right"},attrs:{cols:"4"}},[s("div",{staticClass:"mt-2"},[s("span",{staticClass:"mt-4 font-weight-bold text-12"},[t._v(" "+t._s(t.cOrder_total_return))]),s("br")])])],1)],1)],1)],1)],1),s("b-modal",{attrs:{id:"modal-reload",size:"md",centered:"",title:t.$t("deposit_reminder"),"no-close-on-backdrop":!0,"no-close-on-esc":!0,"ok-title":t.$t("go_deposit")},on:{ok:t.submitreload}},[s("b-form",{staticClass:"mx-5"},[s("b-row",{attrs:{"align-h":"center"}},[s("b-col",{attrs:{md:"12 mb-30"}},[s("div",{staticStyle:{"text-align":"center"}},[s("img",{attrs:{src:a("5a39"),height:"100px"}})]),s("b-row",{staticStyle:{"margin-bottom":"5px"},attrs:{"align-h":"center"}},[s("div",{staticClass:"mt-12",staticStyle:{"text-align":"center"}},[s("span",{staticClass:"mt-4 font-weight-bold text-14",staticStyle:{"font-size":"14px"}},[t._v(t._s(t.$t("deposit_reminder2"))+" ")]),s("br"),s("span",{staticClass:"mt-4 font-weight-bold text-14",staticStyle:{"font-size":"12px"}},[t._v(t._s(t.$t("deposit_reminder3"))+" "+t._s(t.needDeposit)+" "+t._s(t.$t("deposit_reminder4")))]),s("br")])])],1)],1)],1)],1),s("Dialog",{ref:"msg"})],1)},i=[],o=a("5530"),n=(a("14d9"),a("06e0")),r=a("402a"),l=a("9565"),c=a("2f62"),d={computed:Object(o["a"])({},Object(c["c"])(["lang"])),components:{Dialog:l["a"]},data:function(){return{otp:"",email:"",timecount:60,startCount:!1,myVar:null,sending:!1,api_key:null,secret_key:null,sec_password:"",isLoading:!1,canBind:!0,price:"",today_bonus:"",yesterday_bonus:"",today_completed_order:"",boost_time:"",today_left_times:"",point1:"",point2:"",cOrder_total_cost:"",cOrder_profit:"",cOrder_total_return:"",product_id:"",public_path:"",approval:"",needDeposit:""}},props:["success"],methods:{openOtp:function(){var t=this;if(this.today_left_times>0)setTimeout((function(){t.getInfo()}),1e3),this.isLoading=!0;else{var s=this;s.$refs.msg.makeToast("warning",s.$t("today_reach_limit"))}},close:function(){this.$bvModal.hide("modal-otp")},getInfo:function(){var t=Object(n["j"])(),s=this;this.isLoading=!0,t.then((function(t){console.log(t),0==t.data.error_code?(s.$bvModal.show("modal-otp"),s.cOrder_total_cost=t.data.data.total_cost,s.cOrder_profit=t.data.data.profit,s.cOrder_total_return=t.data.data.total_return,s.product_id=t.data.data.product.id,s.public_path=t.data.data.product.public_path,s.price=t.data.data.product.price):s.$refs.msg.makeToast("danger",s.$t(t.data.message))})).catch((function(t){s.$refs.msg.makeToast("warning",s.$t(Object(r["b"])(t))),s.sending=!1}))},reload:function(){this.needDeposit=parseInt(this.cOrder_total_cost)-parseInt(this.point1),this.$bvModal.show("modal-reload")},submitreload:function(){2==this.approval||3==this.approval?this.$router.push("/web/requestDeposit"):1==this.approval?this.$router.push("/web/deposit"):0==this.approval&&(this.$bvModal.show("modal-pending"),this.getSpin())},checkApproval:function(){parseInt(this.cOrder_total_cost)>parseInt(this.point1)?(this.$bvModal.hide("modal-otp"),this.reload()):this.boost()},getSpin:function(){var t=Object(n["h"])(),s=this;t.then((function(t){s.approval=t.data.data.approval,0==s.approval?setTimeout((function(){s.getSpin()}),3e3):s.$router.push("/web/deposit"),console.log(t)})).catch((function(t){console.log(t),s.$refs.msg.makeToast("warning",s.$t(Object(r["b"])(t))),s.isLoading=!1}))},boost:function(){var t=new FormData,s=this;t.append("product_id",this.product_id);var a=Object(n["d"])(t);s.isLoading=!0,a.then((function(t){0==t.data.error_code?(s.$refs.msg.makeToast("success",s.$t("operation_success")),s.$bvModal.hide("modal-otp"),s.loadItems()):s.$refs.msg.makeToast("danger",s.checkError(t.data)),s.sending=!1,s.isLoading=!1})).catch((function(t){s.$refs.msg.makeToast("warning",s.$t(Object(r["b"])(t))),s.sending=!1,s.isLoading=!1}))},checkError:function(t){return"E00047"==t.error_code?"en"==this.$i18n.locale?"Please mine between "+t.message:"请在"+t.message+"之间挖矿":t.message},loadItems:function(){var t=Object(n["G"])(),s=this;this.isLoading=!0,t.then((function(t){console.log(t),s.today_bonus=t.data.data.today_bonus,s.yesterday_bonus=t.data.data.yesterday_bonus,s.today_completed_order=t.data.data.today_completed_order,s.today_left_times=t.data.data.today_left_times,s.boost_time=t.data.data.today_limit,s.memberInfo(),s.isLoading=!1})).catch((function(t){s.$refs.msg.makeToast("warning",s.$t(Object(r["b"])(t)))}))},memberInfo:function(){var t=Object(n["E"])(),s=this;this.isLoading=!0,t.then((function(t){s.point1=t.data.data.point1,s.point2=t.data.data.point2,s.isLoading=!1})).catch((function(t){s.$refs.msg.makeToast("warning",s.$t(Object(r["b"])(t)))}))}},created:function(){this.loadItems(),this.email=localStorage.getItem("username")}},p=d,b=a("2877"),m=Object(b["a"])(p,e,i,!1,null,null,null);s["default"]=m.exports},"5a39":function(t,s,a){t.exports=a.p+"img/no_balance.ff5858e3.png"},9565:function(t,s,a){"use strict";var e=function(){var t=this,s=t._self._c;return s("div")},i=[],o={methods:{makeToast:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,s=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(s,{variant:t,solid:!0})}},watch:{testProp:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"success",s=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(s,{variant:t,solid:!0})}}},n=o,r=a("2877"),l=Object(r["a"])(n,e,i,!1,null,null,null);s["a"]=l.exports},"9d64":function(t,s,a){t.exports=a.p+"img/logo.f318ec47.png"},b680:function(t,s,a){"use strict";var e=a("23e7"),i=a("e330"),o=a("5926"),n=a("408a"),r=a("1148"),l=a("d039"),c=RangeError,d=String,p=Math.floor,b=i(r),m=i("".slice),g=i(1..toFixed),f=function(t,s,a){return 0===s?a:s%2===1?f(t,s-1,a*t):f(t*t,s/2,a)},_=function(t){var s=0,a=t;while(a>=4096)s+=12,a/=4096;while(a>=2)s+=1,a/=2;return s},u=function(t,s,a){var e=-1,i=a;while(++e<6)i+=s*t[e],t[e]=i%1e7,i=p(i/1e7)},h=function(t,s){var a=6,e=0;while(--a>=0)e+=t[a],t[a]=p(e/s),e=e%s*1e7},v=function(t){var s=6,a="";while(--s>=0)if(""!==a||0===s||0!==t[s]){var e=d(t[s]);a=""===a?e:a+b("0",7-e.length)+e}return a},x=l((function(){return"0.000"!==g(8e-5,3)||"1"!==g(.9,0)||"1.25"!==g(1.255,2)||"1000000000000000128"!==g(0xde0b6b3a7640080,0)}))||!l((function(){g({})}));e({target:"Number",proto:!0,forced:x},{toFixed:function(t){var s,a,e,i,r=n(this),l=o(t),p=[0,0,0,0,0,0],g="",x="0";if(l<0||l>20)throw c("Incorrect fraction digits");if(r!=r)return"NaN";if(r<=-1e21||r>=1e21)return d(r);if(r<0&&(g="-",r=-r),r>1e-21)if(s=_(r*f(2,69,1))-69,a=s<0?r*f(2,-s,1):r/f(2,s,1),a*=4503599627370496,s=52-s,s>0){u(p,0,a),e=l;while(e>=7)u(p,1e7,0),e-=7;u(p,f(10,e,1),0),e=s-1;while(e>=23)h(p,1<<23),e-=23;h(p,1<<e),u(p,1,1),h(p,2),x=v(p)}else u(p,0,a),u(p,1<<-s,0),x=v(p)+b("0",l);return l>0?(i=x.length,x=g+(i<=l?"0."+b("0",l-i)+x:m(x,0,i-l)+"."+m(x,i-l))):x=g+x,x}})}}]);
//# sourceMappingURL=chunk-72b3f902.e7c5b440.js.map