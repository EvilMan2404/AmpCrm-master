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
/******/ 	return __webpack_require__(__webpack_require__.s = 64);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/pages/tasks.init.js":
/*!******************************************!*\
  !*** ./resources/js/pages/tasks.init.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  var $statuses = $('#status_id'),
      $assigned_user_id = $('#assigned_user_id'),
      $modelTypeList = $('#source'),
      $source_id = $('#source_id'),
      $priority_id = $('#priority_id'),
      $source = $modelTypeList.children("option:selected").val(),
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
  $statuses.select2({
    "placeholder": $statuses.data('placeholder'),
    "width": '100%'
  });
  $priority_id.select2({
    "placeholder": $priority_id.data('placeholder'),
    "width": '100%'
  });
  $modelTypeList.select2({
    "placeholder": $modelTypeList.data('placeholder'),
    "width": '100%'
  });
  initializeSourceId('empty');
  $modelTypeList.change(function () {
    $source_id.val(null);
    $source_id.data("placeholder", $source_id.data('searching'));
    initializeSourceId();
  });

  if ($source !== '') {
    initializeSourceId();
  }

  function initializeSourceId() {
    var $status = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'withValue';

    if ($status === 'empty') {
      $source_id.select2({
        "placeholder": $source_id.data('placeholder'),
        "width": '100%'
      });
    } else {
      var _$source = $modelTypeList.children("option:selected").val();

      $source_id.select2({
        ajax: {
          url: $source_id.data('url'),
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
              source: _$source
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
        placeholder: $source_id.data('searching'),
        language: {
          // You can find all of the options in the language files provided in the
          // build. They all must be functions that return the string that should be
          // displayed.
          inputTooShort: function inputTooShort() {
            return $source_id.data('start');
          },
          searching: function searching() {
            return $source_id.data('searching');
          },
          noResults: function noResults() {
            return $source_id.data('noResults');
          }
        }
      });
    }
  }

  $('#buttonSubmit').click(function () {
    $('#form').submit();
  });
  $('#form').parsley();
  $(function () {
    $('#form').parsley().on('field:validated', function () {
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
    'url': '/tasks/removeFile/' + element.settings.objId + '/' + element.settings.dropifyId,
    'method': 'POST',
    'success': function success() {
      var $form = $('#listFiles'),
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
  acceptedFiles: ".jpeg,.jpg,.png,.gif,.docx,.doc",
  // addRemoveLinks: true,
  timeout: 60000,
  sending: function sending(file, xhr, formData) {
    formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
  },
  success: function success(file, response) {
    var $image = $('#listFiles'),
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

/***/ 64:
/*!************************************************!*\
  !*** multi ./resources/js/pages/tasks.init.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! g:\OpenServer\domains\newcrm\resources\js\pages\tasks.init.js */"./resources/js/pages/tasks.init.js");


/***/ })

/******/ });