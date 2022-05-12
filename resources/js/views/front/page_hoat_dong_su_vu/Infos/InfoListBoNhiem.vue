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
          <td class="text-center">TỪ <br> (ngày tháng năm)</td>
          <td class="text-center">ĐẾN <br> (ngày tháng năm)</td>
          <td class="text-center">{{ $options.setting.info_action_title }}</td>
        </tr>
      </thead>
			<info-item-bo-nhiem
        v-for="(item, idx) in _infoList"
        :item="item"
        :key="idx"
				:vitri="idx"
				@show-modal-edit="_showModalEdit"
      ></info-item-bo-nhiem>
      <tfoot>
        <tr>
          <td colspan="4"></td>
          <td class="text-right">
          </td>
        </tr>
      </tfoot>
      <modal name="modal-bo-nhiem-khac-edit" width="800" height="570">
        <the-modal-edit-bo-nhiem
          :info="_infoUpdate"
          :info-id="_infoUpdate.id"
        ></the-modal-edit-bo-nhiem>
      </modal>
    </table>
  </div>
</template>

<script>
import { MODULE_LINH_MUC_DETAIL_PAGE, } from '@app/stores/front/types/module-types'
import { mapState, mapActions, } from 'vuex'
import InfoItemBoNhiem from './InfoItemBoNhiem'
import TheModalEditBoNhiem from '../Modals/ModalBoNhiemKhacEdit.vue'

export default {
  name: 'TheInfoList',
  components: {
			InfoItemBoNhiem,
      TheModalEditBoNhiem
  },
	data() {
			return {
					infoUpdate: {},
			}
	},
  computed: {
    ...mapState(MODULE_LINH_MUC_DETAIL_PAGE, {
      arr_bo_nhiems: (state) => state.arr_bo_nhiems,
    }),

		_infoList() {
				return this.arr_bo_nhiems;
		},
		_infoUpdate() {
				return this.infoUpdate;
		}
  },
	methods: {
		...mapActions(MODULE_LINH_MUC_DETAIL_PAGE, [
      'GET_BO_NHIEM_KHAC' 
    ]),
		_showModalEdit(info) {
				this.infoUpdate = { ...info };
				this.$modal.show("modal-bo-nhiem-khac-edit");
		},
		_notificationUpdate(notification) {
				this.$notify(notification);
				this.resetNotification();
    },
    _updateInfoList() {
      	this.$modal.hide("modal-bo-nhiem-khac-edit");
    }
	},
  mounted() {
    this.GET_BO_NHIEM_KHAC(this.$route.params)
  },
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
