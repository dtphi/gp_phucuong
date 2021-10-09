import store from '../../../stores/front/auth/index';

// API LOGIN
export const  fetchLogin = (resolve, errResole, params) => {
  return axios.post('/api/auth/login', {
    email: params.email,
    password: params.password,
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
// API REGISTER
  export const  fetchSignUp = (resolve, errResole, params) => {
  return axios.post('/api/auth/register', {
    email: params.email,
    password: params.password,
    })
    .then((response) => {
      if (response.status === 201) {
        resolve(response);
      } else {
        errResole([{
          status: response.status,
          msg: 'error test'
        }]);
      }
    })
    .catch(errors => errResole(errors))
  }

export function post(url,creds) {
    return axios.post(url, creds, {
            headers: {
                Authorization: getToken()
            }
        }
    );

}
export function get(url) {
    return axios.get(url, {
            headers: {
                Authorization: getToken()
            }
        }
    );
}

export function saveToken(token) {
    return localStorage.setItem("token", "Bearer " + token);
}

export function removeToken() {
    return localStorage.removeItem("token");
}

export function getToken() {
    return localStorage.getItem("token")
}