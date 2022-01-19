import detail from './detail'
import { apiGetLists, apiGetListsGiaoXu, } from '@app/api/front/giaoxus'
import { apiGetListsGiaoPhan, } from '@app/api/front/giaophans'
import { apiGetListsGiaoHat, } from '@app/api/front/giaohats'
import { SET_ERROR, INIT_LIST, } from '@app/stores/front/types/mutation-types'
import { MODULE_GIAO_XU_PAGE, } from '@app/stores/front/types/module-types'
import { GET_LISTS, GET_LISTS_GIAO_PHAN, GET_LISTS_GIAO_HAT, GET_LISTS_GIAO_XU, ACTION_REFESH_LIST_FILTER,
} from '@app/stores/front/types/action-types'
import { fnCheckProp, } from '@app/common/util'

export default {
  namespaced: true,
  state: {
    mainMenus: [],
    pageLists: [],
    giaoPhanLists:[],
    giaoHatLists: [],
    giaoXuLists:[],
    loading: false,
    paginationFilter: [],
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
    giaoPhanLists(state) {
      return state.giaoPhanLists
    },
    giaoHatLists(state) {
      return state.giaoHatLists
    },
    giaoXuLists(state) {
      return state.giaoXuLists
    },
    paginationFilter(state) {
      return state.paginationFilter
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
    INIT_GIAO_PHAN_LIST(state, payload) {
      state.giaoPhanLists = payload
    },
    INIT_GIAO_HAT_LIST(state, payload) {
      state.giaoHatLists = payload
    },
    INIT_GIAO_XU_LIST(state, payload) {
      state.giaoXuLists = payload
    },
    INIT_PAGINATION_FILTER(state, payload) {
      state.paginationFilter = payload
    },
    INIT_REFRESH_LIST(state, payload) {
      state.giaoXuLists = payload
    },
    initFilterList(state) {
      state.giaoXuLists = state.pageLists
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
            name: MODULE_GIAO_XU_PAGE,
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
    async [GET_LISTS_GIAO_PHAN]({ commit, }) {
      commit('setLoading', true)
      await apiGetListsGiaoPhan((infos) => {
        commit('INIT_GIAO_PHAN_LIST', infos.data.results)
        commit('setLoading', false)
        commit('initFilterList')
      }, (errors) => {
        commit('setLoading', false)
        commit(SET_ERROR, errors)
      })
    },
    async [GET_LISTS_GIAO_HAT]({ commit, }, params) {
      commit('setLoading', true)
      await apiGetListsGiaoHat((infos) => {
        commit('INIT_GIAO_HAT_LIST', infos.data.results)
        commit('setLoading', false)
      }, (errors) => {
        commit('setLoading', false)
        commit(SET_ERROR, errors)
      }, params)
    },
    async [GET_LISTS_GIAO_XU]({ commit, }, options) {
      commit('setLoading', true)
      await apiGetListsGiaoXu((response) => {
        commit('INIT_GIAO_XU_LIST', response.data.results)
        commit('INIT_PAGINATION_FILTER', response.data.pagination)
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