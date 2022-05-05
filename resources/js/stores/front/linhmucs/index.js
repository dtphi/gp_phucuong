import detail from './detail'
import { apiGetLists, apiGetListsChucVu, apiGetListsLinhMuc, apiGetHoatDongSuVu } from '@app/api/front/linhmucs'
import { INIT_LIST, SET_ERROR, } from '@app/stores/front/types/mutation-types'
import { GET_LISTS_LINH_MUC, GET_LISTS_LINH_MUC_BY_ID, GET_LISTS_CHUC_VU, ACTION_REFESH_LIST_FILTER,
} from '@app/stores/front/types/action-types'
import { MODULE_LINH_MUC_PAGE, } from '@app/stores/front/types/module-types'
import { fnCheckProp, } from '@app/common/util'

export default {
  namespaced: true,
  state: {
    mainMenus: [],
    pageLists: [],
    linhMucLists: [],
    chucVuLists: [],
    paginationFilter: [],
    loading: false,
    errors: [],
    hoat_dong_su_vu: [],
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
    chucVuLists(state) {
      return state.chucVuLists
    },
    linhMucLists(state) {
      return state.linhMucLists
    },
    paginationFilter(state) {
      return state.paginationFilter
    },
    hoat_dong_su_vu(state) {
      return state.hoat_dong_su_vu
    }
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
    INIT_CHUC_VU_LIST(state, payload) {
      state.chucVuLists = payload
    },
    INIT_LINH_MUC_BY_ID_LIST(state, payload) {
      state.linhMucLists = payload
    },
    INIT_PAGINATION_FILTER(state, payload) {
      state.paginationFilter = payload
    },
    INIT_REFRESH_LIST(state, payload) {
      state.linhMucLists = payload
    },
    initFilterList(state) {
      state.linhMucLists = state.pageLists
    },
    INIT_HOATDONGSUVU(state, payload) {
      state.hoat_dong_su_vu = payload
    }
  },
  
  actions: {
    [GET_LISTS_LINH_MUC]({ commit, dispatch, }, options) {
      commit('setLoading', true)
      apiGetLists((responses) => {			
        commit(INIT_LIST, responses.data.results)
        commit(SET_ERROR, [])
        var pagination = { current_page: 1, total: 0, }
        if (fnCheckProp(responses.data, 'pagination')) {
          pagination = responses.data.pagination
        }
        var configs = {
          moduleActive: {
            name: MODULE_LINH_MUC_PAGE,
            actionList: GET_LISTS_LINH_MUC,
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
    async [GET_LISTS_CHUC_VU]({ commit, }) {
      commit('setLoading', true)
      await apiGetListsChucVu((infos) => {
        commit('INIT_CHUC_VU_LIST', infos.data.results)
        commit('setLoading', false)
        commit('initFilterList')
      }, (errors) => {
        commit('setLoading', false)
        commit(SET_ERROR, errors)
      })
    },
    async [GET_LISTS_LINH_MUC_BY_ID]({ commit, }, options) {
      commit('setLoading', true)
      await apiGetListsLinhMuc((response) => {
        commit('INIT_LINH_MUC_BY_ID_LIST', response.data.results)
        if (fnCheckProp(response.data, 'pagination')) {
          commit('INIT_PAGINATION_FILTER', response.data.pagination)
        }
        commit('setLoading', false)
      }, (errors) => {
        commit('setLoading', false)
        commit(SET_ERROR, errors)
      }, options)
    },
    [ACTION_REFESH_LIST_FILTER]({ commit, }) {
      commit('INIT_REFRESH_LIST', [])
      commit('INIT_PAGINATION_FILTER', [])
    },
  },
  modules: {
    detail: detail,
  },
}