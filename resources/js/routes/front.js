import MainLayout from 'v@front/layouts/main'

const network = ['facebook', 'twitter', 'linkedin', 'whatsapp']
let routeEnv = {}

routeEnv = {
  path: '',
  component: {
    render: c => c('router-view'),
  },
  children: [{
    path: '/',
    component: {
      render: c => c('router-view'),
    },
    children: [{
      path: '',
      component: () => import('v@front/page_news'),
      name: 'home-page',
      meta: {
        auth: false,
        header: 'Trang chủ',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
      },
    }, {
      path: 'trang-chu',
      component: () => import('v@front/page_news'),
      name: 'home-page1',
      meta: {
        auth: false,
        header: 'Trang chủ',
        layout: MainLayout,
        role: 'guest',
        layout_content: {
        },
      },
    }],
  }, {
    path: 'danh-muc-tin',
    component: {
      render: c => c('router-view'),
    },
    children: [{
      path: '',
      component: () => import('v@front/page_category_news'),
      name: 'news-category-all-page',
      meta: {
        auth: false,
        header: 'News Page',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
        network: network,
      },
    }],
  }, {
    path: 'danh-muc-tin/:slug',
    component: {
      render: c => c('router-view'),
    },
    children: [{
      path: '',
      component: () => import('v@front/page_category_news'),
      name: 'news-category-page',
      meta: {
        auth: false,
        header: 'News Page',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
        network: network,
      },
    }],
  }, {
    path: 'danh-muc-tin/:slug_1/:slug',
    component: {
      render: c => c('router-view'),
    },
    children: [{
      path: '',
      component: () => import('v@front/page_category_news'),
      name: 'news-category_1-page',
      meta: {
        auth: false,
        header: 'News Page',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
        network: network,
      },
    }],
  }, {
    path: 'danh-muc-tin/:slug_2/:slug_1/:slug',
    component: {
      render: c => c('router-view'),
    },
    children: [{
      path: '',
      component: () => import('v@front/page_category_news'),
      name: 'news-category_2-page',
      meta: {
        auth: false,
        header: 'News Page',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
        network: network,
      },
    }],
  }, {
    path: 'danh-muc-tin/:slug_3/:slug_2/:slug_1/:slug',
    component: {
      render: c => c('router-view'),
    },
    children: [{
      path: '',
      component: () => import('v@front/page_category_news'),
      name: 'news-category_3-page',
      meta: {
        auth: false,
        header: 'News Page',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
        network: network,
      },
    }],
  }, {
    path: 'tin-tuc',
    component: {
      render: c => c('router-view'),
    },
    children: [{
      path: 'xem-nhieu',
      component: () => import('v@front/page_news_populars'),
      name: 'news-popular-page',
      meta: {
        auth: false,
        header: 'Trang Tin Tức Xem Nhiều',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
      },
    }, {
      path: 'chi-tiet/:slug',
      component: () =>
        import('v@front/page_news_details'),
      name: 'news-slug-detail-page',
      meta: {
        auth: false,
        header: 'Trang Chi Tiết Tin Tức',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
      },
    }, {
      path: 'tags/:slug',
      component: () => import('v@front/page_news_tags'),
      name: 'news-tag-page',
      meta: {
        auth: false,
        header: 'News Page',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
        network: network,
      },
    }],
  }, {
    path: 'video',
    component: {
      render: c => c('router-view'),
    },
    children: [{
      path: '',
      component: () => import('v@front/page_videos'),
      name: 'video-page',
      meta: {
        auth: false,
        header: 'Trang Video',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
      },
    }, {
      path: 'chi-tiet/:slug',
      component: () => import('v@front/page_video_details'),
      name: 'video-detail-page',
      meta: {
        auth: false,
        header: 'Trang Chi Tiết Video',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
      },
    }],
  }, {
    path: 'linh-muc',
    component: {
      render: c => c('router-view'),
    },
    children: [{
      path: '',
      component: () => import('v@front/page_linh_mucs'),
      name: 'linh-muc-page',
      meta: {
        auth: false,
        header: 'Trang Linh Mục',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
      },
    }, {
      path: 'chi-tiet/:linhMucId',
      component: () => import('v@front/page_linh_muc_details'),
      name: 'linh-muc-detail-page',
      meta: {
        auth: false,
        header: 'Trang Chi Tiết Linh Mục',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
      },
    }],
  }, {
    path: 'hanh-cac-thanh',
    component: {
      render: c => c('router-view'),
    },
    children: [{
      path: '',
      component: () => import('v@front/page_hanh_cac_thanh'),
      name: 'hanh-cac-thanh-page',
      meta: {
        auth: false,
        header: 'Trang Hành Các Thánh',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
      },
    },{
      path: 'chi-tiet/:slug',
      component: () => import('v@front/page_hanh_details'),
      name: 'hanh-cac-thanh-detail-page',
      meta: {
        auth: false,
        header: 'Trang Chi Tiết Hành Các Thánh',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
      },
    }],
  },

  {
    path: 'giao-xu',
    component: {
      render: c => c('router-view'),
    },
    children: [{
      path: '',
      component: () => import('v@front/page_giao_xus'),
      name: 'giao-xu-page',
      meta: {
        auth: false,
        header: 'Trang Giáo Xứ',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
      },
    }, {
      path: 'chi-tiet/:giaoXuId',
      component: () => import('v@front/page_giao_xu_details'),
      name: 'giao-xu-detail-page',
      meta: {
        auth: false,
        header: 'Trang Chi Tiết Giáo Xứ',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
      },
    }],
  },{
    path: 'danh-sach-linh-muc',
    component: {
      render: c => c('router-view'),
    },
    children: [{
      path: '',
      component: () => import('v@front/page_danh_sach_linh_mucs'),
      name: 'danh-sach-linh-muc-page',
      meta: {
        auth: false,
        header: 'Trang danh sách linh mục',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
      },
    }, {
      path: 'chi-tiet/:linhMucId',
      component: () => import('v@front/page_linh_muc_chi_tiet'),
      name: 'linh-muc-chi-tiet-page',
      meta: {
        auth: false,
        header: 'Trang Chi Tiết Sửa Linh Mục',
        layout: MainLayout,
        role: 'guest',
        layout_content: {},
      },
      }, {
        path: 'hoat-dong-su-vu/:linhMucId',
        component: () => import('v@front/page_hoat_dong_su_vu'),
        name: 'hoat-dong-su-vu-page',
        meta: {
          auth: false,
          header: 'Trang Hoạt Động Sứ Vụ',
          layout: MainLayout,
          role: 'guest',
          layout_content: {},
        },
      }],
  }],
}

export default [routeEnv]