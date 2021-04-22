import Vue from 'vue';
import Vuex from 'vuex';

import home from './homes';
import video from './videos';
import info from './infos';
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
    navMainLists: [],
    pageLists: [],
    appLists: [],
  }
}


export default new Vuex.Store({
    state: {
      cfApp: {
        setting: defaultState()
      },
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
      }
    },
    modules: {
      home,
      video,
      info
    },
    strict: debug,
    plugins: debug ? [createLogger()] : []
});
