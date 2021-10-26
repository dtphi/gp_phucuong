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
        path: '/',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () => import ('v@front/page_news'),
            name: 'home-page',
            meta: {
                auth: false,
                header: 'Trang chủ',
                layout: MainLayout,
                role: 'guest',
                layout_content: {}
            }
        }, {
            path: 'trang-chu',
            component: () => import ('v@front/page_news'),
            name: 'home-page1',
            meta: {
                auth: false,
                header: 'Trang chủ',
                layout: MainLayout,
                role: 'guest',
                layout_content: {
                }
            }
        }]
    }]
}

export default [routeEnv];