<template>
  <div class="table-responsive">
    <table
      class="table table-striped table-bordered table-hover"
      v-for="(item, idx) in lists"
      :key="idx"
    >
      <thead>
        <tr>
          <td colspan="5" class="text-center" :id="`link-giao-hat-${item.id}`">Giáo Hạt : {{ item.hatName }} : {{ Object.keys(item.giao_xus).length }} Giáo xứ</td>
        </tr>
        <tr>
          <td>TT</td>
          <td style="width: 5%;" class="text-center">
            <input type="checkbox"
                    onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
          </td>
          <td style="width: 50%" class="text-left">Giáo xứ</td>
          <td style="width: 20%" class="text-left">Trình trạng</td>
          <td style="width: 30%" class="text-right">Thực hiện</td>
        </tr>
      </thead>
      <tbody 
        v-for="(giaoXu, idx) in item.giao_xus" 
        :key="idx">
        <info-item 
          v-if="giaoXu.isEdit" 
          key="hat-xu-giao-phan-edit"
          :no="(idx + 1)"
          :hat="item" 
          :item="giaoXu"></info-item>
        <info-new-item 
          v-else 
          key="hat-xu-giao-phan-new"
          :hat="item" 
          :item="giaoXu"></info-new-item>
      </tbody>

      <tfoot>
        <tr>
          <td colspan="4" class="text-right">
            <btn-add-all 
              :giao-hat="item"  
              v-show="lists.lenght"></btn-add-all>
            <btn-add v-show="item.giao_hat_id" :giao-hat="item"></btn-add>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
import BtnAdd from './BtnAdd'
import BtnAddAll from './BtnAddAll'
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
}
</script>
