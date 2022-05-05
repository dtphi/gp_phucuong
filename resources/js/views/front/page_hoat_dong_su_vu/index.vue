<template>
  <div class="tab-content">
    <h1>Hoạt Động Sứ Vụ</h1>
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
    <modal-hoat-dong-su-vu></modal-hoat-dong-su-vu>
  </div>
</template>

<script>
import { MODULE_LINH_MUC_DETAIL_PAGE, } from '@app/stores/front/types/module-types'
import { mapState, mapActions, } from 'vuex'
import InfoList from './Infos/InfoList.vue'
import BtnAdd from './Button/BtnAdd.vue'
import ModalHoatDongSuVu from './Modals/ModalHoatDongSuVu.vue' 

export default {
  name: 'InfoPage',
  components: {
    InfoList,
    BtnAdd,
    ModalHoatDongSuVu,
  },
  data() {
    return {
    }
  },
  methods: {
    ...mapActions(MODULE_LINH_MUC_DETAIL_PAGE, [
      'GET_HOAT_DONG_SU_VU',
    ]),
    _showModalAdd() {
			this.$modal.show('modal-hoat-dong-su-vu-add')
		},
  },
}

</script>

