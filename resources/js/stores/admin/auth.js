import axios from 'axios'

export default {
    namespaced: true,
    state: {
      authenticated: false,
      user: null,
      redirectUrl: 'admin/users',
      redirectLogoutUrl: 'admin/login'
    },
    getters: {
      authenticated(state) {
        return state.authenticated
      },
      user(state) {
        return state.user
      },
    },

    mutations: {
        SET_AUTHENTICATED(state, value) {
            state.authenticated = value
        },

        SET_USER(state, value) {
            state.user = value
        }
    },

    actions: {
        async signIn ({ dispatch }, credentials) {
            await axios.get('/sanctum/csrf-cookie');
            await axios.post('/api/login', credentials);

            return dispatch('admin')
        },

        async signOut ({ dispatch }) {
          await axios.post('/api/logout')

          return dispatch('admin');
        },

        admin ({ commit }) {
            return axios.get('/api/user').then((response) => {
                commit('SET_AUTHENTICATED', true);
                commit('SET_USER', response.data);
            }).catch(() => {
                commit('SET_AUTHENTICATED', false);
                commit('SET_USER', null);
            })
        },

        redirectLoginSuccess({state}) {
            window.location = window.location.origin + '/' + state.redirectUrl;
        },

        redirectLogoutSuccess({state}) {
            window.location = window.location.origin + '/' + state.redirectLogoutUrl;
        }
    }
}
