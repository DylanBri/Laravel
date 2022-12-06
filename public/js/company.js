/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./Modules/Company/Resources/assets/js/collections/Companies.js":
/*!**********************************************************************!*\
  !*** ./Modules/Company/Resources/assets/js/collections/Companies.js ***!
  \**********************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Company === undefined) App.Module.Company = {};
    if (App.Module.Company.Collection === undefined) App.Module.Company.Collection = {};
    App.Module.Company.Collection.Companies = App.Collection.Collection.extend({
      model: App.Module.Company.Model.Company,
      url: "/company/list"
    });
  });
});

/***/ }),

/***/ "./Modules/Company/Resources/assets/js/collections/Contacts.js":
/*!*********************************************************************!*\
  !*** ./Modules/Company/Resources/assets/js/collections/Contacts.js ***!
  \*********************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Company === undefined) App.Module.Company = {};
    if (App.Module.Company.Collection === undefined) App.Module.Company.Collection = {};
    App.Module.Company.Collection.Contacts = App.Collection.Collection.extend({
      model: App.Module.Company.Model.Contact,
      url: "/company/contact/list"
    });
  });
});

/***/ }),

/***/ "./Modules/Company/Resources/assets/js/collections/Payments.js":
/*!*********************************************************************!*\
  !*** ./Modules/Company/Resources/assets/js/collections/Payments.js ***!
  \*********************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Company === undefined) App.Module.Company = {};
    if (App.Module.Company.Collection === undefined) App.Module.Company.Collection = {};
    App.Module.Company.Collection.Payments = App.Collection.Collection.extend({
      model: App.Module.Company.Model.Payment,
      url: "/company/payment/list"
    });
  });
});

/***/ }),

/***/ "./Modules/Company/Resources/assets/js/collections/pageable/Companies.js":
/*!*******************************************************************************!*\
  !*** ./Modules/Company/Resources/assets/js/collections/pageable/Companies.js ***!
  \*******************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Company === undefined) App.Module.Company = {};
    if (App.Module.Company.Collection === undefined) App.Module.Company.Collection = {};
    if (App.Module.Company.Collection.Pageable === undefined) App.Module.Company.Collection.Pageable = {};
    App.Module.Company.Collection.Pageable.Companies = App.Collection.Pageable.Pageable.extend({
      model: App.Module.Company.Model.Company,
      url: "/company/list/pageable"
    });
  });
});

/***/ }),

/***/ "./Modules/Company/Resources/assets/js/collections/pageable/Contacts.js":
/*!******************************************************************************!*\
  !*** ./Modules/Company/Resources/assets/js/collections/pageable/Contacts.js ***!
  \******************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Company === undefined) App.Module.Company = {};
    if (App.Module.Company.Collection === undefined) App.Module.Company.Collection = {};
    if (App.Module.Company.Collection.Pageable === undefined) App.Module.Company.Collection.Pageable = {};
    App.Module.Company.Collection.Pageable.Contacts = App.Collection.Pageable.Pageable.extend({
      model: App.Module.Company.Model.Contact,
      url: "/company/contact/list/pageable"
    });
  });
});

/***/ }),

/***/ "./Modules/Company/Resources/assets/js/collections/pageable/Payments.js":
/*!******************************************************************************!*\
  !*** ./Modules/Company/Resources/assets/js/collections/pageable/Payments.js ***!
  \******************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Company === undefined) App.Module.Company = {};
    if (App.Module.Company.Collection === undefined) App.Module.Company.Collection = {};
    if (App.Module.Company.Collection.Pageable === undefined) App.Module.Company.Collection.Pageable = {};
    App.Module.Company.Collection.Pageable.Payments = App.Collection.Pageable.Pageable.extend({
      model: App.Module.Company.Model.Payment,
      url: "/company/payment/list/pageable"
    });
  });
});

/***/ }),

