(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-5b8c5ebd"],{"2e59":function(t,s,a){"use strict";a.r(s);var e=function(){var t=this,s=t._self._c;return s("div",{staticClass:"main-content"},[s("div",{staticClass:"appBar"},[s("a",{on:{click:function(s){return t.$router.go(-1)}}},[s("img",{attrs:{src:a("e57b"),alt:""}})]),s("span",[t._v(t._s(t.$t("change_secpassword")))])]),s("b-form",{on:{submit:function(s){return s.preventDefault(),t.sendOTP.apply(null,arguments)}}},[s("div",{staticClass:"mainpage"},[s("b-form-group",{staticClass:"form-customize",attrs:{label:t.$t("email"),"label-for":"input-2"}},[s("b-input-group",[s("b-form-input",{staticClass:"form-custom",attrs:{size:"lg",readonly:""},model:{value:t.email,callback:function(s){t.email=s},expression:"email"}})],1)],1),s("b-form-group",{staticClass:"form-customize mb-3",attrs:{label:t.$t("vcode"),"label-for":"input-2"}},[s("b-input-group",[s("b-form-input",{staticClass:"form-custom",attrs:{label:"text",type:"number",required:""},model:{value:t.otp,callback:function(s){t.otp=s},expression:"otp"}}),s("b-input-group-append",{staticClass:"position-relative"},[s("b-button",{attrs:{variant:"primary",disabled:t.startCount||t.sending},on:{click:t.getOTP}},[t.sending?s("span",{staticClass:"text-white"},[t._v(t._s(t.$t("loading...")))]):s("span",[t._v(t._s(t.$t("get_vcode")))])]),t.startCount?s("div",{staticClass:"text-center py-2 overlay-text"},[t._v(" "+t._s(t.timecount)+" s ")]):t._e()],1)],1)],1),s("b-form-group",{staticClass:"form-customize",attrs:{label:t.$t("old_sec_password"),"label-for":"input-2"}},[s("b-input-group",[s("b-form-input",{staticClass:"form-custom",attrs:{type:"password",required:""},model:{value:t.sec_password,callback:function(s){t.sec_password=s},expression:"sec_password"}})],1)],1),s("b-form-group",{staticClass:"form-customize",attrs:{label:t.$t("new_sec_password"),"label-for":"input-2"}},[s("b-form-input",{staticClass:"form-custom",attrs:{type:"password",required:""},model:{value:t.password,callback:function(s){t.password=s},expression:"password"}})],1),s("b-form-group",{staticClass:"form-customize",attrs:{label:t.$t("confirm_sec_new_password"),"label-for":"input-2"}},[s("b-form-input",{staticClass:"form-custom",attrs:{type:"password",required:""},model:{value:t.password_confirmation,callback:function(s){t.password_confirmation=s},expression:"password_confirmation"}})],1),s("b-button",{staticClass:"mx-auto submit_button",staticStyle:{"margin-top":"20vh"},attrs:{variant:"outline-secondary",type:"submit"}},[t._v(t._s(t.isLoading?t.$t("loading..."):t.$t("submit")))])],1)]),s("Dialog",{ref:"msg"})],1)},o=[],n=a("5530"),i=a("06e0"),r=a("402a"),c=a("9565"),l=a("2f62"),u={computed:Object(n["a"])({},Object(l["c"])(["lang"])),components:{Dialog:c["a"]},data:function(){return{email:"",country:"",otp:"",sec_password:"",password:"",password_confirmation:"",timecount:60,startCount:!1,myVar:null,sending:!1,isLoading:!1}},props:["success"],methods:{getInfo:function(){var t=JSON.parse(localStorage.getItem("info"));this.email=t.email},sendOTP:function(){var t=new FormData,s=this;t.append("otp",this.otp);var a=Object(i["i"])(t);s.isLoading=!0,a.then((function(t){console.log(t.data),0==t.data.error_code?(s.$refs.msg.makeToast("success",s.$t(t.data.message)),s.submitForm()):s.$refs.msg.makeToast("danger",s.$t(t.data.message)),s.sending=!1,s.isLoading=!1})).catch((function(t){s.$refs.msg.makeToast("warning",s.$t(Object(r["b"])(t))),s.sending=!1,s.isLoading=!1}))},submitForm:function(){var t=new FormData,s=this;t.append("sec_password",this.sec_password),t.append("password",this.password),t.append("password_confirmation",this.password_confirmation);var a=Object(i["g"])(t);s.isLoading=!0,a.then((function(t){console.log(t.data),0==t.data.error_code?(s.$refs.msg.makeToast("success",s.$t(t.data.message)),s.otp="",s.password="",s.sec_password="",s.password_confirmation=""):s.$refs.msg.makeToast("danger",s.$t(t.data.message)),s.sending=!1,s.isLoading=!1})).catch((function(t){s.$refs.msg.makeToast("warning",s.$t(Object(r["b"])(t))),s.sending=!1,s.isLoading=!1}))},getOTP:function(){if(""==this.username)this.$refs.msg.makeToast("danger",this.$t("emailEmpty"));else{this.sending=!0,this.isLoading=!0;var t=new FormData,s=this;t.append("otp_type","email");var a=Object(i["bb"])(t);a.then((function(t){console.log(t.data),0==t.data.error_code?(s.$refs.msg.makeToast("success",s.$t("otp_sent")),s.startCount=!0,s.myVar=setInterval((function(){s.timecount-=1,0==s.timecount&&(s.timecount=60,clearInterval(s.myVar),s.startCount=!1)}),1e3)):s.$refs.msg.makeToast("danger",s.$t(t.data.message)),s.sending=!1,s.isLoading=!1})).catch((function(t){s.$refs.msg.makeToast("warning",s.$t(Object(r["b"])(t))),s.sending=!1,s.isLoading=!1}))}},loadItems:function(){}},created:function(){this.loadItems(),this.getInfo(),this.username=localStorage.getItem("username")}},m=u,d=(a("ad6e"),a("2877")),p=Object(d["a"])(m,e,o,!1,null,null,null);s["default"]=p.exports},3646:function(t,s,a){},9565:function(t,s,a){"use strict";var e=function(){var t=this,s=t._self._c;return s("div")},o=[],n={methods:{makeToast:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,s=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(s,{variant:t,solid:!0})}},watch:{testProp:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"success",s=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(s,{variant:t,solid:!0})}}},i=n,r=a("2877"),c=Object(r["a"])(i,e,o,!1,null,null,null);s["a"]=c.exports},ad6e:function(t,s,a){"use strict";a("3646")},e57b:function(t,s,a){t.exports=a.p+"img/right.6ff4ef5c.svg"}}]);
//# sourceMappingURL=chunk-5b8c5ebd.2dd3a6ff.js.map