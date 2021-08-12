import {
  fn_get_base_api_url,
  fn_get_base_api_detail_url
} from '@app/api/utils/fn-helper';
import {
  API_DANHMUCS_GIAOPHAN_RESOURCE
} from 'store@admin/types/api-paths';


/**
 * [description]
 * @param  {[type]} newsGroupId [description]
 * @param  {[type]} resolve     [description]
 * @param  {[type]} errResole   [description]
 * @return {[type]}             [description]
 */
export const apiGetGiaoPhanDanhMucsById = (newsGroupId, resolve, errResole) => {
  axios.get(fn_get_base_api_detail_url(API_DANHMUCS_GIAOPHAN_RESOURCE, newsGroupId))
    .then((response) => {
      console.log(response, 'id giaophandanhmuc')
      if (response.status === 200) {
        var json = {};
        json['data'] = response.data.giaophandanhmucs;
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

// lấy danh sách danh mục giáo phận
export const apiGetGiaoPhanDanhMucs = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_DANHMUCS_GIAOPHAN_RESOURCE), {
    params: params
  })
    .then((response) => {
      console.log(response, 'danh sách danh mục giao phan')
      if (response.status === 200) {
        resolve({
          newsgroupname: "Danh Mục :",
          id: 0,
          children: [],
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

/**
 * [description]
 * @param  {[type]} newsGroup [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiUpdateGiaoPhanDanhMucs = (categoryId, newsGroup, resolve, errResole) => {
  return axios.put(fn_get_base_api_detail_url(API_DANHMUCS_GIAOPHAN_RESOURCE, categoryId), newsGroup)
    .then((response) => {
      console.log(response, 'update giaophandanhmucs')
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
    .catch(errors => errResole([{
      status: errors.response.status,
      messageCommon: errors.response.data.message,
      messages: errors.response.data.errors
    }]))
}

/**
 * [description]
 * @param  {[type]} newsGroup [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiInsertGiaoPhanDanhMucs = (danhmucs, resolve, errResole) => {
  return axios.post(fn_get_base_api_url(API_DANHMUCS_GIAOPHAN_RESOURCE), danhmucs)
    .then((response) => {
      console.log(response, 'insert giaophandanhmuc')
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

/**
 * [description]
 * @param  {[type]} newsGroupId [description]
 * @param  {[type]} resolve     [description]
 * @param  {[type]} errResole   [description]
 * @return {[type]}             [description]
 */
export const apiDeleteGiaoPhanDanhMucs = (newsGroupId, resolve, errResole) => {
  return axios.delete(fn_get_base_api_detail_url(API_NEWS_GROUPS_RESOURCE, newsGroupId))
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
    .catch(errors => errResole([{
      status: errors.response.status,
      messageCommon: errors.response.data.message,
      messages: errors.response.data.errors
    }]))
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
  return axios.get(fn_get_base_api_url(`/api/search-news-group`), {
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
    .catch(errors => errResole([{
      status: errors.response.status,
      messageCommon: errors.response.data.message,
      messages: errors.response.data.errors
    }]))
}

export const apiGetDropdownDanhMucs = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(`/api/danh-mucs/dropdowns`), {
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

export const apiGetCategoryByIds = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(`/api/danh-mucs/dropdowns`), {
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