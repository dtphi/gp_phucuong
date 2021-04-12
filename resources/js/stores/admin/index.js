import Vue from 'vue';
import Vuex from 'vuex';

import auth from './auth';
import layout from './layout';
import user from './users';
import info from './infos';
import news_category from './categories';
import createLogger from '../../plugins/logger';

Vue.use(Vuex);

const debug = process.env.NODE_ENV === 'debuger';

const defaultState = () => {
  return {
    errors: [],
    links: {},
    meta: {},
    perPage: 5,
    moduleActive: {
      name: '',
      actionList: ''
    },
    logo: '/front/img/logo.png',
    collectionData: {
      current_page: 1,
      from: 0,
      to:0,
      total: 0
    }
  }
}

export default new Vuex.Store({
  state: {
    cfApp: defaultState()
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
    collectionPaginationData(state) {
      return state.cfApp.collectionData;
    },
    isNotEmptyList(state) {
      if (typeof state.cfApp.meta !== "undefined") {
        return (state.cfApp.meta.total > 0);
      }

      return false;
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
      if (configs.links != undefined) {
        state.cfApp.links = configs.links;
      }
      if (configs.meta != undefined) {
        state.cfApp.meta = configs.meta;
      }
      if (configs.moduleActive)
      {
        state.cfApp.moduleActive = configs.moduleActive;
      }
      if (configs.collectionData != undefined)
      {
        state.cfApp.collectionData = configs.collectionData;
      }
    }
  },
  actions: {
    setConfigApp({
      commit
    }, configs) {
      const links = (configs.hasOwnProperty('links')) ? configs.links: undefined;
      const meta = (configs.hasOwnProperty('meta')) ? configs.meta: undefined;
      const moduleActive = (configs.hasOwnProperty('moduleActive')) ? configs.moduleActive: '';
      const collectionData = (configs.hasOwnProperty('collectionData')) ? configs.collectionData: undefined;

      var _configs = {
        ...defaultState(),
        ...{
          links: links,
          meta: meta,
          moduleActive: moduleActive,
          collectionData: collectionData
        }
      };

      commit('configApp', _configs);
    }
  },
  modules: {
    auth,
    layout,
    user,
    info,
    news_category
  },
  strict: debug,
  plugins: debug ? [createLogger()] : []
});