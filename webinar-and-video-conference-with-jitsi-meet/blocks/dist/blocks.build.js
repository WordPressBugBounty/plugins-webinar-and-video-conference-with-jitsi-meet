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
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./blocks/src/blocks.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./blocks/src/blocks.js":
/*!******************************!*\
  !*** ./blocks/src/blocks.js ***!
  \******************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./style.scss */ "./blocks/src/style.scss");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_style_scss__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./editor.scss */ "./blocks/src/editor.scss");
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_editor_scss__WEBPACK_IMPORTED_MODULE_1__);
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
function _callSuper(t, o, e) { return o = _getPrototypeOf(o), _possibleConstructorReturn(t, _isNativeReflectConstruct() ? Reflect.construct(o, e || [], _getPrototypeOf(t).constructor) : o.apply(t, e)); }
function _possibleConstructorReturn(t, e) { if (e && ("object" == _typeof(e) || "function" == typeof e)) return e; if (void 0 !== e) throw new TypeError("Derived constructors may only return object or undefined"); return _assertThisInitialized(t); }
function _assertThisInitialized(e) { if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); return e; }
function _isNativeReflectConstruct() { try { var t = !Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); } catch (t) {} return (_isNativeReflectConstruct = function _isNativeReflectConstruct() { return !!t; })(); }
function _getPrototypeOf(t) { return _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function (t) { return t.__proto__ || Object.getPrototypeOf(t); }, _getPrototypeOf(t); }
function _inherits(t, e) { if ("function" != typeof e && null !== e) throw new TypeError("Super expression must either be null or a function"); t.prototype = Object.create(e && e.prototype, { constructor: { value: t, writable: !0, configurable: !0 } }), Object.defineProperty(t, "prototype", { writable: !1 }), e && _setPrototypeOf(t, e); }
function _setPrototypeOf(t, e) { return _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function (t, e) { return t.__proto__ = e, t; }, _setPrototypeOf(t, e); }
var InspectorControls = wp.editor.InspectorControls;
var registerBlockType = wp.blocks.registerBlockType;
var __ = wp.i18n.__;
var _wp$element = wp.element,
  Component = _wp$element.Component,
  Fragment = _wp$element.Fragment;
var _wp$components = wp.components,
  PanelBody = _wp$components.PanelBody,
  TextControl = _wp$components.TextControl,
  RangeControl = _wp$components.RangeControl,
  CheckboxControl = _wp$components.CheckboxControl;
var blockIcon = function blockIcon() {
  return wp.element.createElement("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    height: "40",
    viewBox: "0 0 49 28",
    fill: "none"
  }, wp.element.createElement("path", {
    "fill-rule": "evenodd",
    "clip-rule": "evenodd",
    d: "M34.4757 22.0614V17.2941L43.0323 23.4061C43.5361 23.7659 44.1987 23.814 44.7491 23.5307C45.2996 23.2474 45.6455 22.6803 45.6455 22.0612V5.53492C45.6455 4.91587 45.2996 4.34873 44.7491 4.06545C44.1987 3.78219 43.5361 3.8303 43.0323 4.19012L34.4757 10.3021V5.53504C34.4757 2.61741 31.8784 0.577148 29.0998 0.577148H8.62239C5.84387 0.577148 3.24658 2.61741 3.24658 5.53504V22.0614C3.24658 24.979 5.84387 27.0193 8.62239 27.0193H29.0998C31.8784 27.0193 34.4757 24.979 34.4757 22.0614ZM20.3316 18.1759C17.8232 16.8906 15.7668 14.8431 14.4904 12.3347L16.4404 10.3847C16.6886 10.1365 16.7596 9.79081 16.6621 9.48059C16.3341 8.48784 16.1568 7.42421 16.1568 6.31627C16.1568 5.82876 15.758 5.4299 15.2704 5.4299H12.1681C11.6807 5.4299 11.2818 5.82876 11.2818 6.31627C11.2818 14.6393 18.027 21.3845 26.35 21.3845C26.8375 21.3845 27.2364 20.9856 27.2364 20.4981V17.4047C27.2364 16.9172 26.8375 16.5183 26.35 16.5183C25.2509 16.5183 24.1784 16.341 23.1857 16.0131C22.8755 15.9068 22.5209 15.9865 22.2816 16.2258L20.3316 18.1759ZM25.8625 5.42103L26.4918 6.04149L20.8989 11.6345H24.5773V12.5209H19.2591V7.20264H20.1455V11.0051L25.8625 5.42103Z",
    fill: "#407BFF"
  }));
};


