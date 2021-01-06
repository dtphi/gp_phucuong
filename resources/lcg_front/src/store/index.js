import { createStore } from 'vuex'
import home from './home'
import rs from './resources'

export default createStore({
  state: {
    cfApp: rs
  },
  getters: {
    cfApp(state) {
      return state.cfApp
    }
  },
  mutations: {
  },
  actions: {
  },
  modules: {
    home,
  }
})
