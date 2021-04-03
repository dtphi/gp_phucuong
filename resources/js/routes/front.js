import MainLayout from 'v@front/layouts/main';
import HomePage from 'v@front/page_homes';
import VideoPage from 'v@front/page_videos';

//static html layout
import Home from 'v@front/home';
import HomeLayout from 'v@front/layouts';
import Video from 'v@front/video';

import {
    config
} from '../common/config';

const debug = process.env.NODE_ENV === 'debuger';

let routeEnv = {};

if (debug) {
    routeEnv = {
        path: '',
        component: Home,
        name: 'home',
        meta: {
            layout: HomeLayout,
            role: 'public',
            show: {
                footer: true
            },
            title: 'ログイン | ' + config.site_name
        },
        children: [{
            path: 'video',
            component: Video,
            name: 'video',
            meta: {
                layout: HomeLayout,
                role: 'public',
                show: {
                    footer: true
                },
                title: 'ログイン | ' + config.site_name
            },
        }]
    }
} else {
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
            }]
        }]
    }
}

export default [routeEnv];