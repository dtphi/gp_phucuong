import Vue from 'vue';
import Vuex from 'vuex';

import auth from './auth';
import layout from './layout';
import user from './users';
import createLogger from '../../plugins/logger';

Vue.use(Vuex);

const debug = process.env.NODE_ENV === 'debuger';

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
    strict: debug,
    plugins: debug ? [createLogger()] : []
});
