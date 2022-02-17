import {
  fn_get_base_api_url,
  fn_get_base_api_detail_url,
} from '@app/api/utils/fn-helper'
import {
  API_GIAO_XUS_RESOURCE,
  API_GIAO_HATS_BY_GIAO_XUS_RESOURCE,
  API_GIAO_XUS_BY_ID_GIAO_HAT,
  API_GX_THUYEN_CHUYENS_RESOURCE,
} from 'store@admin/types/api-paths'


/**
 * [description]
 * @param  {[type]} infoId    [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiGetInfoGiaoXuById = (infoId, resolve, errResole) => {
  return axios.get(fn_get_base_api_detail_url(API_GIAO_XUS_RESOURCE, infoId))
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
    .catch(errors => {
      if (errors.response) {
        errResole(errors)
      }
    })
}

/**
 * [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @param  {[type]} params    [description]
 * @return {[type]}           [description]
 */
export const apiGetGiaoXuInfos = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_GIAO_XUS_RESOURCE), {
    params: params,
  })
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

/**
 * [description]
 * @param  {[type]} info      [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiUpdateInfo = (info, resolve, errResole) => {
  return axios.put(fn_get_base_api_detail_url(API_GIAO_XUS_RESOURCE, info.id), info)
    .then((response) => {
      if (response.status === 1000) {
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

/**
 * [description]
 * @param  {[type]} info      [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiInsertInfoGiaoXu = (info, resolve, errResole) => {
  return axios.post(fn_get_base_api_url(API_GIAO_XUS_RESOURCE), info)
    .then((response) => {
      if (response.status === 201) {
        var json = {}
        json['data'] = response.data.result
        json['code'] = response.data.code
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

/**
 * [description]
 * @param  {[type]} infoId    [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiDeleteInfo = (infoId, resolve, errResole) => {
  return axios.delete(fn_get_base_api_detail_url(API_GIAO_XUS_RESOURCE, infoId))
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

export const apiGetGiaoXuByIdGiaohat = (resolve, errResole, infoId) => {
  return axios.get(fn_get_base_api_detail_url(API_GIAO_XUS_BY_ID_GIAO_HAT, infoId))
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

export const apiGetGiaoHatInfos = (resolve, errResole) => {
  return axios.get(fn_get_base_api_url(API_GIAO_HATS_BY_GIAO_XUS_RESOURCE))
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

export const apiGetThuyenChuyenById = (infoId, resolve, errResole) => {
  return axios.get(fn_get_base_api_detail_url(API_GX_THUYEN_CHUYENS_RESOURCE, infoId))
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

export const apiUpdateGiaoXuThuyenChuyen = (info, resolve, errResole) => {
  return axios.put(fn_get_base_api_detail_url(API_GIAO_XUS_RESOURCE, info['giaoxuId']), info)
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