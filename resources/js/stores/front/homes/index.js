import { apiGetLists, } from '@app/api/front/homes'
import { INIT_LIST, SET_ERROR, } from '@app/stores/front/types/mutation-types'
import { GET_LISTS, } from '@app/stores/front/types/action-types'

export default {
  namespaced: true,
  state: {
    mainMenus: [],
    pageLists: [],
    loading: false,
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
  },
  actions: {
    [GET_LISTS]({ commit, }, options) {
      commit('setLoading', true)
      apiGetLists((responses) => {
        commit(INIT_LIST, responses.pageLists)
        commit(SET_ERROR, [])
        commit('setLoading', false)
      }, (errors) => {
        commit(SET_ERROR, errors)
        commit('setLoading', false)
      }, options)
    },
  },
}