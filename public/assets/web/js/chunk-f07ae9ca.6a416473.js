(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-f07ae9ca"],{"0968":function(t,a,e){t.exports=e.p+"img/currency.1b215774.svg"},1148:function(t,a,e){"use strict";var s=e("5926"),i=e("577e"),n=e("1d80"),o=RangeError;t.exports=function(t){var a=i(n(this)),e="",l=s(t);if(l<0||l==1/0)throw o("Wrong number of repetitions");for(;l>0;(l>>>=1)&&(a+=a))1&l&&(e+=a);return e}},"5b84":function(t,a,e){},"5fe9":function(t,a,e){"use strict";e.r(a);e("b680");var s=function(){var t=this,a=t._self._c;return a("div",{staticClass:"main-content d-flex flex-column flex-grow-1 mx-3"},[a("div",{staticClass:"appBar"},[a("span",[t._v(t._s(t.$t("record")))])]),a("b-row",{staticStyle:{"margin-bottom":"10px"},attrs:{"align-h":"center"}},[a("b-col",{staticStyle:{"text-align":"left"},attrs:{cols:"6"}},[a("b-card",{staticClass:"mb-3 bg-greyblue px-0"},[a("div",{staticClass:"d-flex"},[a("p",{staticClass:"text-10 font-weight-bold mb-0"},[t._v(t._s(t.$t("today_income")))])]),a("img",{attrs:{src:e("0968"),alt:""}}),a("div",{staticClass:"d-flex justify-content-end align-items-end mt-3"},[a("div",[a("div",{staticClass:"d-flex align-items-end"},[a("span",{staticClass:"text-8 mr-1 mb-1 text-white"},[t._v("USDT")]),a("h6",{staticClass:"mb-0 font-weight-bold"},[t._v(t._s(parseFloat(t.today_bonus).toFixed(2)))])])])])])],1),a("b-col",{staticStyle:{"text-align":"left"},attrs:{cols:"6"}},[a("b-card",{staticClass:"mb-3 bg-greyblue px-0"},[a("div",{staticClass:"d-flex"},[a("p",{staticClass:"text-10 font-weight-bold mb-0"},[t._v(t._s(t.$t("total_income")))])]),a("img",{attrs:{src:e("0968"),alt:""}}),a("div",{staticClass:"d-flex justify-content-end align-items-end mt-3"},[a("div",[a("div",{staticClass:"d-flex align-items-end"},[a("span",{staticClass:"text-8 mr-1 mb-0 text-white"},[t._v("USDT")]),a("h6",{staticClass:"mb-0 font-weight-bold"},[t._v(t._s(parseFloat(t.info.total_income).toFixed(2)))])])])])])],1)],1),a("div",{staticClass:"d-flex flex-column flex-grow-1",staticStyle:{"overflow-y":"scroll",height:"5px"}},[t.currentPage>t.lastPage&&0==t.dataList.length?a("div",{staticStyle:{position:"absolute",top:"50%",left:"50%",transform:"translate(-50%, -50%)"}},[a("p",[t._v("No Data")])]):t._e(),t._l(t.dataList,(function(e){return a("div",{key:e.id,staticClass:"bg-greyblue px-4 py-2 mb-3 font-weight-600",staticStyle:{"border-radius":"10px"}},[a("b-row",{attrs:{"align-v":"center","align-h":"between"}},[a("b-col",{attrs:{cols:"10"}},[a("p",{staticClass:"mb-1 text-white"},[t._v(t._s("zh"==t.$i18n.locale?e.detail:e.detailen))])]),a("b-col",{attrs:{cols:"2"}})],1),a("b-row",{attrs:{"align-v":"center","align-h":"between"}},[a("b-col",{attrs:{cols:"6"}},[a("p",{staticClass:"mb-1 text-muted"},[t._v(t._s(t.$t("previous_balance")))])]),a("b-col",{attrs:{cols:"5"}},[a("span",{staticClass:"text-white text-right d-block"},[t._v(t._s(e.previous))])])],1),a("b-row",{attrs:{"align-v":"center","align-h":"between"}},[a("b-col",{attrs:{cols:"6"}},[a("p",{staticClass:"mb-1 text-muted"},[t._v(t._s(t.$t("change")))])]),a("b-col",{attrs:{cols:"5"}},[a("span",{staticClass:"text-white text-right d-block"},[t._v(t._s(e.action)+t._s(e.found))])])],1),a("b-row",{attrs:{"align-v":"center","align-h":"between"}},[a("b-col",{attrs:{cols:"6"}},[a("p",{staticClass:"mb-1 text-muted"},[t._v(t._s(t.$t("current_balance")))])]),a("b-col",{attrs:{cols:"5"}},[a("span",{staticClass:"text-white text-right d-block"},[t._v(t._s(e.current))])])],1)],1)})),t.currentPage<=t.lastPage?a("b-button",{staticClass:"mx-auto submit_button mb-5",attrs:{variant:"outline-secondary"},on:{click:t.loadItems}},[t._v(t._s(t.isLoading?t.$t("loading..."):t.$t("load_more")))]):t._e()],2),a("div",{staticStyle:{height:"100px"}}),a("Dialog",{ref:"msg"})],1)},i=[],n=e("5530"),o=(e("14d9"),e("06e0")),l=e("402a"),r=e("9565"),c=e("2f62"),d={computed:Object(n["a"])({},Object(c["c"])(["lang"])),components:{Dialog:r["a"]},data:function(){return{isLoading:!0,point1:[],dataList:[],canClear:!1,wallet:"point1",wallet2:"point2",totalRecords:0,today_bonus:0,pageNumber:1,message:"",stock:"",money:"",status:!0,balance:"",currentPage:1,lastPage:1,info:null}},props:["success"],methods:{clipboardSuccessHandler:function(t){var a=t.value;this.$bvToast.toast(a,{title:this.$t("copied"),variant:"success",solid:!0})},clipboardErrorHandler:function(){},onPageChange:function(t){this.pageNumber=t.currentPage,this.loadItems(this.wallet);var a=this.$el.querySelector("#table"),e=a.offsetTop;window.scrollTo(0,e)},onSearch:function(){this.pageNumber=1,this.loadItems(this.wallet)},onCancel:function(){this.canClear=!1,this.loadItems(this.wallet)},getInfo:function(){var t=Object(o["E"])(),a=this;this.isLoading=!0,t.then((function(t){a.balance=t.data.point1,a.isLoading=!1})).catch((function(t){a.isLoading=!1,a.$refs.msg.makeToast("warning",a.$t(Object(l["b"])(t)))}))},orderInfo:function(){var t=Object(o["G"])(),a=this;this.isLoading=!0,t.then((function(t){console.log(t),a.today_bonus=t.data.data.today_bonus,a.isLoading=!1})).catch((function(t){a.$refs.msg.makeToast("warning",a.$t(Object(l["b"])(t)))}))},loadItems:function(){var t=Object(o["O"])(this.wallet,this.currentPage),a=this;this.isLoading=!0,t.then((function(t){var e=t.data.data.record.data;console.log(t.data.data.record.data),a.currentPage+=1,a.lastPage=t.data.data.record.last_page;for(var s=0;s<e.length;s++)a.dataList.push(e[s]);a.isLoading=!1})).catch((function(t){a.isLoading=!1,a.$refs.msg.makeToast("warning",a.$t(Object(l["b"])(t)))}))}},created:function(){this.info=JSON.parse(localStorage.getItem("info")),this.loadItems(),this.orderInfo()}},u=d,b=(e("b4e1"),e("2877")),g=Object(b["a"])(u,s,i,!1,null,null,null);a["default"]=g.exports},9565:function(t,a,e){"use strict";var s=function(){var t=this,a=t._self._c;return a("div")},i=[],n={methods:{makeToast:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,a=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(a,{variant:t,solid:!0})}},watch:{testProp:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"success",a=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(a,{variant:t,solid:!0})}}},o=n,l=e("2877"),r=Object(l["a"])(o,s,i,!1,null,null,null);a["a"]=r.exports},b4e1:function(t,a,e){"use strict";e("5b84")},b680:function(t,a,e){"use strict";var s=e("23e7"),i=e("e330"),n=e("5926"),o=e("408a"),l=e("1148"),r=e("d039"),c=RangeError,d=String,u=Math.floor,b=i(l),g=i("".slice),f=i(1..toFixed),h=function(t,a,e){return 0===a?e:a%2===1?h(t,a-1,e*t):h(t*t,a/2,e)},v=function(t){var a=0,e=t;while(e>=4096)a+=12,e/=4096;while(e>=2)a+=1,e/=2;return a},m=function(t,a,e){var s=-1,i=e;while(++s<6)i+=a*t[s],t[s]=i%1e7,i=u(i/1e7)},p=function(t,a){var e=6,s=0;while(--e>=0)s+=t[e],t[e]=u(s/a),s=s%a*1e7},w=function(t){var a=6,e="";while(--a>=0)if(""!==e||0===a||0!==t[a]){var s=d(t[a]);e=""===e?s:e+b("0",7-s.length)+s}return e},_=r((function(){return"0.000"!==f(8e-5,3)||"1"!==f(.9,0)||"1.25"!==f(1.255,2)||"1000000000000000128"!==f(0xde0b6b3a7640080,0)}))||!r((function(){f({})}));s({target:"Number",proto:!0,forced:_},{toFixed:function(t){var a,e,s,i,l=o(this),r=n(t),u=[0,0,0,0,0,0],f="",_="0";if(r<0||r>20)throw c("Incorrect fraction digits");if(l!=l)return"NaN";if(l<=-1e21||l>=1e21)return d(l);if(l<0&&(f="-",l=-l),l>1e-21)if(a=v(l*h(2,69,1))-69,e=a<0?l*h(2,-a,1):l/h(2,a,1),e*=4503599627370496,a=52-a,a>0){m(u,0,e),s=r;while(s>=7)m(u,1e7,0),s-=7;m(u,h(10,s,1),0),s=a-1;while(s>=23)p(u,1<<23),s-=23;p(u,1<<s),m(u,1,1),p(u,2),_=w(u)}else m(u,0,e),m(u,1<<-a,0),_=w(u)+b("0",r);return r>0?(i=_.length,_=f+(i<=r?"0."+b("0",r-i)+_:g(_,0,i-r)+"."+g(_,i-r))):_=f+_,_}})}}]);
//# sourceMappingURL=chunk-f07ae9ca.6a416473.js.map