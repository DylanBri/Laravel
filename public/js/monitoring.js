/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./Modules/Monitoring/Resources/assets/js/collections/Lots.js":
/*!********************************************************************!*\
  !*** ./Modules/Monitoring/Resources/assets/js/collections/Lots.js ***!
  \********************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
    if (App.Module.Monitoring.Collection === undefined) App.Module.Monitoring.Collection = {};
    App.Module.Monitoring.Collection.Lots = App.Collection.Collection.extend({
      model: App.Module.Monitoring.Model.Lot,
      url: "/monitoring/lot/list"
    });
  });
});

/***/ }),

/***/ "./Modules/Monitoring/Resources/assets/js/collections/Monitorings.js":
/*!***************************************************************************!*\
  !*** ./Modules/Monitoring/Resources/assets/js/collections/Monitorings.js ***!
  \***************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
    if (App.Module.Monitoring.Collection === undefined) App.Module.Monitoring.Collection = {};
    App.Module.Monitoring.Collection.Monitorings = App.Collection.Collection.extend({
      model: App.Module.Monitoring.Model.Monitoring,
      url: "/monitoring/list"
    });
  });
});

/***/ }),

/***/ "./Modules/Monitoring/Resources/assets/js/collections/WorkSiteLotCompany.js":
/*!**********************************************************************************!*\
  !*** ./Modules/Monitoring/Resources/assets/js/collections/WorkSiteLotCompany.js ***!
  \**********************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
    if (App.Module.Monitoring.Collection === undefined) App.Module.Monitoring.Collection = {};
    App.Module.Monitoring.Collection.WorkSiteLotCompany = App.Collection.Collection.extend({
      model: App.Module.Monitoring.Model.WorkSiteLotCompany,
      url: "monitoring/work-site-lot-company/list"
    });
  });
});

/***/ }),

/***/ "./Modules/Monitoring/Resources/assets/js/collections/WorkSites.js":
/*!*************************************************************************!*\
  !*** ./Modules/Monitoring/Resources/assets/js/collections/WorkSites.js ***!
  \*************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
    if (App.Module.Monitoring.Collection === undefined) App.Module.Monitoring.Collection = {};
    App.Module.Monitoring.Collection.WorkSites = App.Collection.Collection.extend({
      model: App.Module.Monitoring.Model.WorkSite,
      url: "monitoring/work-site/list"
    });
  });
});

/***/ }),

/***/ "./Modules/Monitoring/Resources/assets/js/collections/pageable/Lots.js":
/*!*****************************************************************************!*\
  !*** ./Modules/Monitoring/Resources/assets/js/collections/pageable/Lots.js ***!
  \*****************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
    if (App.Module.Monitoring.Collection === undefined) App.Module.Monitoring.Collection = {};
    if (App.Module.Monitoring.Collection.Pageable === undefined) App.Module.Monitoring.Collection.Pageable = {};
    App.Module.Monitoring.Collection.Pageable.Lots = App.Collection.Pageable.Pageable.extend({
      model: App.Module.Monitoring.Model.Lot,
      url: "/monitoring/lot/list/pageable"
    });
  });
});

/***/ }),

/***/ "./Modules/Monitoring/Resources/assets/js/collections/pageable/Monitorings.js":
/*!************************************************************************************!*\
  !*** ./Modules/Monitoring/Resources/assets/js/collections/pageable/Monitorings.js ***!
  \************************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
    if (App.Module.Monitoring.Collection === undefined) App.Module.Monitoring.Collection = {};
    if (App.Module.Monitoring.Collection.Pageable === undefined) App.Module.Monitoring.Collection.Pageable = {};
    App.Module.Monitoring.Collection.Pageable.Monitorings = App.Collection.Pageable.Pageable.extend({
      model: App.Module.Monitoring.Model.Monitoring,
      url: "/monitoring/list/pageable"
    });
  });
});

/***/ }),

