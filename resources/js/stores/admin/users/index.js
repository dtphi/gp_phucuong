import axios from 'axios';
import modals from './modal';
import {
  USERS_SET_LOADING,
  USERS_GET_USER_LIST_SUCCESS,
  USERS_GET_USER_LIST_FAILED,
  USERS_SET_USER_LIST,
  USERS_SET_ERROR 
} from '../mutation-types';

export default {
    namespaced: true,
    state: {
      users: [],
      loading: false,
      errors:[]
    },
    getters: {
      users(state) {
        return state.users
      },
      loading(state) {
        return state.loading
      },
      errors(state) {
        return state.errors
      },
      isError(state) {
        return state.errors.length
      }
    },

    mutations: {
        [USERS_SET_USER_LIST](state, payload) {
            state.users = payload
        },

        [USERS_GET_USER_LIST_SUCCESS](state, payload) {

        },

        [USERS_SET_LOADING](state, payload) {
          state.loading = payload
        },

        [USERS_SET_ERROR](state, payload) {
          state.errors = payload
        }
    },

    actions: {
        async getUserList ({ dispatch, commit }) {
          dispatch('setLoading', true);
            commit(USERS_SET_USER_LIST, [
              {id:1, name:'Phi', email: 'phi@mail.com', createdAt: '24/12/2020'},
              {id:2, name:'Fei', email: 'fei@mail.com', createdAt: '24/12/2020'},
              {id:3, name:'Admin', email: 'admin@mail.com', createdAt: '24/12/2020'}
            ]);
            commit(USERS_GET_USER_LIST_SUCCESS, 'get users success')

            dispatch('setLoading', false);
        },

        setLoading ({commit} , isLoading) {
          commit(USERS_SET_LOADING, isLoading);
        },
    },

    modules: {
      modal: modals
    }
}
