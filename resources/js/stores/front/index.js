import axios from 'axios';
import Vue from 'vue';
import Vuex from 'vuex';

import home from './home';
import createLogger from '../../plugins/logger';

Vue.use(Vuex);

const debug = process.env.NODE_ENV === 'debuger';

import {
  apiGetSettings
} from '@app/api/front/apps';

const settings = {
  logo: '/front/img/logo.png',
  banner: '/images/banner_image.jpg',
  navMainLists: []
}


export default new Vuex.Store({
    state: {
      cfApp: {
        setting: {}
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
          children: {...state.cfApp.setting.navMainLists}
        };
        
        return menus;
      }
    },
    mutations: {
      initSetting(state, payload) {
        state.cfApp.setting = payload;
      },
      appSetError(state, payload) {
        state.errors = payload;
      }
     },
    actions: {
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
    },
    strict: debug,
    plugins: debug ? [createLogger()] : []
});
