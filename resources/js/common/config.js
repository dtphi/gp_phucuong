const envBuild = process.env.NODE_ENV
const pathArray = (envBuild === 'production') ? process.env.MIX_APP_ADMIN_API_ROUTE_LOGIN.split(',') : []
const _adminPathName = (envBuild === 'production') ? pathArray[0] : 'adminlocal'

let baseUrl = window.origin
if (envBuild == 'server-dev') {
  baseUrl = 'http://haydesachnoipodcast.com'
} else if(envBuild == 'production') {
  baseUrl = 'http://localhost:8000'
}

const existStatus = {
  checking: 'checking',
  exist: 'exit',
  notExist: 'notExist',
}

import {
  fn_get_tinymce_langs_url,
} from '@app/api/utils/fn-helper'

export const config = {
  site_name: 'GP-PhuCuong',
  baseUrl: baseUrl,
  existStatus: existStatus,
  site_name: 'GP-PhuCuong',
  carouselLimit: 5,
  chucThanhs: ['--Chọn chức thánh--', 'Phó Tế', 'Linh Mục', 'Giám Mục'],
  loaiChucVus: ['--Chọn--', 'Loại 1', 'Loại 2', 'Loại 3'],
  trieuDongs: ['Tu Triều', 'Tu Dòng'],
  sortIcon: {
    is: 'glyphicon-sort',
    base: 'glyphicon',
    up: 'glyphicon-chevron-up',
    down: 'glyphicon-chevron-down',
  },
  slashDir: '/',
  adminPrefix: _adminPathName,
  adminRoute: {
    login: {
      path: 'login',
      name: `${_adminPathName}.auth.login`,
    },
    phone_verify: {
      path: 'phone-verify',
      name: `${_adminPathName}.auth.login.phone.verify`,
    },
    dashboard: {
      path: 'dashboards',
      name: `${_adminPathName}'.dashboards`,
    },
    redirectLogedUrl: `${_adminPathName}/dashboards`,
    redirectLogoutUrl: `${_adminPathName}/login`,
    redirectPhoneLoginUrl: `${_adminPathName}/phone-verify`,
    storageLinhMucExpectSignInKey: 'linhMuc.expectSignIn',
    storageLinhMucExpectSignInPhoneKey: 'linhMuc.expectSignInPhone',
    history: true,
    mode: 'history',
  },
  mm: {
    api: {
      baseUrl: `${window.origin}/api/mmedia`,
      listUrl: 'list',
      downloadUrl: 'download',
      uploadUrl: 'upload',
      deleteUrl: 'delete',
    },
    fileTypes: ['file', 'image', 'media'],
    imagePrependUrl: window.origin + '/',
    languageUrl: fn_get_tinymce_langs_url('vi_VN'),
    height: '500',
    referrerPolicy: 'strict-origin-when-cross-origin',
    toolbar2: 'undo redo | styleselect | fontsizeselect | fontselect | image ',
    fontFormats: 'Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats',
  },
}