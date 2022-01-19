<template>
  <div class="tab-content">
    <div class="form-group">
      <div class="col-sm-12">
        <div class="text-right">
          <btn-add @show-modal-add="_showModalAdd"></btn-add>
        </div>
        <info-list :lists="groupData.lm_thuyen_chuyens"></info-list>
        <div class="text-right">
          <btn-add @show-modal-add="_showModalAdd"></btn-add>
        </div>
      </div>
    </div>
    <modal-lm-thuyen-chuyen :type-chuc-vu="typeChucVu"></modal-lm-thuyen-chuyen>
  </div>
</template>

<script>
import InfoList from './LmThuyenChuyens/InfoList'
import BtnAdd from './LmThuyenChuyens/BtnAdd'
import ModalLmThuyenChuyen from './Modals/TheModalLmThuyenChuyen'
export default {
  name: 'TabLmThuyenChuyenForm',
  components: {
    InfoList,
    BtnAdd,
    ModalLmThuyenChuyen,
  },
  props: {
    typeChucVu: {
      default() {
        return 0
      } 
    },
    groupData: {
      type: Object,
    },
  },
  methods: {
    _showModalAdd() {
      this.$modal.show('modal-linh-muc-thuyen-chuyen-add')
    },
  },
}
</script>
