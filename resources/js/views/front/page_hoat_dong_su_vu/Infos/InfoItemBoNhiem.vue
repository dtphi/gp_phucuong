<template>
  <tbody>
    <tr>
      <td>{{ vitri + 1 }}</td>
			<p class="text-center">{{ item.chucvuName }}</p>
			 <div class="text-center">
          <p v-if="checkActiveToggle">Xảy ra</p>
          <p v-else>Ẩn</p>
			</div>
			<td class="text-center">{{ item.ghi_chu }}</td>
      <td class="text-center">{{ item.label_from_date  }}</td>
			<td class="text-center">{{ item.label_to_date }}</td>
      <td>	
				<a
					href="javascript:void(0);"
					data-toggle="tooltip"
					@click.prevent="_showModalEdit"
					class="btn btn-default cms-btn"
					data-original-title="Sửa bổ nhiệm khác"
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
import { mapActions } from 'vuex'
import { MODULE_LINH_MUC_DETAIL_PAGE, } from '@app/stores/front/types/module-types'

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
	},
  methods: {
    ...mapActions(MODULE_LINH_MUC_DETAIL_PAGE, [
      'DELETE_THUYEN_CHUYEN'
    ]),
		_removeItem(item) {
      this.$modal.show('dialog', {
        title: "Xóa bổ nhiệm",
        text: "Bạn muốn xóa hoạt động sứ vụ này ?",
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
							this.DELETE_THUYEN_CHUYEN(item.id)
              this.$modal.hide("dialog")
            },
          },
        ],
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
