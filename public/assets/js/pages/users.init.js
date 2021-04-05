/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 60);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/pages/users.init.js":
/*!******************************************!*\
  !*** ./resources/js/pages/users.init.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  var $country = $('#country'),
      $city = $('#city'),
      $team_id = $('#team_id'),
      $space_id = $('#space_id'),
      $searchName = $('#searchName'),
      $searchEmail = $('#searchEmail'),
      $searchPhone = $('#searchPhone'),
      $assigned_user_id = $('#assigned_user_id'),
      $roleId = $('#roleId'),
      token = $('meta[name="csrf-token"]').attr('content');
  $assigned_user_id.select2({
    ajax: {
      url: $assigned_user_id.data('url'),
      type: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-Token': token
      },
      data: function data(params) {
        return {
          q: params.term,
          // search term
          page: params.page
        };
      },
      processResults: function processResults(data, params) {
        // parse the results into the format expected by Select2
        // since we are using custom formatting functions we do not need to
        // alter the remote JSON data, except to indicate that infinite
        // scrolling can be used
        params.page = params.page || 1;
        return {
          results: data,
          pagination: {
            more: params.page * 30 < data.total_count
          }
        };
      }
    },
    placeholder: $assigned_user_id.data('placeholder'),
    language: {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      inputTooShort: function inputTooShort() {
        return $assigned_user_id.data('start');
      },
      searching: function searching() {
        return $assigned_user_id.data('searching');
      },
      noResults: function noResults() {
        return $assigned_user_id.data('noResults');
      }
    }
  });
  $searchName.select2({
    ajax: {
      url: $searchName.data('url'),
      type: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-Token': token
      },
      data: function data(params) {
        return {
          q: params.term,
          // search term
          page: params.page
        };
      },
      processResults: function processResults(data, params) {
        // parse the results into the format expected by Select2
        // since we are using custom formatting functions we do not need to
        // alter the remote JSON data, except to indicate that infinite
        // scrolling can be used
        params.page = params.page || 1;
        return {
          results: data,
          pagination: {
            more: params.page * 30 < data.total_count
          }
        };
      }
    },
    placeholder: $searchName.data('placeholder'),
    language: {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      inputTooShort: function inputTooShort() {
        return $searchName.data('start');
      },
      searching: function searching() {
        return $searchName.data('searching');
      },
      noResults: function noResults() {
        return $searchName.data('noResults');
      }
    }
  });
  $searchName.change(function () {
    $('#form').submit();
  });
  $searchEmail.select2({
    ajax: {
      url: $searchEmail.data('url'),
      type: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-Token': token
      },
      data: function data(params) {
        return {
          q: params.term,
          // search term
          page: params.page
        };
      },
      processResults: function processResults(data, params) {
        // parse the results into the format expected by Select2
        // since we are using custom formatting functions we do not need to
        // alter the remote JSON data, except to indicate that infinite
        // scrolling can be used
        params.page = params.page || 1;
        return {
          results: data,
          pagination: {
            more: params.page * 30 < data.total_count
          }
        };
      }
    },
    placeholder: $searchEmail.data('placeholder'),
    language: {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      inputTooShort: function inputTooShort() {
        return $searchEmail.data('start');
      },
      searching: function searching() {
        return $searchEmail.data('searching');
      },
      noResults: function noResults() {
        return $searchEmail.data('noResults');
      }
    }
  });
  $searchEmail.change(function () {
    $('#form').submit();
  });
  $searchPhone.select2({
    ajax: {
      url: $searchPhone.data('url'),
      type: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-Token': token
      },
      data: function data(params) {
        return {
          q: params.term,
          // search term
          page: params.page
        };
      },
      processResults: function processResults(data, params) {
        // parse the results into the format expected by Select2
        // since we are using custom formatting functions we do not need to
        // alter the remote JSON data, except to indicate that infinite
        // scrolling can be used
        params.page = params.page || 1;
        return {
          results: data,
          pagination: {
            more: params.page * 30 < data.total_count
          }
        };
      }
    },
    placeholder: $searchPhone.data('placeholder'),
    language: {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      inputTooShort: function inputTooShort() {
        return $searchPhone.data('start');
      },
      searching: function searching() {
        return $searchPhone.data('searching');
      },
      noResults: function noResults() {
        return $searchPhone.data('noResults');
      }
    }
  });
  $searchPhone.change(function () {
    $('#form').submit();
  });
  $team_id.select2({
    ajax: {
      url: $team_id.data('url'),
      type: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-Token': token
      },
      data: function data(params) {
        return {
          q: params.term,
          // search term
          page: params.page
        };
      },
      processResults: function processResults(data, params) {
        // parse the results into the format expected by Select2
        // since we are using custom formatting functions we do not need to
        // alter the remote JSON data, except to indicate that infinite
        // scrolling can be used
        params.page = params.page || 1;
        return {
          results: data,
          pagination: {
            more: params.page * 30 < data.total_count
          }
        };
      }
    },
    placeholder: $team_id.data('placeholder'),
    language: {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      inputTooShort: function inputTooShort() {
        return $team_id.data('start');
      },
      searching: function searching() {
        return $team_id.data('searching');
      },
      noResults: function noResults() {
        return $team_id.data('noResults');
      }
    }
  });
  $space_id.select2({
    ajax: {
      url: $space_id.data('url'),
      type: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-Token': token
      },
      data: function data(params) {
        return {
          q: params.term,
          // search term
          page: params.page
        };
      },
      processResults: function processResults(data, params) {
        // parse the results into the format expected by Select2
        // since we are using custom formatting functions we do not need to
        // alter the remote JSON data, except to indicate that infinite
        // scrolling can be used
        params.page = params.page || 1;
        return {
          results: data,
          pagination: {
            more: params.page * 30 < data.total_count
          }
        };
      }
    },
    placeholder: $space_id.data('placeholder'),
    language: {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      inputTooShort: function inputTooShort() {
        return $space_id.data('start');
      },
      searching: function searching() {
        return $space_id.data('searching');
      },
      noResults: function noResults() {
        return $space_id.data('noResults');
      }
    }
  });
  $country.select2({
    "placeholder": $country.data('placeholder'),
    "width": '100%'
  });
  $roleId.select2({
    "placeholder": $roleId.data('placeholder'),
    "width": '100%'
  });
  initializeSelectCities();
  $country.change(function () {
    $city.val(null);
    $city.data("placeholder", $city.data('searching'));
    initializeSelectCities();
  });

  function initializeSelectCities() {
    var value = $country.children("option:selected").val();
    $city.select2({
      ajax: {
        url: $city.data('url'),
        type: 'POST',
        dataType: 'json',
        headers: {
          'X-CSRF-Token': token
        },
        data: function data(params) {
          return {
            q: params.term,
            // search term
            page: params.page,
            country: value
          };
        },
        processResults: function processResults(data, params) {
          // parse the results into the format expected by Select2
          // since we are using custom formatting functions we do not need to
          // alter the remote JSON data, except to indicate that infinite
          // scrolling can be used
          params.page = params.page || 1;
          return {
            results: data,
            pagination: {
              more: params.page * 30 < data.total_count
            }
          };
        }
      },
      placeholder: $city.data('searching'),
      language: {
        // You can find all of the options in the language files provided in the
        // build. They all must be functions that return the string that should be
        // displayed.
        inputTooShort: function inputTooShort() {
          return $city.data('start');
        },
        searching: function searching() {
          return $city.data('searching');
        },
        noResults: function noResults() {
          return $city.data('noResults');
        }
      },
      minimumInputLength: 1
    });
  }
});

/***/ }),

/***/ 60:
/*!************************************************!*\
  !*** multi ./resources/js/pages/users.init.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! g:\OpenServer\domains\newcrm\resources\js\pages\users.init.js */"./resources/js/pages/users.init.js");


/***/ })

/******/ });