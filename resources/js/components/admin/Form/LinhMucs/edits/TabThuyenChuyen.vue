<template>
  <div class="tab-content">
    <modal-update-thuyen-chuyen v-if="openModal"></modal-update-thuyen-chuyen>
    <div class="form-group">
      <div class="col-sm-10">
        <button @click="showModalUpdate" type="button" class="btn btn-primary">Xác nhận thuyên chuyển</button>
      </div>
    </div>
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
import ModalUpdateThuyenChuyen from './Modals/ModalUpdateThuyenChuyen.vue'

export default {
  name: 'TabThuyenChuyenForm',
  components: {
    InfoList,
		ModalThuyenChuyen,
		BtnAdd,
    ModalUpdateThuyenChuyen
  },
	props: {
		typeChucVu: {
			default() {
				return 0
			}
		},
	},
  data() {
    return {
      openModal: false
    }
  },
	methods: {
		_showModalAdd() {
			this.$modal.show('modal-thuyen-chuyen-add')
		},
    showModalUpdate() {
      this.openModal = true
      this.$nextTick(() => {
        this.$modal.show('modal-update-thuyen-chuyen')
      })
      
    }
  },
}
</script>
