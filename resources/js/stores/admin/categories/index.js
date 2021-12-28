import add from './add'
import edit from './edit'
import {
  apiGetNewsGroupById,
  apiGetNewsGroups,
  apiDeleteNewsGroup,
  apiSearchAll,
  apiGetDropdownCategories,
} from 'api@admin/category'
import { MODULE_NEWS_CATEGORY, } from '../types/module-types'
import {
  NEWSGROUPS_SET_LOADING,
  NEWSGROUPS_GET_NEWS_GROUP_LIST_SUCCESS,
  NEWSGROUPS_GET_NEWS_GROUP_LIST_FAILED,
  NEWSGROUPS_DELETE_GROUP_BY_ID_SUCCESS,
  NEWSGROUPS_DELETE_GROUP_BY_ID_FAILED,
  NEWSGROUPS_SET_NEWS_GROUP_LIST,
  NEWSGROUPS_GROUP_DELETE_BY_ID,
  SET_ERROR,
  NEWSGROUPS_FORM_SET_DROPDOWN_CATEGORY_LIST,
  NEWSGROUPS_FORM_GET_DROPDOWN_CATEGORY_SUCCESS,
  NEWSGROUPS_FORM_GET_DROPDOWN_CATEGORY_FAILED,
} from '../types/mutation-types'
import {
  ACTION_GET_NEWS_GROUP_LIST,
  ACTION_DELETE_NEWS_GROUP_BY_ID,
  ACTION_SET_NEWS_GROUP_DELETE_BY_ID,
  ACTION_RELOAD_GET_NEWS_GROUP_LIST,
  ACTION_SET_LOADING,
  ACTION_SEARCH_ALL,
  ACTION_GET_DROPDOWN_CATEGORY_LIST,
} from '../types/action-types'
import { fn_redirect_url, } from '@app/api/utils/fn-helper'
import { fnCheckProp, } from '@app/common/util'

const defaultState = () => {
  return {
    newsGroups: [],
    dropdownCategories: [],
    total: 0,
    newsGroupDelete: null,
    isDelete: false,
    isList: false,
    loading: false,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
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
    },
  },

  mutations: {
    [NEWSGROUPS_FORM_SET_DROPDOWN_CATEGORY_LIST](state, payload) {
      state.dropdownCategories = payload
    },

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

    [SET_ERROR](state, payload) {
      state.errors = payload
    },
  },

  actions: {
    [ACTION_GET_DROPDOWN_CATEGORY_LIST]({ commit, }, filterName) {
      const params = {
        filter_name: filterName,
      }
      apiGetDropdownCategories(
        (result) => {
          commit(
            NEWSGROUPS_FORM_GET_DROPDOWN_CATEGORY_SUCCESS,
            'Success'
          )

          commit(NEWSGROUPS_FORM_SET_DROPDOWN_CATEGORY_LIST, result)
        },
        (errors) => {
          commit(
            NEWSGROUPS_FORM_GET_DROPDOWN_CATEGORY_FAILED,
            'Failed'
          )
          commit(SET_ERROR, errors)
        },
        params
      )
    },

    [ACTION_GET_NEWS_GROUP_LIST]({ dispatch, commit, }, params) {
      dispatch(ACTION_SET_LOADING, true)

      apiGetNewsGroups(
        (newsGroups) => {
          commit(
            NEWSGROUPS_SET_NEWS_GROUP_LIST,
            newsGroups.data.results
          )
          commit(NEWSGROUPS_GET_NEWS_GROUP_LIST_SUCCESS, true)
          var pagination = {
            current_page: 1,
            total: 0,
          }
          if (fnCheckProp(newsGroups.data, 'pagination')) {
            pagination = newsGroups.data.pagination
          }
          var configs = {
            moduleActive: {
              name: MODULE_NEWS_CATEGORY,
              actionList: ACTION_GET_NEWS_GROUP_LIST,
            },
            collectionData: pagination,
          }

          dispatch('setConfigApp', configs, {
            root: true,
          })

          dispatch(ACTION_SET_LOADING, false)
        },
        (errors) => {
          commit(NEWSGROUPS_GET_NEWS_GROUP_LIST_FAILED, false)
          commit(SET_ERROR, errors)
          dispatch(ACTION_SET_LOADING, false)
        },
        params
      )
    },

    async [ACTION_DELETE_NEWS_GROUP_BY_ID](
      { state, dispatch, commit, },
      categoryId
    ) {
      if (categoryId) {
        commit(NEWSGROUPS_GROUP_DELETE_BY_ID, {
          newsgroup: {
            category_id: categoryId,
          },
        })
      }

      await apiDeleteNewsGroup(
        state.newsGroupDelete.newsgroup.category_id,
        (newsGroups) => {
          if (newsGroups) {
            commit(NEWSGROUPS_DELETE_GROUP_BY_ID_SUCCESS, true)
            dispatch(ACTION_GET_NEWS_GROUP_LIST)
            commit(NEWSGROUPS_GROUP_DELETE_BY_ID, null)
          }
        },
        (errors) => {
          commit(NEWSGROUPS_DELETE_GROUP_BY_ID_FAILED, false)
          commit(SET_ERROR, errors)
        }
      )
    },

    [ACTION_SET_NEWS_GROUP_DELETE_BY_ID]({ commit, }, newsGroupId) {
      apiGetNewsGroupById(newsGroupId, (result) => {
        commit(NEWSGROUPS_GROUP_DELETE_BY_ID, result.data)
        commit(NEWSGROUPS_DELETE_GROUP_BY_ID_SUCCESS, false)
      })
    },

    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(NEWSGROUPS_SET_LOADING, isLoading)
    },

    [ACTION_RELOAD_GET_NEWS_GROUP_LIST]: {
      root: true,
      handler() {
        return fn_redirect_url('admin/news-categories')
      },
    },

    [ACTION_SEARCH_ALL]({ dispatch, commit, }, query) {
      dispatch(ACTION_SET_LOADING, true)
      apiSearchAll(
        query,
        (result) => {
          if (result) {
            commit(NEWSGROUPS_GET_NEWS_GROUP_LIST_SUCCESS, true)
          }
          dispatch(ACTION_SET_LOADING, false)
        },
        (errors) => {
          commit(NEWSGROUPS_GET_NEWS_GROUP_LIST_FAILED, false)
          commit(SET_ERROR, errors)
          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },
  },

  modules: {
    add: add,
    edit: edit,
  },
}
