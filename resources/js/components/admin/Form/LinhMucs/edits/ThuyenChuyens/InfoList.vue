<template>
  <div class="table-responsive">
    <table
      id="info-thuyen-chuyen-list"
      class="table table-striped table-bordered table-hover"
    >
      <thead>
        <tr>
          <td colspan="9" class="text-right">
            <btn-remove-select></btn-remove-select>
            <btn-add-select></btn-add-select>
            <btn-add></btn-add>
          </td>
        </tr>
        <tr>
          <td class="text-center">
              <input type="checkbox"
                      @click="_checkAllThuyenChuyen">
          </td>
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
          <td colspan="9" class="text-right">
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

export default {
  name: 'TheInfoList',
  components: {
    BtnAdd,
    BtnAddSelect,
    BtnRemoveSelect,
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
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
