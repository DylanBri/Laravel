/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./Modules/Log/Resources/assets/js/collections/LogQueues.js":
/*!******************************************************************!*\
  !*** ./Modules/Log/Resources/assets/js/collections/LogQueues.js ***!
  \******************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Log === undefined) App.Module.Log = {};
    if (App.Module.Log.Collection === undefined) App.Module.Log.Collection = {};
    App.Module.Log.Collection.LogQueues = App.Collection.Collection.extend({
      model: App.Module.Log.Model.LogQueue,
      url: "/logQueue/list"
    });
  });
});

/***/ }),

/***/ "./Modules/Log/Resources/assets/js/collections/pageable/LogQueues.js":
/*!***************************************************************************!*\
  !*** ./Modules/Log/Resources/assets/js/collections/pageable/LogQueues.js ***!
  \***************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Log === undefined) App.Module.Log = {};
    if (App.Module.Log.Collection === undefined) App.Module.Log.Collection = {};
    if (App.Module.Log.Collection.Pageable === undefined) App.Module.Log.Collection.Pageable = {};
    App.Module.Log.Collection.Pageable.LogQueues = App.Collection.Pageable.Pageable.extend({
      model: App.Module.Log.Model.LogQueue,
      url: "/logQueue/list/pageable"
    });
  });
});

/***/ }),

/***/ "./Modules/Log/Resources/assets/js/models/LogQueue.js":
/*!************************************************************!*\
  !*** ./Modules/Log/Resources/assets/js/models/LogQueue.js ***!
  \************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Log === undefined) App.Module.Log = {};
    if (App.Module.Log.Model === undefined) App.Module.Log.Model = {};
    App.Module.Log.Model.LogQueue = App.Model.Model.extend({
      defaults: {
        'name': '',
        'action': '',
        'data': '',
        'log': '',
        'state': 0
      },
      urlRoot: "/logQueue",
      parse: function parse(resp) {
        // TODO
        // resp.client = new App.Model.Client(resp.client);
        return resp;
      }
    });
  });
});

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!************************************************!*\
  !*** ./Modules/Log/Resources/assets/js/app.js ***!
  \************************************************/
__webpack_require__(/*! ./models/LogQueue */ "./Modules/Log/Resources/assets/js/models/LogQueue.js");

__webpack_require__(/*! ./collections/LogQueues */ "./Modules/Log/Resources/assets/js/collections/LogQueues.js");

__webpack_require__(/*! ./collections/pageable/LogQueues */ "./Modules/Log/Resources/assets/js/collections/pageable/LogQueues.js");
})();

/******/ })()
;