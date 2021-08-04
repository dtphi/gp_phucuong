import AuthLayout from 'v@admin/layouts/auth';
import Login from 'v@admin/auth/Login';

/*default layout*/
import DefaultLayout from 'v@admin/layouts/default';
import LinhMucPage from 'v@admin/linhmucs';
import LinhMucBangCapPage from 'v@admin/linhmucbangcaps';
import LinhMucChucThanhPage from 'v@admin/linhmucchucthanhs';
import LinhMucVanThuPage from 'v@admin/linhmucvanthus';
import LinhMucThuyenChuyenPage from 'v@admin/linhmucthuyenchuyens';
import GiaoPhanPage from 'v@admin/giaophans';
import GiaoHatPage from 'v@admin/giaohats';
import GiaoXuPage from 'v@admin/giaoxus';
import GiaoDiemPage from 'v@admin/giaodiems';
import CoSoGiaoPhanPage from 'v@admin/cosogiaophans';
import CongDoanTuSiPage from 'v@admin/congdoantusis';
import DongPage from 'v@admin/dongs';
import ThanhPage from 'v@admin/thanhs';
import ChucVuPage from 'v@admin/chucvus';
import LeChinhPage from 'v@admin/lechinhs';
import SystemPage from 'v@admin/systems';
import DashboardPage from 'v@admin/dashboards';
import CategoryListPage from 'v@admin/categorys';
import UserListPage from 'v@admin/users';
import InformationListPage from 'v@admin/informations';
import FileManagerListPage from 'v@admin/filemanagers';

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
        path: 'module-*',
        component: () =>
            import ('v@admin/modules'),
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
            component: () =>
                import ('v@admin/categorys/add'),
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
            component: () =>
                import ('v@admin/categorys/edit'),
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
            component: UserListPage,
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
            component: () =>
                import ('v@admin/informations/add'),
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
            component: () =>
                import ('v@admin/informations/edit'),
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
        path: 'slide-info-specials',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: () =>
                import ('v@admin/slideinfospecials'),
            name: 'admin.slide-info-specials.list',
            meta: {
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Slide Tin Tức'
                }],
                header: 'Danh sách slide tin tức',
                layout: DefaultLayout,
                role: 'admin',
                title: 'Slide Tin tức | ' + config.site_name
            }
        }]
    }, {
        path: 'filemanagers',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: FileManagerListPage,
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
    }, {
        path: 'system',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: SystemPage,
            name: 'admin.system.setting',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Cài đặt'
                }],
                header: 'Danh sách cài đặt',
                role: 'admin',
                title: 'Cài đặt chung | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }]
    }, {
        path: 'linh-mucs',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: LinhMucPage,
            name: 'admin.linh.muc.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Linh mục'
                }],
                header: 'Danh sách linh mục',
                role: 'admin',
                title: 'Linh mục | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        },{
            path: 'add',
            component: () => import ('v@admin/linhmucs/add'),
            name: 'admin.linh.muc.add',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Danh sách linh mục',
                    linkName: 'admin.linh.muc.list',
                    linkPath: '/linh-mucs'
                }, {
                    name: 'Thêm Linh Muc'
                }],
                header: 'Thêm linh mục',
                role: 'admin',
                title: 'Thêm linh mục | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }, {
            path: 'edit/:linhmucId',
            component: () => import ('v@admin/linhmucs/edit'),
            name: 'admin.linh.muc.edit',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Danh sách linh mục',
                    linkName: 'admin.linh.muc.list',
                    linkPath: '/linh-mucs'
                }, {
                    name: 'Sửa Linh Muc'
                }],
                header: 'Thêm linh mục',
                role: 'admin',
                title: 'Thêm linh mục | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        },]
    }, {
        path: 'bang-caps',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: LinhMucBangCapPage,
            name: 'admin.linh.muc.bang.cap.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Cài đặt'
                }],
                header: 'Danh sách bằng cấp',
                role: 'admin',
                title: 'Bằng cấp | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        },]
    }, {
        path: 'chuc-thanhs',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: LinhMucChucThanhPage,
            name: 'admin.linh.muc.chuc.thanh.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Chức thánh'
                }],
                header: 'Danh sách chức thánh',
                role: 'admin',
                title: 'Chức thánh | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        },]
    }, {
        path: 'van-thus',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: LinhMucVanThuPage,
            name: 'admin.linh.muc.van.thu.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Văn thư'
                }],
                header: 'Danh sách văn thư',
                role: 'admin',
                title: 'Văn thư | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        },]
    }, {
        path: 'thuyen-chuyens',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: LinhMucThuyenChuyenPage,
            name: 'admin.linh.muc.thuyen.chuyen.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Thuyên chuyển'
                }],
                header: 'Danh sách thuyên chuyển',
                role: 'admin',
                title: 'Thuyên chuyển | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        },]
    }, {
        path: 'giao-phans',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: GiaoPhanPage,
            name: 'admin.giao.phan.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Giáo phận'
                }],
                header: 'Danh sách giáo phận',
                role: 'admin',
                title: 'Giao phận | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }, {
            path: 'add',
            component: () => import ('v@admin/giaophans/add'),
            name: 'admin.giao.phan.add',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Danh sách giáo phận',
                    linkName: 'admin.giao.phan.list',
                    linkPath: '/giao-phans'
                }, {
                    name: 'Giáo phận'
                }],
                header: 'Thêm giáo phận',
                role: 'admin',
                title: 'Giao phận | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }, {
            path: 'edit/:giaoPhanId',
            component: () => import ('v@admin/giaophans/edit'),
            name: 'admin.giao.phan.edit',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                },{
                    name: 'Danh sách giáo phận',
                    linkName: 'admin.giao.phan.list',
                    linkPath: '/giao-phans'
                }, {
                    name: 'Giáo phận'
                }],
                header: 'Sửa giáo phận',
                role: 'admin',
                title: 'Giao phận | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }]
    }, {
        path: 'giao-hats',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: GiaoHatPage,
            name: 'admin.giao.hat.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Giáo hạt'
                }],
                header: 'Danh sách giáo hạt',
                role: 'admin',
                title: 'Giao hạt | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }, {
            path: 'add',
            component: () => import ('v@admin/giaohats/add'),
            name: 'admin.giao.hat.add',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Danh sách giáo hạt',
                    linkName: 'admin.giao.hat.list',
                    linkPath: '/giao-hats'
                }, {
                    name: 'Giáo hạt'
                }],
                header: 'Thêm giáo hạt',
                role: 'admin',
                title: 'Giao hạt | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }, {
            path: 'edit/:giaohatId',
            component: () => import ('v@admin/giaohats/edit'),
            name: 'admin.giao.hat.edit',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Danh sách giáo hạt',
                    linkName: 'admin.giao.hat.list',
                    linkPath: '/giao-hats'
                }, {
                    name: 'Giáo hạt'
                }],
                header: 'Sửa giáo hạt',
                role: 'admin',
                title: 'Giao hạt | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }]
    }, {
        path: 'giao-xus',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: GiaoXuPage,
            name: 'admin.giao.xu.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Giáo xứ'
                }],
                header: 'Danh sách giáo xứ',
                role: 'admin',
                title: 'Giao xứ | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }, {
            path: 'add',
            component: () => import ('v@admin/giaoxus/add'),
            name: 'admin.giao.xu.add',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Danh sách giáo xứ',
                    linkName: 'admin.giao.xu.list',
                    linkPath: '/giao-xus'
                }, {
                    name: 'Giáo xứ'
                }],
                header: 'Thêm giáo xứ',
                role: 'admin',
                title: 'Giao xứ | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }, {
            path: 'edit/:giaoxuId',
            component: () => import ('v@admin/giaoxus/edit'),
            name: 'admin.giao.xu.edit',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Danh sách giáo xứ',
                    linkName: 'admin.giao.xu.list',
                    linkPath: '/giao-xus'
                }, {
                    name: 'Giáo xứ'
                }],
                header: 'Sửa giáo xứ',
                role: 'admin',
                title: 'Giao xứ | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }]
    }, {
        path: 'giao-diems',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: GiaoDiemPage,
            name: 'admin.giao.diem.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Giáo điểm'
                }],
                header: 'Danh sách giáo điểm',
                role: 'admin',
                title: 'Giao điểm | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }]
    }, {
        path: 'co-so-giao-phans',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: CoSoGiaoPhanPage,
            name: 'admin.co.so.giao.phan.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Cơ sở giáo phận'
                }],
                header: 'Danh sách cơ sở giáo phận',
                role: 'admin',
                title: 'Giao điểm | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }]
    }, {
        path: 'cong-doan-tu-sis',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: CongDoanTuSiPage,
            name: 'admin.cong.doan.tu.si.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Công đoàn tu sĩ'
                }],
                header: 'Danh sách công đoàn tu sĩ',
                role: 'admin',
                title: 'Giao điểm | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }]
    }, {
        path: 'dongs',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: DongPage,
            name: 'admin.dong.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Dòng'
                }],
                header: 'Danh sách dòng',
                role: 'admin',
                title: 'Dòng | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }, {
            path: 'add',
            component: () => import ('v@admin/dongs/add'),
            name: 'admin.dong.add',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Danh sách dòng',
                    linkName: 'admin.dong.list',
                    linkPath: '/dongs'
                }, {
                    name: 'Dòng'
                }],
                header: 'Thêm dòng',
                role: 'admin',
                title: 'Dòng | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }, {
            path: 'edit/:dongId',
            component: () => import ('v@admin/dongs/edit'),
            name: 'admin.dong.edit',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Danh sách dòng',
                    linkName: 'admin.dong.list',
                    linkPath: '/dongs'
                }, {
                    name: 'Dòng'
                }],
                header: 'Sửa dòng',
                role: 'admin',
                title: 'Dòng | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }]
    }, {
        path: 'thanhs',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: ThanhPage,
            name: 'admin.thanh.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Thánh'
                }],
                header: 'Danh sách thánh',
                role: 'admin',
                title: 'Giao điểm | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        },]
    }, {
        path: 'chuc-vus',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: ChucVuPage,
            name: 'admin.chuc.vu.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Chức vụ'
                }],
                header: 'Danh sách chức vụ',
                role: 'admin',
                title: 'Chức vụ | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        },]
    }, {
        path: 'le-chinhs',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: LeChinhPage,
            name: 'admin.le.chinh.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản trị',
                    linkName: 'admin.dashboards',
                    linkPath: '/dashboards'
                }, {
                    name: 'Lễ Chính'
                }],
                header: 'Danh sách lễ chính',
                role: 'admin',
                title: 'Lễ Chính | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        },]
    },] 
}];