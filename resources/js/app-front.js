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

store.dispatch('appSettings', {
    type: 'init'
}).then(() => {
    return new Vue({
        el: '#gp-phu-cuong',
        router,
        store
    })
})