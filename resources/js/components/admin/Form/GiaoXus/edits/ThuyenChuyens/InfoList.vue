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
        v-for="(item, idx) in lists"
        :item="item"
        :key="idx"
				:vitri="idx"
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
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
