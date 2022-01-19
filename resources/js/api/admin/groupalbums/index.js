import {
  fn_get_base_api_url,
  fn_get_base_api_detail_url,
} from '@app/api/utils/fn-helper'
import {
  API_GROUP_ALBUMS_RESOURCE,
  API_GROUP_ALBUMS_SEARCH_RESOURCE,
  API_CHANGE_STATUS_GROUP_ALBUMS,
} from 'store@admin/types/api-paths'
import axios from 'axios'

/* GET BY ID RESTRICT IPS */
export const apiGetGroupAlbumsById = (infoId, resolve, errResole) => {
  return axios.get(fn_get_base_api_detail_url(API_GROUP_ALBUMS_RESOURCE, infoId))
    .then((response) => {
      if (response.status === 200) {
        var json = {}
        json['data'] = response.data
        json['status'] = 200
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

export const apiGetAllGroupAlbums = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_GROUP_ALBUMS_RESOURCE), {
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

export const apiUpdateGroupAlbums = (info, resolve, errResole) => {
  return axios.put(fn_get_base_api_detail_url(API_GROUP_ALBUMS_RESOURCE, info.data.id), info)
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

export const apiInsertGroupAlbums = (info, resolve, errResole) => {
  return axios.post(fn_get_base_api_url(API_GROUP_ALBUMS_RESOURCE), info)
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

export const apiDeleteGroupAlbums = (infoId, resolve, errResole) => {
  return axios.delete(fn_get_base_api_detail_url(API_GROUP_ALBUMS_RESOURCE, infoId))
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
const CancelToken = axios.CancelToken
let cancel

export const apiSearchGroupAlbums = (resolve, errResole, query) => {
  if(cancel != undefined) {
    cancel()
  }
  axios.get(fn_get_base_api_url(API_GROUP_ALBUMS_SEARCH_RESOURCE), { params: { query: query, }, cancelToken: new CancelToken(function executor(c) {
    // An executor function receives a cancel function as a parameter
    cancel = c
  }),
  })
    .then((response) => {
      if (response.status === 200) {
        var json = {}
        json['data'] = response.data.data
        resolve(json)
      } else {
        errResole([{
          msg: 'error test',
        }])
      }
    })
    .catch(errors => {
      errResole(errors)
    })
}

/* CHANGE STATUS */
export const apiChangeStatus = (info, resolve, errResole) => {
  return axios.post(fn_get_base_api_url(API_CHANGE_STATUS_GROUP_ALBUMS), info)
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
    .catch(errors => errResole(errors)) //apiChangeStatus
}
