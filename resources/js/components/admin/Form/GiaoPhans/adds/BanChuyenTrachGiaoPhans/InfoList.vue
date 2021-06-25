<template>
  <div class="table-responsive">
    <table
      id="info-ban-chuyen-trach-list"
      class="table table-striped table-bordered table-hover"
    >
      <thead>
        <tr>
          <td class="text-left">Ban chuyên trách</td>
          <td class="text-left">Trình trạng</td>
          <td class="text-right">Thực hiện</td>
        </tr>
      </thead>
      <info-item
        v-for="(item, idx) in lists"
        :key="idx"
        :item="item"
      ></info-item>
      <tfoot>
        <tr>
          <td colspan="3" class="text-right">
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
