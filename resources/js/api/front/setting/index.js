import {
  fn_get_base_api_url,
} from '@app/api/utils/fn-helper'

/**
 * [description]
 * @param  {[type]} newsGroupId [description]
 * @param  {[type]} resolve     [description]
 * @param  {[type]} errResole   [description]
 * @return {[type]}             [description]
 */
export const apiGetSettingByCode = (resolve, errResole, params) => {
  axios.get(fn_get_base_api_url('/api/app/get-data-module'), {
    params: params,
  })
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
      errResole(errors)
    })
}