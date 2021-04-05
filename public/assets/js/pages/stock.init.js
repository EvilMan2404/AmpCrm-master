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
/******/ 	return __webpack_require__(__webpack_require__.s = 58);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/pages/stock.init.js":
/*!******************************************!*\
  !*** ./resources/js/pages/stock.init.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $('#form').parsley();
  var $user_id = $('#user_id'),
      $searchName = $('#searchName'),
      $searchDate = $('#searchDate'),
      $searchOwner = $('#searchOwner'),
      $purchases = $('#purchases'),
      $owner = $('#owner input[type="radio"]'),
      $valueOwner = $('#owner input[type="radio"]:checked'),
      purchases = '',
      token = $('meta[name="csrf-token"]').attr('content');
  $user_id.select2({
    ajax: {
      url: $valueOwner.data('route'),
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
        return $user_id.data('start');
      },
      searching: function searching() {
        return $user_id.data('searching');
      },
      noResults: function noResults() {
        return $user_id.data('noResults');
      }
    }
  });
  $('#owner input[type=radio]').change(function () {
    $user_id.val(null);
    $user_id.find('option').remove();
    $user_id.select2({
      ajax: {
        url: $(this).data('route'),
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
      placeholder: $user_id.data('placeholder'),
      language: {
        // You can find all of the options in the language files provided in the
        // build. They all must be functions that return the string that should be
        // displayed.
        inputTooShort: function inputTooShort() {
          return $user_id.data('start');
        },
        searching: function searching() {
          return $user_id.data('searching');
        },
        noResults: function noResults() {
          return $user_id.data('noResults');
        }
      }
    });
  });
  $purchases.select2({
    ajax: {
      url: $purchases.data('url'),
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
    placeholder: $purchases.data('placeholder'),
    language: {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      inputTooShort: function inputTooShort() {
        return $purchases.data('start');
      },
      searching: function searching() {
        return $purchases.data('searching');
      },
      noResults: function noResults() {
        return $purchases.data('noResults');
      }
    }
  });
  $searchDate.select2({
    ajax: {
      url: $searchDate.data('url'),
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
    placeholder: $searchDate.data('placeholder'),
    language: {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      inputTooShort: function inputTooShort() {
        return $searchDate.data('start');
      },
      searching: function searching() {
        return $searchDate.data('searching');
      },
      noResults: function noResults() {
        return $searchDate.data('noResults');
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
  $searchOwner.select2({
    ajax: {
      url: $searchOwner.data('url'),
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
    placeholder: $searchOwner.data('placeholder'),
    language: {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      inputTooShort: function inputTooShort() {
        return $searchOwner.data('start');
      },
      searching: function searching() {
        return $searchOwner.data('searching');
      },
      noResults: function noResults() {
        return $searchOwner.data('noResults');
      }
    }
  });
  $searchOwner.change(function () {
    $('#form').submit();
  });
  $searchDate.change(function () {
    $('#form').submit();
  });
  $purchases.on('change', function () {
    $.ajax({
      'url': $purchases.data('info'),
      'method': 'POST',
      'data': {
        "purchases": $purchases.val()
      },
      'dataType': 'json',
      'success': function success(data) {
        purchases = data;
        updateForm().then(function () {
          $('.ceramic-input').trigger("change");
        });
      }
    });
  });
  $('body').on('change', '.ceramic-input', updateDiff);

  function updateDiff() {
    var $this = $(this),
        $type = $this.data('m'),
        $value = parseFloat($this.val()),
        $allowed = ['pt', 'pd', 'rh'],
        $result = 0;

    if ($allowed.indexOf($type) !== -1) {
      var $subject = 0,
          $target = $('#' + $type + '_diff'),
          $purch = $('#' + $type + '_purchase');
      $subject = getTotalInput('ceramic-input', $type);
      $result = $subject - parseFloat($purch.val());
      $target.val($result.toFixed(3));
    }
  }

  function getTotalInput($class, $type) {
    var $get = $('.' + $class + '[data-m="' + $type + '"]'),
        $total = 0;
    $.each($get, function (k, v) {
      var input = $(v);
      $total += parseFloat(input.val());
    });
    console.log($total);
    return $total;
  }

  function updateForm() {
    return new Promise(function (resolve) {
      var _weight_purchase, _catalyst_purchase, _pt_purchase, _pd_purchase, _rh_purchase;

      var pt_purchase = 0,
          pd_purchase = 0,
          rh_purchase = 0,
          weight_purchase = 0,
          catalyst_purchase = 0,
          pt_rate = 0,
          pd_rate = 0,
          rh_rate = 0,
          i = 0,
          $tablePurchase = $('#purchase-body');
      $tablePurchase.find('tr').not('.table-info').remove();
      $.each(purchases, function (k, v) {
        if (k !== 'error') {
          pt_purchase += parseFloat(v.pt) * parseFloat(v.count);
          pd_purchase += parseFloat(v.pd) * parseFloat(v.count);
          rh_purchase += parseFloat(v.rh) * parseFloat(v.count);
          weight_purchase += parseFloat(v.weight) * parseFloat(v.count);
          catalyst_purchase += parseInt(v.count);
          /* Purchase table */

          var $newLine = ' <tr data-id="' + v.id + '">\n' + '                                                <th scope="row">' + v.id + '</th>\n' + '                                                <td>' + v.name + '</td>\n' + '                                                <td>' + v.ownerName + '</td>\n' + '                                                <td>' + v.pt + '</td>\n' + '                                                <td>' + v.pd + '</td>\n' + '                                                <td>' + v.rh + '</td>\n' + '                                                <td>' + v.lot.pt_rate + '</td>\n' + '                                                <td>' + v.lot.pd_rate + '</td>\n' + '                                                <td>' + v.lot.rh_rate + '</td>\n' + '                                                <td>' + v.total + ' € </td>\n' + '                                            </tr>';
          $tablePurchase.append($newLine);
          pt_rate = parseFloat(pt_rate) + parseFloat(v.lot.pt_rate);
          pd_rate = parseFloat(pd_rate) + parseFloat(v.lot.pd_rate);
          rh_rate = parseFloat(rh_rate) + parseFloat(v.lot.rh_rate);
          /* Purchase table end */

          i++;
        }
      });

      if (i !== 0) {
        pt_rate /= i;
        pd_rate /= i;
        rh_rate /= i;
      }

      $tablePurchase.find('.table-info').appendTo($tablePurchase);
      $('#pt-rate').text(pt_rate);
      $('#pd-rate').text(pd_rate);
      $('#rh-rate').text(rh_rate);

      if (isNaN(weight_purchase) || weight_purchase < 0) {
        weight_purchase = 0;
      }

      if (isNaN(catalyst_purchase) || catalyst_purchase < 0) {
        catalyst_purchase = 0;
      }

      if (isNaN(pt_purchase) || pt_purchase < 0) {
        pt_purchase = 0;
      }

      if (isNaN(pd_purchase) || pd_purchase < 0) {
        pd_purchase = 0;
      }

      if (isNaN(rh_purchase) || rh_purchase < 0) {
        rh_purchase = 0;
      }

      $('#ceramic').val((_weight_purchase = weight_purchase) !== null && _weight_purchase !== void 0 ? _weight_purchase : 0);
      $('#catalyst').val((_catalyst_purchase = catalyst_purchase) !== null && _catalyst_purchase !== void 0 ? _catalyst_purchase : 0);
      $('#pt_purchase').val((_pt_purchase = pt_purchase) !== null && _pt_purchase !== void 0 ? _pt_purchase : 0);
      $('#pd_purchase').val((_pd_purchase = pd_purchase) !== null && _pd_purchase !== void 0 ? _pd_purchase : 0);
      $('#rh_purchase').val((_rh_purchase = rh_purchase) !== null && _rh_purchase !== void 0 ? _rh_purchase : 0);
      resolve(true);
    });
  }

  var $tableCeramic = $('#ceramic-body'),
      $tableDust = $('#dust-body');

  function addNewAnalysis() {
    var i = $tableCeramic.find('tr').length;

    if ($tableCeramic.find('tr[data-id=' + i + ']').length) {
      i += 1;
    }

    var $newLine = ' <tr data-id="' + i + '">\n' + '                                                <th scope="row"><button type="button" id="deleteRow" class="btn btn-primary deleteRow" data-row="' + i + '">X</button></th>\n' + '                                                <td><input class="form-control ceramic-input" data-parsley-type="number" data-type="ceramic" data-m="pt" type="text" name="ceramic_analysis[' + i + '][pt]"></td>\n' + '                                                <td><input class="form-control ceramic-input" data-parsley-type="number" data-type="ceramic" data-m="pd" type="text" name="ceramic_analysis[' + i + '][pd]"></td>\n' + '                                                <td><input class="form-control ceramic-input" data-parsley-type="number" data-type="ceramic" data-m="rh" type="text" name="ceramic_analysis[' + i + '][rh]"></td>\n' + '                                            </tr>';
    $tableCeramic.append($newLine);
    $tableCeramic.find('.table-info').appendTo($tableCeramic);
    var $newLineNew = ' <tr data-id="' + i + '">\n' + '                                                <th scope="row"><button type="button" id="deleteRow" class="btn btn-primary deleteRow" data-row="' + i + '">X</button></th>\n' + '                                                <td><input data-type="dust" data-m="pt" data-parsley-type="number" class="form-control dust-input" type="text" name="dust_analysis[' + i + '][pt]"></td>\n' + '                                                <td><input data-type="dust" data-m="pd" data-parsley-type="number" class="form-control dust-input" type="text" name="dust_analysis[' + i + '][pd]"></td>\n' + '                                                <td><input data-type="dust"  data-m="rh" data-parsley-type="number" class="form-control dust-input" type="text" name="dust_analysis[' + i + '][rh]"></td>\n' + '                                            </tr>';
    $tableDust.append($newLineNew);
    $tableDust.find('.table-info').appendTo($tableDust);
  }

  $('#addNewAnalysis').on('click', function () {
    addNewAnalysis();
  });
  $('body').on('click', '.deleteRow', function () {
    $tableCeramic.find('tr[data-id="' + $(this).data('row') + '"]').remove();
    $tableDust.find('tr[data-id="' + $(this).data('row') + '"]').remove();
    $('.total_calc').text(0);
    $('.dust-input,.ceramic-input').trigger('change');
  });
  $('body').on('change', '.dust-input,.ceramic-input', function () {
    var $this = $(this),
        $type = $this.data('type');

    if ($type === 'dust') {
      var $m = $this.data('m'),
          $s = 0,
          $i = 0;
      $.each($tableDust.find('tr').not('.table-info'), function (k, v) {
        var value = $(v).data('id'),
            $new = $('input[name="dust_analysis[' + value + '][' + $m + ']"]').val();

        if (typeof $new === 'undefined') {
          $new = 0;
        }

        $s += parseFloat($new);
        $i++;
      });
      $s /= $i;
      $s = parseFloat($s).toFixed(3);
      $('#dust-' + $m + '-rate').text($s);
    } else {
      var _$m = $this.data('m'),
          _$s = 0,
          _$i = 0;

      $.each($tableCeramic.find('tr').not('.table-info'), function (k, v) {
        var value = $(v).data('id'),
            $new = $('input[name="ceramic_analysis[' + value + '][' + _$m + ']"]').val();

        if (typeof $new === 'undefined') {
          $new = 0;
        }

        _$s += parseFloat($new);
        _$i++;
      });
      _$s /= _$i;
      _$s = parseFloat(_$s).toFixed(3);
      $('#ceramic-' + _$m + '-rate').text(_$s);
    }
  });
  $('.dust-input,.ceramic-input').trigger('change');
  $purchases.trigger('change');
});

/***/ }),

/***/ 58:
/*!************************************************!*\
  !*** multi ./resources/js/pages/stock.init.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! g:\OpenServer\domains\newcrm\resources\js\pages\stock.init.js */"./resources/js/pages/stock.init.js");


/***/ })

/******/ });