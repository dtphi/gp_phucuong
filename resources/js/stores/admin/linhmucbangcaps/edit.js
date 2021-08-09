import AppConfig from 'api@admin/constants/app-config';
import {
  apiUpdateInfo
} from 'api@admin/linhmucbangcap';
import {
  INFOS_MODAL_SET_INFO,
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_UPDATE_INFO_SUCCESS,
  INFOS_MODAL_UPDATE_INFO_FAILED,
  INFOS_MODAL_SET_ERROR,
} from '../types/mutation-types';
import {
  ACTION_SET_LOADING,
  ACTION_UPDATE_INFO,
  ACTION_RESET_NOTIFICATION_INFO,
} from '../types/action-types';

const defaultState = () => {
  return {
    styleCss: '',
    loading: false,
    updateSuccess: false,
    info: {},
    errors: []
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
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
    },
  },

  mutations: {

    [INFOS_MODAL_SET_INFO](state, payload) {
      state.info = payload
    },

    [INFOS_MODAL_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [INFOS_MODAL_UPDATE_INFO_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },

    [INFOS_MODAL_UPDATE_INFO_FAILED](state, payload) {
      state.updateSuccess = payload
    },

    [INFOS_MODAL_SET_ERROR](state, payload) {
      state.errors = payload
    },
  },

  actions: {

    [ACTION_SET_LOADING]({
      commit
    }, isLoading) {
      commit(INFOS_MODAL_SET_LOADING, isLoading);
    },

    [ACTION_UPDATE_INFO]({
      dispatch,
      commit
    }, info) {
      dispatch(ACTION_SET_LOADING, true);
      
      apiUpdateInfo(info,
        (result) => {
          commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, AppConfig.comUpdateNoSuccess);
          commit(INFOS_MODAL_SET_INFO, info);

          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          commit(INFOS_MODAL_UPDATE_INFO_FAILED, AppConfig.comUpdateNoFail)

          dispatch(ACTION_SET_LOADING, false);
        }
      )
    },

    [ACTION_RESET_NOTIFICATION_INFO]({
      commit
    }, values) {
      commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, values);
    },
  }
}