/**
 * Mocking client-server processing
 */
const _infos = [
              {id:1, name:'Phi', email: 'phi@mail.com', createdAt: '24/12/2020'},
              {id:2, name:'Fei', email: 'fei@mail.com', createdAt: '24/12/2020'},
              {id:3, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
              {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
               {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                 {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                  {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                   {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                    {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                     {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                      {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                       {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                        {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                         {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                          {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                           {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                            {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                   {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                    {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                     {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                      {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                       {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                        {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                         {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                          {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                           {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                            {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                             {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                              {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                               {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
                                {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
            ]
            
export const apiGetInfoById = (infoId, resolve, errResole) => {
  axios.get('/api/user')
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
  return axios.get('/api/user')
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
  return axios.get('/api/info')
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
  return axios.get('/api/user')
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
  return axios.get('/api/user')
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
