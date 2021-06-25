<template>
  <div class="table-responsive">
    <table
      id="info-thuyen-chuyen-list"
      class="table table-striped table-bordered table-hover"
    >
      <thead>
        <tr>
          <td colspan="5" class="text-right">
            <btn-add></btn-add>
          </td>
        </tr>
        <tr>
          <td>Giáo xứ đến</td>
          <td>Ban chuyên trách</td>
          <td>Ngày đến</td>
          <td>Chức vụ đến</td>
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
