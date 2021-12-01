"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.apiChangeStatus = exports.apiSearchResIp = exports.apiDeleteResIp = exports.apiInsertResIp = exports.apiUpdateResIp = exports.apiGetAllRestrictIp = exports.apiGetResIpById = void 0;

var _fnHelper = require("@app/api/utils/fn-helper");

var _apiPaths = require("store@admin/types/api-paths");

var _axios = _interopRequireDefault(require("axios"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

/* GET BY ID RESTRICT IPS */
var apiGetResIpById = function apiGetResIpById(infoId, resolve, errResole) {
  return _axios["default"].get((0, _fnHelper.fn_get_base_api_detail_url)(_apiPaths.API_RESTRICT_IPS_RESOURCE, infoId)).then(function (response) {
    if (response.status === 200) {
      var json = {};
      json['data'] = response.data;
      json['status'] = 200;
      resolve(json);
    } else {
      errResole([{
        status: response.status,
        msg: 'error test'
      }]);
    }
  })["catch"](function (errors) {
    if (errors.response) {
      errResole(errors);
    }
  });
};
/* GET ALL RESTRICT IPS */


exports.apiGetResIpById = apiGetResIpById;

var apiGetAllRestrictIp = function apiGetAllRestrictIp(resolve, errResole, params) {
  return _axios["default"].get((0, _fnHelper.fn_get_base_api_url)(_apiPaths.API_RESTRICT_IPS_RESOURCE), {
    params: params
  }).then(function (response) {
    if (response.status === 200) {
      resolve({
        data: response.data.data
      });
    } else {
      errResole([{
        status: response.status,
        msg: 'error test'
      }]);
    }
  })["catch"](function (errors) {
    if (errors.response) {
      errResole([{
        status: errors.response.status,
        messageCommon: errors.response.data.message,
        messages: errors.response.data.errors
      }]);
    }
  });
};
/* RESTRICT IPS UPDATE */


exports.apiGetAllRestrictIp = apiGetAllRestrictIp;

var apiUpdateResIp = function apiUpdateResIp(info, resolve, errResole) {
  return _axios["default"].put((0, _fnHelper.fn_get_base_api_detail_url)(_apiPaths.API_RESTRICT_IPS_RESOURCE, info.data.id), info).then(function (response) {
    if (response.status === 200) {
      var json = {};
      json['data'] = response.data;
      json['status'] = 1000;
      resolve(json);
    } else {
      errResole([{
        status: response.status,
        msg: 'error test'
      }]);
    }
  })["catch"](function (errors) {
    return errResole(errors);
  });
};
/* RESTRICT IPS INSERT */


exports.apiUpdateResIp = apiUpdateResIp;

var apiInsertResIp = function apiInsertResIp(info, resolve, errResole) {
  return _axios["default"].post((0, _fnHelper.fn_get_base_api_url)(_apiPaths.API_RESTRICT_IPS_RESOURCE), info).then(function (response) {
    if (response.status === 201) {
      var json = {};
      json['data'] = response.data.result;
      json['code'] = response.data.code;
      resolve(json);
    } else {
      errResole([{
        status: response.status,
        msg: 'error test'
      }]);
    }
  })["catch"](function (errors) {
    return errResole(errors);
  });
};
/* RESTRICT IPS DELETE */


exports.apiInsertResIp = apiInsertResIp;

var apiDeleteResIp = function apiDeleteResIp(infoId, resolve, errResole) {
  return _axios["default"]["delete"]((0, _fnHelper.fn_get_base_api_detail_url)(_apiPaths.API_RESTRICT_IPS_RESOURCE, infoId)).then(function (response) {
    if (response.status === 200) {
      var json = {};
      json['data'] = response.data;
      json['status'] = 1000;
      resolve(json);
    } else {
      errResole([{
        status: response.status,
        msg: 'error test'
      }]);
    }
  })["catch"](function (errors) {
    return errResole(errors);
  });
};

exports.apiDeleteResIp = apiDeleteResIp;
var CancelToken = _axios["default"].CancelToken;
var cancel;
/* RESTRICT IPS SEARCH */

var apiSearchResIp = function apiSearchResIp(resolve, errResole, query) {
  if (cancel != undefined) {
    cancel();
  }

  _axios["default"].get((0, _fnHelper.fn_get_base_api_url)(_apiPaths.API_RESTRICT_IPS_SEARCH_RESOURCE), {
    params: {
      query: query
    },
    cancelToken: new CancelToken(function executor(c) {
      // An executor function receives a cancel function as a parameter
      cancel = c;
    })
  }).then(function (response) {
    if (response.status === 200) {
      var json = {};
      json['data'] = response.data.data;
      resolve(json);
    } else {
      errResole([{
        msg: 'error test'
      }]);
    }
  })["catch"](function (errors) {
    console.log(errors);
  });
};
/* CHANGE STATUS */


exports.apiSearchResIp = apiSearchResIp;

var apiChangeStatus = function apiChangeStatus(info, resolve, errResole) {
  return _axios["default"].post((0, _fnHelper.fn_get_base_api_url)(_apiPaths.API_CHANGE_STATUS_IP), info).then(function (response) {
    if (response.status === 200) {
      var json = {};
      json['data'] = response.data;
      json['status'] = 1000;
      resolve(json);
    } else {
      errResole([{
        status: response.status,
        msg: 'error test'
      }]);
    }
  })["catch"](function (errors) {
    return errResole(errors);
  }); //apiChangeStatus
};

exports.apiChangeStatus = apiChangeStatus;