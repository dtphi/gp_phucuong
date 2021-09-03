import {
  fn_get_base_api_url,
} from '@app/api/utils/fn-helper';
import {
  API_INFO_DETAIL,
  API_GIAO_XU_LIST
} from 'store@front/types/api-paths';

export const apiGetLists = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_GIAO_XU_LIST), {
      params: params
    })
    .then((response) => {
      if (response.status === 200) {
        resolve(response.data.data.results);
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
  console.log(infoId)
  return axios.get(fn_get_base_api_url(API_INFO_DETAIL), {
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