import {
	fn_get_base_api_url,
	fn_get_base_api_detail_url
} from '@app/api/utils/fn-helper';
import {
  API_LINH_MUC_DETAIL,
  API_LINH_MUC_LIST
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