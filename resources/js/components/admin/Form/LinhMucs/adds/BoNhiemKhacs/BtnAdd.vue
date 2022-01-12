<template>
  <button
    type="button"
    data-toggle="tooltip"
    @click.prevent="_showModal()"
    title="Thêm văn thư"
    class="btn btn-default cms-btn"
  >
    <i class="fa fa-plus" />
  </button>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_MODULE_LINH_MUC_ADD, } from 'store@admin/types/module-types'

export default {
  name: 'TheButtonAdd',
  props: {
    moduleKey: {
      default: '',
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_ADD, ['addVanThus']),
    _showModal() {
      this.$emit('show-modal-add')
    },
  },
}
</script>
