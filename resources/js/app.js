require('./bootstrap');
require('./common/detectbrowser');

import '@babel/polyfill';
import axios from 'axios';
import createAuthRefreshInterceptor from 'axios-auth-refresh';
import Vue from 'vue';
import VueAxios from 'vue-axios';
import router from './router';
import store from './stores';
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue';
import { ServerTable } from 'vue-tables-2';
import lightGallery from 'lightgallery/dist/js/lightgallery-all';
import './common/veeValidation';
import mixin from './common/shared';

// Set Vue globally
window.Vue = Vue;

let logoutMutation = 'representative.auth/LOGOUT';
let refreshAction = 'representative.auth/refresh';
let loginRoute = 'public.auth.login';

switch (localStorage.getItem('role')) {
    case 'admin':
        logoutMutation = 'admin.auth/LOGOUT';
        refreshAction = 'admin.auth/refresh';
        loginRoute = 'admin.auth.login';
        break;
    case 'store':
        logoutMutation = 'store.auth/LOGOUT';
        refreshAction = 'store.auth/refresh';
        break;
}

// Set Vue authentication
axios.defaults.withCredentials = true;
axios.defaults.baseURL = '/api/v1/';
axios.interceptors.request.use(async config => {
    config.headers.common = {
        Authorization: `Bearer ${store.getters['token']}`,
        'Content-Type': 'application/json',
        Accept: 'application/json',
        PasswordLastChanged: store.getters['passwordLastChangedAt'],
        RepresentativeMainEmail: store.getters['representative.auth/representativeMainEmail'],
        StoreCode: store.getters['store.auth/storeCode'],
    };
    store.commit('START_LOADING');

    return config;
});
axios.interceptors.response.use(
    async response => {
        store.commit('STOP_LOADING');

        if (response.data && response.data.status === 403 && response.data.errors.logout === true) {
            store.commit(logoutMutation);
            localStorage.setItem('system_error', response.data.errors.message);
            return router.push({ name: loginRoute });
        }

        return response;
    },
    async error => {
        store.commit('STOP_LOADING');
        store.commit(logoutMutation);
        console.error(error.response.data.message);

        switch (error.response.status) {
            case 401:
            case 403:
                localStorage.setItem('system_error', error.response.data.message);
                break;
        }
        return router.push({ name: loginRoute });
    }
);
const refreshAuthLogic = failedRequest => store.dispatch(refreshAction).then(() => {
    failedRequest.response.config.headers['Authorization'] = 'Bearer ' + store.getters['token'];

    return Promise.resolve();
});
createAuthRefreshInterceptor(axios, refreshAuthLogic);

Vue.use(VueAxios, axios);

Vue.config.productionTip = false;

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);

Vue.use(ServerTable, {}, false, 'bootstrap4', {});

Vue.mixin(mixin);

new Vue({
    el: '#gp-phu-cuong',
    router,
    store,
    data() {
        return {
            layout: 'div'
        };
    }
});