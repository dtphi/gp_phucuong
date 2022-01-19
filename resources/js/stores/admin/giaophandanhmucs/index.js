import add from './add'
import edit from './edit'
import {
  apiDeleteGiaoPhanDanhMucs,
  apiSearchAll,
  apiGetDropdownDanhMucs,
  apiGetGiaoPhanDanhMucs,
} from 'api@admin/giaophandanhmuc'
import { MODULE_MODULE_DANHMUC_GIAOPHAN, } from '../types/module-types'
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
} from '../types/mutation-types'
import {
  ACTION_GET_NEWS_GROUP_LIST,
  ACTION_DELETE_NEWS_GROUP_BY_ID,
  ACTION_RELOAD_GET_NEWS_GROUP_LIST,
  ACTION_SET_LOADING,
  ACTION_SEARCH_ALL,
  ACTION_GET_DROPDOWN_CATEGORY_LIST,
} from '../types/action-types'
import { fn_redirect_url, } from '@app/api/utils/fn-helper'
import { fnCheckProp, } from '@app/common/util'

const defaultState = () => {
  return {
    giaophandanhmucs: [],
    dropdownCategories: [],
    total: 0,
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
    newsGroupsGiaoPhan(state) {
      return state.giaophandanhmucs
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
      state.giaophandanhmucs = payload
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
      apiGetDropdownDanhMucs(
        (result) => {
          commit(NEWSGROUPS_FORM_SET_DROPDOWN_CATEGORY_LIST, result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        },
        params
      )
    },

    // action danh muc giao phan
    [ACTION_GET_NEWS_GROUP_LIST]({ dispatch, commit, }, params) {
      dispatch(ACTION_SET_LOADING, true)
      apiGetGiaoPhanDanhMucs(
        (danhmucs) => {
          commit(
            NEWSGROUPS_SET_NEWS_GROUP_LIST,
            danhmucs.data.results
          )
          commit(NEWSGROUPS_GET_NEWS_GROUP_LIST_SUCCESS, true)
          var pagination = {
            current_page: 1,
            total: 0,
          }
          if (fnCheckProp(danhmucs.data, 'pagination')) {
            pagination = danhmucs.data.pagination
          }
          var configs = {
            moduleActive: {
              name: MODULE_MODULE_DANHMUC_GIAOPHAN,
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
      await apiDeleteGiaoPhanDanhMucs(
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

    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(NEWSGROUPS_SET_LOADING, isLoading)
    },

    [ACTION_RELOAD_GET_NEWS_GROUP_LIST]: {
      root: true,
      handler() {
        return fn_redirect_url('admin/giao-phan/danh-mucs')
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
