<template>
  <div class="tab-content">
    <div class="form-group mt-2">
      <div class="col-sm-12">
        <h3><a :href="'/danh-sach-linh-muc/chi-tiet/' + this.$route.params.linhMucId">Thông tin cá nhân</a></h3>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-12">
        <select class="form-control" v-model="select_type_action">
          <option :value="1" :selected="select_type_action === 1">Bổ Nhiệm Khác</option>
          <option :value="0" :selected="select_type_action === 0">Hoạt Động Sứ Vụ</option>
          <option :value="2" :selected="select_type_action === 2">Tất cả</option>
        </select>
      </div>
    </div>
    <!-- Hoạt Động Sứ Vụ -->
    <div class="form-group" v-if="select_type_action === 2">
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
    <!-- Bổ Nhiệm Khác -->
    <div class="form-group" v-else>
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
      select_type_action: 2,
    }
  },
  methods: {
    _showModalAdd() {
			this.$modal.show('modal-hoat-dong-su-vu-add')
		},
    _showModalAddBoNhiem() {
			this.$modal.show('modal-bo-nhiem-khac-add')
		},
  },
}

</script>

