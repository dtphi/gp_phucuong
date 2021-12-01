"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _add = _interopRequireDefault(require("./add"));

var _edit = _interopRequireDefault(require("./edit"));

var _restrictip = require("api@admin/restrictip");

var _moduleTypes = require("../types/module-types");

var _mutationTypes = require("../types/mutation-types");

var _actionTypes = require("../types/action-types");

var _fnHelper = require("@app/api/utils/fn-helper");

var _mutations, _actions;

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var defaultState = function defaultState() {
  return {
    infos: [],
    total: 0,
    isDelete: false,
    isList: false,
    loading: false,
    updateSuccess: false,
    errors: []
  };
};

var _default = {
  namespaced: true,
  state: defaultState(),
  getters: {
    infos: function infos(state) {
      return state.infos;
    },
    loading: function loading(state) {
      return state.loading;
    },
    errors: function errors(state) {
      return state.errors;
    },
    isError: function isError(state) {
      return state.errors.length;
    }
  },
  mutations: (_mutations = {}, _defineProperty(_mutations, _mutationTypes.MODULE_UPDATE_SETTING_SUCCESS, function (state, payload) {
    state.updateSuccess = payload;
  }), _defineProperty(_mutations, _mutationTypes.MODULE_UPDATE_SETTING_FAILED, function (state, payload) {
    state.updateSuccess = payload;
  }), _defineProperty(_mutations, _mutationTypes.INFOS_SET_INFO_LIST, function (state, payload) {
    state.infos = payload;
  }), _defineProperty(_mutations, _mutationTypes.INFOS_SET_INFO_DELETE_BY_ID_FAILED, function (state, payload) {
    state.isDelete = payload;
  }), _defineProperty(_mutations, _mutationTypes.INFOS_SET_INFO_DELETE_BY_ID_SUCCESS, function (state, payload) {
    state.isDelete = payload;
  }), _defineProperty(_mutations, _mutationTypes.INFOS_GET_INFO_LIST_SUCCESS, function (state, payload) {
    state.isList = payload;
  }), _defineProperty(_mutations, _mutationTypes.INFOS_GET_INFO_LIST_FAILED, function (state, payload) {
    state.isList = payload;
  }), _defineProperty(_mutations, _mutationTypes.INFOS_DELETE_INFO_BY_ID_SUCCESS, function (state, payload) {
    state.isDelete = payload;
  }), _defineProperty(_mutations, _mutationTypes.INFOS_DELETE_INFO_BY_ID_FAILED, function (state, payload) {
    state.isDelete = false;
    state.errors = payload;
  }), _defineProperty(_mutations, _mutationTypes.INFOS_SET_LOADING, function (state, payload) {
    state.loading = payload;
  }), _defineProperty(_mutations, _mutationTypes.INFOS_SET_ERROR, function (state, payload) {
    state.errors = payload;
  }), _mutations),
  actions: (_actions = {}, _defineProperty(_actions, _actionTypes.ACTION_GET_INFO_LIST, function _callee(_ref, params) {
    var dispatch, commit;
    return regeneratorRuntime.async(function _callee$(_context) {
      while (1) {
        switch (_context.prev = _context.next) {
          case 0:
            dispatch = _ref.dispatch, commit = _ref.commit;
            dispatch(_actionTypes.ACTION_SET_LOADING, true);
            _context.next = 4;
            return regeneratorRuntime.awrap((0, _restrictip.apiGetAllRestrictIp)(function (infos) {
              commit(_mutationTypes.INFOS_SET_INFO_LIST, infos.data.results);
              commit(_mutationTypes.INFOS_GET_INFO_LIST_SUCCESS, true);
              var pagination = {
                current_page: 1,
                total: 0
              };

              if (infos.data.hasOwnProperty('pagination')) {
                pagination = infos.data.pagination;
              }

              var configs = {
                moduleActive: {
                  name: _moduleTypes.MODULE_MODULE_RESTRICT_IP,
                  actionList: _actionTypes.ACTION_GET_INFO_LIST
                },
                collectionData: pagination
              };
              dispatch('setConfigApp', configs, {
                root: true
              });
            }, function (errors) {
              commit(_mutationTypes.INFOS_GET_INFO_LIST_FAILED, errors);
            }, params));

          case 4:
            dispatch(_actionTypes.ACTION_SET_LOADING, false);

          case 5:
          case "end":
            return _context.stop();
        }
      }
    });
  }), _defineProperty(_actions, _actionTypes.ACTION_DELETE_RESTRICT_IP_BY_ID, function _callee2(_ref2, infoId) {
    var dispatch, commit;
    return regeneratorRuntime.async(function _callee2$(_context2) {
      while (1) {
        switch (_context2.prev = _context2.next) {
          case 0:
            dispatch = _ref2.dispatch, commit = _ref2.commit;
            _context2.next = 3;
            return regeneratorRuntime.awrap((0, _restrictip.apiDeleteResIp)(infoId, function (results) {
              commit(_mutationTypes.INFOS_SET_INFO_DELETE_BY_ID_SUCCESS, true); //dispatch(ACTION_GET_INFO_LIST)
            }, function (errors) {
              commit(_mutationTypes.INFOS_SET_INFO_DELETE_BY_ID_FAILED, false);
            }));

          case 3:
          case "end":
            return _context2.stop();
        }
      }
    });
  }), _defineProperty(_actions, _actionTypes.ACTION_CHANGE_STATUS, function (_ref3, info) {
    var dispatch = _ref3.dispatch;
    (0, _restrictip.apiChangeStatus)(info, function (result) {//dispatch(ACTION_GET_INFO_LIST, { perPage: info.perPage });
    }, function (errors) {});
  }), _defineProperty(_actions, "ACTION_RELOAD_GET_INFO_LIST_RESTRICT_IP", {
    root: true,
    handler: function handler(namespacedContext, payload) {
      if (isNaN(payload)) {
        return (0, _fnHelper.fn_redirect_url)('admin/restrict-ips');
      } else {
        namespacedContext.dispatch(_actionTypes.ACTION_GET_INFO_LIST);
      }
    }
  }), _defineProperty(_actions, _actionTypes.ACTION_SEARCH_ITEMS, function (_ref4, query) {
    var commit = _ref4.commit;
    (0, _restrictip.apiSearchResIp)(function (response) {
      commit(_mutationTypes.INFOS_SET_INFO_LIST, response.data.results);
    }, function (errors) {
      commit(_mutationTypes.INFOS_GET_INFO_LIST_FAILED, errors);
    }, query);
  }), _defineProperty(_actions, _actionTypes.ACTION_SET_LOADING, function (_ref5, isLoading) {
    var commit = _ref5.commit;
    commit(_mutationTypes.INFOS_SET_LOADING, isLoading);
  }), _defineProperty(_actions, _actionTypes.ACTION_RESET_NOTIFICATION_INFO, function (_ref6, values) {
    var commit = _ref6.commit;
    commit(_mutationTypes.MODULE_UPDATE_SETTING_SUCCESS, values);
  }), _actions),
  modules: {
    add: _add["default"],
    edit: _edit["default"]
  }
};
exports["default"] = _default;