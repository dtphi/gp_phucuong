import axios from 'axios';
import {
  apiInsertInfo
} from 'api@admin/information';
import {
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_INSERT_INFO_SUCCESS,
  INFOS_MODAL_INSERT_INFO_FAILED,
  INFOS_MODAL_SET_ERROR
} from '../types/mutation-types';
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_RELOAD_GET_INFO_LIST
} from '../types/action-types';
const NEWS = {
  id: 0,
  newsname: '',
  description: '',
  newslink: '',
  newsgroup_id: 0,
  newsgroupname: '',
  picture: '',
  context: ''
}

export default {
  namespaced: true,
  state: {
    isOpen: false,
    action: 'add',
    info: Object.assign({}, NEWS),
    infoId: 0,
    loading: false,
    updateSuccess: false,
    errors: []
  },
  getters: {
    isOpen(state) {
      return state.isOpen
    },
    info(state) {
      return state.info
    },
    loading(state) {
      return state.loading
    },
    updateSuccess(state) {
      return state.updateSuccess
    },
    errors(state) {
      return state.errors
    },
    isError(state) {
      return state.errors.length
    }
  },

  mutations: {

    [INFOS_MODAL_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [INFOS_MODAL_INSERT_INFO_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },

    [INFOS_MODAL_INSERT_INFO_FAILED](state, payload) {
      state.updateSuccess = payload
    },

    [INFOS_MODAL_SET_ERROR](state, payload) {
      state.errors = payload
    }
  },

  actions: {

    [ACTION_SET_LOADING]({
      commit
    }, isLoading) {
      commit(INFOS_MODAL_SET_LOADING, isLoading);
    },

    [ACTION_INSERT_INFO]({
      dispatch,
      commit
    }, info) {
      apiInsertInfo(
        info,
        (result) => {
          commit(INFOS_MODAL_INSERT_INFO_SUCCESS, true);

          dispatch(ACTION_RELOAD_GET_INFO_LIST, 'page', {
            root: true
          });
          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          commit(INFOS_MODAL_INSERT_INFO_FAILED, false)

          dispatch(ACTION_SET_LOADING, false);
        }
      )
    }
  }
}