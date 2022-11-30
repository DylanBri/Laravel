/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./Modules/Customer/Resources/assets/js/collections/Addresses.js":
/*!***********************************************************************!*\
  !*** ./Modules/Customer/Resources/assets/js/collections/Addresses.js ***!
  \***********************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Customer === undefined) App.Module.Customer = {};
    if (App.Module.Customer.Collection === undefined) App.Module.Customer.Collection = {};
    App.Module.Customer.Collection.Addresses = App.Collection.Collection.extend({
      model: App.Module.Customer.Model.Address,
      url: "/customer/address/list"
    });
  });
});

/***/ }),

/***/ "./Modules/Customer/Resources/assets/js/collections/Customers.js":
/*!***********************************************************************!*\
  !*** ./Modules/Customer/Resources/assets/js/collections/Customers.js ***!
  \***********************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Customer === undefined) App.Module.Customer = {};
    if (App.Module.Customer.Collection === undefined) App.Module.Customer.Collection = {};
    App.Module.Customer.Collection.Customers = App.Collection.Collection.extend({
      model: App.Module.Customer.Model.Customer,
      url: "/customer/list"
    });
  });
});

/***/ }),

/***/ "./Modules/Customer/Resources/assets/js/collections/pageable/Addresses.js":
/*!********************************************************************************!*\
  !*** ./Modules/Customer/Resources/assets/js/collections/pageable/Addresses.js ***!
  \********************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Customer === undefined) App.Module.Customer = {};
    if (App.Module.Customer.Collection === undefined) App.Module.Customer.Collection = {};
    if (App.Module.Customer.Collection.Pageable === undefined) App.Module.Customer.Collection.Pageable = {};
    App.Module.Customer.Collection.Pageable.Addresses = App.Collection.Pageable.Pageable.extend({
      model: App.Module.Customer.Model.Address,
      url: "/customer/address/list/pageable"
    });
  });
});

/***/ }),

/***/ "./Modules/Customer/Resources/assets/js/collections/pageable/Customers.js":
/*!********************************************************************************!*\
  !*** ./Modules/Customer/Resources/assets/js/collections/pageable/Customers.js ***!
  \********************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Customer === undefined) App.Module.Customer = {};
    if (App.Module.Customer.Collection === undefined) App.Module.Customer.Collection = {};
    if (App.Module.Customer.Collection.Pageable === undefined) App.Module.Customer.Collection.Pageable = {};
    App.Module.Customer.Collection.Pageable.Customers = App.Collection.Pageable.Pageable.extend({
      model: App.Module.Customer.Model.Customer,
      url: "/customer/list/pageable"
    });
  });
});

/***/ }),

/***/ "./Modules/Customer/Resources/assets/js/models/Address.js":
/*!****************************************************************!*\
  !*** ./Modules/Customer/Resources/assets/js/models/Address.js ***!
  \****************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Customer === undefined) App.Module.Customer = {};
    if (App.Module.Customer.Model === undefined) App.Module.Customer.Model = {};
    App.Module.Customer.Model.Address = App.Model.Model.extend({
      defaults: {
        id: null,
        'address1': '',
        'address2': '',
        'zip_code': '',
        'city': '' //'country': 'FR'

      },
      urlRoot: "/customer/address",
      parse: function parse(resp) {
        // TODO
        // resp.category = new App.Model.UserCategory(resp.userCategory);
        return resp;
      }
    });
  });
});

/***/ }),

/***/ "./Modules/Customer/Resources/assets/js/models/Customer.js":
/*!*****************************************************************!*\
  !*** ./Modules/Customer/Resources/assets/js/models/Customer.js ***!
  \*****************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Customer === undefined) App.Module.Customer = {};
    if (App.Module.Customer.Model === undefined) App.Module.Customer.Model = {};
    App.Module.Customer.Model.Customer = App.Model.Model.extend({
      defaults: {
        id: null,
        'address_id': 0,
        'client_id': 0,
        'address_1': '',
        'address_2': '',
        'zip_code': '',
        'city': '',
        'country': 'FR',
        'name': '',
        'gender': '',
        'phone': '',
        'fax': ''
      },
      urlRoot: "/customer",
      parse: function parse(resp) {
        // TODO
        // resp.category = new App.Model.UserCategory(resp.userCategory);
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
/*!*****************************************************!*\
  !*** ./Modules/Customer/Resources/assets/js/app.js ***!
  \*****************************************************/
__webpack_require__(/*! ./models/Customer */ "./Modules/Customer/Resources/assets/js/models/Customer.js");

__webpack_require__(/*! ./collections/Customers */ "./Modules/Customer/Resources/assets/js/collections/Customers.js");

__webpack_require__(/*! ./collections/pageable/Customers */ "./Modules/Customer/Resources/assets/js/collections/pageable/Customers.js");

__webpack_require__(/*! ./models/Address */ "./Modules/Customer/Resources/assets/js/models/Address.js");

__webpack_require__(/*! ./collections/Addresses */ "./Modules/Customer/Resources/assets/js/collections/Addresses.js");

__webpack_require__(/*! ./collections/pageable/Addresses */ "./Modules/Customer/Resources/assets/js/collections/pageable/Addresses.js");
})();

/******/ })()
;