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
/******/ 	return __webpack_require__(__webpack_require__.s = 68);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/pages/purchaseReport.init.js":
/*!***************************************************!*\
  !*** ./resources/js/pages/purchaseReport.init.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  var token = $('meta[name="csrf-token"]').attr('content'),
      $wasteTypes = $('#waste_types'),
      $stocks = $('#stocks'),
      $tableStock = $('#stock-body'),
      $dateStart = $('#date_start'),
      $dateFinish = $('#date_finish'),
      $id = $('#id_page'),
      $userId = $('#user_id'),
      $owner = $('#owner'),
      $prevLotSum = $('#previous_info'),
      $searchName = $('#searchName'),
      $tableWaste = $('#wastes-body'); //----------------------------------//

  $owner.change(function () {
    $('#form').submit();
  });
  $searchName.change(function () {
    $('#form').submit();
  });
  $wasteTypes.select2({
    "placeholder": $wasteTypes.data('placeholder'),
    "width": '100%'
  });
  $stocks.select2({
    ajax: {
      url: $stocks.data('url'),
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
          userId: $userId.val(),
          purchaseReport: true
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
    placeholder: $stocks.data('placeholder'),
    language: {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      inputTooShort: function inputTooShort() {
        return $stocks.data('start');
      },
      searching: function searching() {
        return $stocks.data('searching');
      },
      noResults: function noResults() {
        return $stocks.data('noResults');
      }
    }
  });
  $userId.select2({
    ajax: {
      url: $userId.data('url'),
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
          start: $dateStart.val(),
          finish: $dateFinish.val()
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
    placeholder: $userId.data('placeholder'),
    language: {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      inputTooShort: function inputTooShort() {
        return $userId.data('start');
      },
      searching: function searching() {
        return $userId.data('searching');
      },
      noResults: function noResults() {
        return $userId.data('noResults');
      }
    }
  });
  $owner.select2({
    ajax: {
      url: $owner.data('url'),
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
    placeholder: $owner.data('placeholder'),
    language: {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      inputTooShort: function inputTooShort() {
        return $owner.data('start');
      },
      searching: function searching() {
        return $owner.data('searching');
      },
      noResults: function noResults() {
        return $owner.data('noResults');
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
  $stocks.change(function () {
    $.ajax({
      'url': $stocks.data('info'),
      'method': 'POST',
      'data': {
        "stocks": $stocks.val()
      },
      'dataType': 'json',
      'success': function success(data) {
        generateStockTable(data);
        calcTotal();
      }
    });
  });
  $wasteTypes.change(function () {
    $.ajax({
      'url': $wasteTypes.data('info'),
      'method': 'POST',
      'data': {
        "wastes": $wasteTypes.val(),
        "id": $id.val()
      },
      'dataType': 'json',
      'success': function success(data) {
        generateWasteTable(data).then(function () {
          calcWastes();
          calcTotal();
        });
      }
    });
  });

  function generateStockTable(data) {
    $tableStock.find('tr').not('.table-info').remove();
    var total = 0;
    $.each(data, function (k, v) {
      if (k !== 'error') {
        var prevSum = 0;
        var obj = jQuery.parseJSON($prevLotSum.val());
        var f = false;

        if (typeof obj !== 'undefined') {
          prevSum = obj[k];

          if (typeof prevSum !== 'undefined') {
            prevSum = prevSum.total;

            if (typeof prevSum !== 'undefined') {
              if (parseFloat(prevSum) !== parseFloat(v.total)) {
                f = true;
              }
            }
          }
        }

        var prevText = '';

        if (f) {
          prevText = ' <span style="color:#ff0000;">(Было ' + prevSum + '€) </span>';
        }

        var $newLine = ' <tr data-id="' + k + '">\n' + '                                                <th scope="row">' + k + '</th>\n' + '                                                <td>' + v.name + '</td>\n' + '                                                <td>' + v.total + ' € ' + prevText + '</td>\n' + '                                            </tr>';
        $tableStock.append($newLine);
        total += parseFloat(v.total);
      }
    });
    $tableStock.find('.table-info').appendTo($tableStock);
    $('#summaryStock').text(total.toFixed(2) + '€');
  }

  function generateWasteTable(data) {
    return new Promise(function (resolve) {
      var $tbody = $tableWaste,
          tCatalogList = [],
          catalogList = [];
      $.each(data, function (k, v) {
        catalogList.push(v.id);
      });
      $.each($tbody.find('tr').not('.table-info'), function (k, v) {
        if (catalogList.indexOf($(v).data('id')) !== -1) {
          tCatalogList.push(parseInt($(v).data('id')));
        } else {
          $(v).remove();
        }
      });
      $.each(data, function (k, v) {
        if (k !== 'error') {
          if (tCatalogList.indexOf(v.id) === -1) {
            var $newLine = ' <tr data-id="' + v.id + '">\n' + '                                                <td>' + v.name + '</td>\n' + '                                                <td><input type="number" class="form-control sum-wastes" id="' + v.id + '-sum" name="wastes_sum[' + v.id + ']" value="' + parseFloat(v.sum).toFixed(2) + '"></td>\n' + '                                            </tr>';
            $tableWaste.append($newLine);
          }
        }
      });
      $tableWaste.find('.table-info').appendTo($tableWaste);
      resolve(true);
    });
  }

  $tableWaste.on('change', '.sum-wastes', calcWastes);
  $tableWaste.on('change', '.sum-wastes', calcTotal);
  $wasteTypes.on('select2:unselect', function () {
    setTimeout(calcWastes, 500);
  });
  $wasteTypes.on('select2:unselect', function () {
    setTimeout(calcTotal, 502);
  });

  function calcWastes() {
    var total = 0;
    $(".sum-wastes").each(function () {
      var input = $(this); // This is the jquery object of the input, do what you will

      total += parseFloat(input.val());
    });
    $('#summaryWastes').text(total.toFixed(2) + '€');
  }

  function calcTotal() {
    var valueWastes = parseFloat($('#summaryWastes').text()),
        valueLots = parseFloat($('#summaryStock').text());
    var sum = valueWastes + valueLots;
    $('#summaryTotal').val(sum.toFixed(2) + '€');
  }

  $dateFinish.on('change', function () {
    $stocks.val(null).trigger('change');
  });
  $userId.on('change', function () {
    $stocks.val(null).trigger('change');
  });
  $dateStart.on('change', function () {
    $stocks.val(null).trigger('change');
  });
  $('#form').parsley();
  $stocks.trigger('change');
  $wasteTypes.trigger('change');
});

/***/ }),

/***/ 68:
/*!*********************************************************!*\
  !*** multi ./resources/js/pages/purchaseReport.init.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! g:\OpenServer\domains\newcrm\resources\js\pages\purchaseReport.init.js */"./resources/js/pages/purchaseReport.init.js");


/***/ })

/******/ });