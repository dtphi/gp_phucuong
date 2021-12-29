import AppConfig from 'api@admin/constants/app-config'
import {
  apiUpdateGroupAlbums,
  apiGetGroupAlbumsById,
} from 'api@admin/groupalbums'
import { MODULE_MODULE_GROUP_ALBUMS, } from '../types/module-types'
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
  ACTION_UPDATE_INFO,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_UPDATE_INFO_BACK,
  ACTION_RELOAD_GET_INFO_LIST,
} from '../types/action-types'
import { config, } from '@app/api/admin/config'

const defaultState = () => {
  return {
    isExistInfo: config.existStatus.checking,
    info: {
      group_mame: null,
      status: 1,
      updateUser: 1,
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

    [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
      state.info.image = payload
      state.isImgChange = true
    },
    GROUP_ALBUMS_SET_INFO(state, payload) {
      state.info = payload
    },
  },

  actions: {
    [ACTION_SHOW_MODAL_EDIT]({ dispatch, }, infoId) {
      dispatch(ACTION_GET_INFO_BY_ID, infoId)
    },
    // GET ID
    [ACTION_GET_INFO_BY_ID]({ dispatch, commit, }, infoId) {
      dispatch(ACTION_SET_LOADING, true)
      apiGetGroupAlbumsById(
        infoId,
        (result) => {
          commit(INFOS_MODAL_SET_INFO_ID, infoId)
          commit('GROUP_ALBUMS_SET_INFO', result.data)
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
      apiUpdateGroupAlbums(
        info,
        (result) => {
          if (result) {
            commit(SET_ERROR, [])
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
          commit(SET_ERROR, errors)
          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },
    [ACTION_UPDATE_INFO_BACK]({ dispatch, commit, }, info) {
      apiUpdateGroupAlbums(
        info,
        (result) => {
          if (result) {
            commit(
              INFOS_MODAL_UPDATE_INFO_SUCCESS,
              AppConfig.comUpdateNoSuccess
            )
            dispatch(ACTION_GET_INFO_BY_ID, info.data.id)
            dispatch(
              `${MODULE_MODULE_GROUP_ALBUMS}_${ACTION_RELOAD_GET_INFO_LIST}`,
              'page',
              {
                root: true,
              }
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

    [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
      commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, values)
    },
  },
}
