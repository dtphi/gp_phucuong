import {
  fn_get_base_api_url,
  fn_get_base_api_detail_url,
} from '@app/api/utils/fn-helper'
import {
  API_LINH_MUC_DETAIL,
  API_LINH_MUC_DETAIL_UPDATE,
  API_LINH_MUC_LIST,
  API_CHUC_VU_LIST,
  API_LINH_MUC_LIST_BY_ID,
  API_UPDATE_LINH_MUC_TEMP,
  API_HOAT_DONG_SU_VU
} from 'store@front/types/api-paths'

export const apiGetLists = (resolve, errResole, params) => {	
  return axios.get(fn_get_base_api_url(API_LINH_MUC_LIST), {
    params: params,
  }).then((response) => {
    if (response.status === 200) {
      resolve(response.data)
    } else {
      errResole([{
        status: response.status,
        msg: 'error test',
      }])
    }
  })
    .catch(errors => errResole(errors))
}
export const apiGetDetail = (infoId, resolve, errResole, params) => {
  return axios.get(fn_get_base_api_detail_url(API_LINH_MUC_DETAIL, infoId), {
    params: params,
  }).then((response) => {
    if (response.status === 200) {
      resolve(response)
    } else {
      errResole([{
        status: response.status,
        msg: 'error test',
      }])
    }
  })
    .catch(errors => errResole(errors))
}

export const apiGetListsChucVu = (resolve, errResole) => {
  return axios.get(fn_get_base_api_url(API_CHUC_VU_LIST))
    .then((response) => {
      if (response.status === 200) {
        resolve({
          data: response.data.data,
        })
      } else {
        errResole([{
          status: response.status,
          msg: 'error test',
        }])
      }
    })
    .catch(errors => {
      if (errors.response) {
        errResole([{
          status: errors.response.status,
          messageCommon: errors.response.data.message,
          messages: errors.response.data.errors,
        }])
      }
    })
}

export const apiGetListsLinhMuc = (resolve, errResole, options) => {
  return axios.post(fn_get_base_api_url(API_LINH_MUC_LIST_BY_ID), {
    id_chucvu : options.id_chucvu,
    id_giaohat: options.id_giaohat,
    page : options.page,
    query : options.query,
  }).then((response) => {
    if (response.status === 200) {  
      resolve({
        data: response.data.data,
      })
    } else {
      errResole([{
        status: response.status,
        msg: 'error test',
      }])
    }
  })
    .catch(errors => {
      if (errors.response) {
        errResole([{
          status: errors.response.status,
          messageCommon: errors.response.data.message,
          messages: errors.response.data.errors,
        }])
      }
    })
}

export const apiLinhMucUpdateById = (infoId, resolve, errResole) => {
  return axios.get(fn_get_base_api_detail_url(API_LINH_MUC_DETAIL_UPDATE, infoId))
    .then((response) => {
    if (response.status === 200) {
      resolve(response)
    } else {
      errResole([{
        status: response.status,
        msg: 'error test',
      }])
    }
  })
    .catch(errors => errResole(errors))
}

export const apiUpdateLinhMucTemp = (info, resolve, errResole) => {
  return axios.post(fn_get_base_api_url(API_UPDATE_LINH_MUC_TEMP), info) 
    .then((response) => {
      if (response.status === 200) {
        var json = {}
        json['data'] = response.data
        json['status'] = 1000
        resolve(json)
      } else {
        errResole([{
          status: response.status,
          msg: 'error test',
        }])
      }
    })
    .catch(errors => errResole(errors))
}

export const apiGetHoatDongSuVu = (infoId, resolve, errResole) => {
  return axios.get(fn_get_base_api_detail_url(API_HOAT_DONG_SU_VU, infoId))
    .then((response) => {
      if (response.status === 200) {
        var json = {}
        json['data'] = response.data.data
        json['status'] = 1000
        resolve(json)
      } else {
        errResole([{
          status: response.status,
          msg: 'error test',
        }])
      }
    })
    .catch(errors => {
      if (errors.response) {
        errResole(errors)
      }
    })
}

export const apiGetDropdownCategories = (params, resolve, errResole) => {
  return axios.get(fn_get_base_api_url('/api/app/dropdown-categories'), {
    params: params,
  })
    .then((response) => {
      if (response.status === 200) {
        resolve(response.data)
      } else {
        errResole([{
          status: response.status,
          msg: 'error test',
        }])
      }
    })
    .catch(errors => errResole(errors))
}

export const apiAddThuyenChuyen = (params, resolve, errResole) => {
  return axios.get(fn_get_base_api_url('/api/app/add-thuyen-chuyen'), {
    params: params,
  })
    .then((response) => {
      if (response.status === 200) {
        resolve(response.data)
      } else {
        errResole([{
          status: response.status,
          msg: 'error test',
        }])
      }
    })
    .catch(errors => errResole(errors))
}
