(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-0510f0e6"],{"2f64":function(t,a,s){},3071:function(t,a,s){"use strict";s("2f64")},9565:function(t,a,s){"use strict";var i=function(){var t=this,a=t._self._c;return a("div")},e=[],o={methods:{makeToast:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,a=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(a,{variant:t,solid:!0})}},watch:{testProp:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"success",a=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(a,{variant:t,solid:!0})}}},l=o,n=s("2877"),c=Object(n["a"])(l,i,e,!1,null,null,null);a["a"]=c.exports},bf50:function(t,a,s){"use strict";s.r(a);s("a4d3"),s("e01a");var i=function(){var t=this,a=t._self._c;return a("div",{staticClass:"main-content"},[a("div",{staticClass:"appBar"},[a("a",{on:{click:function(a){return t.$router.go(-1)}}},[a("img",{attrs:{src:s("e57b"),alt:""}})]),a("span",[t._v(t._s(t.$t("news")))])]),a("div",{staticClass:"mainpage m-1 px-2",staticStyle:{"min-height":"90vh","padding-bottom":"15vh !important",position:"relative"}},[a("b-row",{staticClass:"mx-0"},[a("b-col",{staticClass:"px-2",attrs:{cols:"12"}},[a("div",{staticClass:"imgbox mb-3"},[a("img",{staticClass:"mx-auto d-block",attrs:{src:t.item.public_path,alt:"",height:"100px"}})])]),a("b-col",{attrs:{cols:"12"}},[a("h5",{staticClass:"text-black",staticStyle:{"text-align":"right!important"}},[t._v(t._s(t.item.created_at))])]),a("b-col",{attrs:{cols:"12"}},[a("h2",{staticClass:"text-black",staticStyle:{"margin-bottom":"10px"}},[t._v(t._s(t.item.title))])]),a("b-col",{attrs:{cols:"12"}},[a("h4",{staticClass:"text-black",staticStyle:{"margin-bottom":"10px"}},[t._v(t._s(t.item.description))])])],1)],1),a("Dialog",{ref:"msg"})],1)},e=[],o=s("5530"),l=s("9565"),n=s("2f62"),c={props:["item"],computed:Object(o["a"])({},Object(n["c"])(["lang"])),components:{Dialog:l["a"]},data:function(){return{public_image:this.public_path,isLoading:!0,point1:[],dataList:null,canClear:!1,wallet:"point1",wallet2:"point2",totalRecords:0,pageNumber:1,message:"",stock:"",money:"",status:!0,balance:"",currentPage:1,lastPage:1}},methods:{clipboardSuccessHandler:function(t){var a=t.value;this.$bvToast.toast(a,{title:this.$t("copied"),variant:"success",solid:!0})},clipboardErrorHandler:function(){},onPageChange:function(t){this.pageNumber=t.currentPage,this.loadItems(this.wallet);var a=this.$el.querySelector("#table"),s=a.offsetTop;window.scrollTo(0,s)},onSearch:function(){this.pageNumber=1,this.loadItems(this.wallet)},onCancel:function(){this.canClear=!1,this.loadItems(this.wallet)},loadItems:function(){console.log(this.item)}},created:function(){this.loadItems()}},r=c,u=(s("3071"),s("2877")),h=Object(u["a"])(r,i,e,!1,null,null,null);a["default"]=h.exports},e57b:function(t,a,s){t.exports=s.p+"img/right.6ff4ef5c.svg"}}]);
//# sourceMappingURL=chunk-0510f0e6.dfec4bc1.js.map