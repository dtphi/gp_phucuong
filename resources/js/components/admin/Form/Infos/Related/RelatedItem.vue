<template>
  <div>
    <i class="fa fa-minus-circle cms-text-red" @click="_deleteRelated"></i
    >{{ infoToRelated.name }}
  </div>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_INFO_ADD, } from 'store@admin/types/module-types'
import { ACTION_REMOVE_INFO_TO_RELATED_LIST, } from 'store@admin/types/action-types'

export default {
  name: 'RelatedItem',
  props: {
    infoToRelated: {
      default: null,
    },
  },
  methods: {
    ...mapActions(MODULE_INFO_ADD, [ACTION_REMOVE_INFO_TO_RELATED_LIST]),
    _deleteRelated() {
      const info = this.$deep(this.infoToRelated)
      this[ACTION_REMOVE_INFO_TO_RELATED_LIST](info)
    },
  },
}
</script>
