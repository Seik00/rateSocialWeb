(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-ab8a785c"],{"0fea":function(t,e,a){"use strict";var s=a("fc3e"),r=a.n(s);r.a},"25f0":function(t,e,a){"use strict";var s=a("6eeb"),r=a("825a"),o=a("d039"),i=a("ad6d"),l="toString",n=RegExp.prototype,c=n[l],d=o((function(){return"/a/b"!=c.call({source:"a",flags:"b"})})),u=c.name!=l;(d||u)&&s(RegExp.prototype,l,(function(){var t=r(this),e=String(t.source),a=t.flags,s=String(void 0===a&&t instanceof RegExp&&!("flags"in n)?i.call(t):a);return"/"+e+"/"+s}),{unsafe:!0})},"2e29":function(t,e,a){},4672:function(t,e,a){"use strict";var s=a("2e29"),r=a.n(s);r.a},9565:function(t,e,a){"use strict";var s=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div")},r=[],o={methods:{makeToast:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,e=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(e,{variant:t,solid:!0})}},watch:{testProp:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"success",e=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(e,{variant:t,solid:!0})}}},i=o,l=a("2877"),n=Object(l["a"])(i,s,r,!1,null,null,null);e["a"]=n.exports},abeb:function(t,e,a){"use strict";a.r(e);var s=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"main-content"},[a("breadcumb",{attrs:{page:t.$t("userList"),folder:t.$t("userManage")}}),a("b-tabs",{attrs:{pills:"",align:"end"},model:{value:t.tabIndex,callback:function(e){t.tabIndex=e},expression:"tabIndex"}},[a("b-tab",{attrs:{title:t.$t("userList"),active:""},on:{click:t.clearData}},[a("b-card",{attrs:{title:t.$t("userList")}},[a("b-row",[a("b-col",{attrs:{md:"12"}},[a("b-card",{staticClass:"mb-30"},[a("b-row",{attrs:{"align-v":"center"}},[a("b-col",{attrs:{md:"2"}},[a("b-form-group",{attrs:{id:"input-group-1",label:"UID","label-for":"input-1"}},[a("b-form-input",{attrs:{id:"input-1",type:"text",required:"",placeholder:t.$t("Enter")+"UID"},model:{value:t.searchUID,callback:function(e){t.searchUID=e},expression:"searchUID"}})],1)],1),a("b-col",{attrs:{md:"2"}},[a("b-form-group",{attrs:{id:"input-group-1",label:t.$t("username"),"label-for":"input-1"}},[a("b-form-input",{attrs:{id:"input-1",type:"text",required:"",placeholder:t.$t("Enter")+t.$t("username")},model:{value:t.searchUsername,callback:function(e){t.searchUsername=e},expression:"searchUsername"}})],1)],1),a("b-col",{staticClass:"mt-3 mt-md-0",attrs:{md:"2"}},[a("b-form-group",{attrs:{id:"input-group-2",label:t.$t("mobile"),"label-for":"input-2"}},[a("b-form-input",{attrs:{id:"input-2",type:"text",required:"",placeholder:t.$t("Enter")+t.$t("mobile")},model:{value:t.searchPhone,callback:function(e){t.searchPhone=e},expression:"searchPhone"}})],1)],1),a("b-col",{staticClass:"mt-3 mt-md-0",attrs:{md:"1"}},[a("b-button",{attrs:{variant:"primary"},on:{click:t.onSearch}},[t._v(t._s(t.$t("search")))])],1),t.canClear?a("b-col",{staticClass:"mt-3 mt-md-0",attrs:{md:"1"}},[a("b-button",{attrs:{variant:"danger"},on:{click:t.onCancel}},[t._v(t._s(t.$t("clear")))])],1):t._e()],1)],1)],1)],1),a("vue-good-table",{attrs:{id:"table",mode:"remote",totalRows:t.totalRecords,isLoading:t.isLoading,columns:t.columns,"search-options":{enabled:!1,placeholder:"Search this table"},"pagination-options":{enabled:!1,perPageDropdownEnabled:!1,perPageDropdown:[10],dropdownAllowAll:!1,rowsPerPageLabel:t.$t("rowPerPage"),nextLabel:t.$t("next"),prevLabel:t.$t("previous"),mode:"pages",pageLabel:t.$t("page"),setCurrentPage:t.pageNumber},styleClass:"tableOne vgt-table table-striped",selectOptions:{enabled:!1,selectionInfoClass:"table-alert__box"},rows:t.rows},on:{"on-page-change":t.onPageChange,"on-search":t.onSearch},scopedSlots:t._u([{key:"table-row",fn:function(e){return["contact_number"==e.column.field?a("span",[e.row.contact_number?a("span",[t._v(" "+t._s(e.row.country.country_code+e.row.contact_number)+" ")]):t._e()]):"user_group_id"==e.column.field?a("span",["en"==t.$i18n.locale?a("span",[t._v(" "+t._s(e.row.package.package_name_en)+" ")]):a("span",[t._v(t._s(e.row.package.package_name))])]):"wr"==e.column.field?a("span",[e.row.wr?a("span",{staticStyle:{color:"green"}},[a("i",{staticClass:"fa fa-check"})]):a("span",{staticStyle:{color:"red"}},[a("i",{staticClass:"fa fa-remove"})])]):"wt"==e.column.field?a("span",[e.row.wt?a("span",{staticStyle:{color:"green"}},[a("i",{staticClass:"fa fa-check"})]):a("span",{staticStyle:{color:"red"}},[a("i",{staticClass:"fa fa-remove"})])]):"rb"==e.column.field?a("span",[e.row.rb?a("span",{staticStyle:{color:"green"}},[a("i",{staticClass:"fa fa-check"})]):a("span",{staticStyle:{color:"red"}},[a("i",{staticClass:"fa fa-remove"})])]):"created_at"==e.column.field?a("span",[t._v(" "+t._s(t.processDate(e.row.created_at))+" ")]):"action"==e.column.field?a("span",[a("button",{directives:[{name:"b-popover",rawName:"v-b-popover.hover.top",value:t.$t("editUser"),expression:"$t('editUser')",modifiers:{hover:!0,top:!0}}],staticClass:"btn btn-default btn-edit",attrs:{type:"button"},on:{click:function(a){return t.editUser(e.row)}}},[a("i",{staticClass:"fa fa-pencil"})]),a("button",{directives:[{name:"b-popover",rawName:"v-b-popover.hover.top",value:t.$t("updatePwd"),expression:"$t('updatePwd')",modifiers:{hover:!0,top:!0}}],staticClass:"btn btn-default btn-push mx-1 px-2",attrs:{type:"button"},on:{click:function(a){return t.showModal(e.row)}}},[a("i",{staticClass:"fa fa-shield"})]),a("button",{directives:[{name:"b-popover",rawName:"v-b-popover.hover.top",value:t.$t("walletRecord"),expression:"$t('walletRecord')",modifiers:{hover:!0,top:!0}}],staticClass:"btn btn-default btn-wallet mr-1",attrs:{type:"button"},on:{click:function(a){return t.showWallet(e.row.username)}}},[a("i",{staticClass:"fa fa-money"})]),a("button",{directives:[{name:"b-popover",rawName:"v-b-popover.hover.top",value:t.$t("settings"),expression:"$t('settings')",modifiers:{hover:!0,top:!0}}],staticClass:"btn btn-default btn-delete mr-1",attrs:{type:"button"},on:{click:function(a){return t.showSettings(e.row.id,e.row.setting)}}},[a("i",{staticClass:"fa fa-gear"})])]):t._e()]}}])}),a("div",{staticClass:"align-items-center mobile-adjust"},[t.totalRecords>0?a("div",{staticClass:"\n              d-flex\n              flex-wrap\n              align-items-center\n              justify-content-start\n              mt-3\n            "},[a("p",{staticClass:"text-light text-16 mr-2"},[t._v(t._s(t.$t("total")))]),a("p",{staticClass:"text-muted text-16",staticStyle:{"font-weight":"bold"}},[t._v(" "+t._s(t.totalRecords)+" ")])]):a("div"),a("div",{staticClass:"d-flex flex-wrap align-items-center justify-content-end"},[a("b-pagination",{staticClass:"pagi-margin pt-3",attrs:{"total-rows":t.totalRecords,"per-page":10,"first-text":t.$t("first"),"prev-text":t.$t("prev"),"next-text":t.$t("next"),"last-text":t.$t("last")},on:{input:function(e){return t.loadItems()}},model:{value:t.pageNumber,callback:function(e){t.pageNumber=e},expression:"pageNumber"}}),a("b-input-group",{staticClass:"ml-3",staticStyle:{width:"160px"}},[a("b-form-input",{attrs:{placeholder:t.$t("PageNo")},model:{value:t.pageNumber,callback:function(e){t.pageNumber=e},expression:"pageNumber"}}),a("b-input-group-append",[a("b-button",{attrs:{variant:"primary"},on:{keypress:function(e){return t.loadItems()},click:function(e){return t.loadItems()}}},[t._v(t._s(t.$t("go")))])],1)],1)],1)])],1)],1),a("b-tab",{attrs:{title:t.$t("editUser"),"title-item-class":{hiddenClass:!t.canEdit}}},[a("b-card",{attrs:{title:t.$t("editUser")}},[a("b-row",{attrs:{"align-h":"center"}},[a("b-col",{attrs:{md:"8 mb-30"}},[a("b-form",{on:{submit:function(e){return e.preventDefault(),t.updateUser(e)}}},[a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-sm-2 col-form-label",attrs:{for:"username2"}},[t._v(t._s(t.$t("username")))]),a("div",{staticClass:"col-sm-10"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.username,expression:"username"}],staticClass:"form-control",attrs:{type:"text",id:"username"},domProps:{value:t.username},on:{input:function(e){e.target.composing||(t.username=e.target.value)}}})])]),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-sm-2 col-form-label",attrs:{for:"email"}},[t._v(t._s(t.$t("email")))]),a("div",{staticClass:"col-sm-10"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.email,expression:"email"}],staticClass:"form-control",attrs:{type:"text",id:"email"},domProps:{value:t.email},on:{input:function(e){e.target.composing||(t.email=e.target.value)}}})])]),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-sm-2 col-form-label",attrs:{for:"d_password"}},[t._v(t._s(t.$t("password")))]),a("div",{staticClass:"col-sm-10"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.password,expression:"password"}],staticClass:"form-control",attrs:{type:"text",id:"d_password",readonly:""},domProps:{value:t.password},on:{input:function(e){e.target.composing||(t.password=e.target.value)}}})])]),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-sm-2 col-form-label",attrs:{for:"d_password"}},[t._v(t._s(t.$t("boost_limit")))]),a("div",{staticClass:"col-sm-10"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.boost_limit,expression:"boost_limit"}],staticClass:"form-control",attrs:{type:"number",id:"boost_limit",min:"0"},domProps:{value:t.boost_limit},on:{input:function(e){e.target.composing||(t.boost_limit=e.target.value)}}}),a("div",{staticStyle:{color:"red"}},[t._v(" "+t._s(t.$t("remind"))+" ")])])]),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-sm-2 col-form-label",attrs:{for:"day_limit"}},[t._v(t._s(t.$t("day_limit")))]),a("div",{staticClass:"col-sm-10"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.day_limit,expression:"day_limit"}],staticClass:"form-control",attrs:{type:"number",id:"day_limit",min:"0"},domProps:{value:t.day_limit},on:{input:function(e){e.target.composing||(t.day_limit=e.target.value)}}}),a("div",{staticStyle:{color:"red"}},[t._v(" "+t._s(t.$t("day_limit_hint"))+" ")])])]),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-sm-2 col-form-label",attrs:{for:"country"}},[t._v(t._s(t.$t("country")))]),a("div",{staticClass:"col-sm-10"},[a("b-form-select",{attrs:{options:t.countryOptions,id:"country"},model:{value:t.country,callback:function(e){t.country=e},expression:"country"}})],1)]),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-sm-2 col-form-label",attrs:{for:"package"}},[t._v(t._s(t.$t("package")))]),a("div",{staticClass:"col-sm-10"},[a("b-form-select",{attrs:{options:t.selectOptions,id:"package"},model:{value:t.packageType,callback:function(e){t.packageType=e},expression:"packageType"}})],1)]),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-sm-2 col-form-label",attrs:{for:"wr"}},[t._v(t._s(t.$t("wr")))]),a("div",{staticClass:"col-sm-10 py-2"},[a("label",{staticClass:"switch switch-primary mr-3"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.wr,expression:"wr"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.wr)?t._i(t.wr,null)>-1:t.wr},on:{change:function(e){var a=t.wr,s=e.target,r=!!s.checked;if(Array.isArray(a)){var o=null,i=t._i(a,o);s.checked?i<0&&(t.wr=a.concat([o])):i>-1&&(t.wr=a.slice(0,i).concat(a.slice(i+1)))}else t.wr=r}}}),a("span",{staticClass:"slider"})])])]),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-sm-2 col-form-label",attrs:{for:"wt"}},[t._v(t._s(t.$t("wt")))]),a("div",{staticClass:"col-sm-10 py-2"},[a("label",{staticClass:"switch switch-primary mr-3"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.wt,expression:"wt"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.wt)?t._i(t.wt,null)>-1:t.wt},on:{change:function(e){var a=t.wt,s=e.target,r=!!s.checked;if(Array.isArray(a)){var o=null,i=t._i(a,o);s.checked?i<0&&(t.wt=a.concat([o])):i>-1&&(t.wt=a.slice(0,i).concat(a.slice(i+1)))}else t.wt=r}}}),a("span",{staticClass:"slider"})])])]),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-sm-2 col-form-label",attrs:{for:"rb"}},[t._v(t._s(t.$t("rb")))]),a("div",{staticClass:"col-sm-10 py-2"},[a("label",{staticClass:"switch switch-primary mr-3"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.rb,expression:"rb"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.rb)?t._i(t.rb,null)>-1:t.rb},on:{change:function(e){var a=t.rb,s=e.target,r=!!s.checked;if(Array.isArray(a)){var o=null,i=t._i(a,o);s.checked?i<0&&(t.rb=a.concat([o])):i>-1&&(t.rb=a.slice(0,i).concat(a.slice(i+1)))}else t.rb=r}}}),a("span",{staticClass:"slider"})])])]),a("div",{staticClass:"form-group row justify-content-end"},[a("div",{staticClass:"col-sm-12"},[a("div",{staticClass:"mt-4 float-right"},[a("b-button",{staticClass:"m-1",attrs:{type:"submit",variant:"primary"}},[t._v(t._s(t.$t("update")))])],1)])])])],1)],1)],1)],1),a("b-tab",{attrs:{title:t.$t("walletRecord")+"("+t.searchUsernameWallet+")","title-item-class":{hiddenClass:!t.canShow}}},[a("b-row",[a("b-col",{attrs:{md:"12"}},[a("b-card",{staticClass:"mb-30"},[a("b-row",{attrs:{"align-v":"center"}},[a("b-col",{staticClass:"mt-3 mt-md-0",attrs:{md:"2"}},[a("b-form-group",{attrs:{id:"walletType",label:t.$t("wallet"),"label-for":"walletType"}},[a("b-form-select",{attrs:{options:t.walletOptions,id:"walletType"},on:{change:function(e){return t.showWallet(t.searchUsernameWallet)}},model:{value:t.selectWalletType,callback:function(e){t.selectWalletType=e},expression:"selectWalletType"}})],1)],1),a("b-col",{staticClass:"mt-3 mt-md-0",attrs:{md:"3"}},[a("b-form-group",{attrs:{id:"input-group-2",label:t.$t("from"),"label-for":"input-2"}},[a("b-form-input",{attrs:{id:"input-2",type:"date"},model:{value:t.from,callback:function(e){t.from=e},expression:"from"}})],1)],1),a("b-col",{staticClass:"mt-3 mt-md-0",attrs:{md:"3"}},[a("b-form-group",{attrs:{id:"input-group-2",label:t.$t("to"),"label-for":"input-2"}},[a("b-form-input",{attrs:{id:"input-2",type:"date"},model:{value:t.to,callback:function(e){t.to=e},expression:"to"}})],1)],1),a("b-col",{staticClass:"mt-3 mt-md-0",attrs:{md:"1"}},[a("b-button",{attrs:{variant:"primary"},on:{click:t.onSearchWallet}},[t._v(t._s(t.$t("search")))])],1),t.canClearWallet?a("b-col",{staticClass:"mt-3 mt-md-0",attrs:{md:"1"}},[a("b-button",{attrs:{variant:"danger"},on:{click:t.onCancelWallet}},[t._v(t._s(t.$t("clear")))])],1):t._e()],1)],1)],1)],1),a("b-card",{attrs:{title:t.$t("totalBalance")+t.totalBalance}},[a("vue-good-table",{attrs:{id:"table",mode:"remote",totalRows:t.totalWalletRecords,isLoading:t.isLoading,columns:t.walletLabel,"search-options":{enabled:!1,placeholder:"Search this table"},"pagination-options":{enabled:!1,perPageDropdownEnabled:!1,perPageDropdown:[10],dropdownAllowAll:!1,rowsPerPageLabel:t.$t("rowPerPage"),nextLabel:t.$t("next"),prevLabel:t.$t("previous"),mode:"pages",pageLabel:t.$t("page"),setCurrentPage:t.walletPageNumber},styleClass:"tableOne vgt-table table-striped",selectOptions:{enabled:!1,selectionInfoClass:"table-alert__box"},rows:t.walletRows},on:{"on-page-change":t.onWalletPageChange,"on-search":t.onSearch},scopedSlots:t._u([{key:"table-row",fn:function(e){return["detail"==e.column.field?a("span",["zh"==t.$i18n.locale?a("span",[t._v(" "+t._s(e.row.detail)+" ")]):a("span",[t._v(" "+t._s(e.row.detailen)+" ")])]):"found"==e.column.field?a("span",[1==e.row.out_type?a("span",{staticStyle:{color:"red"}},[t._v(" -"+t._s(e.row.found)+" ")]):a("span",{staticStyle:{color:"green"}},[t._v(" +"+t._s(e.row.found)+" ")])]):"created_at"==e.column.field?a("span",[t._v(" "+t._s(e.row.created_at)+" ")]):t._e()]}}])}),a("div",{staticClass:"align-items-center mobile-adjust"},[t.totalWalletRecords>0?a("div",{staticClass:"\n              d-flex\n              flex-wrap\n              align-items-center\n              justify-content-start\n              mt-3\n            "},[a("p",{staticClass:"text-light text-16 mr-2"},[t._v(t._s(t.$t("total")))]),a("p",{staticClass:"text-muted text-16",staticStyle:{"font-weight":"bold"}},[t._v(" "+t._s(t.totalWalletRecords)+" ")])]):a("div"),a("div",{staticClass:"d-flex flex-wrap align-items-center justify-content-end"},[a("b-pagination",{staticClass:"pagi-margin pt-3",attrs:{"total-rows":t.totalWalletRecords,"per-page":10,"first-text":t.$t("first"),"prev-text":t.$t("prev"),"next-text":t.$t("next"),"last-text":t.$t("last")},on:{input:t.getWRecord},model:{value:t.walletPageNumber,callback:function(e){t.walletPageNumber=e},expression:"walletPageNumber"}}),a("b-input-group",{staticClass:"ml-3",staticStyle:{width:"160px"}},[a("b-form-input",{attrs:{placeholder:t.$t("PageNo")},model:{value:t.walletPageNumber,callback:function(e){t.walletPageNumber=e},expression:"walletPageNumber"}}),a("b-input-group-append",[a("b-button",{attrs:{variant:"primary"},on:{keypress:t.getWRecord,click:t.getWRecord}},[t._v(t._s(t.$t("go")))])],1)],1)],1)])],1)],1),a("b-tab",{attrs:{title:t.$t("settings"),"title-item-class":{hiddenClass:!t.canSettings}}},[a("b-card",{attrs:{title:t.$t("settings")}},[a("b-row",{attrs:{"align-h":"center"}},[a("b-col",{attrs:{md:"12 mb-30"}},[a("b-form",{on:{submit:function(e){return e.preventDefault(),t.updateSettings(e)}}},[t._l(t.form.setting,(function(e,s){return a("div",{key:e.id,staticClass:"form-group row"},[a("label",{staticClass:"col-sm-1 col-form-label"},[t._v(t._s(t.$t("order")+"No"+(s+1)))]),a("div",{staticClass:"col-sm-1"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.setting[s]["order"],expression:"form.setting[index]['order']"}],staticClass:"form-control",attrs:{type:"number",min:"1",step:"0.01",required:""},domProps:{value:t.form.setting[s]["order"]},on:{input:function(e){e.target.composing||t.$set(t.form.setting[s],"order",e.target.value)}}})]),a("label",{staticClass:"col-sm-1 col-form-label"},[t._v(t._s(t.$t("price")+"(USD) No"+(s+1)))]),a("div",{staticClass:"col-sm-1"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.setting[s]["price"],expression:"form.setting[index]['price']"}],staticClass:"form-control",attrs:{type:"number",min:"0",step:"0.01",required:""},domProps:{value:t.form.setting[s]["price"]},on:{input:function(e){e.target.composing||t.$set(t.form.setting[s],"price",e.target.value)}}})]),a("label",{staticClass:"col-sm-1 col-form-label"},[t._v(t._s(t.$t("profit")+"(%) No"+(s+1)))]),a("div",{staticClass:"col-sm-1"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.setting[s]["profit_rate"],expression:"form.setting[index]['profit_rate']"}],staticClass:"form-control",attrs:{type:"number",min:"0",step:"0.01",required:""},domProps:{value:t.form.setting[s]["profit_rate"]},on:{input:function(e){e.target.composing||t.$set(t.form.setting[s],"profit_rate",e.target.value)}}})]),a("label",{staticClass:"col-sm-2 col-form-label"},[t._v(t._s(t.$t("products_price")+" No"+(s+1)))]),a("div",{staticClass:"col-sm-3"},[a("SearchModal",{attrs:{index:s,products:t.productOptions,id:t.form.setting[s]["product_id"]},on:{_productID:t.changeID}})],1)])})),a("div",{staticClass:"form-group row justify-content-end"},[a("div",{staticClass:"col-sm-12"},[a("div",{staticClass:"mt-4 float-right"},[a("b-button",{staticClass:"m-1",attrs:{type:"submit",variant:"primary"}},[t._v(t._s(t.$t("update")))])],1)])])],2)],1)],1)],1)],1),a("b-tab",{attrs:{title:t.$t("settings")+"2","title-item-class":{hiddenClass:!t.canSettings2}}},[a("b-card",{attrs:{title:t.$t("settings")+"2"}},[a("b-row",{attrs:{"align-h":"center"}},[a("b-col",{attrs:{md:"12 mb-30"}},[a("b-form",{on:{submit:function(e){return e.preventDefault(),t.updateSettings(e)}}},[t._l(t.form.setting2,(function(e,s){return a("div",{key:e.id,staticClass:"form-group row"},[a("label",{staticClass:"col-sm-1 col-form-label"},[t._v(t._s(t.$t("order")+"No"+(s+1)))]),a("div",{staticClass:"col-sm-1"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.setting2[s]["order"],expression:"form.setting2[index]['order']"}],staticClass:"form-control",attrs:{type:"number",min:"1",step:"0.01",required:""},domProps:{value:t.form.setting2[s]["order"]},on:{input:function(e){e.target.composing||t.$set(t.form.setting2[s],"order",e.target.value)}}})]),a("label",{staticClass:"col-sm-1 col-form-label"},[t._v(t._s(t.$t("price")+"(USD) No"+(s+1)))]),a("div",{staticClass:"col-sm-1"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.setting2[s]["price"],expression:"form.setting2[index]['price']"}],staticClass:"form-control",attrs:{type:"number",min:"0",step:"0.01",required:""},domProps:{value:t.form.setting2[s]["price"]},on:{input:function(e){e.target.composing||t.$set(t.form.setting2[s],"price",e.target.value)}}})]),a("label",{staticClass:"col-sm-1 col-form-label"},[t._v(t._s(t.$t("profit")+"(%) No"+(s+1)))]),a("div",{staticClass:"col-sm-1"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.setting2[s]["profit_rate"],expression:"form.setting2[index]['profit_rate']"}],staticClass:"form-control",attrs:{type:"number",min:"0",step:"0.01",required:""},domProps:{value:t.form.setting2[s]["profit_rate"]},on:{input:function(e){e.target.composing||t.$set(t.form.setting2[s],"profit_rate",e.target.value)}}})]),a("label",{staticClass:"col-sm-2 col-form-label"},[t._v(t._s(t.$t("products_price")+" No"+(s+1)))]),a("div",{staticClass:"col-sm-3"},[a("SearchModal",{attrs:{index:s,products:t.productOptions2,id:t.form.setting2[s]["product_id"]},on:{_productID:t.changeID2}})],1)])})),a("div",{staticClass:"form-group row justify-content-end"},[a("div",{staticClass:"col-sm-12"},[a("div",{staticClass:"mt-4 float-right"},[a("b-button",{staticClass:"m-1",attrs:{type:"submit",variant:"primary"}},[t._v(t._s(t.$t("update")))])],1)])])],2)],1)],1)],1)],1)],1),a("b-modal",{attrs:{id:"modal-1",size:"md",centered:"",title:t.$t("updatePwd"),"hide-footer":!0}},[a("b-tabs",{attrs:{pills:""}},[a("b-tab",{staticClass:"m-0",attrs:{title:t.$t("password"),active:""},on:{click:t.clearData}},[a("b-form",{staticClass:"mx-5",on:{submit:function(e){return e.preventDefault(),t.updatePwd(e)}}},[a("b-row",{attrs:{"align-h":"center"}},[a("b-col",{attrs:{md:"12 my-30"}},[a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-sm-3 col-form-label",attrs:{for:"title2"}},[t._v(t._s(t.$t("username")))]),a("div",{staticClass:"col-sm-9"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.username,expression:"username"}],staticClass:"form-control",attrs:{type:"text",id:"title2",readonly:""},domProps:{value:t.username},on:{input:function(e){e.target.composing||(t.username=e.target.value)}}})])]),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-sm-3 col-form-label",attrs:{for:"password"}},[t._v(t._s(t.$t("password")))]),a("div",{staticClass:"col-sm-9"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.password,expression:"password"}],staticClass:"form-control",attrs:{type:"password",id:"password",required:""},domProps:{value:t.password},on:{input:function(e){e.target.composing||(t.password=e.target.value)}}})])]),a("div",{staticClass:"form-group row justify-content-end"},[a("div",{staticClass:"col-sm-12"},[a("div",{staticClass:"mt-4 float-right"},[a("b-button",{staticClass:"m-1",attrs:{type:"submit",variant:"primary"}},[t._v(t._s(t.$t("update")))])],1)])])])],1)],1)],1),a("b-tab",{staticClass:"m-0",attrs:{title:t.$t("password2")},on:{click:t.clearData}},[a("b-form",{staticClass:"mx-5",on:{submit:function(e){return e.preventDefault(),t.updatePwd2(e)}}},[a("b-row",{attrs:{"align-h":"center"}},[a("b-col",{attrs:{md:"12 my-30"}},[a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-sm-3 col-form-label",attrs:{for:"title2"}},[t._v(t._s(t.$t("username")))]),a("div",{staticClass:"col-sm-9"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.username,expression:"username"}],staticClass:"form-control",attrs:{type:"text",id:"title2",readonly:""},domProps:{value:t.username},on:{input:function(e){e.target.composing||(t.username=e.target.value)}}})])]),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-sm-3 col-form-label",attrs:{for:"password"}},[t._v(t._s(t.$t("password2")))]),a("div",{staticClass:"col-sm-9"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.password2,expression:"password2"}],staticClass:"form-control",attrs:{type:"password",id:"password",required:""},domProps:{value:t.password2},on:{input:function(e){e.target.composing||(t.password2=e.target.value)}}})])]),a("div",{staticClass:"form-group row justify-content-end"},[a("div",{staticClass:"col-sm-12"},[a("div",{staticClass:"mt-4 float-right"},[a("b-button",{staticClass:"m-1",attrs:{type:"submit",variant:"primary"}},[t._v(t._s(t.$t("update")))])],1)])])])],1)],1)],1)],1)],1),a("Dialog",{ref:"msg"})],1)},r=[],o=(a("b0c0"),a("d3b7"),a("25f0"),a("5530")),i=a("06e0"),l=a("9565"),n=a("402a"),c=a("2f62"),d=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.productText,expression:"productText"}],staticClass:"form-control",attrs:{id:t.index,type:"text",readonly:""},domProps:{value:t.productText},on:{click:t.showModal,input:function(e){e.target.composing||(t.productText=e.target.value)}}}),a("b-modal",{attrs:{id:"modal-search"+t.index,size:"md",centered:"",title:t.$t("products_price")+" No"+(t.index+1)},on:{ok:t.handleOk}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.price,expression:"price"}],staticClass:"form-control",attrs:{type:"number",min:"0",step:"0.01",placeholder:t.$t("inputPrice")},domProps:{value:t.price},on:{input:[function(e){e.target.composing||(t.price=e.target.value)},t.loadItems]}}),a("div",{staticClass:"mt-4",staticStyle:{height:"300px",position:"relative","overflow-y":"scroll"}},[t.isSearching||t.productList.length<=0?a("div",{staticStyle:{position:"absolute",top:"50%",left:"50%",transform:"translate(-50%, -50%)",height:"100%",width:"100%","z-index":"3",display:"flex","justify-content":"center","align-items":"center"}},[t.isSearching?a("div",{staticClass:"spinner spinner-primary m-2 text-50"}):t.productList.length<=0?a("div",[a("span",[t._v(t._s(t.$t("nodataInPrice")))])]):t._e()]):t._e(),a("b-list-group",t._l(t.productList,(function(e){return a("b-list-group-item",{key:e.id,attrs:{button:""},on:{click:function(a){return t.selectProduct(e)}}},[t._v(t._s("("+e.price+") "+e.name))])})),1)],1)])],1)},u=[],p={props:["index","products","id"],computed:Object(o["a"])({},Object(c["c"])(["lang"]),{productText:function(){if(null!=this.id&&""!=this.id){for(var t="",e=0;e<this.products.length;e++)(this.products[e].value==this.productID||this.products[e].value==this.id)&&(t=this.products[e].text);return t}return null}}),data:function(){return{isSearching:!0,isClicked:!1,price:"",productList:[],productID:null,preProductID:null}},methods:{handleOk:function(){console.log("clicked");var t={};this.isClicked=!0,this.productID=this.preProductID,t["index"]=this.index,t["productID"]=this.productID,this.$emit("_productID",t)},selectProduct:function(t){this.preProductID=t.id},showModal:function(){this.isClicked=!1,this.$bvModal.show("modal-search"+this.index),this.loadItems()},loadItems:function(){this.productList=[];var t=Object(i["gb"])(this.price),e=this;this.isSearching=!0,t.then((function(t){e.productList=t.data.data.record,e.isSearching=!1})).catch((function(t){e.$refs.msg.makeToast("warning",e.$t(Object(n["b"])(t)))}))}},created:function(){}},m=p,f=a("2877"),b=Object(f["a"])(m,d,u,!1,null,null,null),g=b.exports,h={computed:Object(o["a"])({},Object(c["c"])(["lang"]),{walletOptions:function(){return[{value:"point1",text:"USDT"},{value:"point2",text:this.$t("gasFee")},{value:"point3",text:this.$t("gasPanning")}]},walletLabel:function(){return[{label:this.$t("id"),text:"id",field:"id",thClass:"gull-th-class",value:"id",sortable:!1},{label:this.$t("username"),text:"username",field:"user.username",thClass:"gull-th-class",value:"username",sortable:!1},{label:this.$t("previousBalance"),text:"previous",field:"previous",thClass:"gull-th-class",value:"previous",sortable:!1},{label:this.$t("founds"),text:"found",field:"found",thClass:"gull-th-class",value:"found",sortable:!1},{label:this.$t("currentBalance"),text:"current",field:"current",thClass:"gull-th-class",value:"current",sortable:!1},{label:this.$t("detail"),text:"detail",field:"detail",thClass:"gull-th-class",value:"detail",sortable:!1},{label:this.$t("created_at"),text:"created_at",field:"created_at",thClass:"gull-th-class",value:"created_at",sortable:!1}]},columns:function(){return[{label:this.$t("id"),text:"id",field:"id",thClass:"gull-th-class",value:"id",sortable:!1},{label:this.$t("username"),text:"username",field:"username",thClass:"gull-th-class",value:"username",sortable:!1},{label:this.$t("email"),text:"email",field:"email",thClass:"gull-th-class",value:"email",sortable:!1},{label:this.$t("sponsorname"),text:"sponsorName",field:"sponsor.username",thClass:"gull-th-class",value:"sponsorName",sortable:!1},{label:this.$t("ref_id"),text:"ref_code",field:"ref_code",thClass:"gull-th-class",value:"ref_code",sortable:!1},{label:this.$t("password"),text:"password",field:"d_password",thClass:"gull-th-class",value:"password",sortable:!1},{label:this.$t("password2"),text:"password",field:"d_password2",thClass:"gull-th-class",value:"password",sortable:!1},{label:"USDT",text:"USDT",field:"point1",thClass:"gull-th-class",value:"USDT",sortable:!1},{label:this.$t("freeze_wallet"),text:"freeze_wallet",field:"point2",thClass:"gull-th-class",value:"freeze_wallet",sortable:!1},{label:this.$t("da_asset"),text:"da_asset",field:"asset_active",thClass:"gull-th-class",value:"da_asset",sortable:!1},{label:this.$t("da_freeze_asset"),text:"freeze_asset",field:"asset_frozen",thClass:"gull-th-class",value:"freeze_asset",sortable:!1},{label:this.$t("package"),text:"user_group_id",field:"user_group_id",thClass:"gull-th-class",value:"user_group_id",sortable:!1},{label:this.$t("registerDate"),text:"created_at",field:"created_at",thClass:"gull-th-class",value:"created_at",tdClass:"dateWidth",sortable:!1},{label:this.$t("action"),field:"action",tdClass:"bodyWidth",sortable:!1}]}}),components:{Dialog:l["a"],SearchModal:g},data:function(){return{username:"",email:"",boost_limit:"",day_limit:"",form:{user_id:"",setting:[],setting2:[]},setting:[],setting2:[],password:"",password2:"",contact_number:"",country_id:"",user_group_id:"",wr:!1,rb:!1,wt:!1,selectWalletType:"point1",from:"",to:"",canClearWallet:!1,searchUsernameWallet:"",uid:"",totalBalance:0,totalWalletRecords:0,searchUsername:"",searchPhone:"",searchUID:"",isLoading:!1,canClear:!1,totalRecords:0,pageNumber:1,walletPageNumber:1,rows:[],walletRows:[],tabIndex:0,canEdit:!1,canShow:!1,canSettings:!1,canSettings2:!1,packageType:"1",productType:"",country:null,countryOptions:[],package:[],product:[],selectOptions:[],productOptions:[],productOptions2:[],countryList:[],fields:{text:"text",value:"value"},defaultSettingList:[]}},methods:{changeSettingValue:function(t){console.log(t)},processDate:function(t){var e=new Date(t),a=e.getMinutes(),s=e.getHours();1==a.toString().length&&(a="0"+a),1==s.toString().length&&(s="0"+s);var r=e.getFullYear()+"-"+(e.getMonth()+1)+"-"+e.getDate()+" "+s+":"+a;return r},makeToast:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,e=arguments.length>1?arguments[1]:void 0;this.$bvToast.toast(e,{variant:t,solid:!0})},onPageChange:function(t){this.pageNumber=t.currentPage,this.loadItems();var e=this.$el.querySelector("#table"),a=e.offsetTop;window.scrollTo(0,a)},onWalletPageChange:function(t){this.walletPageNumber=t.currentPage,this.getWRecord();var e=this.$el.querySelector("#table"),a=e.offsetTop;window.scrollTo(0,a)},onSearch:function(){this.pageNumber=1,""==this.searchUsername&&""==this.searchPhone&&""==this.searchUID||(this.canClear=!0),this.loadItems()},onCancel:function(){this.searchUsername="",this.searchPhone="",this.searchUID="",this.canClear=!1,this.loadItems()},onSearchWallet:function(){""==this.searchUsernameWallet&&""==this.from&&""==this.to||(this.canClearWallet=!0),this.showWallet(this.searchUsernameWallet)},onCancelWallet:function(){this.from="",this.to="",this.canClearWallet=!1,this.showWallet(this.searchUsernameWallet)},clearData:function(){if(void 0!=this.$refs.dropdownObj)for(var t=0;t<this.$refs.dropdownObj.length;t++)this.$refs.dropdownObj[t].ej2Instances.value=null;this.canEdit=!1,this.canShow=!1,this.canSettings=!1,this.canSettings2=!1;var e=this;e.selectedId=null},showModal:function(t){this.$bvModal.show("modal-1");var e=this,a=t;e.username=a.username},showWallet:function(t){this.canShow=!0,this.tabIndex=2,this.searchUsernameWallet=t,this.walletRows=[],this.totalBalance=0,this.totalWalletRecords=0,this.walletPageNumber=1,this.getWRecord()},changeID:function(t){console.log("Event from child component emitted",t),this.form.setting[t.index]["product_id"]=t.productID,console.log(t.index,this.form.setting[t.index]["product_id"])},changeID2:function(t){console.log("Event from child component emitted",t),this.form.setting2[t.index]["product_id"]=t.productID,console.log(t.index,this.form.setting2[t.index]["product_id"])},showSettings:function(t,e){if(this.form.setting=[],this.form.setting2=[],this.form.user_id=t,this.canSettings=!0,this.tabIndex=3,this.uid=t,console.log(JSON.parse(e)),null==e)for(var a=0;a<this.defaultSettingList.length;a++){var s=JSON.parse(this.defaultSettingList),r={};r["order"]=s[a].order,r["price"]=s[a].price,r["profit_rate"]=s[a].profit_rate,r["product_id"]=s[a].product_id,this.form.setting.push(r)}else this.form.setting=JSON.parse(e)},showSettings2:function(t,e){if(this.form.setting=[],this.form.setting2=[],this.form.user_id=t,this.canSettings2=!0,this.tabIndex=4,this.uid=t,console.log(JSON.parse(e)),null==e)for(var a=0;a<30;a++){var s={order:1,price:0,profit_rate:0,product_id:""};this.form.setting2.push(s)}else this.form.setting2=JSON.parse(e)},getWRecord:function(){var t=Object(i["V"])(this.selectWalletType,this.searchUsernameWallet,this.from,this.to,this.walletPageNumber),e=this;this.isLoading=!0,t.then((function(t){var a=t.data.data.record.data;e.walletRows=a,e.totalBalance=t.data.data.balance,e.totalWalletRecords=t.data.data.record.total,e.isLoading=!1})).catch((function(t){e.$refs.msg.makeToast("warning",e.$t(Object(n["b"])(t)))}))},editUser:function(t){this.canEdit=!0;var e=this;e.tabIndex=1;var a=t;e.selectedId=a.id,e.username=a.username,e.email=a.email,e.contact_number=a.contact_number,e.country=a.country.id,e.password=a.d_password,e.password2=a.d_password2,e.boost_limit=a.boost_limit,e.day_limit=a.day_limit,e.packageType=a.package.id,e.wr=1==a.wr,e.wt=1==a.wt,e.rb=1==a.rb},updatePwd:function(){var t=new FormData;t.append("username",this.username),t.append("password",this.password),t.append("pwd_type","pwd");var e=Object(i["lb"])(t),a=this;e.then((function(){a.$refs.msg.makeToast("success",a.$t("successUpdate")),a.tabIndex=0,a.rows=[],a.canEdit=!1,a.loadItems(),a.$bvModal.hide("modal-1")})).catch((function(t){a.$refs.msg.makeToast("warning",a.$t(Object(n["b"])(t)))})),this.password=""},updatePwd2:function(){var t=new FormData;t.append("username",this.username),t.append("password",this.password2),t.append("pwd_type","pwd2");var e=Object(i["lb"])(t),a=this;e.then((function(){a.$refs.msg.makeToast("success",a.$t("successUpdate")),a.tabIndex=0,a.rows=[],a.canEdit=!1,a.loadItems(),a.$bvModal.hide("modal-1")})).catch((function(t){a.$refs.msg.makeToast("warning",a.$t(Object(n["b"])(t)))})),this.password2=""},updateUser:function(){var t=new FormData;t.append("user_id",this.selectedId),t.append("username",this.username),t.append("email",this.email),t.append("boost_limit",this.boost_limit),t.append("day_limit",this.day_limit),t.append("country_id",this.country),t.append("user_group_id",this.packageType),t.append("wr",this.wr?1:0),t.append("rb",this.rb?1:0),t.append("wt",this.wt?1:0);var e=Object(i["nb"])(t),a=this;e.then((function(t){0==t.data.error_code?(a.$refs.msg.makeToast("success",a.$t("successUpdate")),a.tabIndex=0,a.rows=[],a.canEdit=!1,a.loadItems()):a.$refs.msg.makeToast("warning",a.$t(t.data.message))})).catch((function(t){a.$refs.msg.makeToast("warning",a.$t(Object(n["b"])(t)))}))},updateSettings:function(){var t=JSON.stringify(this.form),e=Object(i["mb"])(t),a=this;e.then((function(t){console.log(t),a.$refs.msg.makeToast("success",a.$t("successUpdate")),a.tabIndex=0,a.rows=[],a.canEdit=!1,a.loadItems()})).catch((function(t){a.$refs.msg.makeToast("warning",a.$t(Object(n["b"])(t)))}))},getCountryList:function(){var t=Object(i["n"])(),e=this;e.countryOptions=[],this.isLoading=!0,t.then((function(t){console.log(t.data),e.countryList=t.data.data;for(var a=0;a<t.data.data.length;a++){var s={};s["value"]=t.data.data[a].id,s["text"]="en"==e.$i18n.locale?t.data.data[a].name_en:t.data.data[a].name,e.countryOptions.push(s)}})).catch((function(t){e.$refs.msg.makeToast("warning",e.$t(Object(n["b"])(t)))}))},globalConfig:function(){var t=Object(i["jb"])(),e=this;this.isLoading=!0,t.then((function(t){e.defaultSettingList=t.data.data.record[6].key_value,e.isLoading=!1}))},loadItems:function(){this.getCountryList(),this.globalConfig();var t=Object(i["T"])(this.pageNumber,this.searchUsername,this.searchPhone,this.searchUID),e=this;this.isLoading=!0,t.then((function(t){var a=t.data.data.user.data;e.rows=a,e.totalRecords=t.data.data.user.total,e.isLoading=!1,e.selectOptions=[],e.package=t.data.data.package;for(var s=0;s<e.package.length;s++){var r={};r["value"]=e.package[s].id,r["text"]=e.package[s].package_name,e.selectOptions.push(r)}e.productOptions=[];var o={value:null,text:""};e.productOptions.push(o),e.product=t.data.data.product;for(var i=0;i<e.product.length;i++){var l={};l["value"]=e.product[i].id,l["text"]="("+e.product[i].price+") "+e.product[i].name_en,e.productOptions.push(l)}e.productOptions2=[];var n={value:null,text:""};e.productOptions2.push(n),e.product2=t.data.data.product;for(var c=0;c<e.product2.length;c++){var d={};d["value"]=e.product2[c].id,d["text"]="("+e.product2[c].price+") "+e.product2[c].name_en,e.productOptions2.push(d)}})).catch((function(t){e.$refs.msg.makeToast("warning",e.$t(Object(n["b"])(t)))}))}},watch:{lang:function(t){var e=this;if(e.selectOptions=[],"en"==t)for(var a=0;a<e.package.length;a++){var s={};s["value"]=e.package[a].id,s["text"]=e.package[a].package_name_en,e.selectOptions.push(s)}else for(var r=0;r<e.package.length;r++){var o={};o["value"]=e.package[r].id,o["text"]=e.package[r].package_name,e.selectOptions.push(o)}e.countryOptions=[];for(var i=0;i<e.countryList.length;i++){var l={};l["value"]=e.countryList[i].id,l["text"]="en"==t?e.countryList[i].name_en:e.countryList[i].name,e.countryOptions.push(l)}}},created:function(){this.loadItems()}},v=h,w=(a("4672"),a("0fea"),Object(f["a"])(v,s,r,!1,null,null,null));e["default"]=w.exports},ad6d:function(t,e,a){"use strict";var s=a("825a");t.exports=function(){var t=s(this),e="";return t.global&&(e+="g"),t.ignoreCase&&(e+="i"),t.multiline&&(e+="m"),t.dotAll&&(e+="s"),t.unicode&&(e+="u"),t.sticky&&(e+="y"),e}},fc3e:function(t,e,a){}}]);
//# sourceMappingURL=chunk-ab8a785c.1649d093.js.map