(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-32a7b868"],{"0e2f":function(t,e,a){t.exports=a.p+"img/Solid.f3502ba4.svg"},1148:function(t,e,a){"use strict";var s=a("5926"),i=a("577e"),n=a("1d80"),r=RangeError;t.exports=function(t){var e=i(n(this)),a="",c=s(t);if(c<0||c==1/0)throw r("Wrong number of repetitions");for(;c>0;(c>>>=1)&&(e+=e))1&c&&(a+=e);return a}},1968:function(t,e,a){t.exports=a.p+"img/deposit.dcb1fae6.svg"},"42b4":function(t,e,a){t.exports=a.p+"img/plus (1).d6c5db07.svg"},"46a9":function(t,e,a){"use strict";a("14d9"),a("b680");var s=function(){var t=this,e=t._self._c;return e("div",{staticClass:"d-flex flex-column flex-grow-1",staticStyle:{overflow:"hidden"}},[e("b-row",{staticClass:"mt-3 mb-2 font-weight-bold"},[e("b-col",{attrs:{cols:"5"}},[e("span",{staticClass:"text-10"},[t._v(t._s(t.$t("coin")))])]),e("b-col",{attrs:{cols:"4"}},[e("span",{staticClass:"text-10"},[t._v(t._s(t.$t("price")))])]),e("b-col",{attrs:{cols:"3"}},[e("span",{staticClass:"text-10"},[t._v(t._s(t.$t("24H_change")))])])],1),e("div",{staticClass:"flex-grow-1 cursor-pointer",staticStyle:{overflow:"hidden scroll"}},t._l(t.coinList,(function(a){return e("b-row",{key:a.id,staticClass:"mb-4",on:{click:function(e){return t.$router.push("/web/trade/tradeChart?type="+a.market)}}},[e("b-col",{attrs:{cols:"5"}},[e("span",{staticClass:"text-14 text-white"},[t._v(t._s(a.market_name))])]),e("b-col",{attrs:{cols:"4"}},[e("span",{staticClass:"text-14 text-white"},[t._v(t._s(parseFloat(a.price).toFixed(4)))])]),e("b-col",{attrs:{cols:"3"}},[e("b-badge",{staticClass:"text-14 text-white",attrs:{variant:a.change>0?"success":"danger"}},[t._v(t._s((a.change>0?"+":" ")+parseFloat(a.change).toFixed(2))+"%")])],1)],1)})),1)],1)},i=[],n=(a("a434"),a("e9c4"),a("06e0")),r=a("402a"),c={props:["isHome"],data:function(){return{coinList:[],isDestroyed:!1,timer:null}},methods:{marketInfo:function(){var t=Object(n["S"])(),e=this;t.then((function(t){for(var a=0;a<t.data.data.trade_market.length;a++){if(!(a<6))break;4==a&&console.log(t.data.data.trade_market[4]["price"])}e.coinList=t.data.data.trade_market,e.isHome&&e.coinList.splice(6);for(var s=[],i=0;i<t.data.data.trade_market.length;i++){var n={};n["value"]=t.data.data.trade_market[i].market,n["text"]=t.data.data.trade_market[i].market,n["price"]=t.data.data.trade_market[i].price,n["id"]=t.data.data.trade_market[i].id,s.push(n)}localStorage.setItem("market",JSON.stringify(s)),e.timer=setTimeout((function(){e.marketInfo()}),1e3)})).catch((function(t){e.$refs.msg.makeToast("warning",e.$t(Object(r["b"])(t)))}))}},created:function(){this.marketInfo()},beforeDestroy:function(){clearTimeout(this.timer)}},o=c,l=a("2877"),u=Object(l["a"])(o,s,i,!1,null,null,null);e["a"]=u.exports},"616e":function(t,e,a){"use strict";a("ccd1")},9565:function(t,e,a){"use strict";var s=function(){var t=this,e=t._self._c;return e("div")},i=[],n={methods:{makeToast:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,e=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(e,{variant:t,solid:!0})}},watch:{testProp:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"success",e=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(e,{variant:t,solid:!0})}}},r=n,c=a("2877"),o=Object(c["a"])(r,s,i,!1,null,null,null);e["a"]=o.exports},a426:function(t,e,a){"use strict";a.r(e);a("14d9");var s=function(){var t=this,e=t._self._c;return e("div",{staticClass:"main-content homepage2 flex-grow-1 d-flex flex-column pb-5",staticStyle:{height:"100vh"}},[e("div",{staticClass:"secondPart flex-grow-1 d-flex flex-column"},[e("b-card",{staticClass:"mb-3"},[e("div",{staticClass:"d-flex mb-5"},[e("div",{staticClass:"avatar-circle",style:{backgroundImage:"url("+"/images/level1/".concat(t.currentPackage.toLowerCase(),".png")+")"}}),e("h4",{staticClass:"font-weight-bold ml-3"},[t._v(t._s(t.username))])]),e("div",{staticClass:"d-flex justify-content-between align-items-end"},[e("div",{staticClass:"ml-3"},[e("img",{attrs:{src:a("42b4"),alt:""},on:{click:function(e){return t.$router.push("/web/deposit")}}})]),e("div",[e("div",{staticClass:"d-flex align-items-end"},[e("span",{staticClass:"text-12 mr-2 text-white"},[t._v("USDT")]),e("div",[e("label",{staticClass:"mb-1"},[t._v(t._s(t.$t("assets")))]),e("h3",{staticClass:"mb-0 font-weight-bold"},[t._v(t._s(t.info.point1))])])])])])]),e("b-row",{},[e("b-col",{attrs:{cols:"4"}},[e("b-link",{staticClass:"btn",attrs:{to:"/web/deposit"}},[e("span",{staticClass:"mb-5 text-white"},[t._v(t._s(t.$t("deposit")))]),e("div",{staticClass:"d-flex justify-content-between align-items-center w-100 mt-3"},[e("i",{staticClass:"fa fa-arrow-right"}),e("span",{staticClass:"text-24 mb-2"},[e("img",{attrs:{src:a("1968"),alt:""}})])])])],1),e("b-col",{attrs:{cols:"4"}},[e("b-link",{staticClass:"btn",attrs:{to:"/web/withdraw"}},[e("span",{staticClass:"mb-5 text-white"},[t._v(t._s(t.$t("withdraw")))]),e("div",{staticClass:"d-flex justify-content-between align-items-center w-100 mt-3"},[e("i",{staticClass:"fa fa-arrow-right"}),e("span",{staticClass:"text-24 mb-2"},[e("img",{attrs:{src:a("0e2f"),alt:""}})])])])],1),e("b-col",{attrs:{cols:"4"}},[e("b-link",{staticClass:"btn",attrs:{to:"/web/ticket/createTicket"}},[e("span",{staticClass:"mb-5 text-white"},[t._v(t._s(t.$t("contact_service")))]),e("div",{staticClass:"d-flex justify-content-between align-items-center w-100 mt-3"},[e("i",{staticClass:"fa fa-arrow-right"}),e("span",{staticClass:"text-24 mb-2"},[e("img",{attrs:{src:a("bb79"),alt:""}})])])])],1)],1),e("Market",{attrs:{isHome:!0}}),e("p",{staticClass:"text-center text-16 cursor-pointer",staticStyle:{height:"100px"},on:{click:function(e){return t.$router.push("/web/trade/tradeList")}}},[t._v(t._s(t.$t("more"))+" "),t._m(0)])],1),e("Dialog",{ref:"msg"})],1)},i=[function(){var t=this,e=t._self._c;return e("span",[e("img",{attrs:{src:a("eb10"),alt:""}})])}],n=a("5530"),r=a("2f62"),c=a("9565"),o=a("46a9"),l={computed:Object(n["a"])({},Object(r["c"])(["lang"])),components:{Dialog:c["a"],Market:o["a"]},data:function(){return{tabIndex:0,language:"",username:"",currentPackage:"",info:null,coinList:[]}},props:["success"],methods:{onSearch:function(){this.pageNumber=1,""==this.from&&""==this.to||(this.canClear=!0),this.loadItems()},onCancel:function(){this.from="",this.to="",this.canClear=!1,this.loadItems()},changeIndex:function(t){this.tabIndex=t},loadItems:function(){this.username=localStorage.getItem("web_username"),this.info=JSON.parse(localStorage.getItem("info")),this.currentPackage=this.info.package.package_name_en}},created:function(){this.loadItems()}},u=l,d=(a("616e"),a("2877")),f=Object(d["a"])(u,s,i,!1,null,null,null);e["default"]=f.exports},b680:function(t,e,a){"use strict";var s=a("23e7"),i=a("e330"),n=a("5926"),r=a("408a"),c=a("1148"),o=a("d039"),l=RangeError,u=String,d=Math.floor,f=i(c),m=i("".slice),h=i(1..toFixed),b=function(t,e,a){return 0===e?a:e%2===1?b(t,e-1,a*t):b(t*t,e/2,a)},g=function(t){var e=0,a=t;while(a>=4096)e+=12,a/=4096;while(a>=2)e+=1,a/=2;return e},v=function(t,e,a){var s=-1,i=a;while(++s<6)i+=e*t[s],t[s]=i%1e7,i=d(i/1e7)},p=function(t,e){var a=6,s=0;while(--a>=0)s+=t[a],t[a]=d(s/e),s=s%e*1e7},w=function(t){var e=6,a="";while(--e>=0)if(""!==a||0===e||0!==t[e]){var s=u(t[e]);a=""===a?s:a+f("0",7-s.length)+s}return a},x=o((function(){return"0.000"!==h(8e-5,3)||"1"!==h(.9,0)||"1.25"!==h(1.255,2)||"1000000000000000128"!==h(0xde0b6b3a7640080,0)}))||!o((function(){h({})}));s({target:"Number",proto:!0,forced:x},{toFixed:function(t){var e,a,s,i,c=r(this),o=n(t),d=[0,0,0,0,0,0],h="",x="0";if(o<0||o>20)throw l("Incorrect fraction digits");if(c!=c)return"NaN";if(c<=-1e21||c>=1e21)return u(c);if(c<0&&(h="-",c=-c),c>1e-21)if(e=g(c*b(2,69,1))-69,a=e<0?c*b(2,-e,1):c/b(2,e,1),a*=4503599627370496,e=52-e,e>0){v(d,0,a),s=o;while(s>=7)v(d,1e7,0),s-=7;v(d,b(10,s,1),0),s=e-1;while(s>=23)p(d,1<<23),s-=23;p(d,1<<s),v(d,1,1),p(d,2),x=w(d)}else v(d,0,a),v(d,1<<-e,0),x=w(d)+f("0",o);return o>0?(i=x.length,x=h+(i<=o?"0."+f("0",o-i)+x:m(x,0,i-o)+"."+m(x,i-o))):x=h+x,x}})},bb79:function(t,e,a){t.exports=a.p+"img/Layer 2.6a950080.svg"},ccd1:function(t,e,a){},eb10:function(t,e,a){t.exports=a.p+"img/right-arrow (5).bcf439af.svg"}}]);
//# sourceMappingURL=chunk-32a7b868.6c94c8de.js.map