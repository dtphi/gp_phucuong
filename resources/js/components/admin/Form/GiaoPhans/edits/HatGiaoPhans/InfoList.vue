<template>
  <div class="table-responsive">
    <table
      id="info-hat-giao-phan-list"
      class="table table-striped table-bordered table-hover"
    >
      <thead>
        <tr>
          <td style="width: 5%;" class="text-center">
            <input type="checkbox"
                    @click="_checkAllHat">
          </td>
          <td style="width: 50%" class="text-left">Hạt</td>
          <td style="width: 20%" class="text-left">Trình trạng</td>
          <td style="width: 30%" class="text-right">
            {{ $options.setting.info_action_title }}
          </td>
        </tr>
      </thead>
      <tbody 
        v-for="(item, idx) in lists" 
        :key="idx">
        <info-item 
          v-if="item.isEdit"
          key="hat-giao-phan-edit" 
          :item="item"></info-item>
        <info-new-item 
          v-else 
          key="hat-giao-phan-new"
          :item="item"></info-new-item>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4" class="text-right">
            <btn-add-all 
              v-show="lists.lenght"></btn-add-all>
            <btn-add></btn-add>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_MODULE_GIAO_PHAN_EDIT, } from 'store@admin/types/module-types'
import BtnAdd from './BtnAdd'
import BtnAddAll from './BtnAllSave'
import InfoItem from './InfoItem'
import InfoNewItem from './InfoNewItem'

export default {
  name: 'TheInfoList',
  components: {
    BtnAdd,
    BtnAddAll,
    InfoItem,
    InfoNewItem,
  },
  props: {
    lists: {
      default: {},
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, ['removeHatGiaoPhan', 'checkAllHat']),
    _removeItem(item) {
      this.removeHatGiaoPhan({
        action: 'removeHatGiaoPhan',
        item: item,
      })
    },
    _checkAllHat(event) {
      this.checkAllHat(event.target.checked)
    },
  },
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
