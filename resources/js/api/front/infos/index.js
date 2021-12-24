import {
  fn_get_base_api_url,
} from '@app/api/utils/fn-helper'
import {
  API_INFO_DETAIL,
  API_INFO_LIST,
  API_INFO_GET_LASTED_LIST,
  API_INFO_GET_POPULAR_LIST,
  API_INFO_GET_RELATED_LIST,
  API_INFO_GET_SPECIAL_MODULE_LIST
} from 'store@front/types/api-paths'

export const apiGetSpecialModuleList = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_INFO_GET_SPECIAL_MODULE_LIST), {
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

export const apiGetPopularList = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_INFO_GET_POPULAR_LIST), {
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

export const apiGetRelatedList = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_INFO_GET_RELATED_LIST), {
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

export const apiGetLastedList = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_INFO_GET_LASTED_LIST), {
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

export const apiGetVideoListsToCategory = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_INFO_LIST), {
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

export const apiGetListsToCategory = (resolve, errResole, params) => {

  return axios.get(fn_get_base_api_url(API_INFO_LIST), {
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
  return axios.get(fn_get_base_api_url(API_INFO_DETAIL), {
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