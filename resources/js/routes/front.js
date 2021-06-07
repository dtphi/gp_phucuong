import MainLayout from 'v@front/layouts/main';
import HomePage from 'v@front/page_news';
import CategoryPage from 'v@front/page_category_news';
import VideoPage from 'v@front/page_videos';

const debug = process.env.NODE_ENV === 'debuger';

const ModuleContent = {
    module_left_info_left_side_bar: 'info-left-side-bar',
    module_left_category_left_side_bar: 'category-left-side-bar',
    module_left_newsletter_register:'newsletter-register',
    module_left_summary_contact: 'summary-contact',
    module_left_category_sub_left_side_bar: 'category-sub-left-side-bar',

    middle_module_info_carousel: 'info-carousel',
    middle_module_special_banner: 'special-banner',
    module_middle_loi_chua: 'loi-chua',
    module_middle_van_kien: 'van-kien',
    module_middle_tin_giao_phan: 'tin-giao-phan',
    module_middle_tin_giao_hoi: 'tin-giao-hoi',

    module_right_info_fanpage: 'info-fanpage',
    module_right_youtube_hanh_cac_thanh: 'youtube-hanh-cac-thanh',
    module_right_lich_cong_giao: 'lich-cong-giao',
    module_right_thong_bao: 'thong-bao',
    module_right_category_icon_side_bar: 'category-icon-side-bar',
    module_right_sach_noi_iframe: 'sach-noi-iframe',

    module_both_noi_bat: 'noi-bat',
    module_both_page_banner_list: 'page-banner-list'
}

const ModuleContentHome = {
    content_top: true,
    content_top_column: {
        right_column: true,
        middle_column: true,
        left_column: false,
        colClass: '8 notication',
        left_modules: [],
        middle_modules: [
            {
                moduleName: ModuleContent.middle_module_info_carousel,
                sortOrder: 0
            }
        ],
        right_modules: [],
        both_column: false,
        both_modules: [],
        column_number: 2
    },
    content_bottom: false,
    content_bottom_column: {
        right_column: false,
        middle_column: false,
        left_column: false,
        colClass: '',
        left_modules: [],
        middle_modules: [],
        right_modules: [],
        both_column: false,
        both_modules: [],
        column_number: 2
    },
    content_main: false,
    content_main_column: {
        right_column: false,
        middle_column: false,
        left_column: false,
        colClass: '',
        left_modules: [],
        middle_modules: [],
        right_modules: [],
        both_column: false,
        both_modules: [],
        column_number: 2
    }
}

const ModuleContentCategory = {
    content_top: true,
    content_top_column: {
        right_column: true,
        middle_column: true,
        left_column: true,
        colClass: '5',
        left_modules: [
            {
                moduleName: ModuleContent.module_left_category_sub_left_side_bar,
                sortOrder: 0,
                isShowMobile: false
            },
            {
                moduleName: ModuleContent.module_left_info_left_side_bar,
                sortOrder: 0,
                componentClass: '',
                isShowMobile: false
            },
            {
                moduleName: ModuleContent.module_left_category_left_side_bar,
                sortOrder: 0,
                componentClass: '',
                isShowMobile: false
            },
            {
                moduleName: ModuleContent.module_left_newsletter_register,
                sortOrder: 0,
                componentClass: 'form test',
                isShowMobile: false
            },
            {
                moduleName: ModuleContent.module_left_summary_contact,
                sortOrder: 0,
                componentClass: 'logo test',
                isShowMobile: false
            }
        ],
        middle_modules: [],
        right_modules: [
            {
                moduleName: ModuleContent.module_right_thong_bao,
                sortOrder: 0
            },
            {
                moduleName: ModuleContent.module_right_lich_cong_giao,
                sortOrder: 0
            },
            {
                moduleName: ModuleContent.module_right_sach_noi_iframe,
                sortOrder: 0
            },
            {
                moduleName: ModuleContent.module_right_info_fanpage,
                sortOrder: 0
            },
            {
                moduleName: ModuleContent.module_right_youtube_hanh_cac_thanh,
                sortOrder: 0
            }
        ],
        both_column: false,
        both_modules: [],
        column_number: 2
    },
    content_bottom: false,
    content_bottom_column: {
        right_column: false,
        middle_column: false,
        left_column: false,
        colClass: '',
        left_modules: [],
        middle_modules: [],
        right_modules: [],
        both_column: false,
        both_modules: [],
        column_number: 2
    },
    content_main: false,
    content_main_column: {
        right_column: false,
        middle_column: false,
        left_column: false,
        colClass: '',
        left_modules: [],
        middle_modules: [],
        right_modules: [],
        both_column: false,
        both_modules: [],
        column_number: 2
    },
    right_column: false,
    middle_column: true,
    left_column: true,
    column_number: 2,
}

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
            component: HomePage,
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
            component: HomePage,
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
    }, {
        path: 'danh-muc-tin',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: CategoryPage,
            name: 'news-category-all-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                layout_content: {}
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: CategoryPage,
            name: 'news-category-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                layout_content: {}
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug_1/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: CategoryPage,
            name: 'news-category_1-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                layout_content: {}
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug_2/:slug_1/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: CategoryPage,
            name: 'news-category_2-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                layout_content: {}
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug_3/:slug_2/:slug_1/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: CategoryPage,
            name: 'news-category_3-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                layout_content: {}
            }
        }]
    }, {
        path: 'tin-tuc',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: 'xem-nhieu',
            component: () =>
                import ('v@front/page_news_populars'),
            name: 'news-popular-page',
            meta: {
                auth: false,
                header: 'News Page',
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
                header: 'News Detail Page',
                layout: MainLayout,
                role: 'guest',
                layout_content: {}
            }
        }]
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
                layout_content: {}
            }
        }, {
            path: 'chi-tiet/:slug',
            component: () =>
                import ('v@front/page_video_details'),
            name: 'video-detail-page',
            meta: {
                auth: false,
                header: 'Video Detail Page',
                layout: MainLayout,
                role: 'guest',
                layout_content: {}
            }
        }]
    }]
}

export default [routeEnv];