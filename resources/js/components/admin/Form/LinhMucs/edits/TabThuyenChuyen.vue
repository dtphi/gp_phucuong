<template>
  <div class="tab-content">
    <div class="form-group">
      <div class="col-sm-12">
        <info-list :lists="arr_thuyen_chuyens"></info-list>
      </div>
    </div>
  </div>
</template>

<script>
import InfoList from './ThuyenChuyens/InfoList'
import { mapState, mapActions, } from 'vuex'
import { MODULE_MODULE_LINH_MUC_EDIT, } from 'store@admin/types/module-types'
export default {
  name: 'TabThuyenChuyenForm',
  components: {
    InfoList,
  },
	computed: {
    ...mapState(MODULE_MODULE_LINH_MUC_EDIT, {
      loading: (state) => state.loading,
      arr_thuyen_chuyens: (state) => state.arr_thuyen_chuyens,
    }),
  },
	methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, {
			getInfoThuyenChuyen: 'ACTION_GET_INFO_THUYEN_CHUYEN',
		}),

  },
	mounted() {
    const linhmucId = parseInt(this.$route.params.linhmucId)
    if (linhmucId) {
      this.getInfoThuyenChuyen(linhmucId)
    }
  },
}
</script>
