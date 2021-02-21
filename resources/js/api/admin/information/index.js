import {
  API_INFOMATIONS_RESOURCE
} from 'store@admin/types/api-paths';

/**
 * Mocking client-server processing
 */
const _infos = [{
  id: 1,
  news_name: 'News 1',
  description: 'Description 1',
  createdAt: '24/12/2020'
}, {
  id: 2,
  news_name: 'News 2',
  description: 'Description 2',
  createdAt: '24/12/2020'
}, {
  id: 3,
  news_name: 'News 3',
  description: 'Description 3',
  createdAt: '24/12/2020'
}, {
  id: 4,
  news_name: 'News 4',
  description: 'Description 4',
  createdAt: '24/12/2020'
}, {
  id: 5,
  news_name: 'News 5',
  description: 'Description 5',
  createdAt: '24/12/2020'
}, {
  id: 6,
  news_name: 'News 6',
  description: 'Description 6',
  createdAt: '24/12/2020'
}, {
  id: 7,
  news_name: 'News 7',
  description: 'Descriptio4 7',
  createdAt: '24/12/2020'
}, {
  id: 8,
  news_name: 'News 8',
  description: 'Descriptio 8',
  createdAt: '24/12/2020'
}, ];

export const apiGetInfoById = (infoId, resolve, errResole) => {
  return axios.get(API_INFOMATIONS_RESOURCE + '/' + infoId)
    .then((response) => {
      console.log(response)
      if (response.status === 200) {
        var json = {};
        json['data'] = response.data.information;
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

export const apiGetInfos = (resolve, errResole) => {
  return axios.get(API_INFOMATIONS_RESOURCE)
    .then((response) => {
      console.log(response)
      if (response.status === 200) {
        const data = response.data.data.results;
        resolve(data);
      } else {
        errResole([{
          status: response.status,
          msg: 'error test'
        }]);
      }
    })
    .catch(errors => errResole(errors))
}

export const apiUpdateInfo = (info, resolve, errResole) => {
  return axios.put(API_INFOMATIONS_RESOURCE + '/' + info.id, info)
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

export const apiInsertInfo = (info, resolve, errResole) => {
  return axios.post(API_INFOMATIONS_RESOURCE, info)
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

export const apiDeleteInfo = (infoId, resolve, errResole) => {
  return axios.delete(API_INFOMATIONS_RESOURCE + '/' + infoId)
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