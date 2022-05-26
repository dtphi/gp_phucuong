<template>
	<div>
    <table
      id="info-thuyen-chuyen-list"
      class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <td class="text-center">TT</td>
          <td class="text-center">CHỨC VỤ</td>
          <td class="text-center">ĐỊA ĐIỂM</td>
          <td class="text-center">CÔNG VIỆC</td>
          <td class="text-center">THỜI GIAN ĐẾN <br> (năm tháng ngày)</td>
          <td class="text-center">THỜI GIAN ĐI <br> (năm tháng ngày)</td>
          <td class="text-center">{{ $options.setting.info_action_title }}</td>
        </tr>
      </thead>
      <info-item
        v-for="(item, idx) in _infoList"
        :item="item"
        :key="idx"
				:vitri="idx"
				@show-modal-edit="_showModalEdit"
      ></info-item>
      <tfoot>
        <tr>
          <td colspan="4"></td>
					 <td class="text-right"></td>
        </tr>
      </tfoot>
    </table>
    <modal name="modal-hoat-dong-su-vu-edit" width="800" height="600">
				<the-modal-edit
					:info="_infoUpdate"
					:info-id="_infoUpdate.id"
				></the-modal-edit>
		</modal>
    <modal name="modal-bo-nhiem-khac-edit" width="800" height="600">
        <the-modal-edit-bo-nhiem
          :info="_infoUpdate"
          :info-id="_infoUpdate.id"
        ></the-modal-edit-bo-nhiem>
      </modal>
	</div>
</template>

<script>
import { MODULE_LINH_MUC_DETAIL_PAGE, } from '@app/stores/front/types/module-types'
import { mapState, mapActions, } from 'vuex'
import InfoItem from './InfoItem'
import TheModalEdit from '../Modals/ModalHoatDongSuVuEdit.vue'
import TheModalEditBoNhiem from '../Modals/ModalBoNhiemKhacEdit.vue'

export default {
  name: 'TheInfoList',
  components: {
			InfoItem,
      TheModalEdit,
      TheModalEditBoNhiem
  },
	data() {
			return {
					infoUpdate: {},
			}
	},
  computed: {
    ...mapState(MODULE_LINH_MUC_DETAIL_PAGE, {
      arr_thuyen_chuyens: (state) => state.arr_thuyen_chuyens,
			update_thuyen_chuyen: (state) => state.update_thuyen_chuyen,
    }),

		_infoList() {
				return this.arr_thuyen_chuyens;
		},
		_infoUpdate() {
				return this.infoUpdate;
		}
  },
	methods: {
		...mapActions(MODULE_LINH_MUC_DETAIL_PAGE, [
      'GET_HOAT_DONG_SU_VU' 
    ]),
		_showModalEdit(info) {
				this.infoUpdate = { ...info };
        console.log(this.infoUpdate.is_bo_nhiem , 'info')
        if(this.infoUpdate.is_bo_nhiem == 1) {  
          this.$modal.show("modal-bo-nhiem-khac-edit");
        }else {   
          this.$modal.show("modal-hoat-dong-su-vu-edit");
        }
				
		},
		_notificationUpdate(notification) {
				this.$notify(notification);
				this.resetNotification();
    },
	},
  mounted() {
    this.GET_HOAT_DONG_SU_VU(this.$route.params)
  },
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
