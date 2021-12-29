'use strict'

Object.defineProperty(exports, '__esModule', {
  value: true,
})
exports.config = void 0
var envBuild = process.env.NODE_ENV
var pathArray = envBuild === 'production' ? process.env.MIX_APP_ADMIN_API_ROUTE_LOGIN.split(',') : []

var _adminPathName = envBuild === 'production' ? pathArray[0] : 'adminlocal'

var baseUrl = window.origin

if (envBuild == 'server') {
  baseUrl = 'http://haydesachnoipodcast.com'
}

var existStatus = {
  checking: 'checking',
  exist: 'exit',
  notExist: 'notExist',
}
var config = {
  site_name: 'GP-PhuCuong',
  baseUrl: baseUrl,
  existStatus: existStatus,
  adminPrefix: _adminPathName,
}
exports.config = config