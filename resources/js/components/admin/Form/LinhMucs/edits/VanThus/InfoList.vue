<template>
  <div>
    <table
      id="info-van-thu-list"
      class="table table-striped table-bordered table-hover"
    >
      <thead>
        <tr>
          <td colspan="6" class="text-right">
            <btn-remove-select></btn-remove-select>
            <btn-add-select></btn-add-select>
            <btn-add></btn-add>
          </td>
        </tr>
        <tr>
          <td class="text-center">
              <input type="checkbox"
                      @click="_checkAllVanThu">
          </td>
          <td class="text-left">Tiêu đề</td>
          <td class="text-left">Loại</td>
          <td class="text-left">Ghi chú</td>
          <td class="text-left">Trạng thái</td>
          <td class="text-right">{{ $options.setting.info_action_title }}</td>
        </tr>
      </thead>
      <tbody 
        v-for="(item, idx) in lists" 
        :key="idx">
        <info-item 
          v-if="item.isEdit"
          key="van-thu-edit"
          :item="item"></info-item>
        <info-new-item 
          v-else 
          key="van-thu-new"
          :item="item"></info-new-item>
      </tbody>

      <tfoot>
        <tr>
          <td colspan="6" class="text-right">
            <btn-remove-select></btn-remove-select>
            <btn-add-select></btn-add-select>
            <btn-add></btn-add>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_MODULE_LINH_MUC_EDIT, } from 'store@admin/types/module-types'
import BtnAdd from './BtnAdd'
import BtnAddSelect from './BtnAddSelect'
import BtnRemoveSelect from './BtnRemoveSelect'
import InfoItem from './InfoItem'
import InfoNewItem from './InfoNewItem'

export default {
  name: 'TheInfoList',
  components: {
    BtnAdd,
    BtnAddSelect,
    BtnRemoveSelect,
    InfoItem,
    InfoNewItem,
  },
  props: {
    lists: {
      default: {},
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, ['checkAllVanThu']),
    _checkAllVanThu(event) {
      this.checkAllVanThu(event.target.checked)
    },
  },
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
