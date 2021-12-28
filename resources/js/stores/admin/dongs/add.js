import AppConfig from 'api@admin/constants/app-config'
import { apiInsertInfoDong, } from 'api@admin/dong'
import { apiGetGiaoPhanInfos, } from 'api@admin/giaophan'
import {
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_INSERT_INFO_SUCCESS,
  INFOS_MODAL_INSERT_INFO_FAILED,
  SET_ERROR,
  INFOS_FORM_SET_MAIN_IMAGE,
  INFOS_GET_INFO_LIST_FAILED,
} from '../types/mutation-types'
import {
  ACTION_SET_LOADING,
  ACTION_SET_IMAGE,
  ACTION_RESET_NOTIFICATION_INFO,
} from '../types/action-types'

const defaultState = () => {
  return {
    isOpen: false,
    action: null,
    classShow: 'modal fade',
    styleCss: '',
    info: {
      date_available: null,
      name: '',
      giaophan_id: null,
      dia_chi: '',
      dien_thoai: '',
      email: '',
      viet: null,
      latin: null,
      noi_dung: null,
      active: 1,
      update_user: 0,
    },
    listGiaoPhan: [],
    isImgChange: true,
    listCategorysDisplay: [],
    listRelatedsDisplay: [],
    dropdownsRelateds: [],
    isGetInfoList: null,
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
    isGiaoPhan(state) {
      return state.listGiaoPhan
    },
    insertSuccess(state) {
      return state.insertSuccess
    },
  },

  mutations: {
    [INFOS_MODAL_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [INFOS_MODAL_INSERT_INFO_SUCCESS](state, payload) {
      state.insertSuccess = payload
    },

    [INFOS_MODAL_INSERT_INFO_FAILED](state, payload) {
      state.insertSuccess = payload
    },

    [SET_ERROR](state, payload) {
      state.errors = payload
    },

    [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
      state.info.image = payload
      state.isImgChange = true
    },
    INFO_GIAO_PHAN(state, payload) {
      state.listGiaoPhan = payload
    },
    [INFOS_GET_INFO_LIST_FAILED](state, payload) {
      state.isGetInfoList = payload
    },
  },

  actions: {
    // action get list giao phan
    ACTION_GET_LIST_GIAO_PHAN({ commit, }, params) {
      apiGetGiaoPhanInfos(
        (infos) => {
          commit('INFO_GIAO_PHAN', infos.data.results)
        },
        (errors) => {
          commit(INFOS_GET_INFO_LIST_FAILED, errors)
        },
        params
      )
    },

    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(INFOS_MODAL_SET_LOADING, isLoading)
    },

    ACTION_INSERT_INFO_DONG({ dispatch, commit, }, info) {
      apiInsertInfoDong(
        info,
        (result) => {
          if (result) {
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
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

    ACTION_INSERT_INFO_DONG_BACK({ dispatch, commit, }, info) {
      apiInsertInfoDong(
        info,
        (result) => {
          if (result) {
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
            dispatch('ACTION_RELOAD_GET_INFO_LIST_DONG', 'page', {
              root: true,
            })
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

    [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
      commit(INFOS_MODAL_INSERT_INFO_SUCCESS, values)
    },
  },
}
