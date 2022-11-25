/******/ (() => { // webpackBootstrap
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/global */
/******/ 	(() => {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/functions.js ***!
  \***********************************/
__webpack_require__.g.getCookie = function (cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');

  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];

    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }

    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }

  return "";
};

__webpack_require__.g.setCookie = function (cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  var expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
};

__webpack_require__.g.sprintf = function () {
  var args = arguments,
      string = args[0],
      i = 0;
  return string.replace(/%((%)|s|d)/g, function (m) {
    // m is the matched format, e.g. %s, %d
    var val = null;

    if (m[2]) {
      val = m[2];
    } else {
      val = args[1][i]; // A switch statement so that the formatter can be extended. Default is %s

      switch (m) {
        case '%d':
          val = parseFloat(val);

          if (isNaN(val)) {
            val = 0;
          }

          break;
      }

      i++;
    }

    return val;
  });
};

__webpack_require__.g.ucfirst = function (str) {
  //  discuss at: http://locutus.io/php/ucfirst/
  // original by: Kevin van Zonneveld (http://kvz.io)
  // bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
  // improved by: Brett Zamir (http://brett-zamir.me)
  //   example 1: ucfirst('kevin van zonneveld')
  //   returns 1: 'Kevin van zonneveld'
  str += '';
  var f = str.charAt(0).toUpperCase();
  return f + str.substr(1);
};

__webpack_require__.g.zeroFill = function (number, n) {
  var isNegative = parseInt(number) < 0;
  number = isNegative ? -1 * number : number;

  for (var i = number.toString().length; i < n; i++) {
    number = '0' + number;
  }

  return (isNegative ? '-' : '') + number;
};

__webpack_require__.g.roundWith = function (number, nbZero) {
  return Math.round(number * Math.pow(10, nbZero)) / Math.pow(10, nbZero);
};

__webpack_require__.g.isInt = function (value) {
  var x;
  return isNaN(value) ? !1 : (x = parseFloat(value), (0 | x) === x);
};
/******/ })()
;