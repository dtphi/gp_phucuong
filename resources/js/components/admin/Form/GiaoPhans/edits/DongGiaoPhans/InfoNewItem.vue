<template>
  <tr>
    <td>
      <info-dong-autocomplete
        :dong="item"
        :key="item.id"
      ></info-dong-autocomplete>
    </td>
    <td>
      <select v-model="item.active" id="input-info-active" class="form-control">
        <option value="1" selected="selected">Xảy ra</option>
        <option value="0">Ẩn</option>
      </select>
    </td>
    <td class="text-right">
      <button
        v-show="isEdit"
        @click="_addDongForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật dòng"
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
import BtnAdd from "./BtnAdd";
import { MODULE_MODULE_GIAO_PHAN_EDIT } from "store@admin/types/module-types";
import InfoDongAutocomplete from "../Groups/InfoDongAutocomplete";

export default {
  name: "TheInfoNewItem",
  components: {
    BtnAdd,
    InfoDongAutocomplete,
  },
  props: {
    item: {
      default: {},
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, ["removeDongGiaoPhan"]),
    _removeItem() {
      this.removeDongGiaoPhan({
        action: "removeDongGiaoPhan",
        item: this.item,
      });
    },
    _addDongForm() {
      console.log("add dong", this.item);
    },
  },
  setting: {
    info_action_title: "Thực hiện",
  },
};
</script>
