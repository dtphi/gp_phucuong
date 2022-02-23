<template>
  <tbody>
		<modal-edit-thuyen-chuyen
				v-if="_infoUpdate.id"
        :info="_infoUpdate || {}"
				@update-info-success="_updateInfoList"
		></modal-edit-thuyen-chuyen> 
    <tr key="thuyen-chuyen-title">
      <td>{{ vitri + 1 }}</td>
      <p class="text-center">{{ item.chucvuName}}</p>
      <div class="text-center">
				<toggle-button class="switch-btn-center" v-if="item.chuc_vu_active == 1" :value="switchValue" @change="_changeActiveThuyenChuyen($event, item)" />
				<toggle-button class="switch-btn-center" v-else :value="!switchValue" @change="_changeActiveThuyenChuyen($event, item)" />
			</div>
			<td>{{ item.linhMucName }}</td>
			<td class="text-center">{{ item.label_from_date  }}</td>
			<td class="text-center">{{ item.label_to_date }}</td>
			<td>	
				<a
					href="javascript:void(0);"
					data-toggle="tooltip"
					@click.prevent="_showModalEdit(item)"
					class="btn btn-default cms-btn"
					data-original-title="Sửa thuyên chuyển"
					><i class="fa fa-edit" />
      	</a>
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
import { mapActions, mapMutations } from 'vuex'
import { MODULE_MODULE_GIAO_XU_EDIT, } from 'store@admin/types/module-types'
import ModalEditThuyenChuyen from '../Modals/TheModalEditThuyenChuyen'

export default {
  name: 'TheInfoItem',
	components: {
		ModalEditThuyenChuyen
	},
  props: {
    item: {
      default: {},
    },
		vitri: {
			type: Number,
		},
  },
  data() {
    return {
      isEdit: false,
			switchValue: true,
			infoUpdate: {},
			curInfo: {},
    }
  },
	computed: {
		_infoUpdate() {
      return this.infoUpdate
    }
	},
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_XU_EDIT, [
      'removeThuyenChuyen',
			'updateActiveThuyenChuyen',
      'addThuyenChuyen',
    ]),
		_removeItem(item) {
      this.$modal.show("dialog", {
        title: "Xóa thuyên chuyển",
        text: "Bạn muốn xóa thuyên chuyển ?",
        buttons: [
          {
            title: "Hủy",
            handler: () => {
              this.$modal.hide("dialog");
            },
          },
          {
            title: "Xóa",
            handler: () => {
							this.removeThuyenChuyen({item: item, vitri: this.vitri, action: 'remove.thuyen.chuyen', id: this.$route.params.giaoxuId })
              this.$modal.hide("dialog")
            },
          },
        ],
      });
    },
		_changeActiveThuyenChuyen($event, item) {
				this.updateActiveThuyenChuyen({
					action: 'update.active.thuyen.chuyen',
					item: item,
				});
		},
		changeEdit() {
				this.isEdit = !this.isEdit
		},
		_showModalEdit(info) {
			this.curInfo = info;
			this.infoUpdate = { ...info };
			this.$nextTick(() => {
          this.$modal.show('modal-thuyen-chuyen-edit');
      });
    },
		_updateInfoList(data) {
			this.$modal.hide('modal-thuyen-chuyen-edit');
		}
  },
	
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
