require('./bootstrap');

import Vue from 'vue';
import Router from 'vue-router';
import routes from './routes/front';
import store from 'store@front';

Vue.use(Router);
window.vue = Vue;
require('./views/front/App');

const layout = JSON.parse(window.page);

const router = new Router({
  history: true,
  mode: 'history',
  routes: [
    ...routes
  ]
});

const initParamsApp = {
  type: 'init',
  pathName: window.location.pathname,
  layout: layout
}

router.beforeEach(async (to, from, next) => {
    if (Object.keys(to.meta.layout_content).length === 0) {
      to.meta.layout_content = layout.layout_content;
    }

    next();
});

store.dispatch('appSettings', initParamsApp).then(() => {
    return new Vue({
        el: '#gp-phu-cuong',
        router,
        store
    })
})