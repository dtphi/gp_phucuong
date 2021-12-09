import {
	fn_get_base_api_url,
	fn_get_base_api_detail_url
} from '@app/api/utils/fn-helper';
import {
  API_LINH_MUC_DETAIL,
  API_LINH_MUC_LIST,
  API_CHUC_VU_LIST,
  API_LINH_MUC_LIST_BY_ID
} from 'store@front/types/api-paths';

export const apiGetLists = (resolve, errResole, params) => {	
  return axios.get(fn_get_base_api_url(API_LINH_MUC_LIST), {
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
  return axios.get(fn_get_base_api_detail_url(API_LINH_MUC_DETAIL, infoId), {
      params: params
    }).then((response) => {
      if (response.status === 200) {
        resolve(response);
      } else {
        errResole([{
          status: response.status,
          msg: 'error test'
        }]);
      }
    })
    .catch(errors => errResole(errors))
}

export const apiGetListsChucVu = (resolve, errResole) => {
  return axios.get(fn_get_base_api_url(API_CHUC_VU_LIST))
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
      console.log(errors);
      if (errors.response) {
        errResole([{
          status: errors.response.status,
          messageCommon: errors.response.data.message,
          messages: errors.response.data.errors
        }])
      }

    })
}

export const apiGetListsLinhMuc = (resolve, errResole, params) => {
  return axios.post(fn_get_base_api_url(API_LINH_MUC_LIST_BY_ID), {
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
      console.log(errors);
      if (errors.response) {
        errResole([{
          status: errors.response.status,
          messageCommon: errors.response.data.message,
          messages: errors.response.data.errors
        }])
      }

    })
}