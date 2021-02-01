import Vue from 'vue';
import Vuex from 'vuex';

import auth from './auth';
import layout from './layout';
import user from './users';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
      cfApp: null
    },
    getters: {
      cfApp(state) {
        return state;
      }
    },
    mutations: {},
    actions: {},
    modules: {
      auth,
      layout,
      user
    },
});
