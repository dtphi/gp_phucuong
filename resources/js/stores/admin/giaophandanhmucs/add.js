import AppConfig from 'api@admin/constants/app-config'
import {
  apiGetGiaoPhanDanhMucsById,
  apiInsertGiaoPhanDanhMucs,
} from 'api@admin/giaophandanhmuc'
import {
  NEWSGROUPS_MODAL_SET_OPEN_MODAL,
  NEWSGROUPS_MODAL_SET_CLOSE_MODAL,
  NEWSGROUPS_MODAL_SET_IS_OPEN_MODAL,
  NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID,
  NEWSGROUPS_MODAL_SET_NEWS_GROUP,
  NEWSGROUPS_MODAL_SET_LOADING,
  NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_SUCCESS,
  NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_FAILED,
  SET_ERROR,
} from '../types/mutation-types'
import {
  ACTION_GET_NEWS_GROUP_BY_ID,
  ACTION_SET_LOADING,
  ACTION_SHOW_MODAL,
  ACTION_CLOSE_MODAL,
  ACTION_IS_OPEN_MODAL,
  ACTION_INSERT_NEWS_GROUP,
  ACTION_RELOAD_GET_NEWS_GROUP_LIST,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_SELECT_DROPDOWN_PARENT_CATEGORY,
  ACTION_INSERT_NEWS_GROUP_BACK,
} from '../types/action-types'

const defaultState = () => {
  return {
    isOpen: false,
    action: null,
    classShow: 'modal fade',
    styleCss: '',
    newsGroupAdd: {
      category_id: null,
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
      nameQuery: '',
    },
    newsGroupId: 0,
    itemRoot: 0,
    loading: false,
    insertSuccess: false,
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
    nameQuery(state) {
      return state.newsGroupAdd.nameQuery
    },
    loading(state) {
      return state.loading
    },
    insertSuccess(state) {
      return state.insertSuccess
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
      state.insertSuccess = false
      state.newsGroupId = 0
    },

    [NEWSGROUPS_MODAL_SET_CLOSE_MODAL](state) {
      const initState = defaultState()

      Object.assign(state.newsGroupAdd, initState.newsGroupAdd)
      state.errors = []
    },

    [NEWSGROUPS_MODAL_SET_IS_OPEN_MODAL](state, payload) {
      state.isOpen = payload
    },

    [NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID](state, payload) {
      state.newsGroupId = payload
    },

    [NEWSGROUPS_MODAL_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_SUCCESS](state, payload) {
      state.insertSuccess = payload
    },

    [NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_FAILED](state, payload) {
      state.insertSuccess = payload
    },

    [SET_ERROR](state, payload) {
      state.errors = payload
    },
  },

  actions: {
    [ACTION_SHOW_MODAL]({ state, dispatch, commit, }, payload) {
      state.itemRoot = payload.itemRoot
      commit(NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID, payload.groupId)
      commit(NEWSGROUPS_MODAL_SET_OPEN_MODAL, payload.action)

      dispatch(ACTION_GET_NEWS_GROUP_BY_ID, payload.groupId)
    },

    [ACTION_GET_NEWS_GROUP_BY_ID]({ dispatch, commit, }, newsGroupId) {
      dispatch(ACTION_SET_LOADING, true)
      if (newsGroupId) {
        apiGetGiaoPhanDanhMucsById(
          newsGroupId,
          (result) => {
            commit(NEWSGROUPS_MODAL_SET_NEWS_GROUP, result.data)

            dispatch(ACTION_SET_LOADING, false)
            dispatch(ACTION_IS_OPEN_MODAL, true)
          },
          (errors) => {
            commit(SET_ERROR, errors)

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

    // insert giao phan danh muc
    [ACTION_INSERT_NEWS_GROUP]({ dispatch, commit, }, danhmucs) {
      dispatch(ACTION_SET_LOADING, true)
      apiInsertGiaoPhanDanhMucs(
        danhmucs,
        (result) => {
          if (result) {
            commit(
              NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
            commit(SET_ERROR, [])
          }
          dispatch(ACTION_SET_LOADING, false)
          dispatch(ACTION_CLOSE_MODAL)
        },
        (errors) => {
          commit(
            NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_FAILED,
            AppConfig.comInsertNoFail
          )
          commit(SET_ERROR, errors)

          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },

    [ACTION_INSERT_NEWS_GROUP_BACK]({ dispatch, commit, }, danhmucs) {
      dispatch(ACTION_SET_LOADING, true)
      apiInsertGiaoPhanDanhMucs(
        danhmucs,
        (result) => {
          if (result) {
            commit(
              NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_SUCCESS,
              AppConfig.comInsertNoSuccess
            )

            dispatch(ACTION_RELOAD_GET_NEWS_GROUP_LIST, null, {
              root: true,
            })
          }
        },
        (errors) => {
          commit(
            NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_FAILED,
            AppConfig.comInsertNoFail
          )
          commit(SET_ERROR, errors)

          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },

    [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
      commit(NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_SUCCESS, values)
    },

    [ACTION_SELECT_DROPDOWN_PARENT_CATEGORY]({ state, }, category) {
      state.newsGroupAdd.nameQuery = category.name
      state.newsGroupAdd.parent_id = category.category_id
    },
  },
}
