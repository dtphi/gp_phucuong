import axios from 'axios'

export default {
    namespaced: true,
    state: {
      lists:[],
      user:{},
      errors:[]
    },
    getters: {
      lists(state) {
        return state.lists
      }
    },

    mutations: {
      SET_LIST(state, lists) {
        state.lists = lists;
      },
      SET_ERRORS(state, errors) {
        state.errors = errors;
      }
    },

    actions: {
        async getUsers ({ commit }, searchs) {
            await axios.get('/api/users', searchs).then(response => {
              var status = response.status;
              var errors = response.data.errors;

              if (status == 200) {
                commit('SET_LIST', response.data.results.user);
                commit('SET_ERRORS', errors);
              }
            });
        }
    }
}
