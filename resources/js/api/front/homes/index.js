import {
  fn_get_base_api_url
} from '@app/api/utils/fn-helper';
import {
  API_HOME_RESOURCE
} from 'store@front/types/api-paths';

export const apiGetLists = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_HOME_RESOURCE), {
      params: params
    })
    .then((response) => {
      console.log(response)
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