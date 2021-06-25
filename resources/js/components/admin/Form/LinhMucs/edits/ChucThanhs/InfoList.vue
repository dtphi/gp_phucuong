<template>
  <div class="table-responsive">
    <table
      id="info-chuc-thanh-list"
      class="table table-striped table-bordered table-hover"
    >
      <thead>
        <tr>
          <td class="text-left">Chức thánh</td>
          <td class="text-center">Ngày tháng</td>
          <td class="text-left">Nơi thụ phong</td>
          <td class="text-left">Người thụ phong</td>
          <td class="text-left">Ghi chú</td>
          <td class="text-left">Trình trang</td>
          <td calss="text-right">{{ $options.setting.info_action_title }}</td>
        </tr>
      </thead>
      <tbody v-for="(item, idx) in lists" :key="idx">
        <info-item v-if="item.isEdit" :item="item"></info-item>
        <info-new-item v-else :item="item"></info-new-item>
      </tbody>

      <tfoot>
        <tr>
          <td colspan="6"></td>
          <td class="text-right">
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
