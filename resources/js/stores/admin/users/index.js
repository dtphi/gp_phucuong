import axios from 'axios';
import modals from './modal';

export default {
    namespaced: true,
    state: {
      authenticated: false,
      user: null,
      errors:[]
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
        SET_AUTHENTICATED(state, value) {
            state.authenticated = value
        },

        SET_USER(state, value) {
            state.user = value
        },

        SET_ERROR(state, value) {
          state.errors = value
        }
    },

    actions: {
        async signIn ({ dispatch }, credentials) {
            await axios.get('/sanctum/csrf-cookie');
            await axios.post('/api/login', credentials);

            return dispatch('admin', {type: options.login})
        },

        async signOut ({ dispatch }) {
          await axios.post('/api/logout')

          return dispatch('admin', {type:options.logout});
        },

        admin ({ commit }, options) {
            return axios.get('/api/user').then((response) => {
                commit('SET_AUTHENTICATED', true);
                commit('SET_USER', response.data);
                commit('SET_ERROR', []);
            }).catch((error) => {
                commit('SET_AUTHENTICATED', false);
                commit('SET_USER', null);
                if (typeof options === 'object') {
                  const type = options.hasOwnProperty('type');
                  type ? ((options.type==='login') ? commit('SET_ERROR',
                  [
                    {msgCommon: 'Login failed!'}
                  ]):null): null;
                }
            })
        }
    },

    modules: {
    	modal: modals
    }
}
