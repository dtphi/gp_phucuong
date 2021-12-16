import {
  fn_get_base_api_url,
  fn_get_base_api_detail_url
} from '@app/api/utils/fn-helper';
import {
  API_GIAO_XU_LIST,
  API_GIAO_XU_LIST_BY_ID,
  API_SEARCH_ITEM_GIAOXU_RESOURCE
} from 'store@front/types/api-paths';
import axios from 'axios';

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

export const apiGetListsGiaoXu = (resolve, errResole, options) => {
  return axios.post(fn_get_base_api_url(API_GIAO_XU_LIST_BY_ID), {
    params: options.params,
    page: options.page
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


const CancelToken = axios.CancelToken;
let cancel;
export const apiSearchItem = (resolve, errResole, options) => {
  if(cancel != undefined) {
               cancel();
 }
 axios.get(fn_get_base_api_url(API_SEARCH_ITEM_GIAOXU_RESOURCE), { params: { query: options.query, page: options.page }, cancelToken: new CancelToken(function executor(c) {
   // An executor function receives a cancel function as a parameter
   cancel = c;
 })
 })
   .then((response) => {
     if (response.status === 200) {
       var json = {};
       json['data'] = response.data.data;
       resolve(json);
     } else {
       errResole([{
         msg: 'error test'
       }]);
     }
   })
   .catch(errors => {
     console.log(errors);
   })
}