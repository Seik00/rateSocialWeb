(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-6dccfaa0"],{"0cb2":function(t,r,e){var o=e("e330"),a=e("7b0b"),i=Math.floor,s=o("".charAt),n=o("".replace),l=o("".slice),c=/\$([$&'`]|\d{1,2}|<[^>]*>)/g,u=/\$([$&'`]|\d{1,2})/g;t.exports=function(t,r,e,o,f,b){var p=e+t.length,d=o.length,m=u;return void 0!==f&&(f=a(f),m=c),n(b,m,(function(a,n){var c;switch(s(n,0)){case"$":return"$";case"&":return t;case"`":return l(r,0,e);case"'":return l(r,p);case"<":c=f[l(n,1,-1)];break;default:var u=+n;if(0===u)return a;if(u>d){var b=i(u/10);return 0===b?a:b<=d?void 0===o[b-1]?s(n,1):o[b-1]+s(n,1):a}c=o[u-1]}return void 0===c?"":c}))}},"107c":function(t,r,e){var o=e("d039"),a=e("da84"),i=a.RegExp;t.exports=o((function(){var t=i("(?<a>b)","g");return"b"!==t.exec("b").groups.a||"bc"!=="b".replace(t,"$<a>c")}))},"14c3":function(t,r,e){var o=e("c65b"),a=e("825a"),i=e("1626"),s=e("c6b6"),n=e("9263"),l=TypeError;t.exports=function(t,r){var e=t.exec;if(i(e)){var c=o(e,t,r);return null!==c&&a(c),c}if("RegExp"===s(t))return o(n,t,r);throw l("RegExp#exec called on incompatible receiver")}},5319:function(t,r,e){"use strict";var o=e("2ba4"),a=e("c65b"),i=e("e330"),s=e("d784"),n=e("d039"),l=e("825a"),c=e("1626"),u=e("7234"),f=e("5926"),b=e("50c4"),p=e("577e"),d=e("1d80"),m=e("8aa5"),_=e("dc4a"),v=e("0cb2"),g=e("14c3"),y=e("b622"),h=y("replace"),k=Math.max,x=Math.min,$=i([].concat),C=i([].push),w=i("".indexOf),I=i("".slice),q=function(t){return void 0===t?t:String(t)},A=function(){return"$0"==="a".replace(/./,"$0")}(),M=function(){return!!/./[h]&&""===/./[h]("a","$0")}(),O=!n((function(){var t=/./;return t.exec=function(){var t=[];return t.groups={a:"7"},t},"7"!=="".replace(t,"$<a>")}));s("replace",(function(t,r,e){var i=M?"$":"$0";return[function(t,e){var o=d(this),i=u(t)?void 0:_(t,h);return i?a(i,t,o,e):a(r,p(o),t,e)},function(t,a){var s=l(this),n=p(t);if("string"==typeof a&&-1===w(a,i)&&-1===w(a,"$<")){var u=e(r,s,n,a);if(u.done)return u.value}var d=c(a);d||(a=p(a));var _=s.global;if(_){var y=s.unicode;s.lastIndex=0}var h=[];while(1){var A=g(s,n);if(null===A)break;if(C(h,A),!_)break;var M=p(A[0]);""===M&&(s.lastIndex=m(n,b(s.lastIndex),y))}for(var O="",D=0,S=0;S<h.length;S++){A=h[S];for(var E=p(A[0]),R=k(x(f(A.index),n.length),0),L=[],j=1;j<A.length;j++)C(L,q(A[j]));var N=A.groups;if(d){var T=$([E],L,R,n);void 0!==N&&C(T,N);var P=p(o(a,void 0,T))}else P=v(E,n,R,L,N,a);R>=D&&(O+=I(n,D,R)+P,D=R+E.length)}return O+I(n,D)}]}),!O||!A||M)},"8aa5":function(t,r,e){"use strict";var o=e("6547").charAt;t.exports=function(t,r,e){return r+(e?o(t,r).length:1)}},9263:function(t,r,e){"use strict";var o=e("c65b"),a=e("e330"),i=e("577e"),s=e("ad6d"),n=e("9f7f"),l=e("5692"),c=e("7c73"),u=e("69f3").get,f=e("fce3"),b=e("107c"),p=l("native-string-replace",String.prototype.replace),d=RegExp.prototype.exec,m=d,_=a("".charAt),v=a("".indexOf),g=a("".replace),y=a("".slice),h=function(){var t=/a/,r=/b*/g;return o(d,t,"a"),o(d,r,"a"),0!==t.lastIndex||0!==r.lastIndex}(),k=n.BROKEN_CARET,x=void 0!==/()??/.exec("")[1],$=h||x||k||f||b;$&&(m=function(t){var r,e,a,n,l,f,b,$=this,C=u($),w=i(t),I=C.raw;if(I)return I.lastIndex=$.lastIndex,r=o(m,I,w),$.lastIndex=I.lastIndex,r;var q=C.groups,A=k&&$.sticky,M=o(s,$),O=$.source,D=0,S=w;if(A&&(M=g(M,"y",""),-1===v(M,"g")&&(M+="g"),S=y(w,$.lastIndex),$.lastIndex>0&&(!$.multiline||$.multiline&&"\n"!==_(w,$.lastIndex-1))&&(O="(?: "+O+")",S=" "+S,D++),e=new RegExp("^(?:"+O+")",M)),x&&(e=new RegExp("^"+O+"$(?!\\s)",M)),h&&(a=$.lastIndex),n=o(d,A?e:$,S),A?n?(n.input=y(n.input,D),n[0]=y(n[0],D),n.index=$.lastIndex,$.lastIndex+=n[0].length):$.lastIndex=0:h&&n&&($.lastIndex=$.global?n.index+n[0].length:a),x&&n&&n.length>1&&o(p,n[0],e,(function(){for(l=1;l<arguments.length-2;l++)void 0===arguments[l]&&(n[l]=void 0)})),n&&q)for(n.groups=f=c(null),l=0;l<q.length;l++)b=q[l],f[b[0]]=n[b[1]];return n}),t.exports=m},9565:function(t,r,e){"use strict";var o=function(){var t=this,r=t._self._c;return r("div")},a=[],i={methods:{makeToast:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,r=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(r,{variant:t,solid:!0})}},watch:{testProp:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"success",r=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(r,{variant:t,solid:!0})}}},s=i,n=e("2877"),l=Object(n["a"])(s,o,a,!1,null,null,null);r["a"]=l.exports},"99af":function(t,r,e){"use strict";var o=e("23e7"),a=e("d039"),i=e("e8b5"),s=e("861d"),n=e("7b0b"),l=e("07fa"),c=e("3511"),u=e("8418"),f=e("65f0"),b=e("1dde"),p=e("b622"),d=e("2d00"),m=p("isConcatSpreadable"),_=d>=51||!a((function(){var t=[];return t[m]=!1,t.concat()[0]!==t})),v=function(t){if(!s(t))return!1;var r=t[m];return void 0!==r?!!r:i(t)},g=!_||!b("concat");o({target:"Array",proto:!0,arity:1,forced:g},{concat:function(t){var r,e,o,a,i,s=n(this),b=f(s,0),p=0;for(r=-1,o=arguments.length;r<o;r++)if(i=-1===r?s:arguments[r],v(i))for(a=l(i),c(p+a),e=0;e<a;e++,p++)e in i&&u(b,p,i[e]);else c(p+1),u(b,p++,i);return b.length=p,b}})},"9f7f":function(t,r,e){var o=e("d039"),a=e("da84"),i=a.RegExp,s=o((function(){var t=i("a","y");return t.lastIndex=2,null!=t.exec("abcd")})),n=s||o((function(){return!i("a","y").sticky})),l=s||o((function(){var t=i("^r","gy");return t.lastIndex=2,null!=t.exec("str")}));t.exports={BROKEN_CARET:l,MISSED_STICKY:n,UNSUPPORTED_Y:s}},ac1f:function(t,r,e){"use strict";var o=e("23e7"),a=e("9263");o({target:"RegExp",proto:!0,forced:/./.exec!==a},{exec:a})},ac32:function(t,r,e){"use strict";e.r(r);e("99af"),e("fb6a");var o=function(){var t=this,r=t._self._c;return r("div",{},[r("div",{staticStyle:{position:"relative"}},[t.isLoading?r("div",{staticStyle:{position:"absolute","background-color":"rgba(211, 211, 211, 0.2)",height:"100%",width:"100%","z-index":"3",display:"flex","justify-content":"center","align-items":"center"}},[r("span",{staticStyle:{"background-color":"#c0dfff",color:"#409eff",padding:"7px 30px","border-radius":"3px"}},[t._v(t._s(t.$t("loading...")))])]):t._e(),r("b-button",{staticClass:"mb-4",attrs:{type:"button",variant:"outline-primary"},on:{click:t.backpage}},[r("i",{staticClass:"dd-arrow i-Arrow-Left"})]),r("b-tabs",{attrs:{pills:"",align:"start"}},[r("b-tab",{attrs:{"no-body":"",title:t.$t("radical"),active:""},on:{click:t.radical}},[r("b-row",{attrs:{"align-h":"center"},on:{submit:t.postData}},[r("b-col",{staticClass:"p-0",attrs:{md:"5"}},[r("b-card",[r("b-form",[r("b-form-group",{attrs:{id:"input-group-1",label:t.$t("gas"),"label-for":"input-1"}},[r("b-form-input",{attrs:{id:"input-1",type:"text",readonly:"",required:""},model:{value:t.balance,callback:function(r){t.balance=r},expression:"balance"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("first_buy_in_amount"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:""},model:{value:t.form.first_order_value,callback:function(r){t.$set(t.form,"first_order_value",r)},expression:"form.first_order_value"}})],1),r("b-row",{staticClass:"form-group",attrs:{"align-h":"between"}},[r("b-col",{attrs:{cols:"8"}},[r("label",{staticClass:"col-form-label",attrs:{for:"first_order_double"}},[t._v(t._s(t.$t("first_order_double")))])]),r("b-col",{staticClass:"py-2",attrs:{cols:"4"}},[r("label",{staticClass:"switch switch-primary mr-3"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.form.first_order_double,expression:"form.first_order_double"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.form.first_order_double)?t._i(t.form.first_order_double,null)>-1:t.form.first_order_double},on:{change:function(r){var e=t.form.first_order_double,o=r.target,a=!!o.checked;if(Array.isArray(e)){var i=null,s=t._i(e,i);o.checked?s<0&&t.$set(t.form,"first_order_double",e.concat([i])):s>-1&&t.$set(t.form,"first_order_double",e.slice(0,s).concat(e.slice(s+1)))}else t.$set(t.form,"first_order_double",a)}}}),r("span",{staticClass:"slider"})])])],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("numbers_of_cover_up"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:""},on:{change:t.setMarginConfig},model:{value:t.form.max_order_count,callback:function(r){t.$set(t.form,"max_order_count",r)},expression:"form.max_order_count"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("take_profit_ratio"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:"",step:"any"},model:{value:t.form.stop_profit_rate,callback:function(r){t.$set(t.form,"stop_profit_rate",r)},expression:"form.stop_profit_rate"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("earnings_callback"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",step:"any",required:""},model:{value:t.form.stop_profit_callback_rate,callback:function(r){t.$set(t.form,"stop_profit_callback_rate",r)},expression:"form.stop_profit_callback_rate"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("margin_call_drop"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:""},on:{change:t.setMarginConfig},model:{value:t.form.cover_rate,callback:function(r){t.$set(t.form,"cover_rate",r)},expression:"form.cover_rate"}})],1),r("b-button",{staticClass:"form-control py-1 px-2 my-3",attrs:{block:"",type:"button"},on:{click:function(r){return t.openModal()}}},[t._v(t._s(t.$t("margin_call_setting"))+" ")]),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("buy_in_callback"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",step:"any",required:""},model:{value:t.form.cover_callback_rate,callback:function(r){t.$set(t.form,"cover_callback_rate",r)},expression:"form.cover_callback_rate"}})],1),r("b-form-group",{attrs:{label:t.$t("strategy_type")},scopedSlots:t._u([{key:"default",fn:function(e){var o=e.ariaDescribedby;return[r("b-form-radio-group",{attrs:{id:"radio-group-2","aria-describedby":o,name:"radio-sub-component"},model:{value:t.form.recycle_status,callback:function(r){t.$set(t.form,"recycle_status",r)},expression:"form.recycle_status"}},[r("b-form-radio",{attrs:{"aria-describedby":o,name:"some-radios",value:"0"}},[t._v(t._s(t.$t("single_strategy")))]),r("b-form-radio",{attrs:{"aria-describedby":o,name:"some-radios",value:"1"}},[t._v(t._s(t.$t("circular_strategy")))])],1)]}}])}),r("b-row",[r("b-col",{staticClass:"pl-1 pr-3",attrs:{cols:"6"}},[r("b-button",{attrs:{block:"",type:"submit",variant:"primary"}},[t._v(t._s(t.$t("submit")))])],1),r("b-col",{staticClass:"pl-1 pr-3",attrs:{cols:"6"}},[r("b-button",{attrs:{block:"",type:"button",variant:"outline-primary"},on:{click:t.backpage}},[t._v(" "+t._s(t.$t("cancel")))])],1)],1)],1)],1)],1)],1)],1),r("b-tab",{attrs:{"no-body":"",title:t.$t("conserve")},on:{click:t.conserve}},[r("b-row",{attrs:{"align-h":"center"},on:{submit:t.postData}},[r("b-col",{staticClass:"p-0",attrs:{md:"5"}},[r("b-card",[r("b-form",[r("b-form-group",{attrs:{id:"input-group-1",label:t.$t("gas"),"label-for":"input-1"}},[r("b-form-input",{attrs:{id:"input-1",type:"text",readonly:"",required:""},model:{value:t.balance,callback:function(r){t.balance=r},expression:"balance"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("first_buy_in_amount"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:""},model:{value:t.form.first_order_value,callback:function(r){t.$set(t.form,"first_order_value",r)},expression:"form.first_order_value"}})],1),r("b-row",{staticClass:"form-group",attrs:{"align-h":"between"}},[r("b-col",{attrs:{cols:"8"}},[r("label",{staticClass:"col-form-label",attrs:{for:"first_order_double"}},[t._v(t._s(t.$t("first_order_double")))])]),r("b-col",{staticClass:"py-2",attrs:{cols:"4"}},[r("label",{staticClass:"switch switch-primary mr-3"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.form.first_order_double,expression:"form.first_order_double"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.form.first_order_double)?t._i(t.form.first_order_double,null)>-1:t.form.first_order_double},on:{change:function(r){var e=t.form.first_order_double,o=r.target,a=!!o.checked;if(Array.isArray(e)){var i=null,s=t._i(e,i);o.checked?s<0&&t.$set(t.form,"first_order_double",e.concat([i])):s>-1&&t.$set(t.form,"first_order_double",e.slice(0,s).concat(e.slice(s+1)))}else t.$set(t.form,"first_order_double",a)}}}),r("span",{staticClass:"slider"})])])],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("numbers_of_cover_up"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:""},on:{change:t.setMarginConfig},model:{value:t.form.max_order_count,callback:function(r){t.$set(t.form,"max_order_count",r)},expression:"form.max_order_count"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("take_profit_ratio"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:"",step:"any"},model:{value:t.form.stop_profit_rate,callback:function(r){t.$set(t.form,"stop_profit_rate",r)},expression:"form.stop_profit_rate"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("earnings_callback"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",step:"any",required:""},model:{value:t.form.stop_profit_callback_rate,callback:function(r){t.$set(t.form,"stop_profit_callback_rate",r)},expression:"form.stop_profit_callback_rate"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("margin_call_drop"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:""},on:{change:t.setMarginConfig},model:{value:t.form.cover_rate,callback:function(r){t.$set(t.form,"cover_rate",r)},expression:"form.cover_rate"}})],1),r("b-button",{staticClass:"form-control py-1 px-2 my-3",attrs:{block:"",type:"button"},on:{click:function(r){return t.openModal()}}},[t._v(t._s(t.$t("margin_call_setting"))+" ")]),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("buy_in_callback"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",step:"any",required:""},model:{value:t.form.cover_callback_rate,callback:function(r){t.$set(t.form,"cover_callback_rate",r)},expression:"form.cover_callback_rate"}})],1),r("b-form-group",{attrs:{label:t.$t("strategy_type")},scopedSlots:t._u([{key:"default",fn:function(e){var o=e.ariaDescribedby;return[r("b-form-radio-group",{attrs:{id:"radio-group-2","aria-describedby":o,name:"radio-sub-component"},model:{value:t.form.recycle_status,callback:function(r){t.$set(t.form,"recycle_status",r)},expression:"form.recycle_status"}},[r("b-form-radio",{attrs:{"aria-describedby":o,name:"some-radios",value:"0"}},[t._v(t._s(t.$t("single_strategy")))]),r("b-form-radio",{attrs:{"aria-describedby":o,name:"some-radios",value:"1"}},[t._v(t._s(t.$t("circular_strategy")))])],1)]}}])}),r("b-row",[r("b-col",{staticClass:"pl-1 pr-3",attrs:{cols:"6"}},[r("b-button",{attrs:{block:"",type:"submit",variant:"primary"}},[t._v(t._s(t.$t("submit")))])],1),r("b-col",{staticClass:"pl-1 pr-3",attrs:{cols:"6"}},[r("b-button",{attrs:{block:"",type:"button",variant:"outline-primary"},on:{click:t.backpage}},[t._v(" "+t._s(t.$t("cancel")))])],1)],1)],1)],1)],1)],1)],1),r("b-tab",{attrs:{"no-body":"",title:t.$t("stable")},on:{click:t.stable}},[r("b-row",{attrs:{"align-h":"center"},on:{submit:t.postData}},[r("b-col",{staticClass:"p-0",attrs:{md:"5"}},[r("b-card",[r("b-form",[r("b-form-group",{attrs:{id:"input-group-1",label:t.$t("gas"),"label-for":"input-1"}},[r("b-form-input",{attrs:{id:"input-1",type:"text",readonly:"",required:""},model:{value:t.balance,callback:function(r){t.balance=r},expression:"balance"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("first_buy_in_amount"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:""},model:{value:t.form.first_order_value,callback:function(r){t.$set(t.form,"first_order_value",r)},expression:"form.first_order_value"}})],1),r("b-row",{staticClass:"form-group",attrs:{"align-h":"between"}},[r("b-col",{attrs:{cols:"8"}},[r("label",{staticClass:"col-form-label",attrs:{for:"first_order_double"}},[t._v(t._s(t.$t("first_order_double")))])]),r("b-col",{staticClass:"py-2",attrs:{cols:"4"}},[r("label",{staticClass:"switch switch-primary mr-3"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.form.first_order_double,expression:"form.first_order_double"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.form.first_order_double)?t._i(t.form.first_order_double,null)>-1:t.form.first_order_double},on:{change:function(r){var e=t.form.first_order_double,o=r.target,a=!!o.checked;if(Array.isArray(e)){var i=null,s=t._i(e,i);o.checked?s<0&&t.$set(t.form,"first_order_double",e.concat([i])):s>-1&&t.$set(t.form,"first_order_double",e.slice(0,s).concat(e.slice(s+1)))}else t.$set(t.form,"first_order_double",a)}}}),r("span",{staticClass:"slider"})])])],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("numbers_of_cover_up"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:""},on:{change:t.setMarginConfig},model:{value:t.form.max_order_count,callback:function(r){t.$set(t.form,"max_order_count",r)},expression:"form.max_order_count"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("take_profit_ratio"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:"",step:"any"},model:{value:t.form.stop_profit_rate,callback:function(r){t.$set(t.form,"stop_profit_rate",r)},expression:"form.stop_profit_rate"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("earnings_callback"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",step:"any",required:""},model:{value:t.form.stop_profit_callback_rate,callback:function(r){t.$set(t.form,"stop_profit_callback_rate",r)},expression:"form.stop_profit_callback_rate"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("margin_call_drop"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:""},on:{change:t.setMarginConfig},model:{value:t.form.cover_rate,callback:function(r){t.$set(t.form,"cover_rate",r)},expression:"form.cover_rate"}})],1),r("b-button",{staticClass:"form-control py-1 px-2 my-3",attrs:{block:"",type:"button"},on:{click:function(r){return t.openModal()}}},[t._v(t._s(t.$t("margin_call_setting"))+" ")]),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("buy_in_callback"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",step:"any",required:""},model:{value:t.form.cover_callback_rate,callback:function(r){t.$set(t.form,"cover_callback_rate",r)},expression:"form.cover_callback_rate"}})],1),r("b-form-group",{attrs:{label:t.$t("strategy_type")},scopedSlots:t._u([{key:"default",fn:function(e){var o=e.ariaDescribedby;return[r("b-form-radio-group",{attrs:{id:"radio-group-2","aria-describedby":o,name:"radio-sub-component"},model:{value:t.form.recycle_status,callback:function(r){t.$set(t.form,"recycle_status",r)},expression:"form.recycle_status"}},[r("b-form-radio",{attrs:{"aria-describedby":o,name:"some-radios",value:"0"}},[t._v(t._s(t.$t("single_strategy")))]),r("b-form-radio",{attrs:{"aria-describedby":o,name:"some-radios",value:"1"}},[t._v(t._s(t.$t("circular_strategy")))])],1)]}}])}),r("b-row",[r("b-col",{staticClass:"pl-1 pr-3",attrs:{cols:"6"}},[r("b-button",{attrs:{block:"",type:"submit",variant:"primary"}},[t._v(t._s(t.$t("submit")))])],1),r("b-col",{staticClass:"pl-1 pr-3",attrs:{cols:"6"}},[r("b-button",{attrs:{block:"",type:"button",variant:"outline-primary"},on:{click:t.backpage}},[t._v(" "+t._s(t.$t("cancel")))])],1)],1)],1)],1)],1)],1)],1),r("b-tab",{attrs:{"no-body":"",title:t.$t("customize")},on:{click:t.customize}},[r("b-row",{attrs:{"align-h":"center"},on:{submit:t.postData}},[r("b-col",{staticClass:"p-0",attrs:{md:"5"}},[r("b-card",[r("b-form",[r("b-form-group",{attrs:{id:"input-group-1",label:t.$t("gas"),"label-for":"input-1"}},[r("b-form-input",{attrs:{id:"input-1",type:"text",readonly:"",required:""},model:{value:t.balance,callback:function(r){t.balance=r},expression:"balance"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("first_buy_in_amount"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:""},model:{value:t.form.first_order_value,callback:function(r){t.$set(t.form,"first_order_value",r)},expression:"form.first_order_value"}})],1),r("b-row",{staticClass:"form-group",attrs:{"align-h":"between"}},[r("b-col",{attrs:{cols:"8"}},[r("label",{staticClass:"col-form-label",attrs:{for:"first_order_double"}},[t._v(t._s(t.$t("first_order_double")))])]),r("b-col",{staticClass:"py-2",attrs:{cols:"4"}},[r("label",{staticClass:"switch switch-primary mr-3"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.form.first_order_double,expression:"form.first_order_double"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.form.first_order_double)?t._i(t.form.first_order_double,null)>-1:t.form.first_order_double},on:{change:function(r){var e=t.form.first_order_double,o=r.target,a=!!o.checked;if(Array.isArray(e)){var i=null,s=t._i(e,i);o.checked?s<0&&t.$set(t.form,"first_order_double",e.concat([i])):s>-1&&t.$set(t.form,"first_order_double",e.slice(0,s).concat(e.slice(s+1)))}else t.$set(t.form,"first_order_double",a)}}}),r("span",{staticClass:"slider"})])])],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("numbers_of_cover_up"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:""},on:{change:t.setMarginConfig},model:{value:t.form.max_order_count,callback:function(r){t.$set(t.form,"max_order_count",r)},expression:"form.max_order_count"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("take_profit_ratio"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:"",step:"any"},model:{value:t.form.stop_profit_rate,callback:function(r){t.$set(t.form,"stop_profit_rate",r)},expression:"form.stop_profit_rate"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("earnings_callback"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",step:"any",required:""},model:{value:t.form.stop_profit_callback_rate,callback:function(r){t.$set(t.form,"stop_profit_callback_rate",r)},expression:"form.stop_profit_callback_rate"}})],1),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("margin_call_drop"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",required:""},on:{change:t.setMarginConfig},model:{value:t.form.cover_rate,callback:function(r){t.$set(t.form,"cover_rate",r)},expression:"form.cover_rate"}})],1),r("b-button",{staticClass:"form-control py-1 px-2 my-3",attrs:{block:"",type:"button"},on:{click:function(r){return t.openModal()}}},[t._v(t._s(t.$t("margin_call_setting"))+" ")]),r("b-form-group",{attrs:{id:"input-group-2",label:t.$t("buy_in_callback"),"label-for":"input-2"}},[r("b-form-input",{attrs:{id:"input-2",type:"number",step:"any",required:""},model:{value:t.form.cover_callback_rate,callback:function(r){t.$set(t.form,"cover_callback_rate",r)},expression:"form.cover_callback_rate"}})],1),r("b-form-group",{attrs:{label:t.$t("strategy_type")},scopedSlots:t._u([{key:"default",fn:function(e){var o=e.ariaDescribedby;return[r("b-form-radio-group",{attrs:{id:"radio-group-2","aria-describedby":o,name:"radio-sub-component"},model:{value:t.form.recycle_status,callback:function(r){t.$set(t.form,"recycle_status",r)},expression:"form.recycle_status"}},[r("b-form-radio",{attrs:{"aria-describedby":o,name:"some-radios",value:"0"}},[t._v(t._s(t.$t("single_strategy")))]),r("b-form-radio",{attrs:{"aria-describedby":o,name:"some-radios",value:"1"}},[t._v(t._s(t.$t("circular_strategy")))])],1)]}}])}),r("b-row",[r("b-col",{staticClass:"pl-1 pr-3",attrs:{cols:"6"}},[r("b-button",{attrs:{block:"",type:"submit",variant:"primary"}},[t._v(t._s(t.$t("submit")))])],1),r("b-col",{staticClass:"pl-1 pr-3",attrs:{cols:"6"}},[r("b-button",{attrs:{block:"",type:"button",variant:"outline-primary"},on:{click:t.backpage}},[t._v(" "+t._s(t.$t("cancel")))])],1)],1)],1)],1)],1)],1)],1)],1)],1),r("b-modal",{attrs:{id:"modal-marginConfig",size:"sm",centered:"",title:t.$t("margin_call_setting"),"hide-footer":""}},[r("b-form",{staticClass:"mx-4",on:{submit:function(r){return r.preventDefault(),t.checkValue.apply(null,arguments)}}},[r("div",{staticClass:"form-group"},[r("b-row",[r("b-col",{staticClass:"px-1",attrs:{cols:"6"}},[r("label",{staticClass:"col-form-label text-center"},[t._v(" "+t._s(t.$t("buyback_drop"))+" ")])]),r("b-col",{staticClass:"px-1",attrs:{cols:"6"}},[r("label",{staticClass:"col-form-label text-center"},[t._v(" "+t._s(t.$t("buyback_ratios"))+" ")])])],1),t._l(t.form.custom_cover.length,(function(e,o){return r("b-row",{key:e.id},[r("b-col",{staticClass:"px-1 pt-1",attrs:{cols:"12"}},[r("span",0==o?[t._v(t._s(t.$t("buyback1")))]:[t._v(t._s(o+1)+t._s(t.$t("buyback")))])]),r("b-col",{staticClass:"p-1",attrs:{cols:"6"}},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.form.custom_cover[o]["percentage"],expression:"form.custom_cover[index]['percentage']"}],staticClass:"form-control",attrs:{type:"number",max:"100",min:"1",required:""},domProps:{value:t.form.custom_cover[o]["percentage"]},on:{input:function(r){r.target.composing||t.$set(t.form.custom_cover[o],"percentage",r.target.value)}}})]),r("b-col",{staticClass:"p-1",attrs:{cols:"6"}},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.form.custom_cover[o]["times"],expression:"form.custom_cover[index]['times']"}],staticClass:"form-control",attrs:{type:"number",required:"",min:"1"},domProps:{value:t.form.custom_cover[o]["times"]},on:{input:function(r){r.target.composing||t.$set(t.form.custom_cover[o],"times",r.target.value)}}})])],1)}))],2),r("b-button",{staticClass:"px-auto mt-1",attrs:{block:"",variant:"primary",type:"submit"}},[t._v(" OK")])],1)],1),r("Dialog",{ref:"msg"})],1)},a=[],i=e("5530"),s=(e("14d9"),e("e9c4"),e("ac1f"),e("5319"),e("06e0")),n=e("402a"),l=e("9565"),c=e("2f62"),u={props:["items"],computed:Object(i["a"])({},Object(c["c"])(["lang"])),components:{Dialog:l["a"]},data:function(){return{form:{gas_type:"point2",platform:"",robot_id:"",market_id:"",first_order_value:"100",max_order_count:"6",first_order_double:!1,stop_profit_rate:"1.8",stop_profit_callback_rate:"0.3",cover_rate:"3",cover_callback_rate:"0.2",recycle_status:"0",custom_cover:[]},checkApiBinding:!1,isLoading:!1,robotInfo:null,infoDetail:null,marketName:"",pin:"",balance:""}},methods:{backpage:function(){this.$router.go(-1)},checkValue:function(){this.$bvModal.hide("modal-marginConfig")},radical:function(){this.form.first_order_value="100",this.form.max_order_count="6",this.form.stop_profit_rate="1.8",this.form.stop_profit_callback_rate="0.3",this.form.cover_rate="3",this.form.cover_callback_rate="0.2",this.setMarginConfig()},conserve:function(){this.form.first_order_value="100",this.form.max_order_count="6",this.form.stop_profit_rate="1.3",this.form.stop_profit_callback_rate="0.3",this.form.cover_rate="5",this.form.cover_callback_rate="0.5",this.setMarginConfig()},stable:function(){this.form.first_order_value="100",this.form.max_order_count="6",this.form.stop_profit_rate="1.5",this.form.stop_profit_callback_rate="0.3",this.form.cover_rate="4",this.form.cover_callback_rate="0.3",this.setMarginConfig()},customize:function(){this.form.first_order_value="",this.form.max_order_count="",this.form.stop_profit_rate="",this.form.stop_profit_callback_rate="",this.form.cover_rate="",this.form.cover_callback_rate="",this.setMarginConfig()},openModal:function(){this.$bvModal.show("modal-marginConfig")},getInfo:function(){var t=Object(s["E"])(),r=this;this.isLoading=!0,t.then((function(t){r.isLoading=!1,r.pin=t.data.pin,r.balance=t.data.point2})).catch((function(t){r.isLoading=!1,r.$refs.msg.makeToast("warning",r.$t(Object(n["b"])(t)))}))},setMarginConfig:function(){this.form.custom_cover=[];for(var t=0;t<this.form.max_order_count;t++){var r={};r["percentage"]=this.form.cover_rate,r["times"]=1,this.form.custom_cover.push(r)}},postData:function(t){t.preventDefault(),this.form.first_order_double=this.form.first_order_double?1:0;var r,e=JSON.stringify(this.form),o=this;""==this.robotInfo||null==this.robotInfo?(this.$delete(this.form,"robot_id"),e=JSON.stringify(this.form),r=Object(s["n"])(e)):r=Object(s["s"])(e),this.isLoading=!0,r.then((function(t){t.data.code>0?o.$swal({icon:"error",text:o.$t(t.data.message)}):o.$swal({icon:"success",text:o.$t(t.data.message)}).then((function(){o.$router.replace({path:"/quantitative/marketList"})})),o.isLoading=!1})).catch((function(t){o.isLoading=!1,o.$refs.msg.makeToast("warning",o.$t(Object(n["b"])(t)))}))},getRobot:function(){this.robotID=this.$route.query.id;var t=Object(s["I"])(this.robotID),r=this;t.then((function(t){r.robotInfo=t.data.data,r.isLoading=!1,r.form.platform=r.$route.query.platform,r.form.market_id=r.$route.query.marketID,null!=r.robotInfo?(r.form.robot_id=r.robotInfo.id,r.form.first_order_value=r.robotInfo.first_order_value,r.form.max_order_count=r.robotInfo.max_order_count,r.form.first_order_double=1==r.robotInfo.first_order_double,r.form.stop_profit_rate=r.robotInfo.stop_profit_rate,r.form.stop_profit_callback_rate=r.robotInfo.stop_profit_callback_rate,r.form.cover_rate=r.robotInfo.cover_rate,r.form.cover_callback_rate=r.robotInfo.cover_callback_rate,r.form.cover_rate=r.robotInfo.cover_rate,r.form.recycle_status=r.robotInfo.recycle_status,null!=r.robotInfo.custom_cover?r.form.custom_cover=JSON.parse(r.robotInfo.custom_cover):r.setMarginConfig()):r.setMarginConfig()})).catch((function(t){r.isLoading=!1,r.$refs.msg.makeToast("warning",r.$t(Object(n["b"])(t)))}))},loadItems:function(){var t=new FormData;t.append("platform",this.$route.query.platform);var r=Object(s["w"])(t),e=this;this.isLoading=!0,r.then((function(t){0!=t.data.code&&(e.checkApiBinding=!0),e.isLoading=!1})).catch((function(t){e.isLoading=!1,e.$refs.msg.makeToast("warning",e.$t(Object(n["b"])(t)))}))}},created:function(){this.getRobot(),this.loadItems(),this.getInfo()}},f=u,b=e("2877"),p=Object(b["a"])(f,o,a,!1,null,null,null);r["default"]=p.exports},ad6d:function(t,r,e){"use strict";var o=e("825a");t.exports=function(){var t=o(this),r="";return t.hasIndices&&(r+="d"),t.global&&(r+="g"),t.ignoreCase&&(r+="i"),t.multiline&&(r+="m"),t.dotAll&&(r+="s"),t.unicode&&(r+="u"),t.unicodeSets&&(r+="v"),t.sticky&&(r+="y"),r}},d784:function(t,r,e){"use strict";e("ac1f");var o=e("4625"),a=e("cb2d"),i=e("9263"),s=e("d039"),n=e("b622"),l=e("9112"),c=n("species"),u=RegExp.prototype;t.exports=function(t,r,e,f){var b=n(t),p=!s((function(){var r={};return r[b]=function(){return 7},7!=""[t](r)})),d=p&&!s((function(){var r=!1,e=/a/;return"split"===t&&(e={},e.constructor={},e.constructor[c]=function(){return e},e.flags="",e[b]=/./[b]),e.exec=function(){return r=!0,null},e[b](""),!r}));if(!p||!d||e){var m=o(/./[b]),_=r(b,""[t],(function(t,r,e,a,s){var n=o(t),l=r.exec;return l===i||l===u.exec?p&&!s?{done:!0,value:m(r,e,a)}:{done:!0,value:n(e,r,a)}:{done:!1}}));a(String.prototype,t,_[0]),a(u,b,_[1])}f&&l(u[b],"sham",!0)}},fb6a:function(t,r,e){"use strict";var o=e("23e7"),a=e("e8b5"),i=e("68ee"),s=e("861d"),n=e("23cb"),l=e("07fa"),c=e("fc6a"),u=e("8418"),f=e("b622"),b=e("1dde"),p=e("f36a"),d=b("slice"),m=f("species"),_=Array,v=Math.max;o({target:"Array",proto:!0,forced:!d},{slice:function(t,r){var e,o,f,b=c(this),d=l(b),g=n(t,d),y=n(void 0===r?d:r,d);if(a(b)&&(e=b.constructor,i(e)&&(e===_||a(e.prototype))?e=void 0:s(e)&&(e=e[m],null===e&&(e=void 0)),e===_||void 0===e))return p(b,g,y);for(o=new(void 0===e?_:e)(v(y-g,0)),f=0;g<y;g++,f++)g in b&&u(o,f,b[g]);return o.length=f,o}})},fce3:function(t,r,e){var o=e("d039"),a=e("da84"),i=a.RegExp;t.exports=o((function(){var t=i(".","s");return!(t.dotAll&&t.exec("\n")&&"s"===t.flags)}))}}]);
//# sourceMappingURL=chunk-6dccfaa0.085ee336.js.map