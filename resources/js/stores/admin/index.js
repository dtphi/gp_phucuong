import Vue from 'vue';
import Vuex from 'vuex';

import auth from './auth';
import layout from './layout';
import user from './users';
import info from './infos';
import newsgroup from './newsgroups';
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
      user,
      info,
      newsgroup
    },
    strict: debug,
    plugins: debug ? [createLogger()] : []
});
