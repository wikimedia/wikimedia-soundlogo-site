(()=>{var e={328:(e,t)=>{"use strict";function r(e){return r="function"===typeof Symbol&&"symbol"===typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"===typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},r(e)}function o(e,t){for(var r=0;r<t.length;r++){var o=t[r];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}function n(e,t){return n=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e},n(e,t)}function c(e){var t=function(){if("undefined"===typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"===typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}();return function(){var r,o=a(e);if(t){var n=a(this).constructor;r=Reflect.construct(o,arguments,n)}else r=o.apply(this,arguments);return i(this,r)}}function i(e,t){return!t||"object"!==r(t)&&"function"!==typeof t?function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e):t}function a(e){return a=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)},a(e)}t.Bz=void 0;var s=window.wp,u=s.blocks,l=s.plugins,f=s.richText,p=s.hooks,v=s.data,y=function(){},d=function(e){var t=e.getContext,r=e.register,o=e.unregister,n=e.before,c=void 0===n?y:n,i=e.after,a=void 0===i?y:i,s=arguments.length>1&&void 0!==arguments[1]?arguments[1]:y,u={},l=function(){c();var e=t(),n=[];return e.keys().forEach((function(t){var c=e(t);if(c!==u[t]){var i=u[t];i&&console.groupCollapsed&&console.groupCollapsed("hot update: ".concat(t)),i&&o(u[t]),r(c),n.push(c),u[t]=c,i&&console.groupCollapsed&&console.groupEnd()}})),a(n),e},f=l();s(f,l)};var g=null,h=function(e){var t=e.name,r=e.settings,o=e.filters,n=e.styles;t&&r&&u.registerBlockType(t,r),o&&Array.isArray(o)&&o.forEach((function(e){var t=e.hook,r=e.namespace,o=e.callback;p.addFilter(t,r,o)})),n&&Array.isArray(n)&&n.forEach((function(e){return u.registerBlockStyle(t,e)}))};var b=function(e){var t=e.name,r=e.settings,o=e.filters,n=e.styles;t&&r&&u.unregisterBlockType(t),o&&Array.isArray(o)&&o.forEach((function(e){var t=e.hook,r=e.namespace;p.removeFilter(t,r)})),n&&Array.isArray(n)&&n.forEach((function(e){return u.unregisterBlockStyle(t,e.name)}))};var m=function(){g=v.select("core/block-editor").getSelectedBlockClientId(),v.dispatch("core/block-editor").clearSelectedBlock()};var k=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:[],t=e.map((function(e){return e.name}));t.length&&(v.select("core/block-editor").getBlocks().forEach((function(e){var r=e.name,o=e.clientId;t.includes(r)&&v.dispatch("core/block-editor").selectBlock(o)})),g?v.dispatch("core/block-editor").selectBlock(g):v.dispatch("core/block-editor").clearSelectedBlock(),g=null)};t.Bz=function(e,t){var r=e.getContext,o=e.register,n=void 0===o?h:o,c=e.unregister,i=void 0===c?b:c,a=e.before,s=void 0===a?m:a,u=e.after;d({getContext:r,register:n,unregister:i,before:s,after:void 0===u?k:u},t)};var O=function(e){var t=e.name,r=e.settings,o=e.filters;t&&r&&l.registerPlugin(t,r),o&&Array.isArray(o)&&o.forEach((function(e){var t=e.hook,r=e.namespace,o=e.callback;p.addFilter(t,r,o)}))};var B=function(e){var t=e.name,r=e.settings,o=e.filters;t&&r&&l.unregisterPlugin(t),o&&Array.isArray(o)&&o.forEach((function(e){var t=e.hook,r=e.namespace;p.removeFilter(t,r)}))};var A=function(e){var t=e.name,r=e.settings;t&&r&&f.registerFormatType(t,r)};var E=function(e){var t=e.name,r=e.settings;t&&r&&f.unregisterFormatType(t)}},543:e=>{function t(e){var t=new Error("Cannot find module '"+e+"'");throw t.code="MODULE_NOT_FOUND",t}t.keys=()=>[],t.resolve=t,t.id=543,e.exports=t}},t={};function r(o){var n=t[o];if(void 0!==n)return n.exports;var c=t[o]={exports:{}};return e[o](c,c.exports,r),c.exports}r.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{"use strict";(0,r(328).Bz)({getContext:()=>r(543)},((e,t)=>{0}))})()})();