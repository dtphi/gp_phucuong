<template>
  <div class="table-responsive">
    <table
      id="info-thuyen-chuyen-list"
      class="table table-striped table-bordered table-hover"
    >
      <thead>
        <tr>
          <td colspan="8" class="text-right">
            <btn-add></btn-add>
          </td>
        </tr>
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
          <td colspan="8" class="text-right">
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

export default {
  name: "TheInfoList",
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
    info_action_title: "Thực hiện"
  },
};
</script>
