<template>
  <div>
    <i class="fa fa-minus-circle cms-text-red" @click="_deleteCategory"></i
    >{{ infoToCategory.name }}
  </div>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_INFO_EDIT, } from 'store@admin/types/module-types'
import { ACTION_REMOVE_INFO_TO_CATEGORY_LIST, } from 'store@admin/types/action-types'

export default {
  name: 'CategoryItemEdit',
  props: {
    infoToCategory: {
      default: null,
    },
  },
  methods: {
    ...mapActions(MODULE_INFO_EDIT, [ACTION_REMOVE_INFO_TO_CATEGORY_LIST]),
    _deleteCategory() {
      const cate = this.$deep(this.infoToCategory)
      this[ACTION_REMOVE_INFO_TO_CATEGORY_LIST](cate)
    },
  },
}
</script>
