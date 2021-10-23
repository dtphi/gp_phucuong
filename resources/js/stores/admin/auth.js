import axios from 'axios';
import {
  fn_get_base_api_url
} from '@app/api/utils/fn-helper';
import {
  AUTH_SET_AUTHENTICATED,
  AUTH_SET_USER,
  AUTH_SET_ERROR
} from './types/mutation-types';
import {
  API_AUTH_SANCTUM_CSRF_COOKIE,
  API_AUTH_LOGIN,
  API_AUTH_LOGOUT,
  API_AUTH_USER
} from './types/api-paths';

const options = {
  init: 'init',
  login: 'login',
  logout: 'logout'
};

const linhMucExpectSignIn = localStorage.getItem('linhMuc.expectSignIn');
const linhMucExpectSignInPhone = localStorage.getItem('linhMuc.expectSignInPhone');

export default {
  namespaced: true,
  state: {
    authenticated: false,
    user: null,
    redirectUrl: 'admin/dashboards',
    redirectLogoutUrl: 'admin/login',
    redirectPhoneLoginUrl: 'admin/phone-verify',
    linhMucExpectSignIn: linhMucExpectSignIn,
    linhMucExpectSignInPhone: linhMucExpectSignInPhone,
    errors: []
  },
  getters: {
    authenticated(state) {
      return state.authenticated
    },
    user(state) {
      return state.user
    },
    errors(state) {
      return state.errors
    },
    isError(state) {
      return state.errors.length
    }
  },

  mutations: {
    [AUTH_SET_AUTHENTICATED](state, value) {
      state.authenticated = value
    },

    [AUTH_SET_USER](state, value) {
      state.user = value
    },

    [AUTH_SET_ERROR](state, value) {
      state.errors = value
    }
  },

  actions: {
    async signIn({
      dispatch
    }, credentials) {
      await axios.get(fn_get_base_api_url(API_AUTH_SANCTUM_CSRF_COOKIE));
      await axios.post(fn_get_base_api_url(API_AUTH_LOGIN), credentials);

      return dispatch('admin', {
        type: options.login
      })
    },

    async signOut({
      dispatch
    }) {
      await axios.post(fn_get_base_api_url(API_AUTH_LOGOUT))

      return dispatch('admin', {
        type: options.logout
      });
    },

    admin({
      commit
    }, options) {
      return axios.get(fn_get_base_api_url(API_AUTH_USER)).then((response) => {
        commit(AUTH_SET_AUTHENTICATED, true);
        commit(AUTH_SET_USER, response.data);
        commit(AUTH_SET_ERROR, []);
      }).catch((error) => {
        commit(AUTH_SET_AUTHENTICATED, false);
        commit(AUTH_SET_USER, null);
        if (typeof options === 'object') {
          const type = options.hasOwnProperty('type');
          type ? ((options.type === 'login') ? commit(AUTH_SET_ERROR, [{
            msgCommon: 'Login failed!'
          }]) : null) : null;
        }
      })
    },

    redirectLoginSuccess({
      state
    }) {
      window.location = window.location.origin + '/' + state.redirectUrl;
    },

    redirectLogoutSuccess({
      state
    }) {
      window.location = window.location.origin + '/' + state.redirectLogoutUrl;
    }
  }
}