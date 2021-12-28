import AppConfig from 'api@admin/constants/app-config'
import { v4 as uuidv4, } from 'uuid'
import {
  apiGetSettingByCode,
  apiInsertSetting,
  apiUpdateSettingByKey,
} from 'api@admin/setting'
import {
  SELECT_DROPDOWN_PARENT_CATEGORY,
  SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY,
  MODULE_UPDATE_SET_LOADING,
  MODULE_UPDATE_SETTING_SUCCESS,
  MODULE_UPDATE_SETTING_FAILED,
  SET_ERROR,
  MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA,
  MODULE_UPDATE_SET_KEYS_DATA,
} from '../../types/mutation-types'
import {
  ACTION_SET_LOADING,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_SELECT_DROPDOWN_PARENT_CATEGORY,
  ACTION_SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY,
  ACTION_INSERT_SETTING,
  ACTION_GET_SETTING,
} from '../../types/action-types'
import _ from 'lodash'
import { fnCheckProp, } from '@app/common/util'
const settingSachNoi = {
  key: 'module_noi_bat_sach_nois',
  value: [],
  serialize: true,
}
const settingYoutube = {
  key: 'module_noi_bat_youtubes',
  value: [],
  serialize: true,
}
const settingHanhCacThanh = {
  key: 'module_noi_bat_hanh_cac_thanhs',
  value: [],
  serialize: true,
}
const settingBanner = {
  key: 'module_noi_bat_banners',
  value: [],
  serialize: true,
}
const settingBannerFormat = {
  key: 'module_noi_bat_banner_formats',
  value: [
    {
      media: 1200,
      top: 32,
      left: 20,
      color: 'ffffff',
      font_weight: 500,
      font_size: 36,
    },
    {
      media: 1024,
      top: 32,
      left: 20,
      color: 'ffffff',
      font_weight: 500,
      font_size: 36,
    },
    {
      media: 960,
      top: 32,
      left: 20,
      color: 'ffffff',
      font_weight: 500,
      font_size: 36,
    },
    {
      media: 812,
      top: 32,
      left: 20,
      color: 'ffffff',
      font_weight: 500,
      font_size: 36,
    },
    {
      media: 768,
      top: 39,
      left: 15,
      color: 'ffffff',
      font_weight: 500,
      font_size: 28,
    },
    {
      media: 736,
      top: 39,
      left: 15,
      color: 'ffffff',
      font_weight: 500,
      font_size: 28,
    },
    {
      media: 667,
      top: 39,
      left: 15,
      color: 'ffffff',
      font_weight: 500,
      font_size: 28,
    },
    {
      media: 414,
      top: 44,
      left: 16,
      color: 'ffffff',
      font_weight: 700,
      font_size: 18,
    },
    {
      media: 375,
      top: 44,
      left: 16,
      color: 'ffffff',
      font_weight: 700,
      font_size: 18,
    }
  ],
  serialize: true,
}

