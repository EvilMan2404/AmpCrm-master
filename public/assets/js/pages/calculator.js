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
/******/ 	return __webpack_require__(__webpack_require__.s = 59);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/pages/calculator.js":
/*!******************************************!*\
  !*** ./resources/js/pages/calculator.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

/*

-> Design credit goes to Jaroslav Getman
-> https://dribbble.com/shots/2334270-004-Calculator

Calculator 2.0

This is the second iteration of this calculator, built with Vue and Vuex. You can find the code for this new version of the calculator and the old calculator here.

github.com/anthonykoch/calculator

TODO:
1. Make buttons show keypress when a keybind is pressed

FIXME:
1. Fix error where Expressions = ['(', '5', '*', '3', ')'] and mode is APPEND after ")". It should be insert
2. Even though pressing delete causes mutation CLEAR_ENTRY to fire, changing the state does nothing until a button has been pressed. Not sure if this is a problem with Vuex or the way I'm doing it.

*/
function main() {
  'use strict';

  var $ = document.querySelector.bind(document);
  var $app = $('.js-app');
  var templates = {
    calculatorButton: $("[data-template=\"calculatorbutton\"]").innerHTML
  };
  var ACTION_CLEAR = 'clear';
  var ACTION_CLEAR_ENTRY = 'clearEntry';
  var ACTION_NEGATE = 'negate';
  var ACTION_UPDATE_OPERATOR = 'updateOperator';
  var ACTION_APPEND_OPERAND = 'appendOperand';
  var ACTION_ADD_PAREN = 'addParen';
  var ACTION_BACKSPACE = 'backspace';
  var ACTION_SHOW_TOTAL = 'showTotal';
  var buttons = [{
    text: 'C',
    className: 'clear',
    action: ACTION_CLEAR
  }, {
    text: '+/-',
    className: 'negation',
    action: ACTION_NEGATE
  }, {
    text: '%',
    className: 'modulo',
    action: ACTION_UPDATE_OPERATOR,
    payload: {
      operator: '%'
    }
  }, {
    text: '√',
    className: 'square',
    action: ACTION_UPDATE_OPERATOR,
    payload: {
      operator: 'yroot'
    }
  }, {
    text: '7',
    action: ACTION_APPEND_OPERAND,
    payload: {
      value: '7'
    }
  }, {
    text: '8',
    action: ACTION_APPEND_OPERAND,
    payload: {
      value: '8'
    }
  }, {
    text: '9',
    action: ACTION_APPEND_OPERAND,
    payload: {
      value: '9'
    }
  }, {
    text: '/',
    className: 'division',
    action: ACTION_UPDATE_OPERATOR,
    payload: {
      operator: '/'
    }
  }, {
    text: '4',
    action: ACTION_APPEND_OPERAND,
    payload: {
      value: '4'
    }
  }, {
    text: '5',
    action: ACTION_APPEND_OPERAND,
    payload: {
      value: '5'
    }
  }, {
    text: '6',
    action: ACTION_APPEND_OPERAND,
    payload: {
      value: '6'
    }
  }, {
    text: '',
    className: 'multiplication',
    icon: 'ion-ios-close-empty',
    action: ACTION_UPDATE_OPERATOR,
    payload: {
      operator: '*'
    }
  }, {
    text: '1',
    action: ACTION_APPEND_OPERAND,
    payload: {
      value: '1'
    }
  }, {
    text: '2',
    action: ACTION_APPEND_OPERAND,
    payload: {
      value: '2'
    }
  }, {
    text: '3',
    action: ACTION_APPEND_OPERAND,
    payload: {
      value: '3'
    }
  }, {
    text: '',
    className: 'subtraction',
    icon: 'ion-ios-minus-empty',
    action: ACTION_UPDATE_OPERATOR,
    payload: {
      operator: '-'
    }
  }, {
    text: '0',
    action: ACTION_APPEND_OPERAND,
    payload: {
      value: '0'
    }
  }, {
    className: 'paren',
    children: [{
      text: '(',
      className: 'open-paren',
      action: ACTION_ADD_PAREN,
      payload: {
        operator: '('
      }
    }, {
      text: ')',
      className: 'close-paren',
      action: ACTION_ADD_PAREN,
      payload: {
        operator: ')'
      }
    }]
  }, {
    text: '.',
    action: ACTION_APPEND_OPERAND,
    payload: {
      value: '.'
    }
  }, {
    text: '',
    className: 'addition',
    icon: 'ion-ios-plus-empty',
    action: ACTION_UPDATE_OPERATOR,
    payload: {
      operator: '+'
    }
  }]; // Mode show total causes the total to be displayed in the current operand display

  var MODE_SHOW_TOTAL = 1 << 1; // Mode insert operand causes the current operand to be overwritten. After the first character has been written, the mode should go to mode append operand

  var MODE_INSERT_OPERAND = 1 << 2; // Mode append operand causes any operand parts to be appended to the current operand

  var MODE_APPEND_OPERAND = 1 << 3; // The maximum number of digits the current operand may be

  var MAX_NUMBER_LENGTH = Number.MAX_SAFE_INTEGER.toString().length;
  var initialState = {
    activeButtons: [],
    buttons: buttons,
    expressions: [],
    currentOperand: '',
    currentOperator: '',
    mode: MODE_SHOW_TOTAL | MODE_INSERT_OPERAND,
    openParenStack: 0,
    error: null,
    total: 0
  };
  var mutations = {
    CLEAR: function CLEAR(state) {
      state.expressions = [];
      state.currentOperand = '0';
      state.currentOperator = '';
      state.openParenStack = 0;
      state.mode = MODE_SHOW_TOTAL | MODE_INSERT_OPERAND;
      state.error = null;
      state.total = 0;
    },
    BACKSPACE: function BACKSPACE(state) {
      var operand = state.currentOperand.slice(0, -1);

      if (operand.length === 0) {
        operand = '0';
      }

      state.currentOperand = operand;
    },
    CLEAR_ENTRY: function CLEAR_ENTRY(state) {
      state.currentOperand = '0';
    },
    NEGATE: function NEGATE(state) {
      // Only add negative sign if not zero
      if (state.currentOperand !== 0) {
        state.currentOperand = (-state.currentOperand).toString();
      }
    },
    UPDATE_OPERATOR: function UPDATE_OPERATOR(state, _ref) {
      var operator = _ref.operator;
      var length = state.expressions.length;
      var last = state.expressions[length - 1] || '';
      var mode = state.mode,
          currentOperand = state.currentOperand;

      if (mode & MODE_INSERT_OPERAND) {
        console.log('MODE_INSERT_OPERAND');

        if (length === 0) {
          state.expressions.push(currentOperand, operator);
        } else if (isOperator(last)) {
          // console.log('isoplast');                            // APPEND_OP LOG
          state.expressions.pop();
          state.expressions.push(operator);
        } else if (last === ')') {
          // console.log('nope');                                // APPEND_OP LOG
          state.expressions.push(operator);
        } else if (last === '(') {
          state.expressions.push(currentOperand, operator);
        } else {// console.log('else');                                // APPEND_OP LOG
        }
      } else if (mode & MODE_APPEND_OPERAND) {
        console.log('MODE_APPEND_OPERAND');

        if (length === 0) {
          console.log('length 0'); // APPEND_OP LOG

          state.expressions.push(currentOperand, operator);
        } else if (isOperator(last)) {
          // console.log('isOperator(last)');                    // APPEND_OP LOG
          state.expressions.push(currentOperand, operator);
        } else if (last === ')') {
          // console.log('last === )');                          // APPEND_OP LOG
          state.expressions.push(operator);
        } else if (last === '(') {
          // console.log('last === (');                          // APPEND_OP LOG
          state.expressions.push(currentOperand, operator);
        } else {// console.log('else');
          // state.expressions.push(operator, currentOperand);
        }
      }

      state.currentOperator = operator;
      state.mode = MODE_INSERT_OPERAND | MODE_SHOW_TOTAL;
      console.log('UPDATE_OPERATOR:', state.expressions);
    },
    ADD_PAREN: function ADD_PAREN(state, _ref2) {
      var operator = _ref2.operator;
      var last = state.expressions[state.expressions.length - 1] || '';
      var currentOperand = state.currentOperand,
          openParenStack = state.openParenStack; // console.log('ADD_PAREN:', {last, operator});

      if (operator === ')' && openParenStack === 0) {
        // No need to add closing paren if there is no open paren
        return;
      } else if (operator === '(' && last === ')') {
        // FIXME: Look at real calculator for semantics
        return;
      }

      if (last === '(' && operator === ')') {
        // Handle immediate closed parens
        state.expressions.push(currentOperand, operator);
      } else if (isOperator(last) && operator === ')') {
        // Automatically append current operand when expressions
        // is "(5 *" so result is "(5 * 5)"
        state.expressions.push(currentOperand, operator);
      } else if ((isOperator(last) || length === 0) && operator === '(') {
        // Handle "5 *" where the result is "5 * (" and "(" is the beginning
        // of a new group expression
        state.expressions.push(operator);
      }

      if (operator === '(') {
        state.openParenStack++;
      } else if (operator === ')') {
        state.openParenStack--;
      }

      console.log('ADD_PAREN');
    },
    APPEND_OPERAND: function APPEND_OPERAND(state, _ref3) {
      var value = _ref3.value,
          operator = _ref3.operator;
      var currentOperand = state.currentOperand;
      var newOperand = currentOperand;
      var newMode; // Don't append 0 to 0

      if (value === '0' && currentOperand[0] === '0') {
        return;
      } else if (value === '.' && currentOperand.includes('.')) {
        // Avoid appending multiple decimals
        return;
      } // Switch modes from showing the total to the current operand


      if (state.mode & MODE_SHOW_TOTAL) {
        newMode = MODE_INSERT_OPERAND;
      }

      if (state.mode & MODE_INSERT_OPERAND) {
        // console.log('INSERT');
        newOperand = value.toString();
        state.mode = MODE_APPEND_OPERAND;
      } else {
        // console.log('APPEND');
        newOperand += value.toString();
      } // TODO: Update font size, actually should do that in the vm


      state.currentOperand = newOperand.substring(0, MAX_NUMBER_LENGTH);
    },
    SHOW_TOTAL: function SHOW_TOTAL(state) {
      var _ref4 = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {},
          $commit = _ref4.$commit,
          explicit = _ref4.explicit;

      var last = state.expressions[state.expressions.length - 1] || '';
      var expressions = state.expressions.slice(0);
      var currentOperand = state.currentOperand;
      var mode = state.mode;
      var currentTotal = state.total;
      var openParenStack = state.openParenStack;
      var isFirstNumber = typeof Number(expressions[0]) === 'number';
      var isSecondOperator = isOperator(expressions[1] || '');
      var length = expressions.length;
      var times = openParenStack;
      var total;

      if (expressions.length === 0) {
        return;
      } else if (explicit && isFirstNumber && isSecondOperator && length === 2) {
        // Handle case where expressions is 5 *
        // console.log('explicit && isFirstNumber && isSecondOperator');
        expressions.push(currentOperand);
      } else if (explicit && isOperator(last)) {
        // Handle case where expressions is ['5', '*', '4', '+'] and
        // the total is being explicitly being requested
        // console.log('explicit && isOperator(last)', isOperator(last), last);
        if (mode & MODE_INSERT_OPERAND) {
          expressions.push(currentTotal);
        } else if (mode & MODE_APPEND_OPERAND) {
          expressions.push(currentOperand);
        }
      } else if (isOperator(last)) {
        // Handle case where expressions is ['5', '*', '4', '+']
        // console.log('isOperator(last)');
        expressions.pop();
      }

      if (explicit) {
        // Automatically close parens when explicitly requesting
        // the total
        var _times = openParenStack;

        while (_times-- > 0) {
          expressions.push(')');
        }
      } else if (!explicit && openParenStack === 1) {
        // Auto close if there is only one missing paren
        expressions.push(')');
      }

      try {
        total = MathParser.eval(expressions.join(' '));

        if (explicit) {
          $commit('CLEAR');
        }

        state.total = total;
      } catch (err) {
        if (explicit) {
          $commit('CLEAR');
          state.error = err;
          console.log(err);
        }
      }

      console.log('SHOW_TOTAL; Expressions: "%s"; Total: %s; Explicit: %s', expressions.join(' '), total, !!explicit);
    }
  };
  var actions = {
    clear: function clear(_ref5) {
      var commit = _ref5.commit;
      commit('CLEAR');
      console.log('');
    },
    backspace: function backspace(_ref6) {
      var commit = _ref6.commit;
      commit('BACKSPACE');
      console.log('');
    },
    clearEntry: function clearEntry(_ref7) {
      var commit = _ref7.commit;
      commit('CLEAR_ENTRY');
      console.log('');
    },
    negate: function negate(_ref8) {
      var commit = _ref8.commit;
      commit('NEGATE');
      console.log('');
    },
    updateOperator: function updateOperator(_ref9, payload) {
      var commit = _ref9.commit;
      commit('UPDATE_OPERATOR', payload);
      commit('SHOW_TOTAL', _objectSpread(_objectSpread({}, payload), {}, {
        $commit: commit
      }));
      console.log('');
    },
    appendOperand: function appendOperand(_ref10, payload) {
      var commit = _ref10.commit;
      commit('APPEND_OPERAND', payload);
      commit('SHOW_TOTAL', _objectSpread(_objectSpread({}, payload), {}, {
        $commit: commit
      }));
      console.log('');
    },
    showTotal: function showTotal(_ref11, payload) {
      var commit = _ref11.commit;
      // FIXME: Probably not supposed to pass commit, but idk
      //        how else to do it
      commit('SHOW_TOTAL', _objectSpread(_objectSpread({}, payload), {}, {
        $commit: commit
      }));
      console.log('');
    },
    addParen: function addParen(_ref12, payload) {
      var commit = _ref12.commit;
      commit('ADD_PAREN', payload);
      commit('SHOW_TOTAL', _objectSpread(_objectSpread({}, payload), {}, {
        $commit: commit
      }));
      console.log('');
    }
  };
  var store = window.store = new Vuex.Store({
    state: initialState,
    actions: actions,
    mutations: mutations
  });
  Vue.component('calculatorbutton', {
    props: ['button'],
    template: templates.calculatorButton,
    computed: {
      className: function className() {
        var button = this.button;
        var className = '';

        if (button.children) {
          className += ' has-children ';
        }

        if (button.className) {
          className += " Calculator-button--".concat(button.className, " ");
        }

        return className;
      }
    },
    methods: {
      emitAction: function emitAction($event, button) {
        this.$store.dispatch(button.action, button.payload);
      }
    }
  }); // [...document.querySelectorAll('.btest')].forEach(item => {
  // 	item.addEventListener('click', () => {
  // 		console.log('btest');
  // 	});
  // })

  var app = new Vue({
    el: $app,
    store: store,
    mounted: function mounted() {
      var _this = this;

      setTimeout(function () {
        return _this.appLoaded = true;
      }, 100);
    },
    data: {
      console: console,
      appLoaded: false
    },
    computed: _objectSpread(_objectSpread({}, Vuex.mapState(['buttons', 'expressions', 'currentOperand', 'currentOperator', 'openParenStack', 'total', 'error', 'mode'])), {}, {
      operand: function operand() {
        var operand;

        if (this.error) {
          return 'Error';
        }

        console.log('Flags:', getFlags(this.mode));

        if (this.mode & MODE_SHOW_TOTAL) {
          operand = this.total.toString();
          console.log('DISPLAY_TOTAL', this.total.toString());
        } else {
          operand = this.currentOperand;
          console.log('DISPLAY_CURRENT', this.currentOperand);
        }

        return operand;
      },
      expressionList: function expressionList() {
        return this.expressions.map(function (str, index, array) {
          var s = str.trim();

          if (array[index - 1] === '(') {
            return s;
          } else if (s === ')') {
            return s;
          } else if (s[0] === '-' && isNumberPart(s[1])) {
            return ' ' + str;
          } else {
            return ' ' + s;
          }

          return str;
        }).join('');
      },
      font: function font() {
        var length;

        if (this.mode & MODE_SHOW_TOTAL) {
          length = this.total.toString().length;
        } else {
          length = this.currentOperand.toString().length;
        }

        var size;
        var weight;

        if (length < 8) {
          size = '60px';
          weight = '200';
        } else if (length <= MAX_NUMBER_LENGTH) {
          size = '28px';
          weight = '300';
        } else if (length >= MAX_NUMBER_LENGTH) {
          size = '24px';
          weight = '300';
        }

        return {
          size: size,
          weight: weight
        };
      }
    })
  });
  var Key = {
    Backspace: 8,
    Delete: 46,
    Enter: 13,
    Escape: 27,
    Multiply: 106,
    Add: 107,
    Subtract: 109,
    Decimal: 110,
    Divide: 111,
    Equals: 187,
    Dash: 189,
    ForwardSlash: 191,
    0: 48,
    1: 49,
    2: 50,
    3: 51,
    4: 52,
    5: 53,
    6: 54,
    7: 55,
    8: 56,
    9: 57,
    Numpad0: 96,
    Numpad1: 97,
    Numpad2: 98,
    Numpad3: 99,
    Numpad4: 100,
    Numpad5: 101,
    Numpad6: 102,
    Numpad7: 103,
    Numpad8: 104,
    Numpad9: 105
  };
  var KeyTranslate = {
    48: '0',
    49: '1',
    50: '2',
    51: '3',
    52: '4',
    53: '5',
    54: '6',
    55: '7',
    56: '8',
    57: '9',
    96: '0',
    97: '1',
    98: '2',
    99: '3',
    100: '4',
    101: '5',
    102: '6',
    103: '7',
    104: '8',
    105: '9',
    106: '*',
    107: '+',
    109: '-',
    111: '/',
    189: '-',
    191: '/'
  };
  var OperatorKeys = [Key.Multiply, Key.Add, Key.Subtract, Key.Divide];
  window.addEventListener('keydown', function onWindowKeydown(e) {
    var key = e.keyCode,
        ctrlKey = e.ctrlKey,
        shiftKey = e.shiftKey; // console.log(key, e.key, e.which);

    if (shiftKey && key === Key['9']) {
      store.dispatch(ACTION_ADD_PAREN, {
        operator: '('
      });
    } else if (shiftKey && key === Key['0']) {
      store.dispatch(ACTION_ADD_PAREN, {
        operator: ')'
      });
    } else if (shiftKey && key === Key['8']) {
      store.dispatch(ACTION_UPDATE_OPERATOR, {
        operator: '*'
      });
    } else if (shiftKey && key === Key.Equals) {
      store.dispatch(ACTION_UPDATE_OPERATOR, {
        operator: '+'
      });
    } else if (key === Key.Dash) {
      store.dispatch(ACTION_UPDATE_OPERATOR, {
        operator: '-'
      });
    } else if (key >= 48 && key <= 57 || key >= 96 && key <= 105) {
      store.dispatch(ACTION_APPEND_OPERAND, {
        value: KeyTranslate[key]
      });
    } else if (key === Key.Decimal) {
      store.dispatch(ACTION_APPEND_OPERAND, {
        value: '.'
      });
    } else if ([Key.Multiply, Key.Add, Key.Subtract, Key.Divide].includes(key)) {
      store.dispatch(ACTION_UPDATE_OPERATOR, {
        operator: KeyTranslate[key]
      });
    } else if (key === Key.Backspace) {
      store.dispatch(ACTION_BACKSPACE);
      return e.preventDefault();
    } else if (key === Key.Delete) {
      store.dispatch(ACTION_CLEAR_ENTRY);
      return e.preventDefault();
    } else if (key === Key.Enter) {
      store.dispatch(ACTION_SHOW_TOTAL, {
        explicit: true
      });
      return e.preventDefault();
    } else if (key === Key.Escape) {
      store.dispatch(ACTION_CLEAR);
      return e.preventDefault();
    }
  }); // Debug function for flags

  function getFlags(flags) {
    var arr = [];

    if (flags & MODE_SHOW_TOTAL) {
      arr.push('MODE_SHOW_TOTAL');
    }

    if (flags & MODE_INSERT_OPERAND) {
      arr.push('MODE_INSERT_OPERAND');
    }

    if (flags & MODE_APPEND_OPERAND) {
      arr.push('MODE_APPEND_OPERAND');
    }

    return arr.join('|');
  }
}

