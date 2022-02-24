<template>
	<div>
    <table
      id="info-thuyen-chuyen-list"
      class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <td class="text-center">TT</td>
          <td class="text-center">CHỨC VỤ</td>
          <td class="text-center">LINH MỤC</td>
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
		<modal name="modal-thuyen-chuyen-edit" 
			:height="700" :click-to-close="false">
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
import { MODULE_MODULE_GIAO_XU_EDIT, } from 'store@admin/types/module-types'
import { mapState, mapActions } from "vuex";
import TheModalEdit from '../Modals/TheModalEditThuyenChuyen'
export default {
  name: 'TheInfoList',
  components: {
    InfoItem,
		TheModalEdit
  },
	data() {
		return {
				infoUpdate: {},
				curInfo: {},
		}
	},
	computed: {
			...mapState(MODULE_MODULE_GIAO_XU_EDIT, {
			loading: (state) => state.loading,
			arr_thuyen_chuyens: (state) => state.arr_thuyen_chuyens,
			update_thuyen_chuyen: (state) => state.update_thuyen_chuyen,
		}),
		_infoList() {
      		return this.arr_thuyen_chuyens;
    	},
			_infoUpdate() {
      return this.infoUpdate
    }
	},
	methods: {
			...mapActions(MODULE_MODULE_GIAO_XU_EDIT, {
					getInfoThuyenChuyen: 'ACTION_GET_INFO_THUYEN_CHUYEN',
			}),
			_showModalEdit(info) {
					this.curInfo = info;
					this.infoUpdate = { ...info };
					this.$modal.show("modal-thuyen-chuyen-edit");
   	 	},
			_updateInfoList() {
				console.log(this.update_thuyen_chuyen, 'upda');
				this.curInfo.id = this.update_thuyen_chuyen.id;
				this.curInfo.giao_xu_id = this.update_thuyen_chuyen.giao_xu_id;
				this.curInfo.linh_muc_id = this.update_thuyen_chuyen.linh_muc_id;
				this.curInfo.linhMucName = this.update_thuyen_chuyen.linhMucName;
				this.curInfo.chuc_vu_id = this.update_thuyen_chuyen.chuc_vu_id;
				this.curInfo.chucvuName = this.update_thuyen_chuyen.chucVuName;
				this.curInfo.label_from_date = this.update_thuyen_chuyen.from_date;
				this.curInfo.label_to_date = this.update_thuyen_chuyen.to_date;

				console.log(this.curInfo, 'cur')

				this.$modal.hide("modal-thuyen-chuyen-edit");
    },
		_notificationUpdate(notification) {
      this.$notify(notification);
      this.resetNotification();
    },

  },
	mounted() {
			const giaoxuId = parseInt(this.$route.params.giaoxuId)
			if (giaoxuId) {
				this.getInfoThuyenChuyen(giaoxuId)
			}
  },
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
