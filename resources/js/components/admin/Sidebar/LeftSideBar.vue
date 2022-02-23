<template>
  <nav v-if="user" id="column-left" class="active" :style="navStyle">
    <div id="profile">
      <div>
        <i class="fa fa-user"></i>
      </div>
      <div>
        <h4>Logo</h4>
        <small>{{user.name}}</small>
        <small>{{userPhone}}</small>
      </div>
    </div>
    <template>
      <ul style="list-style: none;
    padding: 10px;">
        <li id="dashboard">
          <a :href="_getHref('dashboards')">
            <i class="fa fa-dashboard fa-fw"></i>
            <span>{{ $options.setting.dashboards_title }}</span></a
          >
        </li>
      </ul>
      <ul id="menu" :style="ulMenu">
        <li id="giao-phan">
          <a class="parent">
            <i class="fa fa-home fa-fw"></i>
            <span>{{ $options.setting.giaophans_title }}</span></a
          >
          <ul class="collapse" :class="_getCollapseIn([
            'giao-phans', 'giao-hats', 'giao-xus', 'giao-diems', 'co-so-giao-phans', 'cong-doan-tu-sis', 'dongs'
          ])">
            <li>
              <a :href="_getHref('giao-phans')">
                <span>{{ $options.setting.giaophans_title }}</span></a
              >
            </li>
            <li>
              <a :href="_getHref('giao-hats')">
                <span>{{ $options.setting.giaohats_title }}</span></a
              >
            </li>
            <li>
              <a :href="_getHref('giao-xus')">
                <span>{{ $options.setting.giaoxus_title }}</span></a
              >
            </li>
            <li>
              <a :href="_getHref('giao-diems')">
                <span>{{ $options.setting.giaodiems_title }}</span></a
              >
            </li>
            <li>
              <a :href="_getHref('co-so-giao-phans')">
                <span>{{ $options.setting.co_so_giao_phans_title }}</span></a
              >
            </li>
            <li>
              <a :href="_getHref('cong-doan-tu-sis')">
                <span>{{ $options.setting.cong_doan_tu_sis_title }}</span></a
              >
            </li>
            <li>
              <a :href="_getHref('dongs')">
                <span>{{ $options.setting.dongs_title }}</span></a
              >
            </li>
          </ul>
        </li>
        <!-- Giáo phận tin tức -->
        <li id="giao-phan-tin-tuc">
          <a class="parent">
            <i class="fa fa-newspaper-o fa-fw"></i>
            <span>{{ $options.setting.giaophan_tintucs_title }}</span></a
          >
          <ul class="collapse" :class="_getCollapseIn([
            'giao-phan/danh-mucs', 'giao-phan/tin-tucs'
          ])">
            <li>
              <a :href="_getHref('giao-phan/danh-mucs')">
                <span>{{ $options.setting.category_sub_cate_info_title }}</span></a
              >
            </li>
            <li>
              <a :href="_getHref('giao-phan/tin-tucs')">
                <span>{{ $options.setting.category_sub_info_title }}</span></a
              >
            </li>
          </ul>
        </li>
        <li id="linh-muc">
          <a class="parent">
            <i class="fa fa-user fa-fw"></i>
            <span>{{ $options.setting.linhmucs_title }}</span></a
          >
          <ul class="collapse" :class="_getCollapseIn([
            'linh-mucs', 'bang-caps', 'chuc-thanhs', 'van-thus', 'thuyen-chuyens', 'chuc-vus', 'le-chinhs', 'thanhs'
          ])">
            <li>
              <a :href="_getHref('linh-mucs')">
                <span>{{ $options.setting.linhmucs_title }}</span></a
              >
            </li>
            <li>
              <a :href="_getHref('bang-caps')">
                <span>{{ $options.setting.linhmuc_bangcaps_title }}</span></a
              >
            </li>
            <li>
              <a :href="_getHref('chuc-thanhs')">
                <span>{{ $options.setting.linhmuc_chucthanhs_title }}</span></a
              >
            </li>
            <li>
              <a :href="_getHref('van-thus')">
                <span>{{ $options.setting.linhmuc_vanthus_title }}</span></a
              >
            </li>
            <!-- <li>
              <a :href="_getHref('thuyen-chuyens')">
                <span>{{ $options.setting.linhmuc_thuyenchuyens_title }}</span></a
              >
            </li> -->
            <li>
              <a :href="_getHref('chuc-vus')">
                <span>{{ $options.setting.chuc_vus_title }}</span></a
              >
            </li>
            <li>
              <a :href="_getHref('le-chinhs')">
                <span>{{ $options.setting.le_chinhs_title }}</span></a
              >
            </li>
            <li>
            <a :href="_getHref('ngay-les')">
              <span>{{ $options.setting.ngay_les_title }}</span></a
            >
          </li>
            <li>
              <a :href="_getHref('thanhs')">
                <span>{{ $options.setting.thanhs_title }}</span></a
              >
            </li>
          </ul>
        </li>
        <li id="user">
          <a class="parent">
            <i class="fa fa-user fa-fw"></i>
            <span>{{ $options.setting.users_title }}</span></a
          >
          <ul class="collapse" :class="_getCollapseIn([
            'users'
          ])">
            <li>
              <a :href="_getHref('users')">
                <span>{{ $options.setting.users_title }}</span></a
              >
            </li>
          </ul>
        </li>
        <li id="catalog">
          <a class="parent">
            <i class="fa fa-tags fa-fw"></i>
            <span>{{ $options.setting.category_root_title }}</span></a
          >
          <ul class="collapse" :class="_getCollapseIn([
            'news-categories', 'informations', 'slide-info-specials'
          ])">
            <li>
              <a :href="_getHref('news-categories')">{{
                $options.setting.category_sub_cate_info_title
              }}</a>
            </li>
            <li>
              <a :href="_getHref('informations')">{{
                $options.setting.category_sub_info_title
              }}</a>
            </li>
            <li>
              <a :href="_getHref('slide-info-specials')">{{
                $options.setting.slide_info_special_title
              }}</a>
            </li>
          </ul>
        </li>
        <li id="album">
          <a class="parent">
            <i class="fa fa-tags fa-fw"></i>
            <span>{{ $options.setting.album_root_title }}</span></a
          >
          <ul class="collapse" :class="_getCollapseIn(['group-albums', 'albums'])">
            <li>
              <a :href="_getHref('group-albums')">{{
                $options.setting.group_albums_title
              }}</a>
            </li>
            <li>
              <a :href="_getHref('albums')">{{
                $options.setting.albums_title
              }}</a>
            </li>
          </ul>
        </li>
        <li id="files" >
          <a class="parent" :href="_getHref('filemanagers')"><i class="fa fa-file fw"></i><span>{{
            $options.setting.category_sub_image_title
          }}</span></a>
          <ul class="collapse">
          </ul>
        </li>
        <li id="module">
          <a class="parent">
            <i class="fa fa-puzzle-piece fw"></i>
            <span>{{ $options.setting.module_title }}</span></a
          >
          <ul class="collapse" :class="_getCollapseIn([
            'module-loi-chuas', 'module-category-left-side-bars', 'module-home-banners',
            'module-category-icon-side-bars', 'module-thong-baos', 'module-tin-giao-hoi-viet-nams',
            'module-tin-giao-hois', 'module-tin-giao-phans', 'module-van-kiens', 'module-noi-bats'
          ])">
            <li>
              <a :href="_getHref('module-loi-chuas')">{{
                $options.setting.module_loi_chua
              }}</a>
            </li>
            <li>
              <a :href="_getHref('module-category-left-side-bars')">{{
                $options.setting.module_category_left_side_bar
              }}</a>
            </li>
            <li>
              <a :href="_getHref('module-home-banners')">{{
                $options.setting.module_home_banner
              }}</a>
            </li>
            <li>
              <a :href="_getHref('module-category-icon-side-bars')">{{
                $options.setting.module_category_icon_side_bar
              }}</a>
            </li>
            <li>
              <a :href="_getHref('module-thong-baos')">{{
                $options.setting.module_thong_bao
              }}</a>
            </li>
            <li>
              <a :href="_getHref('module-tin-giao-hoi-viet-nams')">{{
                $options.setting.module_tin_giao_hoi_viet_nam
              }}</a>
            </li>
            <li>
              <a :href="_getHref('module-tin-giao-hois')">{{
                $options.setting.module_tin_giao_hoi
              }}</a>
            </li>
            <li>
              <a :href="_getHref('module-tin-giao-phans')">{{
                $options.setting.module_tin_giao_phan
              }}</a>
            </li>
            <li>
              <a :href="_getHref('module-van-kiens')">{{
                $options.setting.module_van_kien
              }}</a>
            </li>
            <li>
              <a :href="_getHref('module-noi-bats')">{{
                $options.setting.module_noi_bat
              }}</a>
            </li>
          </ul>
        </li>
        <li id="system">
          <a class="parent">
            <i class="fa fa-cog fw"></i>
            <span>{{ $options.setting.system_root_title }}</span></a
          >
          <ul class="collapse" :class="_getCollapseIn([
            'system', 'restrict-ips'
          ])">
            <li>
              <a :href="_getHref('system')">{{ $options.setting.sytem_title }}</a>
            </li>
            <li>
              <a :href="_getHref('restrict-ips')">{{ $options.setting.restrict_ips_title }}</a>
            </li>
          </ul>
        </li>
      </ul>
    </template>
    <!-- <template v-else>
      <ul style="list-style: none;
    padding: 10px;">
        <li id="dashboard">
          <a :href="_getHref('dashboards')">
            <i class="fa fa-dashboard fa-fw"></i>
            <span>{{ $options.setting.dashboards_title }}</span></a
          >
        </li>
      </ul>
      <ul v-html="_renderMenu()" id="menu" :style="ulMenu"></ul>
    </template> -->
  </nav>
