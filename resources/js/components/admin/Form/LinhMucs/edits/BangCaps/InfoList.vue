<template>
  <div class="table-responsive">
    <table
      id="info-bang-cap-list"
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
          <th style="width: 5%;" class="text-center">
              <input type="checkbox"
                      onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
          </th>
          <td style="width: 35%" class="text-left">Tên bằng</td>
          <td style="width: 30%" class="text-left">Ghi chú</td>
          <td style="width: 10%" class="text-left">Loại</td>
          <td style="width: 10%" class="text-left">Tình trạng</td>
          <td style="width: 10%" class="text-right">
            {{ $options.setting.info_action_title }}
          </td>
        </tr>
      </thead>
      <tbody v-for="(item, idx) in lists" :key="idx">
        <info-item v-if="item.isEdit" :item="item"></info-item>
        <info-new-item v-else :item="item"></info-new-item>
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
import BtnAdd from "./BtnAdd";
import BtnAddSelect from "./BtnAddSelect";
import BtnRemoveSelect from "./BtnRemoveSelect";
import InfoItem from "./InfoItem";
import InfoNewItem from "./InfoNewItem";

export default {
  name: "TheInfoList",
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
  setting: {
    info_action_title: "Thực hiện"
  },
};
</script>
