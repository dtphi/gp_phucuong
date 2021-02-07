/**
 * Mocking client-server processing
 */
const _infos = {
                name: "Danh Mục :",
                id: 0,
                children: [
                  { id: 1,name: "Ơn gọi linh mục" },
                  { id: 2,name: "Dòng tu" },
                  {
                    name: "Giáo phận",
                    id: 3,
                    children: [
                      {
                      	id: 4,
                        name: "Nhà thờ chánh tòa"
                      },
                      { id: 5, name: "Năm thánh" },
                      { id: 6, name: "Giám mục" },
                      {
                        id: 7, name: "Giáo hạc - Giáo sứ",
                        children: [
                          { id: 8, name: "Hạt Bến Cát" }, 
                          { id: 9, name: "Hạt Bình Long" }, 
                          { id: 10, name: "Hạt Củ Chi" }
                        ]
                      }
                    ]
                  }
                ]
              }

const _newsGroups = [
  {id: 0, name: 'Danh mục'},
  { id: 1,name: "Ơn gọi linh mục" },
  { id: 2,name: "Dòng tu" },
  { id: 3, name: "Giáo phận" },
  { id: 4, name: "Nhà thờ chánh tòa"},
  { id: 5, name: "Năm thánh" },
  { id: 6, name: "Giám mục" },
  { id: 7, name: "Giáo hạc - Giáo sứ"},
  { id: 8, name: "Hạt Bến Cát" }, 
  { id: 9, name: "Hạt Bình Long" }, 
  { id: 10, name: "Hạt Củ Chi" }
]
            
export const apiGetNewsGroupById = (newsGroupId, resolve, errResole) => {
  axios.get('/api/user')
    .then((response) => {
      console.log(response)
      if (response.status === 200) {
        var json = {};
        json['data'] = _newsGroups[newsGroupId];
        json['status'] = 1000;
        resolve(json);
      } else {
        errResole([{status:response.status, msg:'error test'}]);
      }
    })
    .catch(errors => errResole(errors))
}

export const apiGetNewsGroups = (resolve, errResole) => {
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

export const apiUpdateNewsGroup = (newsGroup, resolve, errResole) => {
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

export const apiInsertNewsGroup = (newsGroup, resolve, errResole) => {
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

export const apiDeleteNewsGroup = (newsGroupId, resolve, errResole) => {
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
