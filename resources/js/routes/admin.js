import AuthLayout from 'v@admin/layouts/auth';
import Login from 'v@admin/auth/Login';

/*default layout*/
import DefaultLayout from 'v@admin/layouts/default';

import {
    config
} from '../common/config';

export default [{
    path: '/admin',
    component: {
        render: c => c('router-view')
    },
    children: [{
        path: '',
        redirect: {
            name: 'admin.auth.login'
        }
    }, {
        path: 'login',
        component: Login,
        name: 'admin.auth.login',
        meta: {
            layout: AuthLayout,
            role: 'admin',
            show: {
                footer: true
            },
            title: 'Login | ' + config.site_name
        }
    }, {
        path: 'dashboards',
        component: () => import('v@admin/dashboards'),
        name: 'admin.dashboards',
        meta: {
            layout: DefaultLayout,
            role: 'admin',
            show: {
                footer: true
            },
            title: 'Quản trị | ' + config.site_name
        }
    }, {
        path: 'module-*',
        component: () => import('v@admin/modules'),
        name: 'admin.module.list',
        meta: {
            layout: DefaultLayout,
            auth: true,
            breadcrumbs: [{
                name: 'Quản trị',
                linkName: 'admin.dashboards',
                linkPath: '/dashboards'
            }, {
                name: 'Phần mở rộng'
            }],
            header: 'Phần mở rộng',
            role: 'admin',
            title: 'Danh mục tin | ' + config.site_name,
            show: {
                footer: true
            }
        }
    }, {
        path: 'news-categories',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () => import('v@admin/categorys'),
            name: 'admin.category.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Danh mục tin'
                }],
                header: 'Danh sách danh mục tin',
                role: 'admin',
                title: 'Danh mục tin | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }, {
            path: 'add',
            component: () => import('v@admin/categorys/add'),
            name: 'admin.category.add',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Danh mục tin',
                    linkName: 'admin.category.list',
                    linkPath: '/news-categories'
                }, {
                    name: 'Thêm danh mục'
                }],
                header: 'Thêm danh mục tin tức',
                role: 'admin',
                title: 'Thêm danh mục | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }, {
            path: 'edit/:categoryId',
            component: () => import('v@admin/categorys/edit'),
            name: 'admin.category.edit',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards.list',
                    linkPath: '/dashboards'
                }, {
                    name: 'Danh mục tin',
                    linkName: 'admin.category',
                    linkPath: '/news-categories'
                }, {
                    name: 'Cập nhật danh mục'
                }],
                header: 'CategoryEdit',
                role: 'admin',
                title: 'Edit category | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }]
    }, {
        path: 'users',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () => import('v@admin/users'),
            name: 'admin.users.list',
            meta: {
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Người dùng'
                }],
                header: 'Danh sách người dùng',
                layout: DefaultLayout,
                role: 'admin',
                title: 'Users | ' + config.site_name
            }
        }]
    }, {
        path: 'informations',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () => import('v@admin/informations'),
            name: 'admin.informations.list',
            meta: {
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Tin Tức'
                }],
                header: 'Danh sách tin tức',
                layout: DefaultLayout,
                role: 'admin',
                title: 'Tin tức | ' + config.site_name
            }
        }, {
            path: 'add',
            component: () => import('v@admin/informations/add'),
            name: 'admin.informations.add',
            meta: {
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Tin Tức',
                    linkName: 'admin.informations.list',
                    linkPath: '/informations'
                }, {
                    name: 'Thêm tin tức'
                }],
                header: 'Thêm tin tức',
                layout: DefaultLayout,
                role: 'admin',
                title: 'Thêm tin tức | ' + config.site_name
            }
        }, {
            path: 'edit/:infoId',
            component: () => import('v@admin/informations/edit'),
            name: 'admin.informations.edit',
            meta: {
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Tin Tức',
                    linkName: 'admin.informations.list',
                    linkPath: '/informations'
                }, {
                    name: 'Cập nhật tin tức'
                }],
                header: 'Cập nhật tin tức',
                layout: DefaultLayout,
                role: 'admin',
                title: 'Cập nhật tin tức | ' + config.site_name
            }
        }]
    }, {
        path: 'filemanagers',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () => import('v@admin/filemanagers'),
            name: 'admin.filemanagers.list',
            meta: {
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Hình ảnh tin tức'
                }],
                header: 'Danh sách hình ảnh',
                layout: DefaultLayout,
                role: 'admin',
                title: 'Danh sách hình ảnh | ' + config.site_name
            }
        }]
    }]
}];
