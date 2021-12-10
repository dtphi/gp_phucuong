const state = () => ({
  user: null
})

const getters = {
  isAuthenticated (state) {
    return !!state.user
  }
}

const mutations = {
  setUser (state, payload) {
    state.user = payload
  }
}

const actions = {
  setUser ({ commit }, payload) {
    commit('setUser', payload)
  }
}

export default {
  state,
  getters,
  mutations,
  actions
}
