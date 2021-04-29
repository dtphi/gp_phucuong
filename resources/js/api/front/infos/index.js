import {
    fn_get_base_api_url,
    fn_get_base_api_detail_url
  } from '@app/api/utils/fn-helper';
  import {
    API_VIDEO_RESOURCE,
    API_INFO_DETAIL,
    API_INFO_LIST
  } from 'store@front/types/api-paths';
  
  export const apiGetVideoListsToCategory = (resolve, errResole, params) => {
    return axios.get(fn_get_base_api_url(API_INFO_LIST),{
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

  export const apiGetListsToCategory = (resolve, errResole, slug) => {
    const params = {
      slug: slug
    };
    return axios.get(fn_get_base_api_url(API_INFO_LIST),{
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
      console.log(infoId)
    return axios.get(API_INFO_DETAIL, {
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
   