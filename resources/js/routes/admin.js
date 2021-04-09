import AuthLayout from 'v@admin/layouts/auth';
import Login from 'v@admin/auth/Login';
import Users from 'v@admin/users';
import FileManager from 'v@admin/filemanagers';

/*default layout*/
import DefaultLayout from 'v@admin/layouts/default';
import CategoryListPage from 'v@admin/categorys';
import CategoryEditPage from 'v@admin/categorys/edit';
import CategoryAddPage from 'v@admin/categorys/add';
import InformationListPage from 'v@admin/informations';
import InformationAddPage from 'v@admin/informations/add';
import InformationEditPage from 'v@admin/informations/edit';
import DashboardPage from 'v@admin/dashboards';

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
        component: DashboardPage,
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
        path: 'news-categories',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: CategoryListPage,
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
            component: CategoryAddPage,
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
            component: CategoryEditPage,
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
                title: 'Users | ' + config.site_name,
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
            component: Users,
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
            component: InformationListPage,
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
            component: InformationAddPage,
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
            component: InformationEditPage,
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
            component: FileManager,
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