var EditBlock = /*#__PURE__*/function (_Component) {
  function EditBlock(props) {
    _classCallCheck(this, EditBlock);
    return _callSuper(this, EditBlock, [props]);
  }
  _inherits(EditBlock, _Component);
  return _createClass(EditBlock, [{
    key: "componentDidMount",
    value: function componentDidMount() {
      var _this$props = this.props,
        setAttributes = _this$props.setAttributes,
        _this$props$attribute = _this$props.attributes,
        name = _this$props$attribute.name,
        domain = _this$props$attribute.domain,
        fromGlobal = _this$props$attribute.fromGlobal;
      var _newName = Math.random().toString(36).substring(2, 15);
      if (!name) {
        setAttributes({
          name: _newName
        });
      }
      if (!domain) {
        setAttributes({
          domain: jitsi.domain
        });
      }
    }
  }, {
    key: "render",
    value: function render() {
      var _this$props2 = this.props,
        attributes = _this$props2.attributes,
        setAttributes = _this$props2.setAttributes;
      var name = attributes.name,
        domain = attributes.domain,
        fromGlobal = attributes.fromGlobal,
        width = attributes.width,
        height = attributes.height,
        audioMuted = attributes.audioMuted,
        videoMuted = attributes.videoMuted,
        screenSharing = attributes.screenSharing,
        invite = attributes.invite;
      return wp.element.createElement(Fragment, null, wp.element.createElement(InspectorControls, null, wp.element.createElement(PanelBody, {
        title: __('Settings', 'webinar-and-video-conference-with-jitsi-meet'),
        initialOpen: true
      }, wp.element.createElement(TextControl, {
        label: __('Name', 'webinar-and-video-conference-with-jitsi-meet'),
        value: name,
        onChange: function onChange(val) {
          return setAttributes({
            name: val
          });
        }
      }), wp.element.createElement(TextControl, {
        label: __('Domain', 'webinar-and-video-conference-with-jitsi-meet'),
        value: domain,
        onChange: function onChange(val) {
          return setAttributes({
            domain: val
          });
        },
        disabled: true
      }), wp.element.createElement(CheckboxControl, {
        label: __('Config from global', 'webinar-and-video-conference-with-jitsi-meet'),
        checked: fromGlobal,
        onChange: function onChange(val) {
          setAttributes({
            fromGlobal: val
          });
          if (!fromGlobal) {
            setAttributes({
              width: parseInt(jitsi.meeting_width),
              height: parseInt(jitsi.meeting_height),
              audioMuted: parseInt(jitsi.startwithaudiomuted) ? true : false,
              videoMuted: parseInt(jitsi.startwithvideomuted) ? true : false,
              screenSharing: parseInt(jitsi.startscreensharing) ? true : false,
              invite: parseInt(jitsi.invite) ? true : false
            });
          }
        }
      }), !fromGlobal && wp.element.createElement("div", null, wp.element.createElement(RangeControl, {
        label: __('Width', 'webinar-and-video-conference-with-jitsi-meet'),
        value: width,
        onChange: function onChange(val) {
          return setAttributes({
            width: val
          });
        },
        min: 100,
        max: 2000,
        step: 10
      }), wp.element.createElement(RangeControl, {
        label: __('Height', 'webinar-and-video-conference-with-jitsi-meet'),
        value: height,
        onChange: function onChange(val) {
          return setAttributes({
            height: val
          });
        },
        min: 100,
        max: 2000,
        step: 10
      }), wp.element.createElement(CheckboxControl, {
        label: __('Start with audio muted', 'webinar-and-video-conference-with-jitsi-meet'),
        checked: audioMuted,
        onChange: function onChange(val) {
          return setAttributes({
            audioMuted: val
          });
        }
      }), wp.element.createElement(CheckboxControl, {
        label: __('Start with video muted', 'webinar-and-video-conference-with-jitsi-meet'),
        checked: videoMuted,
        onChange: function onChange(val) {
          return setAttributes({
            videoMuted: val
          });
        }
      }), wp.element.createElement(CheckboxControl, {
        label: __('Start with screen sharing', 'webinar-and-video-conference-with-jitsi-meet'),
        checked: screenSharing,
        onChange: function onChange(val) {
          return setAttributes({
            screenSharing: val
          });
        }
      }), wp.element.createElement(CheckboxControl, {
        label: __('Enable Inviting', 'webinar-and-video-conference-with-jitsi-meet'),
        checked: invite,
        onChange: function onChange(val) {
          return setAttributes({
            invite: val
          });
        }
      })))), wp.element.createElement("div", {
        className: "jitsi-wrapper",
        "data-name": name,
        "data-domain": domain,
        "data-width": width,
        "data-height": height,
        "data-mute": audioMuted,
        "data-videomute": videoMuted,
        "data-screen": screenSharing,
        "data-invite": invite
      }, wp.element.createElement("span", null, " ", __('Room name:', 'webinar-and-video-conference-with-jitsi-meet'), " ", name), " ", wp.element.createElement("br", null), wp.element.createElement("span", null, " ", __('Domain :', 'webinar-and-video-conference-with-jitsi-meet'), " ", domain)));
    }
  }]);
}(Component);
registerBlockType('jitsi-meet-wp/jitsi-meet', {
  title: __('Jitsi Meet', 'webinar-and-video-conference-with-jitsi-meet'),
  icon: blockIcon,
  category: 'embed',
  keywords: [__('jitsi', 'webinar-and-video-conference-with-jitsi-meet'), __('meeting', 'webinar-and-video-conference-with-jitsi-meet'), __('video', 'webinar-and-video-conference-with-jitsi-meet'), __('conference', 'webinar-and-video-conference-with-jitsi-meet'), __('zoom', 'webinar-and-video-conference-with-jitsi-meet')],
  attributes: {
    name: {
      type: 'string',
      "default": ''
    },
    domain: {
      type: 'string',
      "default": ''
    },
    width: {
      type: 'number',
      "default": 1080
    },
    height: {
      type: 'number',
      "default": 720
    },
    fromGlobal: {
      type: 'boolean',
      "default": false
    },
    audioMuted: {
      type: 'boolean',
      "default": false
    },
    videoMuted: {
      type: 'boolean',
      "default": true
    },
    screenSharing: {
      type: 'boolean',
      "default": false
    },
    invite: {
      type: 'boolean',
      "default": true
    }
  },
  edit: EditBlock,
  save: function save(props) {
    var _props$attributes = props.attributes,
      name = _props$attributes.name,
      domain = _props$attributes.domain,
      width = _props$attributes.width,
      height = _props$attributes.height,
      audioMuted = _props$attributes.audioMuted,
      videoMuted = _props$attributes.videoMuted,
      screenSharing = _props$attributes.screenSharing,
      invite = _props$attributes.invite;
    return wp.element.createElement("div", {
      className: "jitsi-wrapper",
      "data-name": name,
      "data-domain": domain,
      "data-width": width,
      "data-height": height,
      "data-mute": audioMuted,
      "data-videomute": videoMuted,
      "data-screen": screenSharing,
      "data-invite": invite,
      style: {
        width: "".concat(width, "px")
      }
    });
  }
});

/***/ }),