/***/ "./Modules/Monitoring/Resources/assets/js/collections/pageable/WorkSiteLotCompany.js":
/*!*******************************************************************************************!*\
  !*** ./Modules/Monitoring/Resources/assets/js/collections/pageable/WorkSiteLotCompany.js ***!
  \*******************************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
    if (App.Module.Monitoring.Collection === undefined) App.Module.Monitoring.Collection = {};
    if (App.Module.Monitoring.Collection.Pageable === undefined) App.Module.Monitoring.Collection.Pageable = {};
    App.Module.Monitoring.Collection.Pageable.WorkSiteLotCompany = App.Collection.Pageable.Pageable.extend({
      model: App.Module.Monitoring.Model.WorkSiteLotCompany,
      url: "/monitoring/work-site-lot-company/list/pageable"
    });
  });
});

/***/ }),

/***/ "./Modules/Monitoring/Resources/assets/js/collections/pageable/WorkSites.js":
/*!**********************************************************************************!*\
  !*** ./Modules/Monitoring/Resources/assets/js/collections/pageable/WorkSites.js ***!
  \**********************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
    if (App.Module.Monitoring.Collection === undefined) App.Module.Monitoring.Collection = {};
    if (App.Module.Monitoring.Collection.Pageable === undefined) App.Module.Monitoring.Collection.Pageable = {};
    App.Module.Monitoring.Collection.Pageable.WorkSites = App.Collection.Pageable.Pageable.extend({
      model: App.Module.Monitoring.Model.WorkSite,
      url: "/monitoring/work-site/list/pageable"
    });
  });
});

/***/ }),

/***/ "./Modules/Monitoring/Resources/assets/js/models/Lot.js":
/*!**************************************************************!*\
  !*** ./Modules/Monitoring/Resources/assets/js/models/Lot.js ***!
  \**************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
    if (App.Module.Monitoring.Model === undefined) App.Module.Monitoring.Model = {};
    App.Module.Monitoring.Model.Lot = App.Model.Model.extend({
      defaults: {
        id: null,
        'client_id': '',
        'name': '',
        'description': ''
      },
      urlRoot: "/monitoring/lot",
      parse: function parse(resp) {
        // TODO
        // resp.category = new App.Model.UserCategory(resp.userCategory);
        return resp;
      }
    });
  });
});

/***/ }),

/***/ "./Modules/Monitoring/Resources/assets/js/models/Monitoring.js":
/*!*********************************************************************!*\
  !*** ./Modules/Monitoring/Resources/assets/js/models/Monitoring.js ***!
  \*********************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
    if (App.Module.Monitoring.Model === undefined) App.Module.Monitoring.Model = {};
    App.Module.Monitoring.Model.Monitoring = App.Model.Model.extend({
      defaults: {
        id: null,
        'client_id': 0,
        'parent_id': null,

        /*
        'lot_id': '',
        'lot_name': '',
        'work_site_id': '',
        'work_site_name': '',
        */
        'work_site_lot_company_id': '',
        'name': '',
        'date': '',
        'lot_amount': 0,
        'market_amount': 0,
        'modify_market_amount': 0,
        'tot_market_amount': 0,
        'rate_vat': 0,
        'deposit': 0,
        'account_percent': 0,
        'account': 0,
        'account_management_percent': 0,
        'account_management': 0,
        'bank_guarantee': 0,
        'retention_money_percent': 0,
        'retention_money': 0,
        'balance': 0,
        'doc_penality_percent': 0,
        'doc_penality': 0,
        'work_penality': 0,
        'progress': 0,
        'balance_du': 0,
        'deduction_previous_payment': 0,
        'cumul_monitoring_previous': 0,
        'amount_to_pay': 0
      },
      urlRoot: "/monitoring",
      parse: function parse(resp) {
        // TODO
        // resp.category = new App.Model.UserCategory(resp.userCategory);
        return resp;
      }
    });
  });
});

