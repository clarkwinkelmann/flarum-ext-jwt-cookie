(()=>{var e={n:t=>{var o=t&&t.__esModule?()=>t.default:()=>t;return e.d(o,{a:o}),o},d:(t,o)=>{for(var i in o)e.o(o,i)&&!e.o(t,i)&&Object.defineProperty(t,i,{enumerable:!0,get:o[i]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t),r:e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})}},t={};(()=>{"use strict";e.r(t);const o=flarum.core.compat["admin/app"];var i=e.n(o);i().initializers.add("clarkwinkelmann-jwt-cookie",(function(){i().extensionData.for("clarkwinkelmann-jwt-cookie").registerSetting({setting:"jwt-cookie.cookieName",type:"text",label:"Cookie name",placeholder:"A valid cookie name"}).registerSetting({setting:"jwt-cookie.publicKey",type:"textarea",label:"Public Key(s)",placeholder:"Leave empty to use Google list of keys automatically"}).registerSetting({setting:"jwt-cookie.publicKeyAlgorithm",type:"string",label:"Public Key Algorithm (example: RS256)",placeholder:"Only if a Public Key is provided"})}))})(),module.exports=t})();
//# sourceMappingURL=admin.js.map