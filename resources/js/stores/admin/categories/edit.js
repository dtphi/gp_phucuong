import AppConfig from 'api@admin/constants/app-config'
import { apiGetNewsGroupById, apiUpdateNewsGroup, } from 'api@admin/category'
import {
  NEWSGROUPS_MODAL_SET_OPEN_MODAL,
  NEWSGROUPS_MODAL_SET_CLOSE_MODAL,
  NEWSGROUPS_MODAL_SET_IS_OPEN_MODAL,
  NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID,
  NEWSGROUPS_MODAL_SET_NEWS_GROUP,
  NEWSGROUPS_MODAL_SET_LOADING,
  NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_SUCCESS,
  NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_SUCCESS,
  NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_FAILED,
  NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_FAILED,
  NEWSGROUPS_MODAL_SET_NEWS_GROUP_FAILED,
  NEWSGROUPS_MODAL_SET_NEWS_GROUP_SUCCESS,
  SET_ERROR,
  SELECT_DROPDOWN_PARENT_CATEGORY,
  SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY,
} from '../types/mutation-types'
import {
  ACTION_GET_NEWS_GROUP_BY_ID,
  ACTION_SET_LOADING,
  ACTION_SHOW_MODAL,
  ACTION_SHOW_MODAL_EDIT,
  ACTION_CLOSE_MODAL,
  ACTION_IS_OPEN_MODAL,
  ACTION_UPDATE_NEWS_GROUP,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_SELECT_DROPDOWN_PARENT_CATEGORY,
  ACTION_SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY,
} from '../types/action-types'

const defaultState = () => {
  return {
    isOpen: false,
    action: null,
    classShow: 'modal fade',
    styleCss: '',
    newsGroup: {
      category_id: null,
      category_name: '',
      name: '',
      tag: '',
      parent_id: 0,
      description: '',
      meta_title: '',
      meta_description: '',
      meta_keyword: '',
      sort_order: 0,
      status: 1,
      layout_id: null,
      path: null,
    },
    infoCategory: {
      category_name: '',
      category_id: null,
    },
    nameQuery: '',
    newsGroupId: 0,
    itemRoot: 0,
    loading: false,
    updateSuccess: false,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    newsGroupAdd(state) {
      return state.newsGroupAdd
    },
    isOpen(state) {
      return state.isOpen
    },
    action(state) {
      return state.action
    },
    classShow(state) {
      return state.classShow
    },
    styleCss(state) {
      return state.styleCss
    },
    newsGroup(state) {
      return state.newsGroup
    },
    infoCategory(state) {
      return state.infoCategory
    },
    getNameQuery(state) {
      var str = state.nameQuery

      if (typeof str === 'undefined' || str === null) {
        return ''
      }

      return str
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
    [NEWSGROUPS_MODAL_SET_OPEN_MODAL](state, payload) {
      state.action = payload
      state.classShow = 'modal fade show'
      state.styleCss = 'display:block'
      state.updateSuccess = false
    },

    [NEWSGROUPS_MODAL_SET_CLOSE_MODAL](state) {
      state.action = 'closeModal'
      state.classShow = 'modal fade'
      state.styleCss = 'display:none'
      state.errors = []
    },

    [NEWSGROUPS_MODAL_SET_IS_OPEN_MODAL](state, payload) {
      state.isOpen = payload
    },

    [NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID](state, payload) {
      state.newsGroupId = payload
    },

    [NEWSGROUPS_MODAL_SET_NEWS_GROUP](state, payload) {
      state.newsGroup = payload
    },

    [NEWSGROUPS_MODAL_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },

    [NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_FAILED](state, payload) {
      state.updateSuccess = payload
    },

    [NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },

    [NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_FAILED](state, payload) {
      state.updateSuccess = payload
    },

    [SET_ERROR](state, payload) {
      state.errors = payload
    },
    [SELECT_DROPDOWN_PARENT_CATEGORY](state, payload) {
      if (parseInt(payload.category_id) !== parseInt(state.newsGroupId)) {
        state.nameQuery = payload.name
        state.newsGroup.parent_id = payload.category_id
      }
    },
    [SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY](state, payload) {
      state.nameQuery = payload.name
      state.infoCategory = payload
    },
  },

  actions: {
    [ACTION_SHOW_MODAL]({ state, dispatch, commit, }, payload) {
      state.itemRoot = payload.itemRoot
      commit(NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID, payload.groupId)
      commit(NEWSGROUPS_MODAL_SET_OPEN_MODAL, payload.action)

      dispatch(ACTION_GET_NEWS_GROUP_BY_ID, payload.groupId)
    },

    [ACTION_SHOW_MODAL_EDIT]({ dispatch, commit, }, payload) {
      commit(NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID, payload.groupId)
      commit(NEWSGROUPS_MODAL_SET_OPEN_MODAL, payload.action)

      dispatch(ACTION_GET_NEWS_GROUP_BY_ID, payload.groupId)
    },

    [ACTION_GET_NEWS_GROUP_BY_ID]({ dispatch, commit, }, newsGroupId) {
      dispatch(ACTION_SET_LOADING, true)
      if (newsGroupId) {
        commit(NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID, newsGroupId)
        apiGetNewsGroupById(
          newsGroupId,
          (result) => {
            commit(NEWSGROUPS_MODAL_SET_NEWS_GROUP_SUCCESS, true)
            commit(NEWSGROUPS_MODAL_SET_NEWS_GROUP, result.data)
            commit(SELECT_DROPDOWN_PARENT_CATEGORY, {
              name: result.data.path,
              category_id: result.data.parent_id,
            })

            dispatch(ACTION_SET_LOADING, false)
            dispatch(ACTION_IS_OPEN_MODAL, true)
          },
          (errors) => {
            commit(NEWSGROUPS_MODAL_SET_NEWS_GROUP_FAILED, errors)

            dispatch(ACTION_SET_LOADING, false)
          }
        )
      } else {
        dispatch(ACTION_SET_LOADING, false)
      }
    },

    [ACTION_CLOSE_MODAL]({ dispatch, commit, }) {
      commit(NEWSGROUPS_MODAL_SET_CLOSE_MODAL)

      dispatch(ACTION_IS_OPEN_MODAL, false)
    },

    [ACTION_IS_OPEN_MODAL]({ commit, }, payload) {
      commit(NEWSGROUPS_MODAL_SET_IS_OPEN_MODAL, payload)
    },

    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(NEWSGROUPS_MODAL_SET_LOADING, isLoading)
    },

    [ACTION_UPDATE_NEWS_GROUP]({ state, dispatch, commit, }, newsGroup) {
      dispatch(ACTION_SET_LOADING, true)
      apiUpdateNewsGroup(
        state.newsGroupId,
        newsGroup,
        (result) => {
          if (result) {
            commit(
              NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_SUCCESS,
              AppConfig.comUpdateNoSuccess
            )
          }
          dispatch(ACTION_SET_LOADING, false)
          dispatch(ACTION_CLOSE_MODAL)
        },
        (errors) => {
          commit(
            NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_FAILED,
            AppConfig.comUpdateNoFail
          )
          commit(SET_ERROR, errors)
          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },

    [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
      commit(NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_SUCCESS, values)
    },

    [ACTION_SELECT_DROPDOWN_PARENT_CATEGORY]({ commit, }, category) {
      commit(SELECT_DROPDOWN_PARENT_CATEGORY, category)
    },

    [ACTION_SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY]({ commit, }, category) {
      commit(SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY, category)
    },
  },
}
