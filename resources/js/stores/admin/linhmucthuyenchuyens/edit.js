import AppConfig from 'api@admin/constants/app-config'
import { apiGetInfoById, apiUpdateInfo, } from 'api@admin/linhmucthuyenchuyen'
import {
  INFOS_MODAL_SET_INFO_ID,
  INFOS_MODAL_SET_INFO_ID_FAILED,
  INFOS_MODAL_SET_INFO,
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_UPDATE_INFO_SUCCESS,
  INFOS_MODAL_UPDATE_INFO_FAILED,
  SET_ERROR,
} from '../types/mutation-types'
import {
  ACTION_GET_INFO_BY_ID,
  ACTION_SET_LOADING,
  ACTION_SHOW_MODAL_EDIT,
  ACTION_UPDATE_INFO,
  ACTION_RESET_NOTIFICATION_INFO,
} from '../types/action-types'
import { config, } from '@app/api/admin/config'

const defaultState = () => {
  return {
    styleCss: '',
    info: {
      from_giao_xu_id: null,
      fromGiaoXuName: '',
      from_chuc_vu_id: null,
      fromchucvuName: '',
      from_date: '',
      duc_cha_id: null,
      ducchaName: '',
      to_date: '',
      chuc_vu_id: '',
      chucvuName: '',
      giao_xu_id: '',
      giaoxuName: '',
      co_so_gp_id: null,
      cosogpName: '',
      dong_id: '',
      dongName: '',
      ban_chuyen_trach_id: null,
      banchuyentrachName: '',
      du_hoc: null,
      quoc_gia: null,
      ghi_chu: '',
      active: 1,
    },
    infoId: 0,
    loading: false,
    updateSuccess: false,
    errors: [],
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
  },

  actions: {
    [ACTION_SHOW_MODAL_EDIT]({ dispatch, }, infoId) {
      dispatch(ACTION_GET_INFO_BY_ID, infoId)
    },

    [ACTION_GET_INFO_BY_ID]({ dispatch, commit, }, infoId) {
      dispatch(ACTION_SET_LOADING, true)
      apiGetInfoById(
        infoId,
        (result) => {
          commit(INFOS_MODAL_SET_INFO_ID, infoId)
          commit(INFOS_MODAL_SET_INFO, result.data)

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

    [ACTION_UPDATE_INFO]({ dispatch, commit, }, info) {
      commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, '')
      apiUpdateInfo(
        info,
        (result) => {
          if (result) {
            commit(
              INFOS_MODAL_UPDATE_INFO_SUCCESS,
              AppConfig.comUpdateNoSuccess
            )
          }
          dispatch(ACTION_SET_LOADING, false)
        },
        (errors) => {
          commit(
            INFOS_MODAL_UPDATE_INFO_FAILED,
            AppConfig.comUpdateNoFail
          )
          dispatch(ACTION_SET_LOADING, false)
          commit(SET_ERROR, errors)
        }
      )
    },

    [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
      commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, values)
    },
  },
}