/***/ "./Modules/Company/Resources/assets/js/models/Company.js":
/*!***************************************************************!*\
  !*** ./Modules/Company/Resources/assets/js/models/Company.js ***!
  \***************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Company === undefined) App.Module.Company = {};
    if (App.Module.Company.Model === undefined) App.Module.Company.Model = {};
    App.Module.Company.Model.Company = App.Model.Model.extend({
      defaults: {
        id: null,
        'address_id': 0,
        'title': '',
        'name': '',
        'address_1': '',
        'address_2': '',
        'zip_code': '',
        'city': '',
        'country': 'FR',
        'phone': '',
        'supervisor': '',
        'siret': '',
        'classification': '',
        'code_ape': '',
        'email': '',
        'insurance': '',
        'client_id': 0,
        'enabled': 1,
        'suppressed': 0
      },
      urlRoot: "/company",
      parse: function parse(resp) {
        // TODO
        // resp.category = new App.Model.UserCategory(resp.userCategory);
        return resp;
      }
    });
  });
});

/***/ }),

/***/ "./Modules/Company/Resources/assets/js/models/Contact.js":
/*!***************************************************************!*\
  !*** ./Modules/Company/Resources/assets/js/models/Contact.js ***!
  \***************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Company === undefined) App.Module.Company = {};
    if (App.Module.Company.Model === undefined) App.Module.Company.Model = {};
    App.Module.Company.Model.Contact = App.Model.Model.extend({
      defaults: {
        id: null,
        'client_id': '',
        'company_id': '',
        'company_name': '',
        'firstname': '',
        'lastname': '',
        'phone': '',
        'email': '',
        'enabled': 1,
        'suppressed': 0
      },
      urlRoot: "/company/contact",
      parse: function parse(resp) {
        // TODO
        // resp.category = new App.Model.UserCategory(resp.userCategory);
        return resp;
      }
    });
  });
});

/***/ }),

/***/ "./Modules/Company/Resources/assets/js/models/Payment.js":
/*!***************************************************************!*\
  !*** ./Modules/Company/Resources/assets/js/models/Payment.js ***!
  \***************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Company === undefined) App.Module.Company = {};
    if (App.Module.Company.Model === undefined) App.Module.Company.Model = {};
    App.Module.Company.Model.Payment = App.Model.Model.extend({
      defaults: {
        id: null,
        'client_id': '',
        'customer_id': '',
        'customer_name': '',
        'company_id': '',
        'company_name': '',
        'monitoring_id': '',
        'monitoring_name': '',
        'name': '',
        'payment_request_date': '',
        'amount_ttc': '',
        'is_staged': 0,
        'is_done': 0,
        'payment_date': '',
        'payment_method': '',
        'bank_name': '',
        'enabled': 1,
        'suppressed': 0
      },
      urlRoot: "/company/payment",
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
/*!****************************************************!*\
  !*** ./Modules/Company/Resources/assets/js/app.js ***!
  \****************************************************/
__webpack_require__(/*! ./models/Company */ "./Modules/Company/Resources/assets/js/models/Company.js");

__webpack_require__(/*! ./collections/Companies */ "./Modules/Company/Resources/assets/js/collections/Companies.js");

__webpack_require__(/*! ./collections/pageable/Companies */ "./Modules/Company/Resources/assets/js/collections/pageable/Companies.js");

__webpack_require__(/*! ./models/Payment */ "./Modules/Company/Resources/assets/js/models/Payment.js");

__webpack_require__(/*! ./collections/Payments */ "./Modules/Company/Resources/assets/js/collections/Payments.js");

__webpack_require__(/*! ./collections/pageable/Payments */ "./Modules/Company/Resources/assets/js/collections/pageable/Payments.js");

__webpack_require__(/*! ./models/Contact */ "./Modules/Company/Resources/assets/js/models/Contact.js");

__webpack_require__(/*! ./collections/Contacts */ "./Modules/Company/Resources/assets/js/collections/Contacts.js");

__webpack_require__(/*! ./collections/pageable/Contacts */ "./Modules/Company/Resources/assets/js/collections/pageable/Contacts.js");
})();

/******/ })()
;