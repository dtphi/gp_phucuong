import {
  API_INFOMATIONS_RESOURCE
} from 'store@admin/types/api-paths';

/**
 * Mocking client-server processing
 */
const _infos = [
              {id:1, name:'Phi', email: 'phi@mail.com', createdAt: '24/12/2020'},
              {id:2, name:'Fei', email: 'fei@mail.com', createdAt: '24/12/2020'},
              {id:3, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
              {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
               {id:5, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                {id:6, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                 {id:7, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                  {id:8, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
 ]
            
export const apiGetInfoById = (infoId, resolve, errResole) => {
  axios.get(API_INFOMATIONS_RESOURCE + '/' + infoId)
    .then((response) => {
      console.log(response)
      if (response.status === 200) {
        var json = {};
        json['data'] = _infos[infoId];
        json['status'] = 1000;
        resolve(json);
      } else {
        errResole([{status:response.status, msg:'error test'}]);
      }
    })
    .catch(errors => errResole(errors))
}

export const apiGetInfos = (resolve, errResole) => {
  return axios.get(API_INFOMATIONS_RESOURCE)
  .then((response) => {
    console.log(response)
    if (response.status === 200) {
      const data = _infos;
      resolve(data);
    } else {
      errResole([{status:response.status, msg:'error test'}]);
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
      errResole([{status:response.status, msg:'error test'}]);
    }
  })
  .catch(errors => errResole(errors))
}

export const apiInsertInfo = (info, resolve, errResole) => {
  return axios.post(API_INFOMATIONS_RESOURCE, info)
  .then((response) => {
    console.log(response)
    if (response.status === 200) {
      var json = {};
      json['data'] = response.data;
      json['status'] = 1000;
      resolve(json);
    } else {
      errResole([{status:response.status, msg:'error test'}]);
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
      errResole([{status:response.status, msg:'error test'}]);
    }
  })
  .catch(errors => errResole(errors))
}
