import {
  fn_get_base_api_url,
} from '@app/api/utils/fn-helper'
import {
  API_GIAO_PHAN_LIST,
} from 'store@front/types/api-paths'

export const apiGetListsGiaoPhan = (resolve, errResole) => {
  return axios.get(fn_get_base_api_url(API_GIAO_PHAN_LIST))
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