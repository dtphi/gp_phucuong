import {
  fn_get_base_api_url,
  fn_get_base_api_detail_url
} from '@app/api/utils/fn-helper';
import {
  API_GIAO_XU_LIST
} from 'store@front/types/api-paths';

export const apiGetLists = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_GIAO_XU_LIST), {
      params: params
    })
    .then((response) => {
      if (response.status === 200) {
        resolve(response.data);
      } else {
        errResole([{
          status: response.status,
          msg: 'error test'
        }]);
      }
    })
    .catch(errors => errResole(errors))
}

export const apiGetDetail = (infoId, resolve, errResole, params) => {
  console.log('url',fn_get_base_api_detail_url(API_GIAO_XU_LIST, infoId))
  return axios.get(fn_get_base_api_detail_url(API_GIAO_XU_LIST, infoId), {
      params: params
    }).then((response) => {
      if (response.status === 200) {
        resolve(response.data);
      } else {
        errResole([{
          status: response.status,
          msg: 'error test'
        }]);
      }
    })
    .catch(errors => errResole(errors))
}