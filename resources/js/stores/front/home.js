import axios from 'axios'

export default {
    namespaced: true,
    state: {
      mainMenus: [],
    },
    getters: {
      mainMenus(state) {
        return state.mainMenus
      }
    },

    mutations: {
        MAIN_MENU(state, value) {
            state.mainMenus = value
        }
    },

    actions: {
        async menus ({ dispatch }) {
            return await axios.get('/api/main-menus');
        }
    }
}