/***/ }),

/***/ "./Modules/Monitoring/Resources/assets/js/models/WorkSite.js":
/*!*******************************************************************!*\
  !*** ./Modules/Monitoring/Resources/assets/js/models/WorkSite.js ***!
  \*******************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
    if (App.Module.Monitoring.Model === undefined) App.Module.Monitoring.Model = {};
    App.Module.Monitoring.Model.WorkSite = App.Model.Model.extend({
      defaults: {
        id: null,
        'client_id': '',
        'customer_id': '',
        'customer_name': '',
        'name': '',
        'notes': '',
        'cumul': 0,
        'address1': '',
        'address2': '',
        'city': '',
        'zip_code': ''
      },
      urlRoot: "/monitoring/work-site",
      parse: function parse(resp) {
        // TODO
        // resp.category = new App.Model.UserCategory(resp.userCategory);
        return resp;
      }
    });
  });
});

/***/ }),

/***/ "./Modules/Monitoring/Resources/assets/js/models/WorkSiteLotCompany.js":
/*!*****************************************************************************!*\
  !*** ./Modules/Monitoring/Resources/assets/js/models/WorkSiteLotCompany.js ***!
  \*****************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
    if (App.Module.Monitoring.Model === undefined) App.Module.Monitoring.Model = {};
    App.Module.Monitoring.Model.WorkSiteLotCompany = App.Model.Model.extend({
      defaults: {
        id: null,
        'client_id': '',
        'company_id': '',
        'company_name': '',
        'lot_id': '',
        'lot_name': '',
        'work_site_id': '',
        'work_site_name': '',
        //'customer_id': '',
        'monitoring_id': '',
        'name': '',
        'type': '',
        'amount_ttc': 0,
        'cumul_payment': 0,
        'cumul_monitoring': 0
      },
      urlRoot: "/monitoring/work-site-lot-company",
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
/*!*******************************************************!*\
  !*** ./Modules/Monitoring/Resources/assets/js/app.js ***!
  \*******************************************************/
__webpack_require__(/*! ./models/Lot */ "./Modules/Monitoring/Resources/assets/js/models/Lot.js");

__webpack_require__(/*! ./collections/Lots */ "./Modules/Monitoring/Resources/assets/js/collections/Lots.js");

__webpack_require__(/*! ./collections/pageable/Lots */ "./Modules/Monitoring/Resources/assets/js/collections/pageable/Lots.js");

__webpack_require__(/*! ./models/WorkSite */ "./Modules/Monitoring/Resources/assets/js/models/WorkSite.js");

__webpack_require__(/*! ./collections/WorkSites */ "./Modules/Monitoring/Resources/assets/js/collections/WorkSites.js");

__webpack_require__(/*! ./collections/pageable/WorkSites */ "./Modules/Monitoring/Resources/assets/js/collections/pageable/WorkSites.js");

__webpack_require__(/*! ./models/Monitoring */ "./Modules/Monitoring/Resources/assets/js/models/Monitoring.js");

__webpack_require__(/*! ./collections/Monitorings */ "./Modules/Monitoring/Resources/assets/js/collections/Monitorings.js");

__webpack_require__(/*! ./collections/pageable/Monitorings */ "./Modules/Monitoring/Resources/assets/js/collections/pageable/Monitorings.js");

__webpack_require__(/*! ./models/WorkSiteLotCompany */ "./Modules/Monitoring/Resources/assets/js/models/WorkSiteLotCompany.js");

__webpack_require__(/*! ./collections/WorkSiteLotCompany */ "./Modules/Monitoring/Resources/assets/js/collections/WorkSiteLotCompany.js");

__webpack_require__(/*! ./collections/pageable/WorkSiteLotCompany */ "./Modules/Monitoring/Resources/assets/js/collections/pageable/WorkSiteLotCompany.js");
})();

/******/ })()
;