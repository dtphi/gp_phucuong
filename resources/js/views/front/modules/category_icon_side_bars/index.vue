<template>
  <div v-if="_isExist" id="category-icon-side-bar-module" class="category">
    <h4 class="tit-common clr-blue">{{ $options.setting.module_title }}</h4>
    <b-row>
      <category-item
        v-for="(item, idx) in _settingCategory"
        :key="idx"
        :idx="idx"
        :group="item"
      ></category-item>
    </b-row>
  </div>
</template>

<script>
import { mapState, } from 'vuex'
import CategoryItem from './components/CategoryItem'

export default {
  name: 'ModuleCategoryIconSideBar',
  components: {
    CategoryItem,
  },
  data() {
    return {}
  },
  computed: {
    ...mapState({
      settingCategorys: state => state.cfApp.setting.modules.module_category_icon_side_bar,
    }),
    _isExist() {
      const moduleName = 'module_category_icon_side_bar_categories'
      const isModule = (String(this.settingCategorys[moduleName]) !== 'undefined')
      if (isModule) {
        return this.settingCategorys.module_category_icon_side_bar_categories.length
      }
      
      return 0
    },
    _settingCategory() {
      return this.settingCategorys.module_category_icon_side_bar_categories
    },
  },
  setting: {
    module_title: 'Danh Mục',
  },
}
</script>

<style lang="scss">
@import "./styles.scss";
</style>
