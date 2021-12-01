"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _vue = _interopRequireDefault(require("vue"));

var _vuex = _interopRequireDefault(require("vuex"));

var _auth = _interopRequireDefault(require("./auth"));

var _layout = _interopRequireDefault(require("./layout"));

var _dashboad = _interopRequireDefault(require("./dashboad"));

var _users = _interopRequireDefault(require("./users"));

var _infos = _interopRequireDefault(require("./infos"));

var _categories = _interopRequireDefault(require("./categories"));

var _modules = _interopRequireDefault(require("./modules"));

var _linhmucs = _interopRequireDefault(require("./linhmucs"));

var _linhmucbangcaps = _interopRequireDefault(require("./linhmucbangcaps"));

var _linhmucchucthanhs = _interopRequireDefault(require("./linhmucchucthanhs"));

var _linhmucvanthus = _interopRequireDefault(require("./linhmucvanthus"));

var _linhmucthuyenchuyens = _interopRequireDefault(require("./linhmucthuyenchuyens"));

var _giaophans = _interopRequireDefault(require("./giaophans"));

var _giaohats = _interopRequireDefault(require("./giaohats"));

var _giaoxus = _interopRequireDefault(require("./giaoxus"));

var _giaodiems = _interopRequireDefault(require("./giaodiems"));

var _congdoantusis = _interopRequireDefault(require("./congdoantusis"));

var _dongs = _interopRequireDefault(require("./dongs"));

var _cosos = _interopRequireDefault(require("./cosos"));

var _banchuyentrachs = _interopRequireDefault(require("./banchuyentrachs"));

var _thanhs = _interopRequireDefault(require("./thanhs"));

var _chucvus = _interopRequireDefault(require("./chucvus"));

var _lechinhs = _interopRequireDefault(require("./lechinhs"));

var _restrictips = _interopRequireDefault(require("./restrictips"));

var _albums = _interopRequireDefault(require("./albums"));

var _giaophandanhmucs = _interopRequireDefault(require("./giaophandanhmucs"));

var _giaophantintucs = _interopRequireDefault(require("./giaophantintucs"));

var _logger = _interopRequireDefault(require("../../plugins/logger"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

_vue["default"].use(_vuex["default"]);

var debug = process.env.NODE_ENV === 'debuger';

var fnIsObject = function fnIsObject(obj) {
  if (typeof obj !== "undefined" && _typeof(obj) === "object" && Object.keys(obj).length) {
    return true;
  }

  return false;
};

var defaultState = function defaultState() {
  return {
    errors: [],
    links: {},
    meta: {},
    perPage: 15,
    moduleActive: {
      name: '',
      actionList: ''
    },
    logo: '/front/img/logo.png',
    collectionData: {
      current_page: 1,
      from: 0,
      to: 0,
      total: 0
    }
  };
};

var _default = new _vuex["default"].Store({
  state: {
    cfApp: defaultState()
  },
  getters: {
    resourcePaginationData: function resourcePaginationData(state) {
      return {
        links: state.cfApp.links,
        meta: state.cfApp.meta
      };
    },
    collectionPaginationData: function collectionPaginationData(state) {
      var colData = {
        current_page: 1,
        from: 0,
        to: 0,
        total: 0
      };

      if (fnIsObject(state.cfApp.collectionData)) {
        return state.cfApp.collectionData;
      }

      return colData;
    },
    isNotEmptyList: function isNotEmptyList(state) {
      if (fnIsObject(state.cfApp.meta) && state.cfApp.meta.hasOwnProperty('total')) {
        return parseInt(state.cfApp.meta.total) > 0;
      }

      return false;
    },
    moduleNameActive: function moduleNameActive(state) {
      var mName = '';

      if (fnIsObject(state.cfApp.moduleActive) && state.cfApp.moduleActive.hasOwnProperty('name')) {
        mName = state.cfApp.moduleActive.name;
      }

      return mName;
    },
    moduleActionListActive: function moduleActionListActive(state) {
      var mAction = '';

      if (fnIsObject(state.cfApp.moduleActive) && state.cfApp.moduleActive.hasOwnProperty('actionList')) {
        mAction = state.cfApp.moduleActive.actionList;
      }

      return mAction;
    }
  },
  mutations: {
    configApp: function configApp(state, configs) {
      if (fnIsObject(configs.links)) {
        state.cfApp.links = configs.links;
      }

      if (fnIsObject(configs.meta)) {
        state.cfApp.meta = configs.meta;
      }

      if (fnIsObject(configs.moduleActive)) {
        state.cfApp.moduleActive = configs.moduleActive;
      }

      if (fnIsObject(configs.collectionData)) {
        state.cfApp.collectionData = configs.collectionData;
      }
    }
  },
  actions: {
    setConfigApp: function setConfigApp(_ref, configs) {
      var commit = _ref.commit;
      var links = configs.hasOwnProperty('links') ? configs.links : undefined;
      var meta = configs.hasOwnProperty('meta') ? configs.meta : undefined;
      var moduleActive = configs.hasOwnProperty('moduleActive') ? configs.moduleActive : undefined;
      var collectionData = configs.hasOwnProperty('collectionData') ? configs.collectionData : undefined;

      var _configs = _objectSpread({}, defaultState(), {}, {
        links: links,
        meta: meta,
        moduleActive: moduleActive,
        collectionData: collectionData
      });

      commit('configApp', _configs);
    }
  },
  modules: {
    auth: _auth["default"],
    layout: _layout["default"],
    dashboard: _dashboad["default"],
    user: _users["default"],
    info: _infos["default"],
    news_category: _categories["default"],
    app_module: _modules["default"],
    linh_muc: _linhmucs["default"],
    bang_cap: _linhmucbangcaps["default"],
    chuc_thanh: _linhmucchucthanhs["default"],
    van_thu: _linhmucvanthus["default"],
    thuyen_chuyen: _linhmucthuyenchuyens["default"],
    giao_phan: _giaophans["default"],
    giao_hat: _giaohats["default"],
    giao_xu: _giaoxus["default"],
    giao_diem: _giaodiems["default"],
    cong_doan_tu_si: _congdoantusis["default"],
    dong: _dongs["default"],
    co_so: _cosos["default"],
    ban_chuyen_trach: _banchuyentrachs["default"],
    thanh: _thanhs["default"],
    chuc_vu: _chucvus["default"],
    le_chinh: _lechinhs["default"],
    danhmuc_giaophan: _giaophandanhmucs["default"],
    tintuc_giaophan: _giaophantintucs["default"],
    restrict_ip: _restrictips["default"],
    albums: _albums["default"]
  },
  strict: debug,
  plugins: debug ? [(0, _logger["default"])()] : []
});

exports["default"] = _default;