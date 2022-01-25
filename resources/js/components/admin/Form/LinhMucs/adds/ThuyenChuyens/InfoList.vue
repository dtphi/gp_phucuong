<template>
  <div>
    <table
      id="info-thuyen-chuyen-list"
      class="table table-striped table-bordered table-hover"
    >
      <thead>
        <tr>
          <td class="text-left">Key</td>
          <td>Value</td>
        </tr>
      </thead>
      <info-item
        v-for="(item, idx) in lists"
        :item="item"
        :key="idx"
      ></info-item>
      <tfoot>
        <tr>
          <td></td>
          <td class="text-right">
            <btn-add></btn-add>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
import BtnAdd from './BtnAdd'
import InfoItem from './InfoItem'

export default {
  name: 'TheInfoList',
  components: {
    BtnAdd,
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
