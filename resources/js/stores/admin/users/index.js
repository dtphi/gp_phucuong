import axios from 'axios';
import modals from './modal';
import ApiUser from 'api@admin/user';
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
          await ApiUser.getUsers(
            (users) => {
              commit(USERS_SET_USER_LIST, users)
              commit(USERS_GET_USER_LIST_SUCCESS, 'get users success')
            },
            (errors) => {
              commit(USERS_GET_USER_LIST_FAILED, 'get users faild')
            }
          );
          dispatch('setLoading', false);
        },

        reloadGetUserList ({dispatch}, isReload) {
          if (isReload) {
            dispatch('getUserList');
          }
        },

        setLoading ({commit} , isLoading) {
          commit(USERS_SET_LOADING, isLoading);
        },
    },

    modules: {
      modal: modals
    }
}
