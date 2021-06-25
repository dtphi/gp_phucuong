<template>
  <div class="table-responsive">
    <table
      class="table table-striped table-bordered table-hover"
      v-for="(item, idx) in lists"
      :key="idx"
    >
      <thead>
        <tr>
          <td colspan="3" class="text-center">Giáo Hat: {{ item.hatName }}</td>
        </tr>
        <tr>
          <td class="text-left">Công đoàn tu sĩ</td>
          <td class="text-left">Trình trạng</td>
          <td class="text-right">Thực hiện</td>
        </tr>
      </thead>
      <info-item
        v-for="(congDts, idx) in item.cong_doan_tu_sis"
        :hat="item"
        :item="congDts"
        :key="idx"
      ></info-item>
      <tfoot>
        <tr>
          <td colspan="3" class="text-right">
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
  },
  setting: {
    info_action_title: "Thực hiện"
  },
};
</script>
