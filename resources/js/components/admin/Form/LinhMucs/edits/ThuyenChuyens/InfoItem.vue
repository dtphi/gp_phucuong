<template>
  <tbody>
    <tr v-if="item.isEdit" key="thuyen-chuyen-title">
      <td class="text-center">
        <input
          type="checkbox"
          :id="`info_select_id_${item.id}`"
          v-model="item.isCheck"
        />
      </td>
      <td>{{ item.fromgiaoxuName }}</td>
      <td>{{ item.label_from_date }}</td>
      <td>{{ item.fromchucvuName }}</td>
      <td>{{ item.giaoxuName }}</td>
      <td>{{ item.label_to_date }}</td>
      <td>{{ item.chucvuName }}</td>
      <td>{{ item.ducchaName }}</td>

      <td class="text-center">
				<toggle-button
									class="switch-btn-center"
									v-if="item.chuc_vu_active == 1"
									:value="switchValue"
									@change="_changeActiveThuyenChuyen($event, item)"
								/>
					<toggle-button
						class="switch-btn-center"
						v-else
						:value="!switchValue"
						@change="_changeActiveThuyenChuyen($event, item)"
					/>
        <button
          type="button"
          @click="_removeItem()"
          data-toggle="tooltip"
          class="btn btn-default cms-btn"
        >
          <font-awesome-layers size="1x" style="background: MistyRose">
            <font-awesome-icon icon="circle" style="color: Tomato" />
            <font-awesome-icon
              icon="times"
              class="fa-inverse"
              transform="shrink-4"
            />
          </font-awesome-layers>
        </button>
      </td>
    </tr>
  </tbody>
</template>

<script>
import { mapActions, } from 'vuex'
import linhMucMix from '@app/mixins/admin/linhmuc'
import { MODULE_MODULE_LINH_MUC_EDIT, } from 'store@admin/types/module-types'
import InfoGiaoXuAutocomplete from '../../Groups/InfoGiaoXuAutocomplete'
import InfoChucVuAutocomplete from '../../Groups/InfoChucVuAutocomplete'
import InfoDucChaAutocomplete from '../../Groups/InfoDucChaAutocomplete'
import InfoCoSoGiaoPhanAutocomplete from '../../Groups/InfoCoSoGiaoPhanAutocomplete'
import InfoDongAutocomplete from '../../Groups/InfoDongAutocomplete'
import InfoBanChuyenTrachAutocomplete from '../../Groups/InfoBanChuyenTrachAutocomplete'
import InfoNewItem from './InfoNewItem'

export default {
  name: 'TheInfoItem',
  mixins: [linhMucMix.tabData],
  components: {
    InfoGiaoXuAutocomplete,
    InfoChucVuAutocomplete,
    InfoDucChaAutocomplete,
    InfoCoSoGiaoPhanAutocomplete,
    InfoDongAutocomplete,
    InfoBanChuyenTrachAutocomplete,
    InfoNewItem,
  },
  props: {
    item: {
      default: {},
    },
  },
  data() {
    return {
      isEdit: false,
			switchValue: true,
    }
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, [
      'removeThuyenChuyen',
			'updateActiveThuyenChuyen',
      'ACTION_UPDATE_DROPDOWN_FROM_GIAO_XU',
      'ACTION_UPDATE_DROPDOWN_FROM_CHUC_VU',
      'ACTION_UPDATE_DROPDOWN_FROM_DUC_CHA',
      'ACTION_UPDATE_DROPDOWN_TO_CHUC_VU',
      'ACTION_UPDATE_DROPDOWN_TO_GIAO_XU',
      'ACTION_UPDATE_DROPDOWN_CO_SO_GIAO_PHAN',
      'ACTION_UPDATE_DROPDOWN_THUYEN_CHUYEN_DONG',
      'ACTION_UPDATE_DROPDOWN_THUYEN_CHUYEN_BAN_CHUYEN_TRACH',
      'addThuyenChuyen'
    ]),
		_removeItem(item) {
      const isDl = confirm('Tiếp tục xóa linh mục thuyên chuyển')
      if (isDl) {
        this.removeThuyenChuyen({
          action: 'removeThuyenChuyen',
          item: item,
        })
      }
    },
    _openEditForm() {
      this.isEdit = !this.isEdit
    },
    _updateThuyenChuyenForm() {
      const id = this.item?.id
      if (id) {
        this.addThuyenChuyen({
          action: 'create.update.thuyen.chuyen.db',
          info: this.item,
        })
      }
    },
		_changeActiveThuyenChuyen($event, item) {
				this.updateActiveThuyenChuyen({
					action: 'update_active_thuyen_chuyen',
					item: item,
				});
		}
  },
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
