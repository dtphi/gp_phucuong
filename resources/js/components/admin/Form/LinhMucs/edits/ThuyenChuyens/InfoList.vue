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
          <td class="text-center">THỜI GIAN ĐẾN <br> (ngày tháng năm)</td>
          <td class="text-center">THỜI GIAN ĐI <br> (ngày tháng năm)</td>
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
		<modal name="modal-lm-thuyen-chuyen-edit" :height="500" :click-to-close="false">
				<the-modal-edit
					v-if="_infoUpdate.id"
					:info="_infoUpdate"
					:info-id="_infoUpdate.id"
					@update-info-success="_updateInfoList"
				></the-modal-edit>
		</modal>
	</div>
</template>

<script>
import InfoItem from './InfoItem'
import { MODULE_MODULE_LINH_MUC_EDIT, } from 'store@admin/types/module-types'
import { mapState, mapActions, } from 'vuex'
import TheModalEdit from '../Modals/TheModalEditThuyenChuyen'

export default {
  name: 'TheInfoList',
  components: {
			InfoItem,
			TheModalEdit,
  },
	data() {
			return {
					infoUpdate: {},
					curInfo: {},
			}
	},
  computed: {
    ...mapState(MODULE_MODULE_LINH_MUC_EDIT, {
      loading: (state) => state.loading,
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
		...mapActions(MODULE_MODULE_LINH_MUC_EDIT, {
			getInfoThuyenChuyen: 'ACTION_GET_INFO_THUYEN_CHUYEN',
		}),
		_showModalEdit(info) {
				this.curInfo = info;
				this.infoUpdate = { ...info };
				this.$modal.show("modal-lm-thuyen-chuyen-edit");
		},
		_updateInfoList() {
				this.curInfo.id = this.update_thuyen_chuyen.id;
				this.curInfo.chuc_vu_id = this.update_thuyen_chuyen.chuc_vu_id;
				this.curInfo.chucvuName = this.update_thuyen_chuyen.chucVuName;
				this.curInfo.chuc_vu_active = this.update_thuyen_chuyen.chuc_vu_active;
				if(this.update_thuyen_chuyen.giao_xu_id != 0) {
					this.curInfo.giaoxuName = this.update_thuyen_chuyen.diaDiemName
					this.curInfo.giao_xu_id = this.update_thuyen_chuyen.giao_xu_id
				}else if(this.update_thuyen_chuyen.co_so_gp_id != 0) {
					this.curInfo.cosogpName = this.update_thuyen_chuyen.diaDiemName
					this.curInfo.co_so_id = this.update_thuyen_chuyen.co_so_gp_id
				}else if(this.update_thuyen_chuyen.dong_id != 0) {
					this.curInfo.dongName = this.update_thuyen_chuyen.diaDiemName
					this.curInfo.dong_id = this.update_thuyen_chuyen.dong_id
				}else {
					this.curInfo.banchuyentrachName = this.update_thuyen_chuyen.diaDiemName
					this.curInfo.ban_chuyen_trach_id = this.update_thuyen_chuyen.ban_chuyen_trach_id
				}

				if(this.update_thuyen_chuyen.dia_diem_tu_nam == "" || this.update_thuyen_chuyen.dia_diem_tu_thang == "" || this.update_thuyen_chuyen.dia_diem_tu_ngay == ""){
						this.curInfo.label_from_date = '';
				} else {
						this.curInfo.label_from_date = this.update_thuyen_chuyen.dia_diem_tu_nam + '-' + this.update_thuyen_chuyen.dia_diem_tu_thang + '-' + this.update_thuyen_chuyen.dia_diem_tu_ngay;
				}	
				if(this.update_thuyen_chuyen.dia_diem_den_nam == "" || this.update_thuyen_chuyen.dia_diem_den_thang == "" || this.update_thuyen_chuyen.dia_diem_den_ngay == ""){
						this.curInfo.label_to_date = '';
				} else {
						this.curInfo.label_to_date = this.update_thuyen_chuyen.dia_diem_den_nam + '-' + this.update_thuyen_chuyen.dia_diem_den_thang + '-' + this.update_thuyen_chuyen.dia_diem_den_ngay;
				}
				this.$modal.hide("modal-lm-thuyen-chuyen-edit");
  	},
		_notificationUpdate(notification) {
				this.$notify(notification);
				this.resetNotification();
    },
	},
	mounted() {
			const linhmucId = parseInt(this.$route.params.linhmucId)
			if (linhmucId) {
				this.getInfoThuyenChuyen(linhmucId)
			}
  },
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
