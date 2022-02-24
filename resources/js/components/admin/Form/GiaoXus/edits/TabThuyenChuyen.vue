<template>
  <div class="tab-content">
    <div class="form-group">
      <div class="col-sm-12">
				<div class="text-right">
						<btn-add @show-modal-add="_showModalAdd"></btn-add>
				</div>
        <info-list></info-list>	
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
export default {
  name: 'TabThuyenChuyenForm',
  components: {
    InfoList,
		BtnAdd,
		ModalThuyenChuyen,
  },
	props: {
		typeChucVu: {
			default() {
				return 0
			}
		},
	},
	methods: {
		_showModalAdd() {
			this.$modal.show('modal-thuyen-chuyen-add')
		},
  },
}
</script>
