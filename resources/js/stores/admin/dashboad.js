import {
  apiGetInfos
} from 'api@admin/information';
import {
  apiGetNewsGroups
} from 'api@admin/category';
import {
  apiGetUsers
} from 'api@admin/user';
import {
  apiGetGiaoPhanInfos
} from 'api@admin/giaophan';
import {
  apiGetLinhMucInfos
} from 'api@admin/linhmuc';

import {
  INFOS_SET_INFO_LIST,
  INFOS_GET_INFO_LIST_SUCCESS,
  INFOS_GET_INFO_LIST_FAILED,
  INFOS_SET_LOADING,
  INFOS_SET_ERROR,
  NEWSGROUPS_GET_NEWS_GROUP_LIST_SUCCESS,
  NEWSGROUPS_GET_NEWS_GROUP_LIST_FAILED,
  USERS_GET_USER_LIST_SUCCESS,
  USERS_GET_USER_LIST_FAILED,
} from './types/mutation-types';
import {
  ACTION_GET_INFO_LIST,
  ACTION_SET_LOADING,
  ACTION_GET_NEWS_GROUP_LIST,
  ACTION_GET_USER_LIST
} from './types/action-types';

const defaultState = () => {
  return {
    infos: [],
    isGetInfoList: null,
    infoTotal: 0,
    isGetCategoryList: null,
    categoryTotal: 0,
    userTotal: 0,
    isGetUserList: null,
    giaoPhanTotal: 0,
    linhMucTotal: 0,
    loading: false,
    errors: []
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  mutations: {
    [INFOS_SET_INFO_LIST](state, payload) {
      state.infos = payload
    },
    [INFOS_GET_INFO_LIST_SUCCESS](state, payload) {
      state.isGetInfoList = payload
    },

    [INFOS_GET_INFO_LIST_FAILED](state, payload) {
      state.isGetInfoList = payload
    },
    [INFOS_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [INFOS_SET_ERROR](state, payload) {
      state.errors = payload
    },

    [NEWSGROUPS_GET_NEWS_GROUP_LIST_SUCCESS](state, payload) {
      state.isGetCategoryList = payload
    },

    [NEWSGROUPS_GET_NEWS_GROUP_LIST_FAILED](state, payload) {
      state.isGetCategoryList = payload
    },

    [USERS_GET_USER_LIST_SUCCESS](state, payload) {
      state.isGetUserList = payload
    },

    [USERS_GET_USER_LIST_FAILED](state, payload) {
      state.isGetUserList = payload
    },

    setInfoTotal(state, payload) {
      state.infoTotal = payload
    },

    setCategoryTotal(state, payload) {
      state.categoryTotal = payload
    },

    setUserTotal(state, payload) {
      state.userTotal = payload
    },

    setGiaoPhanTotal(state, payload) {
      state.giaoPhanTotal = payload
    },

    setLinhMucTotal(state, payload) {
      state.linhMucTotal = payload
    }
  },
  actions: {
    ACTION_GET_INFO_GIAO_PHAN_LIST({
      commit
    }, params) {
      apiGetGiaoPhanInfos(
        (infos) => {
          if (infos.data.hasOwnProperty('pagination')) {
            if (parseInt(infos.data.pagination.total)) {
              commit('setGiaoPhanTotal', infos.data.pagination.total);
            }
          }
        },
        (errors) => {
        },
        params
      );
    },

    ACTION_GET_INFO_LINH_MUC_LIST({
      commit
    }, params) {
      apiGetLinhMucInfos(
        (infos) => {
          if (infos.data.hasOwnProperty('pagination')) {
            if (parseInt(infos.data.pagination.total)) {
              commit('setLinhMucTotal', infos.data.pagination.total);
            }
          }
        },
        (errors) => {
        },
        params
      );
    },

    [ACTION_GET_USER_LIST]({
      commit
    }, params) {
      apiGetUsers(
        (users) => {
          if (users.meta.hasOwnProperty('total')) {
            if (parseInt(users.meta.total)) {
              commit('setUserTotal', users.meta.total);
            }
          }

          commit(USERS_GET_USER_LIST_SUCCESS, true)
        },
        (errors) => {
          commit(USERS_GET_USER_LIST_FAILED, false)
        },
        params
      );
    },

    [ACTION_GET_NEWS_GROUP_LIST]({
      commit
    }, params) {

      apiGetNewsGroups(
        (newsGroups) => {
          commit(NEWSGROUPS_GET_NEWS_GROUP_LIST_SUCCESS, true);

          if (newsGroups.data.hasOwnProperty('pagination')) {
            if (parseInt(newsGroups.data.pagination.total)) {
              commit('setCategoryTotal', newsGroups.data.pagination.total);
            }
          }
        },
        (errors) => {
          commit(NEWSGROUPS_GET_NEWS_GROUP_LIST_FAILED, false);
        },
        params
      );
    },

    [ACTION_GET_INFO_LIST]({
      dispatch,
      commit
    }, params) {
      dispatch(ACTION_SET_LOADING, true);
      apiGetInfos(
        (infos) => {
          commit(INFOS_SET_INFO_LIST, infos.data.results);
          commit(INFOS_GET_INFO_LIST_SUCCESS, true);

          if (infos.data.hasOwnProperty('pagination')) {
            if (parseInt(infos.data.pagination.total)) {
              commit('setInfoTotal', infos.data.pagination.total);
            }
          }

          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          commit(INFOS_GET_INFO_LIST_FAILED, errors);

          dispatch(ACTION_SET_LOADING, false);
        },
        params
      );
    },

    [ACTION_SET_LOADING]({
      commit
    }, isLoading) {
      commit(INFOS_SET_LOADING, isLoading);
    },
  }
}