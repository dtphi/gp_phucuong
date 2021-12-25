import { apiEmailSubscribe, } from '@app/api/front/subscribes'
import { SET_SUBSCRIBE, SET_ERROR, SET_LOADING,
 } from '@app/stores/front/types/mutation-types'

export default {
  namespaced: true,
  state: {
    subscribe: {
      email: '',
    },
    loading: false,
    errors: [],
    insertSuccess: false,
  },
  getters: {
    subscribe(state) {
      return state.subscribe
    },
    loading(state) {
      return state.loading
    },
    insertSuccess(state) {
      return state.insertSuccess
    },
  },
  mutations: {
    [SET_SUBSCRIBE](state, payload) {
      state.subscribe = payload
    },
    [SET_ERROR](state, payload) {
      state.errors = payload
    },
    [SET_LOADING](state, payload) {
      state.loading = payload
    },
    RESET_SUB(state, payload) {
      state.subscribe.email = payload
    },
    SET_INSERT_SUCCESS(state, payload) {
      state.insertSuccess = payload
    },
  },
  actions: {
    ACTION_SUBSCRIBE_REGISTRY_TO_NEWSLETTER({ commit, }, subscribe) {
      commit(SET_LOADING, true)
      apiEmailSubscribe(subscribe,
        (responses) => {
          commit(SET_ERROR, [])
          commit(SET_LOADING, false)
          commit('RESET_SUB', '')
          commit('SET_INSERT_SUCCESS', true)
        },
        (errors) => {
          commit(SET_ERROR, errors)
          commit(SET_LOADING, false)
          commit('SET_INSERT_SUCCESS', false)
        })
    },
    RESET_NOTIFICATION({ commit, }, msg) {
      commit('SET_INSERT_SUCCESS', msg)
    }
  }
}