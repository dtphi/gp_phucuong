import Vue from 'vue';
import Vuex from 'vuex';

import layout from './layout';
import auth from './auth';
import user from './user';
import rs from '@/mixins/resources';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
      cfApp: rs
    },
    getters: {
      cfApp(state) {
        return state.cfApp;
      }
    },
    mutations: {},
    actions: {},
    modules: {
      auth,
      layout,
      user,
    },
});
