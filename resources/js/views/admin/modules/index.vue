<template>
  <div id="content">
    <div class="container-fluid">
      <keep-alive>
        <component v-bind:is="currentModule"></component>
      </keep-alive>
    </div>
  </div>
</template>

<script>
import category_icon_side_bars from './category_icon_side_bars'
import category_left_side_bars from './category_left_side_bars'
import home_banners from './home_banners'
import loi_chuas from './loi_chuas'
import thong_baos from './thong_baos'
import tin_giao_hoi_viet_nams from './tin_giao_hoi_viet_nams'
import tin_giao_hois from './tin_giao_hois'
import tin_giao_phans from './tin_giao_phans'
import van_kiens from './van_kiens'
import noi_bats from './noi_bats'

export default {
  name: 'ExtensionModuler',
  components: {
    'module-category-icon-side-bars': category_icon_side_bars,
    'module-category-left-side-bars': category_left_side_bars,
    'module-home-banners': home_banners,
    'module-loi-chuas': loi_chuas,
    'module-thong-baos': thong_baos,
    'module-tin-giao-hoi-viet-nams': tin_giao_hoi_viet_nams,
    'module-tin-giao-hois': tin_giao_hois,
    'module-tin-giao-phans': tin_giao_phans,
    'module-van-kiens': van_kiens,
    'module-noi-bats': noi_bats,
  },
  computed: {
    currentModule: app => {
      let moduleName = app.$route.params.pathMatch
      
      return 'module-' + moduleName.toLowerCase()
    },
  },
}
</script>
