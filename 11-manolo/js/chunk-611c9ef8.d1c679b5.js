(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-611c9ef8"],{"3a66":function(t,e,i){"use strict";i.d(e,"a",(function(){return o}));var a=i("fe6c"),s=i("58df");function o(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:[];return Object(s["a"])(Object(a["b"])(["absolute","fixed"])).extend({name:"applicationable",props:{app:Boolean},computed:{applicationProperty:function(){return t}},watch:{app:function(t,e){e?this.removeApplication(!0):this.callUpdate()},applicationProperty:function(t,e){this.$vuetify.application.unregister(this._uid,e)}},activated:function(){this.callUpdate()},created:function(){for(var t=0,i=e.length;t<i;t++)this.$watch(e[t],this.callUpdate);this.callUpdate()},mounted:function(){this.callUpdate()},deactivated:function(){this.removeApplication()},destroyed:function(){this.removeApplication()},methods:{callUpdate:function(){this.app&&this.$vuetify.application.register(this._uid,this.applicationProperty,this.updateApplication())},removeApplication:function(){var t=arguments.length>0&&void 0!==arguments[0]&&arguments[0];(t||this.app)&&this.$vuetify.application.unregister(this._uid,this.applicationProperty)},updateApplication:function(){return 0}}})}},"7f19":function(t,e,i){},"93f9":function(t,e,i){"use strict";i.r(e);var a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-footer",{attrs:{app:"",dark:"",padless:"",absolute:""}},[i("v-card",{staticClass:"flex",attrs:{flat:"",tile:""}},[i("v-card-text",{staticClass:"black py-3 white--text text-center"},[i("a",{staticClass:"link-font",attrs:{href:"https://sclab.co",target:"_blank"}},[i("h4",[t._v("[ SCLab. ]")])])])],1)],1)},s=[],o={name:"Footer",data:function(){return{}}},n=o,c=(i("c4c7"),i("2877")),r=i("6544"),p=i.n(r),u=i("b0af"),l=i("99d9"),h=i("5530"),d=(i("a9e3"),i("c7cd"),i("b5b6"),i("8dd9")),f=i("3a66"),b=i("d10f"),v=i("58df"),m=i("80d2"),g=Object(v["a"])(d["a"],Object(f["a"])("footer",["height","inset"]),b["a"]).extend({name:"v-footer",props:{height:{default:"auto",type:[Number,String]},inset:Boolean,padless:Boolean,tag:{type:String,default:"footer"}},computed:{applicationProperty:function(){return this.inset?"insetFooter":"footer"},classes:function(){return Object(h["a"])(Object(h["a"])({},d["a"].options.computed.classes.call(this)),{},{"v-footer--absolute":this.absolute,"v-footer--fixed":!this.absolute&&(this.app||this.fixed),"v-footer--padless":this.padless,"v-footer--inset":this.inset})},computedBottom:function(){if(this.isPositioned)return this.app?this.$vuetify.application.bottom:0},computedLeft:function(){if(this.isPositioned)return this.app&&this.inset?this.$vuetify.application.left:0},computedRight:function(){if(this.isPositioned)return this.app&&this.inset?this.$vuetify.application.right:0},isPositioned:function(){return Boolean(this.absolute||this.fixed||this.app)},styles:function(){var t=parseInt(this.height);return Object(h["a"])(Object(h["a"])({},d["a"].options.computed.styles.call(this)),{},{height:isNaN(t)?t:Object(m["d"])(t),left:Object(m["d"])(this.computedLeft),right:Object(m["d"])(this.computedRight),bottom:Object(m["d"])(this.computedBottom)})}},methods:{updateApplication:function(){var t=parseInt(this.height);return isNaN(t)?this.$el?this.$el.clientHeight:0:t}},render:function(t){var e=this.setBackgroundColor(this.color,{staticClass:"v-footer",class:this.classes,style:this.styles});return t(this.tag,e,this.$slots.default)}}),y=Object(c["a"])(n,a,s,!1,null,"cfce97b4",null);e["default"]=y.exports;p()(y,{VCard:u["a"],VCardText:l["a"],VFooter:g})},"99d9":function(t,e,i){"use strict";i.d(e,"a",(function(){return c}));var a=i("b0af"),s=i("80d2"),o=Object(s["e"])("v-card__actions"),n=Object(s["e"])("v-card__subtitle"),c=Object(s["e"])("v-card__text"),r=Object(s["e"])("v-card__title");a["a"]},b5b6:function(t,e,i){},c4c7:function(t,e,i){"use strict";i("7f19")}}]);
//# sourceMappingURL=chunk-611c9ef8.d1c679b5.js.map