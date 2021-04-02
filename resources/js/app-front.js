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
    document.title = to.meta.title;

    next();
});

store.dispatch('appSettings', initParamsApp).then(() => {
    return new Vue({
        el: '#gp-phu-cuong',
        router,
        store
    })
})