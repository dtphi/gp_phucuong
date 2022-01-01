import AppConfig from 'api@admin/constants/app-config'
import { apiGetInfoDongById, apiUpdateDongInfo, } from 'api@admin/dong'
import { apiGetGiaoPhanInfos, } from 'api@admin/giaophan'
import {
  INFOS_MODAL_SET_INFO_ID,
  INFOS_MODAL_SET_INFO_ID_FAILED,
  INFOS_MODAL_SET_INFO,
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_UPDATE_INFO_SUCCESS,
  INFOS_MODAL_UPDATE_INFO_FAILED,
  SET_ERROR,
  INFOS_FORM_SET_MAIN_IMAGE,
} from '../types/mutation-types'
import {
  ACTION_GET_INFO_BY_ID,
  ACTION_SET_LOADING,
  ACTION_SHOW_MODAL_EDIT,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_SET_IMAGE,
} from '../types/action-types'
import { config, } from '@app/api/admin/config'

const defaultState = () => {
  return {
    styleCss: '',
    isExistInfo: config.existStatus.checking,
    info: {
      date_available: null,
      name: '',
      giaophan_id: null,
      dia_chi: null,
      dien_thoai: null,
      email: '',
      viet: null,
      latin: null,
      noi_dung: null,
      active: 1,
      update_user: 0,
    },
    listGiaoPhan: [],
    isImgChange: false,
    listCategorysDisplay: [],
    listRelatedsDisplay: [],
    infoId: 0,
    loading: false,
    updateSuccess: false,
    errors: [],
    isGetInfoList: null,
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
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
    isNotExistValidate(state) {
      if (
        state.isExistInfo !== config.existStatus.checking ||
                state.isExistInfo !== config.existStatus.exist
      ) {
        return false
      }

      return true
    },
    isGiaoPhan(state) {
      return state.listGiaoPhan
    },
  },

  mutations: {
    [INFOS_MODAL_SET_INFO_ID](state, payload) {
      if (payload) {
        state.infoId = payload
        state.isExistInfo = config.existStatus.exist
      }
    },

    [INFOS_MODAL_SET_INFO_ID_FAILED](state, payload) {
      state.errors = payload
    },

    [INFOS_MODAL_SET_INFO](state, payload) {
      state.info = payload
    },

    [INFOS_MODAL_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [INFOS_MODAL_UPDATE_INFO_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },

    [INFOS_MODAL_UPDATE_INFO_FAILED](state, payload) {
      state.updateSuccess = payload
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
    /*   DONGS_SET_INFO(state, payload) {
       state.info = payload;
     } */
  },

  actions: {
    // action get list giao phan
    ACTION_GET_LIST_GIAO_PHAN({ commit, }, params) {
      apiGetGiaoPhanInfos(
        (infos) => {
          commit('INFO_GIAO_PHAN', infos.data.results)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        },
        params
      )
    },

    [ACTION_SHOW_MODAL_EDIT]({ dispatch, }, infoId) {
      dispatch(ACTION_GET_INFO_BY_ID, infoId)
    },

    // GET ID GIAO XU
    [ACTION_GET_INFO_BY_ID]({ dispatch, commit, }, infoId) {
      dispatch(ACTION_SET_LOADING, true)
      apiGetInfoDongById(
        infoId,
        (result) => {
          commit(INFOS_MODAL_SET_INFO_ID, infoId)
          commit(INFOS_MODAL_SET_INFO, result.data.dong)
          dispatch(ACTION_SET_LOADING, false)
        },
        (errors) => {
          commit(
            INFOS_MODAL_SET_INFO_ID_FAILED,
            Object.values(errors)
          )
          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },

    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(INFOS_MODAL_SET_LOADING, isLoading)
    },

    // UPDATE DONG
    ACTION_UPDATE_INFO_DONG({ dispatch, commit, }, info) {
      commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, '')
      apiUpdateDongInfo(
        info,
        (result) => {
          if (result) {
            commit(
              INFOS_MODAL_UPDATE_INFO_SUCCESS,
              AppConfig.comUpdateNoSuccess
            )
          }
        },
        (errors) => {
          commit(
            INFOS_MODAL_UPDATE_INFO_FAILED,
            AppConfig.comUpdateNoFail
          )
          commit(SET_ERROR, errors)
          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },

    // UPDATE DONG BACK
    ACTION_UPDATE_INFO_DONG_BACK({ dispatch, commit, }, info) {
      commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, '')
      apiUpdateDongInfo(
        info,
        (result) => {
          if (result) {
            commit(
              INFOS_MODAL_UPDATE_INFO_SUCCESS,
              AppConfig.comUpdateNoSuccess
            )
            dispatch('ACTION_RELOAD_GET_INFO_LIST_DONG', 'page', {
              root: true,
            })
          }
        },
        (errors) => {
          commit(
            INFOS_MODAL_UPDATE_INFO_FAILED,
            AppConfig.comUpdateNoFail
          )
          commit(SET_ERROR, errors)
          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },

    [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
      commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, values)
    },

    [ACTION_SET_IMAGE]({ commit, }, imgFile) {
      commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile)
    },
  },
}
