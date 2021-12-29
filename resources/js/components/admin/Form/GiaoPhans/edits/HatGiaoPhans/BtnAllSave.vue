<template>
  <button
    type="button"
    data-toggle="tooltip"
    @click="_addInfo()"
    title="Thêm giáo hạt"
    class="btn btn-default cms-btn"
  >
    Lưu tất cả
  </button>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_MODULE_GIAO_PHAN_EDIT, } from 'store@admin/types/module-types'

export default {
  name: 'TheButtonAdd',
  props: {
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, ['addHatGiaoPhanAll']),

    _addInfo() {
      /*this.addHatGiaoPhan({
        action: "addHatGiaoPhanAll",
      });*/
    },
  },
}
</script>
