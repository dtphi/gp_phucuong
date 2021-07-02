<template>
  <div class="table-responsive">
    <table
      id="info-ban-chuyen-trach-list"
      class="table table-striped table-bordered table-hover"
    >
      <thead>
        <tr>
          <td style="width: 5%;" class="text-center">
            <input type="checkbox"
                    @click="_checkAllBanChuyenTrach">
          </td>
          <td style="width: 50%" class="text-left">Ban chuyên trách</td>
          <td style="width: 20%" class="text-left">Trình trạng</td>
          <td style="width: 30%" class="text-right">Thực hiện</td>
        </tr>
      </thead>
      <tbody v-for="(item, idx) in lists" :key="idx">
        <info-item v-if="item.isEdit" :item="item"></info-item>
        <info-new-item v-else :item="item"></info-new-item>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4" class="text-right">
            <btn-add-all v-show="lists.lenght"></btn-add-all>
            <btn-add></btn-add>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import { MODULE_MODULE_GIAO_PHAN_EDIT } from "store@admin/types/module-types";
import BtnAdd from "./BtnAdd";
import BtnAddAll from "./BtnAddAll";
import InfoItem from "./InfoItem";
import InfoNewItem from "./InfoNewItem";

export default {
  name: "TheInfoList",
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
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, ["checkAllBanChuyenTrach"]),
    _checkAllBanChuyenTrach (event) {
      this.checkAllBanChuyenTrach(event.target.checked)
    }
  },
  setting: {
    info_action_title: "Thực hiện",
  },
};
</script>
