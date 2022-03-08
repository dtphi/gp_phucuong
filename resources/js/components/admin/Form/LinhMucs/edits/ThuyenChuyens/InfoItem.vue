<template>
  <tbody>
    <tr v-if="item.isEdit" key="thuyen-chuyen-title">
      <td>{{ vitri + 1 }}</td>
      <p class="text-center">{{ item.chucvuName}}</p>
      <div class="text-center">
				<toggle-button class="switch-btn-center" v-if="checkActiveToggle" :value="switchValue" @change="_changeActiveThuyenChuyen($event, item)" />
				<toggle-button class="switch-btn-center" v-else :value="!switchValue" @change="_changeActiveThuyenChuyen($event, item)" />
			</div>
			<td class="text-center" v-if="item.giaoxuName">
				<a :href="item.giao_xu_url">{{diaDiemName}}</a>
			</td>
			<td v-else class="text-center">
					{{diaDiemName}}
			</td>
			<td class="text-center">{{ item.label_from_date  }}</td>
			<td class="text-center">{{ item.label_to_date }}</td>
			<td>	
				<a
					href="javascript:void(0);"
					data-toggle="tooltip"
					@click.prevent="_showModalEdit"
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
import { MODULE_MODULE_LINH_MUC_EDIT, } from 'store@admin/types/module-types'

export default {
  name: 'TheInfoItem',
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
    }
  },
	computed: {
			checkActiveToggle: function() {
				if(this.item.chuc_vu_active == 1) {
					if(this.item.label_to_date === '')
						return true
					return false
				}else {
					return false
				}
			},
			diaDiemName: function() {
					if(this.item.giaoxuName) {
							return this.item.giaoxuName 
					}else if(this.item.cosogpName) {
							return this.item.cosogpName
					}else if(this.item.dongName) {
							return this.item.dongName
					}else {
							return this.item.banchuyentrachName
					}
			}
	},
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, [
      'removeThuyenChuyen',
			'updateActiveThuyenChuyen',
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
							this.removeThuyenChuyen({item: item, vitri: this.vitri, action: 'remove.thuyen.chuyen', id: this.$route.params.linhmucId })
              this.$modal.hide("dialog")
            },
          },
        ],
      });
    },
		_changeActiveThuyenChuyen($event, item) {
				this.updateActiveThuyenChuyen({
					action: 'update_active_thuyen_chuyen',
					item: item,
				});
		},
		_showModalEdit() {
			 	this.$emit('show-modal-edit', this.item)
    },
  },
	
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
