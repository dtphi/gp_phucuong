<template>
  <li @click="_selectParentCategory()">
    <i v-if="isSelected" class="fa fa-plus-circle"></i>
    <a href="javascript:void(0);">{{ category.name }}</a>
  </li>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_NEWS_CATEGORY_EDIT, } from 'store@admin/types/module-types'
import { ACTION_SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY, } from 'store@admin/types/action-types'

export default {
  name: 'TheDropdownCategoryEdit',
  props: {
    category: {
      default: {},
    },
  },
  data() {
    return {
      isSelected: false,
    }
  },
  methods: {
    ...mapActions(MODULE_NEWS_CATEGORY_EDIT, [
      ACTION_SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY
    ]),
    _selectParentCategory() {
      this.isSelected = true
      const cate = this.$deep(this.category)
      this[ACTION_SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY](cate)
    },
  },
  setting: {
    paren_category_txt: 'Danh mục tin tức cha',
  },
}
</script>
