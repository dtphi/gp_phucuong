import { config, } from '@app/common/config'
import { apiGetSettingByCode, } from '@app/api/front/setting'
import { apiGetSpecialModuleList, } from '@app/api/front/infos'
import { INIT_LIST, SET_ERROR, } from '@app/stores/front/types/mutation-types'
import { MODULE_UPDATE_SET_LOADING, MODULE_UPDATE_SET_ERROR, MODULE_UPDATE_SET_KEYS_DATA,
} from '../../admin/types/mutation-types'
import { ACTION_SET_LOADING, ACTION_GET_SETTING, ACTION_GET_SPECIAL_INFORMATION_LIST_TO_MODULE,
} from 'store@front/types/action-types'
// import { relativeTimeRounding, } from 'moment'
const settingSpecialInfo = []
const defaultState = () => {
  return {
    module_special_info_ids: settingSpecialInfo,
    moduleData: {
      code: 'module_special_info',
      keys: [
        settingSpecialInfo
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
    settingSpecialInfo(state) {
      return state.module_special_info_ids
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
      state.module_special_info_ids = payload.module_special_info_ids
      state.moduleData.keys = []
      state.moduleData.keys.push(payload.module_special_info_ids)
    },
    [SET_ERROR](state, payload) {
      state.errors = payload
    },
  },
  actions: {
    [ACTION_GET_SETTING]({ dispatch, state, commit, }) {
      dispatch(ACTION_SET_LOADING, true)
      const params = { code: state.moduleData.code, }
      apiGetSettingByCode((res) => {
        if (Object.keys(res.data.moduleData).length) {
          commit(MODULE_UPDATE_SET_KEYS_DATA, res.data.moduleData)
          let infos = res.data.moduleData.module_special_info_ids
          var asorts = _.orderBy(infos, o => o.id, 'desc')
          let values = []
          _.forEach(asorts, function(item, idx) {
            if (idx < config.carouselLimit) {
              values.push({ id: item.id, })
            } else {
              return 0
            }
          })
          dispatch(ACTION_GET_SPECIAL_INFORMATION_LIST_TO_MODULE, values)
        } else {
          dispatch(ACTION_SET_LOADING, false)
        }
      }, (errors) => {
        dispatch(ACTION_SET_LOADING, false)
        commit(SET_ERROR, errors)
      }, params)
    },
    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(MODULE_UPDATE_SET_LOADING, isLoading)
    },
    [ACTION_GET_SPECIAL_INFORMATION_LIST_TO_MODULE]({ state, commit, dispatch, }, specialIds) {
      const params = {
        specialInfoIds: specialIds,
        moduleName: state.moduleData.code,
      }
      apiGetSpecialModuleList((result) => {
        commit(INIT_LIST, result.data.results)
        dispatch(ACTION_SET_LOADING, false)
      }, (errors) => {
        dispatch(ACTION_SET_LOADING, false)
        commit(SET_ERROR, errors)
      }, params)
    },
  },
}