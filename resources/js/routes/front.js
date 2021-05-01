import MainLayout from 'v@front/layouts/main';
import HomePage from 'v@front/page_homes';
import VideoPage from 'v@front/page_videos';
import NewsPage from 'v@front/page_news';
import NewsPopularPage from 'v@front/page_news_populars';
import NewsDetailPage from 'v@front/page_news_details';
import VideoDetailPage from 'v@front/page_video_details';
import CategoryNewsPage from 'v@front/page_category_news';

import {
    config
} from '../common/config';

const debug = process.env.NODE_ENV === 'debuger';

let routeEnv = {};

routeEnv = {
    path: '',
    component: {
        render: c => c('router-view')
    },

    children: [{
        path: '',
        component: HomePage,
        name: 'home',
        meta: {
            layout: MainLayout,
            role: 'public',
            show: {
                footer: true
            },
            title: 'Trang chủ | ' + config.site_name
        }
    }, {
        path: 'home',
        component: HomePage,
        name: 'home_1',
        meta: {
            layout: MainLayout,
            role: 'public',
            show: {
                footer: true
            },
            title: 'Trang chủ | ' + config.site_name
        }
    }, {
        path: 'danh-muc-tin',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: CategoryNewsPage,
            name: 'news-category-all-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Danh Mục Tin Tức | ' + config.site_name
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: CategoryNewsPage,
            name: 'news-category-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Danh Mục Tin Tức | ' + config.site_name
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug_1/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: CategoryNewsPage,
            name: 'news-category_1-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Tin Tức | ' + config.site_name
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug_2/:slug_1/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: CategoryNewsPage,
            name: 'news-category_2-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Tin Tức | ' + config.site_name
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug_3/:slug_2/:slug_1/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: CategoryNewsPage,
            name: 'news-category_3-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Tin Tức | ' + config.site_name
            }
        }]
    }, {
        path: 'tin-tuc',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: NewsPage,
            name: 'news-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Tin Tức | ' + config.site_name
            }
        },
        {
            path: 'xem-nhieu',
            component: NewsPopularPage,
            name: 'news-popular-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Tin Tức | ' + config.site_name
            }
        },
        {
            path: 'chi-tiet/:slug',
            component: NewsDetailPage,
            name: 'news-slug-detail-page',
            meta: {
                auth: false,
                header: 'News Detail Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Tin Tức Chi Tiet | ' + config.site_name,
                layout_content: {
                    content_bottom: false,
                    content_main: true,
                    right_collumn:true,
                    left_collumn: true,
                }
            },
            layout_content: {
                content_bottom: false,
                content_main: true,
                right_collumn:false,
                left_collumn: true,
            }
        }
    ]
    }, {
        path: 'video',
        component: {
            render: c => c('router-view')
        },
        children: [{
                path: '',
                component: VideoPage,
                name: 'video-page',
                meta: {
                    auth: false,
                    header: 'Video Page',
                    layout: MainLayout,
                    role: 'guest',
                    title: 'Trang Video | ' + config.site_name
                }
            },
            {
                path: 'chi-tiet/:slug',
                component: VideoDetailPage,
                name: 'video-detail-page',
                meta: {
                    auth: false,
                    header: 'Video Detail Page',
                    layout: MainLayout,
                    role: 'guest',
                    title: 'Trang Chie Tiet Video | ' + config.site_name
                }
            }
        ]
    }]
}

export default [routeEnv];