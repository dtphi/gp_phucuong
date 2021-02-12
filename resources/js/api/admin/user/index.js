import {
  API_USERS_RESOURCE
} from 'store@admin/types/api-paths';

/**
 * Mocking client-server processing
 */
const _users = [
              {id:1, name:'Phi', email: 'phi@mail.com', createdAt: '24/12/2020'},
              {id:2, name:'Fei', email: 'fei@mail.com', createdAt: '24/12/2020'},
              {id:3, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
              {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'}
            ]
            
export const apiGetUserById = (userId, resolve, errResole) => {
  axios.get(API_USERS_RESOURCE + '/' + userId)
    .then((response) => {
      if (response.status === 200) {
        var json = {};
        json['data'] = _users[userId];
        json['status'] = 1000;
        resolve(json);
      } else {
        errResole([
          {status:response.status, msg:'error test'}
        ]);
      }
    })
    .catch(errors => errResole(errors))
}

export const apiGetUsers = (resolve, errResole) => {
  return axios.get(API_USERS_RESOURCE)
  .then((response) => {
    console.log(response)
    if (response.status === 200) {
      const data = _users;
      resolve(data);
    } else {
      errResole([{status:response.status, msg:'error test'}]);
    }
  })
  .catch(errors => errResole(errors))
}

export const apiUpdateUser = (user, resolve, errResole) => {
  return axios.put(API_USERS_RESOURCE + '/' + user.id, user)
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

/**
 * [description]
 * @param  {[type]} user      [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiInsertUser = (user, resolve, errResole) => {
  return axios.post(API_USERS_RESOURCE, user)
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

export const apiDeleteUser = (userId, resolve, errResole) => {
  return axios.delete(API_USERS_RESOURCE + '/' + userId)
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