const defaultState = () => {
  return {
    module_noi_bat_sach_nois: settingSachNoi,
    module_noi_bat_youtubes: settingYoutube,
    module_noi_bat_hanh_cac_thanhs: settingHanhCacThanh,
    module_noi_bat_banners: settingBanner,
    module_noi_bat_banner_formats: settingBannerFormat,
    moduleData: {
      code: 'module_noi_bat',
      keys: [
        settingSachNoi,
        settingYoutube,
        settingHanhCacThanh,
        settingBanner,
        settingBannerFormat
      ],
    },
    loading: false,
    updateSuccess: false,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    settingSachNoi(state) {
      return state.module_noi_bat_sach_nois
    },
    settingYoutube(state) {
      return state.module_noi_bat_youtubes
    },
    settingHanhCacThanh(state) {
      return state.module_noi_bat_hanh_cac_thanhs
    },
    settingBanner(state) {
      return state.module_noi_bat_banners
    },
    settingBannerFormat(state) {
      return state.module_noi_bat_banner_formats
    },
    moduleData(state) {
      return state.moduleData
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

    [MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA](state, payload) {
      state.module_noi_bat_hanh_cac_thanhs.value = payload
    },

    [MODULE_UPDATE_SET_KEYS_DATA](state, payload) {
      if (fnCheckProp(payload, 'module_noi_bat_banners')) {
        state.module_noi_bat_banners = payload.module_noi_bat_banners
      }
      if (fnCheckProp(payload, 'module_noi_bat_banner_formats')) {
        state.module_noi_bat_banner_formats =
                    payload.module_noi_bat_banner_formats
      }
      if (fnCheckProp(payload, 'module_noi_bat_sach_nois')) {
        state.module_noi_bat_sach_nois =
                    payload.module_noi_bat_sach_nois
      }
      if (fnCheckProp(payload, 'module_noi_bat_youtubes')) {
        state.module_noi_bat_youtubes = payload.module_noi_bat_youtubes
      }
      if (fnCheckProp(payload, 'module_noi_bat_hanh_cac_thanhs')) {
        state.module_noi_bat_hanh_cac_thanhs =
                    payload.module_noi_bat_hanh_cac_thanhs
      }

      state.moduleData.keys = []
      state.module_noi_bat_sach_nois.value = _.forEach(
        state.module_noi_bat_sach_nois.value,
        (item) => {
          if (!fnCheckProp(item, 'id')) {
            _.update(item, 'id', (id) => {
              id = uuidv4()

              return id
            })
          }
          if (!fnCheckProp(item, 'status')) {
            _.update(item, 'status', (status) => {
              status = 1

              return status
            })
          }
          if (!fnCheckProp(item, 'open')) {
            _.update(item, 'open', (open) => {
              open = 0

              return open
            })
          }
        }
      )
      state.moduleData.keys.push(state.module_noi_bat_sach_nois)
      state.module_noi_bat_youtubes.value = _.forEach(
        state.module_noi_bat_youtubes.value,
        (item) => {
          if (!fnCheckProp(item, 'id')) {
            _.update(item, 'id', (id) => {
              id = uuidv4()

              return id
            })
          }
          if (!fnCheckProp(item, 'status')) {
            _.update(item, 'status', (status) => {
              status = 1

              return status
            })
          }
          if (!fnCheckProp(item, 'open')) {
            _.update(item, 'open', (open) => {
              open = 0

              return open
            })
          }
        }
      )
      state.moduleData.keys.push(state.module_noi_bat_youtubes)
      state.module_noi_bat_hanh_cac_thanhs.value = _.forEach(
        state.module_noi_bat_hanh_cac_thanhs.value,
        (item) => {
          if (!fnCheckProp(item, 'id')) {
            _.update(item, 'id', (id) => {
              id = uuidv4()

              return id
            })
          }
          if (!fnCheckProp(item, 'status')) {
            _.update(item, 'status', (status) => {
              status = 1

              return status
            })
          }
          if (!fnCheckProp(item, 'open')) {
            _.update(item, 'open', (open) => {
              open = 0

              return open
            })
          }
        }
      )
      state.moduleData.keys.push(state.module_noi_bat_hanh_cac_thanhs)
      state.module_noi_bat_banners.value = _.forEach(
        state.module_noi_bat_banners.value,
        (item) => {
          if (!fnCheckProp(item, 'id')) {
            _.update(item, 'id', (id) => {
              id = uuidv4()

              return id
            })
          }
          if (!fnCheckProp(item, 'status')) {
            _.update(item, 'status', (status) => {
              status = 1

              return status
            })
          }
          if (!fnCheckProp(item, 'open')) {
            _.update(item, 'open', (open) => {
              open = 0

              return open
            })
          }
          if (!fnCheckProp(item, 'title')) {
            _.update(item, 'title', (title) => {
              title = ''

              return title
            })
          }
        }
      )

      state.moduleData.keys.push(state.module_noi_bat_banners)

      state.module_noi_bat_banner_formats.value = _.forEach(
        state.module_noi_bat_banner_formats.value,
        (item) => {
          if (!fnCheckProp(item, 'top')) {
            _.update(item, 'top', (top) => {
              top = 1

              return top
            })
          }
          if (!fnCheckProp(item, 'left')) {
            _.update(item, 'left', (left) => {
              left = 1

              return left
            })
          }
          if (!fnCheckProp(item, 'color')) {
            _.update(item, 'color', (color) => {
              color = ''

              return color
            })
          }
          if (!fnCheckProp(item, 'font_weight')) {
            _.update(item, 'font_weight', (font_weight) => {
              font_weight = 100

              return font_weight
            })
          }

          if (!fnCheckProp(item, 'font_size')) {
            _.update(item, 'font_size', (font_size) => {
              font_size = 12

              return font_size
            })
          }
        }
      )

      state.moduleData.keys.push(state.module_noi_bat_banner_formats)
    },
  },

  actions: {
    updateSettingByKey({ state, commit, dispatch, }, settingData) {
      dispatch(ACTION_SET_LOADING, true)
      apiUpdateSettingByKey(
        {
          action: 'update',
          code: state.moduleData.code,
          keys: [settingData.banner, settingData.format],
        },
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
    module_noi_bat_sach_nois({ state, }) {
      state.module_noi_bat_sach_nois.value.push({
        id: uuidv4(),
        status: 1,
        open: 0,
        title: '',
        url_title: '',
        author: '',
        sort_order: 0,
      })
    },
    module_noi_bat_sach_nois_action_remove({ state, }, params) {
      let sachnois = state.module_noi_bat_sach_nois.value
      const data = params.item

      if (state.module_noi_bat_sach_nois.value.length > 1) {
        state.module_noi_bat_sach_nois.value = _.remove(
          sachnois,
          function(item) {
            return !(item.id == data.id)
          }
        )
      }
    },
    module_noi_bat_youtubes({ state, }) {
      state.module_noi_bat_youtubes.value.push({
        id: uuidv4(),
        status: 1,
        title: '',
        open: 0,
        url_full: '',
        author: '',
        sort_order: 0,
      })
    },
    module_noi_bat_youtubes_action_remove({ state, }, params) {
      let youtubes = state.module_noi_bat_youtubes.value
      const data = params.item

      if (state.module_noi_bat_youtubes.value.length > 1) {
        state.module_noi_bat_youtubes.value = _.remove(
          youtubes,
          function(item) {
            return !(item.id == data.id)
          }
        )
      }
    },
    module_noi_bat_hanh_cac_thanhs({ state, }) {
      state.module_noi_bat_hanh_cac_thanhs.value.push({
        id: uuidv4(),
        status: 1,
        title: '',
        open: 0,
        url_full: '',
        author: '',
        sort_order: 0,
      })
    },
    module_noi_bat_hanh_cac_thanhs_action_remove({ state, }, params) {
      let hanhCacThanhs = state.module_noi_bat_hanh_cac_thanhs.value
      const data = params.item

      if (state.module_noi_bat_hanh_cac_thanhs.value.length > 1) {
        state.module_noi_bat_hanh_cac_thanhs.value = _.remove(
          hanhCacThanhs,
          function(item) {
            return !(item.id == data.id)
          }
        )
      }
    },
    module_noi_bat_banners({ state, }, value) {
      const data = {
        id: uuidv4(),
        title: '',
        status: 1,
        open: 0,
        image: value.filePath,
        url_full: '',
        width: 700,
        height: 150,
      }
      state.module_noi_bat_banners.value.push(data)
    },
    module_noi_bat_banners_action_remove({ state, }, banner) {
      let banners = state.module_noi_bat_banners.value

      if (state.module_noi_bat_banners.value.length > 1) {
        state.module_noi_bat_banners.value = _.remove(
          banners,
          function(item) {
            return !(item.id == banner.id)
          }
        )
      }
    },
    [ACTION_GET_SETTING]({ dispatch, state, commit, }) {
      dispatch(ACTION_SET_LOADING, true)
      apiGetSettingByCode(
        state.moduleData.code,
        (res) => {
          if (Object.keys(res.data.results).length) {
            commit(MODULE_UPDATE_SET_KEYS_DATA, res.data.results)
          }
          dispatch(ACTION_SET_LOADING, false)
        },
        (errors) => {
          dispatch(ACTION_SET_LOADING, false)
          commit(SET_ERROR, errors)
        }
      )
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

    [ACTION_SELECT_DROPDOWN_PARENT_CATEGORY]({ commit, }, category) {
      commit(SELECT_DROPDOWN_PARENT_CATEGORY, category)
    },

    [ACTION_SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY]({ commit, }, category) {
      commit(SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY, category)
    },
  },
}
