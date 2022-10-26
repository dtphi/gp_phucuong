<template>
  <div>
    <table
      id="info-bo-nhiem-list"
      class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <td class="text-center">TT</td>
          <td class="text-center">CHỨC VỤ</td>
          <td class="text-center">CÔNG VIỆC</td>
          <td class="text-center">TỪ <br> (năm tháng ngày)</td>
          <td class="text-center">ĐẾN <br> (năm tháng ngày)</td>
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
          <td class="text-right">
          </td>
        </tr>
      </tfoot>
			<modal name="modal-lm-bo-nhiem-edit" :height="500" :click-to-close="false">
				<the-modal-edit
					v-if="_infoUpdate.id"
					:info="_infoUpdate"
					:info-id="_infoUpdate.id"
					@update-info-success="_updateInfoList"
				></the-modal-edit>
			</modal>
    </table>
  </div>
</template>

<script>
import { mapActions, mapState} from 'vuex'
import { MODULE_MODULE_LINH_MUC_EDIT, } from 'store@admin/types/module-types'
import InfoItem from './InfoItem'
import TheModalEdit from '../Modals/TheModalEditBoNhiemKhac'


export default {
  name: 'TheInfoList',
  components: {
		InfoItem,
		TheModalEdit
  },
  props: {
    lists: {
      default() {
        return []
      },
    },
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
      arr_bo_nhiems: (state) => state.arr_bo_nhiems,
			update_bo_nhiem: (state) => state.update_bo_nhiem,
    }),
		_infoList() {
				return this.arr_bo_nhiems;
		},
		_infoUpdate() {
				return this.infoUpdate;
		}
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, {
				getInfoBoNhiem: 'ACTION_GET_INFO_BO_NHIEM',
		}),
		_showModalEdit(info) {
				this.curInfo = info;
				this.infoUpdate = { ...info };
				this.$modal.show("modal-lm-bo-nhiem-edit");
		},
		_updateInfoList() {
				this.curInfo.chuc_vu_id = this.update_bo_nhiem.chuc_vu_id;
				this.curInfo.chucvuName = this.update_bo_nhiem.chucVuName;
				this.curInfo.ghi_chu = this.update_bo_nhiem.cong_viec;
				// if(this.update_bo_nhiem.cong_viec_tu_nam == "" || this.update_bo_nhiem.cong_viec_tu_thang == "" || this.update_bo_nhiem.cong_viec_tu_ngay == ""){
				// 		this.curInfo.label_from_date = '';
				// } else {
				// 		this.curInfo.label_from_date = this.update_bo_nhiem.cong_viec_tu_nam + '-' + this.update_bo_nhiem.cong_viec_tu_thang + '-' + this.update_bo_nhiem.cong_viec_tu_ngay;
				// }	
				// if(this.update_bo_nhiem.cong_viec_den_nam == "" || this.update_bo_nhiem.cong_viec_den_thang == "" || this.update_bo_nhiem.cong_viec_den_ngay == ""){
				// 		this.curInfo.label_to_date = '';
				// } else {
				// 		this.curInfo.label_to_date = this.update_bo_nhiem.cong_viec_den_nam + '-' + this.update_bo_nhiem.cong_viec_den_thang + '-' + this.update_bo_nhiem.cong_viec_den_ngay;
				// }

				if(this.update_bo_nhiem.cong_viec_tu_nam == "0" || this.update_bo_nhiem.cong_viec_tu_thang == "" || this.update_bo_nhiem.cong_viec_tu_ngay == ""){
						this.curInfo.label_from_date = '';
				} else if (this.update_bo_nhiem.cong_viec_tu_thang == "0") {
						this.curInfo.label_from_date = this.update_bo_nhiem.cong_viec_tu_nam;
				}
				else if (this.update_bo_nhiem.cong_viec_tu_ngay == "0"){
				this.curInfo.label_from_date = this.update_bo_nhiem.cong_viec_tu_nam +'-' + this.update_bo_nhiem.cong_viec_tu_thang;
				}
				else this.curInfo.label_from_date = this.update_bo_nhiem.cong_viec_tu_nam +'-' + this.update_bo_nhiem.cong_viec_tu_thang + '-' + this.update_bo_nhiem.cong_viec_tu_ngay;
				
				if(this.update_bo_nhiem.cong_viec_den_nam == "0" || this.update_bo_nhiem.cong_viec_den_thang == "" || this.update_bo_nhiem.cong_viec_den_ngay == ""){
						this.curInfo.label_to_date = '';
				} else if (this.update_bo_nhiem.cong_viec_den_thang == "0") {
						this.curInfo.label_to_date = this.update_bo_nhiem.cong_viec_den_nam;
				}
				else if (this.update_bo_nhiem.cong_viec_den_ngay == "0"){
				this.curInfo.label_to_date = this.update_bo_nhiem.cong_viec_den_nam +'-' + this.update_bo_nhiem.cong_viec_den_thang;
				}
				else this.curInfo.label_to_date = this.update_bo_nhiem.cong_viec_den_nam +'-' + this.update_bo_nhiem.cong_viec_den_thang + '-' + this.update_bo_nhiem.cong_viec_den_ngay;
				this.$modal.hide("modal-lm-bo-nhiem-edit");
  	},
    _notificationUpdate(notification) {
				this.$notify(notification);
				this.resetNotification();
    },
  },
	mounted() {
			const linhmucId = parseInt(this.$route.params.linhmucId)
			if (linhmucId) {
				this.getInfoBoNhiem(linhmucId)
			}
  },
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
