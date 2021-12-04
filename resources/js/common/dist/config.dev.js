"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.config = void 0;
var envBuild = process.env.NODE_ENV;
var pathArray = envBuild === "production" ? process.env.MIX_APP_ADMIN_API_ROUTE_LOGIN.split(",") : [];

var _adminPathName = envBuild === "production" ? pathArray[0] : "adminlocal";

var config = {
  site_name: 'GP-PhuCuong',
  carouselLimit: 5,
  chucThanhs: ['--Chọn chức thánh--', 'Phó Tế', 'Linh Mục', 'Giám Mục'],
  loaiChucVus: ['--Chọn--', 'Loại 1', 'Loại 2', 'Loại 3'],
  trieuDongs: ['Tu Triều', 'Tu Dòng'],
  sortIcon: {
    is: "glyphicon-sort",
    base: "glyphicon",
    up: "glyphicon-chevron-up",
    down: "glyphicon-chevron-down"
  },
  slashDir: "/",
  adminPrefix: _adminPathName,
  adminRoute: {
    login: {
      path: 'login',
      name: _adminPathName + '.auth.login'
    },
    phone_verify: {
      path: 'phone-verify',
      name: _adminPathName + '.auth.login.phone.verify'
    },
    dashboard: {
      path: 'dashboards',
      name: _adminPathName + '.dashboards'
    },
    redirectLogedUrl: _adminPathName + "/dashboards",
    redirectLogoutUrl: _adminPathName + "/login",
    redirectPhoneLoginUrl: _adminPathName + "/phone-verify",
    storageLinhMucExpectSignInKey: 'linhMuc.expectSignIn',
    storageLinhMucExpectSignInPhoneKey: 'linhMuc.expectSignInPhone',
    history: true,
    mode: 'history'
  }
};
exports.config = config;