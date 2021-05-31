import MainLayout from 'v@front/layouts/main';

import {
    config
} from '../common/config';

const debug = process.env.NODE_ENV === 'debuger';

const ModuleContent = {
    module_left_info_left_side_bar: 'info-left-side-bar',
    module_left_category_left_side_bar: 'category-left-side-bar',
    module_left_newsletter_register:'newsletter-register',
    module_left_summary_contact: 'summary-contact',

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
}

const ModuleContentCategory = {
    content_top: true,
    content_top_column: {
        right_collumn: false,
        middle_column: true,
        left_collumn: true,
        colClass: '',
        left_modules: [
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
        right_modules: [],
        column_number: 2
    },
    content_bottom: false,
    content_bottom_column: {
        right_collumn: false,
        middle_column: false,
        left_collumn: false,
        colClass: '',
        left_modules: [],
        middle_modules: [],
        right_modules: [],
        column_number: 2
    },
    content_main: false,
    content_main_column: {
        right_collumn: false,
        middle_column: false,
        left_collumn: false,
        colClass: '',
        left_modules: [],
        middle_modules: [],
        right_modules: [],
        column_number: 2
    },
    right_collumn: false,
    middle_column: true,
    left_collumn: true,
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
                layout_content: ModuleContentCategory
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
                layout_content: ModuleContentCategory
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
                layout_content: ModuleContentCategory
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
                layout_content: ModuleContentCategory
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
                layout_content: ModuleContentCategory
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
                        left_modules: [],
                        middle_modules: [
                            {
                                moduleName: ModuleContent.middle_module_info_carousel,
                                sortOrder: 0
                            },
                            {
                                moduleName: ModuleContent.middle_module_special_banner,
                                sortOrder: 0
                            },
                        ],
                        right_modules: [],
                        column_number: 2
                    },
                    content_bottom: true,
                    content_bottom_column: {
                        right_collumn: true,
                        middle_column: true,
                        left_collumn: false,
                        left_modules: [],
                        middle_modules: [
                            {
                                moduleName: ModuleContent.module_middle_loi_chua,
                                sortOrder: 0
                            },
                            {
                                moduleName: ModuleContent.module_middle_tin_giao_hoi,
                                sortOrder: 0
                            },
                            {
                                moduleName: ModuleContent.module_middle_tin_giao_phan,
                                sortOrder: 0
                            },
                            {
                                moduleName: ModuleContent.module_middle_van_kien,
                                sortOrder: 0
                            }
                        ],
                        right_modules: [
                            {
                                moduleName: ModuleContent.module_right_category_icon_side_bar,
                                sortOrder: 0
                            },
                            {
                                moduleName: ModuleContent.module_right_thong_bao,
                                sortOrder: 0
                            },
                            {
                                moduleName: ModuleContent.module_right_lich_cong_giao,
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
                        column_number: 2,
                        colClass: '8'
                    },
                    content_main: false,
                    content_main_column: {
                        right_collumn: false,
                        middle_column: true,
                        left_collumn: false,
                        colClass: '',
                        left_modules: [],
                        middle_modules: [],
                        right_modules: [],
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
                        left_modules: [
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
                        right_modules: [],
                        column_number: 2
                    },
                    content_bottom: false,
                    content_bottom_column: {
                        right_collumn: false,
                        middle_column: false,
                        left_collumn: false,
                        colClass: '',
                        left_modules: [],
                        middle_modules: [],
                        right_modules: [],
                        column_number: 2
                    },
                    content_main: false,
                    content_main_column: {
                        right_collumn: false,
                        middle_column: false,
                        left_collumn: false,
                        colClass: '',
                        left_modules: [],
                        middle_modules: [],
                        right_modules: [],
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
                        left_modules: [],
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
                                moduleName: ModuleContent.module_right_info_fanpage,
                                sortOrder: 0
                            },
                            {
                                moduleName: ModuleContent.module_right_youtube_hanh_cac_thanh,
                                sortOrder: 0
                            }
                        ],
                        column_number: 2
                    },
                    content_bottom: false,
                    content_bottom_column: {
                        right_collumn: false,
                        middle_column: false,
                        left_collumn: false,
                        colClass: '',
                        left_modules: [],
                        middle_modules: [],
                        right_modules: [],
                        column_number: 2
                    },
                    content_main: true,
                    content_main_column: {
                        right_collumn: true,
                        middle_column: true,
                        left_collumn: false,
                        colClass: '8',
                        left_modules: [],
                        middle_modules: [],
                        right_modules: [],
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
                title: 'Trang Video | ' + config.site_name,
                layout_content: {
                    content_top: true,
                    content_top_column: {
                        right_collumn: false,
                        middle_column: true,
                        left_collumn: true,
                        colClass: '',
                        left_modules: [
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
                        right_modules: [],
                        column_number: 2
                    },
                    content_bottom: false,
                    content_bottom_column: {
                        right_collumn: false,
                        middle_column: false,
                        left_collumn: false,
                        colClass: '',
                        left_modules: [],
                        middle_modules: [],
                        right_modules: [],
                        column_number: 2
                    },
                    content_main: false,
                    content_main_column: {
                        right_collumn: false,
                        middle_column: false,
                        left_collumn: false,
                        colClass: '',
                        left_modules: [],
                        middle_modules: [],
                        right_modules: [],
                        column_number: 2
                    },
                }
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
                        left_modules: [],
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
                                moduleName: ModuleContent.module_right_info_fanpage,
                                sortOrder: 0
                            },
                            {
                                moduleName: ModuleContent.module_right_youtube_hanh_cac_thanh,
                                sortOrder: 0
                            }
                        ],
                        column_number: 2
                    },
                    content_bottom: false,
                    content_bottom_column: {
                        right_collumn: false,
                        middle_column: false,
                        left_collumn: false,
                        colClass: '',
                        left_modules: [],
                        middle_modules: [],
                        right_modules: [],
                        column_number: 2
                    },
                    content_main: true,
                    content_main_column: {
                        right_collumn: true,
                        middle_column: true,
                        left_collumn: false,
                        colClass: '8',
                        left_modules: [],
                        middle_modules: [],
                        right_modules: [],
                        column_number: 2
                    },
                }
            }
        }]
    }]
}

export default [routeEnv];