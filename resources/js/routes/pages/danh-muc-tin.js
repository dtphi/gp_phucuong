import MainLayout from 'v@front/layouts/main';

const debug = process.env.NODE_ENV === 'debuger';

const network = ['facebook', 'twitter', 'linkedin', 'whatsapp'];
let routeEnv = {};

routeEnv = {
    path: '',
    component: {
        render: c => c('router-view')
    },
    children: [{
        path: 'danh-muc-tin',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () => import ('v@front/page_category_news'),
            name: 'news-category-all-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                layout_content: {},
                network: network
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () => import ('v@front/page_category_news'),
            name: 'news-category-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                layout_content: {},
                network: network
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug_1/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () => import ('v@front/page_category_news'),
            name: 'news-category_1-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                layout_content: {},
                network: network
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug_2/:slug_1/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () => import ('v@front/page_category_news'),
            name: 'news-category_2-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                layout_content: {},
                network: network
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug_3/:slug_2/:slug_1/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () => import ('v@front/page_category_news'),
            name: 'news-category_3-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                layout_content: {},
                network: network
            }
        }]
    }]
}

export default [routeEnv];