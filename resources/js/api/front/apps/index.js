import {
  fn_get_base_api_url,
} from '@app/api/utils/fn-helper'
import {
  API_APP_SETTING,
} from 'store@front/types/api-paths'

export const apiGetSettings = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_APP_SETTING), {
      params: params
    })
    .then((response) => {
      if (response.status === 200) {
        resolve(response.data)
      } else {
        errResole([{
          status: response.status,
          msg: 'error test'
        }])
      }
    })
    .catch(errors => errResole(errors))
}