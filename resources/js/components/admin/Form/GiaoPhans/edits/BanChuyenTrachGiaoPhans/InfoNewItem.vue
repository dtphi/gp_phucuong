<template>
  <tr>
    <td>
      <info-ban-chuyen-trach-autocomplete
        :ban-chuyen-trach="item"
        :key="item.id"
      ></info-ban-chuyen-trach-autocomplete>
    </td>
    <td>
      <select v-model="item.active" id="input-info-active" class="form-control">
        <option value="1" selected="selected">Xảy ra</option>
        <option value="0">Ẩn</option>
      </select>
    </td>
    <td class="text-right">
      <button
        @click="_addBanChuyenTrachForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật ban chuyên trách"
        class="btn btn-primary cms-btn"
      >
        <i class="fa fa-save"></i>
      </button>
      <button
        type="button"
        @click="_removeItem()"
        data-toggle="tooltip"
        class="btn btn-default cms-btn"
      >
        <font-awesome-layers size="1x" style="background: MistyRose">
          <font-awesome-icon icon="circle" style="color: Tomato" />
          <font-awesome-icon
            icon="times"
            class="fa-inverse"
            transform="shrink-4"
          />
        </font-awesome-layers>
      </button>
    </td>
  </tr>
</template>

<script>
import { mapActions } from "vuex";
import { MODULE_MODULE_GIAO_PHAN_EDIT } from "store@admin/types/module-types";
import InfoBanChuyenTrachAutocomplete from "../Groups/InfoBanChuyenTrachAutocomplete";

export default {
  name: "TheInfoNewItem",
  components: {
    InfoBanChuyenTrachAutocomplete,
  },
  props: {
    item: {
      default: {},
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, [
      "removeBanChuyenTrachGiaoPhan",
    ]),
    _removeItem() {
      this.removeBanChuyenTrachGiaoPhan({
        action: "removeBanChuyenTrachGiaoPhan",
        item: this.item,
      });
    },
    _addBanChuyenTrachForm() {
      console.log("add ban chuyen trach");
    },
  },
  setting: {
    info_action_title: "Thực hiện",
  },
};
</script>
