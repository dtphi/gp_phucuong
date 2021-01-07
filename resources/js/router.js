import Vue from 'vue';
import Router from 'vue-router';

import routes from './routes/index';
import adminRoutes from './routes/admin';
import storeRoutes from './routes/store';
import representativeRoutes from './routes/representative';
import store from './stores';

Vue.use(Router);

const router = new Router({
    history: true,
    mode: 'history',
    routes: [
        ...routes,
        ...adminRoutes,
        ...representativeRoutes,
        ...storeRoutes
    ]
});

router.beforeEach(async (to, from, next) => {
    document.title = to.meta.title;

    if (to.path.startsWith('/admin')) {
        store.commit('representative.auth/LOGOUT');
        store.commit('store.auth/LOGOUT');
        localStorage.setItem('role', 'admin');

        if (store.getters['admin.auth/isAuthenticated'] && from.name !== 'admin.auth.login') {
            await store.dispatch('admin.auth/refresh');
        }

        if (to.matched.some(record => record.meta.auth) && !store.getters['admin.auth/isAuthenticated']) {
            next({ name: 'admin.auth.login' });
            return;
        }
        if (to.name === 'admin.auth.login' && store.getters['admin.auth/isAuthenticated']) {
            next({ name: 'admin.menu.main.menu' });
            return;
        }
    }

    if (to.path.startsWith('/sale-representative')) {
        store.commit('admin.auth/LOGOUT');
        store.commit('store.auth/LOGOUT');
        localStorage.setItem('role', 'representative');

        if (store.getters['representative.auth/isAuthenticated'] && from.name !== 'public.auth.login') {
            await store.dispatch('representative.auth/refresh');
        }

        if (to.matched.some(record => record.meta.auth) && !store.getters['representative.auth/isAuthenticated']) {
            next({ name: 'public.auth.login' });
            return;
        }
        if (to.name === 'public.auth.login' && store.getters['representative.auth/isAuthenticated']) {
            next({ name: 'representative.menu.main.menu' });
            return;
        }
    }

    if (to.path.startsWith('/store')) {
        store.commit('admin.auth/LOGOUT');
        store.commit('representative.auth/LOGOUT');
        localStorage.setItem('role', 'store');

        if (store.getters['store.auth/isAuthenticated'] && from.name !== 'public.auth.login') {
            await store.dispatch('store.auth/refresh');
        }

        if (to.matched.some(record => record.meta.auth) && !store.getters['store.auth/isAuthenticated']) {
            next({ name: 'public.auth.login' });
            return;
        }
        if (to.name === 'public.auth.login' && store.getters['store.auth/isAuthenticated']) {
            next({ name: 'store.menu.main.menu' });
            return;
        }
    }

    if (to.path === '/') {
        if (store.getters['representative.auth/isAuthenticated']) {
            next({ name: 'representative.menu.main.menu' });
            return;
        }
        if (store.getters['store.auth/isAuthenticated']) {
            next({ name: 'store.menu.main.menu' });
            return;
        }
    }
    next();
});

export default router;