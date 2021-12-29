<template>
	<button 
		type="button" 
		data-toggle="tooltip"
		@click="_addInfo()"
        title="Thêm giáo hạt" class="btn btn-default cms-btn">
          <font-awesome-layers style="background:honeydew">
              <font-awesome-icon size="1x" icon="plus"/>
          </font-awesome-layers>
  </button>
</template>

<script>
import {
  mapActions,
} from 'vuex'
import {
  MODULE_MODULE_GIAO_PHAN_EDIT,
} from 'store@admin/types/module-types'

export default {
  name: 'TheButtonAdd',
  props: {
    moduleKey: {
      default: '',
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, [
      'addHatGiaoPhan'
    ]),

    _addInfo() {
      this.addHatGiaoPhan({
        action: 'addHatGiaoPhan',
      })
    },
  },
}
</script>
