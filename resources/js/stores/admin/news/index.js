import axios from 'axios';
import modals from './modal';

export default {
    namespaced: true,
    state: {
      errors:[]
    },
    getters: {
      errors(state) {
        return state.errors
      },
      isError(state) {
        return state.errors.length
      }
    },

    mutations: {
        SET_ERROR(state, value) {
          state.errors = value
        }
    },

    actions: {
        async signIn ({ dispatch }, credentials) {
            await axios.get('/sanctum/csrf-cookie');
            await axios.post('/api/login', credentials);

            return dispatch('admin', {type: options.login})
        }
    },

    modules: {
    	modal: modals
    }
}
