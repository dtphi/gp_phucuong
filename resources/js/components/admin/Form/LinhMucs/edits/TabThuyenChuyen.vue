<template>
  <div class="tab-content">
    <div class="form-group">
      <div class="col-sm-12">
				<div class="text-right">
						<btn-add @show-modal-add="_showModalAdd"></btn-add>
				</div>
        <info-list :lists="arr_thuyen_chuyens"></info-list>	
				<div class="text-right">
						<btn-add @show-modal-add="_showModalAdd"></btn-add>
				</div>
      </div>
    </div>
		<modal-thuyen-chuyen :type-chuc-vu="typeChucVu"></modal-thuyen-chuyen>
  </div>
</template>

<script>
import InfoList from './ThuyenChuyens/InfoList'
import ModalThuyenChuyen from './Modals/TheModalThuyenChuyen'
import BtnAdd from './ThuyenChuyens/BtnAdd'
import { mapState, mapActions, } from 'vuex'
import { MODULE_MODULE_LINH_MUC_EDIT, } from 'store@admin/types/module-types'
export default {
  name: 'TabThuyenChuyenForm',
  components: {
    InfoList,
		ModalThuyenChuyen,
		BtnAdd,
  },
	props: {
		typeChucVu: {
			default() {
				return 0
			}
		},
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
		_showModalAdd() {
			this.$modal.show('modal-thuyen-chuyen-add')
		}
  },
	mounted() {
    const linhmucId = parseInt(this.$route.params.linhmucId)
    if (linhmucId) {
      this.getInfoThuyenChuyen(linhmucId)
    }
  },
}
</script>
