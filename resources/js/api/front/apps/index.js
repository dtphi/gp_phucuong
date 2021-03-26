import {
  fn_get_base_api_url,
  fn_get_base_api_detail_url
} from '@app/api/utils/fn-helper';
import {
  API_APP_SETTING
} from 'store@front/types/api-paths';

/**
 * Mocking client-server processing
 */
const _users = [{
  id: 1,
  name: 'Phi',
  email: 'phi@mail.com',
  createdAt: '24/12/2020'
}]


export const apiGetSettings = (resolve, errResole, params) => {
  return axios.post(fn_get_base_api_url(API_APP_SETTING),{
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
