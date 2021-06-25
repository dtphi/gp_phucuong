<template>
  <div class="table-responsive">
    <table
      id="info-bang-cap-list"
      class="table table-striped table-bordered table-hover"
    >
      <thead>
        <tr>
          <td style="width: 40%" class="text-left">Tên bằng</td>
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
          <td colspan="5" class="text-right">
            <btn-add></btn-add>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
import BtnAdd from "./BtnAdd";
import InfoItem from "./InfoItem";
import InfoNewItem from "./InfoNewItem";

export default {
  name: "TheInfoList",
  components: {
    BtnAdd,
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
