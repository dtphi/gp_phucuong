import detail from './detail'
import { apiGetLists, } from '@app/api/front/homes'
import { INIT_LIST, SET_ERROR, } from '@app/stores/front/types/mutation-types'
import { GET_LISTS, } from '@app/stores/front/types/action-types'

export default {
  namespaced: true,
  state: {
    mainMenus: [],
    pageLists: [],
    errors: [],
  },
  getters: {
    mainMenus(state) {
      return state.mainMenus
    },
    pageLists(state) {
      return state.pageLists
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
  },
  actions: {
    [GET_LISTS]({ commit, }, options) {
      apiGetLists((responses) => {
        commit(INIT_LIST, responses.pageLists)
        commit(SET_ERROR, [])
      }, (errors) => {
        commit(SET_ERROR, errors)
      }, options)
    },
  },
  modules: {
    detail: detail,
  },
}