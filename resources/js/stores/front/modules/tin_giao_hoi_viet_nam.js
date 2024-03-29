import { apiGetSettingByCode, } from '@app/api/front/setting'
import { apiGetListsToCategory, } from '@app/api/front/infos'
import { INIT_LIST, SET_ERROR, } from '@app/stores/front/types/mutation-types'
import { GET_INFORMATION_LIST_TO_CATEGORY, } from '@app/stores/front/types/action-types'
import { MODULE_UPDATE_SET_LOADING, MODULE_UPDATE_SET_ERROR, MODULE_UPDATE_SET_KEYS_DATA,
} from '../../admin/types/mutation-types'
import { ACTION_SET_LOADING, ACTION_GET_SETTING, } from '../../admin/types/action-types'
import { fnCheckProp, } from '@app/common/util'
const settingCategory = []

const defaultState = () => {
  return {
    module_tin_giao_hoi_viet_nam_categories: settingCategory,
    moduleData: {
      code: 'module_tin_giao_hoi_viet_nam',
      keys: [
        settingCategory,
        { module_tin_giao_hoi_viet_nam_category_limit: 6, }
      ],
    },
    pageLists: [],
    loading: false,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    settingCategory(state) {
      return state.module_tin_giao_hoi_viet_nam_categories
    },
    moduleData(state) {
      return state.moduleData
    },
    loading(state) {
      return state.loading
    },
    errors(state) {
      return state.errors
    },
    isError(state) {
      return state.errors.length
    },
    pageLists(state) {
      return state.pageLists
    },
  },
  mutations: {
    [INIT_LIST](state, payload) {
      state.pageLists = payload
    },
    [MODULE_UPDATE_SET_LOADING](state, payload) {
      state.loading = payload
    },
    [MODULE_UPDATE_SET_ERROR](state, payload) {
      state.errors = payload
    },
    [MODULE_UPDATE_SET_KEYS_DATA](state, payload) {
      state.module_tin_giao_hoi_viet_nam_categories = payload.module_tin_giao_hoi_viet_nam_categories
      state.moduleData.keys = []
      state.moduleData.keys.push(payload.module_tin_giao_hoi_viet_nam_categories)
    },
    [SET_ERROR](state, payload) {
      state.errors = payload
    },
  },
  actions: {
    [ACTION_GET_SETTING]({ dispatch, state, commit, }, options) {
      if (options) {
        commit(MODULE_UPDATE_SET_KEYS_DATA, options)
        dispatch(GET_INFORMATION_LIST_TO_CATEGORY, options[0])
      } else {
        dispatch(ACTION_SET_LOADING, true)
        const params = { code: state.moduleData.code, }
        apiGetSettingByCode(res => {
          if (Object.keys(res.data.moduleData).length) {
            commit(MODULE_UPDATE_SET_KEYS_DATA, res.data.moduleData)
            dispatch(GET_INFORMATION_LIST_TO_CATEGORY, res.data.moduleData.module_tin_giao_hoi_viet_nam_categories[0])
          } else {
            dispatch(ACTION_SET_LOADING, false)
          }
        }, errors => {
          dispatch(ACTION_SET_LOADING, false)
          commit(SET_ERROR, errors)
        }, params)
      }
    },
    [GET_INFORMATION_LIST_TO_CATEGORY]({ state, commit, }, routeParams) {
      let slug = ''
      if (fnCheckProp(routeParams, 'link')) {
        slug = routeParams.link
      }
      let page = 1
      let params = {
        moduleName: state.moduleData.code,
        limit: 6,
        page: page,
        slug: slug,
      }
      apiGetListsToCategory(result => {
        commit(INIT_LIST, result.data.results)
      }, errors => {
        commit(SET_ERROR, errors)
      }, params)
    },
    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(MODULE_UPDATE_SET_LOADING, isLoading)
    },
  },
}