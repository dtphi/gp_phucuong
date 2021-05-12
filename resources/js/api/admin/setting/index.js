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
export const apiGetSettingByCode = (code, resolve, errResole) => {
  axios.get(fn_get_base_api_detail_url(API_SETTING_RESOURCE, code))
    .then((response) => {
      console.log(response)
      if (response.status === 200) {
        var json = {};
        json['data'] = response.data.data;
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
    })
}

/**
 * [description]
 * @param  {[type]} settingData [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiInsertSetting = (settingData, resolve, errResole) => {
  return axios.post(fn_get_base_api_url(API_SETTING_RESOURCE), settingData)
    .then((response) => {
      console.log(response)
      if (response.status === 201) {
        var json = {};
        json['data'] = response.data.result;
        json['code'] = response.data.code;
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