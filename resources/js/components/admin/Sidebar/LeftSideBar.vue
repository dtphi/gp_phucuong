<template>
  <nav id="column-left" class="active" style="min-height: 400px">
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
    <ul id="menu">
      <li id="dashboard">
        <a :href="_getHref('dashboards')">
          <i class="fa fa-dashboard fa-fw"></i>
          <span>{{ $options.setting.dashboards_title }}</span></a
        >
      </li>
      <li id="giao-phan">
        <a class="parent">
          <i class="fa fa-home fa-fw"></i>
          <span>{{ $options.setting.giaophans_title }}</span></a
        >
        <ul class="collapse">
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
        <ul class="collapse">
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
        <ul class="collapse">
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
          <li>
            <a :href="_getHref('thuyen-chuyens')">
              <span>{{ $options.setting.linhmuc_thuyenchuyens_title }}</span></a
            >
          </li>
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
        <ul class="collapse">
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
        <ul class="collapse">
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
      <li id="files" v-if="user.isAdmin">
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
        <ul class="collapse">
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
        <ul class="collapse">
          <li>
            <a :href="_getHref('system')">{{ $options.setting.sytem_title }}</a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
</template>

<script>
import { mapState } from "vuex";
import { MODULE_AUTH } from "store@admin/types/module-types";
import { fn_get_admin_base_url } from "@app/api/utils/fn-helper";

export default {
  name: "LeftSideBar",
  computed: {
    ...mapState(MODULE_AUTH, {
        user: (state) => state.user,
        userPhone: (state) => state.linhMucExpectSignInPhone
    })
  },
  methods: {
    _getHref(path) {
      return fn_get_admin_base_url() + "/" + path;
    },
  },
  setting: {
    dashboards_title: "Quản trị",
    users_title: "Người dùng",
    category_root_title: "Tin Tức",
    category_sub_cate_info_title: "Danh mục",
    category_sub_info_title: "Tin tức",
    category_sub_image_title: "Hình ảnh",
    module_title: "Mở rộng",
    module_category_left_side_bar: "Danh mục trái",
    module_category_icon_side_bar: "Danh mục Icon",
    module_home_banner: "Banner trang chủ",
    module_thong_bao: "Danh mục thông báo",
    module_loi_chua: "Danh mục Lời Chúa",
    module_tin_giao_hoi_viet_nam: "Tin giáo hội việt nam",
    module_tin_giao_hoi: "Tin giáo hội",
    module_tin_giao_phan: "Tin giáo phận",
    module_van_kien: "Văn kiện",
    module_noi_bat: "Nổi bật",
    system_root_title: "Hệ thống",
    sytem_title: "Cài đặt",
    linhmucs_title: "Linh mục",
    linhmuc_bangcaps_title: "Bằng cấp",
    linhmuc_chucthanhs_title: "Chức thánh",
    linhmuc_vanthus_title: "Văn thư",
    linhmuc_thuyenchuyens_title: "Thuyên chuyển",
    slide_info_special_title: "Slide tiêu điểm",
    giaophans_title: "Giáo phận",
    giaohats_title: "Giáo hạt",
    giaoxus_title: "Giáo xứ",
    giaodiems_title: "Giáo điểm",
    co_so_giao_phans_title: "Cơ sở giáo phận",
    cong_doan_tu_sis_title: "Công đoàn tu sĩ",
    dongs_title: "Dòng",
    thanhs_title: "Thánh",
    chuc_vus_title: "Chức vụ",
    le_chinhs_title: "Lễ chính",
    giaophan_tintucs_title: "Giáo phận tin tức"
  },
};
</script>
