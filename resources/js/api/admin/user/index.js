import {
  fn_get_base_api_url,
  fn_get_base_api_detail_url,
} from '@app/api/utils/fn-helper'
import {
  API_USERS_RESOURCE,
} from 'store@admin/types/api-paths'

/**
 * [description]
 * @param  {[type]} userId    [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiGetUserById = (userId, resolve, errResole) => {
  axios.get(fn_get_base_api_detail_url(API_USERS_RESOURCE, userId))
    .then((response) => {
      if (response.status === 200) {
        var json = {}
        json['data'] = response.data.admin
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
      errResole([{
        status: errors.response.status,
        messageCommon: errors.response.data.message,
        messages: errors.response.data.errors,
      }])
    })
}

/**
 * [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @param  {[type]} params    [description]
 * @return {[type]}           [description]
 */
export const apiGetUsers = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_USERS_RESOURCE), {
    params: params,
  })
    .then((response) => {
      if (response?.status === 200) {
        resolve(response.data)
      } else {
        errResole([{
          status: response?.status,
          msg: 'error test',
        }])
      }
    })
    .catch(errors => {
      if (errors?.response?.status) {
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
 * @param  {[type]} user      [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiUpdateUser = (user, resolve, errResole) => {
  return axios.put(fn_get_base_api_detail_url(API_USERS_RESOURCE, user.id), user)
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
      errResole([{
        status: errors.response.status,
        messageCommon: errors.response.data.message,
        messages: errors.response.data.errors,
      }])
    })
}

/**
 * [description]
 * @param  {[type]} user      [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiInsertUser = (user, resolve, errResole) => {
  return axios.post(fn_get_base_api_url(API_USERS_RESOURCE), user)
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
    .catch((errors) => {
      errResole([{
        status: errors.response.status,
        messageCommon: errors.response.data.message,
        messages: errors.response.data.errors,
      }])
    })
}

/**
 * [description]
 * @param  {[type]} userId    [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiDeleteUser = (userId, resolve, errResole) => {
  return axios.delete(fn_get_base_api_detail_url(API_USERS_RESOURCE, userId))
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
    .catch(errors => errResole([{
      status: errors.response.status,
      messageCommon: errors.response.data.message,
      messages: errors.response.data.errors,
    }]))
}

/**
 * [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @param  {[type]} params    [description]
 * @return {[type]}           [description]
 */
export const apiSearchAll = (query, resolve, errResole) => {
  let params = {
    query,
  }

  return axios.get(fn_get_base_api_url('/api/search-user'), {
    params,
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
    .catch(errors => errResole([{
      status: errors.response.status,
      messageCommon: errors.response.data.message,
      messages: errors.response.data.errors,
    }]))
}
