import {
    fn_get_base_api_url,
    fn_get_base_api_detail_url
  } from '@app/api/utils/fn-helper';
  import {
    API_VIDEO_RESOURCE
  } from 'store@front/types/api-paths';
  
  export const apiGetLists = (resolve, errResole, params) => {
    return axios.get(fn_get_base_api_url(API_VIDEO_RESOURCE),{
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
   