import {
  fn_get_base_api_url,
  fn_get_base_api_detail_url
} from '@app/api/utils/fn-helper';
import {
  API_RESTRICT_IPS_RESOURCE
} from 'store@admin/types/api-paths';

/* GET BY ID RESTRICT IPS */
export const apiGetResIpById = (infoId, resolve, errResole) => {
  return axios.get(fn_get_base_api_detail_url(API_RESTRICT_IPS_RESOURCE, infoId))
    .then((response) => {
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
      if (errors.response) {
        errResole(errors);
      }
    })
}

/* GET ALL RESTRICT IPS */
export const apiGetAllRestrictIp = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_RESTRICT_IPS_RESOURCE), {
      params: params
    })
    .then((response) => {
      if (response.status === 200) {
        resolve({
          data: response.data.data
        });
      } else {
        errResole([{
          status: response.status,
          msg: 'error test'
        }]);
      }
    })
    .catch(errors => {
      if (errors.response) {
        errResole([{
          status: errors.response.status,
          messageCommon: errors.response.data.message,
          messages: errors.response.data.errors
        }])
      }
    })
}

/* RESTRICT IPS UPDATE */
export const apiUpdateResIp = (info, resolve, errResole) => {
  return axios.put(fn_get_base_api_detail_url(API_RESTRICT_IPS_RESOURCE, info.data.id), info)
    .then((response) => {
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
    .catch(errors => errResole(errors))
}

/* RESTRICT IPS INSERT */
export const apiInsertResIp = (info, resolve, errResole) => {
  return axios.post(fn_get_base_api_url(API_RESTRICT_IPS_RESOURCE), info)
    .then((response) => {
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
    .catch(errors => errResole(errors))
}

/* RESTRICT IPS DELETE */
export const apiDeleteResIp = (infoId, resolve, errResole) => {
  return axios.delete(fn_get_base_api_detail_url(API_RESTRICT_IPS_RESOURCE, infoId))
    .then((response) => {
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
    .catch(errors => errResole(errors))
}