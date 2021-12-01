"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.apiChangeStatus = exports.apiSearchAlbums = exports.apiDeleteAlbums = exports.apiInsertAlbums = exports.apiUpdateAlbums = exports.apiGetAllAlbums = exports.apiGetAlbumsById = void 0;

var _fnHelper = require("@app/api/utils/fn-helper");

var _apiPaths = require("store@admin/types/api-paths");

var _axios = _interopRequireDefault(require("axios"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

var apiGetAlbumsById = function apiGetAlbumsById(infoId, resolve, errResole) {
  return _axios["default"].get((0, _fnHelper.fn_get_base_api_detail_url)(_apiPaths.API_ALBUMS_RESOURCE, infoId)).then(function (response) {
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

exports.apiGetAlbumsById = apiGetAlbumsById;

var apiGetAllAlbums = function apiGetAllAlbums(resolve, errResole, params) {
  return _axios["default"].get((0, _fnHelper.fn_get_base_api_url)(_apiPaths.API_ALBUMS_RESOURCE), {
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

exports.apiGetAllAlbums = apiGetAllAlbums;

var apiUpdateAlbums = function apiUpdateAlbums(info, resolve, errResole) {
  return _axios["default"].put((0, _fnHelper.fn_get_base_api_detail_url)(_apiPaths.API_ALBUMS_RESOURCE, info.data.id), info).then(function (response) {
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

exports.apiUpdateAlbums = apiUpdateAlbums;

var apiInsertAlbums = function apiInsertAlbums(info, resolve, errResole) {
  return _axios["default"].post((0, _fnHelper.fn_get_base_api_url)(_apiPaths.API_ALBUMS_RESOURCE), info).then(function (response) {
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

exports.apiInsertAlbums = apiInsertAlbums;

var apiDeleteAlbums = function apiDeleteAlbums(infoId, resolve, errResole) {
  return _axios["default"]["delete"]((0, _fnHelper.fn_get_base_api_detail_url)(_apiPaths.API_ALBUMS_RESOURCE, infoId)).then(function (response) {
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

exports.apiDeleteAlbums = apiDeleteAlbums;
var CancelToken = _axios["default"].CancelToken;
var cancel;

var apiSearchAlbums = function apiSearchAlbums(resolve, errResole, query) {
  if (cancel != undefined) {
    cancel();
  }

  _axios["default"].get((0, _fnHelper.fn_get_base_api_url)(_apiPaths.API_ALBUMS_SEARCH_RESOURCE), {
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


exports.apiSearchAlbums = apiSearchAlbums;

var apiChangeStatus = function apiChangeStatus(info, resolve, errResole) {
  return _axios["default"].post((0, _fnHelper.fn_get_base_api_url)(_apiPaths.API_CHANGE_STATUS_ALBUMS), info).then(function (response) {
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