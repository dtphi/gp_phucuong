import {
  apiEmailSubscribe
} from '@app/api/front/subscribes';
import {
  SET_SUBSCRIBE,
  SET_ERROR,
  SET_LOADING,
} from '@app/stores/front/types/mutation-types';
import {
  ACTION_SUBSCRIBE_REGISTRY_TO_NEWSLETTER
} from '@app/stores/front/types/action-types';

export default {
  namespaced: true,
  state: {
    subscribe: {
      email: ''
    },
    loading: false,
    errors: []
  },
  getters: {
    subscribe(state) {
      return state.subscribe;
    },
    loading(state) {
      return state.loading;
    }
  }, 

  mutations: {
    [SET_SUBSCRIBE](state, payload) {
      state.subscribe = payload;
    },
    [SET_ERROR](state, payload) {
      state.errors = payload;
    },
    [SET_LOADING](state, payload) {
      state.loading = payload;
    }
  },

  actions: {
    [ACTION_SUBSCRIBE_REGISTRY_TO_NEWSLETTER]({
      commit
    }, subscribe) {
      commit(SET_LOADING, true);
      
      apiEmailSubscribe(
        (responses) => {
          console.log(responses)
          commit(SET_ERROR, []);
          commit(SET_LOADING, false);
        },
        (errors) => {
          commit(SET_ERROR, errors);
          commit(SET_LOADING, false);
        },
        subscribe
      );
    },
  }
}