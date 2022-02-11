<template>
	<div>
    <table
      id="info-thuyen-chuyen-list"
      class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <td>Từ giáo xứ</td>
          <td>Từ ngày</td>
          <td>Chức vụ</td>
          <td>Đến giáo xứ</td>
          <td>Ngày</td>
          <td>Chức vụ</td>
          <td>Đức Cha</td>
          <td></td>
        </tr>
      </thead>
      <info-item
        v-for="(item, idx) in lists"
        :item="item"
        :key="idx"
      ></info-item>
      <tfoot>
        <tr>
          <td colspan="4"></td>
					 <td class="text-right"></td>
        </tr>
      </tfoot>
    </table>
	</div>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_MODULE_LINH_MUC_EDIT, } from 'store@admin/types/module-types'
import InfoItem from './InfoItem'

export default {
  name: 'TheInfoList',
  components: {
    InfoItem,
  },
  props: {
    lists: {
      default: {},
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, ['checkAllThuyenChuyen']),
    _checkAllThuyenChuyen(event) {
      this.checkAllThuyenChuyen(event.target.checked)
    },
  },
	mounted() {
		setTimeout(() => {
			console.log(this.lists, 'ìno')
		}, 3000)
	},
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