</template>

<script>
import { mapState, } from 'vuex'
import { MODULE_AUTH, } from 'store@admin/types/module-types'
import { unserialize, } from 'php-serialize'

export default {
  name: 'LeftSideBar',
  data() {
    return {
      collapseIn: ''
    }
  },
  computed: {
    ...mapState(MODULE_AUTH, {
      user: (state) => state.user,
      userPhone: (state) => state.linhMucExpectSignInPhone,
    }),
    navStyle() {
      return {
        'min-height':innerHeight + 'px',
        'background-color': '#122934',
      }
    },
    ulMenu() {
      return {
        'height': '530px',
        'overflow-x': 'hidden',
        'overflow-y': 'scroll',
      }
    },
    subCollapse() {
      return this.collapseIn
    },
  },
  methods: {
    _renderMenu() {
      const self = this
      const rules = (this.user?.ruleSelect) ? unserialize(this.user.ruleSelect) : []
      let menuHtml = ''

      Object.entries(rules).forEach(function(item) {
        if (item[1]?.abilities?.list) {
          const links = self._getRuleHref(item[0])
          menuHtml += '<li><a href=\'' + links.href + '\'>'
          menuHtml += '<span>' + links.name + '</span></a></li>'
        }
      })

      return menuHtml
    },
    _getHref(path) {
      return this.$helper.fn_admin_base_url() + '/' + path
    },
    _getRuleHref(ruleKey) {
      const links = this.$options.setting.permisstionGroupTexts[ruleKey]

      return {
        href: this.$helper.fn_admin_base_url() + '/' + links.path, 
        name: links.name, 
      }
    },
    _getCollapseIn(groupPath) {
      let regex = this.$route.path.replace(`/${this.$cmsCfg.adminPrefix}/`, '').split('/')
      return groupPath.includes(regex[0]) ? ' in': ''
    },
  },
  setting: {
    permisstionGroupTexts: {
      setting: { name: 'Cài đặt', path: 'system', },
      thanh: { name: 'Thánh', path: 'thanhs', },
      news_group: { name: 'Tin tức Danh mục', path: 'news-categories', },
      linh_muc_van_thu: { name: 'Văn thư', path: 'van-thus', },
      linh_muc_thuyen_chuyen: { name: 'Thuyên chuyển', path: 'thuyen-chuyens', },
      linh_muc_bang_cap: { name: 'Bằng cấp', path: 'bang-caps', },
      linh_muc_chuc_thanh: { name: 'Chức thánh', path: 'chuc-thanhs', },
      linh_muc: { name: 'Linh mục', path: 'linh-mucs', },
      le_chinh: { name: 'Lễ chính', path: 'le-chinhs', },
      chuc_vu: { name: 'Chức vụ', path: 'chuc-vus', },
      giao_phan: { name: 'Giáo phận', path: 'giao-phans', },
      giao_phan_news_group: { name: 'Giáo phận Danh mục', path: 'giao-phan/danh-mucs', },
      giao_phan_news: { name: 'Giáo phận Tin tức', path: 'giao-phan/tin-tucs', },
      giao_hat: { name: 'Giáo hạt', path: 'giao-hats', },
      giao_xu: { name: 'Giáo xứ', path: 'giao-xus', },
      giao_diem: { name: 'Giáo điểm', path: 'giao-diems', },
      giao_phan_co_so: { name: 'Cơ sở', path: 'co-so-giao-phans', },
      cong_doan_tu_si: { name: 'Công đoàn tu sĩ', path: 'cong-doan-tu-sis', },
      dong: { name: 'Dòng', path: 'dongs', },
      tin_tuc: { name: 'Tin tức', path: 'informations', },
      slide_info_specials: { name: 'Slide tiêu điểm', path: 'slide-info-specials', },
      album_group: { name: 'Danh mục Album', path: 'group-albums', },
      album: { name: 'Album', path: 'albums', },
    },
    dashboards_title: 'Quản trị',
    users_title: 'Người dùng',
    category_root_title: 'Tin Tức',
    category_sub_cate_info_title: 'Danh mục',
    category_sub_info_title: 'Tin tức',
    category_sub_image_title: 'Hình ảnh',
    module_title: 'Mở rộng',
    module_category_left_side_bar: 'Danh mục trái',
    module_category_icon_side_bar: 'Danh mục Icon',
    module_home_banner: 'Banner trang chủ',
    module_thong_bao: 'Danh mục thông báo',
    module_loi_chua: 'Danh mục Lời Chúa',
    module_tin_giao_hoi_viet_nam: 'Tin giáo hội việt nam',
    module_tin_giao_hoi: 'Tin giáo hội',
    module_tin_giao_phan: 'Tin giáo phận',
    module_van_kien: 'Văn kiện',
    module_noi_bat: 'Nổi bật',
    system_root_title: 'Hệ thống',
    sytem_title: 'Cài đặt',
    linhmucs_title: 'Linh mục',
    linhmuc_bangcaps_title: 'Bằng cấp',
    linhmuc_chucthanhs_title: 'Chức thánh',
    linhmuc_vanthus_title: 'Văn thư',
    linhmuc_thuyenchuyens_title: 'Thuyên chuyển',
    slide_info_special_title: 'Slide tiêu điểm',
    giaophans_title: 'Giáo phận',
    giaohats_title: 'Giáo hạt',
    giaoxus_title: 'Giáo xứ',
    giaodiems_title: 'Giáo điểm',
    co_so_giao_phans_title: 'Cơ sở giáo phận',
    cong_doan_tu_sis_title: 'Công đoàn tu sĩ',
    dongs_title: 'Dòng',
    thanhs_title: 'Thánh',
    chuc_vus_title: 'Chức vụ',
    le_chinhs_title: 'Lễ chính',
    ngay_les_title: "Ngày lễ",
    giaophan_tintucs_title: 'Giáo phận tin tức',
    restrict_ips_title: 'Restrict ip',
    album_root_title: 'Album hình ảnh',
    group_albums_title: 'Nhóm Album',
    albums_title: 'Album',
  },
}
</script>

<style lang="scss">
  .panel-body {
    .admin-cusstom-paging {
      padding-top: 15px;
      border-top: 1px solid #bcbabaab;
    }
  }
  .table-responsive {
    max-height: 450px;
  }
  /* custom scrollbar */
  ::-webkit-scrollbar {
    width: 15px;
  }

  ::-webkit-scrollbar-track {
    background-color: transparent;
  }

  ::-webkit-scrollbar-thumb {
    background-color: #d7dddf;
    border-radius: 20px;
    border: 6px solid transparent;
    background-clip: content-box;
  }

  ::-webkit-scrollbar-thumb:hover {
    background-color: #595a5a;
  }

  li.active.open {
    background-color: red !important;
  }
</style>
