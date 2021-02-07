import axios from 'axios';
import modals from './modal';
import {
  apiGetNewsGroupById, 
  apiGetNewsGroups,
  apiDeleteNewsGroup
} from 'api@admin/newsgroups';
import {
  NEWSGROUPS_SET_LOADING,
  NEWSGROUPS_GET_NEWS_GROUP_LIST_SUCCESS,
  NEWSGROUPS_GET_NEWS_GROUP_LIST_FAILED,
  NEWSGROUPS_DELETE_GROUP_BY_ID_SUCCESS,
  NEWSGROUPS_DELETE_GROUP_BY_ID_FAILED,
  NEWSGROUPS_SET_NEWS_GROUP_LIST,
  NEWSGROUPS_GROUP_DELETE_BY_ID,
  NEWSGROUPS_SET_ERROR 
} from '../types/mutation-types';
import {
  ACTION_GET_NEWS_GROUP_LIST,
  ACTION_DELETE_NEWS_GROUP_BY_ID,
  ACTION_SET_NEWS_GROUP_DELETE_BY_ID,
  ACTION_RELOAD_GET_NEWS_GROUP_LIST,
  ACTION_SET_LOADING
} from '../types/action-types';

export default {
    namespaced: true,
    state: {
      newsGroups: [],
      newsGroupDelete: null,
      isDelete: false,
      isList: false,
      loading: false,
      errors:[]
    },
    getters: {
      newsGroups(state) {
        return state.newsGroups
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
        [NEWSGROUPS_SET_NEWS_GROUP_LIST](state, payload) {
            state.newsGroups = payload
        },

        [NEWSGROUPS_GROUP_DELETE_BY_ID](state, payload) {
          state.newsGroupDelete = payload
        },

        [NEWSGROUPS_GET_NEWS_GROUP_LIST_SUCCESS](state, payload) {
          state.isList = payload
        },

        [NEWSGROUPS_GET_NEWS_GROUP_LIST_FAILED](state, payload) {
          state.isList = payload
        },

        [NEWSGROUPS_DELETE_GROUP_BY_ID_SUCCESS](state, payload) {
          state.isDelete = payload
        },

        [NEWSGROUPS_DELETE_GROUP_BY_ID_FAILED](state, payload) {
          state.isDelete = payload
        },

        [NEWSGROUPS_SET_LOADING](state, payload) {
          state.loading = payload
        },

        [NEWSGROUPS_SET_ERROR](state, payload) {
          state.errors = payload
        }
    },

    actions: {
        async [ACTION_GET_NEWS_GROUP_LIST] ({ dispatch, commit }) {
          dispatch(ACTION_SET_LOADING, true);
          await apiGetNewsGroups(
            (newsGroups) => {
              commit(NEWSGROUPS_SET_NEWS_GROUP_LIST, newsGroups)
              commit(NEWSGROUPS_GET_NEWS_GROUP_LIST_SUCCESS, true)
            },
            (errors) => {
              commit(NEWSGROUPS_GET_NEWS_GROUP_LIST_FAILED, false)
            }
          );
          dispatch(ACTION_SET_LOADING, false);
        },

        async [ACTION_DELETE_NEWS_GROUP_BY_ID] ({state, dispatch, commit}) {
          await apiDeleteInfo(
            state.newsGroupDelete,
            (newsGroups) => {
              commit(NEWSGROUPS_DELETE_GROUP_BY_ID_SUCCESS, true)
              dispatch(ACTION_GET_NEWS_GROUP_LIST)
              commit(NEWSGROUPS_GROUP_DELETE_BY_ID, null)
            },
            (errors) => {
              commit(NEWSGROUPS_DELETE_GROUP_BY_ID_FAILED, false);
            }
          );
        },

        [ACTION_SET_NEWS_GROUP_DELETE_BY_ID] ({commit}, newsGroupId) {
          apiGetInfoById(
            newsGroupId,
            (result) => {
              commit(NEWSGROUPS_GROUP_DELETE_BY_ID, result.data);
              commit(NEWSGROUPS_DELETE_GROUP_BY_ID_SUCCESS, false);
            }
          );
        },

        [ACTION_RELOAD_GET_NEWS_GROUP_LIST] ({dispatch}, isReload) {
          if (isReload) {
            dispatch(ACTION_GET_NEWS_GROUP_LIST);
          }
        },

        [ACTION_SET_LOADING] ({commit} , isLoading) {
          commit(NEWSGROUPS_SET_LOADING, isLoading);
        },
    },

    modules: {
      modal: modals
    }
}
