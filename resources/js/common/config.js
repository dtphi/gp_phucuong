const envBuild = process.env.NODE_ENV
const adminLocalPrefix = 'adminlocal'
const pathArray = (envBuild === 'production') ? process.env.MIX_APP_ADMIN_API_ROUTE_LOGIN.split(',') : []
const _adminPathName = (envBuild === 'production') ? pathArray[0] : adminLocalPrefix

let baseUrl = window.origin
if (envBuild == 'server-dev') {
  baseUrl = 'http://haydesachnoipodcast.com'
} else if(envBuild == 'production') {
  baseUrl = process.env.MIX_APP_URL
}

const langCode = 'vi_VN'
const existStatus = {
  checking: 'checking',
  exist: 'exit',
  notExist: 'notExist',
}
const fileTypes = ['file', 'image', 'media']
const referrerPolicy = 'strict-origin-when-cross-origin'
const toolbar2 = 'undo redo | styleselect | fontsizeselect | fontselect | image '
const fontFormats = 'Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats'

import {
  fn_get_tinymce_langs_url,
} from '@app/api/utils/fn-helper'

export const config = {
  site_name: 'GP-PhuCuong',
  baseUrl: baseUrl,
  existStatus: existStatus,
  carouselLimit: 5,
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
  dirImage: 'Image/NewPicture',
}

export const pluginConfig = {
  baseUrl: baseUrl,
  existStatus: existStatus,
  carouselLimit: 5,
  chucThanhs: ['--Chọn chức thánh--', 'Phó Tế', 'Linh Mục', 'Giám Mục'],
  loaiChucVus: ['Thuyên chuyển', 'Bổ nhiệm khác', 'Khác'],
  loaiDiaDiems: ['', 'Giáo Xứ', 'Cơ Sở Giáo Phận', 'Dòng', 'Ban Chuyên Trách'],
  trieuDongs: ['Tu Triều', 'Tu Dòng'],
  sortIcon: {
    is: 'glyphicon-sort',
    base: 'glyphicon',
    up: 'glyphicon-chevron-up',
    down: 'glyphicon-chevron-down',
  },
  slashDir: '/',
  adminPrefix: _adminPathName,
  dirImage: 'Image/NewPicture',
  mm: {
    api: {
      baseUrl: `${baseUrl}/api/mmedia`,
      listUrl: 'list',
      downloadUrl: 'download',
      uploadUrl: 'upload',
      deleteUrl: 'delete',
    },
    fileTypes: fileTypes,
    imagePrependUrl: `${baseUrl}/`,
    languageUrl: fn_get_tinymce_langs_url(langCode),
    height: '500',
    referrerPolicy: referrerPolicy,
    toolbar2: toolbar2,
    fontFormats: fontFormats,
  },
  tinymce: {
    options: (resolve) => {
      return {
        relative_urls: false,
        remove_script_host: false,
        document_base_url: `${baseUrl}/`,
        language_url: fn_get_tinymce_langs_url(langCode),
        height: '500',
        image_prepend_url: `${baseUrl}/`,
        referrer_policy: referrerPolicy,
        file_picker_callback: (callback, value, meta) => {
          if (fileTypes.includes(meta.filetype)) {
            resolve(callback)
          }
        },
        toolbar2: toolbar2,
        fontFormats: fontFormats
      }
    }
  },
  tagLimit: 15
} 