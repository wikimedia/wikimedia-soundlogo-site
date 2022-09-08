(()=>{var e={875:()=>{const{gf_input_change:e}=window;let t=[],s=[],o=[];const i=e=>{let{target:t}=e;t.closest(".gfield_custom_select:focus-within")||setTimeout((()=>n(t)),200)},n=e=>{const t=d(e,".gfield_listbox");t.classList.remove("is-opened"),t.removeEventListener("keydown",l),t.setAttribute("tabindex","-1")},r=e=>{let{target:t}=e;const s=d(t,".gfield_listbox");s.setAttribute("tabindex",1),s.classList.toggle("is-opened"),s.addEventListener("keydown",l),s.querySelector(".gfield_option.is-selected")?s.querySelector(".gfield_option.is-selected button").focus():s.querySelector(".gfield_option button").focus()},l=e=>{const t=document.activeElement.closest(".gfield_option"),{key:s}=e;switch(s){case"Down":case"ArrowDown":return e.preventDefault(),t.nextElementSibling.querySelector("button").focus();case"Up":case"ArrowUp":return e.preventDefault(),t.previousElementSibling.querySelector("button").focus();case"Esc":case"Escape":n(t);const o=d(t,".gfield_toggle");return o.scrollIntoView({block:"center"}),o.focus(),o;default:let i=t;for(i.innerText.slice(0,1).toLowerCase()>s.toLowerCase()&&(i=d(t,".gfield_option"));i=i.nextElementSibling;)if(i.innerText.toLowerCase().startsWith(s.toLowerCase())){i.querySelector("button").focus(),i.scrollIntoView({block:"center"});break}}},a=t=>{let{target:s}=t;const o=d(s,".gfield_hidden_input"),i=s.closest(".gfield_option"),r=c(s,".gfield_option"),{text:l,value:a}=i.dataset;r.forEach((e=>e.classList.remove("is-selected"))),i.classList.add("is-selected");const[u,g,m]=o.id.match(/input_([0-9]*)_([0-9]*)/);e(o,g,m),s.closest(".gfield").classList.toggle("has-value",!!a),o.value=a,d(s,".gfield_current_value").innerHTML=l,n(s)},d=(e,t)=>e.classList.contains("gfield_custom_select")?e.querySelector(t):e.closest(".gfield_custom_select").querySelector(t),c=(e,t)=>e.classList.contains("gfield_custom_select")?[...e.querySelectorAll(t)]:[...e.closest(".gfield_custom_select").querySelectorAll(t)];window.addEventListener("DOMContentLoaded",(()=>{t=[...document.querySelectorAll(".gfield_custom_select")],s=[...document.querySelectorAll(".gfield_custom_select .gfield_toggle")],o=[...document.querySelectorAll(".gfield_custom_select .gfield_option")],s.forEach((e=>e.addEventListener("click",r))),o.forEach((e=>e.addEventListener("click",a))),t.forEach((e=>e.addEventListener("focusout",i)))}))},128:()=>{const{submitterEmailField:e}=window;let t;const s=t=>{let{target:s}=t;const{value:o}=s;if(!o)return;fetch(e.ajaxurl,{method:"POST",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:new URLSearchParams([["action","check_email_address"],["email",o]])}).then((e=>e.json())).then((e=>{let{success:t,data:o}=e;const i=s.closest(".gfield"),n=s.closest(".gform_wrapper");i.querySelector(".gfield_validation_message")||s.insertAdjacentHTML("afterend",'<div class="gfield_description validation_message gfield_validation_message"></div>');const r=i.querySelector(".gfield_validation_message");s.toggleAttribute("aria-invalid",!t),i.classList.toggle("gfield_error",!t),n.classList.toggle("gform_validation_error",!t||n.querySelector(".gfield_error")),r.innerHTML=o||""})).catch(console.error)};window.addEventListener("DOMContentLoaded",(()=>{e&&(t=document.getElementById(e.field_id),t.addEventListener("blur",s))}))},133:(e,t,s)=>{"use strict";s.r(t);const o=jQuery;var i=s.n(o);const n=wp.a11y,r=wp.i18n,l=new AudioContext,a=document.querySelector('input[type="file"]'),d=(e,t)=>{const s=c(e),o=t.map((e=>{let{error:t}=e;return t})).includes(!0),i=t.map((e=>{let{message:t}=e;return t}));s[0].innerHTML="<ul>"+t.reduce(((e,t)=>{let{error:s,message:o}=t;return`${e}<li class="${s?"error":"warning"}">${o}</li>`}),"")+"</ul>",(0,n.speak)(i.join(", ")),e.setCustomValidity(o?i.join(", "):""),e.reportValidity()},c=e=>i()(e).closest("div").siblings(".validation_message").length>0?i()(e).closest("div").siblings(".validation_message"):i()(e).siblings(".validation_message").length>0?i()(e).siblings(".validation_message"):i()('<div class="validation_message"></div>').insertAfter(e),u=async e=>{let{target:t}=e;const s=t.files[0],o=[],{name:i,size:n,type:a}=s;if(i.toLowerCase().endsWith(".ogg")&&!a)return;if(window.audioFileAllowedMimeTypes.includes(a)||o.push({error:!0,message:(0,r.__)("File must be one of the allowed types: MP3, OGG, or WAV.","wikimedia-contest")}),n>1e8&&o.push({error:!0,message:(0,r.__)("File must be less than 100MB.","wikimedia-contest")}),o.length)return void d(t,o);const c=await s.arrayBuffer();try{const e=await l.decodeAudioData(c),{sampleRate:t,numberOfChannels:s,duration:d}=e;d>10?o.push({error:!0,message:(0,r.__)("Sound must be less than 10s.","wikimedia-contest")}):d<1?o.push({error:!0,message:(0,r.__)("Sound must be at least 1s.","wikimedia-contest")}):d>4&&o.push({error:!1,message:(0,r.__)("Sound should be less than 4s.","wikimedia-contest")});const u=32*t;"audio/mp3"===a&&u<196608?o.push({error:!1,message:(0,r.__)("MP3 files should be at least 192kbps.","wikimedia-contest")}):"video/ogg"===a&&u<163840&&o.push({error:!1,message:(0,r.__)("OGG files should be at least 160kbps.","wikimedia-contest")});const g=document.getElementById(window.audioFileMetaField);g&&(g.value=JSON.stringify({name:i,type:a,size:n,sampleRate:t,numberOfChannels:s,duration:d}))}catch(u){console.error(u),o.push({error:!0,message:(0,r.__)("Audio file is not readable.","wikimedia-contest")})}o.length&&d(t,o)};document.addEventListener("DOMContentLoaded",(()=>{a&&a.addEventListener("change",u)}))}},t={};function s(o){var i=t[o];if(void 0!==i)return i.exports;var n=t[o]={exports:{}};return e[o](n,n.exports,s),n.exports}s.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return s.d(t,{a:t}),t},s.d=(e,t)=>{for(var o in t)s.o(t,o)&&!s.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:t[o]})},s.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),s.r=e=>{"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},s(875),s(128),s(133)})();