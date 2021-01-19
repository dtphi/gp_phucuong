import Vue from 'vue';
import Router from 'vue-router';

import routes from './routes/public';
import adminRoutes from './routes/admin';

import store from './stores';

Vue.use(Router);

const router = new Router({
    history: true,
    mode: 'history',
    routes: [
        ...routes,
        ...adminRoutes
    ]
});

router.beforeEach(async (to, from, next) => {
    document.title = to.meta.title;
    next();
});

export default router;