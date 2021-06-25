<template>
  <div class="table-responsive">
    <table
      class="table table-striped table-bordered table-hover"
      v-for="(item, idx) in lists"
      :key="idx"
    >
      <thead>
        <tr>
          <td colspan="3" class="text-center">Giáo Hạt : {{ item.hatName }}</td>
        </tr>
        <tr>
          <td class="text-left">Giáo xứ</td>
          <td class="text-left">Trình trạng</td>
          <td class="text-right">Thực hiện</td>
        </tr>
      </thead>
      <info-item
        v-for="(giaoXu, idx) in item.giao_xus"
        :hat="item"
        :item="giaoXu"
        :key="idx"
      ></info-item>
      <tfoot>
        <tr>
          <td></td>
          <td></td>
          <td class="text-right">
            <btn-add :giao-hat="item"></btn-add>
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
  }
};
</script>
