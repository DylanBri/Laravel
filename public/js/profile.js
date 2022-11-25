/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./Modules/Profile/Resources/assets/js/collections/Administrators.js":
/*!***************************************************************************!*\
  !*** ./Modules/Profile/Resources/assets/js/collections/Administrators.js ***!
  \***************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Profile === undefined) App.Module.Profile = {};
    if (App.Module.Profile.Collection === undefined) App.Module.Profile.Collection = {};
    App.Module.Profile.Collection.Administrators = App.Collection.Collection.extend({
      model: App.Module.Profile.Model.Administrator,
      url: "/admin/list"
    });
  });
});

/***/ }),

/***/ "./Modules/Profile/Resources/assets/js/collections/Managers.js":
/*!*********************************************************************!*\
  !*** ./Modules/Profile/Resources/assets/js/collections/Managers.js ***!
  \*********************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Profile === undefined) App.Module.Profile = {};
    if (App.Module.Profile.Collection === undefined) App.Module.Profile.Collection = {};
    App.Module.Profile.Collection.Managers = App.Collection.Collection.extend({
      model: App.Module.Profile.Model.Manager,
      url: "/manager/list"
    });
  });
});

/***/ }),

/***/ "./Modules/Profile/Resources/assets/js/collections/SuperAdmins.js":
/*!************************************************************************!*\
  !*** ./Modules/Profile/Resources/assets/js/collections/SuperAdmins.js ***!
  \************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Profile === undefined) App.Module.Profile = {};
    if (App.Module.Profile.Collection === undefined) App.Module.Profile.Collection = {};
    App.Module.Profile.Collection.SuperAdmins = App.Collection.Collection.extend({
      model: App.Module.Profile.Model.SuperAdmin,
      url: "/supadm/list"
    });
  });
});

/***/ }),

/***/ "./Modules/Profile/Resources/assets/js/collections/Users.js":
/*!******************************************************************!*\
  !*** ./Modules/Profile/Resources/assets/js/collections/Users.js ***!
  \******************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Profile === undefined) App.Module.Profile = {};
    if (App.Module.Profile.Collection === undefined) App.Module.Profile.Collection = {};
    App.Module.Profile.Collection.Users = App.Collection.Collection.extend({
      model: App.Module.Profile.Model.User,
      url: "/user/list"
    });
  });
});

/***/ }),

/***/ "./Modules/Profile/Resources/assets/js/collections/pageable/Administrators.js":
/*!************************************************************************************!*\
  !*** ./Modules/Profile/Resources/assets/js/collections/pageable/Administrators.js ***!
  \************************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Profile === undefined) App.Module.Profile = {};
    if (App.Module.Profile.Collection === undefined) App.Module.Profile.Collection = {};
    if (App.Module.Profile.Collection.Pageable === undefined) App.Module.Profile.Collection.Pageable = {};
    App.Module.Profile.Collection.Pageable.Administrators = App.Collection.Pageable.Pageable.extend({
      model: App.Module.Profile.Model.Administrator,
      url: "/admin/list/pageable"
    });
  });
});

/***/ }),

/***/ "./Modules/Profile/Resources/assets/js/collections/pageable/Managers.js":
/*!******************************************************************************!*\
  !*** ./Modules/Profile/Resources/assets/js/collections/pageable/Managers.js ***!
  \******************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Profile === undefined) App.Module.Profile = {};
    if (App.Module.Profile.Collection === undefined) App.Module.Profile.Collection = {};
    if (App.Module.Profile.Collection.Pageable === undefined) App.Module.Profile.Collection.Pageable = {};
    App.Module.Profile.Collection.Pageable.Managers = App.Collection.Pageable.Pageable.extend({
      model: App.Module.Profile.Model.Manager,
      url: "/manager/list/pageable"
    });
  });
});

/***/ }),

/***/ "./Modules/Profile/Resources/assets/js/collections/pageable/SuperAdmins.js":
/*!*********************************************************************************!*\
  !*** ./Modules/Profile/Resources/assets/js/collections/pageable/SuperAdmins.js ***!
  \*********************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Profile === undefined) App.Module.Profile = {};
    if (App.Module.Profile.Collection === undefined) App.Module.Profile.Collection = {};
    if (App.Module.Profile.Collection.Pageable === undefined) App.Module.Profile.Collection.Pageable = {};
    App.Module.Profile.Collection.Pageable.SuperAdmins = App.Collection.Pageable.Pageable.extend({
      model: App.Module.Profile.Model.SuperAdmin,
      url: "/supadm/list/pageable"
    });
  });
});

/***/ }),

/***/ "./Modules/Profile/Resources/assets/js/collections/pageable/Users.js":
/*!***************************************************************************!*\
  !*** ./Modules/Profile/Resources/assets/js/collections/pageable/Users.js ***!
  \***************************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Profile === undefined) App.Module.Profile = {};
    if (App.Module.Profile.Collection === undefined) App.Module.Profile.Collection = {};
    if (App.Module.Profile.Collection.Pageable === undefined) App.Module.Profile.Collection.Pageable = {};
    App.Module.Profile.Collection.Pageable.Users = App.Collection.Pageable.Pageable.extend({
      model: App.Module.Profile.Model.User,
      url: "/user/list/pageable"
    });
  });
});

/***/ }),

