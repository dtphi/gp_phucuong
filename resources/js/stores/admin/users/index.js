import axios from 'axios';
import addModal from './add-modal';
import editModal from './edit-modal';
import {
  apiGetUserById,
  apiGetUsers,
  apiDeleteUser,
  apiSearchAll
} from 'api@admin/user';
import {
  MODULE_USER
} from '../types/module-types';
import {
  USERS_SET_LOADING,
  USERS_GET_USER_LIST_SUCCESS,
  USERS_GET_USER_LIST_FAILED,
  USERS_DELETE_USER_BY_ID_SUCCESS,
  USERS_DELETE_USER_BY_ID_FAILED,
  USERS_SET_USER_LIST,
  USERS_USER_DELETE_BY_ID,
  USERS_SET_ERROR
} from '../types/mutation-types';
import {
  ACTION_GET_USER_LIST,
  ACTION_DELETE_USER_BY_ID,
  ACTION_SET_USER_DELETE_BY_ID,
  ACTION_RELOAD_GET_USER_LIST,
  ACTION_SET_LOADING,
  ACTION_SEARCH_ALL
} from '../types/action-types';

const defaultState = () => {
  return {
    users: [],
    userDelete: null,
    isDelete: false,
    isList: false,
    loading: false,
    errors: []
  }
}

export default {
  namespaced: true,
  state: defaultState(),
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

    [USERS_USER_DELETE_BY_ID](state, payload) {
      state.userDelete = payload
    },

    [USERS_GET_USER_LIST_SUCCESS](state, payload) {
      state.isList = payload
    },

    [USERS_GET_USER_LIST_FAILED](state, payload) {
      state.isList = payload
    },

    [USERS_DELETE_USER_BY_ID_SUCCESS](state, payload) {
      state.isDelete = payload
    },

    [USERS_DELETE_USER_BY_ID_FAILED](state, payload) {
      state.isDelete = payload
    },

    [USERS_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [USERS_SET_ERROR](state, payload) {
      state.errors = payload
    }
  },

  actions: {
    async [ACTION_GET_USER_LIST]({
      dispatch,
      commit
    }, params) {
      console.log(params)
      dispatch(ACTION_SET_LOADING, true);
      await apiGetUsers(
        (users) => {
          dispatch('setConfigApp', {
            links: { ...users.links
            },
            meta: { ...users.meta
            },
            moduleActive: {
              name: MODULE_USER,
              actionList: ACTION_GET_USER_LIST
            }
          }, {
            root: true
          })
          commit(USERS_SET_USER_LIST, users.data.results)

          commit(USERS_GET_USER_LIST_SUCCESS, true)
        },
        (errors) => {
          commit(USERS_GET_USER_LIST_FAILED, false)
        },
        params
      );
      dispatch(ACTION_SET_LOADING, false);
    },

    async [ACTION_DELETE_USER_BY_ID]({
      state,
      dispatch,
      commit
    }) {
      await apiDeleteUser(
        state.userDelete.id,
        (users) => {
          commit(USERS_DELETE_USER_BY_ID_SUCCESS, true)
          dispatch(ACTION_GET_USER_LIST)
          commit(USERS_USER_DELETE_BY_ID, null)
        },
        (errors) => {
          commit(USERS_DELETE_USER_BY_ID_FAILED, false);
        }
      );
    },

    [ACTION_SET_USER_DELETE_BY_ID]({
      commit
    }, userId) {
      apiGetUserById(
        userId,
        (result) => {
          commit(USERS_USER_DELETE_BY_ID, result.data);
          commit(USERS_DELETE_USER_BY_ID_SUCCESS, false);
        }
      );
    },

    [ACTION_RELOAD_GET_USER_LIST]: {
      root: true,
      handler(namespacedContext, payload) {
        namespacedContext.dispatch(ACTION_GET_USER_LIST);
      }
    },

    [ACTION_SET_LOADING]({
      commit
    }, isLoading) {
      commit(USERS_SET_LOADING, isLoading);
    },

    [ACTION_SEARCH_ALL]({
      dispatch,
      commit
    }, query) {
      dispatch(ACTION_SET_LOADING, true);
      apiSearchAll(query,
        (result) => {
          commit(USERS_GET_USER_LIST_SUCCESS, true);
          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          commit(USERS_GET_USER_LIST_FAILED, false);
          dispatch(ACTION_SET_LOADING, false);
        }
      )
    },
  },

  modules: {
    modal: addModal,
    editModal: editModal
  }
}