import detail from './detail'
import { apiGetLists, apiGetListsHanhCacThanh
} from '@app/api/front/HanhCacThanh'
import { INIT_LIST, SET_ERROR, } from '@app/stores/front/types/mutation-types'
import { GET_LISTS_HANH_CAC_THANH, } from '@app/stores/front/types/action-types'
import { MODULE_HANH_CAC_THANH, } from '@app/stores/front/types/module-types'
import { fnCheckProp, } from '@app/common/util'
import { GET_LISTS } from '../types/action-types'

export default {
  namespaced: true,
  state: {
    loading: false,
    mainMenus: [],
    pageLists: [],
    HanhCacThanhList: [],
    listActive: 'pageList',
    errors: [],
  },
  getters: {
    mainMenus(state) {
      return state.mainMenus
    },
    pageLists(state) {
      return state.pageLists
    },
    loading(state) {
      return state.loading
    },
    HanhCacThanhLists(state) {
      return state.HanhCacThanhLists
    },
  },
  mutations: {
    MAIN_MENU(state, value) {
      state.mainMenus = value
    },
    [INIT_LIST](state, payload) {
      state.pageLists = payload
    },
    [SET_ERROR](state, payload) {
      state.errors = payload
    },
    setLoading(state, payload) {
      state.loading = payload
    },
    INIT_HANH_CAC_THANH_LIST(state, payload) {
      state.HanhCacThanhLists = payload
    },
  },
  actions: {
    [GET_LISTS]({ commit, dispatch, }, options) {
      commit('setLoading', true)
      apiGetLists((responses) => {
        commit(INIT_LIST, responses.data.results)
        commit(SET_ERROR, [])
        var pagination = {
          current_page: 1,
          total: 0,
        }
        if (fnCheckProp(responses.data, 'pagination')) {
          pagination = responses.data.pagination
        }
        var configs = {
          moduleActive: {
            name: MODULE_HANH_CAC_THANH,
            actionList: GET_LISTS,
          },
          collectionData: pagination,
        }
        dispatch('setConfigApp', configs, { root: true, })
        commit('setLoading', false)
      }, (errors) => {
        commit(SET_ERROR, errors)
        commit('setLoading', false)
      }, options)
    },
    async [GET_LISTS_HANH_CAC_THANH]({ commit, }, options) {
      commit('setLoading', true)
      await apiGetListsHanhCacThanh((response) => {
        commit('INIT_HANH_CAC_THANH_LIST', response.data.results)
        commit('setLoading', false)
      }, (errors) => {
        commit('setLoading', false)
        commit(SET_ERROR, errors)
      }, options)
    },
  },
  modules: {
    detail: detail,
  },
}