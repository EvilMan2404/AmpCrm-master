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
/******/ 	return __webpack_require__(__webpack_require__.s = 56);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/pages/purchase.init.js":
/*!*********************************************!*\
  !*** ./resources/js/pages/purchase.init.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  var $categories = $('#categories'),
      $status = $('#status'),
      $type_payment = $('#type_payment'),
      token = $('meta[name="csrf-token"]').attr('content'),
      $catalogTable = $('#table_catalog'),
      $clients = $('#client_id'),
      $userPaid = $('#user_paid'),
      $lots = $('#lots'),
      $searchStatus = $('#searchStatus'),
      $searchName = $('#searchName'),
      $searchOwner = $('#searchOwner'),
      $translation = $('.translation'),
      cart = [],
      categories = [],
      lot = {
    "pt": 0,
    "pd": 0,
    "rh": 0
  },
      select2AjaxInit = [$clients, $userPaid, $searchOwner, $searchName, $categories, $lots];

  function loadCart() {
    var localCart = JSON.parse(localStorage.getItem('purchases'));

    if (localCart !== null && localCart.length > 0) {
      $('.cart-save').show();
      cart = localCart;
    } else {
      $('.cart-save').hide();
    }

    $.each(cart, function (k, v) {
      $('#check-' + v).prop('checked', true);
    });
  }

  loadCart();
  $('.cart-check').on('change', function (e) {
    var $this = $(this),
        id = parseInt($this.data('id'));

    if ($this.is(":checked") && id > 0 && cart.indexOf(id) === -1) {
      cart.push(id);
    } else {
      var index = cart.indexOf(id);

      if (index !== -1) {
        cart.splice(index, 1);
      }
    }

    if (cart.length > 0) {
      $('.cart-save').show();
    } else {
      $('.cart-save').hide();
    }

    console.log(cart);
    localStorage.setItem('purchases', JSON.stringify(cart));
  });
  $('.cart-save').on('click', function (e) {
    e.preventDefault();
    var $this = $(this),
        url = $this.data('url');
    localStorage.setItem('purchases', null);
    window.document.location.href = url + '?purchases=' + cart.join(',');
  });
  $('#clearFilters').on('click', function () {
    localStorage.setItem('purchases', null);
  }); //----------------------------------//

  $status.select2({
    "placeholder": $status.data('placeholder'),
    "width": '100%'
  });
  $searchStatus.select2({
    "placeholder": $status.data('placeholder'),
    "width": '100%'
  });
  $type_payment.select2({
    "placeholder": $type_payment.data('placeholder'),
    "width": '100%'
  });
  $.each(select2AjaxInit, function (k, v) {
    v.select2({
      ajax: {
        url: v.data('url'),
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
      placeholder: v.data('placeholder'),
      language: {
        // You can find all of the options in the language files provided in the
        // build. They all must be functions that return the string that should be
        // displayed.
        inputTooShort: function inputTooShort() {
          return v.data('start');
        },
        searching: function searching() {
          return v.data('searching');
        },
        noResults: function noResults() {
          return v.data('noResults');
        }
      }
    });
  });

  function renderCatalogList() {
    var $tbody = $catalogTable.find('tbody'),
        tCatalogList = [],
        catalogList = [];
    $.each(categories, function (k, v) {
      catalogList.push(v.id);
    });
    $.each($tbody.find('tr'), function (k, v) {
      if (catalogList.indexOf($(v).data('id')) !== -1) {
        tCatalogList.push(parseInt($(v).data('id')));
      } else {
        $(v).remove();
      }
    });
    $.each(categories, function (k, v) {
      if (tCatalogList.indexOf(v.id) === -1) {
        $tbody.append('<tr data-id="' + v.id + '">' + '<td data-tag="name"></td>' + '<td data-tag="price"></td>  ' + '<td data-tag="count"><input class="form-control catalog_count" type="number" value="1" name="cat[' + v.id + '][count]"></td>  ' + '<td data-tag="form">' + '<div><input class="form-control discount_value" type="text" value="100" name="cat[' + v.id + '][discount]"></div>' + //discount
        '<div class="mt-1 ml-1">' + // radio group
        '<div class="radio radio-info form-check-inline">' + //radio 1
        '<input class="discount_type" type="radio" id="cat[' + v.id + '][discount_type_percent]" value="percent" name="cat[' + v.id + '][discount_type]" checked="">\n' + '<label for="cat[' + v.id + '][discount_type_percent]"> ' + $translation.data('percent') + ' </label>\n' + '</div>' + //radio 2
        '<div class="radio radio-info form-check-inline">' + '<input class="discount_type" type="radio" id="cat[' + v.id + '][discount_type_money]" value="money" name="cat[' + v.id + '][discount_type]">\n' + '<label for="cat[' + v.id + '][discount_type_money]"> ' + $translation.data('price') + ' </label>\n' + '</div>' + '</div>' + //radio group end
        '</td>  ' + '</tr>');
      }

      $tbody.find('[data-id=' + v.id + '] > [data-tag=name]').text(v.name);
      $tbody.find('[data-id=' + v.id + '] > [data-tag=price]').text(v.price.toFixed(3));
    });
  }

  function calcInCatalog() {
    return new Promise(function (resolve) {
      var $table = $('#table'),
          dPt = parseFloat($table.data('discountPt')),
          dPd = parseFloat($table.data('discountPd')),
          dRh = parseFloat($table.data('discountRh'));
      $.each(categories, function (k, v) {
        //custom price
        var $item = $('tr[data-id=' + v.id + ']'),
            count = parseInt($item.find('.catalog_count').val()),
            discount = parseFloat($item.find('.discount_value').val()),
            discountType = $item.find('.discount_type:checked').val();

        if (isNaN(count) || count < 0) {
          count = 1;
        }

        if (isNaN(discount) || discount <= 0) {
          discount = 100;
        }

        v.price = (parseFloat(v.weight) * parseFloat(v.pt) * 10 * parseFloat(lot.pt_rate) * count * (dPt / 100) + parseFloat(v.weight) * parseFloat(v.pd) * 10 * parseFloat(lot.pd_rate) * count * (dPd / 100) + parseFloat(v.weight) * parseFloat(v.rh) * 10 * parseFloat(lot.rh_rate) * count * (dRh / 100)) * (discount / 100);

        if (discountType === 'money') {
          v.price = discount * count;
        }

        if (isNaN(v.price)) {
          v.price = 0;
        }

        categories[k] = v;
      });
      resolve(true);
    });
  }

  function calc() {
    if (Object.keys(lot).length > 3 && categories.length > 0) {
      renderCatalogList();
      var $table = $('#table'),
          dPurchase = $table.data('discountPurchase'),
          pt = 0,
          pd = 0,
          rh = 0,
          wgKg = 0,
          total = 0;
      $.each(categories, function (k, v) {
        pt += parseFloat(v.pt);
        pd += parseFloat(v.pd);
        rh += parseFloat(v.rh);
        wgKg += parseFloat(v.weight);
        total += v.price;
      });
      total *= parseFloat(dPurchase) / 100;
      $('.pt_calc').text(pt.toFixed(3));
      $('.pd_calc').text(pd.toFixed(3));
      $('.rh_calc').text(rh.toFixed(3));
      $('.wgkg_calc').text(wgKg.toFixed(3));
      $('.total_calc').text(total.toFixed(3));
    }
  }

  $categories.on('change', function () {
    $.ajax({
      'url': $categories.data('info'),
      'method': 'POST',
      'data': {
        "categories": $categories.val()
      },
      'dataType': 'json',
      'success': function success(data) {
        categories = data;
        $lots.trigger('change');
        calcInCatalog().then(function () {
          calc();
        });
      }
    });
  });
  $lots.change(function () {
    $.ajax({
      'url': $lots.data('info'),
      'method': 'POST',
      'data': {
        "lot": $lots.val()
      },
      'dataType': 'json',
      'success': function success(data) {
        lot = data;
        calcInCatalog().then(function () {
          calc();
        });
      }
    });
  });
  $catalogTable.on('change', '.discount_value, .discount_type, .catalog_count', function () {
    calcInCatalog().then(function () {
      calc();
    });
  });
  $('#buttonSubmit').click(function () {
    $('#form').submit();
  });
  $searchName.change(function () {
    $('#form').submit();
  });
  $searchStatus.change(function () {
    $('#form').submit();
  });
  $searchOwner.change(function () {
    $('#form').submit();
  });
  $('#form').parsley();
  $categories.trigger('change');
  $lots.trigger('change');
});

/***/ }),

/***/ 56:
/*!***************************************************!*\
  !*** multi ./resources/js/pages/purchase.init.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! g:\OpenServer\domains\newcrm\resources\js\pages\purchase.init.js */"./resources/js/pages/purchase.init.js");


/***/ })

/******/ });