(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-54c3308d"],{"0d27":function(t,a,s){},1003:function(t,a,s){"use strict";s("5c6c2")},"25f0":function(t,a,s){"use strict";var e=s("5e77").PROPER,o=s("cb2d"),n=s("825a"),i=s("577e"),r=s("d039"),c=s("90d8"),l="toString",u=RegExp.prototype,m=u[l],d=r((function(){return"/a/b"!=m.call({source:"a",flags:"b"})})),f=e&&m.name!=l;(d||f)&&o(RegExp.prototype,l,(function(){var t=n(this),a=i(t.source),s=i(c(t));return"/"+a+"/"+s}),{unsafe:!0})},3780:function(t,a,s){"use strict";s.r(a);var e=function(){var t=this,a=t._self._c;return a("div",{staticClass:"main-content d-flex flex-column",staticStyle:{"max-height":"100vh"}},[a("div",{staticClass:"appBar"},[a("a",{on:{click:function(a){return t.$router.go(-1)}}},[a("img",{attrs:{src:s("e57b"),alt:""}})]),a("span",[t._v(t._s(t.$t("withdraw")))])]),a("div",{staticClass:"flex-grow-1"},[a("div",{staticClass:"mx-4"},[a("b-row",{staticClass:"mt-3",attrs:{"align-h":"between"}},[a("b-col",{staticClass:"pr-0",attrs:{cols:"6"}},[a("div",{staticClass:"tabContainer text-center",class:{active:0==t.selected},on:{click:function(a){return t.selectIndex(0)}}},[a("div",{staticClass:"tabImage"},[a("img",{attrs:{src:s("6eb4"),alt:""}})]),a("span",[t._v(t._s(t.$t("bank")))])])]),a("b-col",{staticClass:"pl-0",attrs:{cols:"6"}},[a("div",{staticClass:"tabContainer text-center",class:{active:1==t.selected},on:{click:function(a){return t.selectIndex(1)}}},[a("div",{staticClass:"tabImage"},[a("img",{attrs:{src:s("a856"),alt:""}})]),a("span",[t._v(t._s(t.$t("crypto")))])])])],1)],1),0==t.selected?a("bank",{attrs:{fee:t.fee,totalAmount:t.totalAmount,canWithdraw:t.canWithdraw,startLoading:t.isLoading}}):t._e(),1==t.selected?a("coin",{attrs:{fee:t.fee,totalAmount:t.totalAmount,canWithdraw:t.canWithdraw,startLoading:t.isLoading}}):t._e()],1),a("Dialog",{ref:"msg"})],1)},o=[],n=s("5530"),i=s("06e0"),r=s("402a"),c=s("9565"),l=s("2f62"),u=function(){var t=this,a=t._self._c;return a("div",{staticClass:"mt-3 position-relative d-flex flex-column"},[t.startLoading?a("div",{staticStyle:{position:"absolute","background-color":"rgba(211, 211, 211, 0.2)",height:"100%",width:"100%","z-index":"3",display:"flex","justify-content":"center","align-items":"center"}},[a("span",{staticStyle:{"background-color":"#c0dfff",color:"#409eff",padding:"7px 30px","border-radius":"3px"}},[t._v(t._s(t.$t("loading...")))])]):t._e(),a("b-form",{staticClass:"p-4 d-flex flex-column flex-grow-1",on:{submit:function(a){return a.preventDefault(),t.doWithdraw.apply(null,arguments)}}},[a("div",[a("b-form-group",{staticClass:"form-customize mt-3",attrs:{label:t.$t("withdrawAmount")}},[a("b-form-input",{staticClass:"form-control form-custom",attrs:{type:"number",placeholder:t.$t("withdrawHint"),min:"10",max:"10000000",required:""},on:{change:t.updateAmount,input:t.updateAmount},model:{value:t.amount,callback:function(a){t.amount=a},expression:"amount"}})],1),a("b-row",{staticClass:"mb-1",attrs:{"align-h":"between"}},[a("b-col",[a("span",[t._v(t._s(t.$t("amount"))+": "+t._s(this.totalAmount))])]),a("b-col",{staticClass:"text-right"},[a("a",{attrs:{target:"_blank",rel:"noopener noreferrer"},on:{click:t.inputAll}},[t._v(t._s(t.$t("withdrawAll")))])])],1),a("b-form-group",{staticClass:"form-customize mt-3",attrs:{label:t.$t("bank_country")}},[a("b-input-group",[a("b-form-input",{staticClass:"form-control form-custom",attrs:{type:"text",required:""},model:{value:t.country_name,callback:function(a){t.country_name=a},expression:"country_name"}})],1)],1),a("b-form-group",{staticClass:"form-customize mt-3",attrs:{label:t.$t("bank_name")}},[a("b-input-group",[a("b-form-input",{staticClass:"form-control form-custom",attrs:{type:"text",required:""},model:{value:t.bank_name,callback:function(a){t.bank_name=a},expression:"bank_name"}})],1)],1),a("b-form-group",{staticClass:"form-customize mt-3",attrs:{label:t.$t("bank_user")}},[a("b-input-group",[a("b-form-input",{staticClass:"form-control form-custom",attrs:{type:"text",required:""},model:{value:t.bank_user,callback:function(a){t.bank_user=a},expression:"bank_user"}})],1)],1),a("b-form-group",{staticClass:"form-customize mt-3",attrs:{label:t.$t("bank_number")}},[a("b-input-group",[a("b-form-input",{staticClass:"form-control form-custom",attrs:{type:"number",required:""},model:{value:t.bank_number,callback:function(a){t.bank_number=a},expression:"bank_number"}})],1)],1),a("b-form-group",{staticClass:"form-customize mt-3",attrs:{label:t.$t("branch")}},[a("b-input-group",[a("b-form-input",{staticClass:"form-control form-custom",attrs:{type:"text",required:""},model:{value:t.branch,callback:function(a){t.branch=a},expression:"branch"}})],1)],1),a("b-form-group",{staticClass:"form-customize mt-3",attrs:{label:t.$t("sec_password")}},[a("b-input-group",[a("b-form-input",{staticClass:"form-control form-custom",attrs:{placeholder:t.$t("assetPwdHint"),type:"password",required:""},model:{value:t.sec_pwd,callback:function(a){t.sec_pwd=a},expression:"sec_pwd"}})],1)],1)],1),a("div",{},[a("b-form-group",{staticClass:"form-customize mt-3",attrs:{label:t.$t("fees")+" %"}},[a("b-input-group",[a("b-form-input",{staticClass:"form-control form-custom",attrs:{type:"number",readonly:""},model:{value:t.fee,callback:function(a){t.fee=a},expression:"fee"}})],1)],1),a("b-form-group",{staticClass:"form-customize mt-3",attrs:{label:t.$t("get_amount")}},[a("b-input-group",[a("b-form-input",{staticClass:"form-control form-custom",attrs:{type:"number",readonly:""},model:{value:t.convert_amount,callback:function(a){t.convert_amount=a},expression:"convert_amount"}})],1)],1),a("b-button",{staticClass:"mx-auto submit_button my-5",attrs:{disabled:t.isLoading,variant:"outline-secondary",type:"submit"}},[t._v(t._s(t.isLoading?t.$t("loading..."):t.$t("withdraw")))])],1)]),a("b-modal",{staticStyle:{"background-color":"#5f646e !important"},attrs:{id:"modal-warning",size:"md",centered:"",title:t.$t("withdrawal_rules"),"hide-footer":!0}},[a("b-form",[a("b-row",{attrs:{"align-h":"center"}},[a("b-col",{attrs:{md:"12 mb-30"}},[a("div",{staticClass:"form-group"},[a("div",{staticClass:"col-sm-12"},[a("p",[t._v(" "+t._s(t.$t("withdrawal_rules1"))+" ")]),a("p",[t._v(" "+t._s(t.$t("withdrawal_rules2"))+" ")]),a("p",[t._v(" "+t._s(t.$t("withdrawal_rules3"))+" ")]),a("p",[t._v(" "+t._s(t.$t("withdrawal_rules4"))+" ")]),a("p",[t._v(" "+t._s(t.$t("withdrawal_rules5"))+" ")]),a("p",[t._v(" "+t._s(t.$t("withdrawal_rules6"))+" ")]),a("p",[t._v(" "+t._s(t.$t("withdrawal_rules7"))+" ")]),a("p",[t._v(" "+t._s(t.$t("withdrawal_rules8"))+" ")])]),a("div",{staticClass:"col-sm-12"},[a("center",[a("b-button",{staticClass:"mx-auto submit_button mt-5",attrs:{disabled:t.isLoading,variant:"outline-secondary"},on:{click:function(a){return t.close()}}},[t._v(t._s(t.$t("close")))])],1)],1)])])],1)],1)],1),a("Dialog",{ref:"msg"})],1)},m=[],d=(s("d3b7"),s("25f0"),s("14d9"),{props:["fee","totalAmount","canWithdraw","startLoading"],computed:Object(n["a"])({},Object(l["c"])(["lang"])),components:{Dialog:c["a"]},data:function(){return{bank_name:"",bank_user:"",bank_number:"",branch:"",amount:0,confirm_amount:0,convert_amount:0,bankRate:0,sec_pwd:"",selected:0,isLoading:!1,country:null,pSymbol:"",countryOptions:[],rows:[],country_name:""}},methods:{warning:function(){this.$bvModal.show("modal-warning")},close:function(){this.$bvModal.hide("modal-warning")},updateAmount:function(){this.confirm_amount=this.amount-this.amount*this.fee/100,this.confirm_amount<0&&(this.confirm_amount=0),this.changeRate()},inputAll:function(){this.amount=this.totalAmount,this.confirm_amount=this.amount-this.amount*this.fee/100,this.changeRate()},changeRate:function(){var t=this.confirm_amount;this.convert_amount=t.toString()},getInfo:function(){var t=Object(i["y"])(),a=this;this.isLoading=!0,t.then((function(t){a.country=t.data.data.country.id,console.log(a.country),a.country_name=t.data.data.country.name_en,a.bank_number=t.data.data.bank_number,a.bank_name=t.data.data.bank_name,a.bank_user=t.data.data.bank_user,a.branch=t.data.data.branch,null!=t.data.data.bank_number&&a.$bvModal.show("modal-otp"),a.isLoading=!1})).catch((function(t){console.log(t),a.isLoading=!1}))},doWithdraw:function(){var t=new FormData;t.append("amount",this.amount),t.append("bank_country",this.country),t.append("bank_name",this.bank_name),t.append("bank_user",this.bank_user),t.append("bank_number",this.bank_number),t.append("branch",this.branch),t.append("sec_password",this.sec_pwd);var a=Object(i["lb"])(t),s=this;s.isLoading=!0,a.then((function(t){console.log(t.data),0==t.data.error_code?(s.$refs.msg.makeToast("success",s.$t(t.data.message)),setTimeout((function(){s.$router.push("/web/")}),2e3)):s.$refs.msg.makeToast("danger",s.$t(t.data.message)),s.sec_pwd="",s.isLoading=!1})).catch((function(t){console.log(t),s.$refs.msg.makeToast("warning",s.$t(Object(r["b"])(t))),s.isLoading=!1,s.sec_pwd=""}))}},watch:{country:function(){for(var t=this,a=0;a<t.rows.length;a++)t.rows[a].id==t.country&&(t.bankRate=t.rows[a].buy,t.pSymbol=t.rows[a].short_form);t.changeRate()}},created:function(){this.getInfo(),this.info=JSON.parse(localStorage.getItem("info")),console.log(this.info)}}),f=d,p=(s("1003"),s("2877")),b=Object(p["a"])(f,u,m,!1,null,null,null),h=b.exports,g=function(){var t=this,a=t._self._c;return a("div",{staticClass:"mt-3 mx-4",staticStyle:{position:"relative"}},[t.startLoading?a("div",{staticStyle:{position:"absolute","background-color":"rgba(211, 211, 211, 0.2)",height:"100%",width:"100%","z-index":"3",display:"flex","justify-content":"center","align-items":"center"}},[a("span",{staticStyle:{"background-color":"#c0dfff",color:"#409eff",padding:"7px 30px","border-radius":"3px"}},[t._v(t._s(t.$t("loading...")))])]):t._e(),a("b-form",{on:{submit:function(a){return a.preventDefault(),t.checkSubmit.apply(null,arguments)}}},[a("b-form-group",{staticClass:"form-customize",attrs:{label:t.$t("withdraw_type")}},[a("b-input-group",[a("b-form-select",{staticClass:"form-control",staticStyle:{background:"#122a58","min-height":"40px","margin-bottom":"0px!important"},attrs:{type:"text",options:t.withdrawOptions},on:{change:t.updateWithdraw},model:{value:t.withdrawSelected,callback:function(a){t.withdrawSelected=a},expression:"withdrawSelected"}})],1)],1),0==t.show?a("p",{staticClass:"mb-0"},[t._v(t._s(t.$t("withdrawAmount")))]):t._e(),0==t.show?a("b-form-group",{staticClass:"form-customize mt-2 p-0 mb-1"},[a("b-form-input",{staticClass:"custom-input form-custom text-left",attrs:{type:"number",placeholder:t.$t("withdrawHint"),step:"any",min:"10"},on:{change:t.updateAmount,input:t.updateAmount},model:{value:t.amount,callback:function(a){t.amount=a},expression:"amount"}})],1):t._e(),0==t.show?a("b-row",{staticClass:"mb-4",attrs:{"align-h":"between"}},[a("b-col",[a("span",[t._v(t._s(t.$t("amount"))+": "+t._s(this.totalAmount))])]),a("b-col",{staticClass:"text-right"},[a("a",{attrs:{target:"_blank",rel:"noopener noreferrer"},on:{click:t.inputAll}},[t._v(t._s(t.$t("withdrawAll")))])])],1):t._e(),1==t.show?a("p",{staticClass:"mb-0"},[t._v(t._s(t.$t("withdrawDaAmount")))]):t._e(),1==t.show?a("b-form-group",{staticClass:"form-customize mt-2 p-0 mb-1"},[a("b-form-input",{staticClass:"custom-input form-custom text-left",attrs:{type:"number",placeholder:t.$t("withdrawHint"),step:"any",min:"100"},on:{change:t.updateDaAmount,input:t.updateDaAmount},model:{value:t.daAmount,callback:function(a){t.daAmount=a},expression:"daAmount"}})],1):t._e(),1==t.show?a("b-row",{staticClass:"mb-4",attrs:{"align-h":"between"}},[a("b-col",[a("span",[t._v("DA "+t._s(t.$t("amount"))+": "+t._s(this.assetFrozen))])]),a("b-col",{staticClass:"text-right"},[a("a",{attrs:{target:"_blank",rel:"noopener noreferrer"},on:{click:t.inputDaAll}},[t._v(t._s(t.$t("withdrawAll")))])])],1):t._e(),0==t.show?a("b-form-group",{staticClass:"form-customize",attrs:{label:t.$t("wallet_type")}},[a("b-input-group",[a("b-form-select",{staticClass:"form-control",staticStyle:{"min-height":"40px","margin-bottom":"0px!important"},attrs:{type:"text",options:t.walletOptions},model:{value:t.walletSelected,callback:function(a){t.walletSelected=a},expression:"walletSelected"}})],1)],1):t._e(),0==t.show?a("b-form-group",{staticClass:"form-customize",attrs:{label:t.$t("address")}},[a("b-input-group",[a("b-form-input",{staticClass:"form-control form-custom",attrs:{type:"text",required:""},model:{value:t.address,callback:function(a){t.address=a},expression:"address"}})],1)],1):t._e(),1==t.show?a("b-form-group",{staticClass:"form-customize",attrs:{label:t.$t("market_price")}},[a("b-input-group",[a("b-form-input",{staticClass:"form-control form-custom",attrs:{type:"text",readonly:""},model:{value:t.marketPrice,callback:function(a){t.marketPrice=a},expression:"marketPrice"}})],1)],1):t._e(),a("b-form-group",{staticClass:"form-customize mt-3",attrs:{label:t.$t("fees")+" %"}},[a("b-input-group",[a("b-form-input",{staticClass:"form-control form-custom",attrs:{type:"number",readonly:""},model:{value:t.fee,callback:function(a){t.fee=a},expression:"fee"}})],1)],1),a("b-form-group",{staticClass:"form-customize mt-3",attrs:{label:t.$t("get_amount")}},[a("b-input-group",[a("b-form-input",{staticClass:"form-control form-custom",attrs:{type:"number",readonly:""},model:{value:t.confirm_amount,callback:function(a){t.confirm_amount=a},expression:"confirm_amount"}})],1)],1),a("b-form-group",{staticClass:"form-customize mt-3",attrs:{label:t.$t("sec_password")}},[a("b-input-group",[a("b-form-input",{staticClass:"form-control form-custom",attrs:{placeholder:t.$t("assetPwdHint"),type:"password",required:""},model:{value:t.sec_pwd,callback:function(a){t.sec_pwd=a},expression:"sec_pwd"}})],1)],1),a("b-button",{staticClass:"mx-auto submit_button",staticStyle:{"margin-top":"10vh"},attrs:{disabled:t.isLoading,variant:"outline-secondary",type:"submit"}},[t._v(t._s(t.isLoading?t.$t("loading..."):t.$t("withdraw")))])],1),a("Dialog",{ref:"msg"}),a("b-modal",{staticStyle:{"background-color":"#5f646e !important"},attrs:{id:"modal-warning",size:"md",centered:"",title:t.$t("withdrawal_rules"),"hide-footer":!0}},[a("b-form",[a("b-row",{attrs:{"align-h":"center"}},[a("b-col",{attrs:{md:"12 mb-30"}},[a("div",{staticClass:"form-group"},[a("div",{staticClass:"col-sm-12"},[a("p",[t._v(" "+t._s(t.$t("withdrawal_rules1"))+" ")]),a("p",[t._v(" "+t._s(t.$t("withdrawal_rules2"))+" ")]),a("p",[t._v(" "+t._s(t.$t("withdrawal_rules3"))+" ")]),a("p",[t._v(" "+t._s(t.$t("withdrawal_rules4"))+" ")]),a("p",[t._v(" "+t._s(t.$t("withdrawal_rules5"))+" ")]),a("p",[t._v(" "+t._s(t.$t("withdrawal_rules6"))+" ")]),a("p",[t._v(" "+t._s(t.$t("withdrawal_rules7"))+" ")]),a("p",[t._v(" "+t._s(t.$t("withdrawal_rules8"))+" ")])]),a("div",{staticClass:"col-sm-12"},[a("center",[a("b-button",{staticClass:"mx-auto submit_button mt-5",attrs:{disabled:t.isLoading,variant:"outline-secondary"},on:{click:function(a){return t.close()}}},[t._v(t._s(t.$t("close")))])],1)],1)])])],1)],1)],1)],1)},_=[],w={props:["fee","totalAmount","canWithdraw","startLoading"],computed:Object(n["a"])({},Object(l["c"])(["lang"])),components:{Dialog:c["a"]},data:function(){return{address:"",amount:0,confirm_amount:0,sec_pwd:"",selected:0,isLoading:!1,walletSelected:"USDT(TRC20)",withdrawSelected:"coin",walletOptions:[{value:"USDT(TRC20)",text:"USDT(TRC20)"}],withdrawOptions:[{value:"coin",text:this.$t("coin")},{value:"freeze_coin",text:this.$t("da_interest")}],show:!1,assetFrozen:0,marketPrice:"",daAmount:0}},methods:{warning:function(){this.$bvModal.show("modal-warning")},close:function(){this.$bvModal.hide("modal-warning")},selectIndex:function(t){this.selected=t,this.sec_pwd=""},updateAmount:function(){this.confirm_amount=this.amount-this.amount*this.fee/100,this.confirm_amount<0&&(this.confirm_amount=0)},updateDaAmount:function(){this.confirm_amount=this.daAmount*this.marketPrice-this.daAmount*this.fee/100,this.confirm_amount<0&&(this.confirm_amount=0)},updateWithdraw:function(){"coin"==this.withdrawSelected?this.show=!1:this.show=!0},inputAll:function(){this.amount=this.totalAmount,this.confirm_amount=this.amount-this.amount*this.fee/100},inputDaAll:function(){this.daAmount=this.assetFrozen,this.confirm_amount=this.daAmount-this.daAmount*this.fee/100},checkSubmit:function(){0==this.show?this.doWithdraw():this.doWithdrawDa()},doWithdraw:function(){var t=new FormData;t.append("amount",this.amount),t.append("address",this.address),t.append("sec_password",this.sec_pwd),console.log(t);var a=Object(i["kb"])(t),s=this;s.isLoading=!0,a.then((function(t){0==t.data.error_code?(s.$refs.msg.makeToast("success",s.$t(t.data.message)),setTimeout((function(){s.$router.push("/web/")}),2e3)):s.$refs.msg.makeToast("danger",s.$t(t.data.message)),s.sec_pwd="",s.isLoading=!1})).catch((function(t){s.$refs.msg.makeToast("warning",s.$t(Object(r["b"])(t))),s.isLoading=!1,s.sec_pwd=""}))},doWithdrawDa:function(){var t=new FormData;t.append("amount",this.daAmount),t.append("trade_market_id",1),t.append("sec_password",this.sec_pwd),console.log(t);var a=Object(i["mb"])(t),s=this;s.isLoading=!0,a.then((function(t){0==t.data.error_code?(s.$refs.msg.makeToast("success",s.$t(t.data.message)),setTimeout((function(){s.$router.push("/web/")}),2e3)):s.$refs.msg.makeToast("danger",s.$t(t.data.message)),s.sec_pwd="",s.isLoading=!1})).catch((function(t){s.$refs.msg.makeToast("warning",s.$t(Object(r["b"])(t))),s.isLoading=!1,s.sec_pwd=""}))},daAsset:function(){var t=Object(i["b"])("DA"),a=this;t.then((function(t){for(var s=0;s<t.data.data.asset.length;s++)"DA"==t.data.data.asset[s].coin_name&&(a.assetFrozen=t.data.data.asset[s].asset_frozen)})).catch((function(t){a.$refs.msg.makeToast("warning",a.$t(Object(r["b"])(t)))}))},_marketInfo:function(){var t=Object(i["U"])(1),a=this;t.then((function(t){a.marketPrice=t.data.data.trade_market.price})).catch((function(t){a.$refs.msg.makeToast("warning",a.$t(Object(r["b"])(t)))}))}},created:function(){this.daAsset(),this._marketInfo(),this.info=JSON.parse(localStorage.getItem("info")),console.log(this.info.round);var t=Object(i["E"])(),a=this;this.isLoading=!0,t.then((function(t){a.address=t.data.address,null!=t.data.address&&a.$bvModal.show("modal-otp"),a.isLoading=!1})).catch((function(t){console.log(t),a.isLoading=!1}))}},v=w,k=Object(p["a"])(v,g,_,!1,null,null,null),$=k.exports,x={computed:Object(n["a"])({},Object(l["c"])(["lang"])),components:{Dialog:c["a"],bank:h,coin:$},data:function(){return{address:"",totalAmount:0,amount:0,confirm_amount:0,fee:0,sec_pwd:"",selected:0,isLoading:!1,canWithdraw:!1}},props:["success"],methods:{selectIndex:function(t){this.selected=t,this.sec_pwd="",this.getInfo(),this.getRecord()},updateAmount:function(){this.confirm_amount=this.amount*this.fee/100,this.confirm_amount<0&&(this.confirm_amount=0)},inputAll:function(){this.amount=this.totalAmount,this.confirm_amount=this.amount*this.fee/100},getInfo:function(){var t=Object(i["E"])(),a=this;t.then((function(t){a.totalAmount=t.data.data.point1})).catch((function(t){console.log(t),a.$refs.msg.makeToast("warning",a.$t(Object(r["b"])(t))),a.isLoading=!1}))},getRecord:function(){var t=Object(i["P"])(),a=this;a.isLoading=!0,t.then((function(t){a.isLoading=!1,a.fee=t.data.fee,a.canWithdraw=!t.data.can_withdraw})).catch((function(t){console.log(t),a.$refs.msg.makeToast("warning",a.$t(Object(r["b"])(t))),a.isLoading=!1}))},doWithdraw:function(){var t=new FormData;t.append("amount",this.amount),t.append("address",this.address),t.append("sec_password",this.sec_pwd),console.log(t);var a=Object(i["kb"])(t),s=this;s.isLoading=!0,a.then((function(t){0==t.data.error_code?s.$refs.msg.makeToast("success",s.$t(t.data.message)):s.$refs.msg.makeToast("danger",s.$t(t.data.message)),s.getInfo(),s.getRecord(),s.sec_pwd=""})).catch((function(t){s.$refs.msg.makeToast("warning",s.$t(Object(r["b"])(t))),s.isLoading=!1,s.sec_pwd=""}))}},created:function(){this.getInfo(),this.getRecord()}},y=x,C=(s("fa85"),Object(p["a"])(y,e,o,!1,null,null,null));a["default"]=C.exports},"5c6c2":function(t,a,s){},"6eb4":function(t,a,s){t.exports=s.p+"img/surface1.12887daa.svg"},"90d8":function(t,a,s){var e=s("c65b"),o=s("1a2d"),n=s("3a9b"),i=s("ad6d"),r=RegExp.prototype;t.exports=function(t){var a=t.flags;return void 0!==a||"flags"in r||o(t,"flags")||!n(r,t)?a:e(i,t)}},9565:function(t,a,s){"use strict";var e=function(){var t=this,a=t._self._c;return a("div")},o=[],n={methods:{makeToast:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,a=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(a,{variant:t,solid:!0})}},watch:{testProp:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"success",a=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(a,{variant:t,solid:!0})}}},i=n,r=s("2877"),c=Object(r["a"])(i,e,o,!1,null,null,null);a["a"]=c.exports},a856:function(t,a,s){t.exports=s.p+"img/Cjdowner-Cryptocurrency-Flat-Tether-USDT.2751fd70.svg"},ad6d:function(t,a,s){"use strict";var e=s("825a");t.exports=function(){var t=e(this),a="";return t.hasIndices&&(a+="d"),t.global&&(a+="g"),t.ignoreCase&&(a+="i"),t.multiline&&(a+="m"),t.dotAll&&(a+="s"),t.unicode&&(a+="u"),t.unicodeSets&&(a+="v"),t.sticky&&(a+="y"),a}},e57b:function(t,a,s){t.exports=s.p+"img/right.6ff4ef5c.svg"},fa85:function(t,a,s){"use strict";s("0d27")}}]);
//# sourceMappingURL=chunk-54c3308d.34d30160.js.map