/***/ "./blocks/src/editor.scss":
/*!********************************!*\
  !*** ./blocks/src/editor.scss ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./blocks/src/style.scss":
/*!*******************************!*\
  !*** ./blocks/src/style.scss ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vYmxvY2tzL3NyYy9ibG9ja3MuanMiLCJ3ZWJwYWNrOi8vLy4vYmxvY2tzL3NyYy9lZGl0b3Iuc2NzcyIsIndlYnBhY2s6Ly8vLi9ibG9ja3Mvc3JjL3N0eWxlLnNjc3MiXSwibmFtZXMiOlsiSW5zcGVjdG9yQ29udHJvbHMiLCJ3cCIsImVkaXRvciIsInJlZ2lzdGVyQmxvY2tUeXBlIiwiYmxvY2tzIiwiX18iLCJpMThuIiwiX3dwJGVsZW1lbnQiLCJlbGVtZW50IiwiQ29tcG9uZW50IiwiRnJhZ21lbnQiLCJfd3AkY29tcG9uZW50cyIsImNvbXBvbmVudHMiLCJQYW5lbEJvZHkiLCJUZXh0Q29udHJvbCIsIlJhbmdlQ29udHJvbCIsIkNoZWNrYm94Q29udHJvbCIsImJsb2NrSWNvbiIsImNyZWF0ZUVsZW1lbnQiLCJ4bWxucyIsImhlaWdodCIsInZpZXdCb3giLCJmaWxsIiwiZCIsIkVkaXRCbG9jayIsIl9Db21wb25lbnQiLCJwcm9wcyIsIl9jbGFzc0NhbGxDaGVjayIsIl9jYWxsU3VwZXIiLCJfaW5oZXJpdHMiLCJfY3JlYXRlQ2xhc3MiLCJrZXkiLCJ2YWx1ZSIsImNvbXBvbmVudERpZE1vdW50IiwiX3RoaXMkcHJvcHMiLCJzZXRBdHRyaWJ1dGVzIiwiX3RoaXMkcHJvcHMkYXR0cmlidXRlIiwiYXR0cmlidXRlcyIsIm5hbWUiLCJkb21haW4iLCJmcm9tR2xvYmFsIiwiX25ld05hbWUiLCJNYXRoIiwicmFuZG9tIiwidG9TdHJpbmciLCJzdWJzdHJpbmciLCJqaXRzaSIsInJlbmRlciIsIl90aGlzJHByb3BzMiIsIndpZHRoIiwiYXVkaW9NdXRlZCIsInZpZGVvTXV0ZWQiLCJzY3JlZW5TaGFyaW5nIiwiaW52aXRlIiwidGl0bGUiLCJpbml0aWFsT3BlbiIsImxhYmVsIiwib25DaGFuZ2UiLCJ2YWwiLCJkaXNhYmxlZCIsImNoZWNrZWQiLCJwYXJzZUludCIsIm1lZXRpbmdfd2lkdGgiLCJtZWV0aW5nX2hlaWdodCIsInN0YXJ0d2l0aGF1ZGlvbXV0ZWQiLCJzdGFydHdpdGh2aWRlb211dGVkIiwic3RhcnRzY3JlZW5zaGFyaW5nIiwibWluIiwibWF4Iiwic3RlcCIsImNsYXNzTmFtZSIsImljb24iLCJjYXRlZ29yeSIsImtleXdvcmRzIiwidHlwZSIsImVkaXQiLCJzYXZlIiwiX3Byb3BzJGF0dHJpYnV0ZXMiLCJzdHlsZSIsImNvbmNhdCJdLCJtYXBwaW5ncyI6IjtRQUFBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBOzs7UUFHQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0EsMENBQTBDLGdDQUFnQztRQUMxRTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLHdEQUF3RCxrQkFBa0I7UUFDMUU7UUFDQSxpREFBaUQsY0FBYztRQUMvRDs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0EseUNBQXlDLGlDQUFpQztRQUMxRSxnSEFBZ0gsbUJBQW1CLEVBQUU7UUFDckk7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQSwyQkFBMkIsMEJBQTBCLEVBQUU7UUFDdkQsaUNBQWlDLGVBQWU7UUFDaEQ7UUFDQTtRQUNBOztRQUVBO1FBQ0Esc0RBQXNELCtEQUErRDs7UUFFckg7UUFDQTs7O1FBR0E7UUFDQTs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQ2xGQSxJQUFRQSxpQkFBaUIsR0FBS0MsRUFBRSxDQUFDQyxNQUFNLENBQS9CRixpQkFBaUI7QUFDekIsSUFBUUcsaUJBQWlCLEdBQUtGLEVBQUUsQ0FBQ0csTUFBTSxDQUEvQkQsaUJBQWlCO0FBQ3pCLElBQVFFLEVBQUUsR0FBS0osRUFBRSxDQUFDSyxJQUFJLENBQWRELEVBQUU7QUFDVixJQUFB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QUFBLENBQUp2QyxJQUFJO01BQ0pDLE1BQU0sR0FBQXNDLGlCQUFBLENBQU50QyxNQUFNO01BQ05VLEtBQUssR0FBQTRCLGlCQUFBLENBQUw1QixLQUFLO01BQ0w3QixNQUFNLEdBQUF5RCxpQkFBQSxDQUFOekQsTUFBTTtNQUNOOEIsVUFBVSxHQUFBMkIsaUJBQUEsQ0FBVjNCLFVBQVU7TUFDVkMsVUFBVSxHQUFBMEIsaUJBQUEsQ0FBVjFCLFVBQVU7TUFDVkMsYUFBYSxHQUFBeUIsaUJBQUEsQ0FBYnpCLGFBQWE7TUFDYkMsTUFBTSxHQUFBd0IsaUJBQUEsQ0FBTnhCLE1BQU07SUFHUixPQUNFcEQsRUFBQSxDQUFBTyxPQUFBLENBQUFVLGFBQUE7TUFDRW9ELFNBQVMsRUFBQyxlQUFlO01BQ3pCLGFBQVdoQyxJQUFLO01BQ2hCLGVBQWFDLE1BQU87TUFDcEIsY0FBWVUsS0FBTTtNQUNsQixlQUFhN0IsTUFBTztNQUNwQixhQUFXOEIsVUFBVztNQUN0QixrQkFBZ0JDLFVBQVc7TUFDM0IsZUFBYUMsYUFBYztNQUMzQixlQUFhQyxNQUFPO01BQ3BCeUIsS0FBSyxFQUFFO1FBQ0w3QixLQUFLLEtBQUE4QixNQUFBLENBQUs5QixLQUFLO01BQ2pCO0lBQUUsQ0FDRSxDQUFDO0VBRVg7QUFDRixDQUFDLENBQUMsQzs7Ozs7Ozs7Ozs7QUNuUEYseUM7Ozs7Ozs7Ozs7O0FDQUEseUMiLCJmaWxlIjoiYmxvY2tzLmJ1aWxkLmpzIiwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZ2V0dGVyIH0pO1xuIFx0XHR9XG4gXHR9O1xuXG4gXHQvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG4gXHRcdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuIFx0XHR9XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG4gXHR9O1xuXG4gXHQvLyBjcmVhdGUgYSBmYWtlIG5hbWVzcGFjZSBvYmplY3RcbiBcdC8vIG1vZGUgJiAxOiB2YWx1ZSBpcyBhIG1vZHVsZSBpZCwgcmVxdWlyZSBpdFxuIFx0Ly8gbW9kZSAmIDI6IG1lcmdlIGFsbCBwcm9wZXJ0aWVzIG9mIHZhbHVlIGludG8gdGhlIG5zXG4gXHQvLyBtb2RlICYgNDogcmV0dXJuIHZhbHVlIHdoZW4gYWxyZWFkeSBucyBvYmplY3RcbiBcdC8vIG1vZGUgJiA4fDE6IGJlaGF2ZSBsaWtlIHJlcXVpcmVcbiBcdF9fd2VicGFja19yZXF1aXJlX18udCA9IGZ1bmN0aW9uKHZhbHVlLCBtb2RlKSB7XG4gXHRcdGlmKG1vZGUgJiAxKSB2YWx1ZSA9IF9fd2VicGFja19yZXF1aXJlX18odmFsdWUpO1xuIFx0XHRpZihtb2RlICYgOCkgcmV0dXJuIHZhbHVlO1xuIFx0XHRpZigobW9kZSAmIDQpICYmIHR5cGVvZiB2YWx1ZSA9PT0gJ29iamVjdCcgJiYgdmFsdWUgJiYgdmFsdWUuX19lc01vZHVsZSkgcmV0dXJuIHZhbHVlO1xuIFx0XHR2YXIgbnMgPSBPYmplY3QuY3JlYXRlKG51bGwpO1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIobnMpO1xuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkobnMsICdkZWZhdWx0JywgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdmFsdWUgfSk7XG4gXHRcdGlmKG1vZGUgJiAyICYmIHR5cGVvZiB2YWx1ZSAhPSAnc3RyaW5nJykgZm9yKHZhciBrZXkgaW4gdmFsdWUpIF9fd2VicGFja19yZXF1aXJlX18uZChucywga2V5LCBmdW5jdGlvbihrZXkpIHsgcmV0dXJuIHZhbHVlW2tleV07IH0uYmluZChudWxsLCBrZXkpKTtcbiBcdFx0cmV0dXJuIG5zO1xuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCJcIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IFwiLi9ibG9ja3Mvc3JjL2Jsb2Nrcy5qc1wiKTtcbiIsImNvbnN0IHsgSW5zcGVjdG9yQ29udHJvbHMgfSA9IHdwLmVkaXRvcjtcclxuY29uc3QgeyByZWdpc3RlckJsb2NrVHlwZSB9ID0gd3AuYmxvY2tzO1xyXG5jb25zdCB7IF9fIH0gPSB3cC5pMThuO1xyXG5jb25zdCB7IENvbXBvbmVudCwgRnJhZ21lbnQgfSA9IHdwLmVsZW1lbnQ7XHJcbmNvbnN0IHsgUGFuZWxCb2R5LCBUZXh0Q29udHJvbCwgUmFuZ2VDb250cm9sLCBDaGVja2JveENvbnRyb2wgfSA9IHdwLmNvbXBvbmVudHM7XHJcblxyXG5jb25zdCBibG9ja0ljb24gPSAoKSA9PiB7XHJcbiAgcmV0dXJuIChcclxuICAgIDxzdmdcclxuICAgICAgeG1sbnM9XCJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2Z1wiXHJcbiAgICAgIGhlaWdodD1cIjQwXCJcclxuICAgICAgdmlld0JveD1cIjAgMCA0OSAyOFwiXHJcbiAgICAgIGZpbGw9XCJub25lXCJcclxuICAgID5cclxuICAgICAgPHBhdGhcclxuICAgICAgICBmaWxsLXJ1bGU9XCJldmVub2RkXCJcclxuICAgICAgICBjbGlwLXJ1bGU9XCJldmVub2RkXCJcclxuICAgICAgICBkPVwiTTM0LjQ3NTcgMjIuMDYxNFYxNy4yOTQxTDQzLjAzMjMgMjMuNDA2MUM0My41MzYxIDIzLjc2NTkgNDQuMTk4NyAyMy44MTQgNDQuNzQ5MSAyMy41MzA3QzQ1LjI5OTYgMjMuMjQ3NCA0NS42NDU1IDIyLjY4MDMgNDUuNjQ1NSAyMi4wNjEyVjUuNTM0OTJDNDUuNjQ1NSA0LjkxNTg3IDQ1LjI5OTYgNC4zNDg3MyA0NC43NDkxIDQuMDY1NDVDNDQuMTk4NyAzLjc4MjE5IDQzLjUzNjEgMy44MzAzIDQzLjAzMjMgNC4xOTAxMkwzNC40NzU3IDEwLjMwMjFWNS41MzUwNEMzNC40NzU3IDIuNjE3NDEgMzEuODc4NCAwLjU3NzE0OCAyOS4wOTk4IDAuNTc3MTQ4SDguNjIyMzlDNS44NDM4NyAwLjU3NzE0OCAzLjI0NjU4IDIuNjE3NDEgMy4yNDY1OCA1LjUzNTA0VjIyLjA2MTRDMy4yNDY1OCAyNC45NzkgNS44NDM4NyAyNy4wMTkzIDguNjIyMzkgMjcuMDE5M0gyOS4wOTk4QzMxLjg3ODQgMjcuMDE5MyAzNC40NzU3IDI0Ljk3OSAzNC40NzU3IDIyLjA2MTRaTTIwLjMzMTYgMTguMTc1OUMxNy44MjMyIDE2Ljg5MDYgMTUuNzY2OCAxNC44NDMxIDE0LjQ5MDQgMTIuMzM0N0wxNi40NDA0IDEwLjM4NDdDMTYuNjg4NiAxMC4xMzY1IDE2Ljc1OTYgOS43OTA4MSAxNi42NjIxIDkuNDgwNTlDMTYuMzM0MSA4LjQ4Nzg0IDE2LjE1NjggNy40MjQyMSAxNi4xNTY4IDYuMzE2MjdDMTYuMTU2OCA1LjgyODc2IDE1Ljc1OCA1LjQyOTkgMTUuMjcwNCA1LjQyOTlIMTIuMTY4MUMxMS42ODA3IDUuNDI5OSAxMS4yODE4IDUuODI4NzYgMTEuMjgxOCA2LjMxNjI3QzExLjI4MTggMTQuNjM5MyAxOC4wMjcgMjEuMzg0NSAyNi4zNSAyMS4zODQ1QzI2LjgzNzUgMjEuMzg0NSAyNy4yMzY0IDIwLjk4NTYgMjcuMjM2NCAyMC40OTgxVjE3LjQwNDdDMjcuMjM2NCAxNi45MTcyIDI2LjgzNzUgMTYuNTE4MyAyNi4zNSAxNi41MTgzQzI1LjI1MDkgMTYuNTE4MyAyNC4xNzg0IDE2LjM0MSAyMy4xODU3IDE2LjAxMzFDMjIuODc1NSAxNS45MDY4IDIyLjUyMDkgMTUuOTg2NSAyMi4yODE2IDE2LjIyNThMMjAuMzMxNiAxOC4xNzU5Wk0yNS44NjI1IDUuNDIxMDNMMjYuNDkxOCA2LjA0MTQ5TDIwLjg5ODkgMTEuNjM0NUgyNC41NzczVjEyLjUyMDlIMTkuMjU5MVY3LjIwMjY0SDIwLjE0NTVWMTEuMDA1MUwyNS44NjI1IDUuNDIxMDNaXCJcclxuICAgICAgICBmaWxsPVwiIzQwN0JGRlwiXHJcbiAgICAgIC8+XHJcbiAgICA8L3N2Zz5cclxuICApO1xyXG59O1xyXG5cclxuaW1wb3J0ICcuL3N0eWxlLnNjc3MnO1xyXG5pbXBvcnQgJy4vZWRpdG9yLnNjc3MnO1xyXG5cclxuY2xhc3MgRWRpdEJsb2NrIGV4dGVuZHMgQ29tcG9uZW50IHtcclxuICBjb25zdHJ1Y3Rvcihwcm9wcykge1xyXG4gICAgc3VwZXIocHJvcHMpO1xyXG4gIH1cclxuXHJcbiAgY29tcG9uZW50RGlkTW91bnQoKSB7XHJcbiAgICBjb25zdCB7XHJcbiAgICAgIHNldEF0dHJpYnV0ZXMsXHJcbiAgICAgIGF0dHJpYnV0ZXM6IHsgbmFtZSwgZG9tYWluLCBmcm9tR2xvYmFsIH0sXHJcbiAgICB9ID0gdGhpcy5wcm9wcztcclxuICAgIGNvbnN0IF9uZXdOYW1lID0gTWF0aC5yYW5kb20oKS50b1N0cmluZygzNikuc3Vic3RyaW5nKDIsIDE1KTtcclxuICAgIGlmICghbmFtZSkge1xyXG4gICAgICBzZXRBdHRyaWJ1dGVzKHsgbmFtZTogX25ld05hbWUgfSk7XHJcbiAgICB9XHJcblxyXG4gICAgaWYoICFkb21haW4gKXtcclxuICAgICAgc2V0QXR0cmlidXRlcyh7IGRvbWFpbjogaml0c2kuZG9tYWluIH0pO1xyXG4gICAgfVxyXG5cclxuICB9XHJcblxyXG4gIHJlbmRlcigpIHtcclxuICAgIGNvbnN0IHsgYXR0cmlidXRlcywgc2V0QXR0cmlidXRlcyB9ID0gdGhpcy5wcm9wcztcclxuXHJcbiAgICBjb25zdCB7XHJcbiAgICAgIG5hbWUsXHJcbiAgICAgIGRvbWFpbixcclxuICAgICAgZnJvbUdsb2JhbCxcclxuICAgICAgd2lkdGgsXHJcbiAgICAgIGhlaWdodCxcclxuICAgICAgYXVkaW9NdXRlZCxcclxuICAgICAgdmlkZW9NdXRlZCxcclxuICAgICAgc2NyZWVuU2hhcmluZyxcclxuICAgICAgaW52aXRlLFxyXG4gICAgfSA9IGF0dHJpYnV0ZXM7XHJcblxyXG4gICAgcmV0dXJuIChcclxuICAgICAgPEZyYWdtZW50PlxyXG4gICAgICAgIDxJbnNwZWN0b3JDb250cm9scz5cclxuICAgICAgICAgIDxQYW5lbEJvZHkgdGl0bGU9e19fKCdTZXR0aW5ncycsICd3ZWJpbmFyLWFuZC12aWRlby1jb25mZXJlbmNlLXdpdGgtaml0c2ktbWVldCcpfSBpbml0aWFsT3Blbj17dHJ1ZX0+XHJcbiAgICAgICAgICAgIDxUZXh0Q29udHJvbFxyXG4gICAgICAgICAgICAgIGxhYmVsPXtfXygnTmFtZScsICd3ZWJpbmFyLWFuZC12aWRlby1jb25mZXJlbmNlLXdpdGgtaml0c2ktbWVldCcpfVxyXG4gICAgICAgICAgICAgIHZhbHVlPXtuYW1lfVxyXG4gICAgICAgICAgICAgIG9uQ2hhbmdlPXsodmFsKSA9PiBzZXRBdHRyaWJ1dGVzKHsgbmFtZTogdmFsIH0pfVxyXG4gICAgICAgICAgICAvPlxyXG5cclxuICAgICAgICAgICAgPFRleHRDb250cm9sXHJcbiAgICAgICAgICAgICAgbGFiZWw9e19fKCdEb21haW4nLCAnd2ViaW5hci1hbmQtdmlkZW8tY29uZmVyZW5jZS13aXRoLWppdHNpLW1lZXQnKX1cclxuICAgICAgICAgICAgICB2YWx1ZT17ZG9tYWlufVxyXG4gICAgICAgICAgICAgIG9uQ2hhbmdlPXsodmFsKSA9PiBzZXRBdHRyaWJ1dGVzKHsgZG9tYWluOiB2YWwgfSl9XHJcbiAgICAgICAgICAgICAgZGlzYWJsZWQ9e3RydWV9XHJcbiAgICAgICAgICAgIC8+XHJcblxyXG4gICAgICAgICAgICA8Q2hlY2tib3hDb250cm9sXHJcbiAgICAgICAgICAgICAgbGFiZWw9e19fKCdDb25maWcgZnJvbSBnbG9iYWwnLCAnd2ViaW5hci1hbmQtdmlkZW8tY29uZmVyZW5jZS13aXRoLWppdHNpLW1lZXQnKX1cclxuICAgICAgICAgICAgICBjaGVja2VkPXtmcm9tR2xvYmFsfVxyXG4gICAgICAgICAgICAgIG9uQ2hhbmdlPXsodmFsKSA9PiB7XHJcbiAgICAgICAgICAgICAgICBzZXRBdHRyaWJ1dGVzKHsgZnJvbUdsb2JhbDogdmFsIH0pO1xyXG4gICAgICAgICAgICAgICAgaWYgKCFmcm9tR2xvYmFsKSB7XHJcbiAgICAgICAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoe1xyXG4gICAgICAgICAgICAgICAgICAgIHdpZHRoOiBwYXJzZUludChqaXRzaS5tZWV0aW5nX3dpZHRoKSxcclxuICAgICAgICAgICAgICAgICAgICBoZWlnaHQ6IHBhcnNlSW50KGppdHNpLm1lZXRpbmdfaGVpZ2h0KSxcclxuICAgICAgICAgICAgICAgICAgICBhdWRpb011dGVkOiBwYXJzZUludChqaXRzaS5zdGFydHdpdGhhdWRpb211dGVkKVxyXG4gICAgICAgICAgICAgICAgICAgICAgPyB0cnVlXHJcbiAgICAgICAgICAgICAgICAgICAgICA6IGZhbHNlLFxyXG4gICAgICAgICAgICAgICAgICAgIHZpZGVvTXV0ZWQ6IHBhcnNlSW50KGppdHNpLnN0YXJ0d2l0aHZpZGVvbXV0ZWQpXHJcbiAgICAgICAgICAgICAgICAgICAgICA/IHRydWVcclxuICAgICAgICAgICAgICAgICAgICAgIDogZmFsc2UsXHJcbiAgICAgICAgICAgICAgICAgICAgc2NyZWVuU2hhcmluZzogcGFyc2VJbnQoaml0c2kuc3RhcnRzY3JlZW5zaGFyaW5nKVxyXG4gICAgICAgICAgICAgICAgICAgICAgPyB0cnVlXHJcbiAgICAgICAgICAgICAgICAgICAgICA6IGZhbHNlLFxyXG4gICAgICAgICAgICAgICAgICAgIGludml0ZTogcGFyc2VJbnQoaml0c2kuaW52aXRlKSA/IHRydWUgOiBmYWxzZSxcclxuICAgICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgfX1cclxuICAgICAgICAgICAgLz5cclxuICAgICAgICAgICAgeyFmcm9tR2xvYmFsICYmIChcclxuICAgICAgICAgICAgICA8ZGl2PlxyXG4gICAgICAgICAgICAgICAgPFJhbmdlQ29udHJvbFxyXG4gICAgICAgICAgICAgICAgICBsYWJlbD17X18oJ1dpZHRoJywgJ3dlYmluYXItYW5kLXZpZGVvLWNvbmZlcmVuY2Utd2l0aC1qaXRzaS1tZWV0Jyl9XHJcbiAgICAgICAgICAgICAgICAgIHZhbHVlPXt3aWR0aH1cclxuICAgICAgICAgICAgICAgICAgb25DaGFuZ2U9eyh2YWwpID0+IHNldEF0dHJpYnV0ZXMoeyB3aWR0aDogdmFsIH0pfVxyXG4gICAgICAgICAgICAgICAgICBtaW49ezEwMH1cclxuICAgICAgICAgICAgICAgICAgbWF4PXsyMDAwfVxyXG4gICAgICAgICAgICAgICAgICBzdGVwPXsxMH1cclxuICAgICAgICAgICAgICAgIC8+XHJcbiAgICAgICAgICAgICAgICA8UmFuZ2VDb250cm9sXHJcbiAgICAgICAgICAgICAgICAgIGxhYmVsPXtfXygnSGVpZ2h0JywgJ3dlYmluYXItYW5kLXZpZGVvLWNvbmZlcmVuY2Utd2l0aC1qaXRzaS1tZWV0Jyl9XHJcbiAgICAgICAgICAgICAgICAgIHZhbHVlPXtoZWlnaHR9XHJcbiAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlPXsodmFsKSA9PiBzZXRBdHRyaWJ1dGVzKHsgaGVpZ2h0OiB2YWwgfSl9XHJcbiAgICAgICAgICAgICAgICAgIG1pbj17MTAwfVxyXG4gICAgICAgICAgICAgICAgICBtYXg9ezIwMDB9XHJcbiAgICAgICAgICAgICAgICAgIHN0ZXA9ezEwfVxyXG4gICAgICAgICAgICAgICAgLz5cclxuICAgICAgICAgICAgICAgIDxDaGVja2JveENvbnRyb2xcclxuICAgICAgICAgICAgICAgICAgbGFiZWw9e19fKCdTdGFydCB3aXRoIGF1ZGlvIG11dGVkJywgJ3dlYmluYXItYW5kLXZpZGVvLWNvbmZlcmVuY2Utd2l0aC1qaXRzaS1tZWV0Jyl9XHJcbiAgICAgICAgICAgICAgICAgIGNoZWNrZWQ9e2F1ZGlvTXV0ZWR9XHJcbiAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlPXsodmFsKSA9PiBzZXRBdHRyaWJ1dGVzKHsgYXVkaW9NdXRlZDogdmFsIH0pfVxyXG4gICAgICAgICAgICAgICAgLz5cclxuICAgICAgICAgICAgICAgIDxDaGVja2JveENvbnRyb2xcclxuICAgICAgICAgICAgICAgICAgbGFiZWw9e19fKCdTdGFydCB3aXRoIHZpZGVvIG11dGVkJywgJ3dlYmluYXItYW5kLXZpZGVvLWNvbmZlcmVuY2Utd2l0aC1qaXRzaS1tZWV0Jyl9XHJcbiAgICAgICAgICAgICAgICAgIGNoZWNrZWQ9e3ZpZGVvTXV0ZWR9XHJcbiAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlPXsodmFsKSA9PiBzZXRBdHRyaWJ1dGVzKHsgdmlkZW9NdXRlZDogdmFsIH0pfVxyXG4gICAgICAgICAgICAgICAgLz5cclxuICAgICAgICAgICAgICAgIDxDaGVja2JveENvbnRyb2xcclxuICAgICAgICAgICAgICAgICAgbGFiZWw9e19fKCdTdGFydCB3aXRoIHNjcmVlbiBzaGFyaW5nJywgJ3dlYmluYXItYW5kLXZpZGVvLWNvbmZlcmVuY2Utd2l0aC1qaXRzaS1tZWV0Jyl9XHJcbiAgICAgICAgICAgICAgICAgIGNoZWNrZWQ9e3NjcmVlblNoYXJpbmd9XHJcbiAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlPXsodmFsKSA9PiBzZXRBdHRyaWJ1dGVzKHsgc2NyZWVuU2hhcmluZzogdmFsIH0pfVxyXG4gICAgICAgICAgICAgICAgLz5cclxuICAgICAgICAgICAgICAgIDxDaGVja2JveENvbnRyb2xcclxuICAgICAgICAgICAgICAgICAgbGFiZWw9e19fKCdFbmFibGUgSW52aXRpbmcnLCAnd2ViaW5hci1hbmQtdmlkZW8tY29uZmVyZW5jZS13aXRoLWppdHNpLW1lZXQnKX1cclxuICAgICAgICAgICAgICAgICAgY2hlY2tlZD17aW52aXRlfVxyXG4gICAgICAgICAgICAgICAgICBvbkNoYW5nZT17KHZhbCkgPT4gc2V0QXR0cmlidXRlcyh7IGludml0ZTogdmFsIH0pfVxyXG4gICAgICAgICAgICAgICAgLz5cclxuICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgKX1cclxuICAgICAgICAgIDwvUGFuZWxCb2R5PlxyXG4gICAgICAgIDwvSW5zcGVjdG9yQ29udHJvbHM+XHJcbiAgICAgICAgPGRpdlxyXG4gICAgICAgICAgY2xhc3NOYW1lPVwiaml0c2ktd3JhcHBlclwiXHJcbiAgICAgICAgICBkYXRhLW5hbWU9e25hbWV9XHJcbiAgICAgICAgICBkYXRhLWRvbWFpbj17ZG9tYWlufVxyXG4gICAgICAgICAgZGF0YS13aWR0aD17d2lkdGh9XHJcbiAgICAgICAgICBkYXRhLWhlaWdodD17aGVpZ2h0fVxyXG4gICAgICAgICAgZGF0YS1tdXRlPXthdWRpb011dGVkfVxyXG4gICAgICAgICAgZGF0YS12aWRlb211dGU9e3ZpZGVvTXV0ZWR9XHJcbiAgICAgICAgICBkYXRhLXNjcmVlbj17c2NyZWVuU2hhcmluZ31cclxuICAgICAgICAgIGRhdGEtaW52aXRlPXtpbnZpdGV9XHJcbiAgICAgICAgPlxyXG4gICAgICAgICA8c3Bhbj4ge19fKCdSb29tIG5hbWU6JywgJ3dlYmluYXItYW5kLXZpZGVvLWNvbmZlcmVuY2Utd2l0aC1qaXRzaS1tZWV0Jyl9IHtuYW1lfTwvc3Bhbj4gPGJyPjwvYnI+XHJcbiAgICAgICAgIDxzcGFuPiB7X18oJ0RvbWFpbiA6JywgJ3dlYmluYXItYW5kLXZpZGVvLWNvbmZlcmVuY2Utd2l0aC1qaXRzaS1tZWV0Jyl9IHtkb21haW59PC9zcGFuPlxyXG4gICAgICAgICAgPC9kaXY+XHJcbiAgICAgIDwvRnJhZ21lbnQ+XHJcbiAgICApO1xyXG4gIH1cclxufVxyXG5cclxucmVnaXN0ZXJCbG9ja1R5cGUoJ2ppdHNpLW1lZXQtd3Avaml0c2ktbWVldCcsIHtcclxuICB0aXRsZTogX18oJ0ppdHNpIE1lZXQnLCAnd2ViaW5hci1hbmQtdmlkZW8tY29uZmVyZW5jZS13aXRoLWppdHNpLW1lZXQnKSxcclxuICBpY29uOiBibG9ja0ljb24sXHJcbiAgY2F0ZWdvcnk6ICdlbWJlZCcsXHJcbiAga2V5d29yZHM6IFtcclxuICAgIF9fKCdqaXRzaScsICd3ZWJpbmFyLWFuZC12aWRlby1jb25mZXJlbmNlLXdpdGgtaml0c2ktbWVldCcpLFxyXG4gICAgX18oJ21lZXRpbmcnLCAnd2ViaW5hci1hbmQtdmlkZW8tY29uZmVyZW5jZS13aXRoLWppdHNpLW1lZXQnKSxcclxuICAgIF9fKCd2aWRlbycsICd3ZWJpbmFyLWFuZC12aWRlby1jb25mZXJlbmNlLXdpdGgtaml0c2ktbWVldCcpLFxyXG4gICAgX18oJ2NvbmZlcmVuY2UnLCAnd2ViaW5hci1hbmQtdmlkZW8tY29uZmVyZW5jZS13aXRoLWppdHNpLW1lZXQnKSxcclxuICAgIF9fKCd6b29tJywgJ3dlYmluYXItYW5kLXZpZGVvLWNvbmZlcmVuY2Utd2l0aC1qaXRzaS1tZWV0JyksXHJcbiAgXSxcclxuICBhdHRyaWJ1dGVzOiB7XHJcbiAgICBuYW1lOiB7XHJcbiAgICAgIHR5cGU6ICdzdHJpbmcnLFxyXG4gICAgICBkZWZhdWx0OiAnJyxcclxuICAgIH0sXHJcbiAgICBkb21haW46IHtcclxuICAgICAgdHlwZTogJ3N0cmluZycsXHJcbiAgICAgIGRlZmF1bHQ6ICcnLFxyXG4gICAgfSxcclxuICAgIHdpZHRoOiB7XHJcbiAgICAgIHR5cGU6ICdudW1iZXInLFxyXG4gICAgICBkZWZhdWx0OiAxMDgwLFxyXG4gICAgfSxcclxuICAgIGhlaWdodDoge1xyXG4gICAgICB0eXBlOiAnbnVtYmVyJyxcclxuICAgICAgZGVmYXVsdDogNzIwLFxyXG4gICAgfSxcclxuICAgIGZyb21HbG9iYWw6IHtcclxuICAgICAgdHlwZTogJ2Jvb2xlYW4nLFxyXG4gICAgICBkZWZhdWx0OiBmYWxzZSxcclxuICAgIH0sXHJcbiAgICBhdWRpb011dGVkOiB7XHJcbiAgICAgIHR5cGU6ICdib29sZWFuJyxcclxuICAgICAgZGVmYXVsdDogZmFsc2UsXHJcbiAgICB9LFxyXG4gICAgdmlkZW9NdXRlZDoge1xyXG4gICAgICB0eXBlOiAnYm9vbGVhbicsXHJcbiAgICAgIGRlZmF1bHQ6IHRydWUsXHJcbiAgICB9LFxyXG4gICAgc2NyZWVuU2hhcmluZzoge1xyXG4gICAgICB0eXBlOiAnYm9vbGVhbicsXHJcbiAgICAgIGRlZmF1bHQ6IGZhbHNlLFxyXG4gICAgfSxcclxuICAgIGludml0ZToge1xyXG4gICAgICB0eXBlOiAnYm9vbGVhbicsXHJcbiAgICAgIGRlZmF1bHQ6IHRydWUsXHJcbiAgICB9LFxyXG4gIH0sXHJcbiAgZWRpdDogRWRpdEJsb2NrLFxyXG4gIHNhdmU6IGZ1bmN0aW9uIChwcm9wcykge1xyXG4gICAgY29uc3Qge1xyXG4gICAgICBuYW1lLFxyXG4gICAgICBkb21haW4sXHJcbiAgICAgIHdpZHRoLFxyXG4gICAgICBoZWlnaHQsXHJcbiAgICAgIGF1ZGlvTXV0ZWQsXHJcbiAgICAgIHZpZGVvTXV0ZWQsXHJcbiAgICAgIHNjcmVlblNoYXJpbmcsXHJcbiAgICAgIGludml0ZSxcclxuICAgIH0gPSBwcm9wcy5hdHRyaWJ1dGVzO1xyXG5cclxuICAgIHJldHVybiAoXHJcbiAgICAgIDxkaXZcclxuICAgICAgICBjbGFzc05hbWU9XCJqaXRzaS13cmFwcGVyXCJcclxuICAgICAgICBkYXRhLW5hbWU9e25hbWV9XHJcbiAgICAgICAgZGF0YS1kb21haW49e2RvbWFpbn1cclxuICAgICAgICBkYXRhLXdpZHRoPXt3aWR0aH1cclxuICAgICAgICBkYXRhLWhlaWdodD17aGVpZ2h0fVxyXG4gICAgICAgIGRhdGEtbXV0ZT17YXVkaW9NdXRlZH1cclxuICAgICAgICBkYXRhLXZpZGVvbXV0ZT17dmlkZW9NdXRlZH1cclxuICAgICAgICBkYXRhLXNjcmVlbj17c2NyZWVuU2hhcmluZ31cclxuICAgICAgICBkYXRhLWludml0ZT17aW52aXRlfVxyXG4gICAgICAgIHN0eWxlPXt7XHJcbiAgICAgICAgICB3aWR0aDogYCR7d2lkdGh9cHhgLFxyXG4gICAgICAgIH19XHJcbiAgICAgID48L2Rpdj5cclxuICAgICk7XHJcbiAgfSxcclxufSk7XHJcbiIsIi8vIHJlbW92ZWQgYnkgZXh0cmFjdC10ZXh0LXdlYnBhY2stcGx1Z2luIiwiLy8gcmVtb3ZlZCBieSBleHRyYWN0LXRleHQtd2VicGFjay1wbHVnaW4iXSwic291cmNlUm9vdCI6IiJ9