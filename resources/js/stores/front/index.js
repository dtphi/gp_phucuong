import Vue from 'vue';
import Vuex from 'vuex';

import home from './home';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
      cfApp: {
        logo: '/front/img/logo.png',
        banner: '/images/banner_image.jpg',
      }
    },
    getters: {
      cfApp(state) {
        return state.cfApp;
      }
    },
    mutations: {},
    actions: {},
    modules: {
      home,
    },
});
