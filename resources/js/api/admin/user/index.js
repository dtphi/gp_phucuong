/**
 * Mocking client-server processing
 */
const _users = [
              {id:1, name:'Phi', email: 'phi@mail.com', createdAt: '24/12/2020'},
              {id:2, name:'Fei', email: 'fei@mail.com', createdAt: '24/12/2020'},
              {id:3, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'},
              {id:4, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'}
            ]

export default {
	getUserById (userId, resolve, errResole) {
		return axios.get('/api/user')
  	.then((response) => {
  		console.log(response)
  		if (response.status === 200) {
  			var json = {};
  			json['data'] = _users[userId];
  			json['status'] = 1000;
  			resolve(json);
  		} else {
  			errResole([{status:response.status, msg:'error test'}]);
  		}
  	})
  	.catch(errors => errResole(errors))
	},
  getUsers (resolve, errResole) {
  	return axios.get('/api/user')
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
  },
  updateUser (user, resolve, errResole) {
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
}