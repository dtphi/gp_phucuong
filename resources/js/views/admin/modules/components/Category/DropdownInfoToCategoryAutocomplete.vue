<template>
  <li @click="_selectParentCategory()">
    <i v-if="isSelected" class="fa fa-plus-circle"></i>
    <a href="javascript:void(0);">{{ category.name }}</a>
  </li>
</template>

<script>
export default {
  name: 'TheDropdownCategory',
  props: {
    category: Object,
    selectDropdownCategoryItem: Function,
  },
  data() {
    return {
      isSelected: false,
    }
  },
  methods: {
    _selectParentCategory() {
      this.isSelected = true
      this.selectDropdownCategoryItem(this.category)
    },
  },
  setting: {
    paren_category_txt: 'Danh mục hiển thị',
  },
}
</script>
