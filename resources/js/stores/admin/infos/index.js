import axios from 'axios';
import modals from './modal';
import adds from './add';
import edits from './edit';
import {
  apiGetInfoById,
  apiGetInfos,
  apiDeleteInfo,
  apiSearchAll
} from 'api@admin/information';
import {
  MODULE_INFO,
} from '../types/module-types';
import {
  INFOS_SET_LOADING,
  INFOS_GET_INFO_LIST_SUCCESS,
  INFOS_GET_INFO_LIST_FAILED,
  INFOS_DELETE_INFO_BY_ID_SUCCESS,
  INFOS_DELETE_INFO_BY_ID_FAILED,
  INFOS_SET_INFO_LIST,
  INFOS_INFO_DELETE_BY_ID,
  INFOS_SET_INFO_DELETE_BY_ID_FAILED,
  INFOS_SET_INFO_DELETE_BY_ID_SUCCESS,
  INFOS_SET_ERROR
} from '../types/mutation-types';
import {
  ACTION_GET_INFO_LIST,
  ACTION_DELETE_INFO_BY_ID,
  ACTION_SET_INFO_DELETE_BY_ID,
  ACTION_RELOAD_GET_INFO_LIST,
  ACTION_SET_LOADING,
  ACTION_SEARCH_ALL
} from '../types/action-types';
import {
  fn_redirect_url
} from '@app/api/utils/fn-helper';

export default {
  namespaced: true,
  state: {
    infos: [],
    infoDelete: null,
    isDelete: false,
    isList: false,
    loading: false,
    errors: []
  },
  getters: {
    infos(state) {
      return state.infos
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
    [INFOS_SET_INFO_LIST](state, payload) {
      state.infos = payload
    },

    [INFOS_INFO_DELETE_BY_ID](state, payload) {
      state.infoDelete = payload
    },

    [INFOS_SET_INFO_DELETE_BY_ID_FAILED](state, payload) {
      state.isDelete = false;
      state.errors = payload;
    },

    [INFOS_SET_INFO_DELETE_BY_ID_SUCCESS](state, payload) {
      state.isDelete = true;
      state.errors = payload;
    },

    [INFOS_GET_INFO_LIST_SUCCESS](state, payload) {
      state.isList = payload
    },

    [INFOS_GET_INFO_LIST_FAILED](state, payload) {
      state.isList = payload
    },

    [INFOS_DELETE_INFO_BY_ID_SUCCESS](state, payload) {
      state.isDelete = payload
    },

    [INFOS_DELETE_INFO_BY_ID_FAILED](state, payload) {
      state.isDelete = false;
      state.errors = payload;
    },

    [INFOS_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [INFOS_SET_ERROR](state, payload) {
      state.errors = payload
    }
  },

  actions: {
    async [ACTION_GET_INFO_LIST]({
      dispatch,
      commit
    }, params) {
      dispatch(ACTION_SET_LOADING, true);
      await apiGetInfos(
        (infos) => {
          commit(INFOS_SET_INFO_LIST, infos.data.results)
          dispatch('setConfigApp', {
            links: { ...infos.links
            },
            meta: { ...infos.meta
            },
            moduleActive: {
              name: MODULE_INFO,
              actionList: ACTION_GET_INFO_LIST
            }
          }, {
            root: true
          })
          commit(INFOS_GET_INFO_LIST_SUCCESS, true)
        },
        (errors) => {
          commit(INFOS_GET_INFO_LIST_FAILED, false)
        },
        params
      );
      dispatch(ACTION_SET_LOADING, false);
    },

    async [ACTION_DELETE_INFO_BY_ID]({
      state,
      dispatch,
      commit
    }) {
      if (state.infoDelete) {
        await apiDeleteInfo(
          state.infoDelete.id,
          (infos) => {
            commit(INFOS_DELETE_INFO_BY_ID_SUCCESS, true)
            dispatch(ACTION_GET_INFO_LIST)
            commit(INFOS_INFO_DELETE_BY_ID, null)
          },
          (errors) => {
            commit(INFOS_DELETE_INFO_BY_ID_FAILED, Object.values(errors));
          }
        );
      }
    },

    [ACTION_SET_INFO_DELETE_BY_ID]({
      commit
    }, infoId) {
      apiGetInfoById(
        infoId,
        (result) => {
          commit(INFOS_INFO_DELETE_BY_ID, result.data);
          commit(INFOS_SET_INFO_DELETE_BY_ID_SUCCESS, false);
        },
        (errors) => {
          commit(INFOS_SET_INFO_DELETE_BY_ID_FAILED, Object.values(errors));
        }
      );
    },

    [ACTION_RELOAD_GET_INFO_LIST]: {
      root: true,
      handler(namespacedContext, payload) {
        if (isNaN(payload)) {
          return fn_redirect_url('admin/news');
        } else {
          namespacedContext.dispatch(ACTION_GET_INFO_LIST);
        }
      }
    },

    [ACTION_SET_LOADING]({
      commit
    }, isLoading) {
      commit(INFOS_SET_LOADING, isLoading);
    },

    [ACTION_SEARCH_ALL]({
      dispatch,
      commit
    }, query) {
      dispatch(ACTION_SET_LOADING, true);
      apiSearchAll(query,
        (result) => {
          commit(INFOS_GET_INFO_LIST_SUCCESS, true);
          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          commit(INFOS_GET_INFO_LIST_FAILED, false);
          dispatch(ACTION_SET_LOADING, false);
        }
      )
    },
  },

  modules: {
    modal: modals,
    add: adds,
    edit: edits
  }
}