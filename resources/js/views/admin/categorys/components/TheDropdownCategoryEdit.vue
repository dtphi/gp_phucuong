<template>
  <li @click="_selectParentCategory()">
    <a href="javascript:void(0);">{{ category.name }}</a>
  </li>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_NEWS_CATEGORY_EDIT, } from 'store@admin/types/module-types'
import { ACTION_SELECT_DROPDOWN_PARENT_CATEGORY, } from 'store@admin/types/action-types'

export default {
  name: 'TheDropdownCategoryEdit',
  props: {
    category: {
      default: {},
    },
    selectCategoryName: {
      default: Function,
    },
  },
  methods: {
    ...mapActions(MODULE_NEWS_CATEGORY_EDIT, [
      ACTION_SELECT_DROPDOWN_PARENT_CATEGORY
    ]),
    _selectParentCategory() {
      this[ACTION_SELECT_DROPDOWN_PARENT_CATEGORY](this.category)
    },
  },
  setting: {
    paren_category_txt: 'Danh mục tin tức cha',
  },
}
</script>