; // TODO NEXT:

function getTotal(cb) {
  try {
    var total = MathParser.eval(this.expressions.join(''));
    return cb(null, total);
  } catch (err) {
    cb(err);
    console.log(err);
  }
}

function isNumberPart(str) {
  return /^[0-9.]/.test(str);
}

setTimeout(main, 100); // Have to mock commonjs because this was developed in node

var _ref13 = function (module) {
  var exports = module.exports;
  'use strict';

  var Token = exports.Token = {
    NumericLiteral: 'NumericLiteral',
    Punctuator: 'Punctuator'
  };
  /**
   * Regex for numeric decimal literal constructed from ECMAScript spec
   */

  var RE_NUMERIC_LITERAL = exports.RE_NUMERIC_LITERAL = /^(?:(?:0x[0-9a-fA-F]+|0X[0-9a-fA-F]+)|(?:0[oO][0-7]+)|(?:0[bB][01]+)|(?:(?:0|[1-9](?:[0-9]+)?)\.(?:[0-9]+)?|\.[0-9]+|(?:0|[1-9](?:[0-9]+)?))(?:[eE](?:[-+][0-9]+))?)/;
  var operators = exports.operators = ['/', '*', '**', '-', '+', 'yroot', '%'];
  var punctuation = exports.punctuation = ['(', ')'].concat(operators); // All the operators, sorted by longest string length

  var RE_PUNCTUATION = exports.RE_PUNCTUATION = new RegExp('^(?:' + punctuation.slice(0).sort(function (a, b) {
    return b.length - a.length;
  }).map(function (str) {
    return escapeRegExp(str);
  }).join('|') + ')');

  var isOperator = exports.isOperator = function (str) {
    return operators.includes(str);
  };
  /**
   * Courtesy of
   * http://stackoverflow.com/questions/3446170/escape-string-for-use-in-javascript-regex
   */


  function escapeRegExp(str) {
    return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
  }

  function isWhitespace(str) {
    return /^\s$/.test(str);
  }
  /**
   * A Lexer
   * @param {String} data
   * @param {Object} options
   */


  var Lexer = exports.Lexer = /*#__PURE__*/function () {
    function Lexer(data, options) {
      _classCallCheck(this, Lexer);

      var source = data;

      if (source.charAt(0) === "\uFEFF") {
        source = source.slice(1);
      }

      source = source.replace(/\r\n|[\n\r]/g, '\n');
      this.source = source;
      this.input = source;
      this.position = 0;
      this.stash = [];
      this.column = 0;
      this.line = 1;
    }

    _createClass(Lexer, [{
      key: "lex",
      value: function lex() {
        var token =  false || this.getPunctuationToken() || this.getNumericToken();

        if (token == null) {
          this.error("Unexpected token at (".concat(this.position, ")")); // this.error(`Unexpected token (${this.line}:${this.column})`);
        }

        return token;
      }
    }, {
      key: "forward",
      value: function forward(index) {
        this.position += index;
        this.input = this.input.substring(index, this.source.length);
      }
    }, {
      key: "getPunctuationToken",
      value: function getPunctuationToken() {
        var position = this.position;
        var match = this.input.match(RE_PUNCTUATION);

        if (match) {
          this.forward(match[0].length);
          return {
            type: Token.Punctuator,
            value: match[0],
            start: position,
            end: this.position
          };
        }

        return null;
      }
    }, {
      key: "getNumericToken",
      value: function getNumericToken() {
        var position = this.position;
        var match = this.input.match(RE_NUMERIC_LITERAL);

        if (match) {
          this.forward(match[0].length);
          return {
            type: Token.NumericLiteral,
            raw: match[0],
            value: Number(match[0]),
            start: position,
            end: this.position
          };
        }

        return null;
      }
    }, {
      key: "hasEnded",
      value: function hasEnded() {
        return this.input.length === 0;
      }
    }, {
      key: "skipWhitespace",
      value: function skipWhitespace() {
        var position = this.position;
        var times = 0;

        var _char;

        while (position < this.source.length) {
          _char = this.input[times];

          if (isWhitespace(_char)) {
            position++;
            times++;

            if (_char === '\n') {
              this.line++;
              this.column = 0;
            }
          } else {
            break;
          }
        }

        this.position = position;
        this.input = this.input.substring(times, this.source.length);
      }
      /**
       * Returns the next token without consuming the token or null if no
       * tokens can be found.
       *
       * @return {Object|null}
       */

    }, {
      key: "peek",
      value: function peek() {
        return this.lookahead(1);
      }
      /**
       * Returns the token at `index` or `null` if there are no more tokens.
       *
       * @param  {Number} index - The number of tokens to look ahead
       * @return {Object|null}
       */

    }, {
      key: "lookahead",
      value: function lookahead(index) {
        var stash = this.stash;
        var times = index - stash.length;
        var token;

        if (index < 0) {
          this.error('Lookahead index can not be less than 0');
        }

        if (stash[index - 1] !== undefined) {
          return stash[index - 1];
        }

        while (times-- > 0) {
          this.skipWhitespace();

          if (this.hasEnded()) {
            break;
          }

          token = this.lex();

          if (token) {
            stash.push(token);
          }
        }

        return stash[index - 1] || null;
      }
    }, {
      key: "nextToken",
      value: function nextToken() {
        if (this.stash.length) {
          return this.stash.shift();
        } else if (this.hasEnded()) {
          return null;
        }

        this.skipWhitespace();

        if (this.hasEnded()) {
          return null;
        }

        return this.lex();
      }
    }, {
      key: "error",
      value: function error(message) {
        var err = new Error(message);
        throw err;
      }
    }], [{
      key: "all",
      value: function all(data, options) {
        var lexer = new Lexer(data, options);
        var tokens = [];
        var token;

        while (token = lexer.nextToken()) {
          tokens.push(token);
        }

        return tokens;
      }
    }]);

    return Lexer;
  }();

  var Parser = exports.Parser = /*#__PURE__*/function () {
    function Parser(data, options) {
      _classCallCheck(this, Parser);

      this.lexer = new Lexer(data, options);
    }

    _createClass(Parser, [{
      key: "peek",
      value: function peek() {
        return this.lexer.peek();
      }
    }, {
      key: "next",
      value: function next() {
        return this.lexer.nextToken();
      }
    }, {
      key: "error",
      value: function error(message) {
        var err = new Error(message);
        throw err;
      }
    }, {
      key: "parsePrimary",
      value: function parsePrimary() {
        var token = this.peek();
        var expression;

        if (token == null) {
          this.error('Unexpected end of input');
        }

        if (token.value === '(') {
          token = this.next();
          expression = this.parseExpression();
          token = this.next();

          if (token == null) {
            this.error("Unexpected end of input");
          } else if (token.value !== ')') {
            this.error("Unexpected token ".concat(token.value));
          }

          return expression;
        } else if (token.type === Token.NumericLiteral) {
          token = this.next();
          return new Literal(token.raw, token.value);
        }

        this.error("Unexpected token \"".concat(token.value, "\""));
      }
    }, {
      key: "parseUnary",
      value: function parseUnary() {
        var token = this.peek();

        if (token && (token.value === '-' || token.value === '+')) {
          token = this.next();
          return new UnaryExpression(token.value, this.parseUnary());
        }

        return this.parsePrimary();
      } // I'm not sure what these pow and nth square root operators are classified as

    }, {
      key: "parsePowAndSquare",
      value: function parsePowAndSquare() {
        var expression = this.parseUnary();
        var token = this.peek();

        if (token == null) {
          return expression;
        }

        while (token && (token.value === '**' || token.value == 'yroot')) {
          token = this.next();
          var operator = token.value;
          var left = expression;
          var right = this.parseUnary();
          expression = new BinaryExpression(operator, left, right);
          token = this.peek();
        }

        return expression;
      }
    }, {
      key: "parseMultiplicative",
      value: function parseMultiplicative() {
        var expression = this.parsePowAndSquare();
        var token = this.peek();

        if (token == null) {
          return expression;
        }

        while (token && (token.value === '*' || token.value == '/' || token.value === '%')) {
          token = this.next();
          var operator = token.value;
          var left = expression;
          var right = this.parsePowAndSquare();
          expression = new BinaryExpression(operator, left, right);
          token = this.peek();
        }

        return expression;
      }
    }, {
      key: "parseAdditive",
      value: function parseAdditive() {
        var expression = this.parseMultiplicative();
        var token = this.peek();

        while (token && (token.value === '+' || token.value === '-')) {
          token = this.next();
          var operator = token.value;
          var left = expression;
          var right = this.parseMultiplicative();
          expression = new BinaryExpression(operator, left, right, token.start, token.end);
          token = this.peek();
        }

        return expression;
      }
    }, {
      key: "parseExpression",
      value: function parseExpression() {
        return this.parseAdditive();
      }
    }, {
      key: "parse",
      value: function parse() {
        return this.parseExpression();
      }
    }]);

    return Parser;
  }();

  var UnaryExpression = function UnaryExpression(operator, expression) {
    _classCallCheck(this, UnaryExpression);

    this.type = 'UnaryExpression';
    this.operator = operator;
    this.expression = expression;
  };

  var BinaryExpression = function BinaryExpression(op, left, right, start, end) {
    _classCallCheck(this, BinaryExpression);

    this.type = 'BinaryExpression';
    this.operator = op;
    this.left = left;
    this.right = right;
    this.start = start;
    this.end = end;
  };

  var Literal = function Literal(raw, value) {
    _classCallCheck(this, Literal);

    this.type = 'Literal';
    this.raw = raw;
    this.value = value;
  };

  var operations = {
    '+': function _(a, b) {
      return a + b;
    },
    '-': function _(a, b) {
      return a - b;
    },
    '*': function _(a, b) {
      return a * b;
    },
    '/': function _(a, b) {
      return a / b;
    },
    '%': function _(a, b) {
      return a % b;
    },
    '**': function _(a, b) {
      return Math.pow(a, b);
    },
    // NOTE: Apparently this is a naive implementation of nth root
    // http://stackoverflow.com/questions/7308627/javascript-calculate-the-nth-root-of-a-number
    'yroot': function yroot(a, b) {
      return Math.pow(a, 1 / b);
    }
  };
  /**
   * Evaluates the AST produced from the parser and returns its result
   * @return {Number}
   */

  var evaluateAST = exports.evaluateAST = function (node) {
    var a;

    switch (node.type) {
      case 'Expression':
        return evaluateAST(node.expression);

      case 'Literal':
        return parseFloat(node.value);

      case 'UnaryExpression':
        a = evaluateAST(node.expression);

        switch (node.operator) {
          case '+':
            return +a;

          case '-':
            return -a;

          default:
            throw new Error("Parsing error: Unrecognized unary operator \"".concat(node.operator, "\""));
        }

      case 'BinaryExpression':
        var left = node.left,
            right = node.right,
            operator = node.operator;
        var operation = operations[operator];

        if (operation === undefined) {
          throw new Error('Unsupported operand');
        }

        return operation(evaluateAST(left), evaluateAST(right));

      default:
        throw new Error("Parsing error: Unrecognized node type \"".concat(node.type, "\""));
    }
  };
  /**
   * Evaluates the expression passed and returns its result.
   *
   * @param {String} expression - The expression to evaluate
   * @return {Number}
   */


  var MathParser = exports.MathParser = {
    eval: function _eval(expression) {
      var ast = new Parser(expression).parse();
      return evaluateAST(ast);
    }
  };

  if ((typeof window === "undefined" ? "undefined" : _typeof(window)) === 'object' && window) {
    window.MathParser = MathParser;

    window.e = function () {
      return MathParser.eval.apply(MathParser, arguments);
    };

    window.parse = function () {
      return Parser.parse.apply(Parser, arguments);
    };

    window.lex = function () {
      return Lexer.all.apply(Lexer, arguments);
    };
  }

  return module.exports;
}({
  exports: {}
}),
    MathParser = _ref13.MathParser,
    isOperator = _ref13.isOperator,
    operators = _ref13.operators;

/***/ }),

/***/ 59:
/*!************************************************!*\
  !*** multi ./resources/js/pages/calculator.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! g:\OpenServer\domains\newcrm\resources\js\pages\calculator.js */"./resources/js/pages/calculator.js");


/***/ })

/******/ });