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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(2);


/***/ }),
/* 1 */
/***/ (function(module, exports) {

throw new Error("Module build failed: SyntaxError: C:\\xampp\\htdocs\\deploy\\pto_venta\\resources\\js\\app.js: Unexpected token (45:0)\n\n\u001b[0m \u001b[90m 43 | \u001b[39m  { path\u001b[33m:\u001b[39m \u001b[32m'/articulos'\u001b[39m\u001b[33m,\u001b[39m component\u001b[33m:\u001b[39m require(\u001b[32m'./components/Articulos.vue'\u001b[39m) }\u001b[33m,\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 44 | \u001b[39m  { path\u001b[33m:\u001b[39m \u001b[32m'/inventarios/:id'\u001b[39m\u001b[33m,\u001b[39m name\u001b[33m:\u001b[39m\u001b[32m'articulo'\u001b[39m\u001b[33m,\u001b[39m component\u001b[33m:\u001b[39m require(\u001b[32m'./components/Inventarios.vue'\u001b[39m) }\u001b[33m,\u001b[39m\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 45 | \u001b[39m\u001b[33m<<\u001b[39m\u001b[33m<<\u001b[39m\u001b[33m<<\u001b[39m\u001b[33m<\u001b[39m \u001b[33mHEAD\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m    | \u001b[39m\u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 46 | \u001b[39m  { path\u001b[33m:\u001b[39m \u001b[32m'/suppliers'\u001b[39m\u001b[33m,\u001b[39m component\u001b[33m:\u001b[39m require(\u001b[32m'./components/Suppliers.vue'\u001b[39m) }\u001b[33m,\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 47 | \u001b[39m  { path\u001b[33m:\u001b[39m \u001b[32m'/marcas'\u001b[39m\u001b[33m,\u001b[39m component\u001b[33m:\u001b[39m require(\u001b[32m'./components/Marcas.vue'\u001b[39m) }\u001b[33m,\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 48 | \u001b[39m\u001b[33m===\u001b[39m\u001b[33m===\u001b[39m\u001b[33m=\u001b[39m\u001b[0m\n    at Parser.raise (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:4028:15)\n    at Parser.unexpected (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:5359:16)\n    at Parser.parseExprAtom (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:6518:20)\n    at Parser.parseExprSubscripts (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:6081:21)\n    at Parser.parseMaybeUnary (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:6060:21)\n    at Parser.parseExprOps (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:5945:21)\n    at Parser.parseMaybeConditional (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:5917:21)\n    at Parser.parseMaybeAssign (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:5864:21)\n    at Parser.parseExprListItem (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:7199:18)\n    at Parser.parseExprList (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:7179:22)\n    at Parser.parseExprAtom (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:6455:30)\n    at Parser.parseExprSubscripts (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:6081:21)\n    at Parser.parseMaybeUnary (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:6060:21)\n    at Parser.parseExprOps (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:5945:21)\n    at Parser.parseMaybeConditional (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:5917:21)\n    at Parser.parseMaybeAssign (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:5864:21)\n    at Parser.parseVar (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:8123:26)\n    at Parser.parseVarStatement (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:7937:10)\n    at Parser.parseStatementContent (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:7528:21)\n    at Parser.parseStatement (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:7478:17)\n    at Parser.parseBlockOrModuleBlockBody (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:8046:23)\n    at Parser.parseBlockBody (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:8033:10)\n    at Parser.parseTopLevel (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:7443:10)\n    at Parser.parse (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:8876:17)\n    at parse (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\parser\\lib\\index.js:10907:38)\n    at parser (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\core\\lib\\transformation\\normalize-file.js:170:34)\n    at normalizeFile (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\core\\lib\\transformation\\normalize-file.js:138:11)\n    at runSync (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\core\\lib\\transformation\\index.js:44:43)\n    at runAsync (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\core\\lib\\transformation\\index.js:35:14)\n    at process.nextTick (C:\\xampp\\htdocs\\deploy\\pto_venta\\node_modules\\@babel\\core\\lib\\transform.js:34:34)");

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);