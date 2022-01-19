<template>
  <button
    type="button"
    data-toggle="tooltip"
    @click="_addInfo()"
    title="Thêm thông tin"
    class="btn btn-default cms-btn"
  >
    <font-awesome-layers style="background: honeydew">
      <font-awesome-icon size="1x" icon="plus" />
    </font-awesome-layers>
  </button>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_MODULE_NOI_BAT, } from 'store@admin/types/module-types'

export default {
  name: 'TheButtonAdd',
  props: {
    moduleKey: {
      default: '',
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_NOI_BAT, [
      'module_noi_bat_sach_nois',
      'module_noi_bat_hanh_cac_thanhs',
      'module_noi_bat_youtubes'
    ]),
    _addInfo() {
      this[this.moduleKey]({
        action: this.moduleKey,
      })
    },
  },
}
</script>
