<template>
  <div v-if="_isExist" id="category-left-side-bar-module">
    <ul class="menu">
      <category-item
        v-for="(item, idx) in _settingCategory"
        :key="idx"
        :group="item"
      ></category-item>
    </ul>
    <hr class="border my-3" />
  </div>
</template>

<script>
import { mapState, } from 'vuex'
import CategoryItem from './components/CategoryItem'

export default {
  name: 'ModuleCategoryMenuLeft',
  components: {
    CategoryItem,
  },
  data() {
    return {
      fullPage: true,
    }
  },
  computed: {
    ...mapState({
      settingCategorys: state => state.cfApp.setting.modules.module_category_left_side_bar,
    }),
    _isExist() {
      const moduleName = 'module_category_left_side_bar_categories'
      const isModule = (String(this.settingCategorys[moduleName]) !== 'undefined')
      if (isModule) {
        return this.settingCategorys.module_category_left_side_bar_categories.length
      }
      
      return 0
    },
    _settingCategory() {
      return this.settingCategorys.module_category_left_side_bar_categories
    },
  },
  setting: {
    panel_title: 'Module Danh Mục Icon',
    frm_title: 'Thêm danh mục Icon',
    btn_save_txt: 'Lưu',
  },
}
</script>

<style lang="scss">
@import "./styles.scss";
</style>
