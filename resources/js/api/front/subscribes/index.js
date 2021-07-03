import {
  fn_get_base_api_url,
  fn_get_base_api_detail_url
} from '@app/api/utils/fn-helper';
import {
  API_SETTING_RESOURCE
} from 'store@admin/types/api-paths';


/**
 * [description]
 * @param  {[type]} newsGroupId [description]
 * @param  {[type]} resolve     [description]
 * @param  {[type]} errResole   [description]
 * @return {[type]}             [description]
 */
 export const apiEmailSubscribe = (newEmailSub, resolve, errResole) => {
  return axios.post(window.location.origin + "/api/email_sub/create", newEmailSub)
    .then((response) => {
      console.log(response)
      if (response.status === 200) {
        var json = {};
        json['data'] = response.data;
        resolve(json);
      } else {
        errResole([{
          status: response.status,
          msg: 'error test'
        }]);
      }
    })
    .catch(errors => errResole([{
      status: errors.response.status,
      messageCommon: errors.response.data.message,
      messages: errors.response.data.errors
    }]))
}
/* export const apiEmailSubscribe = (resolve, errResole, params) => {
  resolve(params); */
  /*axios.get(fn_get_base_api_url('/api/app/get-data-module'), {
      params: params
    })
    .then((response) => {
      console.log(response)
      if (response.status === 200) {
        var json = {};
        json['data'] = response.data;
        json['status'] = 1000;
        resolve(json);
      } else {
        errResole([{
          status: response.status,
          msg: 'error test'
        }]);
      }
    })
    .catch(errors => {
      console.log(errors)
    })*/
/* } */