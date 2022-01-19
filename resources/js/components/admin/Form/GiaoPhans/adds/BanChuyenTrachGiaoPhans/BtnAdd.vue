<template>
  <button
    type="button"
    data-toggle="tooltip"
    @click="_addInfo()"
    title="Thêm ban chuyên trách"
    class="btn btn-default cms-btn"
  >
    <font-awesome-layers style="background: honeydew">
      <font-awesome-icon size="1x" icon="plus" />
    </font-awesome-layers>
  </button>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_MODULE_GIAO_PHAN_ADD, } from 'store@admin/types/module-types'

export default {
  name: 'TheButtonAdd',
  props: {
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_ADD, ['addBanChuyenTrachGiaoPhan']),

    _addInfo() {
      this.addBanChuyenTrachGiaoPhan({
        action: 'addBanChuyenTrachGiaoPhan',
      })
    },
  },
}
</script>
