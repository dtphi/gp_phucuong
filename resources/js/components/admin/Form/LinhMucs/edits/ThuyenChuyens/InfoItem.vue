<template>
  <tbody>
    <tr v-if="item.isEdit" key="thuyen-chuyen-title">
      <td>{{ vitri + 1 }}</td>
      <p class="text-center">{{ item.chucvuName}}</p>
      <div class="text-center">
				<toggle-button class="switch-btn-center" v-if="item.chuc_vu_active == 1" :value="switchValue" @change="_changeActiveThuyenChuyen($event, item)" />
				<toggle-button class="switch-btn-center" v-else :value="!switchValue" @change="_changeActiveThuyenChuyen($event, item)" />
			</div>
			<td>Giáo Xứ {{ item.giaoxuName }}</td>
			<td class="text-center">{{ item.label_from_date  }}</td>
			<td class="text-center">{{ item.label_to_date }}</td>
			<td>	
				<button
          type="button"
          @click="_removeItem(item)"
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
import { MODULE_MODULE_LINH_MUC_EDIT, } from 'store@admin/types/module-types'

export default {
  name: 'TheInfoItem',
  props: {
    item: {
      default: {},
    },
		vitri: {
			default: 1,
		}
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
