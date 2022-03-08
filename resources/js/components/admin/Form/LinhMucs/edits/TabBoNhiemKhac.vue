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
    <modal-bo-nhiem-khac :type-chuc-vu="typeChucVu"></modal-bo-nhiem-khac>
  </div>
</template>

<script>
import InfoList from './BoNhiemKhacs/InfoList'
import BtnAdd from './BoNhiemKhacs/BtnAdd'
import ModalBoNhiemKhac from './Modals/TheModalBoNhiemKhac'
export default {
  name: 'TabBoNhiemKhacForm',
  components: {
    InfoList,
    BtnAdd,
    ModalBoNhiemKhac,
  },
  props: {
    typeChucVu: {
      default() {
        return 1
      } 
    },
  },
  methods: {
    _showModalAdd() {
      this.$modal.show('modal-lm-bo-nhiem-add')
    },
  },
}
</script>
