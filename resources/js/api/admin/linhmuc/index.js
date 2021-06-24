import {
  fn_get_base_api_url,
  fn_get_base_api_detail_url
} from '@app/api/utils/fn-helper';
import {
  API_LINH_MUCS_RESOURCE
} from 'store@admin/types/api-paths';

export const apiGetDropdownCategories = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(`/api/linh-mucs`), {
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

/**
 * [description]
 * @param  {[type]} infoId    [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiGetInfoById = (infoId, resolve, errResole) => {
  return axios.get(fn_get_base_api_detail_url(API_LINH_MUCS_RESOURCE, infoId))
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
      if (errors.response) {
        errResole(errors);
      }
    })
}

export const apiGetSlideSpecialInfos = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_LINH_MUCS_RESOURCE), {
      params: params
    })
    .then((response) => {
      console.log(response)
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

/**
 * [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @param  {[type]} params    [description]
 * @return {[type]}           [description]
 */
export const apiGetLinhMucInfos = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_LINH_MUCS_RESOURCE), {
      params: params
    })
    .then((response) => {
      console.log(response)
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

/**
 * [description]
 * @param  {[type]} info      [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiUpdateInfo = (info, resolve, errResole) => {
  return axios.put(fn_get_base_api_detail_url(API_LINH_MUCS_RESOURCE, info.id), info)
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
    .catch(errors => errResole(errors))
}

/**
 * [description]
 * @param  {[type]} info      [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiInsertInfo = (info, resolve, errResole) => {
  return axios.post(fn_get_base_api_url(API_LINH_MUCS_RESOURCE), info)
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
    .catch(errors => errResole(errors))
}

/**
 * [description]
 * @param  {[type]} infoId    [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiDeleteInfo = (infoId, resolve, errResole) => {
  return axios.delete(fn_get_base_api_detail_url(API_LINH_MUCS_RESOURCE, infoId))
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
    .catch(errors => errResole(errors))
}

/**
 * [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @param  {[type]} params    [description]
 * @return {[type]}           [description]
 */
export const apiSearchAll = (query, resolve, errResole) => {
  let params = {
    query
  };
  return axios.get(fn_get_base_api_url(`/api/search-info`), {
      params
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

export const apiGetDropdownInfos = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(`/api/informations/dropdowns`), {
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