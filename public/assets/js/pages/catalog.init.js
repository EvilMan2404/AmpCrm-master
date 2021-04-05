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
/******/ 	return __webpack_require__(__webpack_require__.s = 55);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/pages/catalog.init.js":
/*!********************************************!*\
  !*** ./resources/js/pages/catalog.init.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  var $search = $('#search_for_catalog'),
      $lots = $('#lots'),
      token = $('meta[name="csrf-token"]').attr('content'),
      $searchBrand = $('#search_brand_id'),
      $searchCatalogs = $('#id_catalog'),
      $showModal = $('#show_modal'),
      cart = [];

  if ($showModal.data('value') === true) {
    $('#course-settings').modal('show');
  }

  function loadCart() {
    var localCart = JSON.parse(localStorage.getItem('cart'));

    if (localCart !== null && localCart.length > 0) {
      cart = localCart;
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

    console.log(cart);
    localStorage.setItem('cart', JSON.stringify(cart));
  });
  $('.cart-save').on('click', function (e) {
    e.preventDefault();
    var $this = $(this),
        url = $this.data('url');
    localStorage.setItem('cart', null);
    window.document.location.href = url + '?categories_id=' + cart.join(',') + '&lot_id=' + $lots.val();
  }); //----------------------------------//

  $('[data-toggle="select2"]').select2({
    "width": '100%'
  });
  $lots.select2({
    ajax: {
      url: $lots.data('url'),
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
    placeholder: $lots.data('placeholder'),
    language: {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      inputTooShort: function inputTooShort() {
        return $lots.data('start');
      },
      searching: function searching() {
        return $lots.data('searching');
      },
      noResults: function noResults() {
        return $lots.data('noResults');
      }
    }
  });
  $searchCatalogs.select2({
    ajax: {
      url: $searchCatalogs.data('url'),
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
    placeholder: $searchCatalogs.data('placeholder'),
    language: {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      inputTooShort: function inputTooShort() {
        return $searchCatalogs.data('start');
      },
      searching: function searching() {
        return $searchCatalogs.data('searching');
      },
      noResults: function noResults() {
        return $searchCatalogs.data('noResults');
      }
    }
  });
  $search.select2({
    "ajax": {
      url: $search.data('url'),
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
    "placeholder": $search.data('placeholder'),
    "width": '100%',
    'language': {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      inputTooShort: function inputTooShort() {
        return $search.data('start');
      },
      searching: function searching() {
        return $search.data('searching');
      },
      noResults: function noResults() {
        return $search.data('noResults');
      }
    }
  });
  $search.on('change', function (e) {
    $('#form').submit();
  });
  $searchCatalogs.on('change', function (e) {
    $('#form-global').submit();
  });
  $searchBrand.on('change', function (e) {
    $('#form').submit();
  });
  $lots.on('change', function (e) {
    $('#form').submit();
  });
  $('#buttonSubmit').click(function () {
    $('#form').submit();
  });
  $('#form,#course-form').parsley();
  $(function () {
    $('#form,#course-form').parsley().on('field:validated', function () {
      var ok = $('.parsley-error').length === 0;
      $('.alert-info').toggleClass('d-none', !ok);
      $('.alert-warning').toggleClass('d-none', ok);
    });
  });
});
var drEvent = $('.dropify').dropify({
  tpl: {
    wrap: '<div class="dropify-wrapper"></div>',
    loader: '<div class="dropify-loader"></div>',
    message: '<div class="dropify-message"><span class="file-icon" /> <p>{{ default }}</p></div>',
    preview: '<div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-infos-message"></p></div></div></div>',
    filename: '<p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p>',
    clearButton: '<button type="button" class="dropify-clear">{{ remove }}</button>',
    errorLine: '<p class="dropify-error">{{ error }}</p>',
    errorsContainer: '<div class="dropify-errors-container"><ul></ul></div>'
  }
});
drEvent.on('dropify.afterClear', function (event, element) {
  $.ajax({
    'url': '/catalog/removeImage/' + element.settings.objId + '/' + element.settings.dropifyId,
    'method': 'POST',
    'success': function success() {
      var $form = $('#listImages'),
          val = $form.val(),
          list = [],
          newList = [];

      if (val !== '') {
        list = val.split(',');
      }

      $.each(list, function (k, v) {
        if (element.settings.dropifyId !== parseInt(v)) {
          newList.push(v);
        }
      });
      $form.val(newList.join(','));
      $('[data-dropify-id=' + element.settings.dropifyId + ']').parent().remove();
    }
  });
});
Dropzone.options.myAwesomeDropzone = {
  maxFilesize: 10,
  acceptedFiles: ".jpeg,.jpg,.png,.gif",
  // addRemoveLinks: true,
  timeout: 60000,
  sending: function sending(file, xhr, formData) {
    formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
  },
  success: function success(file, response) {
    var $image = $('#listImages'),
        v = $image.val(),
        val = [];

    if (v !== '') {
      val = v.split(',');
    }

    if (response.status) {
      val.push(response.id);
    } else {
      alert(response.error);
    }

    $image.val(val.join(','));
  },
  error: function error(file, response) {
    alert('Error load file');
  }
};

/***/ }),

/***/ 55:
/*!**************************************************!*\
  !*** multi ./resources/js/pages/catalog.init.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! g:\OpenServer\domains\newcrm\resources\js\pages\catalog.init.js */"./resources/js/pages/catalog.init.js");


/***/ })

/******/ });