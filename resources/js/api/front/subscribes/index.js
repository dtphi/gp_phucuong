import {
  fn_get_base_api_url,
} from '@app/api/utils/fn-helper'
import {
  API_EMAIL_SUBSCRIBE,
} from 'store@front/types/api-paths'

/**
 * [description]
 * @param  {[type]} newsGroupId [description]
 * @param  {[type]} resolve     [description]
 * @param  {[type]} errResole   [description]
 * @return {[type]}             [description]
 */
 export const apiEmailSubscribe = (newEmailSub, resolve, errResole) => {
  return axios.post( fn_get_base_api_url(API_EMAIL_SUBSCRIBE), newEmailSub)
    .then((response) => {
      if (response.status === 200) {
        var json = {}
        json['data'] = response.data
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