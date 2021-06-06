require('./bootstrap');

import Vue from 'vue';
import Router from 'vue-router';
import routes from './routes/front';
import store from 'store@front';

Vue.use(Router);
window.vue = Vue;
require('./views/front/App');

const router = new Router({
  history: true,
  mode: 'history',
  routes: [
    ...routes
  ]
});

const initParamsApp = {
  type: 'init',
  pathName: window.location.pathname
}

router.beforeEach(async (to, from, next) => {
    let pageData = JSON.parse(window.page);
    if (Object.keys(to.meta.layout_content).length === 0) {
      to.meta.layout_content = pageData.layout_content;
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