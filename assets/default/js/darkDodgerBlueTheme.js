!function(e){var r={};function t(a){if(r[a])return r[a].exports;var n=r[a]={i:a,l:!1,exports:{}};return e[a].call(n.exports,n,n.exports,t),n.l=!0,n.exports}t.m=e,t.c=r,t.d=function(e,r,a){t.o(e,r)||Object.defineProperty(e,r,{enumerable:!0,get:a})},t.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},t.t=function(e,r){if(1&r&&(e=t(e)),8&r)return e;if(4&r&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(t.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&r&&"string"!=typeof e)for(var n in e)t.d(a,n,function(r){return e[r]}.bind(null,n));return a},t.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(r,"a",r),r},t.o=function(e,r){return Object.prototype.hasOwnProperty.call(e,r)},t.p="/",t(t.s=522)}({0:function(e,r,t){(function(r){var t=function(e){return e&&e.Math==Math&&e};e.exports=t("object"==typeof globalThis&&globalThis)||t("object"==typeof window&&window)||t("object"==typeof self&&self)||t("object"==typeof r&&r)||function(){return this}()||Function("return this")()}).call(this,t(58))},1:function(e,r){e.exports=function(e){try{return!!e()}catch(e){return!0}}},10:function(e,r,t){var a=t(39),n=t(15);e.exports=function(e){return a(n(e))}},12:function(e,r,t){var a=t(20),n=Math.min;e.exports=function(e){return e>0?n(a(e),9007199254740991):0}},15:function(e,r){e.exports=function(e){if(null==e)throw TypeError("Can't call method on "+e);return e}},16:function(e,r,t){var a=t(0),n=t(9),o=t(2),l=t(23),c=t(40),u=t(35),i=u.get,d=u.enforce,s=String(String).split("String");(e.exports=function(e,r,t,c){var u,i=!!c&&!!c.unsafe,f=!!c&&!!c.enumerable,p=!!c&&!!c.noTargetGet;"function"==typeof t&&("string"!=typeof r||o(t,"name")||n(t,"name",r),(u=d(t)).source||(u.source=s.join("string"==typeof r?r:""))),e!==a?(i?!p&&e[r]&&(f=!0):delete e[r],f?e[r]=t:n(e,r,t)):f?e[r]=t:l(r,t)})(Function.prototype,"toString",(function(){return"function"==typeof this&&i(this).source||c(this)}))},17:function(e,r){e.exports={}},180:function(e,r,t){"use strict";t.r(r);t(64);r.default={"mainNavbar.navbar":function(){return["default","boxed"].includes(this.settings["layout.layout"])?"dark-dodger-blue":["transparent","light"].includes(this.settings["mainNavbar.navbar"])?void 0:"light"},"mainDrawer.theme":function(){return"boxed"!==this.settings["layout.layout"]?"dark-dodger-blue":"light-dodger-blue"},".layout-boxed .sidebar-brand":{addClass:["sidebar-brand-dark","bg-primary-pickled-bluewood"],removeClass:["bg-dark-blue","bg-dark-purple","bg-dark","bg-black"]},".js-update-chart-line":{setAttribute:[{name:"data-chart-line-border-color",value:"dodger-blue"},{name:"data-chart-line-border-opacity",value:"1"}]},".js-update-chart-area":{setAttribute:[{name:"data-chart-line-background-color",value:"gradient:dodger-blue"},{name:"data-chart-line-background-opacity",value:"0.1"}]},".js-update-chart-bar":{setAttribute:[{name:"data-chart-line-background-color",value:"gradient:dodger-blue"},{name:"data-chart-line-background-opacity",value:"1"}]},"#locationDoughnutChart":{setAttribute:[{name:"data-chart-line-background-color",value:"dodger-blue;dodger-blue;gray"},{name:"data-chart-line-background-opacity",value:"0.2;1;0.24"}]},"#attendanceDoughnutChart":{setAttribute:[{name:"data-chart-line-background-color",value:"dodger-blue;dodger-blue;gray.700;gray"},{name:"data-chart-line-background-opacity",value:"1;0.2;1;1"}]},"#visitsByDeviceChart":{setAttribute:[{name:"data-chart-line-background-color",value:"dodger-blue;gray.300"},{name:"data-chart-line-background-opacity",value:"0.2,1"}]},".js-update-chart-progress":{setAttribute:[{name:"data-chart-line-background-color",value:"dodger-blue;gray"},{name:"data-chart-line-background-opacity",value:"1"}]},".js-update-chart-progress-accent":{setAttribute:[{name:"data-chart-line-background-color",value:"dodger-blue;gray"},{name:"data-chart-line-background-opacity",value:"1"}]},".js-update-chart-line-accent":{setAttribute:[{name:"data-chart-line-border-color",value:"dodger-blue"},{name:"data-chart-line-border-opacity",value:"0.2"}]},".js-update-chart-line-2nd-accent":{setAttribute:[{name:"data-chart-line-border-color",value:"dodger-blue,dodger-blue"},{name:"data-chart-line-border-opacity",value:"1,0.2"}]},".bg-dark":{addClass:["bg-primary-pickled-bluewood"],removeClass:["bg-dark"]},".bg-dark-blue":{addClass:["bg-primary-pickled-bluewood"],removeClass:["bg-dark-blue"]},".bg-dark-purple":{addClass:["bg-primary-pickled-bluewood"],removeClass:["bg-dark-purple"]},".bg-primary-purple":{addClass:["bg-primary-dodger-blue"],removeClass:["bg-primary-purple"]},".bg-primary-yellow":{addClass:["bg-primary-dodger-blue"],removeClass:["bg-primary-yellow"]},".bg-primary-red":{addClass:["bg-primary-dodger-blue"],removeClass:["bg-primary-red"]},".bg-primary":{addClass:["bg-primary-dodger-blue"],removeClass:["bg-primary"]},".bg-accent-yellow":{addClass:["bg-accent-dodger-blue"],removeClass:["bg-accent-yellow"]},".bg-accent-red":{addClass:["bg-accent-dodger-blue"],removeClass:["bg-accent-red"]},".bg-accent":{addClass:["bg-accent-pickled-bluewood"],removeClass:["bg-accent"]},".border-left-primary-purple":{addClass:["border-left-primary-dodger-blue"],removeClass:["border-left-primary-purple"]},".border-left-primary-yellow":{addClass:["border-left-primary-dodger-blue"],removeClass:["border-left-primary-yellow"]},".border-left-primary-red":{addClass:["border-left-primary-dodger-blue"],removeClass:["border-left-primary-red"]},".border-left-primary":{addClass:["border-left-primary-dodger-blue"],removeClass:["border-left-primary"]},".border-left-accent-yellow":{addClass:["border-left-accent-pickled-bluewood"],removeClass:["border-left-accent-yellow"]},".border-left-accent-red":{addClass:["border-left-accent-pickled-bluewood"],removeClass:["border-left-accent-red"]},".border-left-accent":{addClass:["border-left-accent-pickled-bluewood"],removeClass:["border-left-accent"]},".alert-primary-purple":{addClass:["alert-primary-dodger-blue"],removeClass:["alert-primary-purple"]},".alert-primary-yellow":{addClass:["alert-primary-dodger-blue"],removeClass:["alert-primary-yellow"]},".alert-primary-red":{addClass:["alert-primary-dodger-blue"],removeClass:["alert-primary-red"]},".alert-primary":{addClass:["alert-primary-dodger-blue"],removeClass:["alert-primary"]},".alert-accent-yellow":{addClass:["alert-accent-dodger-blue"],removeClass:["alert-accent-yellow"]},".alert-accent-red":{addClass:["alert-accent-dodger-blue"],removeClass:["alert-accent-red"]},".alert-accent":{addClass:["alert-accent-dodger-blue"],removeClass:["alert-accent"]},".alert-soft-primary-purple":{addClass:["alert-soft-primary-dodger-blue"],removeClass:["alert-soft-primary-purple"]},".alert-soft-primary-yellow":{addClass:["alert-soft-primary-dodger-blue"],removeClass:["alert-soft-primary-yellow"]},".alert-soft-primary-red":{addClass:["alert-soft-primary-dodger-blue"],removeClass:["alert-soft-primary-red"]},".alert-soft-primary":{addClass:["alert-soft-primary-dodger-blue"],removeClass:["alert-soft-primary"]},".alert-soft-accent-yellow":{addClass:["alert-soft-accent-dodger-blue"],removeClass:["alert-soft-accent-yellow"]},".alert-soft-accent-red":{addClass:["alert-soft-accent-dodger-blue"],removeClass:["alert-soft-accent-red"]},".alert-soft-accent":{addClass:["alert-soft-accent-dodger-blue"],removeClass:["alert-soft-accent"]},".text-primary-purple":{addClass:["text-primary-dodger-blue"],removeClass:["text-primary-purple"]},".text-primary-yellow":{addClass:["text-primary-dodger-blue"],removeClass:["text-primary-yellow"]},".text-primary-red":{addClass:["text-primary-dodger-blue"],removeClass:["text-primary-red"]},".text-primary":{addClass:["text-primary-dodger-blue"],removeClass:["text-primary"]},".text-accent-yellow":{addClass:["text-accent-pickled-bluewood"],removeClass:["text-accent-yellow"]},".text-accent-red":{addClass:["text-accent-pickled-bluewood"],removeClass:["text-accent-red"]},".text-accent":{addClass:["text-accent-pickled-bluewood"],removeClass:["text-accent"]},".btn-accent-yellow":{addClass:["btn-accent-dodger-blue"],removeClass:["btn-accent-yellow"]},".btn-accent-red":{addClass:["btn-accent-dodger-blue"],removeClass:["btn-accent-red"]},".btn-accent":{addClass:["btn-accent-dodger-blue"],removeClass:["btn-accent"]},".btn-primary-yellow":{addClass:["btn-primary-dodger-blue"],removeClass:["btn-primary-yellow"]},".btn-primary-purple":{addClass:["btn-primary-dodger-blue"],removeClass:["btn-primary-purple"]},".btn-primary-red":{addClass:["btn-primary-dodger-blue"],removeClass:["btn-primary-red"]},".btn-primary":{addClass:["btn-primary-dodger-blue"],removeClass:["btn-primary"]},".badge-accent-yellow":{addClass:["badge-accent-dodger-blue"],removeClass:["badge-accent-yellow"]},".badge-accent-red":{addClass:["badge-accent-dodger-blue"],removeClass:["badge-accent-red"]},".badge-accent":{addClass:["badge-accent-dodger-blue"],removeClass:["badge-accent"]}}},19:function(e,r){e.exports=function(e,r){return{enumerable:!(1&e),configurable:!(2&e),writable:!(4&e),value:r}}},2:function(e,r){var t={}.hasOwnProperty;e.exports=function(e,r){return t.call(e,r)}},20:function(e,r){var t=Math.ceil,a=Math.floor;e.exports=function(e){return isNaN(e=+e)?0:(e>0?a:t)(e)}},21:function(e,r){var t={}.toString;e.exports=function(e){return t.call(e).slice(8,-1)}},22:function(e,r,t){var a=t(4);e.exports=function(e,r){if(!a(e))return e;var t,n;if(r&&"function"==typeof(t=e.toString)&&!a(n=t.call(e)))return n;if("function"==typeof(t=e.valueOf)&&!a(n=t.call(e)))return n;if(!r&&"function"==typeof(t=e.toString)&&!a(n=t.call(e)))return n;throw TypeError("Can't convert object to primitive value")}},23:function(e,r,t){var a=t(0),n=t(9);e.exports=function(e,r){try{n(a,e,r)}catch(t){a[e]=r}return r}},24:function(e,r,t){var a=t(0),n=t(23),o=a["__core-js_shared__"]||n("__core-js_shared__",{});e.exports=o},26:function(e,r,t){var a=t(60),n=t(0),o=function(e){return"function"==typeof e?e:void 0};e.exports=function(e,r){return arguments.length<2?o(a[e])||o(n[e]):a[e]&&a[e][r]||n[e]&&n[e][r]}},27:function(e,r,t){var a=t(3),n=t(55),o=t(19),l=t(10),c=t(22),u=t(2),i=t(42),d=Object.getOwnPropertyDescriptor;r.f=a?d:function(e,r){if(e=l(e),r=c(r,!0),i)try{return d(e,r)}catch(e){}if(u(e,r))return o(!n.f.call(e,r),e[r])}},28:function(e,r,t){var a=t(3),n=t(1),o=t(2),l=Object.defineProperty,c={},u=function(e){throw e};e.exports=function(e,r){if(o(c,e))return c[e];r||(r={});var t=[][e],i=!!o(r,"ACCESSORS")&&r.ACCESSORS,d=o(r,0)?r[0]:u,s=o(r,1)?r[1]:void 0;return c[e]=!!t&&!n((function(){if(i&&!a)return!0;var e={length:-1};i?l(e,1,{enumerable:!0,get:u}):e[1]=1,t.call(e,d,s)}))}},29:function(e,r){e.exports=["constructor","hasOwnProperty","isPrototypeOf","propertyIsEnumerable","toLocaleString","toString","valueOf"]},3:function(e,r,t){var a=t(1);e.exports=!a((function(){return 7!=Object.defineProperty({},1,{get:function(){return 7}})[1]}))},33:function(e,r,t){var a=t(36),n=t(34),o=a("keys");e.exports=function(e){return o[e]||(o[e]=n(e))}},34:function(e,r){var t=0,a=Math.random();e.exports=function(e){return"Symbol("+String(void 0===e?"":e)+")_"+(++t+a).toString(36)}},35:function(e,r,t){var a,n,o,l=t(67),c=t(0),u=t(4),i=t(9),d=t(2),s=t(24),f=t(33),p=t(17),b=c.WeakMap;if(l){var y=s.state||(s.state=new b),m=y.get,g=y.has,v=y.set;a=function(e,r){return r.facade=e,v.call(y,e,r),r},n=function(e){return m.call(y,e)||{}},o=function(e){return g.call(y,e)}}else{var C=f("state");p[C]=!0,a=function(e,r){return r.facade=e,i(e,C,r),r},n=function(e){return d(e,C)?e[C]:{}},o=function(e){return d(e,C)}}e.exports={set:a,get:n,has:o,enforce:function(e){return o(e)?n(e):a(e,{})},getterFor:function(e){return function(r){var t;if(!u(r)||(t=n(r)).type!==e)throw TypeError("Incompatible receiver, "+e+" required");return t}}}},36:function(e,r,t){var a=t(41),n=t(24);(e.exports=function(e,r){return n[e]||(n[e]=void 0!==r?r:{})})("versions",[]).push({version:"3.8.1",mode:a?"pure":"global",copyright:"© 2020 Denis Pushkarev (zloirock.ru)"})},37:function(e,r,t){var a=t(1);e.exports=!!Object.getOwnPropertySymbols&&!a((function(){return!String(Symbol())}))},39:function(e,r,t){var a=t(1),n=t(21),o="".split;e.exports=a((function(){return!Object("z").propertyIsEnumerable(0)}))?function(e){return"String"==n(e)?o.call(e,""):Object(e)}:Object},4:function(e,r){e.exports=function(e){return"object"==typeof e?null!==e:"function"==typeof e}},40:function(e,r,t){var a=t(24),n=Function.toString;"function"!=typeof a.inspectSource&&(a.inspectSource=function(e){return n.call(e)}),e.exports=a.inspectSource},41:function(e,r){e.exports=!1},42:function(e,r,t){var a=t(3),n=t(1),o=t(46);e.exports=!a&&!n((function(){return 7!=Object.defineProperty(o("div"),"a",{get:function(){return 7}}).a}))},44:function(e,r,t){var a=t(48),n=t(29).concat("length","prototype");r.f=Object.getOwnPropertyNames||function(e){return a(e,n)}},46:function(e,r,t){var a=t(0),n=t(4),o=a.document,l=n(o)&&n(o.createElement);e.exports=function(e){return l?o.createElement(e):{}}},48:function(e,r,t){var a=t(2),n=t(10),o=t(51).indexOf,l=t(17);e.exports=function(e,r){var t,c=n(e),u=0,i=[];for(t in c)!a(l,t)&&a(c,t)&&i.push(t);for(;r.length>u;)a(c,t=r[u++])&&(~o(i,t)||i.push(t));return i}},49:function(e,r){function t(r){return"function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?e.exports=t=function(e){return typeof e}:e.exports=t=function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},t(r)}e.exports=t},5:function(e,r,t){var a=t(0),n=t(36),o=t(2),l=t(34),c=t(37),u=t(61),i=n("wks"),d=a.Symbol,s=u?d:d&&d.withoutSetter||l;e.exports=function(e){return o(i,e)||(c&&o(d,e)?i[e]=d[e]:i[e]=s("Symbol."+e)),i[e]}},50:function(e,r,t){var a=t(20),n=Math.max,o=Math.min;e.exports=function(e,r){var t=a(e);return t<0?n(t+r,0):o(t,r)}},51:function(e,r,t){var a=t(10),n=t(12),o=t(50),l=function(e){return function(r,t,l){var c,u=a(r),i=n(u.length),d=o(l,i);if(e&&t!=t){for(;i>d;)if((c=u[d++])!=c)return!0}else for(;i>d;d++)if((e||d in u)&&u[d]===t)return e||d||0;return!e&&-1}};e.exports={includes:l(!0),indexOf:l(!1)}},522:function(e,r,t){e.exports=t(180)},53:function(e,r,t){var a=t(1),n=/#|\.prototype\./,o=function(e,r){var t=c[l(e)];return t==i||t!=u&&("function"==typeof r?a(r):!!r)},l=o.normalize=function(e){return String(e).replace(n,".").toLowerCase()},c=o.data={},u=o.NATIVE="N",i=o.POLYFILL="P";e.exports=o},54:function(e,r,t){var a,n=t(7),o=t(83),l=t(29),c=t(17),u=t(81),i=t(46),d=t(33),s=d("IE_PROTO"),f=function(){},p=function(e){return"<script>"+e+"<\/script>"},b=function(){try{a=document.domain&&new ActiveXObject("htmlfile")}catch(e){}var e,r;b=a?function(e){e.write(p("")),e.close();var r=e.parentWindow.Object;return e=null,r}(a):((r=i("iframe")).style.display="none",u.appendChild(r),r.src=String("javascript:"),(e=r.contentWindow.document).open(),e.write(p("document.F=Object")),e.close(),e.F);for(var t=l.length;t--;)delete b.prototype[l[t]];return b()};c[s]=!0,e.exports=Object.create||function(e,r){var t;return null!==e?(f.prototype=n(e),t=new f,f.prototype=null,t[s]=e):t=b(),void 0===r?t:o(t,r)}},55:function(e,r,t){"use strict";var a={}.propertyIsEnumerable,n=Object.getOwnPropertyDescriptor,o=n&&!a.call({1:2},1);r.f=o?function(e){var r=n(this,e);return!!r&&r.enumerable}:a},56:function(e,r){r.f=Object.getOwnPropertySymbols},58:function(e,r,t){var a,n=t(49);a=function(){return this}();try{a=a||new Function("return this")()}catch(e){"object"===("undefined"==typeof window?"undefined":n(window))&&(a=window)}e.exports=a},59:function(e,r,t){var a=t(2),n=t(65),o=t(27),l=t(8);e.exports=function(e,r){for(var t=n(r),c=l.f,u=o.f,i=0;i<t.length;i++){var d=t[i];a(e,d)||c(e,d,u(r,d))}}},6:function(e,r,t){var a=t(0),n=t(27).f,o=t(9),l=t(16),c=t(23),u=t(59),i=t(53);e.exports=function(e,r){var t,d,s,f,p,b=e.target,y=e.global,m=e.stat;if(t=y?a:m?a[b]||c(b,{}):(a[b]||{}).prototype)for(d in r){if(f=r[d],s=e.noTargetGet?(p=n(t,d))&&p.value:t[d],!i(y?d:b+(m?".":"#")+d,e.forced)&&void 0!==s){if(typeof f==typeof s)continue;u(f,s)}(e.sham||s&&s.sham)&&o(f,"sham",!0),l(t,d,f,e)}}},60:function(e,r,t){var a=t(0);e.exports=a},61:function(e,r,t){var a=t(37);e.exports=a&&!Symbol.sham&&"symbol"==typeof Symbol.iterator},62:function(e,r,t){var a=t(48),n=t(29);e.exports=Object.keys||function(e){return a(e,n)}},64:function(e,r,t){"use strict";var a=t(6),n=t(51).includes,o=t(71);a({target:"Array",proto:!0,forced:!t(28)("indexOf",{ACCESSORS:!0,1:0})},{includes:function(e){return n(this,e,arguments.length>1?arguments[1]:void 0)}}),o("includes")},65:function(e,r,t){var a=t(26),n=t(44),o=t(56),l=t(7);e.exports=a("Reflect","ownKeys")||function(e){var r=n.f(l(e)),t=o.f;return t?r.concat(t(e)):r}},67:function(e,r,t){var a=t(0),n=t(40),o=a.WeakMap;e.exports="function"==typeof o&&/native code/.test(n(o))},7:function(e,r,t){var a=t(4);e.exports=function(e){if(!a(e))throw TypeError(String(e)+" is not an object");return e}},71:function(e,r,t){var a=t(5),n=t(54),o=t(8),l=a("unscopables"),c=Array.prototype;null==c[l]&&o.f(c,l,{configurable:!0,value:n(null)}),e.exports=function(e){c[l][e]=!0}},8:function(e,r,t){var a=t(3),n=t(42),o=t(7),l=t(22),c=Object.defineProperty;r.f=a?c:function(e,r,t){if(o(e),r=l(r,!0),o(t),n)try{return c(e,r,t)}catch(e){}if("get"in t||"set"in t)throw TypeError("Accessors not supported");return"value"in t&&(e[r]=t.value),e}},81:function(e,r,t){var a=t(26);e.exports=a("document","documentElement")},83:function(e,r,t){var a=t(3),n=t(8),o=t(7),l=t(62);e.exports=a?Object.defineProperties:function(e,r){o(e);for(var t,a=l(r),c=a.length,u=0;c>u;)n.f(e,t=a[u++],r[t]);return e}},9:function(e,r,t){var a=t(3),n=t(8),o=t(19);e.exports=a?function(e,r,t){return n.f(e,r,o(1,t))}:function(e,r,t){return e[r]=t,e}}});