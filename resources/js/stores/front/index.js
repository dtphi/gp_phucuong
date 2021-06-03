import Vue from 'vue';
import Vuex from 'vuex';

import home from './homes';
import video from './videos';
import info from './infos';
import subscribe from './subscribes';
import appModule from './modules';
import createLogger from '../../plugins/logger';
import {
  GET_INFORMATION_LIST_TO_CATEGORY
} from '@app/stores/front/types/action-types';
import {
  MODULE_INFO
} from '@app/stores/front/types/module-types';

Vue.use(Vuex);

const debug = process.env.NODE_ENV === 'debuger';

import {
  apiGetSettings
} from '@app/api/front/apps';

const fnIsObject = (obj) => {
  if (typeof obj !== "undefined" &&
    typeof obj === "object" &&
    Object.keys(obj).length) {
    return true;
  }

  return false;
}


const defaultState = () => {
  return {
    logo: '/front/img/logo.png',
    banner: '/Image/NewPicture/home_banners/banner_image.png',
    iconBookUrl: '/',
    navMainLists: [],
    pageLists: [],
    appLists: [],
    infoLasteds: [],
    infoPopulars: [],
    pages: {}
  }
}

const initPaginationState = () => {
  return {
    links: {},
    meta: {},
    perPage: 20,
    moduleActive: {
      name: MODULE_INFO,
      actionList: GET_INFORMATION_LIST_TO_CATEGORY,
      params: {}
    },
    collectionData: {
      current_page: 1,
      from: 0,
      to: 0,
      total: 0
    }
  }
}

export default new Vuex.Store({
  state: {
    cfApp: {
      setting: defaultState()
    },
    paginationRoot: initPaginationState(),
    errors: [],
    clientsTestimonialsPage: 4
  },
  getters: {
    cfApp(state) {
      return state.cfApp;
    },
    bannerUrl(state) {
      return state.cfApp.setting.banner;
    },
    logoUrl(state) {
      return state.cfApp.setting.logo;
    },
    navMainLists(state) {
      let menus = {
        id: 0,
        newsgroupname: 'Home',
        children: []
      };

      if (fnIsObject(state.cfApp.setting) &&
        state.cfApp.setting.hasOwnProperty('navMainLists') &&
        Array.isArray(state.cfApp.setting.navMainLists)) {
        menus.children = { ...state.cfApp.setting.navMainLists
        };
      }

      return menus;
    },
    pageLists(state) {
      return state.cfApp.setting.pageLists;
    },

    resourcePaginationData(state) {
      return {
        links: state.paginationRoot.links,
        meta: state.paginationRoot.meta
      }
    },
    collectionPaginationData(state) {
      const colData = {
        current_page: 1,
        from: 0,
        to: 0,
        total: 0
      };
      if (fnIsObject(state.paginationRoot.collectionData)) {
        return state.paginationRoot.collectionData;
      }

      return colData;
    },
    isNotEmptyList(state) {
      if (fnIsObject(state.paginationRoot.meta) &&
        state.paginationRoot.meta.hasOwnProperty('total')) {
        return (parseInt(state.paginationRoot.meta.total) > 0);
      }

      return false;
    },
    moduleNameActive(state) {
      let mName = '';
      if (fnIsObject(state.paginationRoot.moduleActive) &&
        state.paginationRoot.moduleActive.hasOwnProperty('name')) {
        mName = state.paginationRoot.moduleActive.name;
      }

      return mName;
    },
    moduleActionListActive(state) {
      let mAction = '';
      if (fnIsObject(state.paginationRoot.moduleActive) &&
        state.paginationRoot.moduleActive.hasOwnProperty('actionList')) {
        mAction = state.paginationRoot.moduleActive.actionList;
      }

      return mAction;
    },
    isScreen767(state) {
      return state.clientsTestimonialsPage == 1;
    },
    isScreen1200(state) {
      return state.clientsTestimonialsPage <= 3;
    },
    isScreen960(state) {
      return state.clientsTestimonialsPage <= 2;
    }
  },
  mutations: {
    initOptions(state, payload) {
      state.options = payload;
    },
    initSetting(state, payload) {
      state.cfApp.setting = payload;
    },
    appSetError(state, payload) {
      state.errors = payload;
    },

    configApp(state, configs) {
      if (fnIsObject(configs.links)) {
        state.paginationRoot.links = configs.links;
      }
      if (fnIsObject(configs.meta)) {
        state.paginationRoot.meta = configs.meta;
      }
      if (fnIsObject(configs.moduleActive)) {
        state.paginationRoot.moduleActive = configs.moduleActive;
      }
      if (fnIsObject(configs.collectionData)) {
        state.paginationRoot.collectionData = configs.collectionData;
      }
    }
  },
  actions: {
    setParams({
      commit
    }, params) {
      commit('initOptions', params);
    },
    appSettings({
      commit
    }, options) {
      apiGetSettings(
        (responses) => {
          commit('initSetting', responses);
          commit('appSetError', []);
        },
        (errors) => {
          commit('appSetError', error);
        },
        options
      );
    },

    setConfigApp({
      commit
    }, configs) {
      const links = (configs.hasOwnProperty('links')) ? configs.links : undefined;
      const meta = (configs.hasOwnProperty('meta')) ? configs.meta : undefined;
      const moduleActive = (configs.hasOwnProperty('moduleActive')) ? configs.moduleActive : undefined;
      const collectionData = (configs.hasOwnProperty('collectionData')) ? configs.collectionData : undefined;

      var _configs = {
        ...initPaginationState(),
        ...{
          links: links,
          meta: meta,
          moduleActive: moduleActive,
          collectionData: collectionData
        }
      };

      commit('configApp', _configs);
    },

    winWidth({state}) {
      var w = window.innerWidth;
      if (w < 768) {
        state.clientsTestimonialsPage = 1
      } else if (w < 960) {
        state.clientsTestimonialsPage = 2
      } else if (w < 1200) {
        state.clientsTestimonialsPage = 3
      } else {
        state.clientsTestimonialsPage = 4
      }
    },
  },
  modules: {
    home,
    video,
    info,
    subscribe,
    appModule
  },
  strict: debug,
  plugins: debug ? [createLogger()] : []
});