<template>
  <div class="tab-content">
    <h1>Hoạt Động Sứ Vụ</h1>
    <h5><a :href="'/danh-sach-linh-muc/chi-tiet/' + this.$route.params.linhMucId"  target="_blank">Thông tin cá nhân</a></h5>
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
    <!-- Bo_nhiem_khac -->
    <h1>Bổ Nhiệm Khác</h1>
    <div class="form-group">
        <div class="col-sm-12">
            <div class="text-right">
              	<btn-add-bo-nhiem @show-modal-add-bo-nhiem="_showModalAddBoNhiem"></btn-add-bo-nhiem>
            </div>
            <info-list-bo-nhiem></info-list-bo-nhiem>
            <div class="text-right">
						<btn-add-bo-nhiem @show-modal-add-bo-nhiem="_showModalAddBoNhiem"></btn-add-bo-nhiem>
				</div>
        </div>
    </div>
    <modal-hoat-dong-su-vu></modal-hoat-dong-su-vu>
    <modal-bo-nhiem-khac></modal-bo-nhiem-khac>
  </div>
</template>

<script>
import { MODULE_LINH_MUC_DETAIL_PAGE, } from '@app/stores/front/types/module-types'
import { mapActions, } from 'vuex'
import InfoList from './Infos/InfoList.vue'
import InfoListBoNhiem from './Infos/InfoListBoNhiem.vue'
import BtnAdd from './Button/BtnAdd.vue'
import BtnAddBoNhiem from './Button/BtnAddBoNhiem.vue'
import ModalHoatDongSuVu from './Modals/ModalHoatDongSuVu.vue' 
import ModalBoNhiemKhac from './Modals/ModalBoNhiemKhac.vue'

export default {
  name: 'InfoPage',
  components: {
    InfoList,
    BtnAdd,
    BtnAddBoNhiem,
    ModalHoatDongSuVu,
    InfoListBoNhiem,
    ModalBoNhiemKhac,
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
    _showModalAddBoNhiem() {
      console.log('modal_bonhiemkhac')
			this.$modal.show('modal-bo-nhiem-khac-add')
		},
  },
}

</script>