/***/ "./Modules/Profile/Resources/assets/js/models/Administrator.js":
/*!*********************************************************************!*\
  !*** ./Modules/Profile/Resources/assets/js/models/Administrator.js ***!
  \*********************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Profile === undefined) App.Module.Profile = {};
    if (App.Module.Profile.Model === undefined) App.Module.Profile.Model = {};
    App.Module.Profile.Model.Administrator = App.Model.Model.extend({
      defaults: {
        id: null,
        quality: "",
        name: "",
        address: "",
        address2: "",
        zip_code: "",
        city: "",
        region: "",
        country: "",
        email: "",
        phone: "",
        mobile: "",
        password: "",
        user_id: 0,
        category_id: 0,
        enabled: true,
        suppressed: false,
        user: null,
        category: null
      },
      urlRoot: "/admin",
      parse: function parse(resp) {
        // TODO
        // resp.user = new App.Model.User(resp.user);
        // resp.category = new App.Model.UserCategory(resp.userCategory);
        return resp;
      }
    });
  });
});

/***/ }),

/***/ "./Modules/Profile/Resources/assets/js/models/Manager.js":
/*!***************************************************************!*\
  !*** ./Modules/Profile/Resources/assets/js/models/Manager.js ***!
  \***************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Profile === undefined) App.Module.Profile = {};
    if (App.Module.Profile.Model === undefined) App.Module.Profile.Model = {};
    App.Module.Profile.Model.Manager = App.Model.Model.extend({
      defaults: {
        id: null,
        quality: "",
        name: "",
        address: "",
        address2: "",
        zip_code: "",
        city: "",
        region: "",
        country: "",
        email: "",
        phone: "",
        mobile: "",
        password: "",
        user_id: 0,
        category_id: 0,
        enabled: true,
        suppressed: false,
        user: null,
        category: null
      },
      urlRoot: "/manager",
      parse: function parse(resp) {
        // TODO
        // resp.user = new App.Model.User(resp.user);
        // resp.category = new App.Model.UserCategory(resp.userCategory);
        return resp;
      }
    });
  });
});

/***/ }),

/***/ "./Modules/Profile/Resources/assets/js/models/SuperAdmin.js":
/*!******************************************************************!*\
  !*** ./Modules/Profile/Resources/assets/js/models/SuperAdmin.js ***!
  \******************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Profile === undefined) App.Module.Profile = {};
    if (App.Module.Profile.Model === undefined) App.Module.Profile.Model = {};
    App.Module.Profile.Model.SuperAdmin = App.Model.Model.extend({
      defaults: {
        id: null,
        quality: "",
        name: "",
        address: "",
        address2: "",
        zip_code: "",
        city: "",
        region: "",
        country: "",
        email: "",
        phone: "",
        mobile: "",
        password: "",
        user_id: 0,
        category_id: 0,
        enabled: true,
        suppressed: false,
        user: null,
        category: null
      },
      urlRoot: "/supadm",
      parse: function parse(resp) {
        // TODO
        // resp.user = new App.Model.User(resp.user);
        // resp.category = new App.Model.UserCategory(resp.userCategory);
        return resp;
      }
    });
  });
});

/***/ }),

/***/ "./Modules/Profile/Resources/assets/js/models/User.js":
/*!************************************************************!*\
  !*** ./Modules/Profile/Resources/assets/js/models/User.js ***!
  \************************************************************/
/***/ (() => {

"use strict";


document.addEventListener('DOMContentLoaded', function (e) {
  $(document).on('app.ready', function () {
    if (App.Module.Profile === undefined) App.Module.Profile = {};
    if (App.Module.Profile.Model === undefined) App.Module.Profile.Model = {};
    App.Module.Profile.Model.User = App.Model.Model.extend({
      defaults: {
        id: null,
        quality: "",
        name: "",
        address: "",
        address2: "",
        zip_code: "",
        city: "",
        region: "",
        country: "",
        email: "",
        phone: "",
        mobile: "",
        password: "",
        user_id: 0,
        category_id: 0,
        enabled: true,
        suppressed: false,
        user: null,
        category: null
      },
      urlRoot: "/user",
      parse: function parse(resp) {
        // TODO
        // resp.user = new App.Model.User(resp.user);
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
  !*** ./Modules/Profile/Resources/assets/js/app.js ***!
  \****************************************************/
__webpack_require__(/*! ./models/SuperAdmin */ "./Modules/Profile/Resources/assets/js/models/SuperAdmin.js");

__webpack_require__(/*! ./collections/SuperAdmins */ "./Modules/Profile/Resources/assets/js/collections/SuperAdmins.js");

__webpack_require__(/*! ./collections/pageable/SuperAdmins */ "./Modules/Profile/Resources/assets/js/collections/pageable/SuperAdmins.js");

__webpack_require__(/*! ./models/Administrator */ "./Modules/Profile/Resources/assets/js/models/Administrator.js");

__webpack_require__(/*! ./collections/Administrators */ "./Modules/Profile/Resources/assets/js/collections/Administrators.js");

__webpack_require__(/*! ./collections/pageable/Administrators */ "./Modules/Profile/Resources/assets/js/collections/pageable/Administrators.js");

__webpack_require__(/*! ./models/Manager */ "./Modules/Profile/Resources/assets/js/models/Manager.js");

__webpack_require__(/*! ./collections/Managers */ "./Modules/Profile/Resources/assets/js/collections/Managers.js");

__webpack_require__(/*! ./collections/pageable/Managers */ "./Modules/Profile/Resources/assets/js/collections/pageable/Managers.js");

__webpack_require__(/*! ./models/User */ "./Modules/Profile/Resources/assets/js/models/User.js");

__webpack_require__(/*! ./collections/Users */ "./Modules/Profile/Resources/assets/js/collections/Users.js");

__webpack_require__(/*! ./collections/pageable/Users */ "./Modules/Profile/Resources/assets/js/collections/pageable/Users.js");
})();

/******/ })()
;