import AppConfig from 'api@admin/constants/app-config'
import { apiInsertInfo, } from 'api@admin/coso'
import { MODULE_MODULE_CO_SO, } from '../types/module-types'
import {
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_INSERT_INFO_SUCCESS,
  INFOS_MODAL_INSERT_INFO_FAILED,
  SET_ERROR,
  INFOS_FORM_SET_MAIN_IMAGE,
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
    [INFOS_MODAL_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [INFOS_MODAL_INSERT_INFO_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },

    [INFOS_MODAL_INSERT_INFO_FAILED](state, payload) {
      state.updateSuccess = payload
    },

    [SET_ERROR](state, payload) {
      state.errors = payload
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
            commit(SET_ERROR, [])
          }
          dispatch(ACTION_SET_LOADING, false)
        },
        (errors) => {
          commit(
            INFOS_MODAL_INSERT_INFO_FAILED,
            AppConfig.comInsertNoFail
          )
          commit(SET_ERROR, errors)

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
              `${MODULE_MODULE_CO_SO}_${ACTION_RELOAD_GET_INFO_LIST}`,
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
          commit(SET_ERROR, errors)

          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },

    [ACTION_SET_IMAGE]({ commit, }, imgFile) {
      commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile)
    },
  },
}
