(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2a272ad8"],{"25f0":function(t,e,a){"use strict";var s=a("5e77").PROPER,n=a("cb2d"),l=a("825a"),o=a("577e"),r=a("d039"),i=a("90d8"),c="toString",d=RegExp.prototype,u=d[c],b=r((function(){return"/a/b"!=u.call({source:"a",flags:"b"})})),v=s&&u.name!=c;(b||v)&&n(RegExp.prototype,c,(function(){var t=l(this),e=o(t.source),a=o(i(t));return"/"+e+"/"+a}),{unsafe:!0})},"49ab":function(t,e,a){},"628b":function(t,e,a){"use strict";a.r(e);var s=function(){var t=this,e=t._self._c;return e("div",{staticClass:"main-content"},[e("breadcumb",{attrs:{page:t.$t("revenue"),folder:t.$t("revenue_list")}}),e("b-col",{staticClass:"p-0",attrs:{lg:"12",xl:"12",md:"12"}},[e("b-row",[e("b-col",{attrs:{md:"6",lg:"4"}},[e("b-card",{staticClass:"mb-30 o-hidden px-2"},[e("b-row",{attrs:{"align-h":"between","align-v":"center"}},[e("div",[e("h6",{staticClass:"mb-2 text-muted"},[t._v(" "+t._s(t.$t("today_revenue"))+" ")]),e("h4",{staticClass:"mb-2 text-muted"},[t._v(" "+t._s(t.today_revenue)+" ")])])])],1)],1),e("b-col",{attrs:{md:"6",lg:"4"}},[e("b-card",{staticClass:"mb-30 o-hidden px-2"},[e("b-row",{attrs:{"align-h":"between","align-v":"center"}},[e("div",[e("h6",{staticClass:"mb-2 text-muted"},[t._v(" "+t._s(t.$t("month_revenue"))+" ")]),e("h4",{staticClass:"mb-2 text-muted"},[t._v(" "+t._s(t.month_revenue)+" ")])])])],1)],1),e("b-col",{attrs:{md:"6",lg:"4"}},[e("b-card",{staticClass:"mb-30 o-hidden px-2"},[e("b-row",{attrs:{"align-h":"between","align-v":"center"}},[e("div",[e("h6",{staticClass:"mb-2 text-muted"},[t._v(" "+t._s(t.$t("cumulative_profit"))+" ")]),e("h4",{staticClass:"mb-2 text-muted"},[t._v(" "+t._s(t.total_revenue)+" ")])])])],1)],1)],1)],1),e("b-card",{attrs:{title:t.$t("revenue_list")}},[e("vue-good-table",{attrs:{id:"table",mode:"remote",totalRows:t.totalRecords,isLoading:t.isLoading,columns:t.columns,"search-options":{enabled:!1,placeholder:"Search this table"},"pagination-options":{enabled:!1,perPageDropdownEnabled:!1,perPageDropdown:[10],dropdownAllowAll:!1,rowsPerPageLabel:t.$t("rowPerPage"),nextLabel:t.$t("next"),prevLabel:t.$t("previous"),mode:"pages",pageLabel:t.$t("page"),setCurrentPage:t.pageNumber},styleClass:"tableOne vgt-table table-striped",selectOptions:{enabled:!1,selectionInfoClass:"table-alert__box"},rows:t.rows},on:{"on-page-change":t.onPageChange},scopedSlots:t._u([{key:"table-row",fn:function(a){return["revenue"==a.column.field?e("span",[e("span",{staticStyle:{color:"green"}},[t._v(" +"+t._s(a.row.revenue)+" ")])]):"date"==a.column.field?e("span",[t._v(" "+t._s(a.row.date)+" ")]):"action"==a.column.field?e("span",[e("button",{staticClass:"btn btn-default btn-edit",attrs:{type:"submit"}},[e("i",{staticClass:"fa fa-copy"})])]):t._e()]}}])}),e("div",{staticClass:"align-items-center mobile-adjust"},[t.totalRecords>0?e("div",{staticClass:"d-flex flex-wrap align-items-center justify-content-start mt-3"},[e("p",{staticClass:"text-light text-16 mr-2"},[t._v(t._s(t.$t("total")))]),e("p",{staticClass:"text-muted text-16",staticStyle:{"font-weight":"bold"}},[t._v(" "+t._s(t.totalRecords)+" ")])]):e("div")])],1),e("Dialog",{ref:"msg"})],1)},n=[],l=a("5530"),o=(a("d3b7"),a("25f0"),a("14d9"),a("06e0")),r=a("402a"),i=a("9565"),c=a("2f62"),d={computed:Object(l["a"])(Object(l["a"])({},Object(c["c"])(["lang"])),{},{columns:function(){return[{label:"ID",text:"pid",field:"pid",thClass:"gull-th-class",value:"pid",sortable:!1},{label:this.$t("profit_amount")+"(USDT)",text:"revenue",field:"revenue",thClass:"gull-th-class",value:"revenue",sortable:!1},{label:this.$t("exchange"),text:"platform",field:"platform",thClass:"gull-th-class",value:"platform",sortable:!1},{label:this.$t("sell_currency"),text:"market",field:"market",thClass:"gull-th-class",value:"market",sortable:!1},{label:this.$t("sell_time"),text:"ctime",field:"ctime",thClass:"gull-th-class",value:"ctime",sortable:!1}]}}),components:{Dialog:i["a"]},data:function(){return{tabIndex:0,selectedId:null,isLoading:!1,totalRecords:0,pageNumber:1,start_date:"",end_date:"",date:"",today_revenue:"",total_revenue:"",month_revenue:"",rows:[]}},props:["success"],methods:{processDate:function(t){var e=new Date(t),a=e.getMinutes(),s=e.getHours();1==a.toString().length&&(a="0"+a),1==s.toString().length&&(s="0"+s);var n=e.getFullYear()+"-"+(e.getMonth()+1)+"-"+e.getDate()+" "+s+":"+a;return n},onPageChange:function(t){this.pageNumber=t.currentPage,this.loadItems();var e=this.$el.querySelector("#table"),a=e.offsetTop;window.scrollTo(0,a)},loadItems:function(){var t=this.$route.query.date,e=Object(o["H"])(t),a=this;this.isLoading=!0,e.then((function(t){var e=t.data.data.data.data;a.today_revenue=t.data.data.today_revenue,console.log(e),a.rows=e,a.totalRecords=t.data.data.total,a.isLoading=!1})).catch((function(t){a.$refs.msg.makeToast("warning",a.$t(Object(r["b"])(t)))}))},loadItems2:function(){var t=Object(o["K"])(this.start_date,this.end_date),e=this;this.isLoading=!0,t.then((function(t){e.total_revenue=t.data.data.total_revenue,e.month_revenue=t.data.data.month_revenue,e.isLoading=!1})).catch((function(t){e.$refs.msg.makeToast("warning",e.$t(Object(r["b"])(t)))}))}},watch:{lang:function(t){var e=this,a=e.wallets;if(e.walletOptions=[],"en"==t)for(var s in e.wallets){var n={};n["value"]=a[s].found_type,n["text"]=a[s].comments_en,e.walletOptions.push(n)}else for(var l in e.wallets){var o={};o["value"]=a[l].found_type,o["text"]=a[l].comments_cn,e.walletOptions.push(o)}}},created:function(){this.loadItems(),this.loadItems2()}},u=d,b=(a("c0df"),a("2877")),v=Object(b["a"])(u,s,n,!1,null,null,null);e["default"]=v.exports},"90d8":function(t,e,a){var s=a("c65b"),n=a("1a2d"),l=a("3a9b"),o=a("ad6d"),r=RegExp.prototype;t.exports=function(t){var e=t.flags;return void 0!==e||"flags"in r||n(t,"flags")||!l(r,t)?e:s(o,t)}},9565:function(t,e,a){"use strict";var s=function(){var t=this,e=t._self._c;return e("div")},n=[],l={methods:{makeToast:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,e=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(e,{variant:t,solid:!0})}},watch:{testProp:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"success",e=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(e,{variant:t,solid:!0})}}},o=l,r=a("2877"),i=Object(r["a"])(o,s,n,!1,null,null,null);e["a"]=i.exports},ad6d:function(t,e,a){"use strict";var s=a("825a");t.exports=function(){var t=s(this),e="";return t.hasIndices&&(e+="d"),t.global&&(e+="g"),t.ignoreCase&&(e+="i"),t.multiline&&(e+="m"),t.dotAll&&(e+="s"),t.unicode&&(e+="u"),t.unicodeSets&&(e+="v"),t.sticky&&(e+="y"),e}},c0df:function(t,e,a){"use strict";a("49ab")}}]);
//# sourceMappingURL=chunk-2a272ad8.12169a2d.js.map