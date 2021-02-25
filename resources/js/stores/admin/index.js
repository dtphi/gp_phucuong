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
    cfApp: {
      errors: [],
      links: {},
      meta: {}
    }
  },
  getters: {
    cfApp(state) {
      return state.cfApp;
    },
    resourcePaginationData(state) {
      return {
        links: state.cfApp.links,
        meta: state.cfApp.meta
      }
    }
  },
  mutations: {
    configApp(state, configs) {
      state.cfApp.links = configs.links;
      state.cfApp.meta = configs.meta;
    }
  },
  actions: {
    setConfigApp({
      commit
    }, configs) {
      commit('configApp', {
        ...{
          links: {},
          meta: {}
        },
        ...{
          links: configs.links,
          meta: configs.meta
        }
      });
    }
  },
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