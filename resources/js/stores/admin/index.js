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
      meta: {},
      moduleActive: {
        name: '',
        actionList: ''
      },
      logo: '/front/img/logo.png',
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
    },
    isNotEmptyList(state) {
      return (state.cfApp.meta.total > 0);
    },
    moduleNameActive(state) {
      return state.cfApp.moduleActive.name;
    },
    moduleActionListActive(state) {
      return state.cfApp.moduleActive.actionList;
    }
  },
  mutations: {
    configApp(state, configs) {
      state.cfApp.links = configs.links;
      state.cfApp.meta = configs.meta;
      state.cfApp.moduleActive = configs.moduleActive;
    }
  },
  actions: {
    setConfigApp({
      commit
    }, configs) {
      commit('configApp', {
        ...{
          links: {},
          meta: {},
          moduleActive: {
            name: '',
            actionList: ''
          }
        },
        ...{
          links: configs.links,
          meta: configs.meta,
          moduleActive: configs.moduleActive
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