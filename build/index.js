(()=>{"use strict";var e,t={483:()=>{const e=window.wp.blocks,t=window.wp.element,r=window.wp.coreData,n=window.wp.date,a=window.wp.i18n,l=window.wp.blockEditor,o=window.wp.components,s=JSON.parse('{"u2":"gilberto-tavares/json-table"}'),i=(0,t.createElement)(o.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 48 48"},(0,t.createElement)(o.Path,{d:"M19.832 36.352v-4.86q-.608 1.263-1.52 2.206-.91.928-2.028 1.534-1.118.608-2.396.912-1.263.304-2.574.304-2.365 0-4.362-.784-1.997-.798-3.626-2.525Q1.711 31.413.85 29.05 0 26.685 0 24.11q0-2.586.85-4.887.86-2.301 2.397-4.012 1.548-1.708 3.674-2.682 2.138-.977 4.633-.977 2.3 0 3.947.657 1.662.655 2.83 1.598 1.18.927 1.883 1.773h1.55v2.844H18.33q-1.072-1.821-2.844-2.875-1.758-1.057-3.948-1.023-1.837 0-3.37.783-1.536.78-2.639 2.108-1.084 1.327-1.692 3.053-.608 1.726-.608 3.64 0 2.127.67 3.948.672 1.822 1.71 2.956Q6.65 32.147 8.168 32.9q1.533.734 3.386.734 3.066 0 5.034-1.484 1.964-1.502 2.747-4.666h-6.774v-2.75h10.242v11.618z"}),(0,t.createElement)(o.Path,{d:"M32.98 33.508h2.222V14.652h-5.53v3.772H26.4v-6.39H48v6.39h-3.275v-3.772h-6.39v18.856h2.492v2.746H32.98z"}));(0,e.registerBlockType)(s.u2,{icon:{src:i},edit:function({attributes:e,setAttributes:s}){const{hiddenColumns:i}=e,[c,u]=(0,t.useState)(null);(0,t.useEffect)((()=>{(async()=>{const{ajaxurl:e,nonce:t}=gilbertoTavaresParams,r=await fetch(`${e}?action=gilberto_tavares_get_data&security=${t}`),n=await r.json();u(n.data)})()}),[]);const d=(0,l.useBlockProps)(),[m=(0,n.getSettings)().formats.date]=(0,r.useEntityProp)("root","site","date_format"),[v=(0,n.getSettings)().formats.time]=(0,r.useEntityProp)("root","site","time_format"),p=`${m} ${v}`;if(!c)return(0,t.createElement)("div",d,(0,t.createElement)("p",null,(0,a.__)("Loading…","gilberto-tavares")));if(!c.data||!c.data.headers)return(0,t.createElement)("div",d,(0,t.createElement)("p",null,(0,a.__)("Data not loaded.","gilberto-tavares")));const b=c.data.rows,g=Object.entries(Object.fromEntries(Object.keys(Object.values(b)[0]).map(((e,t)=>[e,c.data.headers[t]])))).map((([e,t])=>({[e]:t})));return(0,t.createElement)("div",d,(0,t.createElement)(l.InspectorControls,{group:"settings"},(0,t.createElement)(o.PanelBody,{title:(0,a.__)("Column Visibility","gilberto-tavares")},g.map((e=>{const r=Object.keys(e)[0];return(0,t.createElement)(o.ToggleControl,{key:r,label:e[r],checked:!i.includes(r),onChange:()=>(e=>{const t=i.includes(e)?i.filter((t=>t!==e)):[...i,e];s({hiddenColumns:t})})(r)})})))),(0,t.createElement)("table",null,(0,t.createElement)("caption",null,c.title),(0,t.createElement)("thead",null,(0,t.createElement)("tr",null,g.filter((e=>!i.includes(Object.keys(e)[0]))).map((e=>{const r=Object.keys(e)[0];return(0,t.createElement)("th",{key:r},e[r])})))),(0,t.createElement)("tbody",null,Object.entries(b).map((([e,r])=>(0,t.createElement)("tr",{key:e},g.filter((e=>!i.includes(Object.keys(e)[0]))).map((e=>{const a=Object.keys(e)[0];let l=r[a];return Number.isInteger(l)&&"date"===Object.keys(e)[0]&&(l=(e=>{const t=new Date(1e3*e),r=t.getFullYear();let n=t.getDate(),a=t.getMonth()+1,l=t.getHours(),o=t.getMinutes(),s=t.getSeconds();return n<=9&&(n=`0${n}`),a<=9&&(a=`0${a}`),l<=9&&(l=`0${l}`),o<=9&&(o=`0${o}`),s<=9&&(s=`0${s}`),`${r}-${a}-${n} ${l}:${o}:${s}`})(l),l=(0,t.createElement)("time",{dateTime:(0,n.dateI18n)("c",l)},(0,n.dateI18n)(p,l))),(0,t.createElement)("td",{key:a},l)}))))))))},save:()=>null})}},r={};function n(e){var a=r[e];if(void 0!==a)return a.exports;var l=r[e]={exports:{}};return t[e](l,l.exports,n),l.exports}n.m=t,e=[],n.O=(t,r,a,l)=>{if(!r){var o=1/0;for(u=0;u<e.length;u++){for(var[r,a,l]=e[u],s=!0,i=0;i<r.length;i++)(!1&l||o>=l)&&Object.keys(n.O).every((e=>n.O[e](r[i])))?r.splice(i--,1):(s=!1,l<o&&(o=l));if(s){e.splice(u--,1);var c=a();void 0!==c&&(t=c)}}return t}l=l||0;for(var u=e.length;u>0&&e[u-1][2]>l;u--)e[u]=e[u-1];e[u]=[r,a,l]},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={826:0,431:0};n.O.j=t=>0===e[t];var t=(t,r)=>{var a,l,[o,s,i]=r,c=0;if(o.some((t=>0!==e[t]))){for(a in s)n.o(s,a)&&(n.m[a]=s[a]);if(i)var u=i(n)}for(t&&t(r);c<o.length;c++)l=o[c],n.o(e,l)&&e[l]&&e[l][0](),e[l]=0;return n.O(u)},r=globalThis.webpackChunkgilberto_tavares_plugin=globalThis.webpackChunkgilberto_tavares_plugin||[];r.forEach(t.bind(null,0)),r.push=t.bind(null,r.push.bind(r))})();var a=n.O(void 0,[431],(()=>n(483)));a=n.O(a)})();