(()=>{var e={142:()=>{const e=[...document.querySelectorAll(".current-menu-item")],t=()=>{e.forEach((e=>{const{hash:t}=new URL(e.querySelector("a"));e.classList.toggle("current-menu-item",window.location.hash===t)}))},n=e=>{e.preventDefault();const{hash:n}=new URL(e.currentTarget);window.location.hash=n;const o=document.getElementById(n.substring(1));o?window.scrollTo(0,o.offsetTop-100):window.scrollTo(0,0),t()};document.addEventListener("DOMContentLoaded",(()=>{if(e.length<2)return;t();e.map((e=>e.querySelector("a"))).forEach((e=>e.addEventListener("click",n)))}))},218:()=>{let e=[],t=[];const n=e=>{let{target:t}=e;for(;t&&t!==document;t=t.parentElement)if(t.classList.contains("gfield"))return t},o=e=>n(e).classList.add("has-focus"),r=e=>n(e).classList.remove("has-focus"),s=e=>{const t=e.target,o=n(e);t.value?o.classList.add("has-value"):o.classList.remove("has-value")},a=e=>{const t=e.target;if("textarea"!==t.tagName.toLowerCase())return;t.style.height="inherit";const n=window.getComputedStyle(t),o=t.scrollHeight+parseInt(n.getPropertyValue("border-bottom-width"),10);t.style.height=`${o}px`},i=()=>{e=document.querySelectorAll(".gfield input, .gfield select, .gfield textarea"),[...e].forEach((e=>{s({target:e}),e.addEventListener("focus",o),e.addEventListener("blur",r),e.addEventListener("input",s),e.addEventListener("input",a)}))};document.addEventListener("DOMContentLoaded",(()=>{[...document.querySelectorAll([".ginput_container_textarea",".ginput_container_fileupload",".ginput_container_hcaptcha",".ginput_container_consent"].join(","))].forEach((e=>e.closest(".gfield").classList.add("gfield--fullwidth"))),i()})),jQuery(document).on("gform_post_render.reinitialize",(()=>{[...e].forEach((e=>{e.removeEventListener("focus",o),e.removeEventListener("blur",r),e.removeEventListener("input",s),e.removeEventListener("input",a)})),i()})),jQuery(document).on("gform_post_render.scrollPosition",((e,n,o)=>{const r=document.querySelector(`#gf_${n}`);if(!r||!t.includes(n))return void t.push(n);const s=r.parentElement.parentElement;s.focus({preventScroll:!0}),setTimeout((()=>{s.scrollIntoView({behavior:"smooth",block:"center"})}),200)}))},173:()=>{const e=document.querySelector('[data-dropdown="language-switcher"]'),t=e=>{let{target:t}=e;"true"===t.getAttribute("aria-expanded")?o():"false"===t.getAttribute("aria-expanded")&&r()},n=e=>{let{keyCode:t}=e;27===t&&r()},o=()=>{window.scrollTo(0,0),document.body.classList.toggle("disable-body-scrolling",!0),document.addEventListener("keydown",n)},r=()=>{document.body.classList.toggle("disable-body-scrolling",!1),document.removeEventListener("keydown",n)};document.addEventListener("DOMContentLoaded",(()=>{e&&e.addEventListener("click",t)}))}},t={};function n(o){var r=t[o];if(void 0!==r)return r.exports;var s=t[o]={exports:{}};return e[o](s,s.exports,n),s.exports}n(142),n(173),n(218)})();