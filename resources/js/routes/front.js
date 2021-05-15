import MainLayout from 'v@front/layouts/main';

import {
    config
} from '../common/config';

const debug = process.env.NODE_ENV === 'debuger';

const ModuleContent = {
    middle_module_info_carousel: 'info-carousel',

    module_right_info_fanpage: 'info-fanpage',
    module_right_youtube_hanh_cac_thanh: 'youtube-hanh-cac-thanh',
    module_right_lich_cong_giao: 'lich-cong-giao',
    module_right_thong_bao: 'thong-bao',
    module_right_category_icon_side_bar: 'category-icon-side-bar',
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
            component: () =>
                import ('v@front/page_homes'),
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
            component: () =>
                import ('v@front/page_homes'),
            name: 'home_1',
            meta: {
                layout: MainLayout,
                role: 'public',
                show: {
                    footer: true
                },
                title: 'Trang chủ | ' + config.site_name
            }
        }]
    }, {
        path: 'danh-muc-tin',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () =>
                import ('v@front/page_category_news'),
            name: 'news-category-all-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Danh Mục Tin Tức | ' + config.site_name,
                layout_content: {
                    content_top: true,
                    content_top_column: {
                        right_collumn: false,
                        middle_column: true,
                        left_collumn: true,
                        colClass: '',
                        middle_module_info_carousel: '',
                        column_number: 2
                    },
                    content_bottom: false,
                    content_main: false,
                    content_main_column: {
                        right_collumn: false,
                        middle_column: false,
                        left_collumn: false,
                        colClass: '',
                        middle_module_info_carousel: '',
                        module_right_info_fanpage: '',
                        module_right_youtube_hanh_cac_thanh: '',
                        module_right_lich_cong_giao: '',
                        module_right_thong_bao: '',
                        module_right_category_icon_side_bar: '',
                        column_number: 2
                    },
                    right_collumn: false,
                    middle_column: true,
                    left_collumn: true,
                    column_number: 2,
                }
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () =>
                import ('v@front/page_category_news'),
            name: 'news-category-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Danh Mục Tin Tức | ' + config.site_name,
                layout_content: {
                    content_top: true,
                    content_top_column: {
                        right_collumn: false,
                        middle_column: true,
                        left_collumn: true,
                        colClass: '',
                        middle_module_info_carousel: '',
                        column_number: 2
                    },
                    content_bottom: false,
                    content_main: false,
                    content_main_column: {
                        right_collumn: false,
                        middle_column: false,
                        left_collumn: false,
                        colClass: '',
                        middle_module_info_carousel: '',
                        module_right_info_fanpage: '',
                        module_right_youtube_hanh_cac_thanh: '',
                        module_right_lich_cong_giao: '',
                        module_right_thong_bao: '',
                        module_right_category_icon_side_bar: '',
                        column_number: 2
                    },
                    right_collumn: false,
                    middle_column: true,
                    left_collumn: true,
                    column_number: 2,
                }
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug_1/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () =>
                import ('v@front/page_category_news'),
            name: 'news-category_1-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Tin Tức | ' + config.site_name,
                layout_content: {
                    content_top: true,
                    content_top_column: {
                        right_collumn: false,
                        middle_column: true,
                        left_collumn: true,
                        colClass: '',
                        middle_module_info_carousel: '',
                        column_number: 2
                    },
                    content_bottom: false,
                    content_main: false,
                    content_main_column: {
                        right_collumn: false,
                        middle_column: false,
                        left_collumn: false,
                        colClass: '',
                        middle_module_info_carousel: '',
                        module_right_info_fanpage: '',
                        module_right_youtube_hanh_cac_thanh: '',
                        module_right_lich_cong_giao: '',
                        module_right_thong_bao: '',
                        module_right_category_icon_side_bar: '',
                        column_number: 2
                    },
                    right_collumn: false,
                    middle_column: true,
                    left_collumn: true,
                    column_number: 2,
                }
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug_2/:slug_1/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () =>
                import ('v@front/page_category_news'),
            name: 'news-category_2-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Tin Tức | ' + config.site_name,
                layout_content: {
                    content_top: true,
                    content_top_column: {
                        right_collumn: false,
                        middle_column: true,
                        left_collumn: true,
                        colClass: '',
                        middle_module_info_carousel: '',
                        column_number: 2
                    },
                    content_bottom: false,
                    content_main: false,
                    content_main_column: {
                        right_collumn: false,
                        middle_column: false,
                        left_collumn: false,
                        colClass: '',
                        middle_module_info_carousel: '',
                        module_right_info_fanpage: '',
                        module_right_youtube_hanh_cac_thanh: '',
                        module_right_lich_cong_giao: '',
                        module_right_thong_bao: '',
                        module_right_category_icon_side_bar: '',
                        column_number: 2
                    },
                    right_collumn: false,
                    middle_column: true,
                    left_collumn: true,
                    column_number: 2,
                }
            }
        }]
    }, {
        path: 'danh-muc-tin/:slug_3/:slug_2/:slug_1/:slug',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () =>
                import ('v@front/page_category_news'),
            name: 'news-category_3-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Tin Tức | ' + config.site_name,
                layout_content: {
                    content_top: true,
                    content_top_column: {
                        right_collumn: false,
                        middle_column: true,
                        left_collumn: true,
                        colClass: '',
                        middle_module_info_carousel: '',
                        column_number: 2
                    },
                    content_bottom: false,
                    content_main: false,
                    content_main_column: {
                        right_collumn: false,
                        middle_column: false,
                        left_collumn: false,
                        colClass: '',
                        middle_module_info_carousel: '',
                        module_right_info_fanpage: '',
                        module_right_youtube_hanh_cac_thanh: '',
                        module_right_lich_cong_giao: '',
                        module_right_thong_bao: '',
                        module_right_category_icon_side_bar: '',
                        column_number: 2
                    },
                    right_collumn: false,
                    middle_column: true,
                    left_collumn: true,
                    column_number: 2,
                }
            }
        }]
    }, {
        path: 'tin-tuc',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () =>
                import ('v@front/page_news'),
            name: 'news-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Tin Tức | ' + config.site_name,
                layout_content: {
                    content_top: true,
                    content_top_column: {
                        right_collumn: true,
                        middle_column: true,
                        left_collumn: false,
                        colClass: '8 notication',
                        middle_module_info_carousel: ModuleContent.middle_module_info_carousel,
                        module_right_info_fanpage: '',
                        module_right_youtube_hanh_cac_thanh: '',
                        module_right_lich_cong_giao: '',
                        module_right_thong_bao: '',
                        module_right_category_icon_side_bar: '',
                        column_number: 2
                    },
                    content_bottom: true,
                    content_bottom_column: {
                        right_collumn: false,
                        middle_column: true,
                        left_collumn: false,
                        middle_module_info_carousel: '',
                        module_right_info_fanpage: ModuleContent.module_right_info_fanpage,
                        module_right_youtube_hanh_cac_thanh: ModuleContent.module_right_youtube_hanh_cac_thanh,
                        module_right_lich_cong_giao: ModuleContent.module_right_lich_cong_giao,
                        module_right_thong_bao: ModuleContent.module_right_thong_bao,
                        module_right_category_icon_side_bar: ModuleContent.module_right_category_icon_side_bar,
                        column_number: 2
                    },
                    content_main: false,
                    content_main_column: {
                        right_collumn: false,
                        middle_column: true,
                        left_collumn: false,
                        colClass: '',
                        middle_module_info_carousel: '',
                        module_right_info_fanpage: '',
                        module_right_youtube_hanh_cac_thanh: '',
                        module_right_lich_cong_giao: '',
                        module_right_thong_bao: '',
                        module_right_category_icon_side_bar: '',
                        column_number: 2
                    },
                    right_collumn: false,
                    middle_column: true,
                    left_collumn: false,
                    column_number: 2,
                }
            }
        }, {
            path: 'xem-nhieu',
            component: () =>
                import ('v@front/page_news_populars'),
            name: 'news-popular-page',
            meta: {
                auth: false,
                header: 'News Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Tin Tức | ' + config.site_name,
                layout_content: {
                    content_top: true,
                    content_top_column: {
                        right_collumn: false,
                        middle_column: true,
                        left_collumn: true,
                        colClass: '',
                        middle_module_info_carousel: '',
                        column_number: 2
                    },
                    content_bottom: false,
                    content_main: false,
                    content_main_column: {
                        right_collumn: false,
                        middle_column: false,
                        left_collumn: false,
                        colClass: '',
                        middle_module_info_carousel: '',
                        module_right_info_fanpage: '',
                        module_right_youtube_hanh_cac_thanh: '',
                        module_right_lich_cong_giao: '',
                        module_right_thong_bao: '',
                        module_right_category_icon_side_bar: '',
                        column_number: 2
                    },
                    right_collumn: false,
                    middle_column: true,
                    left_collumn: true,
                    column_number: 2,
                }
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
                title: 'Trang Tin Tức Chi Tiet | ' + config.site_name,
                layout_content: {
                    content_top: true,
                    content_top_column: {
                        right_collumn: true,
                        middle_column: true,
                        left_collumn: false,
                        colClass: '8 notication',
                        middle_module_info_carousel: '',
                        module_right_info_fanpage: ModuleContent.module_right_info_fanpage,
                        module_right_youtube_hanh_cac_thanh: ModuleContent.module_right_youtube_hanh_cac_thanh,
                        module_right_lich_cong_giao: ModuleContent.module_right_lich_cong_giao,
                        module_right_thong_bao: ModuleContent.module_right_thong_bao,
                        module_right_category_icon_side_bar: '',
                        column_number: 2
                    },
                    content_bottom: false,
                    content_main: true,
                    content_main_column: {
                        right_collumn: true,
                        middle_column: true,
                        left_collumn: false,
                        colClass: '8',
                        middle_module_info_carousel: '',
                        module_right_info_fanpage: '',
                        module_right_youtube_hanh_cac_thanh: '',
                        module_right_lich_cong_giao: '',
                        module_right_thong_bao: '',
                        module_right_category_icon_side_bar: '',
                        column_number: 2
                    },
                    right_collumn: true,
                    left_collumn: true,
                }
            }
        }]
    }, {
        path: 'video',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () =>
                import ('v@front/page_videos'),
            name: 'video-page',
            meta: {
                auth: false,
                header: 'Video Page',
                layout: MainLayout,
                role: 'guest',
                title: 'Trang Video | ' + config.site_name
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
                title: 'Trang Chie Tiet Video | ' + config.site_name,
                layout_content: {
                    content_top: true,
                    content_top_column: {
                        right_collumn: true,
                        middle_column: true,
                        left_collumn: false,
                        colClass: '8 notication',
                        middle_module_info_carousel: '',
                        module_right_info_fanpage: ModuleContent.module_right_info_fanpage,
                        module_right_youtube_hanh_cac_thanh: ModuleContent.module_right_youtube_hanh_cac_thanh,
                        module_right_lich_cong_giao: ModuleContent.module_right_lich_cong_giao,
                        module_right_thong_bao: ModuleContent.module_right_thong_bao,
                        module_right_category_icon_side_bar: '',
                        column_number: 2
                    },
                    content_bottom: false,
                    content_main: true,
                    content_main_column: {
                        right_collumn: true,
                        middle_column: true,
                        left_collumn: false,
                        colClass: '8',
                        middle_module_info_carousel: '',
                        module_right_info_fanpage: '',
                        module_right_youtube_hanh_cac_thanh: '',
                        module_right_lich_cong_giao: '',
                        module_right_thong_bao: '',
                        module_right_category_icon_side_bar: '',
                        column_number: 2
                    },
                }
            }
        }]
    }]
}

export default [routeEnv];