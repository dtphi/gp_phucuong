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
        path: 'tin-tuc',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: 'xem-nhieu',
            component: () => import ('v@front/page_news_populars'),
            name: 'news-popular-page',
            meta: {
                auth: false,
                header: 'Trang Tin Tức Xem Nhiều',
                layout: MainLayout,
                role: 'guest',
                layout_content: {}
            }
        }, {
            path: 'chi-tiet/:slug',
            component: () =>
                import ('v@front/page_news_details'),
            name: 'news-slug-detail-page',
            meta: {
                auth: false,
                header: 'Trang Chi Tiết Tin Tức',
                layout: MainLayout,
                role: 'guest',
                layout_content: {}
            }
        }]
    }]
}

export default [routeEnv];