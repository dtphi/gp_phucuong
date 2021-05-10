import Vue from 'vue';
import Vuex from 'vuex';

import home from './homes';
import video from './videos';
import info from './infos';
import appModule from './modules';
import createLogger from '../../plugins/logger';

Vue.use(Vuex);

const debug = process.env.NODE_ENV === 'debuger';

import {
  apiGetSettings
} from '@app/api/front/apps';

const fnIsObject = (obj) => {
  if (typeof obj !== "undefined" 
    && typeof obj === "object" 
    && Object.keys(obj).length) {
    return true;
  }

  return false;
}


const defaultState = () => {
  return {
    logo: '/front/img/logo.png',
    banner: '/images/banner_image.jpg',
    iconBookUrl: '/',
    navMainLists: [],
    pageLists: [],
    appLists: [],
    pages: {},
  }
}

const initPaginationState = () => {
  return {
    links: {},
    meta: {},
    perPage: 20,
    moduleActive: {
      name: '',
      actionList: ''
    },
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
      cfApp: {
        setting: defaultState()
      },
      paginationRoot: initPaginationState(),
      errors: []
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

        if (fnIsObject(state.cfApp.setting) 
          && state.cfApp.setting.hasOwnProperty('navMainLists') 
          && Array.isArray(state.cfApp.setting.navMainLists)) {
            menus.children = {...state.cfApp.setting.navMainLists};
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
          to:0,
          total: 0
        };
        if (fnIsObject(state.paginationRoot.collectionData)) {
          return state.paginationRoot.collectionData;
        }
  
        return colData;
      },
      isNotEmptyList(state) {
        if (fnIsObject(state.paginationRoot.meta) 
          && state.paginationRoot.meta.hasOwnProperty('total')) {
          return (parseInt(state.paginationRoot.meta.total) > 0);
        }
  
        return false;
      },
      moduleNameActive(state) {
        let mName = '';
        if (fnIsObject(state.paginationRoot.moduleActive) 
          && state.paginationRoot.moduleActive.hasOwnProperty('name')) {
            mName = state.paginationRoot.moduleActive.name;
        }
  
        return mName;
      },
      moduleActionListActive(state) {
        let mAction = '';
        if (fnIsObject(state.paginationRoot.moduleActive)
          && state.paginationRoot.moduleActive.hasOwnProperty('actionList')) {
            mAction = state.paginationRoot.moduleActive.actionList;
        }
  
        return mAction;
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
        if (fnIsObject(configs.moduleActive))
        {
          state.paginationRoot.moduleActive = configs.moduleActive;
        }
        if (fnIsObject(configs.collectionData))
        {
          state.paginationRoot.collectionData = configs.collectionData;
        }
      }
     },
    actions: {
      setParams({commit}, params) {
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
        const links = (configs.hasOwnProperty('links')) ? configs.links: undefined;
        const meta = (configs.hasOwnProperty('meta')) ? configs.meta: undefined;
        const moduleActive = (configs.hasOwnProperty('moduleActive')) ? configs.moduleActive: undefined;
        const collectionData = (configs.hasOwnProperty('collectionData')) ? configs.collectionData: undefined;
  
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
      }
    },
    modules: {
      home,
      video,
      info,
      appModule
    },
    strict: debug,
    plugins: debug ? [createLogger()] : []
});
