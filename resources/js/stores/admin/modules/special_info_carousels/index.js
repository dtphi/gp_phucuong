import AppConfig from 'api@admin/constants/app-config'
import { v4 as uuidv4, } from 'uuid'
import { apiInsertSetting, } from 'api@admin/setting'
import {
  MODULE_UPDATE_SET_LOADING,
  MODULE_UPDATE_SETTING_SUCCESS,
  MODULE_UPDATE_SETTING_FAILED,
  SET_ERROR,
  MODULE_UPDATE_SET_KEYS_DATA,
} from '../../types/mutation-types'
import {
  ACTION_SET_LOADING,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_INSERT_SETTING,
  ACTION_GET_SETTING,
} from '../../types/action-types'
import _ from 'lodash'

const specialInfoCarousel = {
  value: [],
}

const defaultState = () => {
  return {
    specialInfoCarousel: specialInfoCarousel,
    loading: false,
    updateSuccess: false,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    specialInfoCarousel(state) {
      return state.specialInfoCarousel
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
    [MODULE_UPDATE_SET_LOADING](state, payload) {
      state.loading = payload
    },
    [MODULE_UPDATE_SETTING_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },
    [MODULE_UPDATE_SETTING_FAILED](state, payload) {
      state.updateSuccess = payload
    },
    [SET_ERROR](state, payload) {
      state.errors = payload
    },
    [MODULE_UPDATE_SET_KEYS_DATA](state, payload) {
      state.specialInfoCarousel.value = payload
    },
    MODULE_SPECIAL_INFO_CAROUSEL_UPDATE(state, payload) {
      state.specialInfoCarousel.value = payload
    },
    MODULE_SPECIAL_INFO_CAROUSEL_PUSH_UPDATE(state, payload) {
      state.specialInfoCarousel.value.push(payload)
    }
  },

  actions: {
    pushSpecialInfoCarousel({ commit, }, value) {
      commit('MODULE_SPECIAL_INFO_CAROUSEL_PUSH_UPDATE', {
        id: uuidv4(),
        status: 1,
        open: 0,
        image: value.filePath,
        width: 700,
        height: 450,
      })
    },
    specialInfoCarouselRemove({ state, commit }, banner) {
      let banners = state.specialInfoCarousel.value
      if (state.specialInfoCarousel.value.length > 1) {
        commit('MODULE_SPECIAL_INFO_CAROUSEL_UPDATE', _.remove(
          banners,
          function(item) {
            return !(item.id == banner.id)
          }
        ))
      }
    },
    [ACTION_GET_SETTING]({ commit, }, specialCarousels) {
      if (specialCarousels.length) {
        commit(MODULE_UPDATE_SET_KEYS_DATA, specialCarousels)
      }
    },
    [ACTION_INSERT_SETTING]({ commit, dispatch, }, settingData) {
      dispatch(ACTION_SET_LOADING, true)
      apiInsertSetting(
        settingData,
        (result) => {
          if (result) {
            commit(
              MODULE_UPDATE_SETTING_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
            commit(SET_ERROR, [])
          }

          dispatch(ACTION_SET_LOADING, false)
        },
        (errors) => {
          commit(
            MODULE_UPDATE_SETTING_FAILED,
            AppConfig.comInsertNoFail
          )
          commit(SET_ERROR, errors)

          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },
    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(MODULE_UPDATE_SET_LOADING, isLoading)
    },
    [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
      commit(MODULE_UPDATE_SETTING_SUCCESS, values)
    },
  },
}
