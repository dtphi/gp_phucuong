import Vue from 'vue';
import Vuex from 'vuex';

import home from './home';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
    },
    getters: {
      cfApp(state) {
        return state;
      }
    },
    mutations: {},
    actions: {},
    modules: {
      home,
    },
});
