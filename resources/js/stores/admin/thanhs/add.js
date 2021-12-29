import AppConfig from 'api@admin/constants/app-config'
import { apiInsertInfo, } from 'api@admin/thanh'
import { MODULE_MODULE_THANH, } from '../types/module-types'
import {
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_INSERT_INFO_SUCCESS,
  INFOS_MODAL_INSERT_INFO_FAILED,
  INFOS_MODAL_SET_ERROR,
  INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST,
  INFOS_FORM_ADD_INFO_TO_RELATED_LIST,
  INFOS_FORM_ADD_INFO_TO_RELATED_DISPLAY_LIST,
  INFOS_FORM_SET_MAIN_IMAGE,
  INFOS_FORM_SET_DROPDOWN_RELATED_LIST,
  INFOS_FORM_SELECT_DROPDOWN_INFO_TO_RELATED,
} from '../types/mutation-types'
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_RELOAD_GET_INFO_LIST,
  ACTION_INSERT_INFO_BACK,
  ACTION_SET_IMAGE,
} from '../types/action-types'

const defaultState = () => {
  return {
    isOpen: false,
    action: null,
    classShow: 'modal fade',
    styleCss: '',
    info: {
      image: '',
      date_available: null,
      sort_order: 1,
      status: 1,
      name: '',
      meta_title: '',
      sort_description: '',
      information_type: 1,
      description: '',
      tag: '',
      meta_description: '',
      meta_keyword: '',
      multi_images: [],
      relateds: [],
      categorys: [],
      downloads: [],
      special_carousels: [],
    },
    isImgChange: true,
    listCategorysDisplay: [],
    listRelatedsDisplay: [],
    dropdownsRelateds: [],
    infoRelated: {
      information_id: 0,
      name: '',
    },
    infoId: 0,
    loading: false,
    insertSuccess: false,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
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
    },
  },

  mutations: {
    [INFOS_FORM_SELECT_DROPDOWN_INFO_TO_RELATED](state, payload) {
      state.infoRelated = payload
    },

    [INFOS_FORM_SET_DROPDOWN_RELATED_LIST](state, payload) {
      state.dropdownsRelateds = payload
    },

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
    },

    [INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST](state, payload) {
      state.info.categorys = payload
    },

    [INFOS_FORM_ADD_INFO_TO_RELATED_LIST](state, payload) {
      state.info.relateds = payload
    },

    [INFOS_FORM_ADD_INFO_TO_RELATED_DISPLAY_LIST](state, payload) {
      state.listRelatedsDisplay = payload
    },

    [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
      state.info.image = payload
      state.isImgChange = true
    },
  },

  actions: {
    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(INFOS_MODAL_SET_LOADING, isLoading)
    },

    [ACTION_INSERT_INFO]({ dispatch, commit, }, info) {
      apiInsertInfo(
        info,
        (result) => {
          if (result) {
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
            commit(INFOS_MODAL_SET_ERROR, [])
          }
          dispatch(ACTION_SET_LOADING, false)
        },
        (errors) => {
          commit(
            INFOS_MODAL_INSERT_INFO_FAILED,
            AppConfig.comInsertNoFail
          )
          commit(INFOS_MODAL_SET_ERROR, errors)

          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },

    [ACTION_INSERT_INFO_BACK]({ dispatch, commit, }, info) {
      apiInsertInfo(
        info,
        (result) => {
          if (result) {
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
            dispatch(
              `${MODULE_MODULE_THANH}_${ACTION_RELOAD_GET_INFO_LIST}`,
              'page',
              {
                root: true,
              }
            )
          }
        },
        (errors) => {
          commit(
            INFOS_MODAL_INSERT_INFO_FAILED,
            AppConfig.comInsertNoFail
          )
          commit(INFOS_MODAL_SET_ERROR, errors)

          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },

    [ACTION_SET_IMAGE]({ commit, }, imgFile) {
      commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile)
    },
  },
}
