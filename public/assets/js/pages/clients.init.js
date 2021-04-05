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
/******/ 	return __webpack_require__(__webpack_require__.s = 57);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/pages/clients.init.js":
/*!********************************************!*\
  !*** ./resources/js/pages/clients.init.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $(function () {
    // Multiple images preview in browser
    var imagesPreview = function imagesPreview(input, placeToInsertImagePreview) {
      if (input.files) {
        var filesAmount = input.files.length;

        for (i = 0; i < filesAmount; i++) {
          var reader = new FileReader();

          reader.onload = function (event) {
            $($.parseHTML('<img>')).attr('src', event.target.result).attr('class', 'img-fluid').appendTo(placeToInsertImagePreview);
          };

          reader.readAsDataURL(input.files[i]);
        }
      }
    };

    $('#gallery-photo-add').on('change', function () {
      $('label.label img').remove();
      $('.material-icons').hide();
      $('span.title').hide();
      imagesPreview(this, 'label.label');
    });
  });
  var $billing_country = $('#country'),
      $shipping_country = $('#country-shipping'),
      $shipping_address_city = $('#shipping_address_city'),
      $billing_address_city = $('#billing_address_city'),
      $assigned_user_id = $('#assigned_user_id'),
      $c_type = $('#c_type'),
      $industry = $('#industry'),
      $searchName = $('#searchName'),
      $searchPhone = $('#searchPhone'),
      $group_id = $('#group_id'),
      token = $('meta[name="csrf-token"]').attr('content');
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
  /*  $billing_country.on('change', initializeSelect2);
    $shipping_country.on('change', initializeSelect2Shipping);*/

  $group_id.select2();
  $industry.select2();
  $c_type.select2();
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
    },
    minimumInputLength: 1
  });
  $billing_country.select2({
    "placeholder": $billing_country.data('placeholder'),
    "width": '100%'
  });
  $shipping_country.select2({
    "placeholder": $billing_country.data('placeholder'),
    "width": '100%'
  });
  initializeSelectBillingCities();
  $billing_country.change(function () {
    $billing_address_city.val(null);
    $billing_address_city.data("placeholder", $billing_address_city.data('searching'));
    initializeSelectBillingCities();
  });
  initializeSelectShippingCities();
  $shipping_country.change(function () {
    $shipping_address_city.val(null);
    $shipping_address_city.data("placeholder", $shipping_address_city.data('searching'));
    initializeSelectShippingCities();
  });

  function initializeSelectShippingCities() {
    var value = $shipping_country.children("option:selected").val();
    $shipping_address_city.select2({
      ajax: {
        url: $shipping_address_city.data('url'),
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
      placeholder: $shipping_address_city.data('searching'),
      language: {
        // You can find all of the options in the language files provided in the
        // build. They all must be functions that return the string that should be
        // displayed.
        inputTooShort: function inputTooShort() {
          return $shipping_address_city.data('start');
        },
        searching: function searching() {
          return $shipping_address_city.data('searching');
        },
        noResults: function noResults() {
          return $shipping_address_city.data('noResults');
        }
      },
      minimumInputLength: 1
    });
  }

  function isNumeric(value) {
    return /^-?\d+$/.test(value);
  }

  function initializeSelectBillingCities() {
    var value = $billing_country.children("option:selected").val();
    $billing_address_city.select2({
      ajax: {
        url: $billing_address_city.data('url'),
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
      placeholder: $billing_address_city.data('searching'),
      language: {
        // You can find all of the options in the language files provided in the
        // build. They all must be functions that return the string that should be
        // displayed.
        inputTooShort: function inputTooShort() {
          return $billing_address_city.data('start');
        },
        searching: function searching() {
          return $billing_address_city.data('searching');
        },
        noResults: function noResults() {
          return $billing_address_city.data('noResults');
        }
      },
      minimumInputLength: 1
    });
  }
});

/***/ }),

/***/ 57:
/*!**************************************************!*\
  !*** multi ./resources/js/pages/clients.init.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! g:\OpenServer\domains\newcrm\resources\js\pages\clients.init.js */"./resources/js/pages/clients.init.js");


/***/ })

/******/ });