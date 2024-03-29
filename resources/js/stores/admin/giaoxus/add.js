import AppConfig from 'api@admin/constants/app-config'
import { apiInsertInfoGiaoXu, } from 'api@admin/giaoxu'
import { apiGetGiaoHatInfos, } from 'api@admin/giaohat'
import {
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_INSERT_INFO_SUCCESS,
  INFOS_MODAL_INSERT_INFO_FAILED,
  SET_ERROR,
  INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST,
  INFOS_FORM_ADD_INFO_TO_RELATED_LIST,
  INFOS_FORM_ADD_INFO_TO_RELATED_DISPLAY_LIST,
  INFOS_FORM_SET_MAIN_IMAGE,
  INFOS_FORM_SET_DROPDOWN_RELATED_LIST,
  INFOS_FORM_SELECT_DROPDOWN_INFO_TO_RELATED,
} from '../types/mutation-types'
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO_BACK,
  ACTION_SET_IMAGE,
  ACTION_RESET_NOTIFICATION_INFO,
} from '../types/action-types'
import { getField, updateField } from 'vuex-map-fields'

const defaultState = () => {
  return {
    isOpen: false,
    action: null,
    classShow: 'modal fade',
    styleCss: '',
    info: {
      name: '',
      ngay_thanh_lap: null,
      image: '',
      date_available: null,
      dia_chi: '',
      dien_thoai: '',
      email: '',
      active: 1,
      dan_so: '',
      so_tin_huu: '',
      gio_le: '',
      viet: null,
      latin: null,
      noi_dung: '',
      type: 'giaoxu',
      giao_hat_id: null,
    },
    isGetInfoList: null,
    listGiaoHat: [],
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
    insertSuccess(state) {
      return state.insertSuccess
    },
    errors(state) {
      return state.errors
    },
    isError(state) {
      return state.errors.length
    },
    isGiaoHat(state) {
      return state.listGiaoHat
    },
    getInfoField(state) {
      return getField(state.info)
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
      state.insertSuccess = payload
    },

    [INFOS_MODAL_INSERT_INFO_FAILED](state, payload) {
      state.insertSuccess = payload
    },

    [SET_ERROR](state, payload) {
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
    INFO_GIAO_HAT(state, payload) {
      state.listGiaoHat = payload
    },
    updateInfoField(state, field) {
      return updateField(state.info, field)
    },
  },

  actions: {
    // GET LIST GIAO HAT
    ACTION_GET_LIST_GIAO_HAT({ commit, }, params) {
      apiGetGiaoHatInfos(
        (infos) => {
          commit('INFO_GIAO_HAT', infos.data.results)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        },
        params
      )
    },

    // GET ACTION LOADING PAGE
    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(INFOS_MODAL_SET_LOADING, isLoading)
    },

    // ACTION INSERT INFO GIAO XU
    ACTION_INSERT_INFO_GIAOXU({ dispatch, commit, }, info) {
      apiInsertInfoGiaoXu(
        info,
        (result) => {
          if (result) {
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
            dispatch(ACTION_SET_LOADING, false)
          }
        },
        (errors) => {
          commit(
            INFOS_MODAL_INSERT_INFO_FAILED,
            AppConfig.comInsertNoFail
          )
          dispatch(ACTION_SET_LOADING, false)
          commit(SET_ERROR, errors)
        }
      )
    },

    [ACTION_INSERT_INFO_BACK]({ dispatch, commit, }, info) {
      apiInsertInfoGiaoXu(
        info,
        (result) => {
          if (result) {
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
            dispatch(
              'ACTION_RELOAD_GET_INFO_LIST_GIAO_XU',
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

    [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
      commit(INFOS_MODAL_INSERT_INFO_SUCCESS, values)
    },
  },
}
