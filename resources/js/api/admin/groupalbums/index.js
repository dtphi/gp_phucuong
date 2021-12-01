import {
  fn_get_base_api_url,
  fn_get_base_api_detail_url
} from '@app/api/utils/fn-helper';
import {
  API_GROUP_ALBUMS_RESOURCE
} from 'store@admin/types/api-paths';

export const apiGetGroupAlbums = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_GROUP_ALBUMS_RESOURCE), {
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